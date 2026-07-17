<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->judul }} - Kanca Tegal</title>
    
    <meta name="description" content="{{ Str::limit($artikel->isi, 150) }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    @include('components.navbar')

    <main>
        <!-- Article Header & Meta -->
        <section class="article-detail-section">
            <div class="article-detail-header">
                <span class="article-detail-badge">{{ strtoupper($artikel->kategori) }}</span>
                <h1 class="article-detail-title" id="article-title">{{ $artikel->judul }}</h1>
                <div class="article-detail-meta">
                    <span id="article-author"><i class="fas fa-feather-alt"></i> {{ strtoupper($artikel->nama_uploader) }}</span>
                    <span id="article-date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($artikel->tanggal_upload)->format('d M Y') }}</span>
                    <span id="article-time"><i class="far fa-eye"></i> {{ number_format($artikel->views, 0, ',', '.') }} views</span>
                </div>
            </div>
        </section>

        <!-- Hero Image -->
        <section class="article-detail-hero">
            <img src="{{ filter_var($artikel->foto_utama, FILTER_VALIDATE_URL) ? $artikel->foto_utama : asset($artikel->foto_utama) }}" alt="{{ $artikel->judul }}" id="article-image">
        </section>

        <!-- Article Body -->
        <section class="article-detail-body">
            <!-- Left Sidebar (Social Links) -->
            <div class="article-social-sidebar">
                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin ke clipboard!');" class="article-social-link" style="border:none; background:none; cursor:pointer;" title="Salin Tautan">
                    <i class="fas fa-link"></i>
                </button>
                @auth
                    <form action="{{ url('/artikel/' . $artikel->id . '/favorite') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="article-social-link" style="border:none; background:none; cursor:pointer;" title="Simpan ke Favorit">
                            <i class="{{ $artikel->favoritedBy()->where('user_id', Auth::id())->exists() ? 'fas' : 'far' }} fa-bookmark" style="{{ $artikel->favoritedBy()->where('user_id', Auth::id())->exists() ? 'color: var(--primary-red);' : '' }}"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="article-social-link" title="Simpan ke Favorit">
                        <i class="far fa-bookmark"></i>
                    </a>
                @endauth
            </div>

            <!-- Content Area -->
            <div class="article-content">
                <div class="article-formatted-content">
                    {!! $artikel->isi !!}
                </div>

                @if($artikel->foto_pendukung)
                <div class="article-inline-images">
                    <img src="{{ filter_var($artikel->foto_pendukung, FILTER_VALIDATE_URL) ? $artikel->foto_pendukung : asset($artikel->foto_pendukung) }}" alt="{{ $artikel->judul }}" style="width: 100%; border-radius: 8px;">
                </div>
                @endif

                <!-- Tags and Share -->
                <div class="article-footer-tags">
                    <div class="article-tags">
                        @if($artikel->keywords)
                            @foreach(explode(',', $artikel->keywords) as $keyword)
                                @if(trim($keyword))
                                    <span class="article-tag-pill">{{ strtoupper(trim($keyword)) }}</span>
                                @endif
                            @endforeach
                        @else
                            <span class="article-tag-pill">{{ strtoupper($artikel->kategori) }}</span>
                        @endif
                    </div>
                    <div class="article-share-text">
                        SHARE ARTICLE
                        <div class="article-share-icons">
                            <a href="https://wa.me/?text={{ urlencode($artikel->judul . ' - ' . url('/post/' . $artikel->slug)) }}" target="_blank" title="Bagikan ke WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://instagram.com" target="_blank" title="Buka Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Articles -->
        <section class="related-articles-section">
            <div class="related-header">
                <h3 class="related-title">Baca Artikel Lainnya</h3>
                <a href="{{ url('/artikel') }}" class="related-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="related-grid">
                @forelse($otherArticles as $other)
                <a href="{{ url('/post/' . $other->slug) }}" class="related-card">
                    <img src="{{ filter_var($other->foto_utama, FILTER_VALIDATE_URL) ? $other->foto_utama : asset($other->foto_utama) }}" alt="{{ $other->judul }}">
                    <span class="cat-badge">{{ strtoupper($other->kategori) }}</span>
                    <h4>{{ $other->judul }}</h4>
                </a>
                @empty
                <p style="grid-column: span 3; text-align: center; color: var(--text-muted);">Belum ada artikel lainnya.</p>
                @endforelse
            </div>
        </section>

    </main>

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

</body>
</html>
