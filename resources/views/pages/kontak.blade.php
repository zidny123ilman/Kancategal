<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - {{ \App\Models\Setting::get('site_title', 'Kanca Tegal') }}</title>

    <!-- Meta Tags SEO -->
    <meta name="description"
        content="Hubungi komunitas Kanca Tegal melalui WhatsApp, email resmi, atau ikuti jejak digital kami di Instagram, TikTok, dan Twitter.">
    <meta name="keywords" content="hubungi kami, kontak tegal, whatsapp kanca tegal, email kanca tegal, sosial media">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content Container -->
    <main class="contact-page-container">

        <!-- Header Title Section -->
        <div class="contact-title-wrapper">
            <div class="contact-title-left">
                <h1 class="contact-main-title">Hubungi<br>Kami.</h1>
                <p class="contact-main-desc">
                    "Curating conversations, archiving ideas. Join the collective and let's bridge the literacy gap
                    together."
                </p>
            </div>

            <div class="contact-badge-at">
                <span>@</span>
            </div>
        </div>

        <!-- Grid Row 1 (WhatsApp & Email) -->
        <div class="contact-grid">

            <!-- WhatsApp Card (Kiri) -->
            <div class="contact-card red-card">
                <span class="red-card-tag">INSTANT RESPONSE</span>
                <h3 class="red-card-title">WHATSAPP</h3>

                <div class="red-card-bottom">
                    <p class="red-card-desc">
                        Text us for quick inquiries or community partnership proposals.
                    </p>
                    <a href="https://wa.me/62895324606014" target="_blank">
                        <button class="btn-send-message">
                            SEND MESSAGE <i class="fas fa-arrow-up-right-from-square"></i>
                        </button>
                    </a>
                </div>
            </div>

            <!-- Email Card (Kanan) -->
            <div class="contact-card mint-card">
                <div>
                    <div class="email-icon-box">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <span class="mint-card-tag">OFFICIAL INQUIRIES</span>
                    <h3 class="email-address">kancategal10@gmail.com</h3>
                </div>

                <button class="btn-copy-address"
                    onclick="navigator.clipboard.writeText('kancategal10@gmail.com'); alert('Alamat email berhasil disalin!');">
                    COPY ADDRESS <i class="fas fa-copy"></i>
                </button>
            </div>

        </div>

        <!-- Grid Row 2 (Books B&W & Social Media) -->
        <div class="contact-grid-bottom">

            <!-- Stack of Books B&W Photo Card (Kiri) -->
            <div class="books-photo-card">
                <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=500"
                    alt="Vintage books stack" class="books-photo-img">
                <div class="books-photo-overlay">
                    <h4 class="photo-overlay-title">The Modern Archivist.</h4>
                    <span class="photo-overlay-subtitle">EST. 2025</span>
                </div>
            </div>

            <!-- Social Media Digital Footprint Card (Kanan) -->
            <div class="contact-card social-card">
                <div>
                    <h4 class="social-title">OUR DIGITAL FOOTPRINT</h4>

                    <div class="social-links-row">
                        <!-- Instagram Link -->
                        <a href="https://www.instagram.com/kanca.tegal" class="white-social-btn">
                            <span>INSTAGRAM</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>

                        <!-- TikTok Link -->
                        <a href="https://www.tiktok.com/@kanca.tegal" class="white-social-btn">
                            <span>TIKTOK</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="social-card-bottom">
                    <div class="avatars-overlap-container">
                        <div class="avatar-shape"></div>
                        <div class="avatar-shape"></div>
                        <div class="avatar-shape"></div>
                    </div>
                    <p class="social-support-text">
                        Support kami bersama kawan-kawan tegal sekitarnya dan semua
                    </p>
                </div>
            </div>

        </div>

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

</body>

</html>