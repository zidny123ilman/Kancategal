<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1000|max:2100',
            'kategori' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'file_pdf' => 'nullable|file|mimes:pdf|max:51200',
            'sinopsis' => 'required|string',
            'jumlah_halaman' => 'required|integer|min:1',
            'status' => 'required|string|in:aktif,nonaktif',
        ];
    }
}
