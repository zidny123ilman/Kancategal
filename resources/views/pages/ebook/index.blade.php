<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi E-Book - {{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }}</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Jelajahi dan baca koleksi E-Book digital Kanca Tegal secara instan dan gratis.">
    <meta name="keywords" content="ebook, buku digital, kanca tegal, perpustakaan digital">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    <style>
        .ebook-card {
            background-color: var(--bg-white);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: var(--transition-smooth);
            position: relative;
        }
        .ebook-card:hover {
            transform: translateY(-8px);
            border-color: #1a56db;
            box-shadow: 0 10px 20px rgba(26, 86, 219, 0.08);
        }
        .ebook-image-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            overflow: hidden;
            background-color: #f4f8f5;
        }
        .ebook-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-smooth);
        }
        .ebook-card:hover .ebook-image-wrapper img { transform: scale(1.05); }
        .badge-digital {
            position: absolute;
            top: 1rem; right: 1rem;
            background-color: #1a56db;
            color: #ffffff;
            font-size: 0.65rem; font-weight: 800;
            padding: 0.4rem 0.8rem;
            border-radius: 9999px;
            letter-spacing: 1px; z-index: 2;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .ebook-details {
            padding: 1.5rem;
            display: flex; flex-direction: column; flex-grow: 1;
        }
        .ebook-category {
            font-size: 0.65rem; font-weight: 800;
            color: #1a56db; text-transform: uppercase;
            letter-spacing: 1px; margin-bottom: 0.5rem;
        }
        .ebook-title {
            font-size: 1.1rem; font-weight: 800;
            color: var(--text-dark); line-height: 1.4;
            margin-bottom: 0.5rem; text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden; height: 3rem;
        }
        .ebook-author {
            font-size: 0.8rem; color: var(--text-muted);
            margin-bottom: 1rem; font-weight: 600;
        }
        .ebook-rating {
            margin-top: auto;
            display: flex; align-items: center; gap: 4px;
            font-size: 0.8rem; color: #f59e0b; font-weight: 700;
            border-top: 1px solid var(--border-color); padding-top: 0.75rem;
        }
        .ebook-rating span { color: var(--text-muted); font-weight: 600; font-size: 0.75rem; }

        @media (max-width: 576px) {
            .books-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 1rem !important; }
            .ebook-details { padding: 1rem; }
            .ebook-title { font-size: 0.9rem; height: 2.6rem; }
            .ebook-author { font-size: 0.75rem; margin-bottom: 0.5rem; }
        }

        /* Pagination override */
        .pagination nav { display: flex; justify-content: center; }
        .pagination .pagination { display: flex; list-style: none; padding: 0; margin: 0; gap: 6px; }
        .pagination li { margin: 0; }
        .pagination li a, .pagination li span {
            display: flex; align-items: center; justify-content: center;
            min-width: 40px; height: 40px; padding: 0 10px; border-radius: 8px;
            border: 2px solid var(--border-color); background-color: var(--bg-white);
            color: var(--text-dark); font-weight: 700; text-decoration: none;
            font-size: 0.85rem; transition: var(--transition-smooth);
        }
        .pagination li.active span { background-color: #1a56db; border-color: #1a56db; color: white; }
        .pagination li a:hover { border-color: #1a56db; color: #1a56db; }
        .pagination li.disabled span { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="collection-section">
        
        <!-- Collection Title and Filter Area -->
        <div class="collection-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 3rem;">
            <div class="title-group">
                <span class="title-tagline">DIGITAL ARCHIVE</span>
                <h1 class="main-title-small">Koleksi E-Book</h1>
                <h2 class="main-title-large">KANCA TEGAL</h2>
            </div>
            
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <div class="filter-dropdown-wrapper">
                    <select onchange="location = this.value;" class="filter-select" style="background-color: var(--bg-white); border: 2px solid var(--border-color); border-radius: 9999px; padding: 0.8rem 2rem; outline: none; font-family: var(--font-main); font-size: 0.85rem; font-weight: 700; color: var(--text-dark); cursor: pointer; transition: var(--transition-smooth); width: 240px; text-transform: uppercase; letter-spacing: 1px; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231E2E25%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1.25rem top 50%; background-size: 0.65rem auto; padding-right: 2.5rem;">
                        <option value="{{ url('/ebook') }}" {{ !$kategori || strtolower($kategori) === 'semua' ? 'selected' : '' }}>SEMUA KATEGORI (ALL)</option>
                        @foreach ($categories as $cat)
                            <option value="{{ url('/ebook?kategori=' . urlencode($cat)) }}" {{ strtolower($kategori) === strtolower($cat) ? 'selected' : '' }}>{{ strtoupper($cat) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- E-Books Grid -->
        <div class="books-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
            @forelse ($ebooks as $eb)
            <article class="ebook-card">
                <div class="ebook-image-wrapper">
                    <span class="badge-digital"><i class="fas fa-file-pdf"></i> E-BOOK</span>
                    <a href="{{ url('/ebook/' . $eb->slug) }}">
                        <img src="{{ Storage::url($eb->cover) }}" alt="{{ $eb->judul }}" loading="lazy">
                    </a>
                </div>
                <div class="ebook-details">
                    <span class="ebook-category">{{ $eb->kategori }}</span>
                    <a href="{{ url('/ebook/' . $eb->slug) }}" class="ebook-title">{{ $eb->judul }}</a>
                    <span class="ebook-author">Oleh {{ $eb->penulis }}</span>
                    
                    @php
                        $avgRating = $eb->peminjamans()->whereNotNull('rating')->avg('rating') ?? 0;
                        $totalReviews = $eb->peminjamans()->whereNotNull('rating')->count();
                    @endphp
                    <div class="ebook-rating">
                        @if($avgRating > 0)
                            <i class="fas fa-star"></i> {{ number_format($avgRating, 1) }} <span>({{ $totalReviews }} Ulasan)</span>
                        @else
                            <i class="far fa-star" style="color: var(--text-muted);"></i> <span style="margin-left: 4px;">Belum ada ulasan</span>
                        @endif
                    </div>
                </div>
            </article>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 5rem 2rem;">
                <i class="fas fa-file-pdf" style="font-size: 3.5rem; color: #d0dcd4; margin-bottom: 1.5rem;"></i>
                <h3 style="font-size: 1.5rem; color: var(--text-dark); margin-bottom: 0.5rem; font-weight: 800;">Belum Ada E-Book</h3>
                <p>Maaf, kami tidak menemukan E-Book yang sesuai dengan kriteria pencarian Anda.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($ebooks->hasPages())
        <div style="margin-top: 4rem; display: flex; justify-content: center;">
            <div class="pagination" style="display: flex; gap: 0.5rem;">
                {{ $ebooks->links() }}
            </div>
        </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-logo">KANCA TEGAL</div>
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

</body>
</html>
