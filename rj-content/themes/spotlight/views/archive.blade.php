@extends('theme::layout')

@push('styles')
    <style>
        .rj-archive-hero {
            position: relative;
            padding: 140px 24px 100px;
            text-align: center;
            background: #0a0a0f;
            overflow: hidden;
            border-bottom: 1px solid var(--rj-border);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .rj-archive-hero.rj-h-sm { min-height: 300px; }
        .rj-archive-hero.rj-h-md { min-height: 400px; }
        .rj-archive-hero.rj-h-lg { min-height: 500px; }

        .rj-archive-hero-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 0.9;
        }
        .rj-archive-hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            mix-blend-mode: color;
            pointer-events: none;
        }
        .rj-archive-hero-dim {
            position: absolute;
            inset: 0;
            background: #000;
            z-index: 1;
            pointer-events: none;
        }
        .rj-archive-hero-inner {
            max-width: 720px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .rj-archive-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 20px;
            backdrop-filter: blur(8px);
        }
        .rj-archive-label-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--rj-primary);
            box-shadow: 0 0 10px var(--rj-primary);
        }
        .rj-archive-title {
            font-size: clamp(32px, 4.5vw, 56px);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0 0 16px;
            color: #fff;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }
        .rj-archive-desc {
            font-size: 16px;
            line-height: 1.65;
            color: rgba(255,255,255,0.85);
            margin: 0 auto;
            max-width: 560px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        .rj-archive-count {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 20px;
            padding: 6px 14px;
            border-radius: var(--rj-radius-sm);
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            backdrop-filter: blur(8px);
        }

        .rj-archive-body {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 64px 24px 96px;
        }

        .rj-archive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 28px;
        }
        .rj-archive-grid[data-cols="1"] { grid-template-columns: 1fr; }
        .rj-archive-grid[data-cols="2"] { grid-template-columns: repeat(2, 1fr); }
        .rj-archive-grid[data-cols="3"] { grid-template-columns: repeat(3, 1fr); }

        .rj-archive-empty {
            max-width: 560px;
            margin: 0 auto;
            padding: 80px 24px;
            text-align: center;
        }
        .rj-archive-empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            color: var(--rj-muted);
            margin-bottom: 24px;
        }
        .rj-archive-empty h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px;
            color: var(--rj-text);
        }
        .rj-archive-empty p {
            font-size: 15px;
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 0 28px;
        }
        .rj-archive-empty a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: var(--rj-radius);
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            color: var(--rj-bg);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
        }
        .rj-archive-empty a:hover {
            color: var(--rj-bg);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px -8px color-mix(in srgb, var(--rj-primary) 55%, transparent);
        }

        .rj-archive-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 64px;
            padding-top: 40px;
            border-top: 1px solid var(--rj-border);
            flex-wrap: wrap;
        }
        .rj-archive-pagination a,
        .rj-archive-pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border-radius: var(--rj-radius-sm);
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            color: var(--rj-text);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all .15s;
        }
        .rj-archive-pagination a:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 60%, var(--rj-border));
            color: var(--rj-primary);
            background: color-mix(in srgb, var(--rj-primary) 8%, var(--rj-surface));
        }
        .rj-archive-pagination .rj-current {
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            border-color: transparent;
            color: var(--rj-bg);
            font-weight: 700;
        }
        .rj-archive-pagination .rj-disabled {
            opacity: .4;
            cursor: default;
        }

        @media (max-width: 968px) {
            .rj-archive-grid[data-cols="3"],
            .rj-archive-grid[data-cols="2"] { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .rj-archive-hero { padding: 100px 20px 60px; }
            .rj-archive-body { padding: 40px 20px 64px; }
            .rj-archive-grid,
            .rj-archive-grid[data-cols="3"],
            .rj-archive-grid[data-cols="2"],
            .rj-archive-grid[data-cols="1"] { grid-template-columns: 1fr; gap: 20px; }
            .rj-archive-pagination { margin-top: 48px; }
            .rj-archive-pagination a,
            .rj-archive-pagination span { min-width: 36px; height: 36px; font-size: 13px; }
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();

    // Customizer dəyərlərini oxuyuruq
    $showExcerpt = filter_var(rj_theme_mod('show_excerpt', true, 'blog_list'), FILTER_VALIDATE_BOOLEAN);
    $gridColumns = rj_theme_mod('columns', '3', 'blog_list');

    // Banner Ayarları
    $bannerVideo = rj_theme_mod('banner_video_url', '', 'blog_list');
    $bannerImage = rj_theme_mod('banner_image_url', '', 'blog_list');
    $bannerOverlay = rj_theme_mod('banner_overlay_color', '#1d4ed8', 'blog_list');
    $bannerOpacity = (int) rj_theme_mod('banner_overlay_opacity', 60, 'blog_list') / 100;
    $bannerHeight = rj_theme_mod('banner_height', 'md', 'blog_list');
@endphp

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">

    {{-- YENİ VİDEO BANNER HİSSƏSİ --}}
    <section class="rj-archive-hero rj-h-{{ $bannerHeight }}">

        @if($bannerVideo)
            <video class="rj-archive-hero-video" autoplay loop muted playsinline>
                <source src="{{ $bannerVideo }}" type="video/mp4">
            </video>
        @elseif($bannerImage)
            <img class="rj-archive-hero-video" src="{{ $bannerImage }}" alt="Banner Background">
        @endif

        <div class="rj-archive-hero-overlay" style="background-color: {{ $bannerOverlay }};"></div>
        <div class="rj-archive-hero-dim" style="opacity: {{ $bannerOpacity }};"></div>

        <div class="rj-archive-hero-inner">
            <span class="rj-archive-label">
                <span class="rj-archive-label-dot"></span>
                {{ $archiveLabel ?? __('Archive') }}
            </span>

            <h1 class="rj-archive-title">{{ $archiveTitle ?? __('Blog') }}</h1>

            @if(!empty($archiveDescription))
                <p class="rj-archive-desc">{{ $archiveDescription }}</p>
            @endif

            @if(isset($posts) && method_exists($posts, 'total') && $posts->total() > 0)
                <div class="rj-archive-count">
                    {{ $posts->total() }} {{ $posts->total() === 1 ? __('post') : __('posts') }}
                </div>
            @endif
        </div>
    </section>

    <div class="rj-archive-body">

        @if($posts && $posts->isNotEmpty())
            <div class="rj-archive-grid" data-cols="{{ $gridColumns }}">
                @foreach($posts as $post)
                    @include('theme::partials.loop-card', ['post' => $post, 'showExcerpt' => $showExcerpt])
                @endforeach
            </div>

            @if(method_exists($posts, 'hasPages') && $posts->hasPages())
                <nav class="rj-archive-pagination">
                    @if($posts->onFirstPage())
                        <span class="rj-disabled">←</span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" rel="prev">←</a>
                    @endif

                    @foreach($posts->getUrlRange(max(1, $posts->currentPage() - 2), min($posts->lastPage(), $posts->currentPage() + 2)) as $page => $url)
                        @if($page == $posts->currentPage())
                            <span class="rj-current">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" rel="next">→</a>
                    @else
                        <span class="rj-disabled">→</span>
                    @endif
                </nav>
            @endif
        @else
            <div class="rj-archive-empty">
                <div class="rj-archive-empty-icon">
                    <svg style="width:28px;height:28px;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h2>{{ __('Nothing here yet') }}</h2>
                <p>{{ __('No posts found in this archive. Try browsing the full blog or checking back later.') }}</p>
                <a href="{{ route('frontend.posts.index', ['locale' => $locale]) }}">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    {{ __('Browse all posts') }}
                </a>
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
