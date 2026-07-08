<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Masuk ke akun Kanca Tegal Anda untuk mengakses arsip koleksi, ulasan buku, dan diskusi literasi komunitas.">
    <meta name="keywords" content="login kanca tegal, masuk akun, perpustakaan tegal, literasi tegal">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <!-- Main Content -->
    <main>
        <section class="login-split-container">
            <!-- Left Side: Image & Quote Panel -->
            <div class="login-left">
                <!-- Top Header Logo -->
                <div class="login-left-header">
                    <span class="logo-line"></span>
                    <span class="logo-text">KANCA TEGAL</span>
                </div>

                <!-- Bottom Quote Content -->
                <div class="login-left-content">
                    <span class="login-tagline">THE MODERN ARCHIVIST COLLECTIVE</span>
                    <blockquote class="login-quote">
                        "Membaca adalah alat paling dasar untuk meraih hidup yang baik."
                    </blockquote>
                    <cite class="login-author">Joseph Addison</cite>
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="login-right">
                <!-- Middle Wrapper for Centering Content -->
                <div class="login-right-middle">
                    <h2 class="login-right-title">Selamat Datang</h2>
                    <p class="login-right-subtitle">Masuk untuk melanjutkan ke arsip koleksi.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger" style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 0.8rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 0.8rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.85rem;">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <!-- Nomor Whatsapp -->
                        <div class="login-form-group">
                            <label for="whatsapp">Masukan No. Whatapp</label>
                            <input type="tel" id="whatsapp" name="whatsapp" class="login-input" placeholder="+628*****" value="{{ old('whatsapp') }}" required autocomplete="tel">
                        </div>

                        <!-- Kata Sandi -->
                        <div class="login-form-group">
                            <div class="login-label-row">
                                <label for="kata_sandi">KATA SANDI</label>
                                <a href="{{ url('/lupa-sandi') }}" class="btn-forgot-password">LUPA PASSWORD?</a>
                            </div>
                            <input type="password" id="kata_sandi" name="kata_sandi" class="login-input" placeholder="••••••••" required autocomplete="current-password">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-login-submit">
                            Masuk <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>

                    <!-- OR Divider -->
                    <div class="login-divider-row">
                        <div class="login-divider-line"></div>
                        <span class="login-divider-text">ATAU</span>
                    </div>

                    <!-- Signup Prompt -->
                    <p class="login-signup-prompt">
                        Belum punya akun? <a href="{{ url('/register') }}">Daftar sekarang</a>
                    </p>
                </div>

                <!-- Footer Copyright -->
                <div class="login-right-footer">
                    &copy; 2024 KANCA TEGAL. THE MODERN ARCHIVIST COLLECTIVE.
                </div>
            </div>
        </section>
    </main>

</body>
</html>
