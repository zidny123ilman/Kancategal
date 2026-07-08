<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman #TX-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }} - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        .detail-layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        @media (max-width: 992px) {
            .detail-layout {
                grid-template-columns: 1fr;
            }
        }
        .card-premium {
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            padding: 2rem;
            border-top: 4px solid var(--primary-red);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .card-header-premium {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title-premium {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar-container {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        .avatar-large {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: var(--primary-red);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(192, 30, 46, 0.15);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem 1rem;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            word-break: break-word;
        }
        .permission-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
        }
        .pill-active {
            background-color: rgba(19, 115, 51, 0.1);
            color: #137333;
        }
        .pill-inactive {
            background-color: rgba(107, 122, 113, 0.1);
            color: var(--text-muted);
        }
        .book-detail-wrapper {
            display: flex;
            gap: 1.25rem;
        }
        .book-detail-cover {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: var(--shadow-md);
        }
        .book-detail-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.5rem;
        }
        .denda-box {
            background-color: #F8E8E9;
            border-left: 4px solid var(--primary-red);
            padding: 1rem;
            border-radius: 4px;
            margin-top: 0.5rem;
        }
        .denda-title {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary-red);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        .denda-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary-red);
        }
        .history-card {
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            padding: 2rem;
            border-top: 4px solid #4B6B5B;
        }
    </style>
