<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Admin Kanca Tegal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Modern Glassmorphic Design for Settings Panel */
        :root {
            --bg-glass: rgba(255, 255, 255, 0.75);
            --border-glass: rgba(255, 255, 255, 0.45);
            --shadow-premium: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
            --accent-gradient: linear-gradient(135deg, #c01e2e 0%, #a01825 100%);
        }

        .stg-page-header {
            margin-bottom: 2rem;
            animation: fadeIn 0.8s ease-out;
        }

        .stg-system-label {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--primary-red);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }

        .stg-page-title {
            font-size: 2.25rem;
            font-weight: 900;
            color: #1e2e25;
            margin-bottom: 0.5rem;
        }

        .stg-page-desc {
            font-size: 0.95rem;
            color: #556052;
            line-height: 1.5;
        }

        /* Layout Container */
        .stg-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 992px) {
            .stg-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Sidebar Tabs */
        .stg-sidebar {
            background: var(--bg-glass);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-premium);
        }

        .stg-tab-button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 1.25rem;
            background: transparent;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #64748b;
            cursor: pointer;
            text-align: left;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        .stg-tab-button:last-child {
            margin-bottom: 0;
        }

        .stg-tab-button:hover {
            background: rgba(192, 30, 46, 0.05);
            color: var(--primary-red);
        }

        .stg-tab-button.active {
            background: var(--accent-gradient);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(192, 30, 46, 0.2);
        }

        .stg-tab-button i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Settings Card Panel */
        .stg-panel {
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 2.25rem;
            box-shadow: var(--shadow-premium);
            animation: fadeIn 0.5s ease-out;
        }

        .stg-panel-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1e2e25;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stg-panel-sub {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.4;
        }

        /* Form Styling */
        .stg-form-row {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 1.5rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid #e2e8f0;
            align-items: center;
        }

        .stg-form-row:last-of-type {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .stg-form-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
        }

        .stg-label {
            font-size: 0.8rem;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stg-label-desc {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: none;
            font-weight: 500;
            margin-top: 4px;
            letter-spacing: 0;
            line-height: 1.3;
        }

        .stg-input, .stg-select, .stg-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd2c8;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1e2e25;
            background: rgba(255, 255, 255, 0.85);
            transition: all 0.3s ease;
        }

        .stg-input:focus, .stg-select:focus, .stg-textarea:focus {
            outline: none;
            border-color: var(--primary-red);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(192, 30, 70, 0.12);
        }

        .stg-textarea {
            resize: vertical;
            font-family: inherit;
        }

        /* Action Buttons */
        .stg-action-row {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .stg-btn {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .stg-btn--save {
            background: var(--accent-gradient);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(192, 30, 46, 0.25);
        }

        .stg-btn--save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(192, 30, 46, 0.35);
        }

        /* Maintenance Cards */
        .stg-card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .stg-card-grid {
                grid-template-columns: 1fr;
            }
        }

        .stg-action-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .stg-action-card:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }

        .stg-card-title {
            font-size: 1rem;
            font-weight: 800;
            color: #1e2e25;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stg-card-desc {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.4;
        }

        .stg-btn--outline {
            border: 1px solid #cbd5e1;
            background: transparent;
            color: #334155;
            width: fit-content;
        }

        .stg-btn--outline:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .stg-btn--danger {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            width: fit-content;
        }

        .stg-btn--danger:hover {
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #137333;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }

        /* Alert notifications */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success {
            background-color: #E6F4EA;
            border: 1px solid #137333;
            color: #137333;
        }
        .alert-info {
            background-color: #E8F0FE;
            border: 1px solid #1a73e8;
            color: #1a73e8;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    @include('pages.admin.components.navbar-admin')

    <div class="admin-content">

        <!-- Header -->
        <div class="stg-page-header">
            <span class="stg-system-label">SYSTEM SETTINGS</span>
            <h1 class="stg-page-title">Pengaturan Sistem</h1>
            <p class="stg-page-desc">Konfigurasi pengaturan utama platform Kanca Tegal. Kelola aturan peminjaman,<br>sistem integrasi WhatsApp, pemeliharaan server, dan perlindungan keamanan admin.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
        @endif

        <!-- Layout Wrapper -->
        <div class="stg-layout">
            
            <!-- SIDEBAR: Navigation Tabs -->
            <div class="stg-sidebar">
                <button class="stg-tab-button active" onclick="switchTab(event, 'tab-general')">
                    <i class="fas fa-sliders-h"></i> General & SEO
                </button>
                <button class="stg-tab-button" onclick="switchTab(event, 'tab-security')">
                    <i class="fas fa-user-shield"></i> Profile & Security
                </button>
                <button class="stg-tab-button" onclick="switchTab(event, 'tab-loan')">
                    <i class="fas fa-book-reader"></i> Aturan Peminjaman
                </button>
                <button class="stg-tab-button" onclick="switchTab(event, 'tab-whatsapp')">
                    <i class="fab fa-whatsapp"></i> Notifikasi WhatsApp
                </button>
                <button class="stg-tab-button" onclick="switchTab(event, 'tab-popup')">
                    <i class="fas fa-window-restore"></i> Pengaturan Pop-up
                </button>
                <button class="stg-tab-button" onclick="switchTab(event, 'tab-maintenance')">
                    <i class="fas fa-server"></i> Backup & Cache
                </button>
            </div>

            <!-- CONTENT: Forms Panel -->
            <div class="stg-panel">
                <form id="settings-form" action="{{ url('/admin/setting/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 1. General & SEO Panel -->
                    <div id="tab-general" class="stg-tab-content">
                        <div class="stg-panel-title">
                            <i class="fas fa-sliders-h" style="color: var(--primary-red);"></i> General Settings
                        </div>
                        <p class="stg-panel-sub">Konfigurasi identitas platform dan status operasional umum.</p>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Site Title
                                <p class="stg-label-desc">Nama platform yang digunakan di seluruh aplikasi.</p>
                            </div>
                            <div>
                                <input type="text" class="stg-input" name="site_title" value="{{ $settings['site_title'] }}" required>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Default Language
                                <p class="stg-label-desc">Bahasa utama antarmuka pengguna.</p>
                            </div>
                            <div>
                                <select class="stg-select" name="default_language">
                                    <option value="id" {{ $settings['default_language'] === 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ $settings['default_language'] === 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Enable Maintenance Mode
                                <p class="stg-label-desc">Tampilkan halaman perbaikan sistem bagi pengguna umum saat diaktifkan.</p>
                            </div>
                            <div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] === '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Profile & Security Panel -->
                    <div id="tab-security" class="stg-tab-content" style="display: none;">
                        <div class="stg-panel-title">
                            <i class="fas fa-user-shield" style="color: var(--primary-red);"></i> Profile & Security
                        </div>
                        <p class="stg-panel-sub">Ubah informasi nama lengkap admin dan perbarui kredensial kata sandi untuk kedua akun administrator.</p>

                        <!-- Admin Account 1 -->
                        <div style="margin-bottom: 2rem; border-bottom: 2px dashed #e2e8f0; padding-bottom: 1.5rem;">
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1e2e25; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-user" style="color: var(--primary-red);"></i> Akun Administrator 1
                            </h3>
                            
                            <div class="stg-form-row">
                                <div class="stg-label">
                                    Full Name (Admin 1)
                                    <p class="stg-label-desc">Nama admin yang ditampilkan pada log aktivitas.</p>
                                </div>
                                <div>
                                    <input type="text" class="stg-input" name="admin_fullname" value="{{ $settings['admin_fullname'] }}" required>
                                </div>
                            </div>

                            <div class="stg-form-row">
                                <div class="stg-label">
                                    Username (Admin 1)
                                    <p class="stg-label-desc">Username untuk masuk ke panel administrasi.</p>
                                </div>
                                <div>
                                    <input type="text" class="stg-input" name="admin_username" value="{{ $settings['admin_username'] }}" required>
                                </div>
                            </div>

                            <div class="stg-form-row">
                                <div class="stg-label">
                                    New Password (Admin 1)
                                    <p class="stg-label-desc">Isi jika ingin merubah kata sandi masuk admin saat ini.</p>
                                </div>
                                <div>
                                    <input type="password" class="stg-input" name="admin_password" placeholder="Kosongkan jika tidak ingin merubah" minlength="6">
                                </div>
                            </div>
                        </div>

                        <!-- Admin Account 2 -->
                        <div style="margin-bottom: 1.5rem; padding-bottom: 0.5rem;">
                            <h3 style="font-size: 1.1rem; font-weight: 800; color: #1e2e25; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-user-friends" style="color: var(--primary-red);"></i> Akun Administrator 2
                            </h3>
                            
                            <div class="stg-form-row">
                                <div class="stg-label">
                                    Full Name (Admin 2)
                                    <p class="stg-label-desc">Nama admin kedua yang ditampilkan pada log aktivitas.</p>
                                </div>
                                <div>
                                    <input type="text" class="stg-input" name="admin2_fullname" value="{{ $settings['admin2_fullname'] }}" required>
                                </div>
                            </div>

                            <div class="stg-form-row">
                                <div class="stg-label">
                                    Username (Admin 2)
                                    <p class="stg-label-desc">Username admin kedua untuk masuk ke panel administrasi.</p>
                                </div>
                                <div>
                                    <input type="text" class="stg-input" name="admin2_username" value="{{ $settings['admin2_username'] }}" required>
                                </div>
                            </div>

                            <div class="stg-form-row">
                                <div class="stg-label">
                                    New Password (Admin 2)
                                    <p class="stg-label-desc">Isi jika ingin merubah kata sandi masuk admin kedua saat ini.</p>
                                </div>
                                <div>
                                    <input type="password" class="stg-input" name="admin2_password" placeholder="Kosongkan jika tidak ingin merubah" minlength="6">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Aturan Peminjaman Panel -->
                    <div id="tab-loan" class="stg-tab-content" style="display: none;">
                        <div class="stg-panel-title">
                            <i class="fas fa-book-reader" style="color: var(--primary-red);"></i> Aturan Peminjaman
                        </div>
                        <p class="stg-panel-sub">Tetapkan batas maksimum pinjaman buku, limit durasi, dan pengenaan denda keterlambatan.</p>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Batas Jumlah Pinjaman
                                <p class="stg-label-desc">Maksimum jumlah buku yang bisa dipinjam bersamaan per anggota.</p>
                            </div>
                            <div>
                                <input type="number" class="stg-input" name="loan_limit" value="{{ $settings['loan_limit'] }}" min="1" required>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Durasi Peminjaman (Hari)
                                <p class="stg-label-desc">Jangka waktu standard peminjaman buku fisik sebelum jatuh tempo.</p>
                            </div>
                            <div>
                                <input type="number" class="stg-input" name="loan_duration" value="{{ $settings['loan_duration'] }}" min="1" required>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Durasi Peminjaman E-Book (Hari)
                                <p class="stg-label-desc">Jangka waktu akses E-Book digital setelah permintaan peminjaman disetujui admin.</p>
                            </div>
                            <div>
                                <input type="number" class="stg-input" name="ebook_loan_duration" value="{{ $settings['ebook_loan_duration'] }}" min="1" required>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Denda Keterlambatan (Rp)
                                <p class="stg-label-desc">Tarif denda keterlambatan per buku per hari (dalam Rupiah).</p>
                            </div>
                            <div>
                                <input type="number" class="stg-input" name="late_fine_rate" value="{{ $settings['late_fine_rate'] }}" min="0" required>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Masa Tenggang (Hari)
                                <p class="stg-label-desc">Jumlah hari toleransi keterlambatan pengembalian sebelum denda mulai dihitung.</p>
                            </div>
                            <div>
                                <input type="number" class="stg-input" name="grace_period" value="{{ $settings['grace_period'] }}" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Notifikasi WhatsApp Panel -->
                    <div id="tab-whatsapp" class="stg-tab-content" style="display: none;">
                        <div class="stg-panel-title">
                            <i class="fab fa-whatsapp" style="color: var(--primary-red);"></i> Notifikasi WhatsApp
                        </div>
                        <p class="stg-panel-sub">Atur kredensial WhatsApp API Gateway dan template kustomisasi pesan otomatis.</p>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                WhatsApp Gateway Token
                                <p class="stg-label-desc">Token API dari layanan gateway pengirim pesan (misal: Fonnte/Wablas).</p>
                            </div>
                            <div>
                                <input type="text" class="stg-input" name="wa_api_token" value="{{ $settings['wa_api_token'] }}" placeholder="Masukkan token API gateway Anda">
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Template Registrasi Baru
                                <p class="stg-label-desc">Teks dikirim saat member baru berhasil mendaftar. Variabel tersedia: <code>{name}</code></p>
                            </div>
                            <div>
                                <textarea class="stg-textarea" name="wa_template_register" rows="2" required>{{ $settings['wa_template_register'] }}</textarea>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Template Konfirmasi Pinjam
                                <p class="stg-label-desc">Dikirim setelah menyetujui peminjaman buku. Variabel: <code>{name}</code>, <code>{title}</code>, <code>{due_date}</code></p>
                            </div>
                            <div>
                                <textarea class="stg-textarea" name="wa_template_borrow" rows="3" required>{{ $settings['wa_template_borrow'] }}</textarea>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Template Peringatan Terlambat
                                <p class="stg-label-desc">Pengingat harian denda buku terlambat. Variabel: <code>{name}</code>, <code>{title}</code>, <code>{fine}</code></p>
                            </div>
                            <div>
                                <textarea class="stg-textarea" name="wa_template_overdue" rows="3" required>{{ $settings['wa_template_overdue'] }}</textarea>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Template OTP Lupa Password
                                <p class="stg-label-desc">Pesan WhatsApp yang dikirimkan saat pengguna meminta kode OTP untuk merubah kata sandi. Variabel: <code>{name}</code>, <code>{otp}</code></p>
                            </div>
                            <div>
                                <textarea class="stg-textarea" name="wa_template_otp" rows="3" required>{{ $settings['wa_template_otp'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Popup Settings Panel -->
                    <div id="tab-popup" class="stg-tab-content" style="display: none;">
                        <div class="stg-panel-title">
                            <i class="fas fa-window-restore" style="color: var(--primary-red);"></i> Pengaturan Pop-up Pengumuman
                        </div>
                        <p class="stg-panel-sub">Kelola pop-up pengumuman aktifitas melapak yang akan muncul ketika pengunjung pertama kali membuka website.</p>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Status Pop-up
                                <p class="stg-label-desc">Aktifkan untuk menampilkan pop-up pengumuman di Halaman Utama.</p>
                            </div>
                            <div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="popup_status" value="1" {{ $settings['popup_status'] === '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Tipe Pop-up Aktif
                                <p class="stg-label-desc">Pilih pengumuman mana yang sedang aktif saat ini.</p>
                            </div>
                            <div>
                                <select class="stg-select" name="popup_active_type">
                                    <option value="buka" {{ $settings['popup_active_type'] === 'buka' ? 'selected' : '' }}>Buka Lapakan (Sedang Melapak)</option>
                                    <option value="tutup" {{ $settings['popup_active_type'] === 'tutup' ? 'selected' : '' }}>Lapakan Tutup (Selesai Melapak)</option>
                                </select>
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Foto Pop-up "Buka Lapakan"
                                <p class="stg-label-desc">Pilih foto/banner pengumuman saat lapakan dibuka. Format: JPEG, PNG, JPG, WEBP (Maks: 2MB).</p>
                            </div>
                            <div>
                                <input type="file" class="stg-input" name="popup_buka_image" accept="image/*">
                                @if(!empty($settings['popup_buka_image']))
                                    <div style="margin-top: 10px;">
                                        <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 5px;">Preview Saat Ini:</p>
                                        <img src="{{ asset($settings['popup_buka_image']) }}" alt="Buka Lapakan Preview" style="max-height: 150px; border-radius: 8px; border: 1px solid #cbd5e1;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="stg-form-row">
                            <div class="stg-label">
                                Foto Pop-up "Lapakan Tutup"
                                <p class="stg-label-desc">Pilih foto/banner pengumuman saat lapakan ditutup. Format: JPEG, PNG, JPG, WEBP (Maks: 2MB).</p>
                            </div>
                            <div>
                                <input type="file" class="stg-input" name="popup_tutup_image" accept="image/*">
                                @if(!empty($settings['popup_tutup_image']))
                                    <div style="margin-top: 10px;">
                                        <p style="font-size: 0.75rem; font-weight: 700; color: #64748b; margin-bottom: 5px;">Preview Saat Ini:</p>
                                        <img src="{{ asset($settings['popup_tutup_image']) }}" alt="Lapakan Tutup Preview" style="max-height: 150px; border-radius: 8px; border: 1px solid #cbd5e1;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 6. Backup & Cache Panel (Submit disabled for backup/clear buttons) -->
                    <div id="tab-maintenance" class="stg-tab-content" style="display: none;">
                        <div class="stg-panel-title">
                            <i class="fas fa-server" style="color: var(--primary-red);"></i> Pemeliharaan & Data Backup
                        </div>
                        <p class="stg-panel-sub">Cadangkan database sistem atau segarkan cache server secara berkala.</p>

                        <div class="stg-card-grid">
                            <!-- Backup Database Card -->
                            <div class="stg-action-card">
                                <div>
                                    <div class="stg-card-title">
                                        <i class="fas fa-database" style="color: #64748b;"></i> Database Backup SQL
                                    </div>
                                    <p class="stg-card-desc" style="margin-top: 8px;">Unduh salinan lengkap struktur tabel dan data database <code>nyilih</code> secara realtime dalam format standar file SQL (.sql).</p>
                                </div>
                                <a href="{{ url('/admin/setting/backup') }}" class="stg-btn stg-btn--outline" style="text-decoration: none;">
                                    <i class="fas fa-download"></i> Unduh Backup Database
                                </a>
                            </div>

                            <!-- Clear Cache Card -->
                            <div class="stg-action-card">
                                <div>
                                    <div class="stg-card-title">
                                        <i class="fas fa-eraser" style="color: #64748b;"></i> Pembersihan Cache Aplikasi
                                    </div>
                                    <p class="stg-card-desc" style="margin-top: 8px;">Menghapus cache konfigurasi, cache routing, dan kompilasi view Blade lama pada server untuk menyegarkan perubahan terbaru.</p>
                                </div>
                                <button type="button" class="stg-btn stg-btn--danger" onclick="triggerClearCache();">
                                    <i class="fas fa-trash-alt"></i> Hapus Cache Aplikasi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Common Submit Row (Hidden for maintenance tab) -->
                    <div class="stg-action-row" id="stg-submit-row">
                        <button type="button" class="stg-btn stg-btn--outline" onclick="window.location.reload();">DISCARD</button>
                        <button type="submit" class="stg-btn stg-btn--save">
                            <i class="fas fa-save"></i> Simpan Pengaturan
                        </button>
                    </div>

                </form>

                <!-- Hidden form for clearing cache -->
                <form id="clear-cache-form" action="{{ url('/admin/setting/clear-cache') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

        </div>

    </div>

    <script>
        // Switch between tabs in settings panel
        function switchTab(evt, tabId) {
            evt.preventDefault();

            // Hide all tab contents
            const contents = document.querySelectorAll('.stg-tab-content');
            contents.forEach(content => content.style.display = 'none');

            // Deactivate all tab buttons
            const buttons = document.querySelectorAll('.stg-tab-button');
            buttons.forEach(button => button.classList.remove('active'));

            // Show active tab
            document.getElementById(tabId).style.display = 'block';
            evt.currentTarget.classList.add('active');

            // Hide submit row on backup/maintenance tab since it contains immediate independent actions
            const submitRow = document.getElementById('stg-submit-row');
            if (tabId === 'tab-maintenance') {
                submitRow.style.display = 'none';
            } else {
                submitRow.style.display = 'flex';
            }
        }

        // Trigger cache clear via POST form submission
        function triggerClearCache() {
            if (confirm('Apakah Anda yakin ingin menghapus semua cache aplikasi? Tindakan ini akan menyegarkan view server.')) {
                document.getElementById('clear-cache-form').submit();
            }
        }
    </script>
</body>
</html>
