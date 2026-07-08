<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeliharaan Sistem - Kanca Tegal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-red: #8B1E0F;
            --primary-red-hover: #A7281A;
            --text-dark: #1E2E25;
            --text-light: #F4F6F4;
            --bg-dark: #0A0F0C;
            --bg-card: rgba(255, 255, 255, 0.03);
            --border-glass: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Decorative blur backgrounds */
        .glow-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: 1;
            opacity: 0.15;
        }

        .glow-1 {
            width: 400px;
            height: 400px;
            background: var(--primary-red);
            top: -100px;
            left: -100px;
        }

        .glow-2 {
            width: 500px;
            height: 500px;
            background: #2E5C3D;
            bottom: -150px;
            right: -150px;
        }

        .maintenance-container {
            position: relative;
            z-index: 10;
            max-width: 600px;
            width: 90%;
            padding: 3rem 2rem;
            text-align: center;
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .logo-section {
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: rgba(139, 30, 15, 0.1);
            border: 1px solid rgba(139, 30, 15, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .logo-icon i {
            font-size: 2.5rem;
            color: #E24A35;
            animation: pulse 2s infinite ease-in-out;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .brand-name span {
            color: #E24A35;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #FFFFFF;
        }

        p {
            font-size: 1rem;
            line-height: 1.6;
            color: rgba(244, 246, 244, 0.7);
            margin-bottom: 2rem;
        }

        .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.6rem 1.2rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #E24A35;
            margin-bottom: 2rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            border-top: 1px solid var(--border-glass);
            padding-top: 2rem;
        }

        .social-link {
            color: rgba(244, 246, 244, 0.5);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            color: #E24A35;
            transform: translateY(-3px);
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }
    </style>
</head>
<body>

    <div class="glow-circle glow-1"></div>
    <div class="glow-circle glow-2"></div>

    <div class="maintenance-container">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="brand-name">KANCA<span>TEGAL</span></div>
        </div>

        <h1>Under Maintenance</h1>
        <p>Kami sedang melakukan pemeliharaan rutin pada platform Kanca Tegal untuk meningkatkan kinerja dan menambahkan beberapa fitur baru. Kami akan segera kembali dalam beberapa saat.</p>

        <div class="time-badge">
            <i class="far fa-clock"></i> ESTIMATED TIME: 09.00 - 18.00 WIB
        </div>

        <div class="social-links">
            <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="far fa-envelope"></i></a>
        </div>
    </div>

</body>
</html>
