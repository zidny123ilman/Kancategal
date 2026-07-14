<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail E-Book - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        .detail-wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2.5rem;
            margin-top: 2rem;
        }
        
        @media (max-width: 992px) {
            .detail-wrapper {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
        
        .cover-card {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: fit-content;
        }
        
        .cover-img {
            width: 100%;
            aspect-ratio: 3/4;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .info-card {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }
        
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .meta-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .meta-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .meta-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .meta-value {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 2.5rem;
        }
        
        @media (max-width: 992px) {
            .stats-strip {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .stats-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .stat-strip-card {
            background: #FAFCFA;
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        
        .stat-strip-val {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1A56DB;
            display: block;
        }
        
        .stat-strip-lbl {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-top: 2px;
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
                <span class="page-subtitle">E-BOOK ARCHIVE</span>
                <h1 class="page-title">Detail E-Book</h1>
            </div>
            <div class="page-actions">
                <a href="{{ url('/admin/ebook') }}" class="btn-admin-secondary">
                    <i class="fas fa-arrow-left"></i> KEMBALI
                </a>
                <a href="{{ url('/admin/ebook/edit/' . $ebook->id) }}" class="btn-admin-primary">
                    <i class="fas fa-edit"></i> EDIT E-BOOK
                </a>
            </div>
        </div>

        <div class="detail-wrapper">
            <!-- Left Panel -->
            <div class="cover-card">
                <img src="{{ Storage::url($ebook->cover) }}" alt="Cover" class="cover-img">
                <span class="form-label" style="margin-bottom: 0.5rem;">STATUS E-BOOK</span>
                @if(strtolower($ebook->status) === 'aktif')
                    <span class="status-pill status-ready" style="font-size: 0.85rem; padding: 6px 16px;">
                        <span class="status-dot"></span> AKTIF
                    </span>
                @else
                    <span class="status-pill status-borrowed" style="font-size: 0.85rem; padding: 6px 16px;">
                        <span class="status-dot"></span> NONAKTIF
                    </span>
                @endif
                
                @if($ebook->file_pdf)
                    <a href="{{ url('/ebook/' . $ebook->id . '/read') }}" target="_blank" class="btn-admin-secondary" style="margin-top: 1.5rem; width: 100%; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-book-open"></i> BACA BUKU
                    </a>
                @endif
            </div>

            <!-- Right Panel -->
            <div class="info-card">
                <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.25rem;">{{ $ebook->judul }}</h2>
                <p style="font-size: 1.1rem; color: var(--text-muted); font-weight: 600; margin-bottom: 2rem;">karya {{ $ebook->penulis }}</p>
                
                <!-- Statistics Strip -->
                <div class="stats-strip">
                    <div class="stat-strip-card">
                        <span class="stat-strip-val">{{ $totalBorrowed }}x</span>
                        <span class="stat-strip-lbl">Total Dipinjam</span>
                    </div>
                    <div class="stat-strip-card">
                        <span class="stat-strip-val">{{ $totalReaders }}</span>
                        <span class="stat-strip-lbl">Jumlah Pembaca</span>
                    </div>
                    <div class="stat-strip-card">
                        <span class="stat-strip-val" style="color: #F59E0B;">{{ number_format($averageRating, 1) }} ★</span>
                        <span class="stat-strip-lbl">Rata-rata Rating</span>
                    </div>
                    <div class="stat-strip-card">
                        <span class="stat-strip-val">{{ $totalReviews }}</span>
                        <span class="stat-strip-lbl">Ulasan / Review</span>
                    </div>
                    <div class="stat-strip-card">
                        <span class="stat-strip-val" style="color: #EC4899;">{{ number_format($averageProgress, 1) }}%</span>
                        <span class="stat-strip-lbl">Progress Pembaca</span>
                    </div>
                </div>

                <!-- Meta Grid Info -->
                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Penerbit</span>
                        <span class="meta-value">{{ $ebook->penerbit }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tahun Terbit</span>
                        <span class="meta-value">{{ $ebook->tahun_terbit }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Kategori</span>
                        <span class="meta-value">{{ strtoupper($ebook->kategori) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">ISBN</span>
                        <span class="meta-value">{{ $ebook->isbn ?? '-' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Jumlah Halaman</span>
                        <span class="meta-value">{{ $ebook->jumlah_halaman }} Halaman</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tanggal Upload</span>
                        <span class="meta-value">{{ $ebook->created_at->format('d-m-Y') }}</span>
                    </div>
                </div>

                <!-- Sinopsis -->
                <div style="margin-top: 2rem;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">SINOPSIS</h3>
                    <p style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; white-space: pre-line;">{{ $ebook->sinopsis }}</p>
                </div>
            </div>
        </div>

    </div>
    </main>

</body>
</html>
