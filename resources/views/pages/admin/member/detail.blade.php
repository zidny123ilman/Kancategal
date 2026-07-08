<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Detail - Admin Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        .detail-container {
            max-width: 700px;
            margin: 0 auto;
            background: var(--bg-white);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border-top: 4px solid var(--primary-red);
            padding: 2.5rem;
        }
        .profile-card-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }
        .profile-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary-red);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(192, 30, 46, 0.2);
        }
        .profile-summary h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-dark);
        }
        .profile-summary p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.2rem;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }
        .detail-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            word-break: break-word;
        }
        .permission-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            margin-top: 0.2rem;
        }
        .badge-enabled {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }
        .badge-disabled {
            background-color: rgba(107, 122, 113, 0.1);
            color: var(--text-muted);
        }
        .btn-back-action {
            display: inline-block;
            background-color: var(--bg-sidebar);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0.8rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            text-align: center;
            transition: var(--transition-smooth);
        }
        .btn-back-action:hover {
            background-color: var(--border-color);
        }
    </style>
</head>
<body>

    @include('pages.admin.components.navbar-admin')

        <div class="admin-content" style="padding: 2.5rem 1.5rem;">
            
            <div style="margin-bottom: 2rem;">
                <a href="{{ url('/admin/member') }}" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Member
                </a>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success" style="background-color: #E6F4EA; border: 1px solid #137333; color: #137333; padding: 1rem; border-radius: 8px; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; max-width: 700px; margin: 0 auto 1.5rem auto;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="detail-container">
                <div class="profile-card-header">
                    <div class="profile-avatar-large">
                        {{ substr($member->name, 0, 2) }}
                    </div>
                    <div class="profile-summary">
                        <h2>{{ $member->name }}</h2>
                        <p>Bergabung sejak {{ $member->created_at->format('d F Y') }}</p>
                    </div>
                </div>

                <div class="detail-grid">
                    <div class="detail-group">
                        <span class="detail-label">ID Registrasi</span>
                        <span class="detail-value">#MBR-{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="detail-group">
                        <span class="detail-label">Status Akun</span>
                        <span class="detail-value">
                            @if($member->status === 'active')
                                <span style="color: #10B981; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #10B981;"></span> AKTIF
                                </span>
                            @elseif($member->status === 'suspended')
                                <span style="color: var(--primary-red); font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--primary-red);"></span> SUSPENDED
                                </span>
                            @else
                                <span style="color: #F59E0B; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: #F59E0B;"></span> {{ strtoupper($member->status) }}
                                </span>
                            @endif
                        </span>
                    </div>

                    <div class="detail-group">
                        <span class="detail-label">No. WhatsApp</span>
                        <span class="detail-value">{{ $member->whatsapp }}</span>
                    </div>

                    <div class="detail-group">
                        <span class="detail-label">Alamat Email</span>
                        <span class="detail-value">{{ $member->email ?? '-' }}</span>
                    </div>

                    <div class="detail-group" style="grid-column: span 2;">
                        <span class="detail-label">Alamat Lengkap</span>
                        <span class="detail-value" style="font-weight: 500; line-height: 1.6;">{{ $member->alamat }}</span>
                    </div>

                    <div class="detail-group">
                        <span class="detail-label">Akses Peminjaman</span>
                        <div>
                            @if($member->can_borrow)
                                <span class="permission-badge badge-enabled">
                                    <i class="fas fa-check-circle"></i> DIAKTIFKAN
                                </span>
                            @else
                                <span class="permission-badge badge-disabled">
                                    <i class="fas fa-times-circle"></i> DINONAKTIFKAN
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-group">
                        <span class="detail-label">Akses Upload Artikel</span>
                        <div>
                            @if($member->can_upload_artikel)
                                <span class="permission-badge badge-enabled">
                                    <i class="fas fa-check-circle"></i> DIAKTIFKAN
                                </span>
                            @else
                                <span class="permission-badge badge-disabled">
                                    <i class="fas fa-times-circle"></i> DINONAKTIFKAN
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Account Action (Status Execution) -->
                    <div class="detail-group" style="grid-column: span 2; border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-top: 1rem;">
                        <span class="detail-label">Eksekusi / Ubah Status Akun</span>
                        <form action="{{ url('/admin/member/update-status/' . $member->id) }}" method="POST" style="display: flex; gap: 1rem; align-items: center; margin-top: 0.5rem;">
                            @csrf
                            <select name="status" style="padding: 0.6rem 1rem; font-family: var(--font-main); font-size: 0.9rem; border: 1px solid var(--border-color); border-radius: 6px; color: var(--text-dark); background-color: var(--bg-main); transition: var(--transition-smooth); width: auto; min-width: 200px; height: 38px;">
                                <option value="active" {{ $member->status === 'active' ? 'selected' : '' }}>ACTIVE</option>
                                <option value="suspended" {{ $member->status === 'suspended' ? 'selected' : '' }}>SUSPENDED</option>
                            </select>
                            <button type="submit" style="background-color: var(--primary-red); color: white; border: none; border-radius: 6px; padding: 0 1.5rem; font-weight: 700; cursor: pointer; font-size: 0.85rem; height: 38px; display: inline-flex; align-items: center; justify-content: center; transition: var(--transition-smooth);" onmouseover="this.style.backgroundColor='var(--primary-red-hover)'" onmouseout="this.style.backgroundColor='var(--primary-red)'">
                                Simpan Status
                            </button>
                        </form>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 2rem; margin-top: 2rem; display: flex; justify-content: flex-end;">
                    <a href="{{ url('/admin/member') }}" class="btn-back-action">Kembali</a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
