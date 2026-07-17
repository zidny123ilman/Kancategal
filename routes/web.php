<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminKontenController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\AdminEbookController;

Route::get('/', [BukuController::class, 'landingPage']);
Route::get('/buku', [BukuController::class, 'userIndex']);
Route::get('/buku/{slug}', [BukuController::class, 'userDetail']);
Route::get('/detailbuku', function () {
    $firstBook = \App\Models\Buku::first();
    if ($firstBook) {
        return redirect('/buku/' . $firstBook->slug);
    }
    return redirect('/buku');
});

Route::get('/about', function () {
    $totalAnggotaAktif = \App\Models\User::where('status', 'active')->count();
    $totalBuku = \App\Models\Buku::count();
    return view('pages.about', compact('totalAnggotaAktif', 'totalBuku'));
});

Route::get('/artikel', [ArtikelController::class, 'publicIndex']);
Route::get('/upload-artikel', [ArtikelController::class, 'showUploadForm']);
Route::post('/upload-artikel', [ArtikelController::class, 'store']);
Route::post('/review', [ReviewController::class, 'store'])->middleware('auth');
Route::post('/peminjaman/pinjam/{bukuId}', [PeminjamanController::class, 'pinjam'])->middleware('auth');
Route::post('/peminjaman/kembalikan/{bukuId}', [PeminjamanController::class, 'kembalikan'])->middleware('auth');
Route::post('/buku/{id}/favorite', [BukuController::class, 'toggleFavorite'])->middleware('auth');
Route::post('/artikel/{id}/favorite', [ArtikelController::class, 'toggleFavorite'])->middleware('auth');

Route::get('/post/{slug}', [ArtikelController::class, 'publicDetail']);

Route::get('/kontak', function () {
    return view('pages.kontak');
});

Route::get('/register', function () {
    return view('pages.login-user.register');
});
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('pages.login-user.login');
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/lupa-sandi', [AuthController::class, 'showForgotPasswordForm']);
Route::post('/lupa-sandi', [AuthController::class, 'sendOtp']);
Route::get('/reset-sandi', [AuthController::class, 'showResetPasswordForm']);
Route::post('/reset-sandi', [AuthController::class, 'resetPassword']);

Route::get('/inisiator', function () {
    return view('pages.inisiator');
});

