<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - {{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }}</title>

    <!-- Meta Tags SEO -->
    <meta name="description"
        content="Ketahui seluk-beluk Kanca Tegal, sebuah inisiatif komunitas literasi alternatif yang berdedikasi membangun diskusi, melestarikan arsip lokal, dan menyebarkan budaya baca di Tegal.">
    <meta name="keywords"
        content="tentang kanca tegal, komunitas literasi, sejarah tegal, relawan tegal, donasi buku tegal">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="about-section">

        <!-- Header Title Area -->
        <div class="about-header">
            <div class="title-group">
                <span class="title-tagline">{{ __('SELAYANG PANDANG') }}</span>
                <h1 class="main-title-small">{{ __('Tentang') }}</h1>
                <h2 class="main-title-large">KANCA TEGAL</h2>
            </div>

            <p class="about-header-desc">
                {{ __('Kanca Tegal berbentuk platform/wadah bagi komunitas literasi lokal di kota Tegal dan sekitarnya.') }}
            </p>
        </div>

        <!-- Large Hero Banner -->
        <div class="about-banner-container">
            <img src="{{asset('storage/hero1.jpg')}}" alt="Lapak Buku Fisik Kanca Tegal" class="about-banner-img">

            <div class="about-banner-overlay">
                <i class="fas fa-book-open"></i>
                <p>{{ __('Wadah kolaborasi literasi lokal yang diinisiasi oleh pemuda lokal Tegal.') }}</p>
            </div>
        </div>

        <!-- Siapa Kami Section -->
        <section class="profile-section">
            <div class="profile-left">
                <h3>{{ __('Siapa Kami?') }}</h3>
                <p>
                    {{ __('Kanca Tegal adalah wadah kolektif independen yang bergerak di bidang literasi, pendidikan alternatif, serta pelestarian arsip kebudayaan lokal di Tegal. Fokus kami nggak cuma sekadar buku fisik, tapi juga membangun ekosistem diskusi alternatif yang kritis.') }}
                </p>
                <p>
                    {{ __('Para inisiator meyakini kalau pendidikan tidak boleh terpenjara dalam ruang kelas saja. Pendidikan kolektif melalui lapak baca seperti ini sangat penting untuk merawat kesadaran kolektif karena bersentuhan langsung dengan masyarakat.') }}
                </p>
            </div>

            <div class="profile-right">
                <div class="profile-stats-grid">
                    <!-- Stat Card 1 -->
                    <div class="stat-card white-card">
                        <span class="stat-card-number">{{ number_format($totalAnggotaAktif, 0, ',', '.') }}</span>
                        <span class="stat-card-label">{{ __('Anggota Aktif') }}</span>
                    </div>

                    <!-- Stat Card 2 -->
                    <div class="stat-card red-card">
                        <span class="stat-card-number">{{ number_format($totalBuku, 0, ',', '.') }}</span>
                        <span class="stat-card-label">{{ __('Koleksi Buku') }}</span>
                    </div>
                </div>

                <!-- Mission horizontal bar -->
                <div class="mission-bar">
                    <i class="fas fa-bullseye"></i>
                    <p>{{ __('Misi: Membangun ruang diskusi yang memberdayakan masyarakat melalui literasi alternatif.') }}
                    </p>
                </div>
            </div>
        </section>

    </main>

    <!-- Behind the Scenes (Di Balik Layar) -->
    <section class="bg-sage-section">
        <div class="about-section" style="padding: 0 2rem;">

            <div class="about-header" style="margin-bottom: 2.5rem;">
                <div class="title-group">
                    <span class="title-tagline">{{ __('KOLABORATOR') }}</span>
                    <h2 class="main-title-small" style="font-size: 2.2rem; font-weight: 800; color: var(--text-dark);">
                        {{ __('Di Balik Layar') }}
                    </h2>
                </div>
            </div>

            <!-- Row 1 of Grid -->
            <div class="bts-grid-layout">

                <!-- Left Card (Tim Inisiator) -->
                <div class="bts-card white-card">
                    <div>
                        <h3 class="bts-card-title">{{ __('Berawal dari Keresahan') }}</h3>
                        <p class="bts-card-desc">
                            {{ __('Kanca Tegal lahir pada Januari 2025 berangkat dari keresahan akan minimnya ruang diskusi alternatif di Kota Tegal. Kami percaya lewat literasi, kekuatan transformatif untuk perubahan sosial akan tercipta.') }}
                        </p>
                    </div>
                    <a href="{{ url('/inisiator') }}" class="bts-team-wrapper"
                        style="text-decoration: none; color: inherit; display: flex; align-items: center; justify-content: space-between;">
                        <div class="team-avatars">
                            <img src="{{ asset('storage/irpan.jpg') }}" alt="Inisiator 1" class="team-avatar">
                            <img src="{{ asset('storage/zidny.jpg') }}" alt="Inisiator 2" class="team-avatar">
                        </div>
                        <span class="team-label">{{ __('Tim Inisiator Awal') }} <i class="fas fa-arrow-right"
                                style="margin-left: 0.35rem; font-size: 0.75rem; color: var(--primary-red);"></i></span>
                    </a>
                </div>

                <!-- Right Card (Dark Card) -->
                <div class="bts-card dark-card">
                    <div>
                        <h3 class="bts-card-title">{{ __('Sinergi Bersama') }}</h3>
                        <p class="bts-card-desc">
                            {{ __('Kolaborasi adalah kunci utama kami mengembangkan ekosistem ini. Kami bersinergi dengan seniman, penulis, dan komunitas regional untuk melahirkan gagasan segar.') }}
                        </p>
                    </div>
                    <div class="illustration-box">
                        <div class="ill-text-wrapper">
                            <span class="ill-tag">{{ __('SINERGI BERSAMA') }}</span>
                        </div>
                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=150"
                            alt="Abstract Graphic shape" class="ill-img">
                    </div>
                </div>

            </div>

            <!-- Row 2 of Grid -->
            <div class="bts-grid-layout-bottom">

                <!-- Left Card (Red Card) -->
                <div class="bts-card red-card">
                    <div class="red-card-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="bts-card-title" style="color: var(--text-light);">{{ __('Membaca untuk Melambat') }}</h3>
                    <p class="bts-card-desc" style="color: rgba(255,255,255,0.9); margin-bottom: 0;">
                        {{ __('Di era digital ini, kami tetap percaya pada kekuatan interaksi fisik melalui buku fisik dan diskusi tatap muka.') }}
                    </p>
                </div>

                <!-- Right Card (Filosofi) -->
                <div class="bts-card-row">
                    <div class="row-left">
                        <h3 class="bts-card-title">{{ __('Filosofi \'Kanca\'') }}</h3>
                        <p class="bts-card-desc" style="margin-bottom: 0;">
                            {{ __('Dalam bahasa Jawa, \'kanca\' berarti teman. Kami bukan sekadar perpustakaan, melainkan teman dalam mencari pengetahuan dan berbagi pengalaman.') }}
                        </p>
                    </div>
                    <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&q=80&w=150"
                        alt="Spiral art sketch" class="spiral-art-img">
                </div>

            </div>

        </div>
    </section>

    <!-- Visit Us Section -->
    <section class="visit-section" id="visit-us">
        <h2 class="visit-title">{{ __('Kunjungi \'Lapak\' Kami') }}</h2>
        <p class="visit-subtitle">
            {{ __('Tempat di mana Anda bisa bertemu dengan kami dan perpustakaan keliling, berdiskusi secara tatap muka secara santai.') }}
        </p>

        <div class="map-container"
            style="position: relative; height: 450px; overflow: hidden; border-radius: 12px; border: 1px solid var(--border-color); background: #f8fafc; box-shadow: var(--shadow-sm);">
            <div class="map-card-badge"
                style="position: absolute; top: 16px; left: 16px; z-index: 10; pointer-events: none;">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ \App\Models\Setting::get('map_label', 'LAPAK KAMI: Alun-alun Kota Tegal (Setiap Minggu Pagi)') }}</span>
            </div>
            <iframe
                src="{{ \App\Models\Setting::get('map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.037107771746!2d109.1369796!3d-6.886123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb9e2b17a1b3b%3A0xe54fb7be43f4f1a2!2sAlun-Alun%20Kota%20Tegal!5e0!3m2!1sid!2sid!4v1719400000000!5m2!1sid!2sid') }}"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
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

</body>

</html>