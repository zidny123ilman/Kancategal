<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku - {{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }}</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Jelajahi koleksi buku dan arsip literasi Kanca Tegal. Pinjam buku budaya, sejarah, sastra, politik, dan seni dari penulis lokal maupun nasional.">
    <meta name="keywords" content="koleksi buku, pinjam buku, Kanca Tegal, perpustakaan, budaya Tegal, sejarah Jawa">
    
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
        <div class="collection-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div class="title-group">
                <span class="title-tagline">THE MODERN ARCHIVIST</span>
                <h1 class="main-title-small">Koleksi Buku</h1>
                <h2 class="main-title-large">KANCA TEGAL</h2>
            </div>
            
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                @auth
                    <a href="{{ url('/buku' . ($showOnlyFavorites ? '' : '?favorite=1')) }}" style="background-color: {{ $showOnlyFavorites ? '#ffc107' : 'var(--bg-white)' }}; color: {{ $showOnlyFavorites ? '#1e2e25' : 'var(--text-dark)' }}; border: 2px solid {{ $showOnlyFavorites ? '#ffc107' : 'var(--border-color)' }}; border-radius: 9999px; padding: 0.75rem 1.8rem; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 1px; transition: var(--transition-smooth);">
                        <i class="fas fa-star" style="color: {{ $showOnlyFavorites ? '#1e2e25' : '#ffc107' }};"></i>
                        {{ $showOnlyFavorites ? 'Semua Buku' : 'Favorit Saya' }}
                    </a>
                @endauth

                <div class="filter-dropdown-wrapper">
                    <select onchange="location = this.value;" class="filter-select" style="background-color: var(--bg-white); border: 2px solid var(--border-color); border-radius: 9999px; padding: 0.8rem 2rem; outline: none; font-family: var(--font-main); font-size: 0.85rem; font-weight: 700; color: var(--text-dark); cursor: pointer; transition: var(--transition-smooth); width: 240px; text-transform: uppercase; letter-spacing: 1px; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%231E2E25%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1.25rem top 50%; background-size: 0.65rem auto; padding-right: 2.5rem;">
                        <option value="{{ url('/buku') }}" {{ !$category || strtolower($category) === 'semua' ? 'selected' : '' }}>SEMUA KATEGORI (ALL)</option>
                        @foreach ($categories as $cat)
                            <option value="{{ url('/buku?category=' . urlencode($cat)) }}" {{ strtolower($category) === strtolower($cat) ? 'selected' : '' }}>{{ strtoupper($cat) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="books-grid">
            @forelse ($books as $buku)
            <!-- Book card -->
            <article class="book-card" data-id="{{ $buku->id }}">
                <div class="book-image-wrapper">
                    @if (strtolower($buku->status) === 'ready')
                        <span class="status-badge status-ready"><span class="badge-txt">READY</span></span>
                    @else
                        <span class="status-badge status-borrowed"><span class="badge-txt">DIPINJAM</span></span>
                    @endif
                    
                    @if(in_array($buku->id, $userFavorites))
                        <span class="status-badge favorite-badge" style="background-color: #ffc107; color: #1e2e25; left: auto; right: 1rem;"><i class="fas fa-star"></i> <span class="badge-txt">FAVORIT</span></span>
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
            @empty
            <div style="grid-column: span 3; text-align: center; color: var(--text-muted); padding: 5rem 2rem; background: var(--bg-white); border-radius: 12px; border: 1px solid var(--border-color); width: 100%;">
                <i class="fas fa-book" style="font-size: 3rem; color: #C8D4CE; margin-bottom: 1rem; display: block;"></i>
                <h3 style="font-size: 1.1rem; color: var(--text-dark); margin-bottom: 0.5rem;">
                    {{ $showOnlyFavorites ? 'Tidak Ada Buku Favorit' : 'Tidak Ada Koleksi Buku' }}
                </h3>
                <p style="font-size: 0.9rem;">
                    {{ $showOnlyFavorites ? 'Anda belum menambahkan buku ke daftar favorit Anda.' : 'Belum ada buku untuk kategori ini di perpustakaan.' }}
                </p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($books->hasPages())
        <div class="pagination-container">
            @if ($books->onFirstPage())
                <span class="page-arrow disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $books->previousPageUrl() }}" class="page-arrow"><i class="fas fa-chevron-left"></i></a>
            @endif
            
            <div class="page-numbers">
                @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                    @if ($page == $books->currentPage())
                        <span class="page-num active">{{ sprintf("%02d", $page) }}</span>
                    @else
                        <a href="{{ $url }}" class="page-num">{{ sprintf("%02d", $page) }}</a>
                    @endif
                @endforeach
            </div>
            
            @if ($books->hasMorePages())
                <a href="{{ $books->nextPageUrl() }}" class="page-arrow">NEXT <i class="fas fa-chevron-right"></i></a>
            @else
                <span class="page-arrow disabled">NEXT <i class="fas fa-chevron-right"></i></span>
            @endif
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
                    &copy; 2026 THE MODERN ARCHIVIST. HAK CIPTA DILINDUNGI. Support by @tegal.itsolutions
                </div>
            </div>
        </div>
    </footer>

    <!-- Script to handle book card clicks -->
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
        });
    </script>
</body>
</html>