Route::get('/search', [BukuController::class, 'globalSearch']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/login');
    });

    Route::get('/login', function () {
        if (session()->has('admin_logged_in')) {
            return redirect('/admin/dashboard');
        }
        return view('pages.admin.auth.login-admin');
    });
    Route::post('/login', [AdminSettingController::class, 'login']);
    Route::get('/logout', [AdminSettingController::class, 'logout']);

    // Guarded admin routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/search', [AdminController::class, 'globalSearch']);
        
        Route::get('/buku', [BukuController::class, 'index']);
        Route::get('/buku/cetak', [BukuController::class, 'cetak']);
        Route::get('/buku/tambah', [BukuController::class, 'tambah']);
        Route::post('/buku/store', [BukuController::class, 'store']);
        Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
        Route::post('/buku/update/{id}', [BukuController::class, 'update']);
        Route::post('/buku/delete/{id}', [BukuController::class, 'destroy']);
        
        Route::get('/peminjaman', [PeminjamanController::class, 'adminIndex']);
        Route::get('/peminjaman/cetak', [PeminjamanController::class, 'cetak']);
        Route::get('/peminjaman/detail/{id}', [PeminjamanController::class, 'adminDetail']);
        Route::post('/peminjaman/{id}/setujui-pinjam', [PeminjamanController::class, 'setujuiPinjam']);
        Route::post('/peminjaman/{id}/tolak-pinjam', [PeminjamanController::class, 'tolakPinjam']);
        Route::post('/peminjaman/{id}/setujui-kembali', [PeminjamanController::class, 'setujuiKembali']);
        Route::post('/peminjaman/{id}/tolak-kembali', [PeminjamanController::class, 'tolakKembali']);
        Route::post('/peminjaman/{id}/kirim-peringatan', [PeminjamanController::class, 'kirimPeringatan']);
        Route::get('/peminjaman/export-excel', [PeminjamanController::class, 'exportPeminjamanExcel']);
        
        Route::get('/artikel', [ArtikelController::class, 'adminIndex']);
        Route::get('/artikel/detail/{id}', [ArtikelController::class, 'adminDetail']);
        Route::post('/artikel/{id}/approve', [ArtikelController::class, 'approve']);
        Route::post('/artikel/{id}/reject', [ArtikelController::class, 'reject']);
        Route::post('/artikel/{id}/delete', [ArtikelController::class, 'destroy']);
        
        Route::get('/member', [AdminController::class, 'memberIndex']);
        Route::get('/member/cetak', [AdminController::class, 'cetak']);
        Route::get('/member/tambah', [AdminController::class, 'memberTambah']);
        Route::post('/member/store', [AdminController::class, 'memberStore']);
        Route::get('/member/detail/{id}', [AdminController::class, 'memberDetail']);
        Route::post('/member/update-status/{id}', [AdminController::class, 'memberUpdateStatus']);
        Route::post('/member/delete/{id}', [AdminController::class, 'memberDestroy']);
        Route::get('/member/export-csv', [AdminController::class, 'exportCsv']);
        Route::post('/member/{id}/toggle-permission', [AdminController::class, 'togglePermission']);
        
        Route::get('/konten', [AdminKontenController::class, 'index']);
        Route::post('/konten/update', [AdminKontenController::class, 'update']);
        Route::get('/setting', [AdminSettingController::class, 'index']);
        Route::post('/setting/update', [AdminSettingController::class, 'update']);
        Route::post('/setting/clear-cache', [AdminSettingController::class, 'clearCache']);
        Route::get('/setting/backup', [AdminSettingController::class, 'downloadBackup']);

        // E-Book Admin Routes
        Route::get('/ebook', [AdminEbookController::class, 'index']);
        Route::get('/ebook/tambah', [AdminEbookController::class, 'create']);
        Route::post('/ebook/store', [AdminEbookController::class, 'store']);
        Route::get('/ebook/detail/{id}', [AdminEbookController::class, 'show']);
        Route::get('/ebook/edit/{id}', [AdminEbookController::class, 'edit']);
        Route::post('/ebook/update/{id}', [AdminEbookController::class, 'update']);
        Route::post('/ebook/delete/{id}', [AdminEbookController::class, 'destroy']);

        // E-Book Loan Management (Approval)
        Route::get('/ebook/peminjaman', [AdminEbookController::class, 'peminjamanIndex'])->name('admin.ebook.peminjaman');
        Route::post('/ebook/peminjaman/{id}/setujui', [AdminEbookController::class, 'setujuiPinjam'])->name('admin.ebook.setujui');
        Route::post('/ebook/peminjaman/{id}/tolak', [AdminEbookController::class, 'tolakPinjam'])->name('admin.ebook.tolak');
    });
});

// E-Book Public Routes
Route::get('/ebook', [EbookController::class, 'index'])->name('ebook.index');
// PENTING: Route statis (riwayat) harus didefinisikan SEBELUM route dinamis ({slug})
// agar tidak tertangkap sebagai slug parameter
Route::middleware('auth')->group(function () {
    Route::get('/ebook/riwayat', [EbookController::class, 'riwayat'])->name('ebook.riwayat');
    Route::post('/ebook/{id}/pinjam', [EbookController::class, 'pinjam'])->name('ebook.pinjam');
    Route::get('/ebook/{id}/read', [EbookController::class, 'read'])->name('ebook.read');
    Route::get('/ebook/{id}/pdf', [EbookController::class, 'streamPdf'])->name('ebook.pdf');
    Route::post('/ebook/{id}/update-progress', [EbookController::class, 'updateProgress'])->name('ebook.update-progress');
    Route::post('/ebook/peminjaman/{id}/review', [EbookController::class, 'review'])->name('ebook.review');
});
Route::get('/ebook/{slug}', [EbookController::class, 'show'])->name('ebook.show');

