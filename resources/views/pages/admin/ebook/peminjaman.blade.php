<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman E-Book - Admin Kanca Tegal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .status-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.35rem 0.9rem; border-radius: 9999px;
            font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;
        }
        .badge-menunggu  { background-color: #FEF3C7; color: #92400E; }
        .badge-dipinjam  { background-color: #D1FAE5; color: #065F46; }
        .badge-ditolak   { background-color: #FEE2E2; color: #991B1B; }
        .badge-selesai   { background-color: #E0E7FF; color: #3730A3; }
        .badge-kadaluarsa{ background-color: #F3F4F6; color: #6B7280; }
        .tab-filter-link {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.8rem;
            font-weight: 700; text-decoration: none; color: var(--text-muted);
            border: 1.5px solid var(--border-color); background: var(--bg-white);
            transition: all 0.2s;
        }
        .tab-filter-link.active, .tab-filter-link:hover {
            border-color: var(--primary-red); color: var(--primary-red);
            background-color: rgba(192,30,46,0.05);
        }
        .action-btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.45rem 0.9rem; border-radius: 6px; border: none;
            font-size: 0.75rem; font-weight: 700; cursor: pointer;
            font-family: inherit; text-transform: uppercase; letter-spacing: 0.5px;
            transition: all 0.2s;
        }
        .btn-approve { background-color: #D1FAE5; color: #065F46; }
        .btn-approve:hover { background-color: #A7F3D0; }
        .btn-reject  { background-color: #FEE2E2; color: #991B1B; }
        .btn-reject:hover  { background-color: #FECACA; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; }
        .modal-overlay.show { display: flex; }
        .modal-box { background: var(--bg-white); border-radius: 12px; padding: 2rem; width: 90%; max-width: 480px; }
    </style>
</head>
<body>
    @include('pages.admin.components.navbar-admin')

    <div class="admin-content">
        <div class="page-header">
            <div class="page-title-group">
                <span class="page-subtitle">E-BOOK MANAGEMENT</span>
                <h1 class="page-title">Peminjaman<br>E-Book</h1>
            </div>
            <div class="page-actions">
                <a href="{{ url('/admin/ebook') }}" class="btn-cancel" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; padding:0.7rem 1.5rem; border-radius:8px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke E-Book
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#E6F4EA;border-left:4px solid #137333;color:#137333;padding:1rem;border-radius:6px;margin-bottom:2rem;font-size:0.9rem;font-weight:600;">
                <i class="fas fa-check-circle" style="margin-right:0.5rem;"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#FEE2E2;border-left:4px solid #991B1B;color:#991B1B;padding:1rem;border-radius:6px;margin-bottom:2rem;font-size:0.9rem;font-weight:600;">
                <i class="fas fa-exclamation-circle" style="margin-right:0.5rem;"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Pending notification --}}
        @if($totalMenunggu > 0)
            <div style="background:#FEF3C7;border-left:4px solid #D97706;color:#92400E;padding:1rem;border-radius:6px;margin-bottom:1.5rem;font-size:0.9rem;font-weight:600;">
                <i class="fas fa-clock" style="margin-right:0.5rem;"></i>
                Ada <strong>{{ $totalMenunggu }}</strong> permintaan peminjaman yang menunggu konfirmasi Anda.
            </div>
        @endif

        {{-- Status tabs --}}
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:2rem;">
            @foreach(['Menunggu','Dipinjam','Ditolak','Selesai','Kadaluarsa','semua'] as $tab)
                <a href="{{ url('/admin/ebook/peminjaman?status=' . $tab) }}"
                   class="tab-filter-link {{ $status === $tab ? 'active' : '' }}">
                    @if($tab === 'semua') <i class="fas fa-list"></i> @endif
                    {{ strtoupper($tab) }}
                </a>
            @endforeach
        </div>

        {{-- Table --}}
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>MEMBER</th>
                        <th>E-BOOK</th>
                        <th>TGL PINJAM</th>
                        <th>JTH TEMPO</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                    <tr>
                        <td>
                            <div style="display:flex;flex-direction:column;">
                                <span style="font-weight:700;color:var(--text-dark);font-size:0.85rem;">{{ $p->user->name ?? '-' }}</span>
                                <small style="color:var(--text-muted);font-size:0.72rem;">{{ $p->user->email ?? '' }}</small>
                                <small style="color:var(--text-muted);font-size:0.72rem;"><i class="fab fa-whatsapp" style="color:#25D366;"></i> {{ $p->user->whatsapp ?? '-' }}</small>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.75rem;">
                                @if($p->ebook && $p->ebook->cover)
                                    <img src="{{ Storage::url($p->ebook->cover) }}" alt="" style="width:40px;height:55px;object-fit:cover;border-radius:4px;">
                                @endif
                                <div>
                                    <span style="font-weight:700;font-size:0.82rem;color:var(--text-dark);">{{ Str::limit($p->ebook->judul ?? '-', 40) }}</span>
                                    <br><small style="color:var(--text-muted);font-size:0.72rem;">{{ $p->ebook->kategori ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:0.82rem;font-weight:600;">{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                        <td style="font-size:0.82rem;font-weight:600;">{{ $p->tanggal_jatuh_tempo ? $p->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                        <td>
                            @php
                                $badges = ['Menunggu'=>'menunggu','Dipinjam'=>'dipinjam','Ditolak'=>'ditolak','Selesai'=>'selesai','Kadaluarsa'=>'kadaluarsa'];
                                $cls = $badges[$p->status] ?? 'menunggu';
                            @endphp
                            <span class="status-badge badge-{{ $cls }}">{{ $p->status }}</span>
                            @if($p->catatan_admin)
                                <br><small style="color:var(--text-muted);font-size:0.7rem;display:block;margin-top:0.25rem;">{{ Str::limit($p->catatan_admin, 40) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($p->status === 'Menunggu')
                                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                                    <button class="action-btn btn-approve" onclick="openModal('approve-{{ $p->id }}')">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                    <button class="action-btn btn-reject" onclick="openModal('reject-{{ $p->id }}')">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>

                                {{-- Approve Modal --}}
                                <div class="modal-overlay" id="approve-{{ $p->id }}">
                                    <div class="modal-box">
                                        <h3 style="font-size:1.1rem;font-weight:800;margin-bottom:0.5rem;color:var(--text-dark);">Setujui Peminjaman</h3>
                                        <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;">
                                            Setujui peminjaman E-Book <strong>{{ $p->ebook->judul ?? '' }}</strong> oleh <strong>{{ $p->user->name ?? '' }}</strong>?
                                            Durasi pinjam akan dihitung mulai hari ini berdasarkan pengaturan admin.
                                        </p>
                                        <form action="{{ route('admin.ebook.setujui', $p->id) }}" method="POST">
                                            @csrf
                                            <label style="font-size:0.8rem;font-weight:700;color:var(--text-muted);display:block;margin-bottom:0.4rem;">CATATAN (OPSIONAL)</label>
                                            <textarea name="catatan_admin" rows="2" placeholder="Pesan untuk member..." style="width:100%;border:1.5px solid var(--border-color);border-radius:8px;padding:0.6rem;font-size:0.85rem;font-family:inherit;resize:vertical;box-sizing:border-box;margin-bottom:1rem;"></textarea>
                                            <div style="display:flex;gap:0.75rem;">
                                                <button type="submit" class="action-btn btn-approve" style="padding:0.6rem 1.5rem;font-size:0.82rem;"><i class="fas fa-check"></i> Konfirmasi Setuju</button>
                                                <button type="button" onclick="closeModal('approve-{{ $p->id }}')" class="action-btn" style="background:var(--bg-theme);color:var(--text-dark);padding:0.6rem 1.2rem;">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- Reject Modal --}}
                                <div class="modal-overlay" id="reject-{{ $p->id }}">
                                    <div class="modal-box">
                                        <h3 style="font-size:1.1rem;font-weight:800;margin-bottom:0.5rem;color:var(--text-dark);">Tolak Peminjaman</h3>
                                        <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;">
                                            Tolak peminjaman E-Book <strong>{{ $p->ebook->judul ?? '' }}</strong> oleh <strong>{{ $p->user->name ?? '' }}</strong>?
                                        </p>
                                        <form action="{{ route('admin.ebook.tolak', $p->id) }}" method="POST">
                                            @csrf
                                            <label style="font-size:0.8rem;font-weight:700;color:var(--text-muted);display:block;margin-bottom:0.4rem;">ALASAN PENOLAKAN</label>
                                            <textarea name="catatan_admin" rows="2" placeholder="Berikan alasan penolakan..." style="width:100%;border:1.5px solid var(--border-color);border-radius:8px;padding:0.6rem;font-size:0.85rem;font-family:inherit;resize:vertical;box-sizing:border-box;margin-bottom:1rem;" required></textarea>
                                            <div style="display:flex;gap:0.75rem;">
                                                <button type="submit" class="action-btn btn-reject" style="padding:0.6rem 1.5rem;font-size:0.82rem;"><i class="fas fa-times"></i> Konfirmasi Tolak</button>
                                                <button type="button" onclick="closeModal('reject-{{ $p->id }}')" class="action-btn" style="background:var(--bg-theme);color:var(--text-dark);padding:0.6rem 1.2rem;">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span style="font-size:0.78rem;color:var(--text-muted);">–</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:var(--text-muted);padding:3rem;">
                            <i class="fas fa-inbox" style="font-size:2rem;margin-bottom:1rem;display:block;color:#C8D4CE;"></i>
                            Tidak ada data peminjaman dengan status <strong>{{ strtoupper($status) }}</strong>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="table-footer">
                <span class="table-info">SHOWING {{ $peminjamans->firstItem() ?? 0 }} - {{ $peminjamans->lastItem() ?? 0 }} OF {{ $peminjamans->total() }} ENTRIES</span>
                @if($peminjamans->hasPages())
                <div class="pagination">
                    @if($peminjamans->onFirstPage())
                        <button class="page-btn" disabled style="opacity:0.5;cursor:not-allowed;"><i class="fas fa-chevron-left"></i></button>
                    @else
                        <a href="{{ $peminjamans->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    @endif
                    @foreach($peminjamans->getUrlRange(1, $peminjamans->lastPage()) as $page => $url)
                        @if($page == $peminjamans->currentPage())
                            <button class="page-btn active">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($peminjamans->hasMorePages())
                        <a href="{{ $peminjamans->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    @else
                        <button class="page-btn" disabled style="opacity:0.5;cursor:not-allowed;"><i class="fas fa-chevron-right"></i></button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function openModal(id)  { document.getElementById(id).classList.add('show'); }
        function closeModal(id) { document.getElementById(id).classList.remove('show'); }
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('show');
            });
        });
    </script>
</body>
</html>
