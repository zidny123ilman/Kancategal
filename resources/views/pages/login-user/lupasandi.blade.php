<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Pulihkan akses akun Kanca Tegal Anda dengan memasukkan nomor WhatsApp terdaftar.">
    <meta name="keywords" content="lupa password, kanca tegal, pulihkan akun, whatsapp tegal">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <div class="lupa-page-wrapper">
        <!-- Top Bar Header -->
        <header class="lupa-header">
            <div class="lupa-header-left">
                <a href="{{ url('/login') }}" class="lupa-back-btn" aria-label="Kembali ke Halaman Masuk">
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
        <main class="lupa-split-container">
            <!-- Left Side: Image & Quote -->
            <div class="lupa-left">
                <div class="lupa-left-content">
                    <span class="lupa-tagline">MEMORABILIA DIGITAL</span>
                    <blockquote class="lupa-quote">
                        "Literasi adalah jembatan antara apa yang kita lupakan dan apa yang harus kita ingat kembali."
                    </blockquote>
                    <div class="lupa-left-line"></div>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="lupa-right">
                <!-- Middle Content Wrapper -->
                <div class="lupa-right-inner">
                    <h2 class="lupa-right-title">Lupa Kata Sandi?</h2>
                    <p class="lupa-right-desc">Masukkan nomor WhatsApp yang terdaftar untuk menerima tautan pemulihan.</p>

                    @if ($errors->any())
                        <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-exclamation-triangle" style="flex-shrink: 0;"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form action="{{ url('/lupa-sandi') }}" method="POST">
                        @csrf
                        <!-- Nomor Whatsapp -->
                        <div class="login-form-group">
                            <label for="no_whatsapp">NOMOR WHATSAPP</label>
                            <input type="tel" id="no_whatsapp" name="no_whatsapp" class="login-input" placeholder="+62 812..." value="{{ old('no_whatsapp') }}" required autocomplete="tel">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-lupa-submit">KIRIM KODE OTP</button>
                    </form>

                    <!-- Back to Login -->
                    <a href="{{ url('/login') }}" class="lupa-back-login-link">
                        <i class="fas fa-arrow-left"></i> KEMBALI KE MASUK
                    </a>
                </div>

                <!-- Security Note & Footer -->
                <div>
                    <div class="lupa-security-note">
                        <i class="fas fa-shield-alt"></i>
                        <p>Sistem keamanan kami memastikan data nomor telepon Anda tetap terenkripsi dan terlindungi.</p>
                    </div>
                    <div class="lupa-right-footer">
                        &copy; 2024 KANCA TEGAL ARCHIVE
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
