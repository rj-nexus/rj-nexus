@php
    $previewLocale = request()->query('locale');
    if ($previewLocale && in_array($previewLocale, rj_available_locales(), true)) {
        app()->setLocale($previewLocale);
    }

    $activeTheme = \App\Models\Theme::active();
    $themeAssets = $activeTheme ? ($activeTheme->metadata()['assets'] ?? []) : [];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ rj_dir() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>{{ $title }} · {{ rj_get_option('site_name', config('app.name')) }}</title>

    <style>{!! rj_global_color_css() !!}</style>

    @include('rjbuilder.partials.styles')

    <link rel="stylesheet" href="{{ route('frontend.fonts.css') }}">

    @if($activeTheme)
        @foreach(($themeAssets['css'] ?? []) as $css)
            <link rel="stylesheet" href="{{ $activeTheme->assetUrl($css) }}">
        @endforeach
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body { overflow-x: clip; max-width: 100%; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background: #fff; color: #111827; }

        .rj-frontend-wrapper { container-type: inline-size; container-name: rj; width: 100%; }

        .rj-preview-exit { position: fixed; bottom: 20px; right: 20px; padding: 10px 18px; background: #7c3aed; color: #fff; border-radius: 999px; font-size: 13px; font-weight: 600; text-decoration: none; box-shadow: 0 6px 20px rgba(124, 58, 237, .4); z-index: 99999; transition: background .2s; }
        .rj-preview-exit:hover { background: #6d28d9; color: #fff; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="rj-frontend rj-frontend-wrapper">
        @if($isPage && $header)
            <header class="rj-frontend-header">
                {!! rj_render_template($header) !!}
            </header>
        @endif

        <main class="rj-frontend-main">
            {!! rj_render_blocks($blocks) !!}
        </main>

        @if($isPage && $footer)
            <footer class="rj-frontend-footer">
                {!! rj_render_template($footer) !!}
            </footer>
        @endif
    </div>

    <a href="javascript:history.back()" class="rj-preview-exit">{{ __('Back to builder') }}</a>

    @if($activeTheme)
        @foreach(($themeAssets['js'] ?? []) as $js)
            <script src="{{ $activeTheme->assetUrl($js) }}" defer></script>
        @endforeach
    @endif

    @stack('scripts')
</body>
</html>
