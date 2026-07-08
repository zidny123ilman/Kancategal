<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Kanca Tegal</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon-admin.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-login-body">
    <div class="admin-login-container">
        <!-- Left Side: Image -->
        <div class="admin-login-left">
            <div class="admin-login-overlay"></div>
            <img src="{{ asset('images/admin_library_bg.png') }}" alt="Library Background" class="admin-login-bg-img">
            <div class="admin-login-left-content">
                <p class="admin-login-identity">SYSTEM IDENTITY</p>
                <h1 class="admin-login-title">THE MODERN<br>ARCHIVIST</h1>
                <p class="admin-login-desc">Curation is the bridge between history and the digital future. Access the core of Kanca Tegal's collective memory.</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="admin-login-right">
            <div class="admin-login-form-wrapper">
                <div class="admin-login-header">
                    <div class="admin-login-logo">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19.5C4 18.837 4.26339 18.2011 4.73223 17.7322C5.20107 17.2634 5.83696 17 6.5 17H20" stroke="#C01E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.5 2H20V22H6.5C5.83696 22 5.20107 21.7366 4.73223 21.2678C4.26339 20.7989 4 20.163 4 19.5V4.5C4 3.83696 4.26339 3.20107 4.73223 2.73223C5.20107 2.26339 5.83696 2 6.5 2V2Z" stroke="#C01E2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>KANCA TEGAL</span>
                    </div>
                    <div class="admin-login-badge">
                        ADMIN ACCESS &bull; CMS PORTAL
                    </div>
                </div>

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0;">
                            <path d="M12 9V11M12 15H12.01M5.07183 19H18.9282C20.4678 19 21.4301 17.3333 20.6603 16L13.7321 4C12.9623 2.66667 11.0377 2.66667 10.2679 4L3.33975 16C2.56995 17.3333 3.5322 19 5.07183 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div style="background: rgba(19, 115, 51, 0.08); border: 1px solid rgba(19, 115, 51, 0.2); color: #137333; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0;">
                            <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form class="admin-login-form" action="{{ url('/admin/login') }}" method="POST">
                    @csrf
                    <div class="admin-login-input-group">
                        <label for="username">USERNAME / EMAIL</label>
                        <input type="text" id="username" name="username" placeholder="administrator@kancategal.com" value="{{ old('username') }}" required>
                    </div>

                    <div class="admin-login-input-group">
                        <div class="admin-login-label-flex">
                            <label for="password">PASSWORD</label>
                            <a href="#" class="admin-login-forgot">FORGOT PASSWORD?</a>
                        </div>
                        <input type="password" id="password" name="password" placeholder="••••••••••••" required>
                    </div>

                    <button type="submit" class="admin-login-submit">
                        ENTER DASHBOARD
                    </button>
                </form>

                <div class="admin-login-footer">
                    <p>&copy; 2024 KANCA TEGAL. THE MODERN ARCHIVIST COLLECTIVE</p>
                    <a href="/" class="admin-login-back">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        BACK TO WEBSITE
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
