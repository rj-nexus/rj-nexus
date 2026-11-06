@extends('theme::layout')

@push('styles')
    <style>
        .rj-frontend-main {
            position: relative;
            isolation: isolate;
            min-height: 100vh;
        }

        /* === Arxa Fon Videosu === */
        .rj-bg-video {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100vh;
            z-index: 0; pointer-events: none;
        }
        .rj-bg-video-inner {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            overflow: hidden;
        }
        .rj-bg-video-inner video {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; object-position: center center;
            filter: grayscale(0.6) brightness(0.8) blur(2px);
        }
        .rj-bg-video-tint {
            position: absolute; inset: 0;
            background: #1d4ed8; mix-blend-mode: color; opacity: 0.6;
        }
        .rj-bg-video-fade {
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, rgba(10, 10, 15, 0.2) 0%, transparent 40%, var(--rj-bg) 95%);
            z-index: 2;
        }

        /* Builder məzmunu üçün minimal konteyner (yalnız klasik redaktor üçün) */
        .rj-classic-content {
            position: relative; z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 100px 24px;
            color: var(--rj-text);
            font-size: 17px;
            line-height: 1.75;
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();

    // Arxa plan videosu (Customizer-dən oxunur)
    $defaultBgVideo = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    $bgVideo = trim((string) rj_theme_mod('background_video', '', 'single_page'));
    if ($bgVideo === '') {
        $bgVideo = $defaultBgVideo;
    }
@endphp

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">

    {{-- Arxa Fon Video (Hər səhifədə görünür) --}}
    <div class="rj-bg-video" aria-hidden="true">
        <div class="rj-bg-video-inner">
            <video autoplay muted loop playsinline preload="auto" src="{{ $bgVideo }}"></video>
            <div class="rj-bg-video-tint"></div>
            <div class="rj-bg-video-fade"></div>
        </div>
    </div>

    {{-- Səhifə Məzmunu (Tamamilə Builder-dən asılıdır) --}}
    @if($page)
        @if($page->isBuilderMode() && $page->hasBlocks())
            {{-- Builder blokları birbaşa render olunur --}}
            <div style="position: relative; z-index: 1;">
                {!! rj_render_blocks($page->blocks['blocks'] ?? []) !!}
            </div>
        @elseif(!empty($page->content))
            {{-- Klasik redaktor üçün --}}
            <div class="rj-classic-content">
                {!! strip_tags($page->content, '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><img><blockquote><pre><code><span><div><table><thead><tbody><tr><th><td>') !!}
            </div>
        @endif
    @endif

</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection