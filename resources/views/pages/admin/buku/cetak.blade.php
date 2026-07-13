<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Buku - Kanca Tegal</title>
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
            font-size: 10px;
        }

        .data-table th {
            background-color: #C01E2E;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px 6px;
            border: 1px solid #C01E2E;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 7px 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
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
            width: 65%;
        }

        .signature-box {
            width: 35%;
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
                    <!-- Fallback placeholder text if logo not found -->
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
    <div class="report-title">Laporan Data Buku</div>
    <div class="report-date">
        Tanggal Cetak: @php \Carbon\Carbon::setLocale('id'); @endphp
        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>

    <!-- Nama Laporan & Periode (Align-Left) -->
    <div class="meta-section">
        <div class="meta-row">
            <span class="meta-label">Nama Laporan:</span>
            <span>Laporan Daftar Buku</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Kriteria Filter:</span>
            <span>{{ $periode }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Total Buku:</span>
            <span>{{ count($books) }} unit</span>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 35%;">Judul Buku</th>
                <th style="width: 15%;">ISBN</th>
                <th style="width: 20%;">Author</th>
                <th style="width: 15%;">Penerbit</th>
                <th style="width: 10%;">Status Buku</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $index => $buku)
                @php
                    $avail = strtolower($buku->status) === 'dipinjam' ? 'Borrow' : 'ready';
                    $pub = strtolower($buku->status_publish ?? 'publish') === 'publish' ? 'publish' : 'draft';
                    $statusText = $avail . ' dan ' . $pub;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #111;">{{ $buku->judul }}</td>
                    <td>{{ $buku->isbn }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->penerbit }}</td>
                    <td style="text-transform: capitalize;">{{ $statusText }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #777;">Tidak ada data buku yang sesuai
                        filter.</td>
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