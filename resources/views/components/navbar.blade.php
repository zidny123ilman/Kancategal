<!-- Header / Navbar Component -->
@php
    $currentRoute = request()->path();
    if ($currentRoute === 'buku') {
        $searchAction = url('/buku');
    } elseif ($currentRoute === 'artikel') {
        $searchAction = url('/artikel');
    } else {
        $searchAction = url('/search');
    }
@endphp
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<header class="header">
    <nav class="navbar" id="main-navbar">
        <a href="{{ url('/') }}" class="logo">
            @php
                $siteTitle = \App\Models\Setting::get('site_title', 'KANCA TEGAL');
                $parts = explode(' ', $siteTitle, 2);
            @endphp
            {{ $parts[0] }}@if(isset($parts[1]))<span>{{ $parts[1] }}</span>@endif
        </a>
        
        <button class="mobile-toggle-btn" id="mobileNavbarToggle" style="display: none; background: none; border: none; font-size: 1.5rem; color: var(--text-dark); cursor: pointer; order: 3;">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="nav-menu">
            <li class="mobile-search-item" style="display: none; width: 100%; margin-bottom: 1rem;">
                <form action="{{ $searchAction }}" method="GET" style="margin: 0; display: flex; align-items: center; width: 100%;">
                    <div class="search-box" style="position: relative; display: flex; align-items: center; width: 100%;">
                        <i class="fas fa-search search-icon" onclick="this.closest('form').submit();" style="position: absolute; left: 1rem; color: var(--text-muted); cursor: pointer; font-size: 0.9rem;"></i>
                        <input type="text" name="q" class="search-input" placeholder="{{ __('Search archive...') }}" value="{{ request('q') }}" style="width: 100%; padding: 0.6rem 1rem 0.6rem 2.5rem; border-radius: 9999px; border: 1px solid var(--border-color); background: var(--bg-theme); font-size: 0.85rem; outline: none;">
                    </div>
                </form>
            </li>
            <li><a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">{{ __('Home') }}</a></li>
            <li><a href="{{ url('/buku') }}" class="nav-link {{ Request::is('buku') ? 'active' : '' }}">{{ __('Books') }}</a></li>
            <li><a href="{{ url('/about') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">{{ __('About') }}</a></li>
            <li><a href="{{ url('/artikel') }}" class="nav-link {{ Request::is('artikel') ? 'active' : '' }}">{{ __('Article') }}</a></li>
            <li><a href="{{ url('/kontak') }}" class="nav-link {{ Request::is('kontak') ? 'active' : '' }}">{{ __('Contact') }}</a></li>
        </ul>
        <div class="nav-actions">
            <form action="{{ $searchAction }}" method="GET" style="margin: 0; display: flex; align-items: center;">
                <div class="search-box">
                    <i class="fas fa-search search-icon" onclick="this.closest('form').submit();" style="cursor: pointer;"></i>
                    <input type="text" name="q" class="search-input" placeholder="{{ __('Search archive...') }}" value="{{ request('q') }}">
                </div>
            </form>
            @auth
                <div class="user-profile-menu" style="position: relative; display: inline-block; margin-left: 10px;">
                    <button class="btn-signin" style="background-color: var(--accent-blue); padding: 0.6rem 1.2rem; display: flex; align-items: center; gap: 8px;" onclick="document.getElementById('user-dropdown').classList.toggle('show')">
                        <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} <i class="fas fa-chevron-down" style="font-size: 0.75rem;"></i>
                    </button>
                    <div id="user-dropdown" class="user-dropdown-content" style="display: none; position: absolute; right: 0; top: 110%; background-color: var(--bg-white); min-width: 160px; box-shadow: var(--shadow-lg); border-radius: 8px; overflow: hidden; z-index: 10; border: 1px solid var(--border-color);">
                        @if (Auth::user()->can_upload_artikel)
                            <a href="{{ url('/upload-artikel') }}" style="display: block; padding: 0.8rem 1rem; font-size: 0.85rem; color: var(--text-dark); border-bottom: 1px solid rgba(0,0,0,0.05);"><i class="fas fa-plus-circle" style="margin-right: 8px; color: var(--primary-red);"></i> {{ __('Buat Artikel') }}</a>
                        @endif
                        <form action="{{ url('/logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 0.8rem 1rem; font-size: 0.85rem; color: var(--primary-red); cursor: pointer; display: block; font-family: inherit;"><i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> {{ __('Keluar') }}</button>
                        </form>
                    </div>
                </div>
                <script>
                    window.addEventListener('click', function(e) {
                        const menu = document.getElementById('user-dropdown');
                        const btn = menu ? menu.previousElementSibling : null;
                        if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.remove('show');
                        }
                    });
                    // add style to toggle
                    if (!document.getElementById('user-dropdown-styles')) {
                        const style = document.createElement('style');
                        style.id = 'user-dropdown-styles';
                        style.innerHTML = `
                            .user-dropdown-content.show { display: block !important; }
                            .user-dropdown-content a:hover { background-color: var(--bg-theme); }
                            .user-dropdown-content button:hover { background-color: var(--bg-theme); }
                        `;
                        document.head.appendChild(style);
                    }
                </script>
            @else
                <a href="{{ url('/login') }}" class="btn-signin" id="btn-signin-nav" style="display: inline-block; text-align: center;">{{ __('Sign In') }}</a>
            @endauth
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileNavbarToggle = document.getElementById('mobileNavbarToggle');
            const navMenu = document.querySelector('.nav-menu');
            if (mobileNavbarToggle && navMenu) {
                mobileNavbarToggle.addEventListener('click', (e) => {
                    navMenu.classList.toggle('active');
                    const icon = mobileNavbarToggle.querySelector('i');
                    if (navMenu.classList.contains('active')) {
                        icon.className = 'fas fa-times';
                    } else {
                        icon.className = 'fas fa-bars';
                    }
                    e.stopPropagation();
                });
                document.addEventListener('click', (e) => {
                    if (!navMenu.contains(e.target) && !mobileNavbarToggle.contains(e.target)) {
                        navMenu.classList.remove('active');
                        mobileNavbarToggle.querySelector('i').className = 'fas fa-bars';
                    }
                });
            }
        });
    </script>
</header>
