<?php

namespace Database\Seeders;

use App\Models\Ebook;
use App\Models\EbookPeminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Ebooks
        $ebook1 = Ebook::create([
            'judul' => 'Sejarah Lengkap Tegal',
            'slug' => Str::slug('Sejarah Lengkap Tegal'),
            'penulis' => 'Ki Gede Sebayu',
            'penerbit' => 'Pustaka Pesisir',
            'tahun_terbit' => 2021,
            'kategori' => 'Sejarah',
            'isbn' => '978-602-8123-45-6',
            'jumlah_halaman' => 120,
            'sinopsis' => 'Buku ini mengupas sejarah awal berdirinya Tegal sejak masa kepemimpinan Ki Gede Sebayu hingga era kolonial Belanda. Sangat cocok bagi pembaca yang ingin memahami perkembangan kultural masyarakat pantura.',
            'cover' => 'ebook-cover/sejarah_tegal_cover.png',
            'file_pdf' => 'ebooks/test_ebook.pdf',
            'status' => 'aktif',
        ]);

        $ebook2 = Ebook::create([
            'judul' => 'Kultur Moci Khas Tegal',
            'slug' => Str::slug('Kultur Moci Khas Tegal'),
            'penulis' => 'Mbah Moci',
            'penerbit' => 'Kanca Pustaka',
            'tahun_terbit' => 2023,
            'kategori' => 'Kebudayaan',
            'isbn' => '978-602-8123-99-9',
            'jumlah_halaman' => 95,
            'sinopsis' => 'Teh poci khas Tegal memiliki tradisi unik "wasgitel" (wangi, panas, sepet, legi, lan kentel). Buku ini menceritakan sosiologi masyarakat Tegal yang terbentuk dari kebiasaan berkumpul dan minum teh poci tanah liat bersama.',
            'cover' => 'ebook-cover/teh_poci_cover.png',
            'file_pdf' => 'ebooks/test_ebook.pdf',
            'status' => 'aktif',
        ]);

        // 2. Create some Ebook loans history
        $users = User::all();
        if ($users->isNotEmpty()) {
            // Ebook 1 Loans
            EbookPeminjaman::create([
                'user_id' => $users->random()->id,
                'ebook_id' => $ebook1->id,
                'tanggal_pinjam' => Carbon::today()->subDays(10)->toDateString(),
                'tanggal_jatuh_tempo' => Carbon::today()->subDays(3)->toDateString(),
                'status' => 'Kadaluarsa',
                'last_page' => 45,
                'progress_persen' => 37,
                'rating' => 5,
                'review' => 'Buku sejarah yang sangat lengkap dan ditulis dengan bahasa yang mudah dipahami anak muda.',
                'review_at' => Carbon::today()->subDays(3),
            ]);

            EbookPeminjaman::create([
                'user_id' => $users->random()->id,
                'ebook_id' => $ebook1->id,
                'tanggal_pinjam' => Carbon::today()->subDays(2)->toDateString(),
                'tanggal_jatuh_tempo' => Carbon::today()->addDays(5)->toDateString(),
                'status' => 'Dipinjam',
                'last_page' => 12,
                'progress_persen' => 10,
            ]);

            // Ebook 2 Loans
            EbookPeminjaman::create([
                'user_id' => $users->random()->id,
                'ebook_id' => $ebook2->id,
                'tanggal_pinjam' => Carbon::today()->subDays(15)->toDateString(),
                'tanggal_jatuh_tempo' => Carbon::today()->subDays(8)->toDateString(),
                'status' => 'Selesai',
                'last_page' => 95,
                'progress_persen' => 100,
                'rating' => 4,
                'review' => 'Kajian sosiologinya sangat menarik. Membuka wawasan baru tentang budaya minum teh di Tegal.',
                'review_at' => Carbon::today()->subDays(8),
            ]);
        }
    }
}
