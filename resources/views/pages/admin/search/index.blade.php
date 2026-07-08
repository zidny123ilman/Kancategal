<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Admin - Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        .search-results-section {
            margin-bottom: 3.5rem;
        }
        .section-header-search {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .section-title-search {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-count-badge {
            background-color: var(--primary-red);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .art-mod-actions form, .art-row-actions form {
            margin: 0;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- Navbar Component -->
    @include('pages.admin.components.navbar-admin')

    <!-- Page Content -->
    <div class="admin-content">
        
        <!-- Page Header -->
        <div class="page-header" style="margin-bottom: 2rem;">
            <div class="page-title-group">
                <span class="page-subtitle">GLOBAL ARCHIVE SEARCH</span>
                <h1 class="page-title">Hasil Pencarian</h1>
                <span class="page-subtitle" style="text-transform: none; font-size: 1.1rem; color: var(--text-dark); letter-spacing: 0; margin-top: 0.5rem; font-weight: 600;">
                    Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong>
                </span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="background-color: #E6F4EA; border: 1px solid #137333; color: #137333; padding: 1rem; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @php
            $totalResults = count($books) + count($peminjamans) + count($members) + count($articles);
        @endphp

        <div style="margin-bottom: 2.5rem; font-size: 1rem; color: var(--text-muted); font-weight: 500;">
            Ditemukan {{ $totalResults }} entri yang cocok di seluruh sistem.
        </div>

        <!-- 1. Books Section -->
        <div class="search-results-section">
            <div class="section-header-search">
                <h2 class="section-title-search">
                    <i class="fas fa-book" style="color: var(--primary-red);"></i> Buku Terkait
                    <span class="section-count-badge">{{ count($books) }}</span>
                </h2>
                @if(count($books) > 0)
                    <a href="{{ url('/admin/buku') }}?q={{ urlencode($search) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary-red); text-decoration: none;">Lihat di Manajemen Buku</a>
                @endif
            </div>

            @if(count($books) > 0)
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
                            @foreach ($books as $buku)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background-color: var(--bg-white); padding: 2rem; text-align: center; border-radius: 8px; border: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.9rem;">
                    Tidak ada buku yang cocok dengan kata kunci.
                </div>
            @endif
        </div>

        <!-- 2. Peminjaman Section -->
        <div class="search-results-section">
            <div class="section-header-search">
                <h2 class="section-title-search">
                    <i class="fas fa-bookmark" style="color: var(--primary-red);"></i> Peminjaman Terkait
                    <span class="section-count-badge">{{ count($peminjamans) }}</span>
                </h2>
                @if(count($peminjamans) > 0)
                    <a href="{{ url('/admin/peminjaman') }}?q={{ urlencode($search) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary-red); text-decoration: none;">Lihat di Sirkulasi Peminjaman</a>
                @endif
            </div>

            @if(count($peminjamans) > 0)
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAMA ANGGOTA</th>
                                <th>JUDUL BUKU</th>
                                <th>TANGGAL PINJAM</th>
                                <th>STATUS</th>
                                <th style="text-align: right;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                            <tr>
                                <td class="td-id">#TX-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <a href="{{ url('/admin/peminjaman/detail/' . $peminjaman->id) }}" class="td-member-info" style="color: inherit; text-decoration: none;">
                                        <div class="td-member-avatar-text">{{ substr($peminjaman->user->name ?? '?', 0, 2) }}</div>
                                        <span class="td-member-name" style="text-decoration: underline;">{{ $peminjaman->user->name ?? 'Member Terhapus' }}</span>
                                    </a>
                                </td>
                                <td class="td-book-title-simple">{{ $peminjaman->buku->judul ?? 'Buku Terhapus' }}</td>
                                <td class="td-date">{{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($peminjaman->status === 'pending_pinjam')
                                        <span class="status-text" style="color: #1A73E8;">
                                            <span class="status-dot" style="background-color: #1A73E8;"></span> Konfirmasi Pinjam
                                        </span>
                                    @elseif($peminjaman->status === 'aktif')
                                        @if($peminjaman->tanggal_kembali < \Carbon\Carbon::today()->toDateString())
                                            <span class="status-text status-text-danger">
                                                <span class="status-dot" style="background-color: var(--primary-red);"></span> Terlambat Kembali
                                            </span>
                                        @else
                                            <span class="status-pill-gray" style="background-color: #E6F4EA; color: #137333;">Aktif</span>
                                        @endif
                                    @elseif($peminjaman->status === 'pending_kembali')
                                        <span class="status-text" style="color: #E27B00;">
                                            <span class="status-dot" style="background-color: #E27B00;"></span> Konfirmasi Kembali
                                        </span>
                                    @elseif($peminjaman->status === 'selesai')
                                        <span class="status-pill-gray">Dikembalikan</span>
                                    @elseif($peminjaman->status === 'ditolak')
                                        <span class="status-text status-text-danger">
                                            <span class="status-dot" style="background-color: var(--primary-red);"></span> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($peminjaman->status === 'pending_pinjam')
                                        <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/tolak-pinjam') }}" method="POST" style="display: inline;" onsubmit="return confirm('Tolak permintaan peminjaman ini?');">
                                            @csrf
                                            <button type="submit" class="btn-action-sm btn-danger" style="background-color: #D32F2F; color: white; margin-right: 4px;">Tolak</button>
                                        </form>
                                        <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/setujui-pinjam') }}" method="POST" style="display: inline;" onsubmit="return confirm('Setujui permintaan peminjaman ini?');">
                                            @csrf
                                            <button type="submit" class="btn-action-sm btn-danger" style="background-color: #1A73E8; color: white;">Setujui</button>
                                        </form>
                                    @elseif($peminjaman->status === 'pending_kembali')
                                        <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/tolak-kembali') }}" method="POST" style="display: inline;" onsubmit="return confirm('Tolak pengembalian buku ini?');">
                                            @csrf
                                            <button type="submit" class="btn-action-sm btn-danger" style="background-color: #D32F2F; color: white; margin-right: 4px;">Tolak</button>
                                        </form>
                                        <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/setujui-kembali') }}" method="POST" style="display: inline;" onsubmit="return confirm('Konfirmasi pengembalian buku ini?');">
                                            @csrf
                                            <button type="submit" class="btn-action-sm btn-secondary" style="background-color: #00796B; color: white;">Selesai</button>
                                        </form>
                                    @else
                                        <a href="{{ url('/admin/peminjaman/detail/' . $peminjaman->id) }}" class="btn-action-sm btn-secondary" style="background-color: var(--text-muted); color: white; text-decoration: none; padding: 0.35rem 0.75rem;">Detail</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background-color: var(--bg-white); padding: 2rem; text-align: center; border-radius: 8px; border: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.9rem;">
                    Tidak ada transaksi peminjaman yang cocok dengan kata kunci.
                </div>
            @endif
        </div>

        <!-- 3. Members Section -->
        <div class="search-results-section">
            <div class="section-header-search">
                <h2 class="section-title-search">
                    <i class="fas fa-user-friends" style="color: var(--primary-red);"></i> Member Terkait
                    <span class="section-count-badge">{{ count($members) }}</span>
                </h2>
                @if(count($members) > 0)
                    <a href="{{ url('/admin/member') }}?q={{ urlencode($search) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary-red); text-decoration: none;">Lihat di Manajemen Member</a>
                @endif
            </div>

            @if(count($members) > 0)
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>MEMBER INFORMATION</th>
                                <th>JOIN DATE</th>
                                <th>BORROW ACCESS</th>
                                <th>ARTICLE UPLOAD</th>
                                <th>STATUS AKSES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>
                                    <div class="td-member-info">
                                        <div class="td-member-avatar" style="background-color: var(--accent-blue-grey); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 50%; width: 40px; height: 40px; font-size: 0.9rem;">
                                            {{ substr($member->name, 0, 2) }}
                                        </div>
                                        <div class="td-book-details">
                                            <span class="td-member-name">
                                                <a href="{{ url('/admin/member/detail/' . $member->id) }}" style="color: var(--text-dark); font-weight: 700; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                    {{ $member->name }}
                                                </a>
                                            </span>
                                            <span class="td-id">{{ $member->whatsapp }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-date">{{ $member->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span style="font-size: 0.85rem; font-weight: 700; color: {{ $member->can_borrow ? '#137333' : 'var(--primary-red)' }}">
                                        {{ $member->can_borrow ? 'GRANTED' : 'REVOKED' }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; font-weight: 700; color: {{ $member->can_upload_artikel ? '#137333' : 'var(--primary-red)' }}">
                                        {{ $member->can_upload_artikel ? 'GRANTED' : 'REVOKED' }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->status === 'active')
                                        <span class="status-pill status-ready"><span class="status-dot"></span> ACTIVE</span>
                                    @else
                                        <span class="status-pill status-borrowed"><span class="status-dot"></span> {{ strtoupper($member->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background-color: var(--bg-white); padding: 2rem; text-align: center; border-radius: 8px; border: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.9rem;">
                    Tidak ada member yang cocok dengan kata kunci.
                </div>
            @endif
        </div>

        <!-- 4. Articles Section -->
        <div class="search-results-section">
            <div class="section-header-search">
                <h2 class="section-title-search">
                    <i class="fas fa-file-alt" style="color: var(--primary-red);"></i> Artikel Terkait
                    <span class="section-count-badge">{{ count($articles) }}</span>
                </h2>
                @if(count($articles) > 0)
                    <a href="{{ url('/admin/artikel') }}?q={{ urlencode($search) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--primary-red); text-decoration: none;">Lihat di Manajemen Artikel</a>
                @endif
            </div>

            @if(count($articles) > 0)
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>TITLE &amp; CONTRIBUTOR</th>
                                <th>CATEGORY</th>
                                <th>UPLOAD DATE</th>
                                <th>STATUS</th>
                                <th style="text-align: right;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $art)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <a href="{{ url('/admin/artikel/detail/' . $art->id) }}">
                                            <img src="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}" alt="{{ $art->judul }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        </a>
                                        <div>
                                            <div style="font-weight: 600; color: var(--text-dark);">
                                                <a href="{{ url('/admin/artikel/detail/' . $art->id) }}" style="text-decoration: none; color: inherit;">
                                                    {{ $art->judul }}
                                                </a>
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">by {{ $art->nama_uploader }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size: 0.75rem; font-weight: 800; color: #1A56DB; text-transform: uppercase;">{{ $art->kategori }}</span>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    @if(strtolower($art->status) === 'approved')
                                        <span class="status-pill status-ready">PUBLISHED</span>
                                    @elseif(strtolower($art->status) === 'pending')
                                        <span class="status-pill status-borrowed">PENDING</span>
                                    @else
                                        <span class="status-pill status-draft" style="background-color: rgba(192, 30, 46, 0.1); color: var(--primary-red);">REJECTED</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                                        @if(strtolower($art->status) === 'pending')
                                            <form action="{{ url('/admin/artikel/' . $art->id . '/approve') }}" method="POST">
                                                @csrf
                                                <button type="submit" style="color: #137333; background: none; border: none; cursor: pointer;" title="Approve"><i class="fas fa-check"></i></button>
                                            </form>
                                        @endif
                                        <form action="{{ url('/admin/artikel/' . $art->id . '/delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            <button type="submit" style="color: var(--primary-red); background: none; border: none; cursor: pointer;" title="Delete"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background-color: var(--bg-white); padding: 2rem; text-align: center; border-radius: 8px; border: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.9rem;">
                    Tidak ada artikel yang cocok dengan kata kunci.
                </div>
            @endif
        </div>

    </div>
</body>
</html>
