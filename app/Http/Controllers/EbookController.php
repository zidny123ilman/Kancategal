<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookPeminjaman;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    /**
     * Display a listing of Ebooks for public/users.
     */
    public function index(Request $request)
    {
        // Run expiry checks
        EbookPeminjaman::checkAndUpdateExpired();

        $search = $request->query('q');
        $kategori = $request->query('kategori');
        $penulis = $request->query('penulis');
        $tahun = $request->query('tahun_terbit');

        $query = Ebook::where('status', 'aktif');

        // Apply Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Apply Filters
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        if ($penulis) {
            $query->where('penulis', $penulis);
        }
        if ($tahun) {
            $query->where('tahun_terbit', $tahun);
        }

        $ebooks = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        // Get filter options from active ebooks
        $categories = Ebook::where('status', 'aktif')->select('kategori')->distinct()->pluck('kategori')->toArray();
        $authors = Ebook::where('status', 'aktif')->select('penulis')->distinct()->pluck('penulis')->toArray();
        $years = Ebook::where('status', 'aktif')->select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->pluck('tahun_terbit')->toArray();

        return view('pages.ebook.index', compact('ebooks', 'categories', 'authors', 'years', 'kategori', 'penulis', 'tahun', 'search'));
    }

    /**
     * Display the specified Ebook detail page for users.
     */
    public function show($id)
    {
        // Run expiry checks
        EbookPeminjaman::checkAndUpdateExpired();

        $ebook = Ebook::where('status', 'aktif')->findOrFail($id);

        // Fetch Stats
        $totalBorrowed = EbookPeminjaman::where('ebook_id', $id)->count();
        $totalReaders = EbookPeminjaman::where('ebook_id', $id)->distinct('user_id')->count('user_id');
        $averageRating = EbookPeminjaman::where('ebook_id', $id)->whereNotNull('rating')->avg('rating') ?? 0;
        $totalReviews = EbookPeminjaman::where('ebook_id', $id)->whereNotNull('rating')->count();
        $averageProgress = EbookPeminjaman::where('ebook_id', $id)->avg('progress_persen') ?? 0;

        $reviews = EbookPeminjaman::with('user')
            ->where('ebook_id', $id)
            ->whereNotNull('rating')
            ->orderBy('review_at', 'desc')
            ->get();

        // Check active loan status for logged in user
        $activeLoan = null;
        $pendingLoan = null;
        if (Auth::check()) {
            $activeLoan = EbookPeminjaman::where('user_id', Auth::id())
                ->where('ebook_id', $id)
                ->where('status', 'Dipinjam')
                ->first();
            if (!$activeLoan) {
                $pendingLoan = EbookPeminjaman::where('user_id', Auth::id())
                    ->where('ebook_id', $id)
                    ->where('status', 'Menunggu')
                    ->first();
            }
        }

        return view('pages.ebook.detail', compact(
            'ebook',
            'totalBorrowed',
            'totalReaders',
            'averageRating',
            'totalReviews',
            'averageProgress',
            'reviews',
            'activeLoan',
            'pendingLoan'
        ));
    }

    /**
     * Handle user request to borrow an ebook.
     */
    public function pinjam($id)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk meminjam E-Book.');
        }

        $user = Auth::user();

        // Check if user status is suspended or inactive
        if ($user->status !== 'active') {
            return redirect()->back()->with('error', 'Akun Anda sedang ditangguhkan. Hubungi admin.');
        }

        $ebook = Ebook::where('status', 'aktif')->findOrFail($id);

        // Check if there is already an active or pending loan for the same ebook
        $existingActive = EbookPeminjaman::where('user_id', $user->id)
            ->where('ebook_id', $ebook->id)
            ->whereIn('status', ['Dipinjam', 'Menunggu'])
            ->first();

        if ($existingActive) {
            if ($existingActive->status === 'Menunggu') {
                return redirect()->back()->with('error', 'Permintaan peminjaman E-Book ini sedang menunggu konfirmasi admin.');
            }
            return redirect()->back()->with('error', 'Anda sudah meminjam E-Book ini dan masa aktifnya masih berlaku.');
        }

        // Get loan duration from settings (default 7 days)
        $loanDuration = (int) \App\Models\Setting::get('ebook_loan_duration', 7);

        // Create transaction with Menunggu status (waiting for admin approval)
        $tanggalPinjam = Carbon::today();
        $tanggalJatuhTempo = Carbon::today()->addDays($loanDuration);

        $peminjaman = EbookPeminjaman::create([
            'user_id'             => $user->id,
            'ebook_id'            => $ebook->id,
            'tanggal_pinjam'      => $tanggalPinjam->toDateString(),
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo->toDateString(),
            'status'              => 'Menunggu',
            'last_page'           => 1,
            'progress_persen'     => 0,
        ]);

        // Send WhatsApp notification to user
        $dueDateFormatted = $tanggalJatuhTempo->format('d-m-Y');
        $message = "Halo {$user->name}\nPermintaan peminjaman E-Book diterima.\nJudul:\n{$ebook->judul}\nDurasi pinjam:\n{$loanDuration} Hari\nEstimasi berakhir:\n{$dueDateFormatted}\nMohon tunggu konfirmasi dari admin.";
        WhatsAppService::send($user->whatsapp, $message);

        return redirect()->back()->with('success', 'Permintaan peminjaman E-Book berhasil dikirim. Silakan tunggu konfirmasi dari admin.');
    }

    /**
     * Serve the secure PDF viewer.
     */
    public function read($id)
    {
        // Run expiry checks
        EbookPeminjaman::checkAndUpdateExpired();

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $ebook = Ebook::findOrFail($id);

        // Check active loan
        $peminjaman = EbookPeminjaman::where('user_id', $user->id)
            ->where('ebook_id', $id)
            ->where('status', 'Dipinjam')
            ->first();

        if (!$peminjaman) {
            return redirect()->route('ebook.show', $id)->with('error', 'Anda tidak memiliki akses aktif untuk membaca E-Book ini. Silakan pinjam terlebih dahulu.');
        }

        // Double check expiration dates just in case
        if (Carbon::today()->greaterThan(Carbon::parse($peminjaman->tanggal_jatuh_tempo))) {
            $peminjaman->status = 'Kadaluarsa';
            $peminjaman->save();
            return redirect()->route('ebook.show', $id)->with('error', 'Akses E-Book Anda telah kadaluarsa.');
        }

        return view('pages.ebook.viewer', compact('ebook', 'peminjaman'));
    }

    /**
     * Stream the secure PDF file to the browser.
     */
    public function streamPdf($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        $ebook = Ebook::findOrFail($id);

        // Check if there is an active loan
        $peminjaman = EbookPeminjaman::where('user_id', $user->id)
            ->where('ebook_id', $id)
            ->where('status', 'Dipinjam')
            ->first();

        if (!$peminjaman) {
            return response()->json(['error' => 'Anda tidak memiliki hak akses untuk membaca E-Book ini.'], 403);
        }

        if (Carbon::today()->greaterThan(Carbon::parse($peminjaman->tanggal_jatuh_tempo))) {
            $peminjaman->status = 'Kadaluarsa';
            $peminjaman->save();
            return response()->json(['error' => 'Masa akses E-Book Anda telah berakhir.'], 403);
        }

        // Resolve file path using the 'public' disk
        $storedPath = $ebook->file_pdf;
        $disk = Storage::disk('public');

        // Try stored path as-is, then fallback to just the basename inside ebooks/
        if ($disk->exists($storedPath)) {
            $resolvedPath = $storedPath;
        } elseif ($disk->exists('ebooks/' . basename($storedPath))) {
            $resolvedPath = 'ebooks/' . basename($storedPath);
        } else {
            return response()->json([
                'error' => 'File E-Book tidak ditemukan di server. Silakan hubungi admin.'
            ], 404);
        }

        $fileContent = $disk->get($resolvedPath);
        return response($fileContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($storedPath) . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * AJAX route to update reading progress.
     */
    public function updateProgress(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'last_page' => 'required|integer|min:1',
            'progress_persen' => 'required|integer|min:0|max:100',
        ]);

        $user = Auth::user();

        $peminjaman = EbookPeminjaman::where('user_id', $user->id)
            ->where('ebook_id', $id)
            ->where('status', 'Dipinjam')
            ->first();

        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'No active loan found.'], 403);
        }

        $peminjaman->last_page = $request->last_page;
        $peminjaman->progress_persen = $request->progress_persen;

        // If progress is 100%, we don't automatically complete it unless the user requests/finishes it,
        // but let's just save it. Status stays "Dipinjam" so they can continue reading it until the 7 days are up.
        $peminjaman->save();

        return response()->json(['success' => true]);
    }

    /**
     * User's ebook loan history.
     */
    public function riwayat()
    {
        // Run expiry checks
        EbookPeminjaman::checkAndUpdateExpired();

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $history = EbookPeminjaman::with('ebook')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.ebook.riwayat', compact('history'));
    }

    /**
     * Submit rating and review for an ebook loan.
     */
    public function review(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $peminjaman = EbookPeminjaman::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // User can only review if status is Selesai or Kadaluarsa
        if ($peminjaman->status === 'Dipinjam') {
            // Wait, what if the user completes reading early and wants to return/review?
            // "Ketika status sudah Selesai atau Kadaluarsa dan rating masih kosong -> Beri Rating"
            // Let's allow completing/reviewing, or if they submit review we can also mark it as Selesai!
            $peminjaman->status = 'Selesai';
            $peminjaman->tanggal_selesai = Carbon::today()->toDateString();
        }

        if ($peminjaman->rating !== null) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk transaksi peminjaman ini.');
        }

        $peminjaman->rating = $request->rating;
        $peminjaman->review = $request->review;
        $peminjaman->review_at = Carbon::now();
        $peminjaman->save();

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
