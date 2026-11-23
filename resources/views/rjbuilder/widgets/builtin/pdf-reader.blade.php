@php
    $heightMap = ['500' => '500px', '700' => '700px', '900' => '900px', 'full' => '80vh'];
    $viewerHeight = $heightMap[$opts['height']] ?? '700px';
    $displayTitle = $opts['title'] !== '' ? $opts['title'] : basename(parse_url($url, PHP_URL_PATH) ?: 'document.pdf');
    $safeUrl = e($url);
@endphp

<style>
    #{{ $uid }} { --acc: {{ $opts['accent'] }}; --t: #0f172a; --m: #64748b; --bd: #e2e8f0; --bg: #fff; --toolbar: #f8fafc; width: 100%; padding: 32px 16px; box-sizing: border-box; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}[data-style="dark"] { --t: #e5e7eb; --m: #94a3b8; --bd: rgba(255,255,255,.1); --bg: #1e293b; --toolbar: #0f172a; }

    #{{ $uid }} .rjpdf-card { max-width: 1000px; margin: 0 auto; background: var(--bg); border: 1px solid var(--bd); border-radius: 14px; overflow: hidden; box-shadow: 0 4px 24px -8px rgba(15,23,42,.12); }
    #{{ $uid }}[data-style="minimal"] .rjpdf-card { border: 0; border-radius: 0; box-shadow: none; background: transparent; }

    /* Header */
    #{{ $uid }} .rjpdf-header { display: flex; align-items: center; gap: 16px; padding: 16px 20px; background: var(--toolbar); border-bottom: 1px solid var(--bd); flex-wrap: wrap; }
    #{{ $uid }} .rjpdf-title-wrap { flex: 1; min-width: 0; display: flex; align-items: center; gap: 12px; }
    #{{ $uid }} .rjpdf-icon { flex: none; width: 36px; height: 36px; border-radius: 8px; background: color-mix(in srgb, var(--acc) 15%, transparent); display: flex; align-items: center; justify-content: center; color: var(--acc); }
    #{{ $uid }} .rjpdf-title { margin: 0; font-size: 1rem; font-weight: 700; color: var(--t); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    #{{ $uid }} .rjpdf-actions { display: flex; gap: 8px; flex: none; }
    #{{ $uid }} .rjpdf-act { all: unset; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 8px; font-size: .85rem; font-weight: 600; color: var(--t); background: color-mix(in srgb, var(--t) 6%, transparent); transition: background .2s; text-decoration: none; }
    #{{ $uid }} .rjpdf-act:hover { background: color-mix(in srgb, var(--acc) 20%, transparent); color: var(--acc); }
    #{{ $uid }} .rjpdf-act svg { width: 14px; height: 14px; }

    /* Toolbar */
    #{{ $uid }} .rjpdf-toolbar { display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: var(--toolbar); border-bottom: 1px solid var(--bd); flex-wrap: wrap; font-size: .85rem; color: var(--t); }
    #{{ $uid }} .rjpdf-tb-btn { all: unset; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; color: var(--t); background: transparent; transition: background .2s; font-weight: 700; }
    #{{ $uid }} .rjpdf-tb-btn:hover:not(:disabled) { background: color-mix(in srgb, var(--acc) 15%, transparent); color: var(--acc); }
    #{{ $uid }} .rjpdf-tb-btn:disabled { opacity: .35; cursor: not-allowed; }
    #{{ $uid }} .rjpdf-tb-btn svg { width: 16px; height: 16px; }
    #{{ $uid }} .rjpdf-info { padding: 0 6px; color: var(--m); font-variant-numeric: tabular-nums; min-width: 80px; text-align: center; }
    #{{ $uid }} .rjpdf-info input { width: 44px; padding: 2px 4px; text-align: center; border: 1px solid var(--bd); border-radius: 4px; background: var(--bg); color: var(--t); font: inherit; font-size: inherit; }
    #{{ $uid }} .rjpdf-info input:focus { outline: none; border-color: var(--acc); }
    #{{ $uid }} .rjpdf-sep { width: 1px; height: 20px; background: var(--bd); margin: 0 4px; }
    #{{ $uid }} .rjpdf-spacer { flex: 1; }
    #{{ $uid }} .rjpdf-zoom { color: var(--m); font-variant-numeric: tabular-nums; min-width: 48px; text-align: center; }

    /* Viewer */
    #{{ $uid }} .rjpdf-viewer { position: relative; width: 100%; height: {{ $viewerHeight }}; background: #525659; overflow: auto; display: flex; justify-content: center; padding: 20px; }
    #{{ $uid }}[data-style="minimal"] .rjpdf-viewer { background: #475569; }
    #{{ $uid }} .rjpdf-canvas-wrap { position: relative; box-shadow: 0 4px 20px rgba(0,0,0,.4); }
    #{{ $uid }} .rjpdf-canvas { display: block; background: #fff; max-width: 100%; height: auto; }
    #{{ $uid }} .rjpdf-status { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 12px; color: #fff; background: rgba(0,0,0,.5); font-size: .95rem; }
    #{{ $uid }} .rjpdf-status[hidden] { display: none; }
    #{{ $uid }} .rjpdf-spinner { width: 32px; height: 32px; border: 3px solid rgba(255,255,255,.2); border-top-color: #fff; border-radius: 50%; animation: rjpdf-spin .8s linear infinite; }
    @keyframes rjpdf-spin { to { transform: rotate(360deg); } }
    #{{ $uid }} .rjpdf-error { color: #fca5a5; text-align: center; padding: 24px; max-width: 360px; }
    #{{ $uid }} .rjpdf-error a { color: #93c5fd; text-decoration: underline; }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 16px 8px; }
        #{{ $uid }} .rjpdf-toolbar { padding: 8px 10px; gap: 4px; }
        #{{ $uid }} .rjpdf-header { padding: 12px 14px; }
        #{{ $uid }} .rjpdf-viewer { padding: 10px; height: {{ $opts['height'] === 'full' ? '70vh' : $viewerHeight }}; }
        #{{ $uid }} .rjpdf-sep { display: none; }
    }
