<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

        <!-- Navbar Component -->
    @include('pages.admin.components.navbar-admin')

        <!-- Page Content -->
        <div class="admin-content">
            
            <div class="page-header" style="margin-bottom: 2.5rem;">
                <div class="page-title-group">
                    <span class="page-subtitle">OVERVIEW</span>
                    <h1 class="page-title" style="font-size: 2.5rem;">Dashboard<br>Admin</h1>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card-light" style="background-color: var(--primary-red); color: var(--text-light);">
                    <span class="stat-title" style="color: rgba(255,255,255,0.8);">TOTAL COLLECTION</span>
                    <span class="stat-value" style="color: var(--text-light);">{{ number_format($totalCollection) }} <span style="font-size: 1rem; font-weight: 500;">Vol.</span></span>
                    <i class="fas fa-book-open stat-icon" style="color: rgba(255,255,255,0.1);"></i>
                </div>
                <div class="stat-card-light">
                    <span class="stat-title">TOTAL PINJAMAN AKTIF</span>
                    <span class="stat-value">{{ number_format($totalPeminjamanAktif) }}</span>
                    <i class="fas fa-bookmark stat-icon"></i>
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

            <!-- E-Book Stats Title -->
            <div style="margin-top: 2.5rem; margin-bottom: 1rem;">
                <h2 style="font-size: 1.3rem; font-weight: 700; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-file-pdf" style="color: #1A56DB;"></i> E-Book Statistics
                </h2>
            </div>
            
            <div class="stats-grid" style="margin-bottom: 1.5rem;">
                <div class="stat-card-light" style="border-left: 4px solid #1A56DB;">
                    <span class="stat-title">TOTAL E-BOOK</span>
                    <span class="stat-value">{{ number_format($totalEbooks) }} <span style="font-size: 1rem; font-weight: 500;">Buku</span></span>
                    <i class="fas fa-file-pdf stat-icon" style="color: rgba(26, 86, 219, 0.05);"></i>
                </div>
                <div class="stat-card-light" style="border-left: 4px solid #10B981;">
                    <span class="stat-title">SEDANG DIPINJAM</span>
                    <span class="stat-value">{{ number_format($ebookSedangDipinjam) }}</span>
                    <i class="fas fa-book-reader stat-icon" style="color: rgba(16, 185, 129, 0.05);"></i>
                </div>
                <div class="stat-card-light" style="border-left: 4px solid #EF4444;">
                    <span class="stat-title">KADALUARSA</span>
                    <span class="stat-value">{{ number_format($ebookKadaluarsa) }}</span>
                    <i class="fas fa-history stat-icon" style="color: rgba(239, 68, 68, 0.05);"></i>
                </div>
                <div class="stat-card-light" style="border-left: 4px solid #F59E0B;">
                    <span class="stat-title">JUMLAH PEMBACA</span>
                    <span class="stat-value">{{ number_format($totalEbookReaders) }}</span>
                    <i class="fas fa-users stat-icon" style="color: rgba(245, 158, 11, 0.05);"></i>
                </div>
            </div>

            <div class="stats-grid" style="margin-bottom: 2rem;">
                <div class="stat-card-light" style="border-left: 4px solid #8B5CF6;">
                    <span class="stat-title">TOTAL REVIEW</span>
                    <span class="stat-value">{{ number_format($totalEbookReviews) }}</span>
                    <i class="fas fa-comments stat-icon" style="color: rgba(139, 92, 246, 0.05);"></i>
                </div>
                <div class="stat-card-light" style="border-left: 4px solid #EC4899;">
                    <span class="stat-title">PROGRESS RATA-RATA</span>
                    <span class="stat-value">{{ number_format($avgEbookProgress, 1) }}%</span>
                    <i class="fas fa-spinner stat-icon" style="color: rgba(236, 72, 153, 0.05);"></i>
                </div>
                <div class="stat-card-light" style="border-left: 4px solid #06B6D4;">
                    <span class="stat-title">PALING BANYAK DIPINJAM</span>
                    <span class="stat-value" style="font-size: 0.95rem; font-weight: 700; white-space: normal; line-height: 1.4; display: block; margin-top: 5px;">{{ $mostBorrowedEbookText }}</span>
                </div>
                <div class="stat-card-light" style="border-left: 4px solid #F59E0B;">
                    <span class="stat-title">RATING TERTINGGI</span>
                    <span class="stat-value" style="font-size: 0.95rem; font-weight: 700; white-space: normal; line-height: 1.4; display: block; margin-top: 5px;">{{ $highestRatedEbookText }}</span>
                </div>
            </div>

            <!-- Charts Section -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem; margin-top: 1rem;">
                <!-- Line Chart: Monthly loan trends -->
                <div class="admin-table-container" style="padding: 2rem; border-top: 4px solid #1A56DB;">
                    <h3 style="font-size: 1.1rem; color: var(--text-dark); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 700;">
                        <i class="fas fa-chart-line" style="color: #1A56DB;"></i> Tren Peminjaman Buku (6 Bulan Terakhir)
                    </h3>
                    <div style="position: relative; height: 280px; width: 100%;">
                        <canvas id="loanTrendChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut/Gauge Chart: Reading Interest in Tegal -->
                <div class="admin-table-container" style="padding: 2rem; border-top: 4px solid #10B981; display: flex; flex-direction: column; justify-content: space-between;">
                    <h3 style="font-size: 1.1rem; color: var(--text-dark); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px; font-weight: 700;">
                        <i class="fas fa-chart-pie" style="color: #10B981;"></i> Minat Baca Kota Tegal
                    </h3>
                    <div style="position: relative; height: 180px; display: flex; justify-content: center; align-items: center;">
                        <canvas id="readingInterestChart"></canvas>
                        <!-- Centered text for the percentage -->
                        <div style="position: absolute; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; pointer-events: none;">
                            <span style="font-size: 2.2rem; font-weight: 800; color: var(--text-dark); line-height: 1;">{{ $readingInterest }}%</span>
                            <span style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-top: 4px; letter-spacing: 0.5px;">Indeks Minat</span>
                        </div>
                    </div>
                    <div style="margin-top: 1rem; border-top: 1px solid #E2EAE5; padding-top: 1.2rem; font-size: 0.8rem; color: var(--text-muted); line-height: 1.5; text-align: center;">
                        Dihitung secara dinamis berdasarkan <strong>frekuensi peminjaman</strong>, <strong>durasi peminjaman</strong>, dan <strong>partisipasi anggota</strong>.
                    </div>
                </div>
            </div>

            <!-- Dashboard Intro -->
            <div class="admin-table-container" style="padding: 3rem; text-align: center; border-top: 4px solid var(--primary-red); margin-top: 2rem;">
                <i class="fas fa-chart-line" style="font-size: 4rem; color: var(--text-muted); margin-bottom: 1.5rem; opacity: 0.5;"></i>
                <h2 style="font-size: 1.5rem; color: var(--text-dark); margin-bottom: 1rem;">Selamat Datang di Kanca Tegal Admin</h2>
                <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto; line-height: 1.6;">
                    Gunakan navigasi di sebelah kiri untuk mengelola buku, sirkulasi peminjaman, anggota, dan artikel. Sistem ini membantu Anda mengontrol seluruh ekosistem arsip Kanca Tegal dengan mudah dan efisien.
                </p>
                <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem;">
                    <a href="{{ url('/admin/buku') }}" class="btn-admin-primary" style="text-decoration: none;">
                        <i class="fas fa-book"></i> Kelola Buku
                    </a>
                    <a href="{{ url('/admin/peminjaman') }}" class="btn-admin-secondary" style="text-decoration: none;">
                        <i class="fas fa-bookmark"></i> Daftar Peminjaman
                    </a>
                </div>
            </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Line Chart
            const ctxTrend = document.getElementById('loanTrendChart').getContext('2d');
            
            // Generate gradient for the line fill
            const blueGradient = ctxTrend.createLinearGradient(0, 0, 0, 250);
            blueGradient.addColorStop(0, 'rgba(26, 86, 219, 0.25)');
            blueGradient.addColorStop(1, 'rgba(26, 86, 219, 0.0)');

            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Frekuensi Peminjaman',
                        data: @json($chartData),
                        borderColor: '#1A56DB',
                        borderWidth: 3,
                        backgroundColor: blueGradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#1A56DB',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1E2E25',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            titleFont: {
                                family: 'Plus Jakarta Sans',
                                size: 12,
                                weight: '700'
                            },
                            bodyFont: {
                                family: 'Plus Jakarta Sans',
                                size: 12
                            },
                            cornerRadius: 8,
                            padding: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6B7A71',
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    weight: '600',
                                    size: 11
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#E2EAE5',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6B7A71',
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    weight: '600',
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            // Reading Interest Doughnut Chart
            const ctxInterest = document.getElementById('readingInterestChart').getContext('2d');
            const interestVal = @json($readingInterest);
            const remainingVal = 100 - interestVal;

            new Chart(ctxInterest, {
                type: 'doughnut',
                data: {
                    labels: ['Minat Baca', 'Sisa'],
                    datasets: [{
                        data: [interestVal, remainingVal],
                        backgroundColor: ['#10B981', '#E2EAE5'],
                        borderWidth: 0,
                        hoverOffset: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    }
                }
            });
        });
    </script>

        </div>
    </main>

</body>
</html>


