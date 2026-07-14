<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ebook extends Model
{
    use HasFactory;

    protected $table = 'ebooks';

    protected $fillable = [
        'judul',
        'slug',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'isbn',
        'sinopsis',
        'jumlah_halaman',
        'cover',
        'file_pdf',
        'status',
    ];

    /**
     * Boot the model to automatically generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ebook) {
            $ebook->slug = Str::slug($ebook->judul);
        });

        static::updating(function ($ebook) {
            $ebook->slug = Str::slug($ebook->judul);
        });
    }

    /**
     * Get the loans for the ebook.
     */
    public function peminjamans()
    {
        return $this->hasMany(EbookPeminjaman::class, 'ebook_id');
    }
}
