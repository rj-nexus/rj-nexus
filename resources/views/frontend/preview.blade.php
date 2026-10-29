@php
    $previewLocale = request()->query('locale');
    if ($previewLocale && in_array($previewLocale, rj_available_locales(), true)) {
        app()->setLocale($previewLocale);
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ rj_dir() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow, noarchive">
    <title>{{ $title }} · {{ rj_get_option('site_name', config('app.name')) }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        {!! rj_global_color_css() !!}
        {!! rj_breakpoint_css() !!}
        html, body { margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", sans-serif; color: #1f2937; background: #fff; }

        /* Preview üçün üzən düymə */
        .rj-preview-exit { position: fixed; bottom: 20px; right: 20px; padding: 10px 18px; background: #7c3aed; color: #fff; border-radius: 999px; font-size: 13px; font-weight: 600; text-decoration: none; box-shadow: 0 6px 20px rgba(124, 58, 237, .4); z-index: 99999; transition: background .2s; }
        .rj-preview-exit:hover { background: #6d28d9; color: #fff; }
    </style>
    @if(function_exists('rj_do_action')) {!! rj_do_action('frontend_head') !!} @endif
</head>
<body>
    @if($isPage && $header)
        {!! rj_render_template($header) !!}
    @endif

    {!! rj_render_blocks($blocks) !!}

    @if($isPage && $footer)
        {!! rj_render_template($footer) !!}
    @endif

    <a href="javascript:history.back()" class="rj-preview-exit">{{ __('Back to builder') }}</a>

    @if(function_exists('rj_do_action')) {!! rj_do_action('frontend_footer') !!} @endif
</body>
</html>
