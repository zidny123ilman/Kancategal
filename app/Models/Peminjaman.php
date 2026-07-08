<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'resensi_rating',
        'resensi_isi',
    ];

    /**
     * Get the user who borrowed the book.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Get the calculated fine (denda) for the loan.
     */
    public function getDendaAttribute()
    {
        if (in_array($this->status, ['pending_pinjam', 'ditolak', 'ditolak_pinjam'])) {
            return 0;
        }

        $tanggalKembali = \Carbon\Carbon::parse($this->tanggal_kembali);
        
        if ($this->status === 'selesai') {
            $tanggalSelesai = $this->tanggal_dikembalikan ? \Carbon\Carbon::parse($this->tanggal_dikembalikan) : \Carbon\Carbon::parse($this->updated_at);
        } else {
            $tanggalSelesai = \Carbon\Carbon::today();
        }

        if ($tanggalSelesai->greaterThan($tanggalKembali)) {
            $lateDays = $tanggalSelesai->diffInDays($tanggalKembali);
            $gracePeriod = (int) Setting::get('grace_period', 0);
            $lateFineRate = (int) Setting::get('late_fine_rate', 1000);

            if ($lateDays > $gracePeriod) {
                return ($lateDays - $gracePeriod) * $lateFineRate;
            }
        }

        return 0;
    }
}
