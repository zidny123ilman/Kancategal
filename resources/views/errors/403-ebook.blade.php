<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak — Kanca Tegal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }

        .icon-wrap {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.12);
            border: 2px solid rgba(239, 68, 68, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
        }

        .icon-wrap i {
            font-size: 2.5rem;
            color: #ef4444;
        }

        .error-code {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #ef4444;
            margin-bottom: 0.75rem;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        p {
            font-size: 0.95rem;
            color: #94a3b8;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }
        .btn-primary:hover { background: linear-gradient(135deg, #2563eb, #1e40af); transform: translateY(-1px); }

        .btn-secondary {
            background: transparent;
            border: 1px solid #334155;
            color: #94a3b8;
        }
        .btn-secondary:hover { background: #334155; color: #e2e8f0; }

        .divider {
            height: 1px;
            background: #334155;
            margin: 1.75rem 0;
        }

        .info-box {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 10px;
            padding: 1rem;
            text-align: left;
            margin-bottom: 2rem;
        }

        .info-box p {
            font-size: 0.85rem;
            color: #93c5fd;
            margin: 0;
        }

        .info-box i {
            color: #60a5fa;
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap">
            <i class="fas fa-lock"></i>
        </div>

        <div class="error-code">Error 403</div>

        <h1>Akses E-Book Ditolak</h1>

        <p>{{ $message ?? 'Anda tidak memiliki izin untuk mengakses konten ini.' }}</p>

        <div class="info-box">
            <p>
                <i class="fas fa-info-circle"></i>
                Untuk membaca E-Book, Anda harus meminjam terlebih dahulu dan menunggu persetujuan admin.
            </p>
        </div>

        <div class="btn-group">
            <a href="/ebook" class="btn btn-primary">
                <i class="fas fa-book-open"></i> Jelajahi E-Book
            </a>
            @auth
            <a href="{{ route('ebook.riwayat') }}" class="btn btn-secondary">
                <i class="fas fa-history"></i> Lihat Riwayat Peminjaman
            </a>
            @else
            <a href="/login" class="btn btn-secondary">
                <i class="fas fa-sign-in-alt"></i> Login untuk Meminjam
            </a>
            @endauth
        </div>
    </div>
</body>
</html>
