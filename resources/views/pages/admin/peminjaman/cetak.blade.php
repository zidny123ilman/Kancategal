<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Sirkulasi Peminjaman - Kanca Tegal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Styles */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 110px;
            vertical-align: middle;
            text-align: left;
        }

        .kop-logo img {
            width: 100px;
            height: auto;
        }

        .kop-text {
            vertical-align: middle;
            text-align: left;
            padding-left: 15px;
        }

        .kop-title {
            font-size: 22px;
            font-weight: bold;
            color: #C01E2E;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }

        .kop-info {
            font-size: 11px;
            color: #555;
            margin: 2px 0;
        }

        .kop-info a {
            color: #4A6B8C;
            text-decoration: none;
        }

        /* Title and Meta */
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .report-date {
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-bottom: 25px;
        }

        .meta-section {
            text-align: left;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .meta-row {
            margin-bottom: 4px;
        }

        .meta-label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 9px;
        }

        .data-table th {
            background-color: #C01E2E;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px 5px;
            border: 1px solid #C01E2E;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8px;
        }

        .badge-aktif {
            background-color: #e3f2fd;
            color: #0d47a1;
        }

        .badge-selesai {
            background-color: #e8f5e9;
            color: #1b5e20;
        }

        .badge-menunggu {
            background-color: #fff3e0;
            color: #e65100;
        }

        .badge-telat {
            background-color: #ffebee;
            color: #b71c1c;
        }

        /* Signature Section */
        .signature-container {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-space {
            width: 60%;
        }

        .signature-box {
            width: 40%;
            text-align: center;
            font-size: 11px;
        }

        .sig-date {
            margin-bottom: 5px;
        }

        .sig-role {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .sig-dept {
            color: #555;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <!-- Kop Kepala Surat Laporan -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo Kanca Tegal">
                @else
                    <div style="font-weight: bold; font-size: 14px; color: #C01E2E;">KANCA TEGAL</div>
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-title">KANCA TEGAL</div>
                <div class="kop-info">Telepon: +62 895-3246-06014 &nbsp;|&nbsp; Email: kancategal10@gmail.com</div>
                <div class="kop-info">Website: <a href="https://www.kancategal.com">www.kancategal.com</a> &nbsp;|&nbsp;
                    Alamat: Tegal, Jawa Tengah, Indonesia</div>
            </td>
        </tr>
    </table>

    <!-- Judul Laporan & Tanggal Cetak (Center) -->
    <div class="report-title">Laporan Sirkulasi Peminjaman</div>
    <div class="report-date">
        Tanggal Cetak: @php \Carbon\Carbon::setLocale('id'); @endphp
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>

    <!-- Nama Laporan & Periode (Align-Left) -->
    <div class="meta-section">
        <div class="meta-row">
            <span class="meta-label">Nama Laporan:</span>
            <span>Laporan Sirkulasi Peminjaman</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Kriteria Filter:</span>
            <span>{{ $periode }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Total Data Pinjam:</span>
            <span>{{ count($loans) }} Data Peminjaman</span>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 15%;">Peminjam</th>
                <th style="width: 13%;">No. WhatsApp</th>
                <th style="width: 22%;">Buku</th>
                <th style="width: 10%;">Tgl Pinjam</th>
                <th style="width: 10%;">Tgl Kembali</th>
                <th style="width: 10%;">Tgl Dikembalikan</th>
                <th style="width: 8%; text-align: center;">Status</th>
                <th style="width: 8%; text-align: right;">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $index => $loan)
                @php
                    $statusText = '';
                    $badgeClass = '';
                    $dendaText = '-';
                    $tanggalKembali = \Carbon\Carbon::parse($loan->tanggal_kembali);

                    if ($loan->status === 'selesai') {
                        $statusText = 'Selesai';
                        $badgeClass = 'badge-selesai';
                        $tanggalSelesai = $loan->tanggal_dikembalikan ? \Carbon\Carbon::parse($loan->tanggal_dikembalikan) : \Carbon\Carbon::parse($loan->updated_at);
                    } else {
                        $tanggalSelesai = \Carbon\Carbon::today();
                        if ($loan->status === 'pending_pinjam' || $loan->status === 'pending_kembali') {
                            $statusText = 'Menunggu';
                            $badgeClass = 'badge-menunggu';
                        } else {
                            // aktif
                            if ($tanggalSelesai->greaterThan($tanggalKembali)) {
                                $statusText = 'Telat';
                                $badgeClass = 'badge-telat';
                            } else {
                                $statusText = 'Aktif';
                                $badgeClass = 'badge-aktif';
                            }
                        }
                    }

                    // Denda calculation
                    $denda = 0;
                    $lateDays = 0;
                    $gracePeriod = (int) \App\Models\Setting::get('grace_period', 0);
                    $lateFineRate = (int) \App\Models\Setting::get('late_fine_rate', 1000);

                    if ($tanggalSelesai->greaterThan($tanggalKembali) && !in_array($loan->status, ['pending_pinjam', 'ditolak', 'ditolak_pinjam'])) {
                        $lateDays = (int) $tanggalSelesai->diffInDays($tanggalKembali, true);
                        if ($lateDays > $gracePeriod) {
                            $fineDays = $lateDays - $gracePeriod;
                            $denda = $fineDays * $lateFineRate;
                        }
                    }

                    // If loan is finished and they paid a specific amount of fine
                    if ($loan->denda_dibayar !== null) {
                        $denda = $loan->denda_dibayar;
                    }

                    if ($denda > 0) {
                        $dendaText = 'Rp ' . number_format($denda, 0, ',', '.');
                        if ($lateDays > $gracePeriod) {
                            $fineDays = $lateDays - $gracePeriod;
                            $dendaText .= "\n" . '(' . $fineDays . ' hari @ Rp ' . number_format($lateFineRate, 0, ',', '.') . ')';
                        }
                    }
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #111;">{{ $loan->user->name ?? '-' }}</td>
                    <td>{{ $loan->user->whatsapp ?? '-' }}</td>
                    <td>{{ $loan->buku->judul ?? '-' }}</td>
                    <td>{{ $loan->tanggal_pinjam ? \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->translatedFormat('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $loan->tanggal_dikembalikan ? \Carbon\Carbon::parse($loan->tanggal_dikembalikan)->translatedFormat('d/m/Y') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                    </td>
                    <td
                        style="text-align: right; font-weight: bold; color: {{ $denda > 0 ? '#b71c1c' : '#333' }}; white-space: pre-line;">
                        {{ $dendaText }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 20px; color: #777;">Tidak ada data sirkulasi
                        peminjaman yang sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature / Penanggung Jawab -->
    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td class="signature-space"></td>
                <td class="signature-box">
                    <div class="sig-date">Tegal, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                    <div class="sig-role">Penanggung Jawab,</div>
                    <div class="sig-name">{{ $adminName }}</div>
                    <div class="sig-dept">Administrator Kanca Tegal</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>