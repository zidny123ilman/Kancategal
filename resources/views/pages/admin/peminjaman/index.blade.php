<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Peminjaman - Admin Kanca Tegal</title>
    
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
            
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card-light">
                    <span class="stat-title">TOTAL PINJAMAN AKTIF</span>
                    <span class="stat-value">{{ number_format($totalPeminjamanAktif) }}</span>
                    <i class="fas fa-bookmark stat-icon"></i>
                </div>
                <div class="stat-card-light">
                    <span class="stat-title">MENUNGGU KONFIRMASI</span>
                    <span class="stat-value" style="color: #1A56DB;">{{ number_format($menungguKonfirmasi) }}</span>
                    <i class="fas fa-clipboard-list stat-icon"></i>
                </div>
                <div class="stat-card-danger" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <span class="stat-title">TERLAMBAT KEMBALI</span>
                        <span class="stat-value">{{ number_format($terlambatKembali) }}</span>
                    </div>
                    <div style="margin-top: 1rem; border-top: 1px solid rgba(192, 30, 46, 0.2); padding-top: 0.5rem; font-size: 0.8rem; display: flex; flex-direction: column; gap: 4px; color: #c01e2e; text-align: left;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Denda Terbayar:</span>
                            <strong>Rp {{ number_format($totalDendaTerbayar, 0, ',', '.') }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed rgba(192, 30, 46, 0.1); padding-top: 4px;">
                            <span>Belum Terbayar:</span>
                            <strong>Rp {{ number_format($totalDendaBelumTerbayar, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <i class="fas fa-exclamation-triangle stat-icon"></i>
                </div>
            </div>

            <!-- Page Header -->
            <div class="page-header" style="margin-bottom: 1.5rem;">
                <div class="page-title-group">
                    <h1 class="page-title" style="font-size: 2rem;">Manajemen Peminjaman</h1>
                    <span class="page-subtitle" style="text-transform: none; font-size: 0.95rem; color: var(--text-dark); letter-spacing: 0; margin-top: 0.5rem; font-weight: 500;">Daftar sirkulasi buku terbaru dalam ekosistem Kanca Tegal.</span>
                </div>
                <div class="page-actions">
                    <a href="{{ url('/admin/peminjaman/export-excel') }}?{{ http_build_query(request()->query()) }}" class="btn-admin-secondary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-download"></i> Ekspor Data
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ url('/admin/peminjaman') }}" style="margin-bottom: 2rem; padding: 1.5rem; background: #E8EFEA; border-radius: 8px; display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: flex-end;">
                <div style="flex: 1; min-width: 150px; display: flex; flex-direction: column; gap: 0.5rem;">
                    <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Tipe Sirkulasi</span>
                    <select name="type" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.85rem; color: var(--text-dark); outline: none; background: white; font-family: var(--font-main); font-weight: 600;">
                        <option value="">Semua Tipe</option>
                        <option value="peminjaman" {{ request('type') === 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                        <option value="pengembalian" {{ request('type') === 'pengembalian' ? 'selected' : '' }}>Pengembalian</option>
                    </select>
                </div>
                
                <div style="flex: 1; min-width: 150px; display: flex; flex-direction: column; gap: 0.5rem;">
                    <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Status</span>
                    <select name="status" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.85rem; color: var(--text-dark); outline: none; background: white; font-family: var(--font-main); font-weight: 600;">
                        <option value="">Semua Status</option>
                        <option value="pending_pinjam" {{ request('status') === 'pending_pinjam' ? 'selected' : '' }}>Menunggu Konfirmasi Pinjam</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat Kembali</option>
                        <option value="pending_kembali" {{ request('status') === 'pending_kembali' ? 'selected' : '' }}>Menunggu Konfirmasi Kembali</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai / Dikembalikan</option>
                    </select>
                </div>
                
                <div style="flex: 1; min-width: 150px; display: flex; flex-direction: column; gap: 0.5rem;">
                    <span style="font-size: 0.7rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Tanggal Pinjam</span>
                    <input type="date" name="date" value="{{ request('date') }}" style="width: 100%; padding: 0.55rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.85rem; color: var(--text-dark); outline: none; background: white; font-family: var(--font-main); font-weight: 600;">
                </div>
                
                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn-admin-primary" style="padding: 0.65rem 1.25rem; border-radius: 6px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; border: none;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ url('/admin/peminjaman') }}" class="btn-admin-secondary" style="padding: 0.65rem 1.25rem; border-radius: 6px; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #E6F4EA; border: 1px solid #137333; color: #137333; padding: 1rem; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Data Table -->
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAMA ANGGOTA</th>
                            <th>JUDUL BUKU</th>
                            <th>TIPE</th>
                            <th>TANGGAL PINJAM</th>
                            <th>STATUS</th>
                            <th style="text-align: right;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $peminjaman)
                            <tr>
                                <td class="td-id">#TX-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <a href="{{ url('/admin/peminjaman/detail/' . $peminjaman->id) }}" class="td-member-info" style="color: inherit; text-decoration: none;">
                                        <div class="td-member-avatar-text">{{ substr($peminjaman->user->name ?? '?', 0, 2) }}</div>
                                        <span class="td-member-name" style="text-decoration: underline;">{{ $peminjaman->user->name ?? 'Member Terhapus' }}</span>
                                    </a>
                                </td>
                                <td class="td-book-title-simple">{{ $peminjaman->buku->judul ?? 'Buku Terhapus' }}</td>
                                <td>
                                    @if(in_array($peminjaman->status, ['pending_pinjam', 'aktif']))
                                        <span class="type-pill type-peminjaman">PEMINJAMAN</span>
                                    @else
                                        <span class="type-pill type-pengembalian">PENGEMBALIAN</span>
                                    @endif
                                </td>
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
                                            @if($peminjaman->denda > 0)
                                                <div style="font-size: 0.75rem; color: var(--primary-red); font-weight: bold; margin-top: 2px;">
                                                    Denda: Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="status-pill-gray" style="background-color: #E6F4EA; color: #137333;">Aktif</span>
                                        @endif
                                    @elseif($peminjaman->status === 'pending_kembali')
                                        <span class="status-text" style="color: #E27B00;">
                                            <span class="status-dot" style="background-color: #E27B00;"></span> Konfirmasi Kembali (Cek Buku)
                                        </span>
                                        @if($peminjaman->tanggal_kembali < \Carbon\Carbon::today()->toDateString() && $peminjaman->denda > 0)
                                            <div style="font-size: 0.75rem; color: #E27B00; font-weight: bold; margin-top: 2px;">
                                                Terlambat (Denda: Rp {{ number_format($peminjaman->denda, 0, ',', '.') }})
                                            </div>
                                        @endif
                                    @elseif($peminjaman->status === 'selesai')
                                        <span class="status-pill-gray">Dikembalikan</span>
                                        @if($peminjaman->denda > 0)
                                            <div style="font-size: 0.75rem; color: #555; font-weight: bold; margin-top: 2px;">
                                                Denda Terbayar: Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                                            </div>
                                        @endif
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
                                    @elseif($peminjaman->status === 'aktif')
                                        <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/kirim-peringatan') }}" method="POST" style="display: inline;" onsubmit="return confirm('Kirim WhatsApp peringatan keterlambatan ke anggota ini?');">
                                            @csrf
                                            <button type="submit" class="btn-action-sm" style="background-color: #25D366; color: white; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem;">
                                                <i class="fab fa-whatsapp"></i> Remind WA
                                            </button>
                                        </form>
                                    @elseif($peminjaman->status === 'selesai')
                                        <i class="fas fa-check-circle action-icon" style="color: #137333;" title="Selesai"></i>
                                    @elseif($peminjaman->status === 'ditolak')
                                        <i class="fas fa-times-circle action-icon" style="color: var(--primary-red);" title="Ditolak"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                    Tidak ada data sirkulasi yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <span class="table-info" style="text-transform: none; letter-spacing: 0;">
                        Menampilkan {{ $peminjamans->firstItem() ?? 0 }}-{{ $peminjamans->lastItem() ?? 0 }} dari {{ $peminjamans->total() }} transaksi
                    </span>
                    <div class="pagination">
                        @if ($peminjamans->onFirstPage())
                            <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-left"></i></button>
                        @else
                            <a href="{{ $peminjamans->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @php
                            $start = max(1, $peminjamans->currentPage() - 2);
                            $end = min($peminjamans->lastPage(), $peminjamans->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $peminjamans->url(1) }}" class="page-btn">1</a>
                            @if($start > 2)
                                <span class="page-btn" style="border: none; cursor: default; background: transparent; display: flex; align-items: center; justify-content: center;">...</span>
                            @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $peminjamans->currentPage())
                                <button class="page-btn active">{{ $i }}</button>
                            @else
                                <a href="{{ $peminjamans->url($i) }}" class="page-btn">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $peminjamans->lastPage())
                            @if($end < $peminjamans->lastPage() - 1)
                                <span class="page-btn" style="border: none; cursor: default; background: transparent; display: flex; align-items: center; justify-content: center;">...</span>
                            @endif
                            <a href="{{ $peminjamans->url($peminjamans->lastPage()) }}" class="page-btn">{{ $peminjamans->lastPage() }}</a>
                        @endif

                        @if ($peminjamans->hasMorePages())
                            <a href="{{ $peminjamans->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-right"></i></button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>


