<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }} - Platform Komunitas Literasi</title>

    <!-- Meta Tags SEO -->
    <meta name="description"
        content="Kanca Tegal adalah platform komunitas yang berdedikasi pada pelestarian kearifan lokal dan pengembangan diskusi literasi modern di Tegal.">
    <meta name="keywords"
        content="Kanca Tegal, literasi, komunitas Tegal, perpustakaan Tegal, buku mingguan, diskusi budaya">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- Scoped styles for horizontal sliders -->
    <style>
        .slider-outer-wrapper {
            position: relative;
            width: 100%;
        }

        .slider-inner-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            gap: 2rem;
            padding: 1rem 0.5rem 2rem 0.5rem;
            margin: 0 -0.5rem;
            scrollbar-width: none;
            /* Firefox */
        }

        .slider-inner-container::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .slider-inner-container .article-card,
        .slider-inner-container .review-card,
        .slider-inner-container .book-card {
            flex: 0 0 100%;
            scroll-snap-align: start;
            box-sizing: border-box;
        }

        @media (min-width: 768px) {
            .slider-inner-container .article-card {
                flex: 0 0 calc(50% - 1rem);
            }

            .slider-inner-container .review-card {
                flex: 0 0 calc(50% - 1rem);
            }

            .slider-inner-container .book-card {
                flex: 0 0 calc(50% - 1rem);
            }
        }

        @media (min-width: 1024px) {
            .slider-inner-container .article-card {
                flex: 0 0 calc(33.333% - 1.333rem);
            }

            .slider-inner-container .review-card {
                flex: 0 0 calc(50% - 1rem);
            }

            .slider-inner-container .book-card {
                flex: 0 0 calc(25% - 1.5rem);
            }
        }

        .nav-arrow-btn {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-smooth);
            color: var(--text-dark);
        }

        .nav-arrow-btn:hover {
            background: var(--primary-red);
            color: var(--text-light);
            border-color: var(--primary-red);
        }
    </style>
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

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-content">
                    <span class="hero-badge">{{ __('COMMUNITY PLATFORM') }}</span>
                    <h1 class="hero-title">{!! nl2br(e(\App\Models\Setting::get('hero_title', "KANCA\nTEGAL"))) !!}</h1>
                    <p class="hero-description">
                        {{ \App\Models\Setting::get('hero_subtitle', 'A creative community that dedicated to the preservation of local wisdom and the cultivation of modern literacy discussion in Tegal.') }}
                    </p>
                    <div class="hero-buttons">
                        <button class="btn-explore">{{ __('EXPLORE MORE') }}</button>
                        <a href="{{ url('/register') }}" class="btn-register"
                            style="display: inline-block; text-align: center;">{{ __('Register Member') }}</a>
                    </div>
                </div>

                <div class="hero-image-wrapper">
                    <div class="hero-image-container">
                        @php
                            $heroImage = \App\Models\Setting::get('hero_image', 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=1000');
                        @endphp
                        @if(str_starts_with($heroImage, 'http'))
                            <img src="{{ $heroImage }}" alt="Membaca Buku Bersama" class="hero-image">
                        @else
                            <img src="{{ asset($heroImage) }}" alt="Membaca Buku Bersama" class="hero-image">
                        @endif
                    </div>
                    <div class="hero-card-overlay">
                        <p>"{{ \App\Models\Setting::get('schedule_info', 'Kanca Tegal library open everyday on 09.00-18.00.') }}"
                        </p>
                        <a href="{{ url('/about#visit-us') }}" style="text-decoration: none; color: inherit;">
                            <span>{{ __('Visit Us Today') }} &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Weekly Books Section -->
        <section class="section">
            <div class="section-container">
                <div class="section-header">
                    <div class="section-title-wrapper">
                        <span class="section-tag">{{ __('WHAT WE READ THIS WEEK') }}</span>
                        <h2 class="section-title">{{ __('Weekly Books') }}</h2>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 1rem;">
                        <a href="{{ url('/buku') }}" class="section-link">
                            {{ __('View All Books') }} <i class="fas fa-arrow-right"></i>
                        </a>
                        @if(count($weeklyBooks) > 0)
                            <div class="slider-navigation" style="display: flex; gap: 0.5rem;">
                                <button class="nav-arrow-btn" id="books-prev"><i class="fas fa-arrow-left"></i></button>
                                <button class="nav-arrow-btn" id="books-next"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="slider-outer-wrapper">
                    <div class="slider-inner-container" id="books-slider">
                        @forelse ($weeklyBooks as $buku)
                        <!-- Book -->
                        <article class="book-card" onclick="window.location.href = '{{ url('/detailbuku/' . $buku->id) }}';"
                            style="cursor: pointer;">
                            <div class="book-image-wrapper">
                                @if(str_starts_with($buku->foto, 'http'))
                                    <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image">
                                @else
                                    <img src="{{ asset($buku->foto) }}" alt="{{ $buku->judul }}" class="book-image">
                                @endif
                            </div>
                            <span class="book-category">{{ $buku->kategori }}</span>
                            <h3 class="book-title">{{ $buku->judul }}</h3>
                            <p class="book-description">{{ Str::limit($buku->sinopsis, 120) }}</p>
                        </article>
                    @empty
                        <div
                            style="text-align: center; color: var(--text-muted); padding: 3rem; background: var(--bg-white); border-radius: 12px; border: 1px solid var(--border-color); width: 100%; flex: 0 0 100%;">
                            <i class="fas fa-book" style="font-size: 2rem; color: #C8D4CE; margin-bottom: 0.5rem;"></i>
                            <p style="font-size: 0.9rem; font-weight: 600;">{{ __('Belum ada buku tersedia minggu ini.') }}
                            </p>
                        </div>
                    @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="section" style="background-color: var(--bg-theme);">
            <div class="section-container about-grid">
                <div class="about-images">
                    <div class="about-img-container">
                        <img src="{{ asset('storage/background2.jpg') }}" alt="Diskusi Komunitas" class="about-img">
                    </div>
                    <div class="about-img-container">
                        <img src="{{ asset('storage/bg1.jpg') }}"
                            alt="Rak Buku Perpustakaan" class="about-img">
                    </div>
                </div>

                <div class="about-content">
                    <span class="section-tag">{{ __('OUR JOURNEY') }}</span>
                    <h2 class="section-title" style="margin-bottom: 1.5rem;">{{ __('About Kanca Tegal') }}</h2>
                    <p class="about-description">
                        {{ __('KANCA TEGAL was born from a community of local youths who believe that literacy is the key to progress and growth in Tegal. Founded on the principles of collaboration and creativity, we bridge the gap between traditional wisdom and modern literacy in this digital age.') }}
                    </p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ number_format($totalBuku, 0, ',', '.') }}</span>
                            <span class="stat-label">{{ __('Books') }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ number_format($totalAnggota, 0, ',', '.') }}</span>
                            <span class="stat-label">{{ __('Members') }}</span>
                        </div>
                    </div>
                    <a href="{{ url('/about') }}" class="btn-story" id="btn-about-story"
                        style="display: inline-block; text-decoration: none; text-align: center;">{{ __('Our Full Story') }}
                        &rarr;</a>
                </div>
            </div>
        </section>

        <!-- Article Notes Section -->
        <section class="section">
            <div class="section-container">
                <div class="section-header">
                    <div class="section-title-wrapper">
                        <span class="section-tag">{{ __('THE JOURNAL') }}</span>
                        <h2 class="section-title">{{ __('Article Notes') }}</h2>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 1rem;">
                        <a href="{{ url('/artikel') }}" class="section-link">
                            {{ __('Lihat Artikel lainnya') }} <i class="fas fa-arrow-right"></i>
                        </a>
                        @if($articles->count() > 0)
                            <div class="slider-navigation" style="display: flex; gap: 0.5rem;">
                                <button class="nav-arrow-btn" id="art-prev"><i class="fas fa-arrow-left"></i></button>
                                <button class="nav-arrow-btn" id="art-next"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="slider-outer-wrapper">
                    <div class="slider-inner-container" id="articles-slider">
                        @forelse ($articles as $art)
                            <div class="article-card">
                                <div
                                    class="article-icon-wrapper {{ strtolower($art->kategori) === 'essay' ? 'icon-essay' : (strtolower($art->kategori) === 'news' ? 'icon-news' : 'icon-review') }}">
                                    @if (strtolower($art->kategori) === 'essay')
                                        <i class="fas fa-feather-alt"></i>
                                    @elseif (strtolower($art->kategori) === 'news')
                                        <i class="fas fa-globe-asia"></i>
                                    @else
                                        <i class="fas fa-archive"></i>
                                    @endif
                                </div>
                                <div class="article-meta">
                                    <span class="article-tag">{{ strtoupper($art->kategori) }}</span>
                                    <span
                                        class="article-badge {{ strtolower($art->kategori) === 'essay' ? 'badge-essay' : (strtolower($art->kategori) === 'news' ? 'badge-news' : 'badge-review') }}">READ</span>
                                </div>
                                <h3 class="article-title">
                                    <a href="{{ url('/detailartikel/' . $art->slug) }}">
                                        {{ $art->judul }}
                                    </a>
                                </h3>
                                <p class="article-description">{{ Str::limit($art->isi, 120) }}</p>
                                <a href="{{ url('/detailartikel/' . $art->slug) }}" class="article-link">
                                    {{ __('Read More') }} <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <div
                                style="text-align: center; color: var(--text-muted); padding: 3rem; background: var(--bg-white); border-radius: 12px; border: 1px solid var(--border-color); width: 100%; flex: 0 0 100%;">
                                <i class="far fa-file-alt"
                                    style="font-size: 2rem; color: #C8D4CE; margin-bottom: 0.5rem; display: block;"></i>
                                <p style="font-size: 0.9rem; font-weight: 600;">
                                    {{ __('Belum ada artikel tersedia saat ini.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <!-- Community Reviews Section -->
        <section class="section" style="background-color: var(--bg-theme);">
            <div class="section-container">
                <div class="section-header"
                    style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div class="section-title-wrapper">
                        <span class="section-tag">{{ __('WHAT THEY ARE SAYING') }}</span>
                        <h2 class="section-title">{{ __('Community Reviews') }}</h2>
                    </div>
                    @if($reviews->count() > 0)
                        <div class="slider-navigation" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <button class="nav-arrow-btn" id="rev-prev"><i class="fas fa-arrow-left"></i></button>
                            <button class="nav-arrow-btn" id="rev-next"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    @endif
                </div>

                <div class="slider-outer-wrapper">
                    <div class="slider-inner-container" id="reviews-slider">
                        @forelse ($reviews as $rev)
                            <div class="review-card">
                                <span class="quote-icon">“</span>
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rev->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star" style="color: #D1DCD5;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <blockquote class="review-text">
                                    "{{ $rev->isi }}"
                                </blockquote>
                                <div class="review-author">
                                    @php
                                        $avatarUrl = $rev->user_id
                                            ? 'https://ui-avatars.com/api/?name=' . urlencode($rev->user->name) . '&background=C8D4CE&color=1E2E25'
                                            : $rev->avatar;
                                        $authorName = $rev->user_id ? $rev->user->name : $rev->nama;
                                        $authorRole = $rev->user_id ? 'Active Member' : $rev->peran;
                                    @endphp
                                    <img src="{{ $avatarUrl }}" alt="{{ $authorName }}" class="author-avatar">
                                    <div class="author-info">
                                        <span class="author-name">{{ $authorName }}</span>
                                        <span class="author-role">{{ $authorRole }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                style="text-align: center; color: var(--text-muted); padding: 3rem; background: var(--bg-white); border-radius: 12px; border: 1px solid var(--border-color); width: 100%; flex: 0 0 100%;">
                                <p style="font-size: 0.9rem; font-weight: 600;">
                                    {{ __('Belum ada ulasan komunitas saat ini.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                @auth
                    <!-- Add Review Form -->
                    <div
                        style="margin-top: 4rem; max-width: 600px; margin-left: auto; margin-right: auto; background: var(--bg-white); padding: 2.5rem; border-radius: 16px; box-shadow: var(--shadow-md); border: 1px solid rgba(0, 0, 0, 0.02);">
                        <h3
                            style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--text-dark); text-align: center;">
                            {{ __('Tulis Ulasan Anda') }}</h3>

                        <form action="{{ url('/review') }}" method="POST" id="review-form">
                            @csrf

                            <!-- Star Rating Selector -->
                            <div style="margin-bottom: 1.5rem; text-align: center;">
                                <label
                                    style="display: block; font-size: 0.9rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('Pilih Rating Anda') }}</label>
                                <div class="star-rating-input"
                                    style="display: inline-flex; gap: 8px; font-size: 2rem; color: #D1DCD5; cursor: pointer;">
                                    <i class="far fa-star star-btn" data-value="1"></i>
                                    <i class="far fa-star star-btn" data-value="2"></i>
                                    <i class="far fa-star star-btn" data-value="3"></i>
                                    <i class="far fa-star star-btn" data-value="4"></i>
                                    <i class="far fa-star star-btn" data-value="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating-value" value="" required>
                                @error('rating')
                                    <span
                                        style="display: block; color: var(--primary-red); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Review text -->
                            <div style="margin-bottom: 1.5rem;">
                                <label for="isi"
                                    style="display: block; font-size: 0.9rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem;">{{ __('Ulasan Anda') }}</label>
                                <textarea name="isi" id="isi" rows="4"
                                    placeholder="{{ __('Bagikan pengalaman Anda bersama Kanca Tegal...') }}"
                                    style="width: 100%; padding: 1rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.95rem; font-family: var(--font-main); color: var(--text-dark); outline: none; resize: vertical; transition: var(--transition-smooth);"
                                    required>{{ old('isi') }}</textarea>
                                @error('isi')
                                    <span
                                        style="display: block; color: var(--primary-red); font-size: 0.8rem; margin-top: 5px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn-story"
                                style="width: 100%; border-radius: 8px; padding: 1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('Kirim Ulasan') }}</button>
                        </form>
                    </div>
                @else
                    <!-- Login Prompt -->
                    <div
                        style="margin-top: 4rem; text-align: center; background: var(--bg-white); padding: 3rem 2rem; border-radius: 16px; box-shadow: var(--shadow-sm); border: 1px solid rgba(0, 0, 0, 0.02); max-width: 600px; margin-left: auto; margin-right: auto;">
                        <i class="fas fa-lock"
                            style="font-size: 2.5rem; color: #C8D4CE; margin-bottom: 1rem; display: block;"></i>
                        <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-dark);">
                            {{ __('Bagikan Pengalaman Anda') }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
                            {{ __('Silakan masuk (login) terlebih dahulu untuk dapat menulis ulasan komunitas.') }}</p>
                        <a href="{{ url('/login') }}" class="btn-signin"
                            style="display: inline-block; padding: 0.8rem 2rem;">{{ __('Masuk Sekarang') }}</a>
                    </div>
                @endauth
            </div>
        </section>
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

    <!-- Script to handle article clicks and pass full data to detail page -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Smooth scroll for explore more button
            const btnExplore = document.querySelector('.btn-explore');
            if (btnExplore) {
                btnExplore.addEventListener('click', (e) => {
                    e.preventDefault();
                    const nextSection = document.querySelector('.hero-section').nextElementSibling;
                    if (nextSection) {
                        nextSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            // Slider/Carousel scroll logic
            function setupSlider(containerId, prevBtnId, nextBtnId) {
                const container = document.getElementById(containerId);
                const prevBtn = document.getElementById(prevBtnId);
                const nextBtn = document.getElementById(nextBtnId);

                if (container && prevBtn && nextBtn) {
                    prevBtn.addEventListener('click', () => {
                        const firstCard = container.querySelector('.article-card, .review-card');
                        if (firstCard) {
                            const cardWidth = firstCard.offsetWidth;
                            container.scrollBy({ left: -cardWidth - 32, behavior: 'smooth' }); // card width + gap
                        }
                    });

                    nextBtn.addEventListener('click', () => {
                        const firstCard = container.querySelector('.article-card, .review-card');
                        if (firstCard) {
                            const cardWidth = firstCard.offsetWidth;
                            container.scrollBy({ left: cardWidth + 32, behavior: 'smooth' }); // card width + gap
                        }
                    });
                }
            }

            setupSlider('books-slider', 'books-prev', 'books-next');
            setupSlider('articles-slider', 'art-prev', 'art-next');
            setupSlider('reviews-slider', 'rev-prev', 'rev-next');

            // Star rating selection logic
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('rating-value');

            if (stars.length > 0 && ratingInput) {
                stars.forEach(star => {
                    star.addEventListener('mouseover', () => {
                        const val = parseInt(star.getAttribute('data-value'));
                        highlightStars(val);
                    });

                    star.addEventListener('mouseout', () => {
                        const currentRating = ratingInput.value ? parseInt(ratingInput.value) : 0;
                        highlightStars(currentRating);
                    });

                    star.addEventListener('click', () => {
                        const val = parseInt(star.getAttribute('data-value'));
                        ratingInput.value = val;
                        highlightStars(val);
                    });
                });
            }

            function highlightStars(val) {
                stars.forEach(s => {
                    const starVal = parseInt(s.getAttribute('data-value'));
                    if (starVal <= val) {
                        s.classList.remove('far', 'fa-star');
                        s.classList.add('fas', 'fa-star');
                        s.style.color = '#F59E0B'; // Gold color
                    } else {
                        s.classList.remove('fas', 'fa-star');
                        s.classList.add('far', 'fa-star');
                        s.style.color = '#D1DCD5'; // Default color
                    }
                });
            }
        });
    </script>

    @php
        $popupStatus = \App\Models\Setting::get('popup_status', '0');
        $popupActiveType = \App\Models\Setting::get('popup_active_type', 'buka');
        $popupImage = ($popupActiveType === 'buka')
            ? \App\Models\Setting::get('popup_buka_image', '')
            : \App\Models\Setting::get('popup_tutup_image', '');
    @endphp

    @if($popupStatus === '1' && !empty($popupImage))
        <!-- Landing Page Popup Modal -->
        <div id="landingPopupModal" class="popup-modal-overlay" style="display: none;">
            <div class="popup-modal-container">
                <button class="popup-modal-close-btn" onclick="closeLandingPopup()">&times;</button>
                <div class="popup-modal-content">
                    <img src="{{ asset($popupImage) }}" alt="Pengumuman Kanca Tegal" class="popup-modal-img">
                </div>
            </div>
        </div>

        <style>
            .popup-modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.75);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                z-index: 99999;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.4s ease;
                padding: 1.5rem;
            }

            .popup-modal-overlay.show {
                opacity: 1;
            }

            .popup-modal-container {
                position: relative;
                max-width: 600px;
                width: 100%;
                background: #ffffff;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                transform: scale(0.8);
                transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .popup-modal-overlay.show .popup-modal-container {
                transform: scale(1);
            }

            .popup-modal-close-btn {
                position: absolute;
                top: 15px;
                right: 15px;
                background: rgba(255, 255, 255, 0.8);
                border: none;
                width: 36px;
                height: 36px;
                border-radius: 50%;
                font-size: 24px;
                line-weight: 36px;
                font-weight: 700;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #333;
                z-index: 10;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .popup-modal-close-btn:hover {
                background: var(--primary-red, #c01e2e);
                color: #ffffff;
                transform: rotate(90deg);
            }

            .popup-modal-content {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
            }

            .popup-modal-img {
                width: 100%;
                height: auto;
                max-height: 80vh;
                object-fit: contain;
                display: block;
            }

            @media (max-width: 576px) {
                .popup-modal-container {
                    border-radius: 12px;
                }

                .popup-modal-close-btn {
                    top: 10px;
                    right: 10px;
                    width: 32px;
                    height: 32px;
                    font-size: 20px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Check if popup was already shown in this session
                if (!sessionStorage.getItem('popup_displayed')) {
                    const modal = document.getElementById('landingPopupModal');
                    if (modal) {
                        modal.style.display = 'flex';
                        // Trigger fade-in
                        setTimeout(() => {
                            modal.classList.add('show');
                        }, 50);
                    }
                }
            });

            function closeLandingPopup() {
                const modal = document.getElementById('landingPopupModal');
                if (modal) {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 400);
                    // Mark as shown in session storage
                    sessionStorage.setItem('popup_displayed', 'true');
                }
            }

            // Close on clicking outside container
            window.addEventListener('click', function (e) {
                const modal = document.getElementById('landingPopupModal');
                if (e.target === modal) {
                    closeLandingPopup();
                }
            });
        </script>
    @endif
</body>

</html>