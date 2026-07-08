<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Para Pendiri - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Mengenal tim inisiator awal di balik gerakan literasi Kanca Tegal.">
    <meta name="keywords" content="pendiri kanca tegal, tim inisiator, literasi tegal, profil inisiator">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <!-- Header / Navbar Component -->
    @include('components.navbar')

    <main style="background-color: #F4F8F5; min-height: 100vh;">
        <section class="inisiator-container">
            <!-- Title Area -->
            <span class="inisiator-tagline">MENGENAL TIM KAMI</span>
            <h1 class="inisiator-title">Para Pendiri.</h1>
            <p class="inisiator-desc">
                Di balik setiap arsip dan diskusi, ada semangat untuk merawat identitas. Kami adalah kolektif arsiparis modern yang percaya bahwa masa depan Tegal berakar dari narasi yang kita bangun hari ini.
            </p>

            <!-- Members List -->
            <div class="inisiator-list">
                
                <!-- Member 1: Ahmad Rifai -->
                <div class="inisiator-row">
                    <div class="inisiator-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=600" alt="Ahmad Rifai" class="inisiator-img">
                    </div>
                    <div class="inisiator-info">
                        <span class="inisiator-role">KETUA & PENGARSIP</span>
                        <h2 class="inisiator-name">Ahmad Rifai</h2>
                        <span class="inisiator-edu">Lulusan Sastra Indonesia</span>
                        
                        <div class="inisiator-quote-box">
                            <blockquote class="inisiator-quote">
                                "Ingin menghidupkan kembali dialek lokal melalui literasi."
                            </blockquote>
                        </div>
                        
                        <div class="inisiator-bio">
                            <p>Bagi Ahmad, bahasa adalah rumah. Melalui Kanca Tegal, ia berupaya mendokumentasikan setiap kosakata dan dialek yang terancam punah, menjadikannya jembatan bagi generasi masa depan untuk memahami asal-usul mereka sendiri.</p>
                            <p>Visi kepemimpinannya berfokus pada kekuatan arsip sebagai alat perlawanan terhadap amnesia budaya.</p>
                        </div>
                    </div>
                </div>

                <!-- Member 2: Siti Nurhaliza -->
                <div class="inisiator-row reverse">
                    <div class="inisiator-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=600" alt="Siti Nurhaliza" class="inisiator-img">
                    </div>
                    <div class="inisiator-info">
                        <span class="inisiator-role">DIREKTUR KREATIF</span>
                        <h2 class="inisiator-name">Siti Nurhaliza</h2>
                        <span class="inisiator-edu">Lulusan Desain Komunikasi Visual</span>
                        
                        <div class="inisiator-quote-box">
                            <blockquote class="inisiator-quote">
                                "Membangun ruang bagi anak muda Tegal untuk berekspresi secara artistik."
                            </blockquote>
                        </div>
                        
                        <div class="inisiator-bio">
                            <p>Siti percaya bahwa estetika adalah bahasa universal. Sebagai direktur kreatif, ia mengubah data sejarah yang kaku menjadi visual yang memikat dan relevan bagi generasi muda, memastikan Kanca Tegal tetap berdenyut di ranah digital.</p>
                            <p>Ia mengarahkan identitas visual komunitas dengan memadukan elemen tradisional dan minimalisme kontemporer.</p>
                        </div>
                    </div>
                </div>

                <!-- Member 3: Budi Santoso -->
                <div class="inisiator-row">
                    <div class="inisiator-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=600" alt="Budi Santoso" class="inisiator-img">
                    </div>
                    <div class="inisiator-info">
                        <span class="inisiator-role">KOORDINATOR KOMUNITAS</span>
                        <h2 class="inisiator-name">Budi Santoso</h2>
                        <span class="inisiator-edu">Lulusan Sosiologi</span>
                        
                        <div class="inisiator-quote-box">
                            <blockquote class="inisiator-quote">
                                "Menyatukan masyarakat melalui kecintaan pada buku dan diskusi budaya."
                            </blockquote>
                        </div>
                        
                        <div class="inisiator-bio">
                            <p>Budi adalah perekat di Kanca Tegal. Dengan latar belakang sosiologinya, ia merancang program-program yang inklusif, mengundang setiap lapisan masyarakat Tegal untuk duduk bersama, berbagi cerita, dan merayakan literasi sebagai alat pemersatu.</p>
                            <p>Baginya, komunitas bukan sekadar kumpulan orang, melainkan ekosistem di mana ide-ide segar dapat tumbuh dan berkembang.</p>
                        </div>
                    </div>
                </div>

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
                    <li><a href="#" class="footer-link">WHATSAPP</a></li>
                    <li><a href="#" class="footer-link">INSTAGRAM</a></li>
                    <li><a href="#" class="footer-link">COMMUNITY GUIDELINES</a></li>
                    <li><a href="#" class="footer-link">SUPPORT</a></li>
                </ul>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; 2026 THE MODERN ARCHIVIST. ALL RIGHTS RESERVED.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
