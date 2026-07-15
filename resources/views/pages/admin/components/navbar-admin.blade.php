<link rel="icon" type="image/png" href="{{ asset('favicon-admin.png') }}">
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo-icon">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="sidebar-logo-text">
            <span class="sidebar-logo-title">KANCA TEGAL</span>
            <span class="sidebar-logo-subtitle">THE MODERN ARCHIVIST</span>
        </div>
        <button class="mobile-close-btn" id="mobileCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <ul class="sidebar-nav">
        <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/buku') ? 'active' : '' }}">
            <a href="{{ url('/admin/buku') }}" class="nav-link">
                <i class="fas fa-book"></i> Books
            </a>
        </li>
        @php
            $totalEbookMenunggu = \App\Models\EbookPeminjaman::where('status', 'Menunggu')->count();
        @endphp
        <li class="nav-item {{ Request::is('admin/ebook*') ? 'active' : '' }}">
            <a href="{{ url('/admin/ebook') }}" class="nav-link">
                <i class="fas fa-file-pdf"></i> E-Book
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/ebook/peminjaman*') ? 'active' : '' }}" style="padding-left: 0.5rem;">
            <a href="{{ url('/admin/ebook/peminjaman') }}" class="nav-link" style="font-size: 0.82rem; padding: 0.6rem 1rem 0.6rem 1.75rem;">
                <i class="fas fa-clock" style="font-size: 0.85rem;"></i>
                Peminjaman E-Book
                @if($totalEbookMenunggu > 0)
                    <span style="margin-left: auto; background-color: #D97706; color: #fff; font-size: 0.68rem; font-weight: 800; padding: 2px 7px; border-radius: 9999px; min-width: 20px; text-align: center;">{{ $totalEbookMenunggu }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/peminjaman') ? 'active' : '' }}">
            <a href="{{ url('/admin/peminjaman') }}" class="nav-link">
                <i class="fas fa-bookmark"></i> Peminjaman
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/member') ? 'active' : '' }}">
            <a href="{{ url('/admin/member') }}" class="nav-link">
                <i class="fas fa-user-friends"></i> Members
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/artikel') ? 'active' : '' }}">
            <a href="{{ url('/admin/artikel') }}" class="nav-link">
                <i class="fas fa-file-alt"></i> Articles
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/konten') ? 'active' : '' }}">
            <a href="{{ url('/admin/konten') }}" class="nav-link">
                <i class="fas fa-sliders-h"></i> Content Management
            </a>
        </li>
        <li class="nav-item {{ Request::is('admin/setting') ? 'active' : '' }}">
            <a href="{{ url('/admin/setting') }}" class="nav-link">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ url('/admin/logout') }}" class="logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="admin-main">

<!-- Topbar -->
<header class="admin-topbar">
    <div class="topbar-left-mobile">
        <button id="mobileMenuBtn" class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    @php
        $currentAdminPath = request()->path();
        if (str_contains($currentAdminPath, 'admin/buku')) {
            $adminSearchAction = url('/admin/buku');
        } elseif (str_contains($currentAdminPath, 'admin/ebook')) {
            $adminSearchAction = url('/admin/ebook');
        } elseif (str_contains($currentAdminPath, 'admin/peminjaman')) {
            $adminSearchAction = url('/admin/peminjaman');
        } elseif (str_contains($currentAdminPath, 'admin/member')) {
            $adminSearchAction = url('/admin/member');
        } elseif (str_contains($currentAdminPath, 'admin/artikel')) {
            $adminSearchAction = url('/admin/artikel');
        } else {
            $adminSearchAction = url('/admin/search');
        }
    @endphp
    <form action="{{ $adminSearchAction }}" method="GET" style="margin: 0; display: flex; align-items: center; width: 400px;">
        <div class="topbar-search" style="width: 100%;">
            <i class="fas fa-search" onclick="this.closest('form').submit();" style="cursor: pointer;"></i>
            <input type="text" name="q" placeholder="SEARCH ARCHIVE..." value="{{ request('q') }}">
        </div>
    </form>
    
    <div class="topbar-right">
        <div class="topbar-notification">
            <i class="far fa-bell"></i>
        </div>
        <div class="topbar-profile" id="profileDropdownBtn">
            <div class="profile-info">
                <span class="profile-role">ADMINISTRATOR</span>
                <span class="profile-name">{{ session('admin_fullname', 'Admin') }}</span>
            </div>
            <img src="{{ asset('images/profile.jpg') }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('admin_fullname', 'Admin')) }}&background=1E2E25&color=fff'" alt="Profile" class="profile-avatar" id="topbarProfileImg">
            
            <!-- Dropdown Menu -->
            <div class="profile-dropdown-menu" id="profileDropdownMenu">
                <a href="{{ url('/admin/setting') }}" class="dropdown-item">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/admin/logout') }}" class="dropdown-item text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</header>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileCloseBtn = document.getElementById('mobileCloseBtn');
        const adminSidebar = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');

        // Toggle Sidebar
        function toggleSidebar() {
            if(adminSidebar) adminSidebar.classList.toggle('active');
            if(sidebarOverlay) sidebarOverlay.classList.toggle('active');
            if(adminSidebar && adminSidebar.classList.contains('active')){
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleSidebar);
        if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', toggleSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

        // Toggle Profile Dropdown
        if (profileDropdownBtn && profileDropdownMenu) {
            profileDropdownBtn.addEventListener('click', function(e) {
                profileDropdownMenu.classList.toggle('active');
                e.stopPropagation();
            });

            document.addEventListener('click', function(e) {
                if (!profileDropdownBtn.contains(e.target)) {
                    profileDropdownMenu.classList.remove('active');
                }
            });
        }
    });
</script>
