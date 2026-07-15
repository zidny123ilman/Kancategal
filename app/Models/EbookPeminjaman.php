<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'ebook_peminjaman';

    protected $fillable = [
        'user_id',
        'ebook_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_selesai',
        'status', // Menunggu, Dipinjam, Ditolak, Selesai, Kadaluarsa
        'last_page',
        'progress_persen',
        'rating',
        'review',
        'review_at',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_selesai' => 'date',
        'review_at' => 'datetime',
    ];

    /**
     * Get the user who borrowed the ebook.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the ebook that was borrowed.
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebook_id');
    }

    /**
     * Check and update expired ebook loans.
     */
    public static function checkAndUpdateExpired()
    {
        self::where('status', 'Dipinjam')
            ->where('tanggal_jatuh_tempo', '<', \Carbon\Carbon::today()->toDateString())
            ->update(['status' => 'Kadaluarsa']);
    }

    /**
     * Get the duration label for display.
     */
    public function getDurationDaysAttribute(): int
    {
        if ($this->tanggal_pinjam && $this->tanggal_jatuh_tempo) {
            return $this->tanggal_pinjam->diffInDays($this->tanggal_jatuh_tempo);
        }
        return (int) \App\Models\Setting::get('ebook_loan_duration', 7);
    }
}
