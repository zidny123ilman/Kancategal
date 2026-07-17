<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Buku extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'bukus';

    protected $fillable = [
        'foto',
        'judul',
        'penulis',
        'penerbit',
        'jumlah_halaman',
        'sinopsis',
        'bahasa',
        'kategori',
        'isbn',
        'tentang_penulis',
        'status',
        'status_publish',
        'slug',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('judul')
            ->saveSlugsTo('slug');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}
