<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management - Admin Kanca Tegal</title>
    
    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        /* Toast notification styling */
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--accent-blue-grey);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .toast-notification.show {
            transform: translateY(0);
            opacity: 1;
        }
        .toast-icon-success {
            color: #4CAF50;
        }
    </style>
</head>
<body>

    <!-- Navbar Component -->
    @include('pages.admin.components.navbar-admin')

        <!-- Page Content -->
        <div class="admin-content">
            
            <div class="member-header-top">
                <div class="member-header-left">
                    <span class="page-subtitle">ARCHIVE MANAGEMENT</span>
                    <h1 class="page-title">Member Management</h1>
                    <p class="member-quote">"The archives are not silent. They are the breathing memory of a collective community."<br>— Administer access and curation roles.</p>
                </div>
                
                <div class="member-total-card">
                    <div class="member-total-info">
                        <span class="member-total-label">TOTAL MEMBERS</span>
                        <span class="member-total-val">{{ number_format($totalMembers) }}</span>
                    </div>
                    <div class="member-trend-icon">
                        <i class="fas fa-arrow-trend-up"></i>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #E6F4EA; border: 1px solid #137333; color: #137333; padding: 1rem; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" style="background-color: rgba(192, 30, 46, 0.1); border: 1px solid var(--primary-red); color: var(--primary-red); padding: 1rem; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="member-toolbar">
                <div class="member-toolbar-left" style="display: flex; gap: 1rem;">
                    <a href="{{ url('/admin/member/tambah') }}" class="btn-admin-primary" style="text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-plus"></i> ADD NEW MEMBER
                    </a>
                    <a href="{{ url('/admin/member/cetak') }}?{{ http_build_query(request()->query()) }}" target="_blank" class="btn-admin-secondary" style="text-transform: uppercase; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-print"></i> CETAK LAPORAN
                    </a>
                </div>
                <div class="member-toolbar-right">
                    <span class="pill-count-active">ACTIVE: {{ $activeMembers }}</span>
                    <span class="pill-count-pending">OTHERS: {{ $totalMembers - $activeMembers }}</span>
                </div>
            </div>

            <!-- Data Table -->
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>MEMBER INFORMATION</th>
                            <th>JOIN DATE</th>
                            <th>BORROW ACCESS</th>
                            <th>ARTICLE UPLOAD</th>
                            <th>STATUS AKSES</th>
                            <th style="text-align: right;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>
                                    <div class="td-member-info">
                                        <div class="td-member-avatar" style="background-color: var(--accent-blue-grey); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 50%; width: 40px; height: 40px; font-size: 0.9rem;">
                                            {{ substr($member->name, 0, 2) }}
                                        </div>
                                        <div class="td-book-details">
                                            <span class="td-member-name">
                                                <a href="{{ url('/admin/member/detail/' . $member->id) }}" style="color: var(--text-dark); font-weight: 700; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                    {{ $member->name }}
                                                </a>
                                            </span>
                                            <span class="td-id">{{ $member->whatsapp }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-date">{{ $member->created_at->format('M d, Y') }}</td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" 
                                               class="permission-toggle" 
                                               data-user-id="{{ $member->id }}" 
                                               data-type="can_borrow" 
                                               {{ $member->can_borrow ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <label class="toggle-switch">
                                        <input type="checkbox" 
                                               class="permission-toggle" 
                                               data-user-id="{{ $member->id }}" 
                                               data-type="can_upload_artikel" 
                                               {{ $member->can_upload_artikel ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    @if($member->status === 'active')
                                        <span class="pill-status-active"><span class="status-dot-sm"></span> ACTIVE</span>
                                    @elseif($member->status === 'suspended')
                                        <span class="pill-status-danger" style="background-color: rgba(192, 30, 46, 0.1); color: var(--primary-red);"><span class="status-dot-sm" style="background-color: var(--primary-red);"></span> SUSPENDED</span>
                                    @else
                                        <span class="pill-status-danger" style="background-color: rgba(245, 158, 11, 0.1); color: #F59E0B;"><span class="status-dot-sm" style="background-color: #F59E0B;"></span> {{ strtoupper($member->status) }}</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ url('/admin/member/delete/' . $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member {{ $member->name }}?');" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action-sm btn-danger" style="background-color: var(--primary-red); color: white; border: none; border-radius: 4px; padding: 0.4rem 0.8rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: var(--transition-smooth);" onmouseover="this.style.backgroundColor='var(--primary-red-hover)'" onmouseout="this.style.backgroundColor='var(--primary-red)'">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                    Belum ada anggota komunitas yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="table-footer">
                    <span class="table-info" style="text-transform: uppercase;">SHOWING {{ $members->count() }} OF {{ $totalMembers }} MEMBERS</span>
                </div>
            </div>

            <!-- Dashboard Bottom Section -->
            <div class="member-dashboard-bottom">
                
                <!-- Recent Logs -->
                <div class="member-card-box" style="flex: 0.8;">
                    <div class="member-card-title">
                        <div class="member-card-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        Recent Logs
                    </div>
                    
                    @forelse($logs as $log)
                        <div class="log-item">
                            <span class="log-label" style="background-color: var(--primary-red); color: white; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">{{ $log->action }}</span>
                            <div class="log-text">{{ $log->details }}</div>
                            <div class="log-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div style="padding: 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.85rem;">
                            Belum ada log aktivitas admin.
                        </div>
                    @endforelse
                </div>

                <!-- Access Control Overview -->
                <div class="member-card-box" style="flex: 1.2;">
                    <div class="member-card-title">
                        Access Control Overview
                    </div>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 2rem; line-height: 1.5;">
                        Member permissions directly impact the digital library's growth. Ensure all uploading members are verified contributors.
                    </p>
                    
                    <div style="display: flex; gap: 3rem;">
                        <div style="flex: 1;">
                            <div class="progress-header">GLOBAL BORROWING</div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $borrowPercent }}%;"></div>
                            </div>
                            <span class="progress-value-text red">{{ $borrowPercent }}% ENABLED</span>
                        </div>
                        <div style="flex: 1;">
                            <div class="progress-header">ARCHIVE CONTRIBUTIONS</div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill blue" style="width: {{ $uploadPercent }}%;"></div>
                            </div>
                            <span class="progress-value-text blue">{{ $uploadPercent }}% ENABLED</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Toast Notification Element -->
    <div id="toast" class="toast-notification">
        <i class="fas fa-check-circle toast-icon-success"></i>
        <span id="toast-message">Hak akses diperbarui!</span>
    </div>

    <!-- AJAX script to toggle permissions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('.permission-toggle');
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');

            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const userId = this.getAttribute('data-user-id');
                    const permissionType = this.getAttribute('data-type');
                    const value = this.checked ? 1 : 0;

                    // Get CSRF Token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`{{ url('/admin/member') }}/${userId}/toggle-permission`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            permission_type: permissionType,
                            value: value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show toast
                            toastMsg.textContent = data.message;
                            toast.classList.add('show');
                            
                            // Auto hide toast after 3 seconds
                            setTimeout(() => {
                                toast.classList.remove('show');
                            }, 3000);
                        } else {
                            alert('Terjadi kesalahan saat memperbarui hak akses.');
                            // revert toggle state
                            this.checked = !this.checked;
                        }
                    })
                    .catch(error => {
                        console.error('Error updating permission:', error);
                        alert('Gagal menghubungkan ke server.');
                        // revert toggle state
                        this.checked = !this.checked;
                    });
                });
            });
        });
    </script>
</body>
</html>
