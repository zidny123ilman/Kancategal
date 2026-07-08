<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Setting;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of loans for admin.
     */
    public function adminIndex(Request $request)
    {
        // Global Stats (Unfiltered)
        $totalPeminjamanAktif = Peminjaman::where('status', 'aktif')->count();
        $menungguKonfirmasi = Peminjaman::whereIn('status', ['pending_pinjam', 'pending_kembali'])->count();
        
        $today = Carbon::today()->toDateString();
        $terlambatKembali = Peminjaman::where('status', 'aktif')
            ->where('tanggal_kembali', '<', $today)
            ->count();

        // Query with filters
        $query = Peminjaman::with(['user', 'buku']);

        // 1. Filter Type: peminjaman / pengembalian
        if ($request->filled('type')) {
            if ($request->type === 'peminjaman') {
                $query->whereIn('status', ['pending_pinjam', 'aktif']);
            } elseif ($request->type === 'pengembalian') {
                $query->whereIn('status', ['pending_kembali', 'selesai']);
            }
        }

        // 2. Filter Status: pending_pinjam, aktif, terlambat, pending_kembali, selesai
        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->where('status', 'aktif')
                      ->where('tanggal_kembali', '<', $today);
            } else {
                $query->where('status', $request->status);
            }
        }

        // 3. Filter Date: matches tanggal_pinjam
        if ($request->filled('date')) {
            $query->whereDate('tanggal_pinjam', $request->date);
        }

        // Calculate total denda paid (status: selesai) and unpaid (status: aktif, pending_kembali)
        $allSelesaiLoans = Peminjaman::where('status', 'selesai')->get();
        $totalDendaTerbayar = $allSelesaiLoans->sum(function($loan) {
            return $loan->denda;
        });

        $allUnpaidLoans = Peminjaman::whereIn('status', ['aktif', 'pending_kembali'])->get();
        $totalDendaBelumTerbayar = $allUnpaidLoans->sum(function($loan) {
            return $loan->denda;
        });

        $search = $request->query('q');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                              ->orWhere('whatsapp', 'like', '%' . $search . '%');
                })->orWhereHas('buku', function($bukuQuery) use ($search) {
                    $bukuQuery->where('judul', 'like', '%' . $search . '%')
                              ->orWhere('kategori', 'like', '%' . $search . '%');
                });
            });
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('pages.admin.peminjaman.index', compact(
            'peminjamans',
            'totalPeminjamanAktif',
            'menungguKonfirmasi',
            'terlambatKembali',
            'totalDendaTerbayar',
            'totalDendaBelumTerbayar'
        ));
    }

    /**
     * Approve borrowing request.
     */
    public function setujuiPinjam($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        if ($peminjaman->status !== 'pending_pinjam') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid untuk disetujui.');
        }

        // Check if book is already borrowed
        if ($peminjaman->buku->status === 'dipinjam') {
            return redirect()->back()->with('error', 'Buku ini sedang dipinjam oleh orang lain.');
        }

        // Update loan status to aktif
        $peminjaman->status = 'aktif';
        $peminjaman->save();

        // Update book status to dipinjam
        $peminjaman->buku->status = 'dipinjam';
        $peminjaman->buku->save();

        // Send WhatsApp confirmation notification
        $template = Setting::get('wa_template_borrow', 'Halo {name}, peminjaman buku {title} berhasil. Harap kembalikan sebelum {due_date}.');
        $dueDateFormatted = date('d-m-Y', strtotime($peminjaman->tanggal_kembali));
        $message = str_replace(
            ['{name}', '{title}', '{due_date}'],
            [$peminjaman->user->name, $peminjaman->buku->judul, $dueDateFormatted],
            $template
        );
        \App\Services\WhatsAppService::send($peminjaman->user->whatsapp, $message);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'LOAN APPROVED',
            'details' => 'Admin (' . $adminName . ') menyetujui peminjaman buku "' . $peminjaman->buku->judul . '" oleh member "' . $peminjaman->user->name . '"',
        ]);

        return redirect()->back()->with('success', 'Peminjaman buku berhasil disetujui.');
    }

    /**
     * Send WhatsApp overdue warning notification to user.
     */
    public function kirimPeringatan($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        if (!$peminjaman->user || !$peminjaman->buku) {
            return redirect()->back()->with('error', 'Data user atau buku tidak lengkap untuk mengirim notifikasi.');
        }

        $fine = $peminjaman->denda;
        $fineFormatted = 'Rp ' . number_format($fine, 0, ',', '.');

        // Fetch WhatsApp template from Settings
        $template = Setting::get('wa_template_overdue', 'Halo {name}, peminjaman buku {title} telah terlambat. Denda saat ini adalah {fine}. Harap segera kembalikan.');
        
        // Format message
        $formattedMessage = str_replace(
            ['{name}', '{title}', '{fine}'],
            [$peminjaman->user->name, $peminjaman->buku->judul, $fineFormatted],
            $template
        );

        $sent = \App\Services\WhatsAppService::send($peminjaman->user->whatsapp, $formattedMessage);

        if ($sent) {
            // Log the action
            $adminName = session('admin_fullname', 'Admin');
            AdminLog::create([
                'action' => 'OVERDUE REMINDER SENT',
                'details' => 'Admin (' . $adminName . ') mengirim peringatan terlambat WhatsApp ke member "' . $peminjaman->user->name . '" untuk buku "' . $peminjaman->buku->judul . '"',
            ]);
            return redirect()->back()->with('success', 'Peringatan keterlambatan WhatsApp berhasil dikirim ke nomor ' . $peminjaman->user->whatsapp);
        }

        return redirect()->back()->with('error', 'Gagal mengirim pesan WhatsApp. Pastikan token API gateway Fonnte sudah dikonfigurasi dengan benar.');
    }

    /**
     * Approve return request.
     */
    public function setujuiKembali($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        if ($peminjaman->status !== 'pending_kembali') {
            return redirect()->back()->with('error', 'Status pengembalian tidak valid untuk disetujui.');
        }

        // Update loan status to selesai
        $peminjaman->status = 'selesai';
        $peminjaman->tanggal_dikembalikan = Carbon::today()->toDateString();
        $peminjaman->save();

        // Update book status to ready
        $peminjaman->buku->status = 'ready';
        $peminjaman->buku->save();

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'RETURN APPROVED',
            'details' => 'Admin (' . $adminName . ') menyetujui pengembalian buku "' . $peminjaman->buku->judul . '" oleh member "' . $peminjaman->user->name . '"',
        ]);

        return redirect()->back()->with('success', 'Pengembalian buku berhasil disetujui.');
    }

    /**
     * Reject borrowing request.
     */
    public function tolakPinjam($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        if ($peminjaman->status !== 'pending_pinjam') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid untuk ditolak.');
        }

        // Update loan status to ditolak
        $peminjaman->status = 'ditolak';
        $peminjaman->save();

        // Keep/update book status to ready
        $peminjaman->buku->status = 'ready';
        $peminjaman->buku->save();

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'LOAN REJECTED',
            'details' => 'Admin (' . $adminName . ') menolak peminjaman buku "' . $peminjaman->buku->judul . '" oleh member "' . $peminjaman->user->name . '"',
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil ditolak.');
    }

    /**
     * Reject return request.
     */
    public function tolakKembali($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        if ($peminjaman->status !== 'pending_kembali') {
            return redirect()->back()->with('error', 'Status pengembalian tidak valid untuk ditolak.');
        }

        // Revert status to aktif (since return is rejected, borrowing is active again)
        $peminjaman->status = 'aktif';
        $peminjaman->save();

        // Book status remains dipinjam
        $peminjaman->buku->status = 'dipinjam';
        $peminjaman->buku->save();

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'RETURN REJECTED',
            'details' => 'Admin (' . $adminName . ') menolak pengembalian buku "' . $peminjaman->buku->judul . '" oleh member "' . $peminjaman->user->name . '"',
        ]);

        return redirect()->back()->with('success', 'Permintaan pengembalian ditolak. Status sirkulasi dikembalikan menjadi aktif.');
    }

    /**
     * Display borrowing detail with user details.
     */
    public function adminDetail($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        // Fetch other loans by the same user (excluding current) for history
        $userLoans = Peminjaman::with('buku')
            ->where('user_id', $peminjaman->user_id)
            ->where('id', '!=', $peminjaman->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin.peminjaman.detail', compact('peminjaman', 'userLoans'));
    }

    /**
     * Export filtered list of loans to Excel.
     */
    public function exportPeminjamanExcel(Request $request)
    {
        $today = Carbon::today()->toDateString();
        
        // Apply the same filters
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('type')) {
            if ($request->type === 'peminjaman') {
                $query->whereIn('status', ['pending_pinjam', 'aktif']);
            } elseif ($request->type === 'pengembalian') {
                $query->whereIn('status', ['pending_kembali', 'selesai']);
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->where('status', 'aktif')
                      ->where('tanggal_kembali', '<', $today);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('date')) {
            $query->whereDate('tanggal_pinjam', $request->date);
        }

        $loans = $query->orderBy('created_at', 'desc')->get();
        $fileName = 'laporan_peminjaman_' . date('Ymd_His') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ];

        $callback = function() use ($loans) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="utf-8"></head>';
            echo '<body>';
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Nama Peminjam</th>';
            echo '<th>No WhatsApp</th>';
            echo '<th>Judul Buku</th>';
            echo '<th>Kategori/Genre</th>';
            echo '<th>Tanggal Pinjam</th>';
            echo '<th>Masa Pengembalian</th>';
            echo '<th>Tanggal Dikembalikan</th>';
            echo '<th>Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($loans as $loan) {
                echo '<tr>';
                echo '<td>#TX-' . str_pad($loan->id, 4, '0', STR_PAD_LEFT) . '</td>';
                echo '<td>' . ($loan->user->name ?? '-') . '</td>';
                echo '<td>' . ($loan->user->whatsapp ?? '-') . '</td>';
                echo '<td>' . ($loan->buku->judul ?? '-') . '</td>';
                echo '<td>' . ($loan->buku->kategori ?? '-') . '</td>';
                echo '<td>' . ($loan->tanggal_pinjam ? date('d-m-Y', strtotime($loan->tanggal_pinjam)) : '-') . '</td>';
                echo '<td>' . ($loan->tanggal_kembali ? date('d-m-Y', strtotime($loan->tanggal_kembali)) : '-') . '</td>';
                echo '<td>' . ($loan->tanggal_dikembalikan ? date('d-m-Y', strtotime($loan->tanggal_dikembalikan)) : '-') . '</td>';
                echo '<td>' . strtoupper($loan->status) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</body>';
            echo '</html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * User request to borrow a book.
     */
    public function pinjam($bukuId)
    {
        $user = Auth::user();

        // 1. Check user status
        if ($user->status !== 'active') {
            return redirect()->back()->with('error', 'Akun Anda sedang ditangguhkan atau tidak aktif. Silakan hubungi admin.');
        }

        // 2. Check if user is allowed to borrow
        if (!$user->can_borrow) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk meminjam buku. Silakan hubungi admin.');
        }

        // 3. Find book and check availability
        $book = Buku::findOrFail($bukuId);
        if ($book->status !== 'ready') {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // 4. Check borrowing limit
        $activeLoansCount = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['pending_pinjam', 'aktif', 'pending_kembali'])
            ->count();
        
        $limit = (int) Setting::get('loan_limit', 3);
        if ($activeLoansCount >= $limit) {
            return redirect()->back()->with('error', 'Batas peminjaman Anda sudah mencapai limit (' . $limit . ' buku) sesuai aturan Kanca Tegal!');
        }

        // 5. Create loan record
        $loanDuration = (int) Setting::get('loan_duration', 7);
        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $book->id,
            'tanggal_pinjam' => Carbon::today()->toDateString(),
            'tanggal_kembali' => Carbon::today()->addDays($loanDuration)->toDateString(),
            'status' => 'pending_pinjam',
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    /**
     * User request to return a book.
     */
    public function kembalikan(Request $request, $bukuId)
    {
        $user = Auth::user();

        // Find the active loan for this user and book
        $peminjaman = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $bukuId)
            ->where('status', 'aktif')
            ->firstOrFail();

        // Set status to pending_kembali
        $peminjaman->status = 'pending_kembali';

        // Save review if provided
        if ($request->filled('rating')) {
            $peminjaman->resensi_rating = (int) $request->rating;
        }
        if ($request->filled('ulasan')) {
            $peminjaman->resensi_isi = $request->ulasan;
        }

        $peminjaman->save();

        return redirect()->back()->with('success', 'Permintaan pengembalian berhasil diajukan. Silakan kembalikan buku ke perpustakaan untuk diverifikasi admin.');
    }
}
