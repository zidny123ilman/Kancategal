<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created community review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'isi' => 'required|string|min:5',
        ], [
            'rating.required' => 'Rating bintang wajib dipilih.',
            'rating.integer' => 'Rating bintang tidak valid.',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'isi.required' => 'Isi ulasan wajib diisi.',
            'isi.min' => 'Ulasan terlalu singkat (minimal 5 karakter).',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'isi' => $request->isi,
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim!');
    }
}
