<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo-icon">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="sidebar-logo-text">
            <span class="sidebar-logo-title">KANCA TEGAL</span>
            <span class="sidebar-logo-subtitle">THE MODERN ARCHIVIST</span>
        </div>
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
        <a href="{{ url('/') }}" class="logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>
