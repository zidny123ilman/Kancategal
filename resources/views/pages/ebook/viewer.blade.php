<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Membaca: {{ $ebook->judul }} - Kanca Tegal</title>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-viewer: #121212;
            --bg-toolbar: #1e1e1e;
            --text-light: #e0e0e0;
            --accent-color: #1a56db;
            --border-dark: #2d2d2d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }

        body, html {
            width: 100%;
            height: 100%;
            background-color: var(--bg-viewer);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text-light);
            overflow: hidden;
        }

        /* Toolbar Header */
        .viewer-header {
            height: 60px;
            background-color: var(--bg-toolbar);
            border-bottom: 1px solid var(--border-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 50%;
        }

        .btn-back {
            background: none;
            border: 1px solid var(--border-dark);
            color: var(--text-light);
            border-radius: 6px;
            padding: 0.5rem 0.8rem;
            cursor: pointer;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: var(--border-dark);
            border-color: #555;
        }

        .book-title {
            font-size: 1rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .header-center {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-indicator {
            font-size: 0.9rem;
            font-weight: 600;
            background-color: rgba(255,255,255,0.05);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-input {
            width: 45px;
            background: rgba(255,255,255,0.1);
            border: none;
            border-radius: 4px;
            color: #fff;
            text-align: center;
            font-family: inherit;
            font-weight: 700;
            padding: 2px 4px;
            outline: none;
        }

        .page-input::-webkit-outer-spin-button,
        .page-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .progress-badge {
            font-size: 0.8rem;
            font-weight: 800;
            background-color: var(--accent-color);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
        }

        /* Canvas Workspace */
        .viewer-container {
            width: 100%;
            height: calc(100% - 60px);
            margin-top: 60px;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 2rem;
            position: relative;
        }

        .canvas-wrapper {
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            background-color: white;
            position: relative;
            transform-origin: top center;
        }

        canvas {
            display: block;
        }

        /* Floating Controller Panel */
        .floating-controls {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(30, 30, 30, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-dark);
            border-radius: 30px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            z-index: 100;
        }

        .control-btn {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.1rem;
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .control-btn:hover:not(:disabled) {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }

        .control-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .control-divider {
            width: 1px;
            height: 24px;
            background-color: var(--border-dark);
        }

        /* Loading Spinner */
        .loader-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--bg-viewer);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            z-index: 1000;
            transition: opacity 0.4s ease;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.1);
            border-top-color: var(--accent-color);
            border-radius: 50%;
            animation: spin 1s infinite linear;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Watermark block */
        .watermark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-content: space-around;
            pointer-events: none;
            z-index: 10;
            overflow: hidden;
            opacity: 0.08;
        }

        .watermark-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: #000;
            transform: rotate(-30deg);
            white-space: nowrap;
        }

        /* Mobile specific style overrides */
        @media (max-width: 576px) {
            .viewer-header {
                padding: 0 0.75rem;
            }
            .header-left {
                max-width: 40%;
            }
            .book-title {
                display: none;
            }
            .viewer-container {
                padding: 1rem 0.5rem;
            }
            .floating-controls {
                bottom: 1rem;
                padding: 0.4rem 0.6rem;
                gap: 0.8rem;
            }
        }
    </style>
</head>
<body oncontextmenu="return false;">

    <!-- Loader Overlay -->
    <div class="loader-overlay" id="loaderOverlay">
        <div class="spinner"></div>
        <p style="font-weight: 700;">Memuat Dokumen Digital...</p>
    </div>

    <!-- Header Toolbar -->
    <header class="viewer-header">
        <div class="header-left">
            <a href="{{ route('ebook.show', $ebook->id) }}" class="btn-back">
                <i class="fas fa-chevron-left"></i> <span>Kembali</span>
            </a>
            <span class="book-title">{{ $ebook->judul }}</span>
        </div>

        <div class="header-center">
            <div class="page-indicator">
                <span>Halaman</span>
                <input type="number" id="pageNumberInput" class="page-input" value="{{ $peminjaman->last_page }}" min="1">
                <span>dari <strong id="totalPagesVal">-</strong></span>
            </div>
        </div>

        <div class="header-right">
            <div class="progress-badge">
                <span id="progressPercentVal">{{ $peminjaman->progress_persen }}%</span> Dibaca
            </div>
        </div>
    </header>

    <!-- Workspace -->
    <div class="viewer-container" id="viewerContainer">
        <div class="canvas-wrapper" id="canvasWrapper">
            <canvas id="pdfCanvas"></canvas>
            
            <!-- Watermark to deter screenshots -->
            <div class="watermark-overlay">
                @for($i = 0; $i < 12; $i++)
                    <span class="watermark-text">{{ Auth::user()->name }} - Kanca Tegal</span>
                @endfor
            </div>
        </div>
    </div>

    <!-- Floating controls -->
    <div class="floating-controls">
        <button class="control-btn" id="prevPageBtn" title="Halaman Sebelumnya">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="control-btn" id="nextPageBtn" title="Halaman Selanjutnya">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <div class="control-divider"></div>
        
        <button class="control-btn" id="zoomOutBtn" title="Perkecil">
            <i class="fas fa-search-minus"></i>
        </button>
        <button class="control-btn" id="zoomInBtn" title="Perbesar">
            <i class="fas fa-search-plus"></i>
        </button>
        <button class="control-btn" id="fitWidthBtn" title="Lebar Sesuai Layar">
            <i class="fas fa-arrows-alt-h"></i>
        </button>
    </div>

    <!-- PDF.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        // Set workerSrc
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

        // Viewer state variables
        const ebookId = {{ $ebook->id }};
        const pdfUrl = "{{ route('ebook.pdf', $ebook->id) }}";
        let pdfDoc = null;
        let pageNum = {{ $peminjaman->last_page }};
        let pageRendering = false;
        let pageNumPending = null;
        let scale = 1.2;
        let saveProgressTimeout = null;

        const canvas = document.getElementById('pdfCanvas');
        const ctx = canvas.getContext('2d');

        // Elements
        const prevBtn = document.getElementById('prevPageBtn');
        const nextBtn = document.getElementById('nextPageBtn');
        const zoomInBtn = document.getElementById('zoomInBtn');
        const zoomOutBtn = document.getElementById('zoomOutBtn');
        const fitWidthBtn = document.getElementById('fitWidthBtn');
        const totalPagesVal = document.getElementById('totalPagesVal');
        const pageNumberInput = document.getElementById('pageNumberInput');
        const progressPercentVal = document.getElementById('progressPercentVal');
        const loaderOverlay = document.getElementById('loaderOverlay');
        const viewerContainer = document.getElementById('viewerContainer');

        // Load PDF document
        pdfjsLib.getDocument({
            url: pdfUrl,
            withCredentials: true // send session cookies
        }).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            totalPagesVal.textContent = pdfDoc.numPages;
            pageNumberInput.max = pdfDoc.numPages;

            // Hide loader
            loaderOverlay.style.opacity = '0';
            setTimeout(() => {
                loaderOverlay.style.display = 'none';
            }, 400);

            // Set dynamic scale based on screen size on first load
            fitToWidth();
        }).catch(err => {
            alert('Gagal memuat dokumen digital: ' + err.message);
            window.location.href = "{{ route('ebook.show', $ebook->id) }}";
        });

        // Render Page function
        function renderPage(num) {
            pageRendering = true;
            
            // Update input and button statuses
            pageNumberInput.value = num;
            prevBtn.disabled = (num <= 1);
            nextBtn.disabled = (num >= pdfDoc.numPages);

            // Fetch page
            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);

                // Wait for rendering to finish
                renderTask.promise.then(() => {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });

                // Update and save progress (debounced)
                updateProgressUI(num);
                queueSaveProgress(num);
            });
        }

        // Queue rendering if page is currently rendering
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        // Previous Page
        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        }
        prevBtn.addEventListener('click', onPrevPage);

        // Next Page
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        }
        nextBtn.addEventListener('click', onNextPage);

        // Zoom In
        zoomInBtn.addEventListener('click', () => {
            scale += 0.25;
            queueRenderPage(pageNum);
        });

        // Zoom Out
        zoomOutBtn.addEventListener('click', () => {
            if (scale <= 0.5) return;
            scale -= 0.25;
            queueRenderPage(pageNum);
        });

        // Fit Width
        function fitToWidth() {
            if (!pdfDoc) return;
            pdfDoc.getPage(pageNum).then(page => {
                const viewport = page.getViewport({ scale: 1.0 });
                const containerWidth = viewerContainer.clientWidth - 64; // pad 2rem
                scale = containerWidth / viewport.width;
                queueRenderPage(pageNum);
            });
        }
        fitWidthBtn.addEventListener('click', fitToWidth);

        // Manual Page input change
        pageNumberInput.addEventListener('change', (e) => {
            let val = parseInt(e.target.value);
            if (isNaN(val) || val < 1) val = 1;
            if (val > pdfDoc.numPages) val = pdfDoc.numPages;
            pageNum = val;
            queueRenderPage(pageNum);
        });

        // Update progress UI
        function updateProgressUI(num) {
            const percent = Math.min(100, Math.round((num / pdfDoc.numPages) * 100));
            progressPercentVal.textContent = percent + '%';
        }

        // Debounced Save Progress API Call
        function queueSaveProgress(num) {
            if (saveProgressTimeout) {
                clearTimeout(saveProgressTimeout);
            }

            saveProgressTimeout = setTimeout(() => {
                saveProgress(num);
            }, 1000); // Wait 1 second after last page turn before saving to prevent spam
        }

        function saveProgress(num) {
            const percent = Math.min(100, Math.round((num / pdfDoc.numPages) * 100));

            fetch(`/ebook/${ebookId}/update-progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    last_page: num,
                    progress_persen: percent
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    console.error('Failed to update progress on server:', data.message);
                }
            })
            .catch(err => {
                console.error('Error saving reading progress:', err);
            });
        }

        // Keybindings & Security features
        document.addEventListener('keydown', (e) => {
            // Block screenshots/prints/saves
            // Ctrl+P (Print)
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                alert('Pencetakan dokumen tidak diizinkan untuk melindungi hak cipta.');
            }
            // Ctrl+S (Save)
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                alert('Pengunduhan dokumen tidak diizinkan.');
            }
            // Right and Left Arrow keys for page navigation
            if (e.key === 'ArrowRight') {
                onNextPage();
            }
            if (e.key === 'ArrowLeft') {
                onPrevPage();
            }
        });
    </script>
</body>
</html>
