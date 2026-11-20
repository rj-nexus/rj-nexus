<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('RJBuilder')) - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    
    @php
        $themeBg = function_exists('rj_theme_mod') ? (rj_theme_mod('background_color') ?: '#ffffff') : '#ffffff';
        $themeText = function_exists('rj_theme_mod') ? (rj_theme_mod('text_color') ?: '#111827') : '#111827';
        $themeSurface = function_exists('rj_theme_mod') ? (rj_theme_mod('surface_color') ?: '#f3f4f6') : '#f3f4f6';
        $themeBorder = function_exists('rj_theme_mod') ? (rj_theme_mod('border_color') ?: '#e5e7eb') : '#e5e7eb';
        $themePrimary = function_exists('rj_theme_mod') ? (rj_theme_mod('primary_color') ?: '#8b5cf6') : '#8b5cf6';
        $themeSecondary = function_exists('rj_theme_mod') ? (rj_theme_mod('secondary_color') ?: '#ec4899') : '#ec4899';
        $themeMuted = function_exists('rj_theme_mod') ? (rj_theme_mod('muted_color') ?: '#6b7280') : '#6b7280';
    @endphp

    <style>
        :root { 
            {!! rj_css_variables() !!} 
            --rj-bg: {{ $themeBg }};
            --rj-text: {{ $themeText }};
            --rj-surface: {{ $themeSurface }};
            --rj-border: {{ $themeBorder }};
            --rj-primary: {{ $themePrimary }};
            --rj-secondary: {{ $themeSecondary }};
            --rj-muted: {{ $themeMuted }};
        }
        html, body { height: 100%; overflow: hidden; margin: 0; }
        [x-cloak] { display: none !important; }
        .rj-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .rj-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .rj-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 3px; }
        .rj-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.25); }
        
        /* Builder-in xarici fonunu tünd temalarda tünd boz edirik */
        @if(in_array(strtolower($themeBg), ['#0a0a0f', '#000000', '#111827', '#1f2937', '#111', '#05050a']))
            .rj-main { background-color: #1a1a24 !important; }
            .rj-devlabel { color: #9ca3af !important; }
        @else
            .rj-main { background-color: #e5e7eb !important; }
        @endif
    </style>
</head>
<body class="font-sans antialiased h-screen overflow-hidden" style="background-color: var(--rj-bg); color: var(--rj-text);">
    @yield('content')
</body>
</html>