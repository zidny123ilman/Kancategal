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
                Di balik setiap arsip dan diskusi, ada semangat untuk merawat identitas. Kami adalah kolektif arsiparis
                modern yang percaya bahwa masa depan Tegal berakar dari narasi yang kita bangun hari ini.
            </p>

            <!-- Members List -->
            <div class="inisiator-list">

                <!-- Member 1: Irfan Maulana -->
                <div class="inisiator-row">
                    <div class="inisiator-img-wrapper">
                        <img src="{{ asset('storage/irpan.jpg')}}" alt="Irfan Maulana" class="inisiator-img">
                    </div>
                    <div class="inisiator-info">
                        <span class="inisiator-role">INISIATOR</span>
                        <h2 class="inisiator-name">IRFAN MAULANA, S.Pd.</h2>
                        <span class="inisiator-edu">Lulusan S1 PGSD UNNES</span>

                        <div class="inisiator-quote-box">
                            <blockquote class="inisiator-quote">
                                "Ingin merawat kesadaran kolektif di Kota Tegal."
                            </blockquote>
                        </div>

                        <div class="inisiator-bio">
                            <p>Sebagai lulusan pendidikan, Irfan memilih jalan alternatif di luar dinding sekolah
                                formal. Keputusannya untuk tidak menjadi guru lahir dari refleksi kritis terhadap
                                ketidakseriusan negara dalam memberikan upah yang layak bagi profesi pendidik. Bagi
                                Irfan, mengimplementasikan ilmu kependidikan tidak harus terpenjara oleh sistem yang
                                tidak berpihak pada kesejahteraan.</p>
                            <p>Melalui Kanca Tegal, ia membawa ruang belajar itu langsung ke jantung interaksi warga.
                                Lapak baca ini menjadi manifestasi nyata dari ilmunya—sebuah jembatan demokratis yang
                                mengajak masyarakat untuk saling bertukar gagasan, merawat nalar kritis, dan membangun
                                kesadaran kolektif secara mandiri.</p>
                        </div>
                    </div>
                </div>

                <!-- Member 2: Moh. Zidny Ilman-->
                <div class="inisiator-row reverse">
                    <div class="inisiator-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=600"
                            alt="Siti Nurhaliza" class="inisiator-img">
                    </div>
                    <div class="inisiator-info">
                        <span class="inisiator-role">INISIATOR</span>
                        <h2 class="inisiator-name">Moh. Zidny Ilman</h2>
                        <span class="inisiator-edu">Mahasiswa Teknik Komputer, UHN</span>

                        <div class="inisiator-quote-box">
                            <blockquote class="inisiator-quote">
                                "Membangun ruang bebas berekspresi dan bertukar karya pikir maupun fisik di Kota Tegal."
                            </blockquote>
                        </div>

                        <div class="inisiator-bio">
                            <p>Berangkat dari keyakinan bahwa perubahan lahir dari ruang yang terbuka, ia menginisiasi
                                Kanca Tegal sebagai wadah bagi anak muda dan masyarakat umum untuk bertemu, berdiskusi,
                                berkarya, dan saling menguatkan. Baginya, setiap gagasan harus diberi ruang untuk tumbuh
                                agar tidak jadi ide semata yang beku dalam rutinitas palsu.</p>
                            <p>Kanca Tegal dibangun sebagai ruang bersama yang menghubungkan literasi, kreativitas, dan
                                gerakan kolektif. Teknologi digunakan bukan sekadar alat, melainkan sarana memperluas
                                akses pengetahuan, mempertemukan gagasan, dan mendorong setiap individu untuk bertumbuh
                                serta memberi manfaat bagi lingkungan sekitarnya.
                            </p>
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