<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    protected $fillable = [
        'judul',
        'nama_uploader',
        'user_id',
        'tanggal_upload',
        'foto_utama',
        'isi',
        'foto_pendukung',
        'kategori',
        'status',
        'keywords',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'artikel_favorites', 'artikel_id', 'user_id')->withTimestamps();
    }
}