</style>

<section id="{{ $uid }}" data-style="{{ $opts['style'] }}" data-url="{{ $safeUrl }}" data-start="{{ $opts['start_page'] }}">
    <div class="rjpdf-card">

        <div class="rjpdf-header">
            <div class="rjpdf-title-wrap">
                <span class="rjpdf-icon" aria-hidden="true">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </span>
                <h3 class="rjpdf-title" title="{{ $displayTitle }}">{{ $displayTitle }}</h3>
            </div>
            <div class="rjpdf-actions">
                @if ($opts['show_open_new'])
                    <a href="{{ $safeUrl }}" target="_blank" rel="noopener" class="rjpdf-act" title="{{ __('Open in new tab') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>{{ __('Open') }}</span>
                    </a>
                @endif
                @if ($opts['show_download'])
                    <a href="{{ $safeUrl }}" download="{{ $opts['download_name'] }}" class="rjpdf-act" title="{{ __('Download') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                        <span>{{ __('Download') }}</span>
                    </a>
                @endif
            </div>
        </div>

        @if ($opts['show_controls'])
            <div class="rjpdf-toolbar">
                <button type="button" class="rjpdf-tb-btn" data-act="prev" title="{{ __('Previous page') }}" aria-label="{{ __('Previous page') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="rjpdf-info">
                    <input type="text" data-act="page-input" value="{{ $opts['start_page'] }}" aria-label="{{ __('Page number') }}">
                    <span>/ <span data-act="total">–</span></span>
                </div>
                <button type="button" class="rjpdf-tb-btn" data-act="next" title="{{ __('Next page') }}" aria-label="{{ __('Next page') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
                <span class="rjpdf-sep"></span>
                <button type="button" class="rjpdf-tb-btn" data-act="zoom-out" title="{{ __('Zoom out') }}" aria-label="{{ __('Zoom out') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 8v6m-3-3h6"/></svg>
                </button>
                <span class="rjpdf-zoom" data-act="zoom-label">100%</span>
                <button type="button" class="rjpdf-tb-btn" data-act="zoom-in" title="{{ __('Zoom in') }}" aria-label="{{ __('Zoom in') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 8v6m-3-3h6"/></svg>
                </button>
                <span class="rjpdf-sep"></span>
                <button type="button" class="rjpdf-tb-btn" data-act="fit-width" title="{{ __('Fit width') }}" aria-label="{{ __('Fit width') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-16h2a2 2 0 012 2v2m-4 12h2a2 2 0 002-2v-2"/></svg>
                </button>
                <span class="rjpdf-spacer"></span>
                <button type="button" class="rjpdf-tb-btn" data-act="fullscreen" title="{{ __('Fullscreen') }}" aria-label="{{ __('Fullscreen') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                </button>
            </div>
        @endif

        <div class="rjpdf-viewer" data-act="viewer">
            <div class="rjpdf-canvas-wrap">
                <canvas class="rjpdf-canvas" data-act="canvas"></canvas>
            </div>
            <div class="rjpdf-status" data-act="status">
                <div class="rjpdf-spinner"></div>
                <div>{{ __('Loading PDF...') }}</div>
            </div>
        </div>

    </div>
</section>

