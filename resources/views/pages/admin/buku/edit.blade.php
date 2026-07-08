<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <!-- Custom Style for Upload Form -->
    <style>
        .form-container {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 2.5rem;
            margin-top: 2rem;
        }

        @media (max-width: 992px) {
            .form-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        /* Cover Upload Card */
        .cover-upload-card {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: fit-content;
            transition: var(--transition-smooth);
        }

        .cover-upload-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .image-preview-wrapper {
            width: 100%;
            aspect-ratio: 3/4;
            border-radius: 8px;
            background-color: #F4F8F5;
            border: 2px dashed #C8D4CE;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-align: center;
            padding: 1.5rem;
        }

        .image-preview-wrapper:hover {
            border-color: var(--primary-red);
            background-color: #FAF4F4;
        }

        .image-preview-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .upload-placeholder i {
            font-size: 2.5rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            transition: var(--transition-smooth);
        }

        .image-preview-wrapper:hover .upload-placeholder i {
            color: var(--primary-red);
            transform: scale(1.1);
        }

        .upload-placeholder span {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .upload-placeholder p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        /* Form Fields Details */
        .form-details-card {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        @media (max-width: 768px) {
            .form-group.full-width {
                grid-column: span 1;
            }
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-label .required {
            color: var(--primary-red);
        }

        .form-control {
            font-family: var(--font-main);
            width: 100%;
            padding: 0.85rem 1.2rem;
            border: 1.5px solid var(--border-color);
            background-color: #FAFCFA;
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--text-dark);
            outline: none;
            transition: var(--transition-smooth);
        }

        .form-control:focus {
            border-color: var(--primary-red);
            background-color: var(--bg-white);
            box-shadow: 0 0 0 4px rgba(192, 30, 46, 0.1);
        }

        .form-control::placeholder {
            color: #A3B2A9;
            font-weight: 400;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            line-height: 1.5;
        }

        /* Form Footer/Actions */
        .form-actions-bar {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-cancel {
            background-color: transparent;
            color: var(--text-muted);
            border: 1.5px solid var(--border-color);
            padding: 0.9rem 1.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background-color: #F4F8F5;
            color: var(--text-dark);
            border-color: #9FB0A6;
        }

        /* Validation Alerts */
        .validation-alert {
            background-color: #FDF2F2;
            border-left: 4px solid var(--primary-red);
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .validation-alert-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary-red);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .validation-alert-list {
            margin-left: 1.5rem;
            font-size: 0.8rem;
            color: #7A242B;
        }

        .input-error-msg {
            font-size: 0.75rem;
            color: var(--primary-red);
            font-weight: 600;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: var(--primary-red) !important;
            background-color: #FFFDFD !important;
        }
    </style>
</head>
<body>

    <!-- Navbar Component -->
    @include('pages.admin.components.navbar-admin')

    <!-- Page Content -->
    <div class="admin-content">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title-group">
                <span class="page-subtitle">ARCHIVE MANAGEMENT</span>
                <h1 class="page-title">Edit Buku</h1>
            </div>
            <div class="page-actions">
                <a href="{{ url('/admin/buku') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left"></i> KEMBALI
                </a>
            </div>
        </div>

        <!-- Validation errors -->
        @if ($errors->any())
            <div class="validation-alert">
                <div class="validation-alert-title">
                    <i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan pengisian form:
                </div>
                <ul class="validation-alert-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Book edit form -->
        <form action="{{ url('/admin/buku/update/' . $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-container">
                
                <!-- Left: Cover image upload -->
                <div class="cover-upload-card">
                    <span class="form-label" style="align-self: flex-start; margin-bottom: 1rem;">
                        COVER BUKU
                    </span>
                    
                    <div class="image-preview-wrapper" onclick="document.getElementById('fotoInput').click();">
                        @if($buku->foto)
                            <img id="imagePreview" src="{{ str_starts_with($buku->foto, 'http') ? $buku->foto : asset($buku->foto) }}" alt="Cover Preview" style="display: block;">
                            <div class="upload-placeholder" id="uploadPlaceholder" style="display: none;">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>GANTI FOTO</span>
                                <p>PNG, JPG, JPEG atau WEBP (Maks. 2MB)</p>
                            </div>
                        @else
                            <img id="imagePreview" src="" alt="Cover Preview" style="display: none;">
                            <div class="upload-placeholder" id="uploadPlaceholder" style="display: flex;">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>PILIH FOTO</span>
                                <p>PNG, JPG, JPEG atau WEBP (Maks. 2MB)</p>
                            </div>
                        @endif
                        <input type="file" name="foto" id="fotoInput" class="file-input @error('foto') is-invalid @enderror" accept="image/*">
                    </div>
                    @error('foto')
                        <span class="input-error-msg"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <!-- Right: Book fields -->
                <div class="form-details-card">
                    <div class="form-grid">
                        
                        <!-- Judul Buku -->
                        <div class="form-group full-width">
                            <label class="form-label" for="judul">
                                JUDUL BUKU <span class="required">*</span>
                            </label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') ?? $buku->judul }}" placeholder="Contoh: Sang Pemimpi" required>
                            @error('judul')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="form-group">
                            <label class="form-label" for="penulis">
                                NAMA PENULIS <span class="required">*</span>
                            </label>
                            <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis') ?? $buku->penulis }}" placeholder="Contoh: Andrea Hirata" required>
                            @error('penulis')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Penerbit -->
                        <div class="form-group">
                            <label class="form-label" for="penerbit">
                                PENERBIT <span class="required">*</span>
                            </label>
                            <input type="text" name="penerbit" id="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') ?? $buku->penerbit }}" placeholder="Contoh: Bentang Pustaka" required>
                            @error('penerbit')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Jumlah Halaman -->
                        <div class="form-group">
                            <label class="form-label" for="jumlah_halaman">
                                JUMLAH HALAMAN <span class="required">*</span>
                            </label>
                            <input type="number" name="jumlah_halaman" id="jumlah_halaman" class="form-control @error('jumlah_halaman') is-invalid @enderror" value="{{ old('jumlah_halaman') ?? $buku->jumlah_halaman }}" min="1" placeholder="Contoh: 292" required>
                            @error('jumlah_halaman')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- ISBN -->
                        <div class="form-group">
                            <label class="form-label" for="isbn">
                                ISBN <span class="required">*</span>
                            </label>
                            <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn') ?? $buku->isbn }}" placeholder="Contoh: 978-602-291-292-7" required>
                            @error('isbn')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Bahasa -->
                        <div class="form-group">
                            <label class="form-label" for="bahasa">
                                BAHASA <span class="required">*</span>
                            </label>
                            <select name="bahasa" id="bahasa" class="form-control @error('bahasa') is-invalid @enderror" required>
                                <option value="" disabled>Pilih bahasa...</option>
                                <option value="Indonesia" {{ (old('bahasa') ?? $buku->bahasa) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                <option value="English" {{ (old('bahasa') ?? $buku->bahasa) == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Jawa / Tegalan" {{ (old('bahasa') ?? $buku->bahasa) == 'Jawa / Tegalan' ? 'selected' : '' }}>Jawa / Tegalan</option>
                                <option value="Lainnya" {{ (old('bahasa') ?? $buku->bahasa) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('bahasa')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="form-group">
                            <label class="form-label" for="kategori">
                                KATEGORI <span class="required">*</span>
                            </label>
                            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                                <option value="" disabled>Pilih kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ (old('kategori') ?? strtoupper($buku->kategori)) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                                <option value="LAINNYA" {{ old('kategori') == 'LAINNYA' ? 'selected' : '' }}>LAINNYA (TAMBAH KATEGORI BARU...)</option>
                            </select>
                            @error('kategori')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Input Kategori Baru -->
                        <div class="form-group" id="kategori_baru_group" style="display: none;">
                            <label class="form-label" for="kategori_baru">
                                NAMA KATEGORI BARU <span class="required">*</span>
                            </label>
                            <input type="text" name="kategori_baru" id="kategori_baru" class="form-control @error('kategori_baru') is-invalid @enderror" value="{{ old('kategori_baru') }}" placeholder="Contoh: GEOGRAFI">
                            @error('kategori_baru')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status Publish -->
                        <div class="form-group">
                            <label class="form-label" for="status_publish">
                                STATUS PUBLIKASI <span class="required">*</span>
                            </label>
                            <select name="status_publish" id="status_publish" class="form-control @error('status_publish') is-invalid @enderror" required>
                                <option value="publish" {{ (old('status_publish') ?? $buku->status_publish) == 'publish' ? 'selected' : '' }}>PUBLISH</option>
                                <option value="draft" {{ (old('status_publish') ?? $buku->status_publish) == 'draft' ? 'selected' : '' }}>DRAFT</option>
                            </select>
                            @error('status_publish')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sinopsis Singkat -->
                        <div class="form-group full-width">
                            <label class="form-label" for="sinopsis">
                                SINOPSIS SINGKAT <span class="required">*</span>
                            </label>
                            <textarea name="sinopsis" id="sinopsis" class="form-control @error('sinopsis') is-invalid @enderror" placeholder="Tuliskan sinopsis singkat mengenai isi buku ini..." required>{{ old('sinopsis') ?? $buku->sinopsis }}</textarea>
                            @error('sinopsis')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tentang Penulis (Optional) -->
                        <div class="form-group full-width">
                            <label class="form-label" for="tentang_penulis">
                                TENTANG PENULIS <span style="font-size:0.65rem; color: var(--text-muted); font-weight:normal;">(OPSIONAL)</span>
                            </label>
                            <textarea name="tentang_penulis" id="tentang_penulis" class="form-control @error('tentang_penulis') is-invalid @enderror" placeholder="Tulis biografi singkat atau latar belakang penulis buku ini...">{{ old('tentang_penulis') ?? $buku->tentang_penulis }}</textarea>
                            @error('tentang_penulis')
                                <span class="input-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions-bar">
                        <a href="{{ url('/admin/buku') }}" class="btn-cancel">BATAL</a>
                        <button type="submit" class="btn-admin-primary">
                            <i class="fas fa-save"></i> SIMPAN PERUBAHAN
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
    </main>

    <!-- JavaScript to handle photo preview -->
    <script>
        document.getElementById('fotoInput').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                @if($buku->foto)
                    preview.src = "{{ str_starts_with($buku->foto, 'http') ? $buku->foto : asset($buku->foto) }}";
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                @else
                    preview.src = "";
                    preview.style.display = 'none';
                    placeholder.style.display = 'flex';
                @endif
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const kategoriSelect = document.getElementById('kategori');
            const kategoriBaruGroup = document.getElementById('kategori_baru_group');
            const kategoriBaruInput = document.getElementById('kategori_baru');

            function toggleKategoriBaru() {
                if (kategoriSelect.value === 'LAINNYA') {
                    kategoriBaruGroup.style.display = 'flex';
                    kategoriBaruInput.setAttribute('required', 'required');
                } else {
                    kategoriBaruGroup.style.display = 'none';
                    kategoriBaruInput.removeAttribute('required');
                }
            }

            kategoriSelect.addEventListener('change', toggleKategoriBaru);
            toggleKategoriBaru(); // Run on page load
        });
    </script>
</body>
</html>
