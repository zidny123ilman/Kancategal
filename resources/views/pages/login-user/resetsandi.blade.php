<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Buat kata sandi baru untuk mengamankan akun Kanca Tegal Anda.">
    <meta name="keywords" content="reset password, kanca tegal, atur ulang sandi, secure access">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <div class="lupa-page-wrapper" style="min-height: 100vh; display: flex; flex-direction: column;">
        <!-- Top Bar Header -->
        <header class="lupa-header">
            <div class="lupa-header-left">
                <a href="{{ url('/lupa-sandi') }}" class="lupa-back-btn" aria-label="Kembali">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="{{ url('/') }}" class="lupa-logo">
                    KANCA<span>TEGAL</span>
                </a>
            </div>
            <div class="lupa-header-right">
                <a href="#" class="lupa-help-btn" aria-label="Bantuan">
                    <i class="far fa-question-circle"></i>
                </a>
            </div>
        </header>

        <!-- Main split container -->
        <main class="reset-split-container">
            <!-- Left Side: Image & Quote -->
            <div class="reset-left">
                <div class="reset-left-content">
                    <span class="reset-tagline">SECURE ACCESS</span>
                    <h1 class="reset-quote">Melindungi Warisan Pengetahuan Kita.</h1>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="reset-right">
                <!-- Middle Content Wrapper -->
                <div class="reset-right-inner">
                    <h2 class="reset-right-title">Atur Ulang Kata Sandi</h2>
                    <p class="reset-right-desc">Buat kata sandi baru yang kuat untuk akun Anda.</p>

                    {{-- 
                    @if (session()->has('formatted_otp_message'))
                        <div class="otp-simulation-box" style="background: rgba(30, 46, 37, 0.6); border: 1px solid rgba(46, 92, 61, 0.4); border-radius: 16px; padding: 1.25rem; margin-bottom: 1.5rem; backdrop-filter: blur(10px);">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 0.75rem;">
                                <i class="fab fa-whatsapp" style="color: #25d366; font-size: 1.25rem;"></i>
                                <span style="font-size: 0.85rem; font-weight: 700; color: #25d366; text-transform: uppercase; letter-spacing: 0.5px;">Simulasi WhatsApp Gateway</span>
                            </div>
                            <div style="background: #111b15; border-radius: 12px; padding: 1rem; border: 1px solid rgba(255,255,255,0.05); position: relative;">
                                <div style="font-size: 0.85rem; line-height: 1.5; color: rgba(244,246,244,0.95); white-space: pre-wrap; font-family: monospace;">{{ session('formatted_otp_message') }}</div>
                                <div style="text-align: right; font-size: 0.7rem; color: rgba(244,246,244,0.4); margin-top: 4px;">{{ now()->format('H:i') }} &nbsp; <i class="fas fa-check-double" style="color: #53bdeb;"></i></div>
                            </div>
                            <p style="font-size: 0.75rem; color: rgba(244,246,244,0.5); margin-top: 8px; line-height: 1.4;"><i class="fas fa-info-circle"></i> Ini adalah simulasi pengiriman pesan WhatsApp. Masukkan kode OTP di atas untuk melanjutkan reset kata sandi.</p>
                        </div>
                    @endif
                    --}}

                    @if ($errors->any())
                        <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-exclamation-triangle" style="flex-shrink: 0;"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form action="{{ url('/reset-sandi') }}" method="POST">
                        @csrf
                        
                        <!-- OTP Code -->
                        <div class="login-form-group">
                            <label for="otp">KODE OTP WHATSAPP</label>
                            <input type="text" id="otp" name="otp" class="login-input" placeholder="Masukkan 6 digit kode OTP" required pattern="[0-9]{6}" autocomplete="one-time-code" value="{{ old('otp') }}">
                        </div>

                        <!-- Kata Sandi Baru -->
                        <div class="login-form-group">
                            <label for="kata_sandi">KATA SANDI BARU</label>
                            <div style="position: relative;">
                                <input type="password" id="kata_sandi" name="kata_sandi" class="login-input" placeholder="••••••••" required autocomplete="new-password">
                                <i class="far fa-eye toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);" onclick="togglePasswordVisibility('kata_sandi', this)"></i>
                            </div>
                        </div>

                        <!-- Konfirmasi Kata Sandi Baru -->
                        <div class="login-form-group">
                            <label for="konfirmasi_sandi">KONFIRMASI KATA SANDI BARU</label>
                            <div style="position: relative;">
                                <input type="password" id="konfirmasi_sandi" name="konfirmasi_sandi" class="login-input" placeholder="••••••••" required autocomplete="new-password">
                                <i class="far fa-eye toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-muted);" onclick="togglePasswordVisibility('konfirmasi_sandi', this)"></i>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-reset-submit">Simpan Kata Sandi</button>
                    </form>

                    <!-- Back to Login -->
                    <a href="{{ url('/login') }}" class="reset-back-login-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke Login
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="reset-footer">
            <div class="reset-footer-left">
                <div class="reset-footer-logo">
                    KANCA<span>TEGAL</span>
                </div>
                <div class="reset-footer-copy">
                    &copy; 2026 KANCA TEGAL Support by @tegal.itsolutions X Universitas Harkat Negeri
                </div>
            </div>
            <ul class="reset-footer-right">
                <li><a href="#" class="reset-footer-link">WHATSAPP</a></li>
                <li><a href="#" class="reset-footer-link">INSTAGRAM</a></li>
                <li><a href="#" class="reset-footer-link">COMMUNITY GUIDELINES</a></li>
                <li><a href="#" class="reset-footer-link">SUPPORT</a></li>
            </ul>
        </footer>
    </div>

    <!-- Password visibility toggle script -->
    <script>
        function togglePasswordVisibility(inputId, iconElement) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                iconElement.classList.remove('fa-eye');
                iconElement.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                iconElement.classList.remove('fa-eye-slash');
                iconElement.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
