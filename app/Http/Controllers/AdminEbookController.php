<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookPeminjaman;
use App\Http\Requests\StoreEbookRequest;
use App\Http\Requests\UpdateEbookRequest;
use App\Models\AdminLog;
use App\Models\Setting;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminEbookController extends Controller
{
    /**
     * Manage ebook loan requests (Menunggu, Dipinjam, etc.)
     */
    public function peminjamanIndex(Request $request)
    {
        $status = $request->query('status', 'Menunggu');
        $search = $request->query('q');

        $query = EbookPeminjaman::with(['user', 'ebook'])
            ->orderBy('created_at', 'desc');

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('ebook', function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            });
        }

        $peminjamans  = $query->paginate(15)->withQueryString();
        $totalMenunggu = EbookPeminjaman::where('status', 'Menunggu')->count();

        return view('pages.admin.ebook.peminjaman', compact('peminjamans', 'status', 'totalMenunggu'));
    }

    /**
     * Approve an ebook loan request.
     */
    public function setujuiPinjam(Request $request, $id)
    {
        $peminjaman = EbookPeminjaman::with(['user', 'ebook'])->findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        // Recalculate due date from today (admin approved today)
        $loanDuration = (int) Setting::get('ebook_loan_duration', 7);
        $tanggalPinjam = Carbon::today();
        $tanggalJatuhTempo = Carbon::today()->addDays($loanDuration);

        $peminjaman->status              = 'Dipinjam';
        $peminjaman->tanggal_pinjam      = $tanggalPinjam->toDateString();
        $peminjaman->tanggal_jatuh_tempo = $tanggalJatuhTempo->toDateString();
        $peminjaman->catatan_admin       = $request->input('catatan_admin');
        $peminjaman->save();

        // Notify user via WhatsApp
        $user  = $peminjaman->user;
        $ebook = $peminjaman->ebook;
        $dueDateFormatted = $tanggalJatuhTempo->format('d-m-Y');
        $message = "Halo {$user->name}\nPeminjaman E-Book Anda telah DISETUJUI.\nJudul:\n{$ebook->judul}\nMasa akses:\n{$loanDuration} Hari\nBerlaku hingga:\n{$dueDateFormatted}\nSelamat membaca!";
        WhatsAppService::send($user->whatsapp, $message);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action'  => 'EBOOK LOAN APPROVED',
            'details' => 'Admin (' . $adminName . ') menyetujui peminjaman E-Book "' . $ebook->judul . '" oleh ' . $user->name,
        ]);

        return redirect()->back()->with('success', 'Peminjaman E-Book berhasil disetujui. Notifikasi dikirim ke member.');
    }

    /**
     * Reject an ebook loan request.
     */
    public function tolakPinjam(Request $request, $id)
    {
        $peminjaman = EbookPeminjaman::with(['user', 'ebook'])->findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $peminjaman->status        = 'Ditolak';
        $peminjaman->catatan_admin = $request->input('catatan_admin', 'Ditolak oleh admin.');
        $peminjaman->save();

        // Notify user via WhatsApp
        $user  = $peminjaman->user;
        $ebook = $peminjaman->ebook;
        $catatan = $peminjaman->catatan_admin;
        $message = "Halo {$user->name}\nMaaf, peminjaman E-Book Anda DITOLAK.\nJudul:\n{$ebook->judul}\nAlasan:\n{$catatan}\nSilakan hubungi admin untuk informasi lebih lanjut.";
        WhatsAppService::send($user->whatsapp, $message);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action'  => 'EBOOK LOAN REJECTED',
            'details' => 'Admin (' . $adminName . ') menolak peminjaman E-Book "' . $ebook->judul . '" oleh ' . $user->name,
        ]);

        return redirect()->back()->with('success', 'Permintaan peminjaman E-Book berhasil ditolak.');
    }

    /**
     * Display a listing of Ebooks for admin.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $query = Ebook::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $ebooks = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $totalEbooks = Ebook::count();

        return view('pages.admin.ebook.index', compact('ebooks', 'totalEbooks'));
    }

    /**
     * Show the form for creating a new Ebook.
     */
    public function create()
    {
        // Get categories for dropdown suggestions
        $categories = Ebook::select('kategori')->distinct()->whereNotNull('kategori')->pluck('kategori')->toArray();
        $defaultCategories = ['BUDAYA', 'SEJARAH', 'SASTRA', 'TEKNOLOGI', 'SENI', 'POLITIK', 'FILOSOFI', 'SOSIOLOGI'];
        $categories = array_unique(array_merge($defaultCategories, array_map('strtoupper', $categories)));
        sort($categories);

        return view('pages.admin.ebook.tambah', compact('categories'));
    }

    /**
     * Store a newly created Ebook in storage.
     */
    public function store(StoreEbookRequest $request)
    {
        $data = $request->validated();

        // Handle category input
        if (strtoupper($data['kategori']) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $data['kategori'] = strtoupper(trim($request->input('kategori_baru')));
        } else {
            $data['kategori'] = strtoupper($data['kategori']);
        }

        // Handle cover file upload — tetap di storage public lokal
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('ebook-cover', 'public');
        }

        // Handle pdf file upload — disimpan ke Backblaze B2
        if ($request->hasFile('file_pdf')) {
            $pdfFile = $request->file('file_pdf');
            $pdfKey  = 'ebooks/' . uniqid('', true) . '_' . $pdfFile->getClientOriginalName();
            Storage::disk('b2')->putFileAs('', $pdfFile, $pdfKey);
            $data['file_pdf'] = $pdfKey;
        }

        // Generate slug
        $data['slug'] = Str::slug($data['judul']);

        $ebook = Ebook::create($data);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'EBOOK CREATED',
            'details' => 'Admin (' . $adminName . ') uploaded E-Book "' . $ebook->judul . '"',
        ]);

        return redirect('/admin/ebook')->with('success', 'E-Book baru berhasil diunggah!');
    }

    /**
     * Display the specified Ebook.
     */
    public function show($id)
    {
        $ebook = Ebook::findOrFail($id);

        // Fetch stats
        $totalBorrowed = EbookPeminjaman::where('ebook_id', $id)->count();
        $totalReaders = EbookPeminjaman::where('ebook_id', $id)->distinct('user_id')->count('user_id');
        $averageRating = EbookPeminjaman::where('ebook_id', $id)->whereNotNull('rating')->avg('rating') ?? 0;
        $totalReviews = EbookPeminjaman::where('ebook_id', $id)->whereNotNull('rating')->count();
        $averageProgress = EbookPeminjaman::where('ebook_id', $id)->avg('progress_persen') ?? 0;

        return view('pages.admin.ebook.detail', compact(
            'ebook',
            'totalBorrowed',
            'totalReaders',
            'averageRating',
            'totalReviews',
            'averageProgress'
        ));
    }

    /**
     * Show the form for editing the specified Ebook.
     */
    public function edit($id)
    {
        $ebook = Ebook::findOrFail($id);
        
        $categories = Ebook::select('kategori')->distinct()->whereNotNull('kategori')->pluck('kategori')->toArray();
        $defaultCategories = ['BUDAYA', 'SEJARAH', 'SASTRA', 'TEKNOLOGI', 'SENI', 'POLITIK', 'FILOSOFI', 'SOSIOLOGI'];
        $categories = array_unique(array_merge($defaultCategories, array_map('strtoupper', $categories)));
        sort($categories);

        return view('pages.admin.ebook.edit', compact('ebook', 'categories'));
    }

    /**
     * Update the specified Ebook in storage.
     */
    public function update(UpdateEbookRequest $request, $id)
    {
        $ebook = Ebook::findOrFail($id);
        $data = $request->validated();

        // Handle category input
        if (strtoupper($data['kategori']) === 'LAINNYA' && $request->filled('kategori_baru')) {
            $data['kategori'] = strtoupper(trim($request->input('kategori_baru')));
        } else {
            $data['kategori'] = strtoupper($data['kategori']);
        }

        // Handle cover update — tetap di storage public lokal
        if ($request->hasFile('cover')) {
            if ($ebook->cover) {
                Storage::disk('public')->delete($ebook->cover);
            }
            $data['cover'] = $request->file('cover')->store('ebook-cover', 'public');
        }

        // Handle pdf update — upload baru ke B2, hapus lama dari B2
        if ($request->hasFile('file_pdf')) {
            if ($ebook->file_pdf) {
                Storage::disk('b2')->delete($ebook->file_pdf);
            }
            $pdfFile = $request->file('file_pdf');
            $pdfKey  = 'ebooks/' . uniqid('', true) . '_' . $pdfFile->getClientOriginalName();
            Storage::disk('b2')->putFileAs('', $pdfFile, $pdfKey);
            $data['file_pdf'] = $pdfKey;
        }

        $ebook->update($data);

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'EBOOK UPDATED',
            'details' => 'Admin (' . $adminName . ') updated E-Book "' . $ebook->judul . '"',
        ]);

        return redirect('/admin/ebook')->with('success', 'E-Book berhasil diperbarui!');
    }

    /**
     * Remove the specified Ebook from storage.
     */
    public function destroy($id)
    {
        $ebook = Ebook::findOrFail($id);
        $title = $ebook->judul;

        // Hapus cover dari storage public lokal
        if ($ebook->cover) {
            Storage::disk('public')->delete($ebook->cover);
        }
        // Hapus PDF dari Backblaze B2
        if ($ebook->file_pdf) {
            Storage::disk('b2')->delete($ebook->file_pdf);
        }

        $ebook->delete();

        // Log the action
        $adminName = session('admin_fullname', 'Admin');
        AdminLog::create([
            'action' => 'EBOOK DELETED',
            'details' => 'Admin (' . $adminName . ') deleted E-Book "' . $title . '"',
        ]);

        return redirect('/admin/ebook')->with('success', 'E-Book berhasil dihapus!');
    }
}
