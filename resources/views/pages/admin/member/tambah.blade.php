<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border-top: 4px solid var(--primary-red);
            padding: 2.5rem;
        }
        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        .form-title {
            font-size: 1.5rem;
            color: var(--text-dark);
            font-weight: 700;
        }
        .form-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            font-family: var(--font-main);
            font-size: 0.9rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-dark);
            background-color: var(--bg-main);
            transition: var(--transition-smooth);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary-red);
            background-color: var(--bg-white);
            box-shadow: 0 0 0 3px rgba(192, 30, 46, 0.1);
        }
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn-submit {
            flex: 1;
            background-color: var(--primary-red);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.8rem;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            text-align: center;
            transition: var(--transition-smooth);
        }
        .btn-submit:hover {
            background-color: var(--primary-red-hover);
        }
        .btn-cancel {
            flex: 1;
            background-color: var(--bg-sidebar);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.8rem;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        .btn-cancel:hover {
            background-color: var(--border-color);
        }
        .error-message {
            color: var(--primary-red);
            font-size: 0.8rem;
            margin-top: 0.4rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    @include('pages.admin.components.navbar-admin')

        <div class="admin-content" style="padding: 2.5rem 1.5rem;">
            
            <div style="margin-bottom: 2rem;">
                <a href="{{ url('/admin/member') }}" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Member
                </a>
            </div>

            <div class="form-container">
                <div class="form-header">
                    <div class="form-title">Tambah Member Baru</div>
                    <div class="form-subtitle">Daftarkan anggota baru ke dalam arsip komunitas Kanca Tegal secara manual.</div>
                </div>

                <form action="{{ url('/admin/member/store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" placeholder="Masukkan nama lengkap member..." required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="whatsapp">No. WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" class="form-input" value="{{ old('whatsapp') }}" placeholder="Contoh: 081234567890..." required>
                        @error('whatsapp')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="alamat">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap..." style="resize: vertical;" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-input" placeholder="Buat password minimal 6 karakter..." required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Masukkan kembali password..." required>
                    </div>

                    <div class="form-actions">
                        <a href="{{ url('/admin/member') }}" class="btn-cancel">Batal</a>
                        <button type="submit" class="btn-submit">Simpan Member</button>
                    </div>
                </form>
            </div>

        </div>
    </main>

</body>
</html>
