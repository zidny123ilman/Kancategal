<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Artikel Baru - Kanca Tegal</title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="Tulis dan unggah artikel, esai, atau ulasan literasi Anda untuk disebarkan di komunitas Kanca Tegal.">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    <style>
        .upload-page-container {
            max-width: 800px;
            margin: 4rem auto;
            padding: 0 2rem;
        }
        
        .upload-card {
            background-color: var(--bg-white);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .upload-title-group {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .upload-badge {
            background-color: rgba(42, 91, 122, 0.1);
            color: var(--accent-blue);
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .upload-main-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--text-dark);
        }

        .upload-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.6rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--bg-theme);
            color: var(--text-dark);
            font-family: var(--font-main);
            font-size: 0.95rem;
            outline: none;
            transition: var(--transition-smooth);
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--accent-blue);
            background-color: var(--bg-white);
            box-shadow: 0 0 0 3px rgba(42, 91, 122, 0.15);
        }

        /* File Input Styling */
        .file-upload-wrapper {
            position: relative;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background-color: var(--bg-theme);
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .file-upload-wrapper:hover {
            border-color: var(--accent-blue);
            background-color: rgba(42, 91, 122, 0.02);
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-icon {
            font-size: 2rem;
            color: var(--text-muted);
            margin-bottom: 0.8rem;
        }

        .file-upload-text {
            font-size: 0.9rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .file-upload-subtext {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        /* Custom Editor Toolbar Styling */
        .editor-container {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            background-color: var(--bg-white);
        }

        .editor-toolbar {
            background-color: var(--bg-theme);
            border-bottom: 1px solid var(--border-color);
            padding: 0.6rem;
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .toolbar-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition-smooth);
        }

        .toolbar-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: var(--text-dark);
        }

        .toolbar-divider {
            width: 1px;
            height: 20px;
            background-color: var(--border-color);
            margin: 0 0.3rem;
        }

        .editor-textarea {
            width: 100%;
            min-height: 300px;
            padding: 1.2rem;
            border: none;
            outline: none;
            resize: vertical;
            font-family: var(--font-main);
            font-size: 1rem;
            line-height: 1.7;
            color: var(--text-dark);
        }

        /* Live Preview Styling */
        .preview-container {
            margin-top: 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--bg-theme);
            padding: 1.5rem;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .preview-badge {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .preview-content {
            font-size: 0.95rem;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .preview-content p {
            margin-bottom: 1rem;
        }

        .preview-content blockquote {
            border-left: 3px solid var(--primary-red);
            padding-left: 1rem;
            font-style: italic;
            color: var(--text-muted);
            margin: 1.5rem 0;
        }

        .btn-submit-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
        }

        .btn-cancel {
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .btn-cancel:hover {
            color: var(--primary-red);
        }

        .btn-submit-artikel {
            background-color: var(--accent-blue);
            color: var(--text-light);
            padding: 1rem 2.5rem;
            border-radius: 9999px;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(42, 91, 122, 0.2);
        }

        .btn-submit-artikel:hover {
            background-color: var(--accent-blue-grey);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(42, 91, 122, 0.3);
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .upload-page-container {
                margin: 2rem auto;
                padding: 0 1rem;
            }

            .upload-card {
                padding: 1.5rem;
                border-radius: 12px;
            }

            .upload-main-title {
                font-size: 1.8rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .btn-submit-container {
                flex-direction: column-reverse;
                gap: 1rem;
                align-items: stretch;
            }

            .btn-submit-artikel, .btn-cancel {
                width: 100%;
                text-align: center;
                justify-content: center;
                padding: 0.8rem;
            }
            
            .btn-cancel {
                padding: 0.8rem;
                border: 1px solid var(--border-color);
                border-radius: 9999px;
            }

            .file-upload-wrapper {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <main class="upload-page-container">
        
        <div class="upload-card">
            
            <div class="upload-title-group">
                <span class="upload-badge">Kontribusi Komunitas</span>
                <h1 class="upload-main-title">Unggah Artikel Baru</h1>
                <p class="upload-subtitle">Tulis gagasan, esai, atau ulasan menarik Anda. Tulisan Anda akan ditinjau oleh tim kurator sebelum diterbitkan.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.85rem;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($draft)
                <div style="background-color: rgba(226, 123, 0, 0.1); border: 1px solid #E27B00; color: #E27B00; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.85rem; display: flex; align-items: center; justify-content: space-between;">
                    <span><i class="fas fa-edit"></i> Melanjutkan draf Anda sebelumnya yang disimpan pada <strong>{{ $draft->updated_at->format('d M Y H:i') }}</strong>.</span>
                </div>
            @endif

            <form action="{{ url('/upload-artikel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Judul Artikel -->
                <div class="form-group">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" id="judul" name="judul" class="form-input" placeholder="Tulis judul yang menarik..." value="{{ old('judul', $draft->judul ?? '') }}">
                </div>

                <div class="form-row">
                    <!-- Nama Uploader -->
                    <div class="form-group">
                        <label for="nama_uploader" class="form-label">Nama Uploader</label>
                        <input type="text" id="nama_uploader" name="nama_uploader" class="form-input" placeholder="Nama Anda..." value="{{ old('nama_uploader', $draft->nama_uploader ?? Auth::user()->name) }}">
                    </div>

                    <!-- Tanggal Upload -->
                    <div class="form-group">
                        <label for="tanggal_upload" class="form-label">Tanggal Upload</label>
                        <input type="date" id="tanggal_upload" name="tanggal_upload" class="form-input" value="{{ old('tanggal_upload', $draft->tanggal_upload ?? date('Y-m-d')) }}">
                    </div>
                </div>

                <div class="form-row">
                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="kategori" class="form-label">Kategori</label>
                        @php
                            $stdCategories = ['ESAI', 'SASTRA', 'LITERASI', 'JURNALISTIK'];
                            $draftCategory = $draft ? $draft->kategori : '';
                            $isCustomCategory = $draftCategory && !in_array(strtoupper($draftCategory), $stdCategories);
                        @endphp
                        <select id="kategori" name="kategori" class="form-select" onchange="checkCategory(this)">
                            <option value="" disabled {{ !$draftCategory ? 'selected' : '' }}>Pilih kategori...</option>
                            <option value="ESAI" {{ old('kategori', $draftCategory) === 'ESAI' ? 'selected' : '' }}>Esai</option>
                            <option value="SASTRA" {{ old('kategori', $draftCategory) === 'SASTRA' ? 'selected' : '' }}>Sastra</option>
                            <option value="LITERASI" {{ old('kategori', $draftCategory) === 'LITERASI' ? 'selected' : '' }}>Literasi</option>
                            <option value="JURNALISTIK" {{ old('kategori', $draftCategory) === 'JURNALISTIK' ? 'selected' : '' }}>Jurnalistik</option>
                            <option value="LAINNYA" {{ (old('kategori') === 'LAINNYA' || $isCustomCategory) ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        
                        <div class="form-group" id="kategori_baru_container" style="display: {{ (old('kategori') === 'LAINNYA' || $isCustomCategory) ? 'block' : 'none' }}; margin-top: 1rem;">
                            <label for="kategori_baru" class="form-label">Kategori Baru</label>
                            <input type="text" id="kategori_baru" name="kategori_baru" class="form-input" placeholder="Masukkan nama kategori baru..." value="{{ old('kategori_baru', $isCustomCategory ? $draftCategory : '') }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Keywords -->
                    <div class="form-group">
                        <label for="keywords" class="form-label">Kata Kunci (Keywords)</label>
                        <input type="text" id="keywords" name="keywords" class="form-input" placeholder="Pisahkan dengan koma (misal: literasi, budaya, tegal)" value="{{ old('keywords', $draft->keywords ?? '') }}" required>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 5px;">Minimal 1 kata kunci.</span>
                    </div>

                    <!-- Foto Pendukung -->
                    <div class="form-group">
                        <label for="foto_pendukung" class="form-label">Foto Pendukung (Opsional)</label>
                        <input type="file" id="foto_pendukung" name="foto_pendukung" class="form-input" accept="image/*" style="padding: 0.6rem;">
                        @if($draft && !empty($draft->foto_pendukung))
                            <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 10px;">
                                <img src="{{ asset($draft->foto_pendukung) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                                <span style="font-size: 0.75rem; color: var(--text-muted);">Foto pendukung terunggah.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Foto Utama -->
                <div class="form-group">
                    <label class="form-label">Foto Utama Cover</label>
                    <div class="file-upload-wrapper">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text" id="file-upload-label">
                            @if($draft && !empty($draft->foto_utama) && $draft->foto_utama !== 'uploads/articles/default.jpg')
                                Terpilih: {{ basename($draft->foto_utama) }}
                            @else
                                Pilih atau Seret Foto Cover Utama di Sini
                            @endif
                        </div>
                        <div class="file-upload-subtext">Hanya file JPG, PNG, WEBP maksimal 2MB</div>
                        <input type="file" name="foto_utama" class="file-upload-input" accept="image/*" onchange="updateFileName(this)">
                    </div>
                    @if($draft && !empty($draft->foto_utama) && $draft->foto_utama !== 'uploads/articles/default.jpg')
                        <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 10px;">
                            <img src="{{ asset($draft->foto_utama) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                            <span style="font-size: 0.8rem; color: var(--text-muted);">Cover saat ini sudah tersimpan. Unggah file baru untuk menggantinya.</span>
                        </div>
                    @endif
                </div>

                <!-- Isi Artikel (Editor) -->
                <div class="form-group">
                    <label for="isi" class="form-label">Isi Artikel Lengkap</label>
                    <div class="editor-container">
                        <div class="editor-toolbar">
                            <button type="button" class="toolbar-btn" title="Bold" onclick="insertTag('<b>', '</b>')"><i class="fas fa-bold"></i></button>
                            <button type="button" class="toolbar-btn" title="Italic" onclick="insertTag('<i>', '</i>')"><i class="fas fa-italic"></i></button>
                            <button type="button" class="toolbar-btn" title="Underline" onclick="insertTag('<u>', '</u>')"><i class="fas fa-underline"></i></button>
                            <span class="toolbar-divider"></span>
                            <button type="button" class="toolbar-btn" title="Heading 3" onclick="insertTag('<h3>', '</h3>')"><i class="fas fa-heading"></i></button>
                            <button type="button" class="toolbar-btn" title="Blockquote" onclick="insertTag('<blockquote>', '</blockquote>')"><i class="fas fa-quote-left"></i></button>
                            <span class="toolbar-divider"></span>
                            <button type="button" class="toolbar-btn" title="List Item" onclick="insertTag('<li>', '</li>')"><i class="fas fa-list-ul"></i></button>
                            <button type="button" class="toolbar-btn" title="Paragraph" onclick="insertTag('<p>', '</p>')"><i class="fas fa-paragraph"></i></button>
                        </div>
                        <textarea id="isi" name="isi" class="editor-textarea" placeholder="Tulis isi tulisan Anda di sini..." oninput="updatePreview()">{{ old('isi', $draft->isi ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Live Preview Panel -->
                <div class="preview-container">
                    <div class="preview-header">
                        <span class="preview-badge">Live Preview Tampilan Konten</span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);"><i class="far fa-eye"></i> Tampilan Instan</span>
                    </div>
                    <div class="preview-content" id="live-preview-content">
                        <p style="color: var(--text-muted); font-style: italic;">Pratinjau tulisan Anda akan muncul di sini secara real-time...</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="btn-submit-container">
                    <a href="{{ url('/artikel') }}" class="btn-cancel">Batal</a>
                    <div style="display: flex; gap: 1rem;">
                        @if($draft)
                            <button type="submit" name="action" value="discard" class="btn-submit-artikel" style="background-color: var(--primary-red); box-shadow: 0 4px 10px rgba(192, 30, 46, 0.2);" onclick="return confirm('Hapus draf ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus Draf
                            </button>
                        @endif
                        <button type="submit" name="action" value="draft" class="btn-submit-artikel" style="background-color: #E27B00; box-shadow: 0 4px 10px rgba(226, 123, 0, 0.2);">
                            <i class="fas fa-save"></i> Simpan Draf
                        </button>
                        <button type="submit" name="action" value="publish" class="btn-submit-artikel">
                            <i class="fas fa-paper-plane"></i> Unggah Artikel
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </main>

    <!-- Footer -->
    <footer class="footer" style="margin-top: 6rem;">
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

    <!-- JS Functionality -->
    <script>
        function updateFileName(input) {
            const label = document.getElementById('file-upload-label');
            if (input.files && input.files[0]) {
                label.textContent = "Terpilih: " + input.files[0].name;
                label.style.color = "var(--accent-blue)";
            } else {
                label.textContent = "Pilih atau Seret Foto Cover Utama di Sini";
                label.style.color = "var(--text-dark)";
            }
        }

        function insertTag(openTag, closeTag) {
            const textarea = document.getElementById('isi');
            const startPos = textarea.selectionStart;
            const endPos = textarea.selectionEnd;
            const text = textarea.value;
            
            const selectedText = text.substring(startPos, endPos);
            const replacement = openTag + selectedText + closeTag;
            
            textarea.value = text.substring(0, startPos) + replacement + text.substring(endPos, text.length);
            
            // Restore selection/focus
            textarea.focus();
            textarea.selectionStart = startPos + openTag.length;
            textarea.selectionEnd = startPos + openTag.length + selectedText.length;
            
            updatePreview();
        }

        function updatePreview() {
            const textarea = document.getElementById('isi');
            const preview = document.getElementById('live-preview-content');
            
            if (textarea.value.trim() === '') {
                preview.innerHTML = '<p style="color: var(--text-muted); font-style: italic;">Pratinjau tulisan Anda akan muncul di sini secara real-time...</p>';
                return;
            }
            
            // Replace double newlines with paragraphs if not already wrapped in p tags
            let text = textarea.value;
            
            // Convert simple formatting
            let formattedHtml = text;
            
            // If they didn't write HTML tags, convert newlines to paragraphs
            if (!formattedHtml.includes('<p>') && !formattedHtml.includes('<br>')) {
                formattedHtml = formattedHtml.split(/\n\n+/).map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');
            }
            
            preview.innerHTML = formattedHtml;
        }

        function checkCategory(select) {
            const container = document.getElementById('kategori_baru_container');
            const input = document.getElementById('kategori_baru');
            if (select.value === 'LAINNYA') {
                container.style.display = 'block';
                input.required = true;
                input.focus();
            } else {
                container.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updatePreview();
        });
    </script>
</body>
</html>
