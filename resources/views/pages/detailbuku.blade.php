<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->judul }} - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Detail buku {{ $book->judul }} oleh {{ $book->penulis }}. {{ Str::limit($book->sinopsis, 150) }}">
    <meta name="keywords" content="{{ $book->judul }}, {{ $book->penulis }}, {{ $book->kategori }}, pinjam buku, Kanca Tegal">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        /* Hide scrollbars for sliding container */
        #resensi-slider-container::-webkit-scrollbar {
            display: none;
        }
        
        /* Star Rating select style */
        .star-rating-wrapper input:checked ~ label {
            color: #ffc107 !important;
        }
        .star-rating-wrapper label:hover,
        .star-rating-wrapper label:hover ~ label {
            color: #ffc107 !important;
        }
        
        /* Modal fade-in animation */
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        @if (session('success'))
            <div style="background-color: #E6F4EA; border-left: 4px solid #137333; color: #137333; padding: 1rem; border-radius: 6px; margin: 1.5rem 3rem 0; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background-color: rgba(192, 30, 46, 0.1); border-left: 4px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 6px; margin: 1.5rem 3rem 0; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Book Detail Upper Section -->
        <section class="book-detail-section">
            <!-- Left Side: Cover & Status -->
            <div class="book-detail-left">
                @if(str_starts_with($book->foto, 'http'))
                    <img src="{{ $book->foto }}" alt="{{ $book->judul }} Cover" class="book-cover-large">
                @else
                    <img src="{{ asset($book->foto) }}" alt="{{ $book->judul }} Cover" class="book-cover-large">
                @endif
                
                <div class="book-status-card">
                    <span class="status-label">STATUS</span>
                    <span class="status-value" id="status-value" style="color: {{ $statusColor }};">
                        <i class="fas {{ $statusIcon }}"></i> {{ $statusText }}
                    </span>
                </div>
            </div>

            <!-- Right Side: Info & Actions -->
            <div class="book-detail-right">
                <div class="breadcrumb">
                    <a href="{{ url('/buku') }}" style="text-decoration: underline;">KATALOG</a> <i class="fas fa-chevron-right" style="font-size:0.5rem; margin: 0 0.5rem;"></i> 
                    <span>{{ strtoupper($book->kategori) }}</span> <i class="fas fa-chevron-right" style="font-size:0.5rem; margin: 0 0.5rem;"></i> 
                    <span>{{ strtoupper($book->judul) }}</span>
                </div>

                <h1 class="detail-title">{{ $book->judul }}</h1>

                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">PENULIS</span>
                        <span class="meta-value">{{ $book->penulis }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">PENERBIT</span>
                        <span class="meta-value">{{ $book->penerbit }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">HALAMAN</span>
                        <span class="meta-value">{{ $book->jumlah_halaman }} Pages</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">DURASI PINJAM</span>
                        <span class="meta-value">{{ \App\Models\Setting::get('loan_duration', '7') }} Hari</span>
                    </div>
                </div>

                <blockquote class="detail-quote">
                    {{ $book->sinopsis }}
                </blockquote>

                <div class="action-buttons">
                    @auth
                        @if($activePeminjaman)
                            @if($activePeminjaman->status === 'pending_pinjam')
                                <button class="btn-secondary-action" disabled style="opacity: 0.7; cursor: not-allowed;">
                                    <i class="fas fa-clock"></i> Menunggu Konfirmasi Pinjam
                                </button>
                            @elseif($activePeminjaman->status === 'aktif')
                                <button type="button" class="btn-secondary-action" onclick="openReturnModal()">
                                    <i class="fas fa-undo"></i> Kembalikan Buku
                                </button>
                            @elseif($activePeminjaman->status === 'pending_kembali')
                                <button class="btn-secondary-action" disabled style="opacity: 0.7; cursor: not-allowed;">
                                    <i class="fas fa-clock"></i> Menunggu Konfirmasi Kembali
                                </button>
                            @endif
                        @else
                            @if(strtolower($book->status) === 'ready')
                                <form action="{{ url('/peminjaman/pinjam/' . $book->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-primary-action">
                                        <i class="fas fa-book"></i> Pinjam Buku
                                    </button>
                                </form>
                            @else
                                <button class="btn-secondary-action" disabled style="opacity: 0.7; cursor: not-allowed;">
                                    <i class="fas fa-times-circle"></i> Tidak Tersedia
                                </button>
                            @endif
                        @endif
                    @else
                        <a href="{{ url('/login') }}" class="btn-primary-action" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-book"></i> Pinjam Buku
                        </a>
                    @endauth
                    
                    <button id="btn-fav" class="btn-secondary-action" style="display: inline-flex; align-items: center; gap: 8px;">
                        @if(isset($isFavorited) && $isFavorited)
                            <i class="fas fa-bookmark" style="color: #ffc107;"></i> <span id="btn-fav-text">Hapus dari Koleksi</span>
                        @else
                            <i class="far fa-bookmark"></i> <span id="btn-fav-text">Tambah ke Koleksi</span>
                        @endif
                    </button>
                </div>

                <div class="specs-grid">
                    <div class="spec-box">
                        <span class="meta-label">BAHASA</span>
                        <span class="meta-value">{{ $book->bahasa }}</span>
                    </div>
                    <div class="spec-box">
                        <span class="meta-label">KATEGORI</span>
                        <span class="meta-value">{{ $book->kategori }}</span>
                    </div>
                    <div class="spec-box">
                        <span class="meta-label">ISBN</span>
                        <span class="meta-value">{{ $book->isbn }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Book Detail Lower Section -->
        <section class="detail-lower-section">
            <!-- Curator Note -->
            <div class="curator-note">
                <h3 class="curator-title">THE CURATOR'S NOTE</h3>
                <p class="curator-text">
                    "{{ $book->judul }}" adalah salah satu karya penting dalam genre {{ strtolower($book->kategori) }} di platform Kanca Tegal. Penulis {{ $book->penulis }} berhasil menyajikan kisah yang kaya dan berbobot untuk dinikmati pembaca.
                </p>
            </div>

            @if(Auth::check() && Auth::user()->can_borrow)
                <!-- Short Reviews / Resensi Singkat Section -->
                <div class="resensi-section" style="margin-top: 3rem; grid-column: span 2;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 class="curator-title" style="margin: 0; font-size: 1rem; letter-spacing: 1px;">RESENSI ANGGOTA</h3>
                        @if($resensis->count() > 1)
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="resensi-nav-btn" onclick="slideResensi('left')" style="background: none; border: 1px solid var(--border-color); color: var(--text-dark); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition-smooth);"><i class="fas fa-chevron-left"></i></button>
                                <button class="resensi-nav-btn" onclick="slideResensi('right')" style="background: none; border: 1px solid var(--border-color); color: var(--text-dark); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition-smooth);"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        @endif
                    </div>
                    
                    <div id="resensi-slider-container" style="overflow-x: auto; display: flex; gap: 1.5rem; scroll-behavior: smooth; padding-bottom: 1rem; scrollbar-width: none;">
                        @forelse($resensis as $resensi)
                            <div class="resensi-card" style="flex: 0 0 320px; background-color: var(--bg-theme); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; min-height: 140px; transition: var(--transition-smooth);">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                                        <div style="color: #ffc107;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $resensi->resensi_rating ? 'fas' : 'far' }} fa-star" style="font-size: 0.8rem;"></i>
                                            @endfor
                                        </div>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($resensi->updated_at)->format('d M Y') }}</span>
                                    </div>
                                    <p style="font-size: 0.85rem; line-height: 1.6; color: var(--text-dark); font-style: italic; margin-bottom: 1rem;">
                                        "{{ $resensi->resensi_isi ?? 'Hanya memberikan rating.' }}"
                                    </p>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 0.8rem;">
                                    <div style="width: 26px; height: 26px; border-radius: 50%; background-color: var(--accent-blue); color: var(--text-light); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                        {{ strtoupper(substr($resensi->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-dark);">{{ $resensi->user->name ?? 'Anggota Kanca' }}</span>
                                </div>
                            </div>
                        @empty
                            <div style="width: 100%; text-align: center; padding: 2.5rem 0; border: 1px dashed var(--border-color); border-radius: 12px; color: var(--text-muted); font-size: 0.85rem;">
                                <i class="far fa-comment-dots" style="font-size: 1.8rem; display: block; margin-bottom: 0.5rem; opacity: 0.6;"></i>
                                Belum ada resensi singkat untuk buku ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- Author Info -->
            @if($book->tentang_penulis)
            <div class="author-card">
                <i class="fas fa-feather-alt author-card-watermark"></i>
                <h3 class="author-card-title">Tentang Penulis</h3>
                <p class="author-card-text">
                    {{ $book->tentang_penulis }}
                </p>
            </div>
            @endif
        @auth
            @if($activePeminjaman && $activePeminjaman->status === 'aktif')
                <!-- Return Book Modal -->
                <div id="returnBookModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center; backdrop-filter: blur(5px);">
                    <div style="background-color: var(--bg-white); border-radius: 16px; width: 90%; max-width: 500px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid var(--border-color); position: relative; animation: modalFadeIn 0.3s ease-out; margin: auto; display: flex; flex-direction: column;">
                        <span onclick="closeReturnModal()" style="position: absolute; right: 1.5rem; top: 1.2rem; font-size: 1.5rem; cursor: pointer; color: var(--text-muted); transition: var(--transition-smooth);">&times;</span>
                        
                        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.5rem; letter-spacing: -0.5px;">Kembalikan Buku</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5;">Apakah Anda ingin memberikan resensi singkat mengenai buku ini? (Opsional)</p>
                        
                        <form action="{{ url('/peminjaman/kembalikan/' . $book->id) }}" method="POST">
                            @csrf
                            
                            <!-- Star Rating input -->
                            <div style="margin-bottom: 1.5rem; text-align: center;">
                                <label class="form-label" style="display: block; text-align: left; margin-bottom: 0.5rem;">Rating Buku</label>
                                <div class="star-rating-wrapper" style="display: inline-flex; flex-direction: row-reverse; gap: 0.5rem; justify-content: center; width: 100%;">
                                    <input type="radio" id="star5" name="rating" value="5" style="display: none;"><label for="star5" class="fas fa-star rating-star" style="font-size: 2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                                    <input type="radio" id="star4" name="rating" value="4" style="display: none;"><label for="star4" class="fas fa-star rating-star" style="font-size: 2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                                    <input type="radio" id="star3" name="rating" value="3" style="display: none;"><label for="star3" class="fas fa-star rating-star" style="font-size: 2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                                    <input type="radio" id="star2" name="rating" value="2" style="display: none;"><label for="star2" class="fas fa-star rating-star" style="font-size: 2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                                    <input type="radio" id="star1" name="rating" value="1" style="display: none;"><label for="star1" class="fas fa-star rating-star" style="font-size: 2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                                </div>
                            </div>
                            
                            <!-- Review text area -->
                            <div class="form-group" style="margin-bottom: 2rem;">
                                <label for="ulasan" class="form-label">Resensi Singkat (Opsional)</label>
                                <textarea id="ulasan" name="ulasan" class="form-input" style="min-height: 100px; resize: vertical; width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--bg-theme); color: var(--text-dark);" placeholder="Tulis pendapat singkat Anda mengenai isi buku ini..."></textarea>
                            </div>
                            
                            <!-- Action buttons -->
                            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                <button type="button" class="btn-secondary-action" onclick="closeReturnModal()" style="margin: 0; padding: 0.8rem 1.5rem; font-size: 0.85rem;">Batal</button>
                                <button type="submit" class="btn-primary-action" style="margin: 0; padding: 0.8rem 1.8rem; font-size: 0.85rem;">Kirim & Kembalikan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endauth
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-logo">
                    KANCA TEGAL
                </div>
                <ul class="footer-links">
                    <li><a href="https://wa.me/62895324606014" class="footer-link">WHATSAPP</a></li>
                    <li><a href="https://instagram.com/kanca.tegal" class="footer-link">INSTAGRAM</a></li>
                </ul>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; 2026 THE MODERN ARCHIVIST. HAK CIPTA DILINDUNGI. Support by @tegal.itsolutions
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isLoggedIn = @json(Auth::check());
            const btnFav = document.getElementById('btn-fav');

            btnFav.addEventListener('click', () => {
                if (!isLoggedIn) {
                    window.location.href = "{{ url('/login') }}";
                    return;
                }
                
                // Toggle favorite via POST request
                fetch("{{ url('/buku/' . $book->id . '/favorite') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const icon = btnFav.querySelector('i');
                    const textSpan = document.getElementById('btn-fav-text');
                    if (data.status === 'added') {
                        icon.className = 'fas fa-bookmark';
                        icon.style.color = '#ffc107';
                        if (textSpan) textSpan.textContent = 'Hapus dari Koleksi';
                        alert('Buku ditambahkan ke koleksi favorit Anda.');
                    } else {
                        icon.className = 'far fa-bookmark';
                        icon.style.color = '';
                        if (textSpan) textSpan.textContent = 'Tambah ke Koleksi';
                        alert('Buku dihapus dari koleksi favorit Anda.');
                    }
                })
                .catch(err => {
                    console.error('Error toggling favorite:', err);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        });

        function openReturnModal() {
            const modal = document.getElementById('returnBookModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeReturnModal() {
            const modal = document.getElementById('returnBookModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function slideResensi(direction) {
            const container = document.getElementById('resensi-slider-container');
            if (container) {
                const scrollAmount = 340; // card width (320px) + gap (20px)
                if (direction === 'left') {
                    container.scrollLeft -= scrollAmount;
                } else {
                    container.scrollLeft += scrollAmount;
                }
            }
        }
    </script>
</body>
</html>
