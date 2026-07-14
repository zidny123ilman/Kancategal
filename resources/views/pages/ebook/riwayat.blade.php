<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman E-Book - Kanca Tegal</title>
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        .history-section {
            padding: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .history-header {
            margin-bottom: 2.5rem;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 1rem;
        }

        /* Responsive Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background-color: var(--bg-white);
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .history-table th {
            background-color: var(--bg-theme);
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--border-color);
        }

        .history-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .history-table tr:last-child td {
            border-bottom: none;
        }

        .book-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .book-cover {
            width: 45px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .book-title {
            font-weight: 800;
            color: var(--text-dark);
            text-decoration: none;
            display: block;
        }

        .book-author {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Status Pills */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 0.35rem 0.8rem;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #E6F4EA;
            color: #137333;
        }

        .status-expired {
            background-color: #FCE8E6;
            color: #C5221F;
        }

        .status-completed {
            background-color: #E8F0FE;
            color: #1A73E8;
        }

        /* Action buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #1a56db;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .btn-action:hover {
            background-color: #1140a3;
        }

        .btn-review {
            background-color: transparent;
            color: #f59e0b;
            border: 1.5px solid #f59e0b;
        }

        .btn-review:hover {
            background-color: #fffbeb;
            color: #d97706;
            border-color: #d97706;
        }

        /* Progress Mini */
        .progress-mini-wrapper {
            background-color: var(--border-color);
            border-radius: 9999px;
            height: 5px;
            width: 80px;
            overflow: hidden;
            margin-top: 4px;
        }
        .progress-mini-fill {
            background-color: #1a56db;
            height: 100%;
        }

        /* Star Rating select style */
        .star-rating-wrapper input:checked ~ label {
            color: #ffc107 !important;
        }
        .star-rating-wrapper label:hover,
        .star-rating-wrapper label:hover ~ label {
            color: #ffc107 !important;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @media (max-width: 768px) {
            .history-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="history-section">
        
        <div class="history-header">
            <span style="font-size: 0.75rem; font-weight: 800; color: #1a56db; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 0.25rem;">USER AREA</span>
            <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--text-dark); letter-spacing: -0.5px; line-height: 1.2;">Riwayat Peminjaman E-Book</h1>
        </div>

        @if (session('success'))
            <div style="background-color: #E6F4EA; border-left: 4px solid #137333; color: #137333; padding: 1rem; border-radius: 6px; margin-bottom: 2rem; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background-color: rgba(192, 30, 46, 0.1); border-left: 4px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 6px; margin-bottom: 2rem; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>E-Book</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Akses</th>
                        <th>Progress Baca</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                        <tr>
                            <td>
                                <div class="book-meta">
                                    <img src="{{ Storage::url($item->ebook->cover) }}" alt="Cover" class="book-cover">
                                    <div>
                                        <a href="{{ route('ebook.show', $item->ebook->id) }}" class="book-title">{{ $item->ebook->judul }}</a>
                                        <span class="book-author">{{ $item->ebook->penulis }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted);">{{ $item->progress_persen }}% (Hlm {{ $item->last_page }})</span>
                                    <div class="progress-mini-wrapper">
                                        <div class="progress-mini-fill" style="width: {{ $item->progress_persen }}%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->status === 'Dipinjam')
                                    <span class="status-pill status-active"><i class="fas fa-book-open"></i> Aktif</span>
                                @elseif($item->status === 'Kadaluarsa')
                                    <span class="status-pill status-expired"><i class="fas fa-times-circle"></i> Kadaluarsa</span>
                                @else
                                    <span class="status-pill status-completed"><i class="fas fa-check-circle"></i> Selesai</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    @if($item->status === 'Dipinjam')
                                        <a href="{{ route('ebook.read', $item->ebook->id) }}" class="btn-action">
                                            <i class="fas fa-book-open"></i> BACA BUKU
                                        </a>
                                    @endif

                                    @if($item->rating === null)
                                        <button type="button" class="btn-action btn-review" onclick="openReviewModal({{ $item->id }}, '{{ addslashes($item->ebook->judul) }}')">
                                            <i class="far fa-star"></i> ULASAN
                                        </button>
                                    @else
                                        <div style="font-size: 0.75rem; color: #f59e0b; font-weight: 700;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $item->rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    @endif

                                    @if($item->status === 'Kadaluarsa')
                                        <form action="{{ route('ebook.pinjam', $item->ebook->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action" style="background-color: var(--text-dark);">
                                                <i class="fas fa-redo"></i> PINJAM LAGI
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 4rem 2rem; color: var(--text-muted);">
                                <i class="fas fa-history" style="font-size: 2.5rem; display: block; margin-bottom: 1rem; color: var(--border-color);"></i>
                                Anda belum pernah meminjam E-Book apa pun.
                                <a href="{{ url('/ebook') }}" style="display: block; margin-top: 1rem; color: #1a56db; font-weight: 700; text-decoration: underline;">Jelajahi Katalog E-Book</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $history->links() }}
        </div>
        
    </main>

    <!-- Review / Rating Modal -->
    <div id="reviewEbookModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center; backdrop-filter: blur(5px);">
        <div style="background-color: var(--bg-white); border-radius: 16px; width: 90%; max-width: 500px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid var(--border-color); position: relative; animation: modalFadeIn 0.3s ease-out; margin: auto; display: flex; flex-direction: column;">
            <span onclick="closeReviewModal()" style="position: absolute; right: 1.5rem; top: 1.2rem; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);">&times;</span>
            
            <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.5rem; letter-spacing: -0.5px;">Berikan Ulasan E-Book</h3>
            <p id="modalBookTitle" style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5; font-weight: 700;"></p>
            
            <form id="reviewForm" action="" method="POST">
                @csrf
                
                <!-- Star Rating input -->
                <div style="margin-bottom: 1.5rem; text-align: center;">
                    <label class="form-label" style="display: block; text-align: left; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Rating Anda</label>
                    <div class="star-rating-wrapper" style="display: inline-flex; flex-direction: row-reverse; gap: 0.5rem; justify-content: center; width: 100%;">
                        <input type="radio" id="star5" name="rating" value="5" style="display: none;"><label for="star5" class="fas fa-star rating-star" style="font-size: 2.2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                        <input type="radio" id="star4" name="rating" value="4" style="display: none;"><label for="star4" class="fas fa-star rating-star" style="font-size: 2.2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                        <input type="radio" id="star3" name="rating" value="3" style="display: none;"><label for="star3" class="fas fa-star rating-star" style="font-size: 2.2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                        <input type="radio" id="star2" name="rating" value="2" style="display: none;"><label for="star2" class="fas fa-star rating-star" style="font-size: 2.2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                        <input type="radio" id="star1" name="rating" value="1" style="display: none;"><label for="star1" class="fas fa-star rating-star" style="font-size: 2.2rem; color: #ccc; cursor: pointer; transition: color 0.2s;"></label>
                    </div>
                </div>
                
                <!-- Review text area -->
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="review" class="form-label" style="display: block; text-align: left; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">Ulasan Singkat</label>
                    <textarea id="review" name="review" required class="form-input" style="min-height: 100px; resize: vertical; width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--bg-theme); color: var(--text-dark); font-family: inherit; font-size: 0.9rem;" placeholder="Tulis pendapat singkat Anda mengenai E-Book ini..."></textarea>
                </div>
                
                <!-- Action buttons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn-secondary-action" onclick="closeReviewModal()" style="margin: 0; padding: 0.8rem 1.5rem; font-size: 0.85rem; border-radius: 6px;">Batal</button>
                    <button type="submit" class="btn-action" style="margin: 0; padding: 0.8rem 1.8rem; font-size: 0.85rem; background-color: #f59e0b; border-radius: 6px; border: none;">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReviewModal(peminjamanId, bookTitle) {
            const modal = document.getElementById('reviewEbookModal');
            const form = document.getElementById('reviewForm');
            const titleElem = document.getElementById('modalBookTitle');
            
            titleElem.textContent = bookTitle;
            form.action = `/ebook/peminjaman/${peminjamanId}/review`;
            
            modal.style.display = 'flex';
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewEbookModal');
            modal.style.display = 'none';
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('reviewEbookModal');
            if (e.target === modal) {
                closeReviewModal();
            }
        });
    </script>
</body>
</html>
