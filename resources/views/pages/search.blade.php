<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian: "{{ $search }}" - {{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }}</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Hasil pencarian arsip dan artikel untuk kata kunci {{ $search }} di Kanca Tegal.">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="collection-section">
        
        <!-- Collection Title and Filter Area -->
        <div class="collection-header">
            <div class="title-group">
                <span class="title-tagline">SEARCH ARCHIVE</span>
                <h1 class="main-title-small">Hasil Pencarian</h1>
                <h2 class="main-title-large">"{{ $search }}"</h2>
            </div>
        </div>

        <div style="margin-bottom: 3rem; font-size: 1rem; color: var(--text-muted); font-weight: 500;">
            Menampilkan {{ count($books) }} Buku dan {{ count($articles) }} Artikel untuk kata kunci <strong>"{{ $search }}"</strong>.
        </div>

        <!-- Books Section -->
        @if(count($books) > 0)
            <div class="section-title-wrapper" style="margin-bottom: 2rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <span class="section-tag">BOOKS FOUND</span>
                <h2 class="section-title" style="font-size: 1.8rem;">Koleksi Buku Terkait</h2>
            </div>
            <div class="books-grid" style="margin-bottom: 5rem;">
                @foreach ($books as $buku)
                <!-- Book card -->
                <article class="book-card" data-id="{{ $buku->id }}">
                    <div class="book-image-wrapper">
                        @if (strtolower($buku->status) === 'ready')
                            <span class="status-badge status-ready">READY</span>
                        @else
                            <span class="status-badge status-borrowed">DIPINJAM</span>
                        @endif
                        <div class="book-image-container">
                            @if(str_starts_with($buku->foto, 'http'))
                                <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image">
                            @else
                                <img src="{{ asset($buku->foto) }}" alt="{{ $buku->judul }}" class="book-image">
                            @endif
                        </div>
                    </div>
                    <div class="book-info">
                        <span class="book-category {{ strtolower($buku->status) !== 'ready' ? 'muted-cat' : '' }}">{{ $buku->kategori }}</span>
                        <h3 class="book-title">{{ $buku->judul }}</h3>
                        <p class="book-author">{{ $buku->penulis }}</p>
                        @if (strtolower($buku->status) === 'ready')
                            <button class="btn-borrow">PINJAM BUKU</button>
                        @else
                            <button class="btn-unavailable" disabled>TIDAK TERSEDIA</button>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
        @endif

        <!-- Articles Section -->
        @if(count($articles) > 0)
            <div class="section-title-wrapper" style="margin-bottom: 2rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <span class="section-tag">ARTICLES FOUND</span>
                <h2 class="section-title" style="font-size: 1.8rem;">Kumpulan Artikel Terkait</h2>
            </div>
            <div class="articles-page-container" style="margin-bottom: 5rem;">
                <div class="articles-grid">
                    @foreach ($articles as $index => $art)
                        <!-- Card -->
                        <article class="most-read-card">
                            <div class="img-wrapper-relative">
                                <span class="number-badge">0{{ $index + 1 }}</span>
                                <img src="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}" alt="{{ $art->judul }}" class="most-read-img" style="height: 250px; object-fit: cover; width: 100%;">
                            </div>
                            <h4 class="article-title">
                                <a href="#" class="dynamic-art-link" 
                                   data-slug="{{ $art->slug }}"
                                   data-title="{{ $art->judul }}" 
                                   data-uploader="{{ $art->nama_uploader }}" 
                                   data-date="{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}" 
                                   data-content="{{ $art->isi }}" 
                                   data-image="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}" 
                                   data-category="{{ $art->kategori }}">
                                    {{ $art->judul }}
                                </a>
                            </h4>
                            <span class="article-author-blue">BY {{ strtoupper($art->nama_uploader) }}</span>
                            <p class="article-desc-preview">
                                {{ Str::limit($art->isi, 120) }}
                            </p>
                            <a href="#" class="btn-read-more-link dynamic-art-link"
                               data-slug="{{ $art->slug }}"
                               data-title="{{ $art->judul }}" 
                               data-uploader="{{ $art->nama_uploader }}" 
                               data-date="{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}" 
                               data-content="{{ $art->isi }}" 
                               data-image="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}" 
                               data-category="{{ $art->kategori }}">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if(count($books) === 0 && count($articles) === 0)
            <div style="text-align: center; color: var(--text-muted); padding: 5rem 2rem; background: var(--bg-white); border-radius: 12px; border: 1px solid var(--border-color); width: 100%;">
                <i class="fas fa-search" style="font-size: 3rem; color: #C8D4CE; margin-bottom: 1rem; display: block;"></i>
                <h3 style="font-size: 1.1rem; color: var(--text-dark); margin-bottom: 0.5rem;">Tidak Ada Hasil Pencarian</h3>
                <p style="font-size: 0.9rem;">Maaf, tidak ada buku atau artikel yang cocok dengan kata kunci <strong>"{{ $search }}"</strong>.</p>
                <a href="{{ url('/') }}" class="btn-signin" style="display: inline-block; margin-top: 1.5rem; text-decoration: none;">Kembali ke Beranda</a>
            </div>
        @endif

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
                    &copy; 2026 KANCA TEGAL Support by @tegal.itsolutions X Universitas Harkat Negeri
                </div>
            </div>
        </div>
    </footer>

    <!-- Script to handle clicks -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bookCards = document.querySelectorAll('.book-card');
            bookCards.forEach(card => {
                card.style.cursor = 'pointer';
                card.addEventListener('click', () => {
                    const id = card.getAttribute('data-id');
                    if (id) {
                        window.location.href = "{{ url('/detailbuku') }}/" + id;
                    }
                });
            });

            const articleLinks = document.querySelectorAll('.dynamic-art-link');
            articleLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    let target = link;
                    if (!link.getAttribute('data-title')) {
                        target = link.closest('.most-read-card').querySelector('[data-title]');
                    }
                    
                    if (target) {
                        const slug = target.getAttribute('data-slug');
                        
                        window.location.href = `{{ url('/detailartikel') }}/${slug}`;
                    }
                });
            });
        });
    </script>
</body>
</html>
