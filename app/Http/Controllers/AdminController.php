<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\AdminLog;
use App\Models\Artikel;
use App\Models\Ebook;
use App\Models\EbookPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display admin dashboard overview.
     */
    public function dashboard()
    {
        $totalCollection = Buku::count();
        $totalPeminjamanAktif = Peminjaman::where('status', 'aktif')->count();
        
        $today = Carbon::today()->toDateString();
        $terlambatKembali = Peminjaman::whereIn('status', ['aktif', 'pending_kembali'])
            ->where('tanggal_kembali', '<', $today)
            ->count();

        // 6-Month Monthly Trend for Chart
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        $monthlyLoans = Peminjaman::select(
                DB::raw("DATE_FORMAT(tanggal_pinjam, '%Y-%m') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->where('tanggal_pinjam', '>=', $sixMonthsAgo->toDateString())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('count', 'month')
            ->toArray();

        $chartLabels = [];
        $chartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            // Format to Indonesian month name or short month
            $chartLabels[] = $month->translatedFormat('F Y');
            $chartData[] = $monthlyLoans[$monthKey] ?? 0;
        }

        // Calculate Reading Interest Percentage
        // 1. Loan frequency score (max 40 points)
        $totalLoans = Peminjaman::count();
        $loanFrequencyScore = min(40, $totalLoans * 0.2);

        // 2. Average loan duration score (max 30 points)
        $avgDuration = Peminjaman::select(
                DB::raw("AVG(DATEDIFF(COALESCE(tanggal_dikembalikan, tanggal_kembali), tanggal_pinjam)) as avg_days")
            )->first()->avg_days ?? 7;
        $durationScore = min(30, $avgDuration * 3);

        // 3. User participation ratio (max 30 points)
        $totalUsers = User::count();
        $activeBorrowers = Peminjaman::distinct('user_id')->count('user_id');
        $userRatio = $totalUsers > 0 ? ($activeBorrowers / $totalUsers) : 0;
        $participationScore = $userRatio * 30;

        $readingInterest = min(100, max(0, round($loanFrequencyScore + $durationScore + $participationScore)));

        // Calculate total denda paid (status: selesai) and unpaid (status: aktif, pending_kembali)
        $allSelesaiLoans = Peminjaman::where('status', 'selesai')->get();
        $totalDendaTerbayar = $allSelesaiLoans->sum(function($loan) {
            return $loan->denda;
        });

        $allUnpaidLoans = Peminjaman::whereIn('status', ['aktif', 'pending_kembali'])->get();
        $totalDendaBelumTerbayar = $allUnpaidLoans->sum(function($loan) {
            return $loan->denda;
        });

        // E-Book Stats
        EbookPeminjaman::checkAndUpdateExpired();
        $totalEbooks = Ebook::count();
        $ebookSedangDipinjam = EbookPeminjaman::where('status', 'Dipinjam')->count();
        $ebookKadaluarsa = EbookPeminjaman::where('status', 'Kadaluarsa')->count();
        
        $mostBorrowedEbook = Ebook::withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->first();
        $mostBorrowedEbookText = $mostBorrowedEbook && $mostBorrowedEbook->peminjamans_count > 0 
            ? $mostBorrowedEbook->judul . ' (' . $mostBorrowedEbook->peminjamans_count . 'x)' 
            : '-';

        $highestRatedEbook = Ebook::select('ebooks.*')
            ->join('ebook_peminjaman', 'ebooks.id', '=', 'ebook_peminjaman.ebook_id')
            ->selectRaw('AVG(ebook_peminjaman.rating) as avg_rating')
            ->groupBy('ebooks.id', 'ebooks.judul', 'ebooks.slug', 'ebooks.penulis', 'ebooks.penerbit', 'ebooks.tahun_terbit', 'ebooks.kategori', 'ebooks.isbn', 'ebooks.sinopsis', 'ebooks.jumlah_halaman', 'ebooks.cover', 'ebooks.file_pdf', 'ebooks.status', 'ebooks.created_at', 'ebooks.updated_at')
            ->orderBy('avg_rating', 'desc')
            ->first();
        $highestRatedEbookText = $highestRatedEbook && $highestRatedEbook->avg_rating > 0 
            ? $highestRatedEbook->judul . ' (' . number_format($highestRatedEbook->avg_rating, 1) . ' ★)' 
            : '-';

        $totalEbookReaders = EbookPeminjaman::distinct('user_id')->count('user_id');
        $totalEbookReviews = EbookPeminjaman::whereNotNull('rating')->count();
        $avgEbookProgress = EbookPeminjaman::avg('progress_persen') ?? 0;

        return view('pages.admin.dashboard.index', compact(
            'totalCollection',
            'totalPeminjamanAktif',
            'terlambatKembali',
            'totalDendaTerbayar',
            'totalDendaBelumTerbayar',
            'chartLabels',
            'chartData',
            'readingInterest',
            'totalEbooks',
            'ebookSedangDipinjam',
            'ebookKadaluarsa',
            'mostBorrowedEbookText',
            'highestRatedEbookText',
            'totalEbookReaders',
            'totalEbookReviews',
            'avgEbookProgress'
        ));
    }

    /**
     * Display members list in admin panel.
     */
    public function memberIndex(Request $request)
    {
        $search = $request->query('q');
        $query = User::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('whatsapp', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }
        $members = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $totalMembers = User::count();
        $activeMembers = User::where('status', 'active')->count();
        
        $borrowEnabledCount = User::where('can_borrow', true)->count();
        $uploadEnabledCount = User::where('can_upload_artikel', true)->count();

        $borrowPercent = $totalMembers > 0 ? round(($borrowEnabledCount / $totalMembers) * 100) : 0;
        $uploadPercent = $totalMembers > 0 ? round(($uploadEnabledCount / $totalMembers) * 100) : 0;

        $logs = AdminLog::orderBy('created_at', 'desc')->take(4)->get();

        return view('pages.admin.member.index', compact(
            'members', 
            'totalMembers', 
            'activeMembers', 
            'borrowPercent', 
            'uploadPercent', 
            'logs'
        ));
    }

    /**
     * Show form to manually add a new member.
     */
    public function memberTambah()
    {
        return view('pages.admin.member.tambah');
    }

    /**
     * Store a manually created member.
     */
    public function memberStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:50|unique:users,whatsapp',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $member = User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password),
            'status' => 'active',
            'can_borrow' => true,
            'can_upload_artikel' => false,
        ]);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'MEMBER CREATED',
            'details' => 'Admin (' . $adminName . ') created member ' . $member->name,
        ]);

        return redirect('/admin/member')->with('success', 'Member baru berhasil ditambahkan!');
    }

    /**
     * Display detailed profile of a member.
     */
    public function memberDetail($id)
    {
        $member = User::findOrFail($id);
        return view('pages.admin.member.detail', compact('member'));
    }

    /**
     * Update the status of a member.
     */
    public function memberUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:active,suspended',
        ]);

        $member = User::findOrFail($id);
        $oldStatus = $member->status;
        $newStatus = $request->status;

        if ($oldStatus !== $newStatus) {
            $member->status = $newStatus;
            $member->save();

            // Log the action
            $adminName = session('admin_fullname', 'Admin');
            AdminLog::create([
                'action' => 'MEMBER STATUS CHANGED',
                'details' => 'Admin (' . $adminName . ') changed status of ' . $member->name . ' from ' . strtoupper($oldStatus) . ' to ' . strtoupper($newStatus),
            ]);
        }

        return redirect()->back()->with('success', 'Status member berhasil diperbarui menjadi ' . strtoupper($newStatus) . '.');
    }

    /**
     * Delete a member from the database.
     */
    public function memberDestroy($id)
    {
        $member = User::findOrFail($id);
        $memberName = $member->name;
        
        $member->delete();

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'MEMBER DELETED',
            'details' => 'Admin (' . $adminName . ') deleted member ' . $memberName,
        ]);

        return redirect('/admin/member')->with('success', 'Member ' . $memberName . ' berhasil dihapus.');
    }

    /**
     * Export member list as a CSV file.
     */
    public function exportCsv()
    {
        $members = User::orderBy('created_at', 'desc')->get();
        
        $csvFileName = 'members_export_' . Carbon::now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $csvFileName,
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $columns = ['ID', 'Nama', 'No WhatsApp', 'Alamat', 'Email', 'Status', 'Akses Pinjam', 'Akses Artikel', 'Tanggal Bergabung'];

        $callback = function() use($members, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($members as $member) {
                fputcsv($file, [
                    $member->id,
                    $member->name,
                    $member->whatsapp,
                    $member->alamat,
                    $member->email ?? '-',
                    strtoupper($member->status),
                    $member->can_borrow ? 'YA' : 'TIDAK',
                    $member->can_upload_artikel ? 'YA' : 'TIDAK',
                    $member->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'DATA EXPORT',
            'details' => 'Admin (' . $adminName . ') exported member list to CSV file ' . $csvFileName,
        ]);

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Toggle a member permission (borrow or upload article) via AJAX.
     */
    public function togglePermission(Request $request, $id)
    {
        $request->validate([
            'permission_type' => 'required|string|in:can_borrow,can_upload_artikel',
            'value' => 'required|integer|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $type = $request->permission_type;
        $user->$type = (bool) $request->value;
        $user->save();

        $actionLabel = $user->$type ? 'GRANTED' : 'REVOKED';
        $permLabel = $type === 'can_borrow' ? 'borrowing access' : 'article upload access';
        
        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'ACCESS ' . $actionLabel,
            'details' => 'Admin (' . $adminName . ') ' . ($user->$type ? 'enabled' : 'disabled') . ' ' . $permLabel . ' for ' . $user->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Hak akses ' . ($type === 'can_borrow' ? 'Peminjaman' : 'Upload Artikel') . ' untuk ' . $user->name . ' berhasil diperbarui.',
        ]);
    }

    /**
     * Global search for admin dashboard.
     */
    public function globalSearch(Request $request)
    {
        $search = $request->query('q');

        $books = [];
        $peminjamans = [];
        $members = [];
        $articles = [];

        if ($search) {
            $books = Buku::where('judul', 'like', '%' . $search . '%')
                ->orWhere('penulis', 'like', '%' . $search . '%')
                ->orWhere('kategori', 'like', '%' . $search . '%')
                ->orWhere('isbn', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->get();

            $peminjamans = Peminjaman::with(['user', 'buku'])
                ->where(function($q) use ($search) {
                    $q->whereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                                  ->orWhere('whatsapp', 'like', '%' . $search . '%');
                    })->orWhereHas('buku', function($bukuQuery) use ($search) {
                        $bukuQuery->where('judul', 'like', '%' . $search . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $members = User::where('name', 'like', '%' . $search . '%')
                ->orWhere('whatsapp', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->get();

            $articles = Artikel::where('judul', 'like', '%' . $search . '%')
                ->orWhere('nama_uploader', 'like', '%' . $search . '%')
                ->orWhere('kategori', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pages.admin.search.index', compact('search', 'books', 'peminjamans', 'members', 'articles'));
    }

    /**
     * Cetak laporan daftar member dalam format PDF.
     */
    public function cetak(Request $request)
    {
        $search = $request->query('q');
        $query = User::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('whatsapp', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }
        $members = $query->orderBy('created_at', 'desc')->get();

        // Base64 Logo
        $logoPath = public_path('images/logo_kanca_tegal.jpg');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $adminName = session('admin_fullname', \App\Models\Setting::get('admin_fullname', 'Admin'));
        
        $periode = 'Semua';
        if ($search) {
            $periode = 'Pencarian: "' . $search . '"';
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.admin.member.cetak', compact('members', 'logoBase64', 'adminName', 'periode'));
        return $pdf->stream('laporan_member_' . date('Ymd_His') . '.pdf');
    }
}
