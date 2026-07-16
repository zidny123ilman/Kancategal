<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        .detail-container {
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            padding: 2.5rem;
            margin-top: 2rem;
            max-width: 900px;
        }
        
        .article-hero {
            position: relative;
            width: 100%;
            height: 380px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .article-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-category {
            display: inline-block;
            background-color: var(--accent-blue);
            color: white;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.4rem 0.9rem;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .article-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .article-meta .status-badge {
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .status-pending {
            background-color: #FEF7E0;
            color: #B06000;
            border: 1px solid #B06000;
        }

        .status-approved {
            background-color: #E6F4EA;
            color: #137333;
            border: 1px solid #137333;
        }

        .status-rejected {
            background-color: #FDF2F2;
            color: #C01E2E;
            border: 1px solid #C01E2E;
        }

        .article-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #333333;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .support-img-wrapper {
            margin: 2rem 0;
            width: 100%;
            max-height: 400px;
            border-radius: 8px;
            overflow: hidden;
        }

        .support-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .moderation-card {
            background-color: #F8FAF9;
            border: 1.5px dashed #C8D4CE;
            border-radius: 8px;
            padding: 1.5rem 2rem;
            margin-top: 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .moderation-text {
            flex: 1;
            min-width: 250px;
        }

        .moderation-title {
            font-weight: 800;
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .moderation-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .moderation-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-approve-large {
            background-color: #137333;
            color: white;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .btn-approve-large:hover {
            background-color: #0f5d29;
            transform: translateY(-1px);
        }

        .btn-reject-large {
            background-color: var(--primary-red);
            color: white;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .btn-reject-large:hover {
            background-color: #a01826;
            transform: translateY(-1px);
        }
        /* Modal Overlay and Box styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-box {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
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
                <span class="page-subtitle">CURATION HUB</span>
                <h1 class="page-title">Detail Artikel</h1>
            </div>
            <div class="page-actions">
                <a href="{{ url('/admin/artikel') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left"></i> KEMBALI
                </a>
            </div>
        </div>

        <div class="detail-container">
            
            <!-- Hero Image -->
            <div class="article-hero">
                <img src="{{ filter_var($artikel->foto_utama, FILTER_VALIDATE_URL) ? $artikel->foto_utama : asset($artikel->foto_utama) }}" alt="{{ $artikel->judul }}">
            </div>

            <!-- Category -->
            <span class="article-category">{{ $artikel->kategori }}</span>

            <!-- Title -->
            <h1 class="article-title">{{ $artikel->judul }}</h1>

            <!-- Meta Details -->
            <div class="article-meta">
                <span>
                    <i class="fas fa-user-edit"></i> oleh <strong>{{ $artikel->nama_uploader }}</strong>
                </span>
                <span>
                    <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($artikel->tanggal_upload)->format('d M Y') }}
                </span>
                <span>
                    Status: 
                    @if(strtolower($artikel->status) === 'approved')
                        <span class="status-badge status-approved">PUBLISHED</span>
                    @elseif(strtolower($artikel->status) === 'pending')
                        <span class="status-badge status-pending">PENDING ACC</span>
                    @else
                        <span class="status-badge status-rejected">REJECTED</span>
                    @endif
                </span>
            </div>

            <!-- Article Body Content -->
            <div class="article-body">
                @foreach (explode("\n", $artikel->isi) as $paragraph)
                    @if(trim($paragraph))
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                    @endif
                @endforeach
            </div>

            <!-- Supporting Image if present -->
            @if($artikel->foto_pendukung)
                <div class="support-img-wrapper">
                    <img src="{{ filter_var($artikel->foto_pendukung, FILTER_VALIDATE_URL) ? $artikel->foto_pendukung : asset($artikel->foto_pendukung) }}" alt="Supporting Image">
                </div>
            @endif

            <!-- Moderation Action Panel if Pending -->
            @if(strtolower($artikel->status) === 'pending')
                <div class="moderation-card">
                    <div class="moderation-text">
                        <div class="moderation-title">Keputusan Moderasi</div>
                        <div class="moderation-desc">Sebagai admin, Anda dapat menyetujui artikel untuk dipublikasikan atau menolaknya.</div>
                    </div>
                    <div class="moderation-actions">
                        <button type="button" class="btn-reject-large" onclick="openRejectModal({{ $artikel->id }}, '{{ addslashes($artikel->judul) }}')">TOLAK</button>
                        <form action="{{ url('/admin/artikel/' . $artikel->id . '/approve') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-approve-large">SETUJUI</button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

    </div>
    </main>

    <!-- Reject Modal -->
    <div class="modal-overlay" id="reject-article-modal">
        <div class="modal-box">
            <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:0.5rem; color:#1e2e25; display:flex; align-items:center; gap:8px;">
                <i class="fas fa-times-circle" style="color:var(--primary-red);"></i> Tolak Artikel
            </h3>
            <p style="font-size:0.85rem; color:#64748b; margin-bottom:1.5rem;">
                Tolak artikel <strong id="reject-modal-title"></strong>? Anda harus memberikan alasan penolakan yang akan dikirimkan ke penulis melalui WhatsApp.
            </p>
            <form id="reject-modal-form" action="" method="POST">
                @csrf
                <label style="font-size:0.75rem; font-weight:800; color:#334155; display:block; margin-bottom:0.5rem; text-transform:uppercase; letter-spacing:0.5px;">ALASAN PENOLAKAN</label>
                <textarea name="alasan_ditolak" rows="3" placeholder="Tulis alasan penolakan di sini..." style="width:100%; border:1.5px solid #cbd2c8; border-radius:8px; padding:0.75rem; font-size:0.9rem; font-family:inherit; resize:vertical; box-sizing:border-box; margin-bottom:1.5rem;" required></textarea>
                <div style="display:flex; justify-content:flex-end; gap:0.75rem;">
                    <button type="button" onclick="closeRejectModal()" class="btn-admin-secondary" style="padding:0.6rem 1.2rem; border-radius:6px; border:none; font-weight:700; cursor:pointer;">Batal</button>
                    <button type="submit" class="btn-reject-large" style="padding:0.6rem 1.5rem; border-radius:6px; border:none; font-weight:700; cursor:pointer;">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id, title) {
            const modal = document.getElementById('reject-article-modal');
            const form = document.getElementById('reject-modal-form');
            const titleElem = document.getElementById('reject-modal-title');
            
            form.action = "{{ url('/admin/artikel') }}/" + id + "/reject";
            titleElem.textContent = title;
            modal.classList.add('show');
        }
        
        function closeRejectModal() {
            document.getElementById('reject-article-modal').classList.remove('show');
        }
        
        document.getElementById('reject-article-modal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });
    </script>

</body>
</html>
