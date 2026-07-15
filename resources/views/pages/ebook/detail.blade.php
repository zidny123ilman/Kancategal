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
        /* ============================
           PROGRESS BAR
        ============================ */
        .progress-bar-wrapper {
            background-color: var(--border-color);
            border-radius: 9999px;
            height: 8px; width: 100%; overflow: hidden; margin-top: 0.5rem;
        }
        .progress-bar-fill {
            background-color: #1a56db;
            height: 100%; border-radius: 9999px;
            transition: width 0.3s ease;
        }

        /* ============================
           STATUS INFO BOX
        ============================ */
        .ebook-status-box {
            border-radius: 10px; padding: 1.25rem 1.5rem; margin-bottom: 1.75rem;
        }
        .ebook-status-box .status-tag {
            font-size: 0.72rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;
        }
        .ebook-status-box .status-body {
            font-size: 0.88rem; font-weight: 600; color: var(--text-dark);
        }
        .box-menunggu  { background: #FEF3C7; border: 1.5px solid #D97706; }
        .box-menunggu .status-tag { color: #92400E; }
        .box-active    { background: #EEF2FF; border: 1.5px solid #1a56db; }
        .box-active .status-tag { color: #1a56db; }

        /* ============================
           STATS SECTION MOBILE
        ============================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
            background-color: var(--bg-white);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 2.5rem;
        }
        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
                padding: 1.5rem;
            }
            .stats-grid .stat-number { font-size: 1.6rem !important; }
        }

        /* ============================
           RESENSI SECTION
        ============================ */
        .resensi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        @media (max-width: 1024px) { .resensi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px)  { .resensi-grid { grid-template-columns: 1fr; gap: 1rem; } }

        .resensi-card {
            background-color: var(--bg-white);
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: var(--transition-smooth);
        }
        .resensi-card:hover {
            border-color: #1a56db;
            box-shadow: 0 4px 12px rgba(26,86,219,0.08);
        }
        .resensi-stars { color: #f59e0b; font-size: 0.82rem; }
        .resensi-text {
            font-size: 0.85rem; color: var(--text-muted);
            line-height: 1.65; font-style: italic;
            margin: 0.75rem 0; flex-grow: 1;
        }
        .resensi-meta {
            font-size: 0.7rem; font-weight: 800;
            color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 0.5px; border-top: 1px solid var(--border-color);
            padding-top: 0.75rem; margin-top: 0.75rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .resensi-author { font-size: 0.82rem; font-weight: 800; color: var(--text-dark); }

        /* ============================
           MOBILE DETAIL LAYOUT
        ============================ */
        @media (max-width: 768px) {
            /* Flash messages on mobile */
            .flash-msg { margin: 1rem 1rem 0 !important; }

            /* Detail section stacks to column */
            .book-detail-section {
                flex-direction: column !important;
                padding: 1.5rem 1rem !important;
                gap: 1.5rem !important;
            }
            .book-detail-left {
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
            }
            .book-cover-large {
                max-width: 180px !important;
                margin: 0 auto !important;
            }
            .book-status-card { width: 100% !important; max-width: 280px !important; }
            .book-detail-right { width: 100% !important; }

            /* Breadcrumb wraps */
            .breadcrumb {
                font-size: 0.72rem !important;
                flex-wrap: wrap !important;
                word-break: break-word !important;
            }
            .detail-title { font-size: 1.4rem !important; }

            /* Meta grid 2 cols */
            .meta-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.75rem !important;
            }

            /* Action btn full width */
            .btn-main-action {
                width: 100% !important;
                min-width: unset !important;
            }

            /* Stats */
            .stats-section { margin: 2rem 1rem 0 !important; }

            /* Reviews */
            .resensi-section { margin-top: 2.5rem !important; }
            .resensi-section-inner { padding: 0 1rem !important; }

            /* Section header */
            .section-title-area { flex-direction: column !important; align-items: flex-start !important; gap: 0.5rem !important; }
        }

        @media (max-width: 480px) {
            .book-cover-large { max-width: 140px !important; }
            .detail-title { font-size: 1.2rem !important; }
            .meta-grid { grid-template-columns: 1fr 1fr !important; }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="flash-msg" style="background-color: #E6F4EA; border-left: 4px solid #137333; color: #137333; padding: 1rem; border-radius: 6px; margin: 1.5rem 3rem 0; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flash-msg" style="background-color: rgba(192, 30, 46, 0.1); border-left: 4px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 6px; margin: 1.5rem 3rem 0; font-size: 0.9rem; font-weight: 600;">
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
                        <i class="fas fa-laptop"></i> AKSES DIGITAL
                    </span>
                </div>
            </div>

            <!-- Right Side: Info & Actions -->
            <div class="book-detail-right">
                <div class="breadcrumb">
                    <a href="{{ url('/ebook') }}" style="text-decoration: underline;">KATALOG E-BOOK</a>
                    <i class="fas fa-chevron-right" style="font-size:0.5rem; margin: 0 0.5rem;"></i>
                    <span>{{ strtoupper($ebook->kategori) }}</span>
                    <i class="fas fa-chevron-right" style="font-size:0.5rem; margin: 0 0.5rem;"></i>
                    <span>{{ strtoupper($ebook->judul) }}</span>
                </div>

                <h1 class="detail-title">{{ $ebook->judul }}</h1>

                @php
                    $loanDuration = (int) \App\Models\Setting::get('ebook_loan_duration', 7);
                @endphp
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
                        <span class="meta-value">{{ $loanDuration }} Hari</span>
                    </div>
                </div>

                <blockquote class="detail-quote">
                    {{ $ebook->sinopsis }}
                </blockquote>

                {{-- Status: Pinjaman Aktif --}}
                @if($activeLoan)
                    <div class="ebook-status-box box-active">
                        <span class="status-tag">STATUS PINJAMAN AKTIF</span>
                        <p class="status-body">
                            <i class="far fa-calendar-alt"></i>
                            Masa akses berlaku hingga: <strong>{{ \Carbon\Carbon::parse($activeLoan->tanggal_jatuh_tempo)->format('d-m-Y') }}</strong>
                        </p>
                        <div style="margin: 1rem 0 1.25rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">
                                <span>Progress Membaca</span>
                                <span>{{ $activeLoan->progress_persen }}% (Hlm. {{ $activeLoan->last_page }}/{{ $ebook->jumlah_halaman }})</span>
                            </div>
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-fill" style="width: {{ $activeLoan->progress_persen }}%;"></div>
                            </div>
                        </div>
                        <a href="{{ url('/ebook/' . $ebook->id . '/read') }}" class="btn-main-action" style="background-color: #1a56db; border-color: #1a56db; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-weight: 700;">
                            <i class="fas fa-book-open"></i> BACA SEKARANG
                        </a>
                    </div>

                {{-- Status: Menunggu Konfirmasi --}}
                @elseif($pendingLoan)
                    <div class="ebook-status-box box-menunggu">
                        <span class="status-tag"><i class="fas fa-clock"></i> MENUNGGU KONFIRMASI ADMIN</span>
                        <p class="status-body">
                            Permintaan peminjaman E-Book ini sedang dalam proses review oleh admin.
                            Anda akan mendapat notifikasi WhatsApp setelah disetujui.
                        </p>
                        <p style="font-size: 0.78rem; color: #92400E; margin-top: 0.5rem; font-weight: 600;">
                            <i class="fas fa-calendar-alt"></i>
                            Diajukan: {{ \Carbon\Carbon::parse($pendingLoan->created_at)->format('d M Y, H:i') }} WIB
                        </p>
                    </div>

                {{-- Status: Belum Pinjam --}}
                @else
                    <div class="action-buttons">
                        @auth
                            <form action="{{ route('ebook.pinjam', $ebook->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-main-action" style="background-color: #1a56db; border-color: #1a56db;">
                                    <i class="fas fa-book-reader"></i> AJUKAN PINJAM E-BOOK
                                </button>
                            </form>
                            <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.75rem; font-weight: 600;">
                                <i class="fas fa-info-circle"></i> Permintaan akan dikonfirmasi oleh admin. Durasi pinjam: <strong>{{ $loanDuration }} hari</strong>.
                            </p>
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
        <section class="stats-section" style="margin: 4rem 3rem 0;">
            <div class="stats-grid">
                <div>
                    <span class="stat-number" style="font-size: 2.2rem; font-weight: 800; color: #1a56db; display: block;">{{ $totalBorrowed }}x</span>
                    <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Kali Dipinjam</span>
                </div>
                <div>
                    <span class="stat-number" style="font-size: 2.2rem; font-weight: 800; color: #1a56db; display: block;">{{ $totalReaders }}</span>
                    <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Jumlah Pembaca</span>
                </div>
                <div>
                    <span class="stat-number" style="font-size: 2.2rem; font-weight: 800; color: #f59e0b; display: block;">{{ number_format($averageRating, 1) }} ★</span>
                    <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Rata-rata Rating</span>
                </div>
                <div>
                    <span class="stat-number" style="font-size: 2.2rem; font-weight: 800; color: #ec4899; display: block;">{{ number_format($averageProgress, 1) }}%</span>
                    <span style="font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Progress Membaca</span>
                </div>
            </div>
        </section>

        <!-- Resensi / Reviews Section -->
        <section class="resensi-section" style="margin-top: 4rem; padding-bottom: 4rem;">
            <div class="resensi-section-inner" style="padding: 0 3rem;">
                <div class="section-title-area" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 1rem;">
                    <div class="title-group-inline">
                        <span class="title-tag">MEMBER FEEDBACK</span>
                        <h2 class="title-main" style="font-size: 2rem; font-weight: 800;">Resensi Anggota</h2>
                    </div>
                    @if($reviews->count() > 0)
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted);">{{ $reviews->count() }} Ulasan</span>
                    @endif
                </div>

                @if($reviews->count() > 0)
                    <div class="resensi-grid">
                        @foreach($reviews as $review)
                            <div class="resensi-card">
                                <!-- Header: nama + bintang -->
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <span class="resensi-author">{{ $review->user->name }}</span>
                                    <span class="resensi-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </span>
                                </div>
                                <!-- Teks ulasan -->
                                <p class="resensi-text">"{{ Str::limit($review->review, 200) }}"</p>
                                <!-- Footer: tanggal -->
                                <div class="resensi-meta">
                                    <span><i class="far fa-calendar-alt" style="margin-right: 4px;"></i>{{ \Carbon\Carbon::parse($review->review_at)->format('d M Y') }}</span>
                                    <span style="background-color: #f59e0b20; color: #92400E; padding: 2px 8px; border-radius: 9999px; font-size: 0.68rem;">
                                        {{ $review->rating }}/5 ★
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; color: var(--text-muted); padding: 3rem 1rem;">
                        <i class="far fa-comment-dots" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; color: var(--border-color);"></i>
                        <p style="font-weight: 600;">Belum ada ulasan untuk E-Book ini. Jadilah yang pertama memberikan resensi!</p>
                    </div>
                @endif
            </div>
        </section>
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
                    &copy; 2026 THE MODERN ARCHIVIST. HAK CIPTA DILINDUNGI. Support by @tegal.itsolutions
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
