<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

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
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