<script type="module">
(function () {
    const root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    const url = root.dataset.url;
    const startPage = Math.max(1, parseInt(root.dataset.start || '1', 10));

    const canvas = root.querySelector('[data-act="canvas"]');
    const status = root.querySelector('[data-act="status"]');
    const viewer = root.querySelector('[data-act="viewer"]');
    const pageInput = root.querySelector('[data-act="page-input"]');
    const totalEl = root.querySelector('[data-act="total"]');
    const zoomLabel = root.querySelector('[data-act="zoom-label"]');

    let pdfDoc = null;
    let pageNum = startPage;
    let scale = 1.2;
    let rendering = false;
    let pending = null;

    function setStatus(html) {
        if (!status) return;
        if (html === null) { status.hidden = true; return; }
        status.hidden = false;
        status.innerHTML = html;
    }

    function updateToolbar() {
        if (pageInput) pageInput.value = pageNum;
        if (totalEl && pdfDoc) totalEl.textContent = pdfDoc.numPages;
        if (zoomLabel) zoomLabel.textContent = Math.round((scale / 1.2) * 100) + '%';
    }

    async function renderPage(num) {
        if (!pdfDoc) return;
        if (rendering) { pending = num; return; }
        rendering = true;
        try {
            const page = await pdfDoc.getPage(num);
            const containerWidth = viewer.clientWidth - 40;
            const viewport0 = page.getViewport({ scale: 1 });
            let fitScale = scale;
            if (viewport0.width * fitScale > containerWidth) {
                fitScale = containerWidth / viewport0.width;
            }
            const viewport = page.getViewport({ scale: fitScale });
            const dpr = window.devicePixelRatio || 1;

            canvas.width = Math.floor(viewport.width * dpr);
            canvas.height = Math.floor(viewport.height * dpr);
            canvas.style.width = Math.floor(viewport.width) + 'px';
            canvas.style.height = Math.floor(viewport.height) + 'px';

            const ctx = canvas.getContext('2d');
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

            await page.render({ canvasContext: ctx, viewport }).promise;
            updateToolbar();
        } catch (err) {
            console.error(err);
        } finally {
            rendering = false;
            if (pending !== null) {
                const next = pending;
                pending = null;
                renderPage(next);
            }
        }
    }

    function loadPdfJs() {
        return import('https://cdn.jsdelivr.net/npm/pdfjs-dist@4/build/pdf.min.mjs').then(function (mod) {
            mod.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4/build/pdf.worker.min.mjs';
            return mod;
        });
    }

    loadPdfJs().then(function (pdfjsLib) {
        return pdfjsLib.getDocument({ url: url, withCredentials: false }).promise;
    }).then(function (doc) {
        pdfDoc = doc;
        if (pageNum > doc.numPages) pageNum = 1;
        setStatus(null);
        return renderPage(pageNum);
    }).catch(function (err) {
        console.error('PDF load error', err);
        setStatus(
            '<div class="rjpdf-error">' +
            '<p>{{ __('Unable to load the PDF.') }}</p>' +
            '<p><a href="' + url + '" target="_blank" rel="noopener">{{ __('Open PDF directly') }}</a></p>' +
            '</div>'
        );
    });

    function bind(act, fn) {
        const el = root.querySelector('[data-act="' + act + '"]');
        if (el) el.addEventListener('click', fn);
    }

    bind('prev', function () {
        if (pageNum <= 1) return;
        pageNum--;
        renderPage(pageNum);
    });
    bind('next', function () {
        if (!pdfDoc || pageNum >= pdfDoc.numPages) return;
        pageNum++;
        renderPage(pageNum);
    });
    bind('zoom-in', function () {
        scale = Math.min(scale * 1.25, 4);
        renderPage(pageNum);
    });
    bind('zoom-out', function () {
        scale = Math.max(scale / 1.25, 0.4);
        renderPage(pageNum);
    });
    bind('fit-width', function () {
        scale = 1.2;
        renderPage(pageNum);
    });
    bind('fullscreen', function () {
        if (!document.fullscreenElement) {
            viewer.requestFullscreen && viewer.requestFullscreen();
        } else {
            document.exitFullscreen && document.exitFullscreen();
        }
    });

    if (pageInput) {
        pageInput.addEventListener('change', function () {
            const n = parseInt(pageInput.value, 10);
            if (pdfDoc && n >= 1 && n <= pdfDoc.numPages) {
                pageNum = n;
                renderPage(pageNum);
            } else {
                pageInput.value = pageNum;
            }
        });
        pageInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') pageInput.blur();
        });
    }

    // Keyboard nav
    document.addEventListener('keydown', function (e) {
        if (!root.contains(document.activeElement) && !viewer.contains(document.activeElement)) return;
        if (e.key === 'ArrowRight') { bind('next'); }
        if (e.key === 'ArrowLeft') { bind('prev'); }
    }, { passive: true });

    // Re-render on resize
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () { if (pdfDoc) renderPage(pageNum); }, 200);
    });
})();
</script>