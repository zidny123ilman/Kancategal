<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Kanca Tegal</title>

    <!-- Meta Tags SEO -->
    <meta name="description"
        content="Bergabunglah dengan Kanca Tegal dan daftarkan diri Anda sebagai anggota komunitas literasi alternatif untuk mengarsipkan ide dan berbagi wawasan.">
    <meta name="keywords" content="daftar kanca tegal, registrasi anggota, komunitas tegal, perpustakaan tegal">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        <section class="register-split-container">
            <!-- Left Side: Image Panel -->
            <div class="register-left">
                <h1 class="register-left-title">Mulai Arsip<br>Digital Anda.</h1>
                <p class="register-left-desc">
                    Bergabunglah dengan komunitas pembaca paling terkurasi di Tegal. Bangun koleksi, tulis ulasan, dan
                    temukan literatur yang bermakna.
                </p>
                <div class="register-left-footer">
                    <div class="register-left-line"></div>
                    <span class="register-left-tag">THE MODERN ARCHIVIST COLLECTIVE</span>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="register-right">
                <div class="register-right-inner">
                    <span class="register-right-tagline">BERGABUNG DENGAN KAMI</span>
                    <h2 class="register-right-title">Buat Akun Baru</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger"
                            style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 0.8rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/register') }}" method="POST">
                        @csrf
                        <!-- Nama Lengkap -->
                        <div class="register-form-group">
                            <label for="nama_lengkap">NAMA LENGKAP</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="register-input"
                                placeholder="Arsiparis Muda" value="{{ old('nama_lengkap') }}" required
                                autocomplete="name">
                        </div>

                        <!-- Nomor Whatsapp -->
                        <div class="register-form-group">
                            <label for="no_whatsapp">NOMOR WHATSAPP</label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp" class="register-input"
                                placeholder="Contoh: 08123456789 atau +6281234567"
                                value="{{ old('no_whatsapp') }}"
                                inputmode="tel"
                                maxlength="16"
                                required autocomplete="tel">
                            <small id="wa-hint" style="display:block; margin-top:4px; font-size:0.78rem; color:#888;">
                                Format: 08xx / +628xx / 628xx — hanya angka, 10–13 digit
                            </small>
                            <small id="wa-error" style="display:none; margin-top:4px; font-size:0.78rem; color:#c0392b;">
                                <i class="fas fa-exclamation-circle"></i> Nomor tidak valid. Pastikan hanya angka dan minimal 10 digit.
                            </small>
                        </div>

                        <!-- Alamat Rumah -->
                        <div class="register-form-group">
                            <label for="alamat_rumah">ALAMAT RUMAH</label>
                            <input type="text" id="alamat_rumah" name="alamat_rumah" class="register-input"
                                placeholder="Masukan alamat lengkap Anda" value="{{ old('alamat_rumah') }}" required
                                autocomplete="street-address">
                        </div>

                        <!-- Kata Sandi -->
                        <div class="register-form-group">
                            <label for="kata_sandi">KATA SANDI</label>
                            <input type="password" id="kata_sandi" name="kata_sandi" class="register-input"
                                placeholder="••••••••" required autocomplete="new-password">
                        </div>

                        <!-- Konfirmasi Kata Sandi -->
                        <div class="register-form-group">
                            <label for="konfirmasi_sandi">KONFIRMASI KATA SANDI</label>
                            <input type="password" id="konfirmasi_sandi" name="konfirmasi_sandi" class="register-input"
                                placeholder="••••••••" required autocomplete="new-password">
                        </div>

                        <!-- Checkbox Persetujuan -->
                        <div class="register-checkbox-group">
                            <input type="checkbox" id="persetujuan" required checked>
                            <label for="persetujuan">
                                Saya setuju dengan <a href="#">syarat dan ketentuan</a> yang berlaku di Kanca Tegal.
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-register-submit">Daftar Sekarang</button>
                    </form>

                    <!-- Login Prompt -->
                    <p class="register-login-prompt">
                        Sudah memiliki akun? <a href="{{ url('/login') }}">Masuk di sini</a>
                    </p>
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
                    &copy; 2026 KANCA TEGAL Support by @tegal.itsolutions X Universitas Harkat Negeri
                </div>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            const input   = document.getElementById('no_whatsapp');
            const hint    = document.getElementById('wa-hint');
            const errMsg  = document.getElementById('wa-error');
            const form    = input.closest('form');

            /**
             * Normalize to 08xxxxxxxxx then validate with regex.
             * Accepts: 08xx, +628xx, 628xx — digits only, 10-13 digits total.
             */
            function normalize(val) {
                let n = val.replace(/[\s\-\.\(\)]/g, '');
                if (n.startsWith('+')) n = n.slice(1);
                if (n.startsWith('628')) n = '0' + n.slice(2);
                else if (n.startsWith('62')) n = '0' + n.slice(2);
                else if (n.startsWith('8')) n = '0' + n;
                return n;
            }

            function isValid(val) {
                if (!val.trim()) return false;
                const normalized = normalize(val);
                return /^08[0-9]{8,11}$/.test(normalized);
            }

            function validate() {
                const val = input.value.trim();
                if (!val) {
                    input.style.borderColor = '';
                    hint.style.display  = 'block';
                    errMsg.style.display = 'none';
                    return;
                }
                if (isValid(val)) {
                    input.style.borderColor = '#27ae60';
                    hint.style.display  = 'block';
                    errMsg.style.display = 'none';
                } else {
                    input.style.borderColor = '#c0392b';
                    hint.style.display  = 'none';
                    errMsg.style.display = 'block';
                }
            }

            input.addEventListener('input', validate);
            input.addEventListener('blur',  validate);

            form.addEventListener('submit', function (e) {
                if (!isValid(input.value)) {
                    e.preventDefault();
                    input.focus();
                    input.style.borderColor = '#c0392b';
                    hint.style.display  = 'none';
                    errMsg.style.display = 'block';
                }
            });
        })();
    </script>
</body>

</html>