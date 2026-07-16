<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Management - Admin Kanca Tegal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .art-mod-actions form {
            margin: 0;
            display: inline-block;
        }
        .art-row-actions form {
            margin: 0;
            display: inline-block;
        }
        .alert-success {
            background-color: #E6F4EA;
            border: 1px solid #137333;
            color: #137333;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        .status-badge {
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            display: inline-block;
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

    @include('pages.admin.components.navbar-admin')

        <!-- Page Content -->
        <div class="admin-content">

            @if (session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Page Header -->
            <div class="art-page-header">
                <div class="art-page-header-left">
                    <span class="art-curation-label">CURATION HUB</span>
                    <h1 class="art-page-title">Article Management</h1>
                </div>
            </div>

            <!-- Tab Filters -->
            <div class="art-tabs">
                <button class="art-tab {{ $status === 'all' ? 'art-tab--active-red' : '' }}" onclick="window.location.href='{{ request()->fullUrlWithQuery(['status' => 'all']) }}'">
                    ALL ARCHIVES ({{ $countAll }})
                </button>
                <button class="art-tab {{ $status === 'pending' ? 'art-tab--active-blue' : '' }}" onclick="window.location.href='{{ request()->fullUrlWithQuery(['status' => 'pending']) }}'">
                    <span class="art-tab-dot"></span> PENDING QUEUE ({{ $countPending }})
                </button>
                <button class="art-tab {{ $status === 'publish' ? 'art-tab--active-red' : '' }}" onclick="window.location.href='{{ request()->fullUrlWithQuery(['status' => 'publish']) }}'">
                    PUBLISHED ({{ $countApproved }})
                </button>
                <button class="art-tab {{ $status === 'rejected' ? 'art-tab--active-red' : '' }}" onclick="window.location.href='{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}'">
                    REJECTED ({{ $countRejected }})
                </button>
            </div>

            @if($status === 'pending')
                <!-- Moderation Queue Cards Grid -->
                <div class="art-section-header">
                    <h2 class="art-section-title">Moderation Queue</h2>
                    <span class="art-badge-action">{{ sprintf('%02d', $countPending) }} ACTION REQUIRED</span>
                </div>

                <div class="art-mod-grid">
                    @forelse($articles as $art)
                        <!-- Card -->
                        <div class="art-mod-card">
                            <a href="{{ url('/admin/artikel/detail/' . $art->id) }}" style="text-decoration: none; color: inherit; display: block; width: 100%;">
                                <img
                                    src="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                                    alt="{{ $art->judul }}"
                                    class="art-mod-card-img"
                                    style="height: 200px; object-fit: cover; width: 100%; border-top-left-radius: 12px; border-top-right-radius: 12px;"
                                >
                            </a>
                            <div class="art-mod-card-body">
                                <div class="art-mod-card-meta">
                                    <span class="art-mod-category">{{ strtoupper($art->kategori) }}</span>
                                    <span class="art-mod-time">{{ \Carbon\Carbon::parse($art->tanggal_upload)->diffForHumans() }}</span>
                                </div>
                                <h3 class="art-mod-card-title">
                                    <a href="{{ url('/admin/artikel/detail/' . $art->id) }}" style="text-decoration: none; color: inherit;">
                                        {{ $art->judul }}
                                    </a>
                                </h3>
                                <p class="art-mod-card-desc">{{ Str::limit(strip_tags($art->isi), 100) }}</p>
                                <div class="art-mod-card-footer">
                                    <div class="art-mod-author">
                                        <div class="art-mod-avatar" style="background-color: var(--accent-blue); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 50%; width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ substr($art->nama_uploader, 0, 2) }}
                                        </div>
                                        <span class="art-mod-author-name">{{ $art->nama_uploader }}</span>
                                    </div>
                                     <div class="art-mod-actions" style="display: flex; gap: 8px; align-items: center;">
                                        <button type="button" class="art-btn-reject" title="Reject" onclick="openRejectModal({{ $art->id }}, '{{ addslashes($art->judul) }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <form action="{{ url('/admin/artikel/' . $art->id . '/approve') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="art-btn-approve">APPROVE</button>
                                        </form>
                                     </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: span 2; background-color: var(--bg-white); padding: 3rem; text-align: center; border-radius: 12px; border: 1px solid var(--border-color); color: var(--text-muted); width: 100%;">
                            <i class="far fa-check-circle" style="font-size: 3rem; color: #137333; margin-bottom: 1rem; display: block;"></i>
                            Semua artikel telah dimoderasi. Antrean kosong!
                        </div>
                    @endforelse
                </div>
            @else
                <!-- Table for All / Published / Rejected Archives -->
                <div class="art-archive-header" style="margin-top: 2rem;">
                    <h2 class="art-section-title">
                        @if($status === 'publish')
                            Published Archive
                        @elseif($status === 'rejected')
                            Rejected Archive
                        @else
                            All Archives
                        @endif
                    </h2>
                    <div class="art-sort-tabs">
                        <button class="art-sort-tab art-sort-tab--active">LATEST</button>
                    </div>
                </div>

                <!-- Table -->
                <div class="art-table-wrap">
                    <table class="art-table">
                        <thead>
                            <tr>
                                <th class="art-th">TITLE &amp; CONTRIBUTOR</th>
                                <th class="art-th">CATEGORY</th>
                                <th class="art-th">UPLOAD DATE</th>
                                <th class="art-th">STATUS</th>
                                <th class="art-th art-th--right">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $art)
                                <!-- Row -->
                                <tr class="art-tr">
                                    <td class="art-td">
                                        <div class="art-title-col">
                                            <a href="{{ url('/admin/artikel/detail/' . $art->id) }}">
                                                <img
                                                    src="{{ filter_var($art->foto_utama, FILTER_VALIDATE_URL) ? $art->foto_utama : asset($art->foto_utama) }}"
                                                    alt="{{ $art->judul }}"
                                                    class="art-thumb"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;"
                                                >
                                            </a>
                                            <div>
                                                <div class="art-title-text" style="font-weight: 600; color: var(--text-dark);">
                                                    <a href="{{ url('/admin/artikel/detail/' . $art->id) }}" style="text-decoration: none; color: inherit;">
                                                        {{ $art->judul }}
                                                    </a>
                                                </div>
                                                <div class="art-meta-text">by <span class="art-meta-link">{{ $art->nama_uploader }}</span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="art-td">
                                        <span class="art-cat-pill art-cat-pill--blue">{{ strtoupper($art->kategori) }}</span>
                                    </td>
                                    <td class="art-td">
                                        <span style="font-size: 0.85rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($art->tanggal_upload)->format('d M Y') }}</span>
                                    </td>
                                    <td class="art-td">
                                        @if(strtolower($art->status) === 'approved')
                                            <span class="status-badge status-approved">PUBLISHED</span>
                                        @elseif(strtolower($art->status) === 'pending')
                                            <span class="status-badge status-pending">PENDING ACC</span>
                                        @else
                                            <span class="status-badge status-rejected">REJECTED</span>
                                        @endif
                                    </td>
                                    <td class="art-td art-td--right">
                                        <div class="art-row-actions" style="display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                                            @if(strtolower($art->status) === 'pending')
                                                <button type="button" class="art-icon-btn" style="color: var(--primary-red); background: none; border: none; cursor: pointer;" title="Reject" onclick="openRejectModal({{ $art->id }}, '{{ addslashes($art->judul) }}')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <form action="{{ url('/admin/artikel/' . $art->id . '/approve') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="art-icon-btn" style="color: #137333; background: none; border: none; cursor: pointer;" title="Approve"><i class="fas fa-check"></i></button>
                                                </form>
                                            @endif
                                            <form action="{{ url('/admin/artikel/' . $art->id . '/delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini dari arsip?')">
                                                @csrf
                                                <button type="submit" class="art-icon-btn" style="color: var(--primary-red); background: none; border: none; cursor: pointer;" title="Delete"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                        Belum ada artikel untuk kategori status ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Table Footer -->
                    <div class="art-table-footer">
                        <span class="art-table-info">Showing {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} of {{ $articles->total() }} Articles</span>
                    </div>
                </div>
            @endif

            @if($articles->hasPages())
                <div class="art-table-footer" style="margin-top: 1.5rem; justify-content: center; background: transparent; border-top: none;">
                    <div class="art-pagination">
                        @if ($articles->onFirstPage())
                            <button class="art-page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-left"></i></button>
                        @else
                            <a href="{{ $articles->previousPageUrl() }}" class="art-page-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @php
                            $start = max(1, $articles->currentPage() - 2);
                            $end = min($articles->lastPage(), $articles->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $articles->url(1) }}" class="art-page-btn">1</a>
                            @if($start > 2)
                                <span class="art-page-dots">...</span>
                            @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $articles->currentPage())
                                <button class="art-page-btn art-page-btn--active">{{ $i }}</button>
                            @else
                                <a href="{{ $articles->url($i) }}" class="art-page-btn">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $articles->lastPage())
                            @if($end < $articles->lastPage() - 1)
                                <span class="art-page-dots">...</span>
                            @endif
                            <a href="{{ $articles->url($articles->lastPage()) }}" class="art-page-btn">{{ $articles->lastPage() }}</a>
                        @endif

                        @if ($articles->hasMorePages())
                            <a href="{{ $articles->nextPageUrl() }}" class="art-page-btn"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <button class="art-page-btn" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-chevron-right"></i></button>
                        @endif
                    </div>
                </div>
            @endif

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
                    <button type="button" onclick="closeRejectModal()" class="art-btn" style="background:#cbd5e1; color:#334155; padding:0.6rem 1.2rem; border-radius:6px; border:none; font-weight:700; cursor:pointer;">Batal</button>
                    <button type="submit" class="art-btn" style="background:var(--primary-red); color:white; padding:0.6rem 1.5rem; border-radius:6px; border:none; font-weight:700; cursor:pointer;">Konfirmasi Tolak</button>
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