</head>
<body>

    @include('pages.admin.components.navbar-admin')

    <div class="admin-content" style="padding: 2.5rem 1.5rem;">
        
        <div style="margin-bottom: 2rem;">
            <a href="{{ url('/admin/peminjaman') }}" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Peminjaman
            </a>
        </div>

        <!-- Success/Error Alerts -->
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

        <div class="detail-layout">
            
            <!-- LEFT COLUMN: MEMBER PROFILE -->
            <div class="card-premium">
                <div class="card-header-premium">
                    <div class="card-title-premium">
                        <i class="fas fa-user-circle" style="color: var(--primary-red);"></i> Profil Anggota
                    </div>
                    <span class="status-pill-gray" style="text-transform: uppercase; font-size: 0.7rem; font-weight: 700; background: #E8F0FE; color: #1A56DB;">
                        #MBR-{{ str_pad($peminjaman->user->id ?? 0, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                @if($peminjaman->user)
                    <div class="avatar-container">
                        <div class="avatar-large">
                            {{ substr($peminjaman->user->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--text-dark);">{{ $peminjaman->user->name }}</h3>
                            <span class="status-text" style="margin-top: 0.25rem;">
                                @if($peminjaman->user->status === 'active')
                                    <span class="status-pill status-ready" style="font-size: 0.65rem;"><span class="status-dot"></span> AKTIF</span>
                                @else
                                    <span class="status-pill status-borrowed" style="background-color: #F8E8E9; color: var(--primary-red); font-size: 0.65rem;"><span class="status-dot" style="background-color: var(--primary-red);"></span> SUSPENDED</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item" style="grid-column: span 2;">
                            <span class="info-label">Nomor WhatsApp</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $peminjaman->user->whatsapp) }}" target="_blank" class="info-value" style="color: #137333; display: flex; align-items: center; gap: 5px;">
                                <i class="fab fa-whatsapp"></i> {{ $peminjaman->user->whatsapp }}
                            </a>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <span class="info-label">Alamat Email</span>
                            <span class="info-value">{{ $peminjaman->user->email ?? '-' }}</span>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <span class="info-label">Alamat Lengkap</span>
                            <span class="info-value" style="font-weight: 500; line-height: 1.5;">{{ $peminjaman->user->alamat ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Hak Pinjam</span>
                            <div>
                                @if($peminjaman->user->can_borrow)
                                    <span class="permission-pill pill-active"><i class="fas fa-check"></i> Ya</span>
                                @else
                                    <span class="permission-pill pill-inactive"><i class="fas fa-times"></i> Tidak</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Hak Upload Artikel</span>
                            <div>
                                @if($peminjaman->user->can_upload_artikel)
                                    <span class="permission-pill pill-active"><i class="fas fa-check"></i> Ya</span>
                                @else
                                    <span class="permission-pill pill-inactive"><i class="fas fa-times"></i> Tidak</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; color: var(--text-muted); padding: 2rem 0;">
                        <i class="fas fa-user-slash" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        <p>Data anggota tidak ditemukan (Terhapus)</p>
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: TRANSACTION DETAIL -->
            <div class="card-premium">
                <div class="card-header-premium">
                    <div class="card-title-premium">
                        <i class="fas fa-bookmark" style="color: var(--primary-red);"></i> Detail Sirkulasi
                    </div>
                    <span class="status-pill-gray" style="text-transform: uppercase; font-size: 0.7rem; font-weight: 700; background: #E8EFEA; color: #1E2E25;">
                        #TX-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                @if($peminjaman->buku)
                    <div class="book-detail-wrapper">
                        @if(str_starts_with($peminjaman->buku->foto, 'http'))
                            <img src="{{ $peminjaman->buku->foto }}" alt="Cover" class="book-detail-cover">
                        @else
                            <img src="{{ asset($peminjaman->buku->foto) }}" alt="Cover" class="book-detail-cover">
                        @endif
                        <div class="book-detail-info">
                            <span class="td-genre" style="margin-bottom: 0.25rem;">{{ $peminjaman->buku->kategori }}</span>
                            <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.25rem;">{{ $peminjaman->buku->judul }}</h3>
                            <span class="td-book-sku">ISBN: {{ $peminjaman->buku->isbn }}</span>
                            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-top: 0.25rem;">Karya: {{ $peminjaman->buku->penulis }}</span>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; color: var(--text-muted); padding: 2rem 0;">
                        <i class="fas fa-book-dead" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        <p>Data buku tidak ditemukan (Terhapus)</p>
                    </div>
                @endif

                <div class="info-grid" style="border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                    <div class="info-item">
                        <span class="info-label">Tanggal Pengajuan</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d F Y (H:i)') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Sirkulasi</span>
                        <div>
                            @if($peminjaman->status === 'pending_pinjam')
                                <span class="status-text" style="color: #1A73E8; font-weight: 700;">
                                    <span class="status-dot" style="background-color: #1A73E8;"></span> Menunggu Persetujuan Pinjam
                                </span>
                            @elseif($peminjaman->status === 'aktif')
                                @if($peminjaman->tanggal_kembali < \Carbon\Carbon::today()->toDateString())
                                    <span class="status-text status-text-danger" style="font-weight: 700;">
                                        <span class="status-dot" style="background-color: var(--primary-red);"></span> Terlambat Kembali
                                    </span>
                                @else
                                    <span class="permission-pill pill-active" style="background-color: #E6F4EA; color: #137333; font-weight: 700;">Aktif</span>
                                @endif
                            @elseif($peminjaman->status === 'pending_kembali')
                                <span class="status-text" style="color: #E27B00; font-weight: 700;">
                                    <span class="status-dot" style="background-color: #E27B00;"></span> Menunggu Persetujuan Kembali
                                </span>
                            @elseif($peminjaman->status === 'selesai')
                                <span class="status-pill-gray" style="font-weight: 700;">Selesai / Dikembalikan</span>
                            @elseif($peminjaman->status === 'ditolak')
                                <span class="status-text status-text-danger" style="font-weight: 700;">
                                    <span class="status-dot" style="background-color: var(--primary-red);"></span> Permintaan Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Mulai Pinjam</span>
                        <span class="info-value">{{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') : '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Batas Pengembalian</span>
                        <span class="info-value" style="{{ ($peminjaman->status === 'aktif' || $peminjaman->status === 'pending_kembali') && $peminjaman->tanggal_kembali < \Carbon\Carbon::today()->toDateString() ? 'color: var(--primary-red); font-weight: 700;' : '' }}">
                            {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="info-item" style="grid-column: span 2;">
                        <span class="info-label">Tanggal Dikembalikan Nyata</span>
                        <span class="info-value">{{ $peminjaman->tanggal_dikembalikan ? \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d F Y') : '-' }}</span>
                    </div>

                    <!-- Overdue Fine Section -->
                    @if($peminjaman->denda > 0)
                        <div class="info-item" style="grid-column: span 2;">
                            <div class="denda-box">
                                <div class="denda-title">
                                    {{ $peminjaman->status === 'selesai' ? 'Denda Terlambat (Telah Dibayar)' : 'Kalkulasi Denda Terlambat Saat Ini' }}
                                </div>
                                <div class="denda-value">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- CONTEXTUAL ADMIN ACTIONS -->
                @if(in_array($peminjaman->status, ['pending_pinjam', 'pending_kembali', 'aktif']))
                    <div style="margin-top: 1rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; display: flex; gap: 0.75rem; justify-content: flex-end;">
                        @if($peminjaman->status === 'aktif')
                            <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/kirim-peringatan') }}" method="POST" onsubmit="return confirm('Kirim WhatsApp peringatan keterlambatan/pengembalian ke anggota ini?');">
                                @csrf
                                <button type="submit" class="btn-admin-primary" style="background-color: #25D366; padding: 0.7rem 1.25rem; font-size: 0.8rem; box-shadow: none; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fab fa-whatsapp"></i> Kirim Peringatan WA
                                </button>
                            </form>
                        @elseif($peminjaman->status === 'pending_pinjam')
                            <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/tolak-pinjam') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak permintaan peminjaman ini?');">
                                @csrf
                                <button type="submit" class="btn-admin-secondary" style="background-color: #F8E8E9; color: var(--primary-red); padding: 0.7rem 1.25rem; font-size: 0.8rem; border: none; cursor: pointer;">
                                    <i class="fas fa-times-circle"></i> Tolak Pinjaman
                                </button>
                            </form>
                            <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/setujui-pinjam') }}" method="POST" onsubmit="return confirm('Setujui permintaan peminjaman buku ini?');">
                                @csrf
                                <button type="submit" class="btn-admin-primary" style="padding: 0.7rem 1.25rem; font-size: 0.8rem; box-shadow: none; border: none; cursor: pointer;">
                                    <i class="fas fa-check-circle"></i> Setujui Pinjaman
                                </button>
                            </form>
                        @elseif($peminjaman->status === 'pending_kembali')
                            <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/tolak-kembali') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengembalian buku ini?');">
                                @csrf
                                <button type="submit" class="btn-admin-secondary" style="background-color: #F8E8E9; color: var(--primary-red); padding: 0.7rem 1.25rem; font-size: 0.8rem; border: none; cursor: pointer;">
                                    <i class="fas fa-times-circle"></i> Tolak Pengembalian
                                </button>
                            </form>
                            <form action="{{ url('/admin/peminjaman/' . $peminjaman->id . '/setujui-kembali') }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku selesai?');">
                                @csrf
                                <button type="submit" class="btn-admin-primary" style="background-color: #00796B; padding: 0.7rem 1.25rem; font-size: 0.8rem; box-shadow: none; border: none; cursor: pointer;">
                                    <i class="fas fa-check-circle"></i> Selesaikan Pengembalian
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- LOWER SECTION: USER BORROWING HISTORY -->
        <div class="history-card">
            <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-dark); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-history" style="color: #4B6B5B;"></i> Riwayat Sirkulasi Anggota Lainnya
            </h3>
            
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID TRANSAKSI</th>
                            <th>JUDUL BUKU</th>
                            <th>TANGGAL PINJAM</th>
                            <th>BATAS KEMBALI</th>
                            <th>STATUS</th>
                            <th>DENDA</th>
                            <th style="text-align: right;">DETAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($userLoans as $loan)
                            <tr>
                                <td class="td-id">#TX-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="td-book-title-simple" style="font-weight: bold;">{{ $loan->buku->judul ?? 'Buku Terhapus' }}</td>
                                <td class="td-date">{{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') : '-' }}</td>
                                <td class="td-date">{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($loan->status === 'pending_pinjam')
                                        <span class="status-text" style="color: #1A73E8;"><span class="status-dot" style="background-color: #1A73E8;"></span> Pending Pinjam</span>
                                    @elseif($loan->status === 'aktif')
                                        @if($loan->tanggal_kembali < \Carbon\Carbon::today()->toDateString())
                                            <span class="status-text status-text-danger"><span class="status-dot" style="background-color: var(--primary-red);"></span> Terlambat</span>
                                        @else
                                            <span class="status-pill-gray" style="background-color: #E6F4EA; color: #137333;">Aktif</span>
                                        @endif
                                    @elseif($loan->status === 'pending_kembali')
                                        <span class="status-text" style="color: #E27B00;"><span class="status-dot" style="background-color: #E27B00;"></span> Pending Kembali</span>
                                    @elseif($loan->status === 'selesai')
                                        <span class="status-pill-gray">Selesai</span>
                                    @elseif($loan->status === 'ditolak')
                                        <span class="status-text status-text-danger"><span class="status-dot" style="background-color: var(--primary-red);"></span> Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->denda > 0)
                                        <span style="color: var(--primary-red); font-weight: bold;">Rp {{ number_format($loan->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span style="color: var(--text-muted);">-</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ url('/admin/peminjaman/detail/' . $loan->id) }}" class="action-icon" title="Lihat detail transaksi ini">
                                        <i class="fas fa-eye" style="color: #4A6B8C;"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                    Tidak ada transaksi sirkulasi lainnya untuk anggota ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
