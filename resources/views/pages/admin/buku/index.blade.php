<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Buku - Admin Kanca Tegal</title>
    
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
                    <span class="page-subtitle">ARCHIVE MANAGEMENT</span>
                    <h1 class="page-title">Manajemen<br>Buku</h1>
                </div>
                <div class="page-actions">
                    <a href="{{ url('/admin/peminjaman/export-excel') }}" class="btn-admin-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-download"></i> EKSPOR LAPORAN PEMINJAMAN
                    </a>
                    <a href="{{ url('/admin/buku/tambah') }}" class="btn-admin-primary">
                        <i class="fas fa-plus"></i> UPLOAD BUKU BARU
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
            <div class="book-management-top">
                <div class="filter-card">
                    <div class="filter-group-row">
                        <div class="filter-group" style="flex: 1;">
                            <span class="filter-group-title">GENRE ARCHIVE</span>
                            <select onchange="location = this.value;" class="form-control" style="background-color: var(--bg-white); border: 1.5px solid var(--border-color); border-radius: 8px; padding: 0.5rem 1rem; outline: none; font-family: var(--font-main); font-size: 0.9rem; color: var(--text-dark); cursor: pointer; max-width: 250px; margin-top: 0.5rem;">
                                <option value="{{ request()->fullUrlWithQuery(['genre' => 'all']) }}" {{ !$genre || strtolower($genre) === 'all' ? 'selected' : '' }}>SEMUA GENRE (ALL)</option>
                                @foreach($genres as $g)
                                    <option value="{{ request()->fullUrlWithQuery(['genre' => $g]) }}" {{ strtolower($genre) === strtolower($g) ? 'selected' : '' }}>{{ strtoupper($g) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group" style="flex: 1;">
                            <span class="filter-group-title">AVAILABILITY</span>
                            <div class="filter-pills" style="gap: 1.5rem; background: transparent;">
                                <a href="{{ request()->fullUrlWithQuery(['availability' => 'all']) }}" class="filter-pill-text {{ !$availability || strtolower($availability) === 'all' ? 'active' : '' }}" style="text-decoration: none;">All</a>
                                <a href="{{ request()->fullUrlWithQuery(['availability' => 'ready']) }}" class="filter-pill-text {{ strtolower($availability) === 'ready' ? 'active' : '' }}" style="text-decoration: none;">Ready</a>
                                <a href="{{ request()->fullUrlWithQuery(['availability' => 'borrowed']) }}" class="filter-pill-text {{ strtolower($availability) === 'borrowed' ? 'active' : '' }}" style="text-decoration: none;">Borrowed</a>
                                <a href="{{ request()->fullUrlWithQuery(['availability' => 'publish']) }}" class="filter-pill-text {{ strtolower($availability) === 'publish' ? 'active' : '' }}" style="text-decoration: none;">Publish</a>
                                <a href="{{ request()->fullUrlWithQuery(['availability' => 'draft']) }}" class="filter-pill-text {{ strtolower($availability) === 'draft' ? 'active' : '' }}" style="text-decoration: none;">Draft</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="total-collection-card">
                    <span class="title">TOTAL COLLECTION</span>
                    <div class="value">{{ number_format($totalCollection) }} <span class="unit">Vol.</span></div>
                    <i class="fas fa-book-open bg-icon"></i>
                </div>
            </div>

            <!-- Data Table -->
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>COVER & TITLE</th>
                            <th>AUTHOR</th>
                            <th>GENRE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $buku)
                        <tr>
                            <td>
                                <div class="td-book-info">
                                    @if(str_starts_with($buku->foto, 'http'))
                                        <img src="{{ $buku->foto }}" alt="Cover" class="td-book-cover">
                                    @else
                                        <img src="{{ asset($buku->foto) }}" alt="Cover" class="td-book-cover">
                                    @endif
                                    <div class="td-book-details">
                                        <span class="td-book-title">{{ $buku->judul }}</span>
                                        <span class="td-book-sku">ISBN-{{ $buku->isbn }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="td-author">{{ $buku->penulis }}</td>
                            <td class="td-genre">{{ strtoupper($buku->kategori) }}</td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.4rem; align-items: flex-start;">
                                    @if(strtolower($buku->status) === 'ready')
                                        <span class="status-pill status-ready">
                                            <span class="status-dot"></span> READY
                                        </span>
                                    @else
                                        <span class="status-pill status-borrowed">
                                            <span class="status-dot"></span> BORROWED
                                        </span>
                                    @endif

                                    @if(strtolower($buku->status_publish ?? 'publish') === 'draft')
                                        <span class="status-pill status-draft">
                                            <span class="status-dot"></span> DRAFT
                                        </span>
                                    @else
                                        <span class="status-pill status-published">
                                            <span class="status-dot"></span> PUBLISHED
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <a href="{{ url('/admin/buku/edit/' . $buku->id) }}" class="action-icon" title="Edit Buku">
                                        <i class="fas fa-edit" style="color: #4A6B8C;"></i>
                                    </a>
                                    <form action="{{ url('/admin/buku/delete/' . $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" class="action-icon" title="Hapus buku">
                                            <i class="fas fa-trash-alt" style="color: var(--primary-red);"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                                <i class="fas fa-book" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: #C8D4CE;"></i>
                                Belum ada buku yang diunggah. Silakan klik tombol <strong>Upload Buku Baru</strong>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <span class="table-info">SHOWING {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} OF {{ $books->total() }} ENTRIES</span>
                    @if($books->hasPages())
                    <div class="pagination">
                        @if ($books->onFirstPage())
                            <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-left"></i></button>
                        @else
                            <a href="{{ $books->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @php
                            $start = max(1, $books->currentPage() - 2);
                            $end = min($books->lastPage(), $books->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $books->url(1) }}" class="page-btn">1</a>
                            @if($start > 2)
                                <span class="page-btn" style="border: none; cursor: default; background: transparent; display: flex; align-items: center; justify-content: center;">...</span>
                            @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $books->currentPage())
                                <button class="page-btn active">{{ $i }}</button>
                            @else
                                <a href="{{ $books->url($i) }}" class="page-btn">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $books->lastPage())
                            @if($end < $books->lastPage() - 1)
                                <span class="page-btn" style="border: none; cursor: default; background: transparent; display: flex; align-items: center; justify-content: center;">...</span>
                            @endif
                            <a href="{{ $books->url($books->lastPage()) }}" class="page-btn">{{ $books->lastPage() }}</a>
                        @endif

                        @if ($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
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


