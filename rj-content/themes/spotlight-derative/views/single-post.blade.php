@extends('theme::layout')

@push('styles')
    <style>
        .rj-frontend-main {
            position: relative;
            isolation: isolate;
        }

        /* === Arxa Fon Videosu (Archive ilə eyni) === */
        .rj-bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }
        .rj-bg-video-inner {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .rj-bg-video-inner video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            filter: grayscale(0.6) brightness(0.8) blur(2px);
        }
        .rj-bg-video-tint {
            position: absolute;
            inset: 0;
            background: #1d4ed8;
            mix-blend-mode: color;
            opacity: 0.6;
        }
        .rj-bg-video-fade {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(10, 10, 15, 0.2) 0%,
                transparent 40%,
                var(--rj-bg) 95%
            );
            z-index: 2;
        }

        /* === Əsas Konteyner === */
        .rj-single-container {
            --q-accent: #2f6bff;
            --q-line: rgba(255, 255, 255, .16);
            --q-card: linear-gradient(145deg, rgba(255, 255, 255, .12), rgba(255, 255, 255, .04));
            --q-blur: blur(28px) saturate(150%);

            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 64px 24px 96px;
        }

        /* === Başlıq və Meta (Yuxarıda, kartdan kənar) === */
        .rj-single-header {
            text-align: center;
            margin-bottom: 48px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        .rj-single-breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 24px;
        }
        .rj-single-breadcrumb a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.2s;
        }
        .rj-single-breadcrumb a:hover { color: #fff; }
        .rj-single-breadcrumb-sep { opacity: 0.5; }

        .rj-single-title {
            font-size: clamp(32px, 5vw, 56px);
            line-height: 1.1;
            font-weight: 500;
            letter-spacing: -0.03em;
            margin: 0 0 24px;
            color: #fff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .rj-single-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 24px;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.8);
        }
        .rj-single-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .rj-single-meta-item svg {
            width: 18px;
            height: 18px;
            opacity: 0.7;
        }
        .rj-single-meta-cat {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .rj-single-meta-cat:hover {
            background: rgba(47, 107, 255, 0.3);
            border-color: #2f6bff;
        }

        /* === Grid Sistemi (Məzmun və Sidebar) === */
        .rj-single-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 32px;
            align-items: start;
        }

        /* === Sol Tərəf: Yazı Kartı === */
        .rj-single-card {
            background: var(--q-card);
            border: 1px solid var(--q-line);
            border-radius: 32px;
            padding: 48px;
            backdrop-filter: var(--q-blur);
            -webkit-backdrop-filter: var(--q-blur);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 20px 50px rgba(0, 0, 0, .35);
            overflow: hidden;
        }
        .rj-single-card.is-wide { padding: 48px; }
        .rj-single-card.is-full { padding: 48px; }

        .rj-single-hero {
            margin: 0 -48px 48px;
            border-radius: 0;
            overflow: hidden;
        }
        .rj-single-hero img {
            width: 100%;
            height: auto;
            display: block;
            max-height: 560px;
            object-fit: cover;
        }

        .rj-single-excerpt {
            font-size: 19px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin: 0 0 40px;
            padding-left: 20px;
            border-left: 3px solid var(--q-accent);
            font-style: italic;
        }

        /* Məzmunun daxili stilləri (Dark glass üçün) */
        .rj-single-content {
            font-size: 17px;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.85);
        }
        .rj-single-content > * { margin: 0 0 24px; }
        .rj-single-content > *:last-child { margin-bottom: 0; }
        .rj-single-content h2 { font-size: 28px; line-height: 1.25; margin: 48px 0 20px; letter-spacing: -.02em; color: #fff; }
        .rj-single-content h3 { font-size: 22px; line-height: 1.3; margin: 36px 0 16px; letter-spacing: -.015em; color: #fff; }
        .rj-single-content h4 { font-size: 18px; line-height: 1.4; margin: 28px 0 12px; color: #fff; }
        .rj-single-content p { color: rgba(255, 255, 255, 0.85); }
        .rj-single-content a {
            color: #60a5fa;
            text-decoration: underline;
            text-decoration-color: rgba(96, 165, 250, 0.4);
            text-underline-offset: 3px;
            transition: text-decoration-color .15s;
        }
        .rj-single-content a:hover { text-decoration-color: #60a5fa; color: #93c5fd; }
        .rj-single-content ul, .rj-single-content ol { padding-left: 28px; margin: 0 0 24px; }
        .rj-single-content li { margin: 0 0 8px; }
        .rj-single-content blockquote {
            margin: 32px 0; padding: 24px; background: rgba(0,0,0,0.3);
            border-left: 3px solid var(--q-accent); border-radius: 0 16px 16px 0;
            color: rgba(255,255,255,0.9); font-style: italic; font-size: 18px;
        }
        .rj-single-content blockquote p:last-child { margin-bottom: 0; }
        .rj-single-content code {
            padding: 2px 8px; background: rgba(0,0,0,0.4); border: 1px solid var(--q-line);
            border-radius: 6px; font-size: .9em; color: #60a5fa; font-family: ui-monospace, 'SF Mono', Menlo, monospace;
        }
        .rj-single-content pre {
            padding: 20px; background: rgba(0,0,0,0.4); border: 1px solid var(--q-line);
            border-radius: 16px; overflow-x: auto; margin: 0 0 24px;
        }
        .rj-single-content pre code { padding: 0; background: none; border: 0; color: #fff; }
        .rj-single-content img { border-radius: 16px; margin: 8px 0; }
        .rj-single-content hr { border: 0; border-top: 1px solid var(--q-line); margin: 48px 0; }

        /* Teqlər və Naviqasiya */
        .rj-single-tags {
            display: flex; flex-wrap: wrap; gap: 10px; margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--q-line);
        }
        .rj-single-tag {
            display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 999px;
            background: rgba(255,255,255,0.06); border: 1px solid var(--q-line); color: #fff;
            font-size: 14px; text-decoration: none; transition: all .15s;
        }
        .rj-single-tag:hover { border-color: var(--q-accent); background: rgba(47, 107, 255, 0.12); }

        .rj-single-nav {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--q-line);
        }
        .rj-single-nav-item {
            display: flex; flex-direction: column; gap: 8px; padding: 24px; background: rgba(0,0,0,0.2);
            border: 1px solid var(--q-line); border-radius: 20px; text-decoration: none; transition: all .18s;
        }
        .rj-single-nav-item:hover { border-color: var(--q-accent); background: rgba(47, 107, 255, 0.08); }
        .rj-single-nav-item.rj-next { text-align: right; }
        .rj-single-nav-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,0.6); }
        .rj-single-nav-title { font-size: 16px; font-weight: 500; color: #fff; line-height: 1.4; }

        /* === Sağ Tərəf: Sidebar (Archive ilə eyni) === */
        .rj-sidebar {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .rj-widget {
            background: var(--q-card);
            border: 1px solid var(--q-line);
            border-radius: 32px;
            padding: 40px 40px 44px;
            backdrop-filter: var(--q-blur);
            -webkit-backdrop-filter: var(--q-blur);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 20px 50px rgba(0, 0, 0, .35);
        }

        .rj-widget-title {
            position: relative;
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            margin: 0 0 32px;
            padding-bottom: 32px;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }
        .rj-widget-title::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 1px;
            background: rgba(255, 255, 255, .22);
        }
        .rj-widget-title::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 3px;
            z-index: 1;
            background:
                radial-gradient(circle, #fff 1.5px, transparent 2px) left center / 3px 3px no-repeat,
                radial-gradient(circle, #fff 1.5px, transparent 2px) right center / 3px 3px no-repeat;
        }

        .rj-search-form { position: relative; display: flex; }
        .rj-search-input {
            width: 100%; padding: 16px 50px 16px 24px; background: rgba(0, 0, 0, .25);
            border: 1px solid var(--q-line); border-radius: 18px; color: #fff; font-size: 15px; outline: none;
        }
        .rj-search-input:focus { border-color: var(--q-accent); }
        .rj-search-btn {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--q-accent); cursor: pointer; padding: 8px; display: flex;
        }

        .rj-cat-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; }
        .rj-cat-list a {
            display: flex; justify-content: space-between; align-items: center; padding: 16px 20px;
            background: rgba(255, 255, 255, .05); border: 1px solid var(--q-line); border-radius: 16px;
            color: #fff; text-decoration: none; font-size: 16px; font-weight: 500; transition: all .2s;
        }
        .rj-cat-list a:hover { border-color: var(--q-accent); background: rgba(47, 107, 255, .08); }
        .rj-cat-arrow { width: 20px; height: 20px; flex-shrink: 0; color: var(--q-accent); }

        .rj-recent-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 20px; }
        .rj-recent-item { display: flex; gap: 16px; align-items: center; }
        .rj-recent-thumb { width: 80px; height: 80px; border-radius: 16px; background: rgba(255, 255, 255, .04); object-fit: cover; flex-shrink: 0; }
        .rj-recent-info { display: flex; flex-direction: column; gap: 6px; min-width: 0; }
        .rj-recent-date { display: flex; align-items: center; gap: 6px; font-size: 12px; color: rgba(255, 255, 255, .6); }
        .rj-recent-date svg { width: 14px; height: 14px; }
        .rj-recent-title {
            font-size: 15px; font-weight: 500; color: #fff; text-decoration: none; line-height: 1.3;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s;
        }
        .rj-recent-title:hover { color: var(--q-accent); }

        @media (max-width: 1200px) {
            .rj-single-grid { grid-template-columns: 1fr 340px; }
            .rj-single-card { padding: 32px; }
            .rj-single-hero { margin: 0 -32px 32px; }
            .rj-widget { padding: 32px 28px; }
        }
        @media (max-width: 968px) {
            .rj-single-grid { grid-template-columns: 1fr; }
            .rj-single-header { margin-bottom: 32px; }
        }
        @media (max-width: 640px) {
            .rj-single-container { padding: 40px 20px 64px; }
            .rj-single-card { padding: 24px; border-radius: 24px; }
            .rj-single-hero { margin: 0 -24px 24px; }
            .rj-single-content { font-size: 16px; }
            .rj-single-content h2 { font-size: 24px; margin-top: 32px; }
            .rj-single-content h3 { font-size: 20px; margin-top: 24px; }
            .rj-single-nav { grid-template-columns: 1fr; }
            .rj-single-nav-item.rj-next { text-align: left; }
            .rj-widget-title { font-size: 24px; }
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();
    $blogUrl = route('frontend.posts.index', ['locale' => $locale]);

    // Customizer dəyərləri
    $showImage = filter_var(rj_theme_mod('show_featured_image', true, 'blog_single'), FILTER_VALIDATE_BOOLEAN);
    $showRelated = filter_var(rj_theme_mod('show_related_posts', true, 'blog_single'), FILTER_VALIDATE_BOOLEAN);

    // Banner Video (Archive ilə eyni)
    $defaultBgVideo = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    $bgVideo = trim((string) rj_theme_mod('background_video', '', 'blog_list'));
    if ($bgVideo === '') {
        $bgVideo = $defaultBgVideo;
    }

    // Sidebar məlumatları
    try {
        $sidebarCategories = \App\Models\Category::take(10)->get();
        $sidebarRecent = \App\Models\Post::where('type', 'post')->where('status', 'published')->where('id', '!=', $post->id)->orderByDesc('published_at')->take(5)->get();
        $sidebarTags = \App\Models\Tag::take(15)->get();
    } catch (\Throwable $e) {
        $sidebarCategories = collect();
        $sidebarRecent = collect();
        $sidebarTags = collect();
    }

    $catUrl = function ($cat) use ($locale) {
        $slug = $cat->slug ?? '';
        if ($slug === '') return $blogUrl;
        return route('frontend.posts.index', ['locale' => $locale, 'term' => $slug, 'taxonomy' => 'category']);
    };

    $tagUrl = function ($tag) use ($locale) {
        $slug = $tag->slug ?? '';
        if ($slug === '') return $blogUrl;
        return route('frontend.posts.index', ['locale' => $locale, 'term' => $slug, 'taxonomy' => 'tag']);
    };

    $prevUrl = isset($previousPost) && $previousPost ? ($previousPost->public_url ?? null) : null;
    $nextUrl = isset($nextPost) && $nextPost ? ($nextPost->public_url ?? null) : null;
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

    <div class="rj-single-container">

        {{-- Başlıq və Meta --}}
        <header class="rj-single-header">
            <nav class="rj-single-breadcrumb">
                <a href="{{ url('/' . $locale) }}">{{ __('Home') }}</a>
                <span class="rj-single-breadcrumb-sep">/</span>
                <a href="{{ $blogUrl }}">{{ __('Blog') }}</a>
                <span class="rj-single-breadcrumb-sep">/</span>
                <span>{{ \Illuminate\Support\Str::limit($post->title ?? '', 40) }}</span>
            </nav>

            <h1 class="rj-single-title">{{ $post->title ?? '' }}</h1>

            <div class="rj-single-meta">
                <div class="rj-single-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg>
                    <span>{{ optional($post->author)->name ?? __('Unknown') }}</span>
                </div>

                @if($post->published_at)
                    <div class="rj-single-meta-item">
                        <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
                        <time datetime="{{ $post->published_at->toIso8601String() }}">
                            {{ $post->published_at->format('M d, Y') }}
                        </time>
                    </div>
                @endif

                @if($post->categories && $post->categories->isNotEmpty())
                    <a href="{{ $catUrl($post->categories->first()) }}" class="rj-single-meta-cat">
                        {{ $post->categories->first()->name }}
                    </a>
                @endif
            </div>
        </header>

        {{-- Grid: Məzmun və Sidebar --}}
        <div class="rj-single-grid">

            {{-- Sol Tərəf: Yazı Kartı --}}
            <article class="rj-single-card">

                @if($showImage && $post->featured_image)
                    <figure class="rj-single-hero">
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title ?? '' }}">
                    </figure>
                @endif

                @if($post->excerpt)
                    <div class="rj-single-excerpt">{{ $post->excerpt }}</div>
                @endif

                <div class="rj-single-content">
                    @if($post->isBuilderMode() && $post->hasBlocks())
                        {!! rj_render_blocks($post->blocks['blocks'] ?? []) !!}
                    @else
                        {!! $post->content ?? '' !!}
                    @endif
                </div>

                @if($post->tags && $post->tags->isNotEmpty())
                    <div class="rj-single-tags">
                        @foreach($post->tags as $tag)
                            <a href="{{ $tagUrl($tag) }}" class="rj-single-tag">
                                #{{ $tag->name ?? '' }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($prevUrl || $nextUrl)
                    <nav class="rj-single-nav">
                        @if($prevUrl)
                            <a href="{{ $prevUrl }}" class="rj-single-nav-item rj-prev">
                                <span class="rj-single-nav-label">← {{ __('Previous') }}</span>
                                <span class="rj-single-nav-title">{{ $previousPost->title ?? '' }}</span>
                            </a>
                        @else
                            <span></span>
                        @endif

                        @if($nextUrl)
                            <a href="{{ $nextUrl }}" class="rj-single-nav-item rj-next">
                                <span class="rj-single-nav-label">{{ __('Next') }} →</span>
                                <span class="rj-single-nav-title">{{ $nextPost->title ?? '' }}</span>
                            </a>
                        @endif
                    </nav>
                @endif
            </article>

            {{-- Sağ Tərəf: Sidebar --}}
            <aside class="rj-sidebar">

                {{-- Axtarış --}}
                <div class="rj-widget">
                    <h3 class="rj-widget-title">{{ __('Search') }}</h3>
                    <form method="GET" action="{{ $blogUrl }}" class="rj-search-form">
                        <input type="text" name="s" class="rj-search-input" placeholder="{{ __('Search posts...') }}" value="{{ request('s') }}">
                        <button type="submit" class="rj-search-btn" aria-label="{{ __('Search') }}">
                            <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                {{-- Kateqoriyalar --}}
                @if($sidebarCategories->isNotEmpty())
                    <div class="rj-widget">
                        <h3 class="rj-widget-title">{{ __('Categories') }}</h3>
                        <ul class="rj-cat-list">
                            @foreach($sidebarCategories as $cat)
                                <li>
                                    <a href="{{ $catUrl($cat) }}">
                                        <span>{{ $cat->name }}</span>
                                        <svg class="rj-cat-arrow" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M9 7h8v8"/></svg>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Son Yazılar --}}
                @if($sidebarRecent->isNotEmpty())
                    <div class="rj-widget">
                        <h3 class="rj-widget-title">{{ __('Recent posts') }}</h3>
                        <ul class="rj-recent-list">
                            @foreach($sidebarRecent as $rPost)
                                <li class="rj-recent-item">
                                    @if($rPost->featured_image)
                                        <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="rj-recent-thumb">
                                    @else
                                        <div class="rj-recent-thumb" style="display:flex;align-items:center;justify-content:center;"><svg style="width:20px;height:20px;color:rgba(255,255,255,.5);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                    @endif
                                    <div class="rj-recent-info">
                                        @if($rPost->published_at)
                                            <span class="rj-recent-date">
                                                <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
                                                {{ $rPost->published_at->format('M d, Y') }}
                                            </span>
                                        @endif
                                        <a href="{{ $rPost->public_url }}" class="rj-recent-title">{{ $rPost->title }}</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </aside>
        </div>

        {{-- Əlaqəli Yazılar (Kartın altında) --}}
        @if($showRelated && isset($related) && $related->isNotEmpty())
            <div style="margin-top: 64px;">
                <h3 style="font-size: 28px; font-weight: 500; margin-bottom: 32px; color: #fff; text-align: center;">{{ __('Related Posts') }}</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                    @foreach($related as $rPost)
                        @include('theme::partials.loop-card', ['post' => $rPost, 'showExcerpt' => false])
                    @endforeach
                </div>
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
