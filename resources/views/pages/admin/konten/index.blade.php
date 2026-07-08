<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management - Admin Kanca Tegal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Modern & Artistic CSS for Content Management Dashboard */
        :root {
            --bg-glass: rgba(255, 255, 255, 0.7);
            --border-glass: rgba(255, 255, 255, 0.4);
            --shadow-premium: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
            --primary-gradient: linear-gradient(135deg, #1e2e25 0%, #111a15 100%);
            --accent-gradient: linear-gradient(135deg, #c01e2e 0%, #a01825 100%);
        }

        .cnt-page-header {
            margin-bottom: 2rem;
            animation: fadeIn 0.8s ease-out;
        }

        .cnt-system-label {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: var(--primary-red);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }

        .cnt-page-title {
            font-size: 2.25rem;
            font-weight: 900;
            color: #1e2e25;
            margin-bottom: 0.5rem;
        }

        .cnt-page-desc {
            font-size: 0.95rem;
            color: #556052;
            line-height: 1.5;
        }

        /* Responsive Split Screen Editor */
        .cnt-editor-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 2rem;
            align-items: start;
            margin-bottom: 2rem;
        }

        @media (max-width: 1200px) {
            .cnt-editor-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Glassmorphic Panel Cards */
        .cnt-panel {
            background: var(--bg-glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-premium);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cnt-panel:hover {
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.12);
        }

        .cnt-panel-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e2e25;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cnt-panel-sub {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #8c9886;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            display: block;
        }

        /* Form Controls */
        .cnt-field-group {
            margin-bottom: 1.5rem;
        }

        .cnt-field-label {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: #4a5447;
            display: block;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .cnt-input, .cnt-textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #cbd2c8;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1e2e25;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .cnt-input:focus, .cnt-textarea:focus {
            outline: none;
            border-color: var(--primary-red);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(192, 30, 70, 0.15);
        }

        .cnt-textarea {
            resize: vertical;
            font-family: inherit;
        }

        /* Upload Area */
        .cnt-upload-area {
            border: 2px dashed #cbd2c8;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .cnt-upload-area:hover {
            border-color: var(--primary-red);
            background: rgba(192, 30, 70, 0.02);
        }

        .cnt-upload-icon {
            font-size: 1.75rem;
            color: #8c9886;
            margin-bottom: 0.25rem;
            transition: color 0.3s ease;
        }

        .cnt-upload-area:hover .cnt-upload-icon {
            color: var(--primary-red);
        }

        .cnt-upload-text {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e2e25;
        }

        .cnt-upload-sub {
            font-size: 0.75rem;
            color: #8c9886;
        }

        .cnt-file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Interactive Live Preview Mockup Browser */
        .cnt-mockup-browser {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            position: sticky;
            top: 20px;
            animation: slideIn 0.8s ease-out;
        }

        .cnt-browser-header {
            background: #f1f5f9;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
        }

        .cnt-browser-dots {
            display: flex;
            gap: 6px;
        }

        .cnt-browser-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .cnt-browser-dot--red { background: #ef4444; }
        .cnt-browser-dot--yellow { background: #f59e0b; }
        .cnt-browser-dot--green { background: #10b981; }

        .cnt-browser-address {
            background: #ffffff;
            border-radius: 6px;
            padding: 0.25rem 2rem;
            font-size: 0.75rem;
            color: #64748b;
            width: 60%;
            text-align: center;
            border: 1px solid #e2e8f0;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .cnt-browser-content {
            height: 480px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        /* Mini-Scale Landing Elements in Mockup */
        .preview-hero-section {
            background: #ffffff;
            padding: 2rem 1.5rem;
            position: relative;
            border-bottom: 8px solid #f1f5f9;
        }

        .preview-hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 1rem;
            align-items: center;
        }

        .preview-hero-badge {
            display: inline-block;
            background: rgba(192, 30, 46, 0.1);
            color: #c01e2e;
            font-size: 0.55rem;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .preview-hero-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #1e2e25;
            line-height: 1.15;
            margin-bottom: 0.5rem;
            font-family: Georgia, serif;
            word-wrap: break-word;
        }

        .preview-hero-desc {
            font-size: 0.75rem;
            color: #556052;
            line-height: 1.4;
            margin-bottom: 1rem;
        }

        .preview-btn {
            background: #1e2e25;
            color: #ffffff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            display: inline-block;
        }

        .preview-hero-img-wrapper {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            height: 160px;
            background: #e2e8f0;
        }

        .preview-hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-schedule-card {
            position: absolute;
            bottom: 8px;
            left: 8px;
            right: 8px;
            background: #1e2e25;
            color: #ffffff;
            padding: 8px;
            border-radius: 6px;
            font-size: 0.6rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            line-height: 1.3;
        }

        .preview-schedule-card p {
            margin: 0;
            font-weight: 600;
        }
        
        .preview-schedule-card span {
            color: #c8d4ce;
            font-size: 0.5rem;
            display: block;
            margin-top: 2px;
        }

        /* Mini-Scale About Map Element in Mockup */
        .preview-map-section {
            padding: 1.5rem;
            background: #f8fafc;
        }

        .preview-map-title {
            font-size: 0.85rem;
            font-weight: 800;
            color: #1e2e25;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .preview-map-iframe-container {
            border-radius: 8px;
            overflow: hidden;
            height: 180px;
            background: #e2e8f0;
            border: 1px solid #cbd2c8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .preview-map-iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Action Buttons Row */
        .cnt-action-row {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .cnt-btn {
            padding: 0.85rem 1.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .cnt-btn--discard {
            background: #e2e8f0;
            color: #475569;
        }

        .cnt-btn--discard:hover {
            background: #cbd5e1;
            color: #1e293b;
        }

        .cnt-btn--publish {
            background: var(--accent-gradient);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(192, 30, 46, 0.3);
        }

        .cnt-btn--publish:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(192, 30, 46, 0.4);
        }

        /* Version History Section */
        .cnt-version-section {
            margin-top: 3.5rem;
            background: #ffffff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-premium);
            border: 1px solid #e2e8f0;
        }

        .cnt-version-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .cnt-version-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1e2e25;
        }

        .cnt-version-sub {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #8c9886;
            text-transform: uppercase;
        }

        .cnt-version-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cnt-vth {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
            letter-spacing: 0.5px;
        }

        .cnt-vtr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s ease;
        }

        .cnt-vtr:hover {
            background: #f8fafc;
        }

        .cnt-vtd {
            padding: 1rem;
            font-size: 0.85rem;
            color: #334155;
            vertical-align: middle;
        }

        .cnt-modifier {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cnt-modifier-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #1e2e25;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .cnt-modifier-name {
            font-weight: 700;
            color: #1e2e25;
        }

        .cnt-tag {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            margin-right: 8px;
            letter-spacing: 0.5px;
        }

        .cnt-tag--blue { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
        .cnt-tag--green { background: rgba(16, 185, 129, 0.1); color: #059669; }
        .cnt-tag--purple { background: rgba(139, 92, 246, 0.1); color: #7c3aed; }
        .cnt-tag--orange { background: rgba(245, 158, 11, 0.1); color: #d97706; }
        .cnt-tag--red { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

        .cnt-change-desc {
            color: #475569;
        }

        .cnt-status-published {
            background: #e2fbe8;
            color: #15803d;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success {
            background-color: #E6F4EA;
            border: 1px solid #137333;
            color: #137333;
        }
        .alert-info {
            background-color: #E8F0FE;
            border: 1px solid #1a73e8;
            color: #1a73e8;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>

    @include('pages.admin.components.navbar-admin')

    <!-- Page Content -->
    <div class="admin-content">

        <!-- Page Header -->
        <div class="cnt-page-header">
            <span class="cnt-system-label">SYSTEM CONFIGURATION</span>
            <h1 class="cnt-page-title">Landing Page Editor</h1>
            <p class="cnt-page-desc">Customize the digital storefront and about info of Kanca Tegal. Adjust brand messaging,<br>hero backgrounds, opening schedules, and location maps with real-time feedback.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
        @endif

        <!-- Editor Grid -->
        <div class="cnt-editor-grid">

            <!-- LEFT: Editor Form -->
            <div class="cnt-panel">
                <span class="cnt-panel-sub">LANDING CONFIGURATION</span>
                <div class="cnt-panel-title" style="margin-bottom: 1.5rem;">
                    <i class="fas fa-edit" style="color: var(--primary-red);"></i> Curation Console
                </div>

                <form action="{{ url('/admin/konten/update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Section: Hero Content -->
                    <div style="margin-bottom: 2rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 1.5rem;">
                        <h3 style="font-size: 0.95rem; font-weight: 800; color: #1e2e25; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-home" style="color: #64748b; font-size: 0.85rem;"></i> 1. Hero Landing Page
                        </h3>

                        <!-- Hero Headline -->
                        <div class="cnt-field-group">
                            <label class="cnt-field-label" for="hero_title">Hero Title / Headline</label>
                            <textarea class="cnt-textarea" id="hero_title" name="hero_title" rows="2" placeholder="KANCA&#10;TEGAL" required>{{ $settings['hero_title'] }}</textarea>
                            <div style="font-size: 0.75rem; color: #8c9886; margin-top: 4px;">Use new lines (Enter) to control text wrapping in the hero logo area.</div>
                        </div>

                        <!-- Sub-caption Text -->
                        <div class="cnt-field-group">
                            <label class="cnt-field-label" for="hero_subtitle">Hero Subtitle / Description</label>
                            <textarea class="cnt-textarea" id="hero_subtitle" name="hero_subtitle" rows="3" placeholder="A creative community..." required>{{ $settings['hero_subtitle'] }}</textarea>
                        </div>

                        <!-- Schedule Info -->
                        <div class="cnt-field-group">
                            <label class="cnt-field-label" for="schedule_info">Opening Schedule Card text</label>
                            <input class="cnt-input" type="text" id="schedule_info" name="schedule_info" placeholder="Kanca Tegal library open everyday on 09.00-18.00." value="{{ $settings['schedule_info'] }}" required>
                        </div>

                        <!-- Hero Background Image -->
                        <div class="cnt-field-group">
                            <label class="cnt-field-label">Hero Background Image</label>
                            <div class="cnt-upload-area">
                                <i class="fas fa-cloud-upload-alt cnt-upload-icon"></i>
                                <span class="cnt-upload-text">Drag & drop or click to replace image</span>
                                <span class="cnt-upload-sub">Supports JPG, PNG, WEBP (Max 2MB)</span>
                                <input type="file" class="cnt-file-input" id="hero_image_file" name="hero_image" accept="image/*">
                            </div>
                            <div style="font-size: 0.75rem; color: #8c9886; margin-top: 6px; word-break: break-all;" id="preview-filename">
                                CURRENT: {{ basename($settings['hero_image']) }}
                            </div>
                        </div>
                    </div>

                    <!-- Section: About Page & Location Map -->
                    <div style="margin-bottom: 1.5rem;">
                        <h3 style="font-size: 0.95rem; font-weight: 800; color: #1e2e25; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-map-marked-alt" style="color: #64748b; font-size: 0.85rem;"></i> 2. Location & Map (About Page)
                        </h3>

                        <!-- Map Label -->
                        <div class="cnt-field-group">
                            <label class="cnt-field-label" for="map_label">Map Location Label</label>
                            <input class="cnt-input" type="text" id="map_label" name="map_label" placeholder="LAPAK KAMI: Alun-alun Kota Tegal (Setiap Minggu Pagi)" value="{{ $settings['map_label'] }}" required>
                        </div>

                        <!-- Map Embed Link -->
                        <div class="cnt-field-group">
                            <label class="cnt-field-label" for="map_embed_url">Google Maps Embed URL</label>
                            <textarea class="cnt-textarea" id="map_embed_url" name="map_embed_url" rows="3" placeholder="https://www.google.com/maps/embed?pb=..." required>{{ $settings['map_embed_url'] }}</textarea>
                            <div style="font-size: 0.75rem; color: #8c9886; margin-top: 4px;">Paste the Google Maps embed URL (the value of <code>src</code> attribute in standard iframe embed code).</div>
                        </div>
                    </div>

                    <!-- Action Row -->
                    <div class="cnt-action-row">
                        <button type="button" class="cnt-btn cnt-btn--discard" onclick="window.location.reload();">DISCARD DRAFT</button>
                        <button type="submit" class="cnt-btn cnt-btn--publish">PUBLISH TO LIVE</button>
                    </div>

                </form>
            </div>

            <!-- RIGHT: Interactive Live Preview -->
            <div>
                <div class="cnt-mockup-browser">
                    <!-- Browser Header -->
                    <div class="cnt-browser-header">
                        <div class="cnt-browser-dots">
                            <span class="cnt-browser-dot cnt-browser-dot--red"></span>
                            <span class="cnt-browser-dot cnt-browser-dot--yellow"></span>
                            <span class="cnt-browser-dot cnt-browser-dot--green"></span>
                        </div>
                        <div class="cnt-browser-address">kancategal.com/live-preview</div>
                        <div style="width: 40px;"></div>
                    </div>

                    <!-- Mockup Window Content -->
                    <div class="cnt-browser-content">
                        
                        <!-- Toggle Preview Tabs -->
                        <div style="display: flex; border-bottom: 1px solid #e2e8f0; background: #f8fafc; sticky: top;">
                            <button id="tab-hero" class="preview-tab" style="flex: 1; padding: 0.75rem; border: none; background: #ffffff; font-weight: 800; font-size: 0.75rem; color: #1e2e25; border-bottom: 2px solid var(--primary-red); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fas fa-home"></i> Hero Landing Page
                            </button>
                            <button id="tab-map" class="preview-tab" style="flex: 1; padding: 0.75rem; border: none; background: #f8fafc; font-weight: 700; font-size: 0.75rem; color: #64748b; border-bottom: 1px solid #e2e8f0; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fas fa-map-marker-alt"></i> About Page Map
                            </button>
                        </div>

                        <!-- 1. Hero Section Mockup View -->
                        <div id="view-hero" class="preview-view">
                            <div class="preview-hero-section">
                                <div class="preview-hero-grid">
                                    <div>
                                        <span class="preview-hero-badge">COMMUNITY PLATFORM</span>
                                        <h1 class="preview-hero-title" id="preview-title">{!! nl2br(e($settings['hero_title'])) !!}</h1>
                                        <p class="preview-hero-desc" id="preview-subtitle">{{ $settings['hero_subtitle'] }}</p>
                                        <button class="preview-btn">EXPLORE MORE</button>
                                    </div>
                                    <div class="preview-hero-img-wrapper">
                                        @if(str_starts_with($settings['hero_image'], 'http'))
                                            <img src="{{ $settings['hero_image'] }}" alt="Hero Background" class="preview-hero-img" id="preview-hero-img">
                                        @else
                                            <img src="{{ asset($settings['hero_image']) }}" alt="Hero Background" class="preview-hero-img" id="preview-hero-img">
                                        @endif
                                        <div class="preview-schedule-card">
                                            <p id="preview-schedule">"{{ $settings['schedule_info'] }}"</p>
                                            <span>Visit Us Today &rarr;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Map Section Mockup View -->
                        <div id="view-map" class="preview-view" style="display: none;">
                            <div class="preview-map-section">
                                <h3 class="preview-map-title" id="preview-map-label">{{ $settings['map_label'] }}</h3>
                                <div class="preview-map-iframe-container">
                                    <iframe id="preview-map-iframe" src="{{ $settings['map_embed_url'] }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Version History -->
        <div class="cnt-version-section">
            <div class="cnt-version-header">
                <div>
                    <div class="cnt-version-title">Version History</div>
                    <div class="cnt-version-sub">AUDIT LOG</div>
                </div>
            </div>

            <table class="cnt-version-table">
                <thead>
                    <tr>
                        <th class="cnt-vth">MODIFIER</th>
                        <th class="cnt-vth">ELEMENT CHANGED</th>
                        <th class="cnt-vth">DETAILS</th>
                        <th class="cnt-vth">TIMESTAMP</th>
                        <th class="cnt-vth">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            $modifierName = 'Admin';
                            $initials = 'AD';
                            // Parse modifier name if formatted in details (e.g. "AdminName updated ...")
                            preg_match('/^([A-Za-z\s\.\-]+) updated|^([A-Za-z\s\.\-]+) uploaded/', $log->details, $matches);
                            if (!empty($matches)) {
                                $modifierName = trim($matches[1] ?: $matches[2]);
                                $parts = explode(' ', $modifierName);
                                $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                            }

                            // Clean action name
                            $cleanedAction = str_replace('CONTENT_', '', $log->action);
                            
                            // Badge color selection
                            $tagClass = 'cnt-tag--blue';
                            if ($cleanedAction === 'HERO_IMAGE') $tagClass = 'cnt-tag--green';
                            if ($cleanedAction === 'SCHEDULE') $tagClass = 'cnt-tag--orange';
                            if ($cleanedAction === 'MAP_EMBED') $tagClass = 'cnt-tag--purple';
                            if ($cleanedAction === 'MAP_LABEL') $tagClass = 'cnt-tag--red';
                        @endphp
                        <tr class="cnt-vtr {{ $loop->index >= 3 ? 'cnt-vtr-extra' : '' }}" {!! $loop->index >= 3 ? 'style="display: none;"' : '' !!}>
                            <td class="cnt-vtd">
                                <div class="cnt-modifier">
                                    <div class="cnt-modifier-avatar">{{ $initials }}</div>
                                    <span class="cnt-modifier-name">{{ $modifierName }}</span>
                                </div>
                            </td>
                            <td class="cnt-vtd">
                                <span class="cnt-tag {{ $tagClass }}">{{ $cleanedAction }}</span>
                            </td>
                            <td class="cnt-vtd cnt-change-desc">
                                {{ $log->details }}
                            </td>
                            <td class="cnt-vtd" style="color: #64748b; font-size: 0.8rem;">
                                {{ $log->created_at->format('d M Y, h:i A') }}
                                <span style="display:block; font-size: 0.7rem; color: #94a3b8;">{{ $log->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="cnt-vtd">
                                <span class="cnt-status-published">PUBLISHED</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="cnt-vtd" style="text-align: center; padding: 3rem; color: #8c9886;">
                                <i class="fas fa-history" style="font-size: 1.5rem; display: block; margin-bottom: 0.5rem; color: #cbd2c8;"></i>
                                No changes registered yet. Modify elements above to populate this log.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if(count($logs) > 3)
                <div style="text-align: center; margin-top: 1.5rem;">
                    <button id="toggle-history-btn" class="cnt-btn cnt-btn--discard" style="padding: 0.6rem 1.5rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-chevron-down"></i> Lihat Lebih Banyak
                    </button>
                </div>
            @endif
        </div>

    </div>

    <!-- Script for Live Preview Bindings and Tab toggles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form fields inputs
            const inputTitle = document.getElementById('hero_title');
            const inputSubtitle = document.getElementById('hero_subtitle');
            const inputSchedule = document.getElementById('schedule_info');
            const inputMapLabel = document.getElementById('map_label');
            const inputMapEmbed = document.getElementById('map_embed_url');
            const inputHeroImage = document.getElementById('hero_image_file');

            // Preview targets
            const previewTitle = document.getElementById('preview-title');
            const previewSubtitle = document.getElementById('preview-subtitle');
            const previewSchedule = document.getElementById('preview-schedule');
            const previewMapLabel = document.getElementById('preview-map-label');
            const previewMapIframe = document.getElementById('preview-map-iframe');
            const previewHeroImage = document.getElementById('preview-hero-img');
            const previewFilenameLabel = document.getElementById('preview-filename');

            // Tab navigation elements
            const tabHero = document.getElementById('tab-hero');
            const tabMap = document.getElementById('tab-map');
            const viewHero = document.getElementById('view-hero');
            const viewMap = document.getElementById('view-map');

            // 1. Live Preview: Text Bindings
            if (inputTitle && previewTitle) {
                inputTitle.addEventListener('input', () => {
                    previewTitle.innerHTML = inputTitle.value.replace(/\n/g, '<br>');
                });
            }

            if (inputSubtitle && previewSubtitle) {
                inputSubtitle.addEventListener('input', () => {
                    previewSubtitle.textContent = inputSubtitle.value;
                });
            }

            if (inputSchedule && previewSchedule) {
                inputSchedule.addEventListener('input', () => {
                    previewSchedule.textContent = `"${inputSchedule.value}"`;
                });
            }

            if (inputMapLabel && previewMapLabel) {
                inputMapLabel.addEventListener('input', () => {
                    previewMapLabel.textContent = inputMapLabel.value;
                });
            }

            // 2. Live Preview: Google Maps Iframe Bindings (with extracting src from direct iframe copy-paste)
            if (inputMapEmbed && previewMapIframe) {
                let mapTimeout;
                inputMapEmbed.addEventListener('input', () => {
                    clearTimeout(mapTimeout);
                    mapTimeout = setTimeout(() => {
                        let url = inputMapEmbed.value.trim();
                        // If admin pasted a full raw iframe HTML string, extract the src URL
                        if (url.startsWith('<iframe')) {
                            const srcMatch = url.match(/src="([^"]+)"/);
                            if (srcMatch && srcMatch[1]) {
                                url = srcMatch[1];
                                // update field value for clarity
                                inputMapEmbed.value = url;
                            }
                        }
                        previewMapIframe.src = url;
                    }, 800); // 800ms debounce
                });
            }

            // 3. Live Preview: File Image Upload Bindings
            if (inputHeroImage && previewHeroImage) {
                inputHeroImage.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewHeroImage.src = e.target.result;
                            if (previewFilenameLabel) {
                                previewFilenameLabel.textContent = 'PREVIEW: ' + file.name + ' (unsaved)';
                                previewFilenameLabel.style.color = '#c01e2e';
                                previewFilenameLabel.style.fontWeight = '700';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // 4. Preview Window: Tab switching functionality
            if (tabHero && tabMap) {
                tabHero.addEventListener('click', (e) => {
                    e.preventDefault();
                    // Update active tab styling
                    tabHero.style.background = '#ffffff';
                    tabHero.style.color = '#1e2e25';
                    tabHero.style.borderBottom = '2px solid var(--primary-red)';
                    tabHero.style.fontWeight = '800';

                    tabMap.style.background = '#f8fafc';
                    tabMap.style.color = '#64748b';
                    tabMap.style.borderBottom = '1px solid #e2e8f0';
                    tabMap.style.fontWeight = '700';

                    // Switch view
                    viewHero.style.display = 'block';
                    viewMap.style.display = 'none';
                });

                tabMap.addEventListener('click', (e) => {
                    e.preventDefault();
                    // Update active tab styling
                    tabMap.style.background = '#ffffff';
                    tabMap.style.color = '#1e2e25';
                    tabMap.style.borderBottom = '2px solid var(--primary-red)';
                    tabMap.style.fontWeight = '800';

                    tabHero.style.background = '#f8fafc';
                    tabHero.style.color = '#64748b';
                    tabHero.style.borderBottom = '1px solid #e2e8f0';
                    tabHero.style.fontWeight = '700';

                    // Switch view
                    viewMap.style.display = 'block';
                    viewHero.style.display = 'none';
                });
            }

            // Toggle Content Version History rows
            const toggleBtn = document.getElementById('toggle-history-btn');
            const extraRows = document.querySelectorAll('.cnt-vtr-extra');
            if (toggleBtn && extraRows.length > 0) {
                let isExpanded = false;
                toggleBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    isExpanded = !isExpanded;
                    extraRows.forEach(row => {
                        row.style.display = isExpanded ? 'table-row' : 'none';
                    });
                    toggleBtn.innerHTML = isExpanded 
                        ? '<i class="fas fa-chevron-up"></i> Lihat Lebih Sedikit' 
                        : '<i class="fas fa-chevron-down"></i> Lihat Lebih Banyak';
                });
            }
        });
    </script>
</body>
</html>
