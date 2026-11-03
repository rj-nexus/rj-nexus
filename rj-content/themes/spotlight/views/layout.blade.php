@php
    $activeHeaderTemplate = app(\App\Services\ThemeResolver::class)->header();
    if ($activeHeaderTemplate) {
        $isSticky = ($activeHeaderTemplate->settings['sticky_header'] ?? '1') === '1';
    } else {
        $isSticky = rj_get_option('header_sticky', '1') === '1';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ rj_dir() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0a0a0f">

    <title>{{ $title ?? rj_get_option('site_name', config('app.name')) }}</title>

    @if(rj_get_option('site_favicon'))
        <link rel="icon" href="{{ rj_get_option('site_favicon') }}">
    @endif

    <style>{!! rj_global_color_css() !!}</style>

    @include('rjbuilder.partials.styles')

    <link rel="stylesheet" href="{{ route('frontend.fonts.css') }}">

    <style>
        :root {
            --rj-primary: #a78bfa;
            --rj-secondary: #f472b6;
            --rj-accent: #22d3ee;
            --rj-text: #e5e7eb;
            --rj-muted: #94a3b8;
            --rj-bg: #0a0a0f;
            --rj-surface: #14141c;
            --rj-border: #262632;
            --rj-link: #a78bfa;
            --rj-header-bg: #0a0a0f;
            --rj-header-text: #f1f5f9;
            --rj-footer-bg: #050508;
            --rj-footer-text: #94a3b8;
            --rj-container: 1200px;
            --rj-font-body: 'Inter', system-ui, -apple-system, sans-serif;
            --rj-font-heading: 'Inter', system-ui, -apple-system, sans-serif;
            --rj-font-size: 16px;
            --rj-line-height: 1.65;
            --rj-radius: 12px;
            --rj-radius-sm: 8px;
            --rj-radius-lg: 20px;
            color-scheme: dark;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body {
            overflow-x: clip;
            max-width: 100%;
            margin: 0;
            padding: 0;
            background: var(--rj-bg);
            color: var(--rj-text);
        }
        body {
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
        ::selection { background: var(--rj-primary); color: #0a0a0f; }

        .rj-frontend {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: clip;
            width: 100%;
            max-width: 100%;
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
            color: #0a0a0f;
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
    <div class="rj-frontend rj-frontend-wrapper">
        @yield('content')
    </div>

    @include('theme::partials.popup')

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
