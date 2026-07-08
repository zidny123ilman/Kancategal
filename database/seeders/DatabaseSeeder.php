<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Members (Users)
        $users = [
            [
                'name' => 'Riana Kusuma',
                'whatsapp' => '0898765456780',
                'email' => 'riana@example.com',
                'alamat' => 'Jl. Pancasila No. 12, Tegal',
                'password' => Hash::make('password'),
                'can_borrow' => true,
                'can_upload_artikel' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'whatsapp' => '0878675456790',
                'email' => 'ahmad@example.com',
                'alamat' => 'Jl. Ahmad Yani No. 45, Tegal',
                'password' => Hash::make('password'),
                'can_borrow' => true,
                'can_upload_artikel' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Siti Aminah',
                'whatsapp' => '0898765432123',
                'email' => 'siti@example.com',
                'alamat' => 'Jl. Diponegoro No. 8, Tegal',
                'password' => Hash::make('password'),
                'can_borrow' => false,
                'can_upload_artikel' => false,
                'status' => 'suspended',
            ],
            [
                'name' => 'Budi Santoso',
                'whatsapp' => '08123456788990',
                'email' => 'budi@example.com',
                'alamat' => 'Jl. Sudirman No. 100, Tegal',
                'password' => Hash::make('password'),
                'can_borrow' => true,
                'can_upload_artikel' => true,
                'status' => 'probation',
            ],
            [
                'name' => 'Test User',
                'whatsapp' => '081234567890',
                'email' => 'test@example.com',
                'alamat' => 'Jl. Martoloyo No. 3, Tegal',
                'password' => Hash::make('password'),
                'can_borrow' => true,
                'can_upload_artikel' => true, // has access to upload article
                'status' => 'active',
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // 2. Call BukuSeeder
        $this->call(BukuSeeder::class);

        // 3. Seed Articles (Artikels)
        $articles = [
            [
                'judul' => 'The Evolution of Sauto Tegal: A Culinary Odyssey',
                'nama_uploader' => 'Budi Sudarsono',
                'tanggal_upload' => '2023-10-24',
                'foto_utama' => 'https://images.unsplash.com/photo-1606131731446-5568d87113aa?auto=format&fit=crop&q=80&w=500',
                'isi' => 'Sauto Tegal adalah variasi soto khas Tegal yang unik karena menggunakan tauco sebagai bumbu utamanya. Rasa gurih manis berpadu sedikit asam asam tauco menciptakan harmoni rasa pesisiran yang melegenda. Biasanya disajikan dengan mangkuk kecil, dipenuhi tauge, suwiran daging ayam atau sapi, dan jeroan garing.',
                'foto_pendukung' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=500',
                'kategori' => 'GASTRONOMY',
                'status' => 'approved',
            ],
            [
                'judul' => 'Journalism in the age of Citizen Voices',
                'nama_uploader' => 'Dewi Sartika',
                'tanggal_upload' => '2023-10-22',
                'foto_utama' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500',
                'isi' => 'Di era digital saat ini, batasan jurnalisme arus utama kian memudar. Setiap warga dengan gawai pintar dapat meliput kejadian secara real-time. Hal ini menghidupkan ekosistem berita alternatif namun juga membawa tantangan berat berupa disinformasi. Kurasi dan integritas tetap menjadi pilar utama.',
                'foto_pendukung' => null,
                'kategori' => 'MEDIA',
                'status' => 'approved',
            ],
            [
                'judul' => 'The Vanishing Architecture of Poci Houses',
                'nama_uploader' => 'Adi Kusuma',
                'tanggal_upload' => Carbon::now()->subHours(2)->toDateString(),
                'foto_utama' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&q=80&w=500',
                'isi' => 'Teh poci bukan sekadar minuman di Tegal, melainkan sebuah ritual sosial. Dulu, hampir setiap rumah memiliki ruang khusus untuk "Moci" dengan arsitektur jendela rendah dan beranda luas untuk bersantai. Kini, rumah-rumah poci tradisional tersebut lambat laun tergantikan oleh ruko-ruko minimalis modern.',
                'foto_pendukung' => null,
                'kategori' => 'HERITAGE & CULTURE',
                'status' => 'pending',
            ],
            [
                'judul' => 'Poetry of the North Coast: A Resurgence',
                'nama_uploader' => 'Maya Lestari',
                'tanggal_upload' => Carbon::now()->subHours(5)->toDateString(),
                'foto_utama' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&q=80&w=500',
                'isi' => 'Sastra pesisir utara Jawa Tengah, khususnya Tegal, memiliki karakter blak-blakan (lugas) dan jenaka. Belakangan, anak-anak muda di Tegal mulai menghidupkan kembali sastra lokal melalui stand-up poetry dan stanzas digital di media sosial, membawa isu lingkungan pesisir dan abrasi.',
                'foto_pendukung' => null,
                'kategori' => 'LOCAL LITERATURES',
                'status' => 'pending',
            ]
        ];

        // Assign some seeded user ids to articles for realism if wanted
        $fauzi = User::where('name', 'Ahmad Fauzi')->first();
        $riana = User::where('name', 'Riana Kusuma')->first();

        foreach ($articles as $index => $art) {
            if ($index % 2 === 0 && $fauzi) {
                $art['user_id'] = $fauzi->id;
            } elseif ($riana) {
                $art['user_id'] = $riana->id;
            }
            Artikel::create($art);
        }

        // 4. Seed Peminjamans (Loans)
        $allUsers = User::all();
        $allBooks = \App\Models\Buku::all();

        if ($allUsers->isNotEmpty() && $allBooks->isNotEmpty()) {
            $months = [
                1 => ['name' => 'Jan', 'count' => 15],
                2 => ['name' => 'Feb', 'count' => 22],
                3 => ['name' => 'Mar', 'count' => 35],
                4 => ['name' => 'Apr', 'count' => 28],
                5 => ['name' => 'May', 'count' => 42],
                6 => ['name' => 'Jun', 'count' => 50],
            ];

            foreach ($months as $monthNum => $data) {
                for ($i = 0; $i < $data['count']; $i++) {
                    $user = $allUsers->random();
                    $book = $allBooks->random();
                    
                    $day = rand(1, 28);
                    $borrowDate = Carbon::create(2026, $monthNum, $day);
                    $dueDate = (clone $borrowDate)->addDays(rand(7, 14));
                    
                    if ($monthNum < 6) {
                        // All loans in past months are completed
                        $returnDate = (clone $borrowDate)->addDays(rand(3, 10));
                        \App\Models\Peminjaman::create([
                            'user_id' => $user->id,
                            'buku_id' => $book->id,
                            'tanggal_pinjam' => $borrowDate->toDateString(),
                            'tanggal_kembali' => $dueDate->toDateString(),
                            'tanggal_dikembalikan' => $returnDate->toDateString(),
                            'status' => 'selesai',
                            'created_at' => $borrowDate,
                            'updated_at' => $returnDate,
                        ]);
                    } else {
                        // June loans (some active, some late, some completed)
                        $statusRandom = rand(1, 10);
                        if ($statusRandom <= 4) {
                            // Completed
                            $returnDate = (clone $borrowDate)->addDays(rand(3, 10));
                            \App\Models\Peminjaman::create([
                                'user_id' => $user->id,
                                'buku_id' => $book->id,
                                'tanggal_pinjam' => $borrowDate->toDateString(),
                                'tanggal_kembali' => $dueDate->toDateString(),
                                'tanggal_dikembalikan' => $returnDate->toDateString(),
                                'status' => 'selesai',
                                'created_at' => $borrowDate,
                                'updated_at' => $returnDate,
                            ]);
                        } elseif ($statusRandom <= 7) {
                            // Active and on time (due date is in the future relative to 26 June 2026)
                            $borrowDateJune = Carbon::create(2026, 6, rand(20, 25));
                            $dueDateJune = (clone $borrowDateJune)->addDays(rand(7, 14));
                            \App\Models\Peminjaman::create([
                                'user_id' => $user->id,
                                'buku_id' => $book->id,
                                'tanggal_pinjam' => $borrowDateJune->toDateString(),
                                'tanggal_kembali' => $dueDateJune->toDateString(),
                                'tanggal_dikembalikan' => null,
                                'status' => 'aktif',
                                'created_at' => $borrowDateJune,
                                'updated_at' => $borrowDateJune,
                            ]);
                        } else {
                            // Late (due date is in the past relative to 26 June 2026)
                            $borrowDateJuneLate = Carbon::create(2026, 6, rand(1, 10));
                            $dueDateJuneLate = (clone $borrowDateJuneLate)->addDays(7);
                            \App\Models\Peminjaman::create([
                                'user_id' => $user->id,
                                'buku_id' => $book->id,
                                'tanggal_pinjam' => $borrowDateJuneLate->toDateString(),
                                'tanggal_kembali' => $dueDateJuneLate->toDateString(),
                                'tanggal_dikembalikan' => null,
                                'status' => 'aktif',
                                'created_at' => $borrowDateJuneLate,
                                'updated_at' => $borrowDateJuneLate,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
