<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen E-Book - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <!-- Navbar Component -->
    @include('pages.admin.components.navbar-admin')

    <!-- Page Content -->
    <div class="admin-content">
        
        <div class="page-header">
            <div class="page-title-group">
                <span class="page-subtitle">E-BOOK ARCHIVE</span>
                <h1 class="page-title">Manajemen<br>E-Book</h1>
            </div>
            <div class="page-actions" style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                @php $totalMenunggu = \App\Models\EbookPeminjaman::where('status','Menunggu')->count(); @endphp
                <a href="{{ url('/admin/ebook/peminjaman') }}" class="btn-cancel" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; padding:0.7rem 1.2rem; border-radius:8px; position:relative;">
                    <i class="fas fa-clock"></i> PEMINJAMAN E-BOOK
                    @if($totalMenunggu > 0)
                        <span style="background:#D97706;color:#fff;font-size:0.68rem;font-weight:800;padding:2px 7px;border-radius:9999px;margin-left:4px;">{{ $totalMenunggu }}</span>
                    @endif
                </a>
                <a href="{{ url('/admin/ebook/tambah') }}" class="btn-admin-primary">
                    <i class="fas fa-plus"></i> UPLOAD E-BOOK BARU
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div style="background-color: #E6F4EA; border-left: 4px solid #137333; color: #137333; padding: 1rem; border-radius: 6px; margin-bottom: 2rem; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Filters & Stats -->
        <div class="book-management-top" style="align-items: stretch;">
            <div class="filter-card" style="display: flex; align-items: center; justify-content: space-between; flex: 1;">
                <div class="filter-group-row" style="width: 100%;">
                    <form action="{{ url('/admin/ebook') }}" method="GET" style="display: flex; gap: 1rem; width: 100%; align-items: center;">
                        <div class="filter-group" style="flex: 1;">
                            <span class="filter-group-title">CARI E-BOOK</span>
                            <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem;">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Judul, penulis, kategori..." class="form-control" style="background-color: var(--bg-white); border: 1.5px solid var(--border-color); border-radius: 8px; padding: 0.5rem 1rem; outline: none; font-family: var(--font-main); font-size: 0.9rem; color: var(--text-dark); width: 100%; max-width: 300px;">
                                <button type="submit" class="btn-admin-primary" style="padding: 0.5rem 1.2rem; font-size: 0.85rem;"><i class="fas fa-search"></i> FILTER</button>
                                @if(request('q'))
                                    <a href="{{ url('/admin/ebook') }}" class="btn-cancel" style="padding: 0.5rem 1.2rem; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; border-radius: 6px;">RESET</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="total-collection-card">
                <span class="title">TOTAL E-BOOKS</span>
                <div class="value">{{ number_format($totalEbooks) }} <span class="unit">Buku</span></div>
                <i class="fas fa-file-pdf bg-icon"></i>
            </div>
        </div>

        <!-- Data Table -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>COVER & TITLE</th>
                        <th>AUTHOR / PUBLISHER</th>
                        <th>GENRE</th>
                        <th>PAGES</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ebooks as $eb)
                    <tr>
                        <td>
                            <div class="td-book-info">
                                <img src="{{ Storage::url($eb->cover) }}" alt="Cover" class="td-book-cover" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                                <div class="td-book-details">
                                    <a href="{{ url('/admin/ebook/detail/' . $eb->id) }}" style="text-decoration: none; font-weight: 700; color: var(--text-dark);" class="td-book-title">{{ $eb->judul }}</a>
                                    <span class="td-book-sku">ISBN: {{ $eb->isbn ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="td-author">
                            <div style="display: flex; flex-direction: column;">
                                <span>{{ $eb->penulis }}</span>
                                <small style="color: var(--text-muted); font-size: 0.75rem;">{{ $eb->penerbit }} ({{ $eb->tahun_terbit }})</small>
                            </div>
                        </td>
                        <td class="td-genre">{{ strtoupper($eb->kategori) }}</td>
                        <td class="td-genre">{{ $eb->jumlah_halaman }} Hlm</td>
                        <td>
                            @if(strtolower($eb->status) === 'aktif')
                                <span class="status-pill status-ready">
                                    <span class="status-dot"></span> AKTIF
                                </span>
                            @else
                                <span class="status-pill status-borrowed">
                                    <span class="status-dot"></span> NONAKTIF
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.75rem; align-items: center;">
                                <a href="{{ url('/admin/ebook/detail/' . $eb->id) }}" class="action-icon" title="Detail E-Book">
                                    <i class="fas fa-eye" style="color: #10B981;"></i>
                                </a>
                                <a href="{{ url('/admin/ebook/edit/' . $eb->id) }}" class="action-icon" title="Edit E-Book">
                                    <i class="fas fa-edit" style="color: #4A6B8C;"></i>
                                </a>
                                <form action="{{ url('/admin/ebook/delete/' . $eb->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus E-Book ini? File PDF dan cover akan dihapus secara permanen!')" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" class="action-icon" title="Hapus E-Book">
                                        <i class="fas fa-trash-alt" style="color: var(--primary-red);"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                            <i class="fas fa-file-pdf" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: #C8D4CE;"></i>
                            Belum ada E-Book yang diunggah. Silakan klik tombol <strong>Upload E-Book Baru</strong>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="table-footer">
                <span class="table-info">SHOWING {{ $ebooks->firstItem() ?? 0 }} - {{ $ebooks->lastItem() ?? 0 }} OF {{ $ebooks->total() }} ENTRIES</span>
                @if($ebooks->hasPages())
                <div class="pagination">
                    @if ($ebooks->onFirstPage())
                        <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $ebooks->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif

                    @php
                        $start = max(1, $ebooks->currentPage() - 2);
                        $end = min($ebooks->lastPage(), $ebooks->currentPage() + 2);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $ebooks->url(1) }}" class="page-btn">1</a>
                        @if($start > 2)
                            <span class="page-btn" style="border: none; cursor: default; background: transparent; display: flex; align-items: center; justify-content: center;">...</span>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $ebooks->currentPage())
                            <button class="page-btn active">{{ $i }}</button>
                        @else
                            <a href="{{ $ebooks->url($i) }}" class="page-btn">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $ebooks->lastPage())
                        @if($end < $ebooks->lastPage() - 1)
                            <span class="page-btn" style="border: none; cursor: default; background: transparent; display: flex; align-items: center; justify-content: center;">...</span>
                        @endif
                        <a href="{{ $ebooks->url($ebooks->lastPage()) }}" class="page-btn">{{ $ebooks->lastPage() }}</a>
                    @endif

                    @if ($ebooks->hasMorePages())
                        <a href="{{ $ebooks->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
                @endif
            </div>
        </div>

    </div>
    </main>

</body>
</html>
