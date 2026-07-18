<?php

namespace App\Http\Middleware;

use App\Models\EbookPeminjaman;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EbookAccess
{
    /**
     * Pastikan user memiliki pinjaman aktif (status Dipinjam & belum kadaluarsa)
     * untuk ebook yang diminta sebelum mengizinkan akses membaca/streaming PDF.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Wajib login
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk membaca E-Book.');
        }

        // 2. Ambil ebook id dari route parameter (bisa bernama 'id')
        $ebookId = $request->route('id');

        // 3. Cari peminjaman aktif milik user untuk ebook ini
        $peminjaman = EbookPeminjaman::where('user_id', Auth::id())
            ->where('ebook_id', $ebookId)
            ->where('status', 'Dipinjam')
            ->first();

        // 4. Tidak ada peminjaman aktif
        if (!$peminjaman) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Anda tidak memiliki izin membaca E-Book ini. Pastikan peminjaman Anda sudah disetujui.',
                ], 403);
            }
            return response()->view('errors.403-ebook', [
                'message' => 'Anda tidak memiliki izin membaca E-Book ini. Pastikan peminjaman sudah disetujui oleh admin.',
            ], 403);
        }

        // 5. Cek masa akses — jika kadaluarsa, update status & tolak
        if (Carbon::today()->greaterThan(Carbon::parse($peminjaman->tanggal_jatuh_tempo))) {
            $peminjaman->update(['status' => 'Kadaluarsa']);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Masa akses E-Book Anda telah berakhir.',
                ], 403);
            }
            return response()->view('errors.403-ebook', [
                'message' => 'Masa akses E-Book Anda telah berakhir. Silakan pinjam kembali jika ingin melanjutkan membaca.',
            ], 403);
        }

        // 6. Lolos semua pengecekan — injeksi peminjaman ke request agar controller bisa langsung pakai
        $request->merge(['_peminjaman' => $peminjaman]);

        return $next($request);
    }
}
