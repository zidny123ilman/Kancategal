<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->judul }} - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Detail E-Book {{ $ebook->judul }} oleh {{ $ebook->penulis }}. {{ Str::limit($ebook->sinopsis, 150) }}">
    <meta name="keywords" content="{{ $ebook->judul }}, {{ $ebook->penulis }}, {{ $ebook->kategori }}, ebook, Kanca Tegal">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        /* Hide scrollbars for sliding container */
        #resensi-slider-container::-webkit-scrollbar {
            display: none;
        }
        
        /* Resensi card responsive layout */
        .resensi-card {
            flex: 0 0 calc((100% - 4.5rem) / 4); /* 4 cards on PC, with 3 gaps of 1.5rem */
            background-color: var(--bg-theme);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px;
            transition: var(--transition-smooth);
            box-sizing: border-box;
            scroll-snap-align: start;
        }
        
        @media (max-width: 1024px) {
            .resensi-card {
                flex: 0 0 calc((100% - 3rem) / 3); /* 3 cards on tablet */
            }
        }
        
        @media (max-width: 768px) {
            .resensi-card {
                flex: 0 0 calc((100% - 1.5rem) / 2); /* 2 cards on small tablet */
            }
        }
        
        @media (max-width: 480px) {
            .resensi-card {
                flex: 0 0 100%; /* 1 card on mobile */
            }
        }

        /* E-Book Badge and Progress bar styling */
        .progress-bar-wrapper {
            background-color: var(--border-color);
            border-radius: 9999px;
            height: 8px;
            width: 100%;
            overflow: hidden;
            margin-top: 0.5rem;
        }
        .progress-bar-fill {
            background-color: #1a56db;
            height: 100%;
            border-radius: 9999px;
            transition: width 0.3s ease;
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
                <img src="{{ Storage::url($ebook->cover) }}" alt="{{ $ebook->judul }} Cover" class="book-cover-large">
                
                <div class="book-status-card" style="border-color: #1a56db;">
                    <span class="status-label" style="color: #1a56db;">E-BOOK DIGITAL</span>
                    <span class="status-value" style="color: #1a56db;">
                        <i class="fas fa-laptop"></i> AKSES INSTAN
                    </span>
                </div>
            </div>

            <!-- Right Side: Info & Actions -->
            <div class="book-detail-right">
                <div class="breadcrumb">
                    <a href="{{ url('/ebook') }}" style="text-decoration: underline;">KATALOG E-BOOK</a> <i class="fas fa-chevron-right" style="font-size:0.5rem; margin: 0 0.5rem;"></i> 
                    <span>{{ strtoupper($ebook->kategori) }}</span> <i class="fas fa-chevron-right" style="font-size:0.5rem; margin: 0 0.5rem;"></i> 
                    <span>{{ strtoupper($ebook->judul) }}</span>
                </div>

                <h1 class="detail-title">{{ $ebook->judul }}</h1>

                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">PENULIS</span>
                        <span class="meta-value">{{ $ebook->penulis }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">PENERBIT</span>
                        <span class="meta-value">{{ $ebook->penerbit }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">HALAMAN</span>
                        <span class="meta-value">{{ $ebook->jumlah_halaman }} Halaman</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">TAHUN TERBIT</span>
                        <span class="meta-value">{{ $ebook->tahun_terbit }}</span>
                    </div>
                    @if($ebook->isbn)
                    <div class="meta-item">
                        <span class="meta-label">ISBN</span>
                        <span class="meta-value">{{ $ebook->isbn }}</span>
                    </div>
                    @endif
                    <div class="meta-item">
                        <span class="meta-label">DURASI PINJAM</span>
                        <span class="meta-value">7 Hari</span>
                    </div>
                </div>

                <blockquote class="detail-quote">
                    {{ $ebook->sinopsis }}
                </blockquote>

                @if($activeLoan)
                    <!-- Active Borrow Box -->
                    <div style="background-color: #f4f8f5; border: 1.5px solid #1a56db; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
                        <span style="font-size: 0.75rem; font-weight: 800; color: #1a56db; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">STATUS PINJAMAN AKTIF</span>
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-dark); margin-bottom: 1rem;">
                            <i class="far fa-calendar-alt"></i> Masa akses berlaku hingga: <strong>{{ \Carbon\Carbon::parse($activeLoan->tanggal_jatuh_tempo)->format('d-m-Y') }}</strong>
                        </p>
                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">
                                <span>Progress Membaca</span>
                                <span>{{ $activeLoan->progress_persen }}% (Hlm. {{ $activeLoan->last_page }}/{{ $ebook->jumlah_halaman }})</span>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" style="width: {{ $activeLoan->progress_persen }}%;"></div>
                            </div>
                        </div>
                        <a href="{{ url('/ebook/' . $ebook->id . '/read') }}" class="btn-main-action" style="background-color: #1a56db; border-color: #1a56db; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: auto; min-width: 220px; font-weight: 700;">
                            <i class="fas fa-book-open"></i> BACA SEKARANG
                        </a>
                    </div>
                @else
                    <div class="action-buttons">
                        @auth
                            <form action="{{ route('ebook.pinjam', $ebook->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-main-action" style="background-color: #1a56db; border-color: #1a56db;">
                                    <i class="fas fa-book-reader"></i> PINJAM E-BOOK
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/login') }}" class="btn-main-action" style="background-color: #1a56db; border-color: #1a56db; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-sign-in-alt"></i> LOGIN UNTUK MEMINJAM
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </section>

        <!-- Stats Section -->
        <section style="margin: 4rem 3rem 0; padding: 2.5rem; background-color: var(--bg-white); border: 2px solid var(--border-color); border-radius: 12px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center;">
            <div>
                <span style="font-size: 2.2rem; font-weight: 800; color: #1a56db; display: block;">{{ $totalBorrowed }}x</span>
                <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Kali Dipinjam</span>
            </div>
            <div>
                <span style="font-size: 2.2rem; font-weight: 800; color: #1a56db; display: block;">{{ $totalReaders }}</span>
                <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Jumlah Pembaca</span>
            </div>
            <div>
                <span style="font-size: 2.2rem; font-weight: 800; color: #f59e0b; display: block;">{{ number_format($averageRating, 1) }} ★</span>
                <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata Rating</span>
            </div>
            <div>
                <span style="font-size: 2.2rem; font-weight: 800; color: #ec4899; display: block;">{{ number_format($averageProgress, 1) }}%</span>
                <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Progress Membaca</span>
            </div>
        </section>

        <!-- Member reviews Section -->
        <section class="resensi-section" style="margin-top: 4rem;">
            <div class="section-title-area" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 1rem;">
                <div class="title-group-inline">
                    <span class="title-tag">MEMBER FEEDBACK</span>
                    <h2 class="title-main" style="font-size: 2rem; font-weight: 800;">Resensi Anggota</h2>
                </div>
            </div>

            <!-- Resensi Cards Slider Container -->
            <div id="resensi-slider-container" style="display: flex; gap: 1.5rem; overflow-x: auto; scroll-snap-type: x mandatory; padding: 0.5rem 0 2rem; width: 100%;">
                @forelse($reviews as $review)
                    <div class="resensi-card">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span style="font-size: 0.85rem; font-weight: 800; color: var(--text-dark);">{{ $review->user->name }}</span>
                                <span style="font-size: 0.75rem; color: #f59e0b; font-weight: 700;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </span>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; font-style: italic; white-space: normal;">
                                "{{ Str::limit($review->review, 250) }}"
                            </p>
                        </div>
                        <div style="margin-top: 1rem; font-size: 0.7rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">
                            {{ \Carbon\Carbon::parse($review->review_at)->format('d M Y') }}
                        </div>
                    </div>
                @empty
                    <div style="width: 100%; text-align: center; color: var(--text-muted); padding: 3rem 0;">
                        <i class="far fa-comment-dots" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; color: var(--border-color);"></i>
                        Belum ada ulasan untuk E-Book ini. Jadilah yang pertama memberikan resensi!
                    </div>
                @endforelse
            </div>
        </section>
    </main>

</body>
</html>
