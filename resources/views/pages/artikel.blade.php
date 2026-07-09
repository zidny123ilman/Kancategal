<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumpulan Artikel - {{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }}</title>

    <!-- Meta Tags SEO -->
    <meta name="description"
        content="Jelajahi kumpulan esai, jurnal, berita, dan catatan literasi alternatif dari para kontributor dan pegiat Kanca Tegal.">
    <meta name="keywords" content="kumpulan artikel, esai literasi, jurnal tegal, berita tegal, kanca tegal">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Flash Messages -->
    <div style="max-width: 1200px; margin: 1.5rem auto 0; padding: 0 2rem;">
        @if (session('success'))
            <div class="alert alert-success"
                style="background-color: #E6F4EA; border: 1px solid #137333; color: #137333; padding: 1rem; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger"
                style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Content Container -->
    <main class="articles-page-container">

        <!-- Page Header -->
        <div class="articles-header"
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 3rem;">
            <div>
                <h1 class="main-title-small">Kumpulan Artikel</h1>
                <h2 class="main-title-large">KANCA TEGAL</h2>
            </div>
            @auth
                @if (Auth::user()->can_upload_artikel)
                    <a href="{{ url('/upload-artikel') }}" class="btn-signin"
                        style="background-color: var(--accent-blue); display: inline-flex; align-items: center; gap: 8px; text-decoration: none; text-transform: uppercase; font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                        <i class="fas fa-plus"></i> Buat Artikel Baru
                    </a>
                @endif
            @endauth
        </div>

        <!-- Most Read Section -->
        <section>
            <div class="section-header">
                <div class="section-title-group">
                    <h3 class="section-title">Most Read</h3>
                    <span class="section-tagline">TRENDING TOPICS THIS MONTH</span>
                </div>

                <div class="slider-navigation">
                    <button class="nav-arrow-btn"><i class="fas fa-arrow-left"></i></button>
                    <button class="nav-arrow-btn"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <!-- Most Read Grid -->
            <div class="articles-grid">
                @forelse($mostRead as $index => $art)
                    <!-- Card -->
                    <article class="most-read-card">
                        <div class="img-wrapper-relative">
                            <span class="number-badge">0{{ $index + 1 }}</span>
                            <img src="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                                alt="{{ $art->judul }}" class="most-read-img"
                                style="height: 250px; object-fit: cover; width: 100%;">
                        </div>
                        <h4 class="article-title">
                            <a href="#" class="dynamic-art-link" data-title="{{ $art->judul }}"
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
                        <a href="#" class="btn-read-more-link dynamic-art-link" data-title="{{ $art->judul }}"
                            data-uploader="{{ $art->nama_uploader }}"
                            data-date="{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}"
                            data-content="{{ $art->isi }}"
                            data-image="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                            data-category="{{ $art->kategori }}">
                            Read More <i class="fas fa-arrow-right"></i>
                        </a>
                    </article>
                @empty
                    <div style="grid-column: span 3; text-align: center; padding: 4rem 0; color: var(--text-muted);">
                        <i class="far fa-file-alt"
                            style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                        Belum ada artikel populer saat ini.
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Latest Articles Section (Full Width Sage BG) -->
    <section class="full-width-sage-section">
        <div class="sage-section-container">

            <div class="section-header">
                <div class="section-title-group">
                    <h3 class="section-title">Latest Articles</h3>
                    <span class="section-tagline">FRESH PERSPECTIVES FROM OUR EDITORS</span>
                </div>

                <div class="slider-navigation">
                    <button class="nav-arrow-btn"><i class="fas fa-arrow-left"></i></button>
                    <button class="nav-arrow-btn"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <!-- Latest Articles Grid -->
            <div class="articles-grid" style="margin-bottom: 0;">
                @forelse($latest as $art)
                    <!-- Latest Card -->
                    <article class="latest-article-card">
                        <div class="latest-card-img-container">
                            <img src="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                                alt="{{ $art->judul }}" class="latest-card-img"
                                style="height: 200px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="badge-row">
                            <span class="pill-badge cat-badge">{{ strtoupper($art->kategori) }}</span>
                            <span class="pill-badge time-badge">5 MIN READ</span>
                        </div>
                        <h4 class="latest-card-title">
                            <a href="#" class="dynamic-art-link" data-title="{{ $art->judul }}"
                                data-uploader="{{ $art->nama_uploader }}"
                                data-date="{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}"
                                data-content="{{ $art->isi }}"
                                data-image="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                                data-category="{{ $art->kategori }}">
                                {{ $art->judul }}
                            </a>
                        </h4>
                        <p class="latest-card-desc">
                            {{ Str::limit($art->isi, 120) }}
                        </p>
                        <div class="latest-card-footer">
                            <span class="latest-author-name">{{ strtoupper($art->nama_uploader) }}</span>
                            <button class="btn-action-arrow dynamic-art-link" data-title="{{ $art->judul }}"
                                data-uploader="{{ $art->nama_uploader }}"
                                data-date="{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}"
                                data-content="{{ $art->isi }}"
                                data-image="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                                data-category="{{ $art->kategori }}">
                                <i class="fas fa-arrow-up-right-from-square"></i>
                            </button>
                        </div>
                    </article>
                @empty
                    @if($mostRead->isEmpty())
                        <!-- Already handled above -->
                    @else
                        <div style="grid-column: span 3; text-align: center; padding: 4rem 0; color: var(--text-muted);">
                            Semua artikel sudah ditampilkan di atas.
                        </div>
                    @endif
                @endforelse
            </div>

        </div>
    </section>

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

    <!-- Script to handle article clicks and pass full data to detail page -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const articleLinks = document.querySelectorAll('.dynamic-art-link');

            articleLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Retrieve metadata
                    let target = link;
                    if (!link.getAttribute('data-title')) {
                        // If it's a wrapper, search closest element or children
                        target = link.closest('.most-read-card, .latest-article-card').querySelector('[data-title]');
                    }

                    if (target) {
                        const title = target.getAttribute('data-title');
                        const author = target.getAttribute('data-uploader');
                        const date = target.getAttribute('data-date');
                        const content = target.getAttribute('data-content');
                        const image = target.getAttribute('data-image');
                        const category = target.getAttribute('data-category');

                        // Redirect with URL parameters
                        window.location.href = `{{ url('/detailartikel') }}?title=${encodeURIComponent(title)}&author=${encodeURIComponent(author)}&date=${encodeURIComponent(date)}&content=${encodeURIComponent(content)}&image=${encodeURIComponent(image)}&category=${encodeURIComponent(category)}`;
                    }
                });
            });
        });
    </script>
</body>

</html>