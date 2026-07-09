<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca Tegal: Jejak Hindia Di Pesisir Utara - Kanca Tegal</title>
    
    <meta name="description" content="Artikel literasi Kanca Tegal mengenai Membaca Tegal: Jejak Hindia Di Pesisir Utara.">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    @include('components.navbar')

    <main>
        <!-- Article Header & Meta -->
        <section class="article-detail-section">
            <div class="article-detail-header">
                <span class="article-detail-badge">EDITORIAL NOTES</span>
                <h1 class="article-detail-title" id="article-title">Membaca Tegal: Jejak Hindia Di Pesisir Utara</h1>
                <div class="article-detail-meta">
                    <span id="article-author"><i class="fas fa-feather-alt"></i> EKA PRANAWA</span>
                    <span id="article-date"><i class="far fa-calendar-alt"></i> 24 Oktober 2023</span>
                    <span id="article-time"><i class="far fa-clock"></i> 5 min read</span>
                </div>
            </div>
        </section>

        <!-- Hero Image -->
        <section class="article-detail-hero">
            <img src="https://images.unsplash.com/photo-1512403754473-27835f7b9984?auto=format&fit=crop&q=80&w=1200" alt="Typewriter" id="article-image">
        </section>

        <!-- Article Body -->
        <section class="article-detail-body">
            <!-- Left Sidebar (Social Links) -->
            <div class="article-social-sidebar">
                <a href="#" class="article-social-link"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="article-social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="article-social-link"><i class="fas fa-link"></i></a>
                <a href="#" class="article-social-link"><i class="far fa-bookmark"></i></a>
            </div>

            <!-- Content Area -->
            <div class="article-content">
                <p>
                    Pesisir utara Jawa menyimpan banyak cerita yang tidak tercatat dalam buku sejarah arus utama. Di sela-sela riuh pelabuhan dan aroma laut, terdapat jejak-jejak peradaban yang menghubungkan kehidupan masa lalu dengan modernitas yang terus berjalan.
                </p>
                <p>
                    Dalam perjalanan menyusuri jejak masa lalu, kita akan menemukan sisa-sisa bangunan era kolonial yang berdiri kaku, menyimpan berbagai cerita yang tak sempat tersampaikan. Menyelusuri kota, menyisir bangunan tua, dan mencoba memahami sejarah tidaklah cukup hanya dengan membaca ensiklopedia, tapi harus dirasakan dan diselami langsung.
                </p>

                <blockquote class="article-blockquote">
                    <i class="fas fa-quote-left"></i>
                    <p>Literasi bukanlah tentang seberapa banyak buku yang kita miliki, melainkan tentang seberapa dalam kita mampu membaca dunia di sekitar kita melalui mata orang lain.</p>
                    <cite>— EKALANANG PRANAWA</cite>
                </blockquote>

                <p>
                    Tantangannya tidak berhenti di sana. Kita dihadapkan pada arus modernitas yang deras, yang sering kali menghapus identitas lokal dan budaya yang kita miliki. Maka dibutuhkan dedikasi dan upaya kolektif untuk merawat dan mendokumentasikan nilai-nilai sejarah ini agar bisa bertahan dari gerusan zaman.
                </p>

                <div class="article-inline-images">
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=500" alt="Books">
                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=500" alt="Reading">
                </div>

                <p>
                    Akhirnya, literasi di pesisir tidak sebatas kegiatan membaca buku teks semata. Ia meluas menjadi aktivitas mengamati, merekam, dan mempertahankan identitas komunitas yang ada di Tegal dan wilayah sekitarnya. 
                </p>

                <!-- Tags and Share -->
                <div class="article-footer-tags">
                    <div class="article-tags">
                        <span class="article-tag-pill">LITERASI</span>
                        <span class="article-tag-pill">TEGAL</span>
                        <span class="article-tag-pill">BUDAYA</span>
                    </div>
                    <div class="article-share-text">
                        SHARE ARTICLE
                        <div class="article-share-icons">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
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
                <!-- Card 1 -->
                <a href="#" class="related-card">
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80&w=500" alt="Membaca Tegal">
                    <span class="cat-badge">SOSIOLOGI</span>
                    <h4>Membaca: Jejak Hindia Di Pesisir Tegal</h4>
                </a>

                <!-- Card 2 -->
                <a href="#" class="related-card">
                    <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=500" alt="Kopi dan Diskusi">
                    <span class="cat-badge">KOMUNITAS</span>
                    <h4>Kopi, Senja, dan Cerita Kawan Baca di Kota</h4>
                </a>

                <!-- Card 3 -->
                <a href="#" class="related-card">
                    <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&q=80&w=500" alt="Literasi">
                    <span class="cat-badge">REVIEWS</span>
                    <h4>Mengenal Karakter Literasi Di Era Digital</h4>
                </a>
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
                    &copy; 2026 THE MODERN ARCHIVIST. HAK CIPTA DILINDUNGI. Support by @tegal.itsolutions
                </div>
            </div>
        </div>
    </footer>

    <!-- Script to dynamically update article details based on URL query parameters if present -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const title = urlParams.get('title');
            const author = urlParams.get('author');
            const date = urlParams.get('date');
            const content = urlParams.get('content');
            const image = urlParams.get('image');
            const category = urlParams.get('category');
            
            if (title) {
                document.title = title + " - Kanca Tegal";
                const titleEl = document.getElementById('article-title');
                if (titleEl) titleEl.textContent = title;
            }
            if (author) {
                const authorEl = document.getElementById('article-author');
                if (authorEl) authorEl.innerHTML = '<i class="fas fa-feather-alt"></i> ' + author.toUpperCase();
            }
            if (date) {
                const dateEl = document.getElementById('article-date');
                if (dateEl) dateEl.innerHTML = '<i class="far fa-calendar-alt"></i> ' + date;
            }
            if (category) {
                const badgeEl = document.querySelector('.article-detail-badge');
                if (badgeEl) badgeEl.textContent = category.toUpperCase();
            }
            if (image) {
                const imgEl = document.getElementById('article-image');
                if (imgEl) imgEl.src = image;
            }
            if (content) {
                const contentDiv = document.querySelector('.article-content');
                if (contentDiv) {
                    const paragraphs = content.split(/\r?\n+/);
                    let html = '';
                    paragraphs.forEach((p, idx) => {
                        if (p.trim()) {
                            html += `<p>${p.trim()}</p>`;
                            if (idx === 0 && paragraphs.length > 1) {
                                html += `<blockquote class="article-blockquote">
                                    <i class="fas fa-quote-left"></i>
                                    <p>${p.trim().substring(0, 120)}...</p>
                                    <cite>— ${author ? author.toUpperCase() : 'KONTRIBUTOR'}</cite>
                                </blockquote>`;
                            }
                        }
                    });
                    contentDiv.innerHTML = html;
                }
            }
        });
    </script>
</body>
</html>
