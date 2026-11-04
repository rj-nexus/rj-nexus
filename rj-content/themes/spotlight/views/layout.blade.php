@php
    $activeHeaderTemplate = app(\App\Services\ThemeResolver::class)->header();

    if ($activeHeaderTemplate) {
        $isSticky = ($activeHeaderTemplate->settings['sticky_header'] ?? '1') === '1';
    } else {
        $themeSticky = rj_theme_mod('sticky_header', null, 'layout');
        $isSticky = $themeSticky !== null ? (bool) $themeSticky : (rj_get_option('header_sticky', '1') === '1');
    }

    $sanitizeColor = function ($value, $default) {
        $value = is_string($value) ? trim($value) : '';
        return preg_match('/^#[0-9a-fA-F]{3,8}$/', $value) ? $value : $default;
    };

    $cPrimary = $sanitizeColor(rj_theme_mod('primary_color', null, 'colors'), '#a78bfa');
    $cSecondary = $sanitizeColor(rj_theme_mod('secondary_color', null, 'colors'), '#f472b6');
    $cAccent = $sanitizeColor(rj_theme_mod('accent_color', null, 'colors'), '#22d3ee');
    $cText = $sanitizeColor(rj_theme_mod('text_color', null, 'colors'), '#e5e7eb');
    $cMuted = $sanitizeColor(rj_theme_mod('muted_color', null, 'colors'), '#94a3b8');
    $cBg = $sanitizeColor(rj_theme_mod('background_color', null, 'colors'), '#0a0a0f');
    $cSurface = $sanitizeColor(rj_theme_mod('surface_color', null, 'colors'), '#14141c');
    $cBorder = $sanitizeColor(rj_theme_mod('border_color', null, 'colors'), '#262632');
    $cLink = $sanitizeColor(rj_theme_mod('link_color', null, 'colors'), '#a78bfa');
    $cHeaderBg = $sanitizeColor(rj_theme_mod('header_bg', null, 'header'), '#0a0a0f');
    $cHeaderText = $sanitizeColor(rj_theme_mod('header_text_color', null, 'header'), '#f1f5f9');
    $cFooterBg = $sanitizeColor(rj_theme_mod('footer_bg', null, 'footer'), '#050508');
    $cFooterText = $sanitizeColor(rj_theme_mod('footer_text_color', null, 'footer'), '#94a3b8');

    $allowedFonts = ['Inter', 'Figtree', 'Roboto', 'Open Sans', 'Lato', 'Poppins', 'system-ui'];

    $fontBody = rj_theme_mod('font_body', 'Inter', 'typography');
    if (!in_array($fontBody, $allowedFonts, true)) $fontBody = 'Inter';

    $fontHeading = rj_theme_mod('font_heading', 'Inter', 'typography');
    if (!in_array($fontHeading, $allowedFonts, true)) $fontHeading = 'Inter';

    $fontSizeBase = (int) rj_theme_mod('font_size_base', 16, 'typography');
    $fontSizeBase = max(12, min(24, $fontSizeBase));

    $lineHeight = (float) rj_theme_mod('line_height', 1.65, 'typography');
    $lineHeight = max(1.2, min(2.2, $lineHeight));

    $containerWidth = (int) rj_theme_mod('container_width', 1200, 'layout');
    $containerWidth = max(960, min(1600, $containerWidth));

    $fontBodyFamily = $fontBody === 'system-ui'
        ? 'system-ui, -apple-system, sans-serif'
        : "'{$fontBody}', system-ui, -apple-system, sans-serif";

    $fontHeadingFamily = $fontHeading === 'system-ui'
        ? 'system-ui, -apple-system, sans-serif'
        : "'{$fontHeading}', system-ui, -apple-system, sans-serif";

    $googleFamilies = [];
    foreach ([$fontBody, $fontHeading] as $f) {
        if ($f !== 'system-ui' && !in_array($f, $googleFamilies, true)) {
            $googleFamilies[] = $f;
        }
    }

    $googleFontsUrl = '';
    if (!empty($googleFamilies)) {
        $families = array_map(fn($f) => 'family=' . urlencode($f) . ':wght@400;500;600;700;800', $googleFamilies);
        $googleFontsUrl = 'https://fonts.googleapis.com/css2?' . implode('&', $families) . '&display=swap';
    }

    $showStars = in_array(strtolower($cBg), ['#0a0a0f', '#000', '#000000', '#050508']);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ rj_dir() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="{{ $cBg }}">

    <title>{{ $title ?? rj_get_option('site_name', config('app.name')) }}</title>

    @if(rj_get_option('site_favicon'))
        <link rel="icon" href="{{ rj_get_option('site_favicon') }}">
    @endif

    <style>{!! rj_global_color_css() !!}</style>

    @include('rjbuilder.partials.styles')

    <link rel="stylesheet" href="{{ route('frontend.fonts.css') }}">

    @if($googleFontsUrl)
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="{{ $googleFontsUrl }}">
    @endif

    <style>
        :root {
            --rj-primary: {{ $cPrimary }};
            --rj-secondary: {{ $cSecondary }};
            --rj-accent: {{ $cAccent }};
            --rj-text: {{ $cText }};
            --rj-muted: {{ $cMuted }};
            --rj-bg: {{ $cBg }};
            --rj-surface: {{ $cSurface }};
            --rj-border: {{ $cBorder }};
            --rj-link: {{ $cLink }};
            --rj-header-bg: {{ $cHeaderBg }};
            --rj-header-text: {{ $cHeaderText }};
            --rj-footer-bg: {{ $cFooterBg }};
            --rj-footer-text: {{ $cFooterText }};
            --rj-container: {{ $containerWidth }}px;
            --rj-font-body: {{ $fontBodyFamily }};
            --rj-font-heading: {{ $fontHeadingFamily }};
            --rj-font-size: {{ $fontSizeBase }}px;
            --rj-line-height: {{ $lineHeight }};
            --rj-radius: 12px;
            --rj-radius-sm: 8px;
            --rj-radius-lg: 20px;
            color-scheme: dark;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html {
            overflow-x: clip;
            max-width: 100%;
            margin: 0;
            padding: 0;
            background: var(--rj-bg);
            color: var(--rj-text);
        }
        body {
            overflow-x: clip;
            max-width: 100%;
            margin: 0;
            padding: 0;
            background: transparent;
            color: var(--rj-text);
            font-family: var(--rj-font-body);
            font-size: var(--rj-font-size);
            line-height: var(--rj-line-height);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--rj-font-heading);
            color: var(--rj-text);
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        a { color: var(--rj-link); text-decoration: none; }
        a:hover { color: var(--rj-secondary); }
        ::selection { background: var(--rj-primary); color: var(--rj-bg); }

        .rj-frontend {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: clip;
            width: 100%;
            max-width: 100%;
            position: relative;
            z-index: 1;
        }
        .rj-frontend > main {
            flex: 1;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
        .rj-frontend-wrapper {
            container-type: inline-size;
            container-name: rj;
            width: 100%;
        }

        .rj-frontend-header,
        .rj-frontend-footer {
            width: 100%;
            max-width: 100%;
        }

        .rj-frontend-header {
            background: var(--rj-header-bg);
            color: var(--rj-header-text);
            width: 100%;
            position: relative;
            z-index: 40;
            border-bottom: 1px solid var(--rj-border);
        }

        body.has-sticky-header .rj-frontend-header {
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
            background: color-mix(in srgb, var(--rj-header-bg) 88%, transparent);
        }

        .rj-frontend-footer {
            overflow-x: hidden;
            background: var(--rj-footer-bg);
            color: var(--rj-footer-text);
            border-top: 1px solid var(--rj-border);
        }

        .rj-frontend-header > *,
        .rj-frontend-footer > *,
        .rj-frontend-main > * {
            max-width: 100%;
            box-sizing: border-box;
        }

        .rj-frontend img,
        .rj-frontend video,
        .rj-frontend iframe {
            max-width: 100%;
            height: auto;
        }

        .rj-container {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 0 24px;
        }

        .rj-form-wrap { width: 100%; }
        .rj-form { display: flex; flex-direction: column; gap: 16px; margin: 0; }
        .rj-form-stack .rj-form-field { width: 100%; }
        .rj-form-inline { flex-direction: row; flex-wrap: wrap; align-items: flex-end; }
        .rj-form-inline .rj-form-field { flex: 1 1 200px; }
        .rj-form-inline .rj-form-actions { flex: 0 0 auto; }
        .rj-form-grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .rj-form-grid-2 .rj-form-field-full,
        .rj-form-grid-2 .rj-form-field-textarea,
        .rj-form-grid-2 .rj-form-actions { grid-column: 1 / -1; }

        .rj-form-field { display: flex; flex-direction: column; gap: 6px; }
        .rj-form-labels-inline .rj-form-field { flex-direction: row; align-items: center; gap: 12px; }
        .rj-form-labels-inline .rj-form-label { flex: 0 0 140px; margin: 0; }
        .rj-form-labels-inline .rj-form-input,
        .rj-form-labels-inline textarea,
        .rj-form-labels-inline select { flex: 1; }

        .rj-form-label { font-size: 13px; font-weight: 600; color: var(--rj-text); line-height: 1.4; }
        .rj-form-req { color: #ef4444; margin-left: 3px; }

        .rj-form-input,
        .rj-form textarea,
        .rj-form select {
            width: 100%;
            padding: 11px 14px;
            font-size: 14px;
            font-family: inherit;
            color: var(--rj-text);
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-sm);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .rj-form-input:focus,
        .rj-form textarea:focus,
        .rj-form select:focus {
            border-color: var(--rj-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--rj-primary) 25%, transparent);
        }
        .rj-form textarea { resize: vertical; min-height: 100px; line-height: 1.5; }
        .rj-form select { cursor: pointer; }

        .rj-form-help { font-size: 11px; color: var(--rj-muted); line-height: 1.4; }

        .rj-form-radio-group,
        .rj-form-checkbox-group { display: flex; flex-direction: column; gap: 8px; }
        .rj-form-radio,
        .rj-form-checkbox {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--rj-text);
            cursor: pointer;
            user-select: none;
        }
        .rj-form-radio input,
        .rj-form-checkbox input { accent-color: var(--rj-primary); cursor: pointer; }

        .rj-form-actions { display: flex; gap: 8px; }

        .rj-form-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            color: var(--rj-bg);
            background: var(--rj-primary);
            border: 0;
            border-radius: var(--rj-radius-sm);
            cursor: pointer;
            transition: opacity .15s, transform .12s;
            font-family: inherit;
        }
        .rj-form-submit:hover { opacity: .9; }
        .rj-form-submit:active { transform: scale(.98); }
        .rj-form-submit:disabled { opacity: .6; cursor: default; }

        .rj-form-message {
            padding: 12px 16px;
            border-radius: var(--rj-radius-sm);
            font-size: 13px;
            line-height: 1.5;
        }
        .rj-form-message.rj-ok {
            background: rgba(16, 185, 129, .1);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, .3);
        }
        .rj-form-message.rj-err {
            background: rgba(239, 68, 68, .1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, .3);
        }

        .rj-form-input.rj-invalid,
        .rj-form textarea.rj-invalid,
        .rj-form select.rj-invalid { border-color: #ef4444; }

        @media (max-width: 640px) {
            .rj-container { padding: 0 20px; }
            .rj-form-grid-2 { grid-template-columns: 1fr; }
            .rj-form-inline { flex-direction: column; align-items: stretch; }
        }

        /* === Starfield Background === */
        .rj-starfield {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        .rj-starfield::before,
        .rj-starfield::after {
            content: '';
            position: absolute;
            inset: 0;
            background-repeat: repeat;
        }
        .rj-starfield::before {
            background-image:
                radial-gradient(1px 1px at 20px 30px, rgba(255,255,255,.7), transparent),
                radial-gradient(1px 1px at 50px 80px, rgba(255,255,255,.5), transparent),
                radial-gradient(1.5px 1.5px at 90px 40px, rgba(255,255,255,.6), transparent),
                radial-gradient(1px 1px at 130px 100px, rgba(255,255,255,.8), transparent);
            background-size: 150px 150px;
            animation: rjStarsMoveUp 120s linear infinite;
        }
        .rj-starfield::after {
            background-image:
                radial-gradient(2px 2px at 30px 50px, rgba(255,255,255,.4), transparent),
                radial-gradient(1.5px 1.5px at 80px 120px, rgba(255,255,255,.5), transparent),
                radial-gradient(1px 1px at 140px 70px, rgba(255,255,255,.6), transparent);
            background-size: 200px 200px;
            animation: rjStarsMoveUpSlow 180s linear infinite;
        }
        @keyframes rjStarsMoveUp {
            0% { background-position: 0 0; }
            100% { background-position: 0 -1500px; }
        }
        @keyframes rjStarsMoveUpSlow {
            0% { background-position: 0 0; }
            100% { background-position: 0 -2000px; }
        }
    </style>

    @php $activeTheme = \App\Models\Theme::active(); @endphp
    @if($activeTheme)
        @php $themeAssets = $activeTheme->metadata()['assets'] ?? []; @endphp
        @foreach(($themeAssets['css'] ?? []) as $css)
            <link rel="stylesheet" href="{{ $activeTheme->assetUrl($css) }}">
        @endforeach
    @endif

    @stack('styles')
</head>
<body class="{{ $isSticky ? 'has-sticky-header' : '' }}">

    @if($showStars)
        <div class="rj-starfield" aria-hidden="true"></div>
    @endif

    <div class="rj-frontend rj-frontend-wrapper">
        @yield('content')
    </div>

    @if(view()->exists('theme::partials.popup'))
        @include('theme::partials.popup')
    @endif

    <button id="rj-back-to-top" class="rj-btt" aria-label="{{ __('Back to top') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
    </button>

    <style>
        .rj-btt {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        .rj-btt.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .rj-btt:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
            color: var(--rj-primary);
        }
        .rj-btt svg {
            width: 22px;
            height: 22px;
            transition: transform 0.2s;
        }
        .rj-btt:hover svg {
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .rj-btt {
                bottom: 20px;
                right: 20px;
                width: 46px;
                height: 46px;
            }
            .rj-btt svg {
                width: 18px;
                height: 18px;
            }
        }
    </style>

    <script>
    (function() {
        var btt = document.getElementById('rj-back-to-top');
        if (!btt) return;

        window.addEventListener('scroll', function() {
            if (window.scrollY > 400) {
                btt.classList.add('show');
            } else {
                btt.classList.remove('show');
            }
        }, { passive: true });

        btt.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    })();
    </script>

    <script>
    (function () {
        const ready = (fn) => {
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn);
            else fn();
        };

        ready(() => {
            document.querySelectorAll('.rj-form').forEach(form => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const submitBtn = form.querySelector('.rj-form-submit');
                    const messageEl = form.querySelector('.rj-form-message');
                    form.querySelectorAll('.rj-invalid').forEach(el => el.classList.remove('rj-invalid'));
                    const originalLabel = submitBtn ? submitBtn.textContent : '';
                    if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = '...'; }
                    if (messageEl) { messageEl.style.display = 'none'; messageEl.className = 'rj-form-message'; }
                    try {
                        const fd = new FormData(form);
                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                            body: fd,
                        });
                        const data = await res.json().catch(() => ({}));
                        if (res.ok && data.success) {
                            form.reset();
                            if (messageEl) {
                                messageEl.className = 'rj-form-message rj-ok';
                                messageEl.textContent = data.message || 'OK';
                                messageEl.style.display = 'block';
                            }
                            if (data.redirect) setTimeout(() => { window.location.href = data.redirect; }, 800);
                            form.dispatchEvent(new CustomEvent('rj-form-success', { detail: data }));
                        } else {
                            const errors = data.errors || {};
                            let firstInvalid = null;
                            Object.keys(errors).forEach(name => {
                                const input = form.querySelector('[name="' + name + '"], [name="' + name + '[]"]');
                                if (input) {
                                    input.classList.add('rj-invalid');
                                    if (!firstInvalid) firstInvalid = input;
                                }
                            });
                            if (messageEl) {
                                messageEl.className = 'rj-form-message rj-err';
                                messageEl.textContent = data.message || 'Please check the form.';
                                messageEl.style.display = 'block';
                            }
                            if (firstInvalid) firstInvalid.focus();
                            form.dispatchEvent(new CustomEvent('rj-form-error', { detail: data }));
                        }
                    } catch (err) {
                        if (messageEl) {
                            messageEl.className = 'rj-form-message rj-err';
                            messageEl.textContent = 'Network error. Please try again.';
                            messageEl.style.display = 'block';
                        }
                    } finally {
                        if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalLabel; }
                    }
                });
            });
        });
    })();
    </script>

    <script>
    (function() {
        var placeholderUrl = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/placeholder/fallback-image/rj-nexus-no-image.webp';

        function applyPlaceholder(img) {
            if (img.dataset.placeholderApplied) return;
            img.dataset.placeholderApplied = 'true';
            img.src = placeholderUrl;
            img.style.background = '#14141c';
            img.style.objectFit = 'contain';
            img.style.padding = '2rem';
            img.style.opacity = '0.4';
            img.style.filter = 'grayscale(100%)';
        }

        function checkImages(container) {
            container.querySelectorAll('img').forEach(function(img) {
                if (!img.src || img.src.includes('undefined') || img.src === window.location.href || img.src === '') applyPlaceholder(img);
                img.addEventListener('error', function() { applyPlaceholder(this); });
            });
        }

        document.addEventListener('DOMContentLoaded', function() { checkImages(document); });

        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) {
                            if (node.tagName === 'IMG') {
                                if (!node.src || node.src === '') applyPlaceholder(node);
                                node.addEventListener('error', function() { applyPlaceholder(this); });
                            } else {
                                checkImages(node);
                            }
                        }
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            observer.observe(document.body, { childList: true, subtree: true });
        });
    })();
    </script>

    @if($activeTheme)
        @php $themeAssets = $activeTheme->metadata()['assets'] ?? []; @endphp
        @foreach(($themeAssets['js'] ?? []) as $js)
            <script src="{{ $activeTheme->assetUrl($js) }}" defer></script>
        @endforeach
    @endif

    @stack('scripts')
</body>
</html>
