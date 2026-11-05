@extends('theme::layout')

@push('styles')
    <style>
        .rj-frontend-main {
            position: relative;
            isolation: isolate;
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

        /* === Əsas Konteyner === */
        .rj-page-container {
            --q-accent: #2f6bff;
            --q-line: rgba(255, 255, 255, .16);
            --q-card: linear-gradient(145deg, rgba(255, 255, 255, .12), rgba(255, 255, 255, .04));
            --q-blur: blur(28px) saturate(150%);
            position: relative; z-index: 1;
            margin: 0 auto;
            padding: 80px 24px 96px;
            max-width: 1000px;
        }
        .rj-page-container.is-wide { max-width: 1200px; }
        .rj-page-container.is-full { max-width: 100%; padding-left: 0; padding-right: 0; }

        /* === Başlıq === */
        .rj-page-header {
            text-align: center;
            margin-bottom: 48px;
        }
        .rj-page-title {
            font-size: clamp(32px, 5vw, 56px);
            line-height: 1.1;
            font-weight: 500;
            letter-spacing: -0.03em;
            margin: 0;
            color: #fff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        /* === Səhifə Kartı === */
        .rj-page-card {
            background: var(--q-card);
            border: 1px solid var(--q-line);
            border-radius: 32px;
            padding: 48px;
            backdrop-filter: var(--q-blur);
            -webkit-backdrop-filter: var(--q-blur);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 20px 50px rgba(0, 0, 0, .35);
            overflow: hidden;
        }

        .rj-page-hero {
            margin: 0 -48px 48px;
            border-radius: 0;
            overflow: hidden;
        }
        .rj-page-hero img {
            width: 100%; height: auto; display: block; max-height: 500px; object-fit: cover;
        }

        /* Məzmunun daxili stilləri */
        .rj-page-content {
            font-size: 17px; line-height: 1.75; color: rgba(255, 255, 255, 0.85);
        }
        .rj-page-content > * { margin: 0 0 24px; }
        .rj-page-content > *:last-child { margin-bottom: 0; }
        .rj-page-content h2 { font-size: 28px; line-height: 1.25; margin: 48px 0 20px; letter-spacing: -.02em; color: #fff; }
        .rj-page-content h3 { font-size: 22px; line-height: 1.3; margin: 36px 0 16px; letter-spacing: -.015em; color: #fff; }
        .rj-page-content h4 { font-size: 18px; line-height: 1.4; margin: 28px 0 12px; color: #fff; }
        .rj-page-content p { color: rgba(255, 255, 255, 0.85); }
        .rj-page-content a {
            color: #60a5fa; text-decoration: underline; text-decoration-color: rgba(96, 165, 250, 0.4);
            text-underline-offset: 3px; transition: text-decoration-color .15s;
        }
        .rj-page-content a:hover { text-decoration-color: #60a5fa; color: #93c5fd; }
        .rj-page-content ul, .rj-page-content ol { padding-left: 28px; margin: 0 0 24px; }
        .rj-page-content li { margin: 0 0 8px; }
        .rj-page-content blockquote {
            margin: 32px 0; padding: 24px; background: rgba(0,0,0,0.3);
            border-left: 3px solid var(--q-accent); border-radius: 0 16px 16px 0;
            color: rgba(255,255,255,0.9); font-style: italic; font-size: 18px;
        }
        .rj-page-content blockquote p:last-child { margin-bottom: 0; }
        .rj-page-content code {
            padding: 2px 8px; background: rgba(0,0,0,0.4); border: 1px solid var(--q-line);
            border-radius: 6px; font-size: .9em; color: #60a5fa; font-family: ui-monospace, 'SF Mono', Menlo, monospace;
        }
        .rj-page-content pre {
            padding: 20px; background: rgba(0,0,0,0.4); border: 1px solid var(--q-line);
            border-radius: 16px; overflow-x: auto; margin: 0 0 24px;
        }
        .rj-page-content pre code { padding: 0; background: none; border: 0; color: #fff; }
        .rj-page-content img { border-radius: 16px; margin: 8px 0; }
        .rj-page-content hr { border: 0; border-top: 1px solid var(--q-line); margin: 48px 0; }

        @media (max-width: 768px) {
            .rj-page-container { padding: 40px 20px 64px; }
            .rj-page-card { padding: 32px 24px; border-radius: 24px; }
            .rj-page-hero { margin: 0 -24px 32px; }
            .rj-page-content { font-size: 16px; }
            .rj-page-content h2 { font-size: 24px; margin-top: 32px; }
            .rj-page-content h3 { font-size: 20px; margin-top: 24px; }
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();

    // Customizer dəyərləri
    $showImage = filter_var(rj_theme_mod('show_featured_image', true, 'single_page'), FILTER_VALIDATE_BOOLEAN);
    $contentWidth = rj_theme_mod('content_width', 'normal', 'single_page');

    // Arxa plan videosu
    $defaultBgVideo = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    $bgVideo = trim((string) rj_theme_mod('background_video', '', 'single_page'));
    if ($bgVideo === '') {
        $bgVideo = $defaultBgVideo;
    }

    $containerClass = 'rj-page-container';
    if ($contentWidth === 'wide') $containerClass .= ' is-wide';
    if ($contentWidth === 'full') $containerClass .= ' is-full';

    // Yoxlayırıq ki, səhifədə göstəriləsi nəsə var?
    $hasImage = $showImage && !empty($page->featured_image);
    $hasBlocks = $page && $page->isBuilderMode() && $page->hasBlocks();
    $hasContent = $page && !empty($page->content);
    $hasAnything = $hasImage || $hasBlocks || $hasContent;
@endphp

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">

    {{-- Arxa Fon Video --}}
    <div class="rj-bg-video" aria-hidden="true">
        <div class="rj-bg-video-inner">
            <video autoplay muted loop playsinline preload="auto" src="{{ $bgVideo }}"></video>
            <div class="rj-bg-video-tint"></div>
            <div class="rj-bg-video-fade"></div>
        </div>
    </div>

    <div class="{{ $containerClass }}">

        @if($page)
            <header class="rj-page-header">
                <h1 class="rj-page-title">{{ $page->title ?? '' }}</h1>
            </header>

            {{-- Yalnız məzmun varsa kartı göstəririk --}}
            @if($hasAnything)
                <article class="rj-page-card">

                    @if($hasImage)
                        <figure class="rj-page-hero">
                            <img src="{{ $page->featured_image }}" alt="{{ $page->title ?? '' }}">
                        </figure>
                    @endif

                    @if($hasBlocks || $hasContent)
                        <div class="rj-page-content">
                            @if($hasBlocks)
                                {!! rj_render_blocks($page->blocks['blocks'] ?? []) !!}
                            @else
                                {!! $page->content !!}
                            @endif
                        </div>
                    @endif
                </article>
            @endif

        @else
            <div style="text-align: center; padding: 100px 20px; background: var(--q-card); border-radius: 32px; border: 1px solid var(--q-line);">
                <h2 style="color: #fff; margin-bottom: 10px;">{{ __('Page not found') }}</h2>
                <p style="color: rgba(255,255,255,0.6);">{{ __('The page you are looking for does not exist or has been moved.') }}</p>
            </div>
        @endif

    </div>
</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
