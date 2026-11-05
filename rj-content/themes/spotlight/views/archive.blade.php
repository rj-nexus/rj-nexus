@extends('theme::layout')

@push('styles')
    <style>
        .rj-frontend-main {
            position: relative;
            isolation: isolate;
        }

        .rj-bg-video {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .rj-bg-video-inner {
            position: sticky;
            top: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .rj-bg-video-inner video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            /* Yüngül blur və tündlük - video özünü göstərsin deyə */
            filter: grayscale(0.8) brightness(0.7) blur(3px);
            transform: scale(1.05);
        }

        .rj-bg-video-tint {
            position: absolute;
            inset: 0;
            background: #1d4ed8;
            mix-blend-mode: color;
            opacity: 0.85;
        }

        /* Kəskin xətti yox edən və saytın fon rənginə yumşaq keçid edən qradient */
        .rj-bg-video-fade {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(10, 10, 15, 0.3) 0%,
                transparent 30%,
                transparent 60%,
                var(--rj-bg) 100%
            );
            z-index: 2;
        }

        .rj-archive-wrapper {
            --q-accent: #2f6bff;
            --q-line: rgba(255, 255, 255, .16);
            --q-card: linear-gradient(145deg, rgba(255, 255, 255, .12), rgba(255, 255, 255, .04));
            --q-blur: blur(28px) saturate(150%);
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 64px 24px 96px;
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 32px;
            align-items: start;
        }

        .rj-sidebar {
            position: sticky;
            top: 100px;
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
            font-size: 34px;
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

        .rj-search-form {
            position: relative;
            display: flex;
        }
        .rj-search-input {
            width: 100%;
            padding: 18px 56px 18px 24px;
            background: rgba(0, 0, 0, .25);
            border: 1px solid var(--q-line);
            border-radius: 18px;
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: border-color 0.2s;
        }
        .rj-search-input::placeholder {
            color: rgba(255, 255, 255, .5);
        }
        .rj-search-input:focus {
            border-color: var(--q-accent);
        }
        .rj-search-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--q-accent);
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rj-cat-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .rj-cat-list a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 22px 26px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid var(--q-line);
            border-radius: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            font-weight: 500;
            letter-spacing: -0.01em;
            transition: border-color .2s, background .2s;
        }
        .rj-cat-list a:hover {
            border-color: var(--q-accent);
            background: rgba(47, 107, 255, .08);
        }
        .rj-cat-arrow {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            color: var(--q-accent);
        }

        .rj-recent-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }
        .rj-recent-item {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .rj-recent-thumb {
            width: 128px;
            height: 128px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .04);
            object-fit: cover;
            flex-shrink: 0;
        }
        .rj-recent-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 0;
        }
        .rj-recent-date {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            color: rgba(255, 255, 255, .8);
        }
        .rj-recent-date svg {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }
        .rj-recent-title {
            font-size: 22px;
            font-weight: 500;
            color: #fff;
            text-decoration: none;
            line-height: 1.3;
            letter-spacing: -0.02em;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s;
        }
        .rj-recent-title:hover {
            color: var(--q-accent);
        }

        .rj-tag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .rj-tag-cloud a {
            display: inline-flex;
            padding: 10px 18px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--q-line);
            border-radius: 999px;
            color: rgba(255, 255, 255, .8);
            font-size: 15px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .rj-tag-cloud a:hover {
            border-color: var(--q-accent);
            color: #fff;
            background: rgba(47, 107, 255, .12);
        }

        .rj-archive-main {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .rj-archive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 28px;
        }
        .rj-archive-grid[data-cols="1"] { grid-template-columns: 1fr; }
        .rj-archive-grid[data-cols="2"] { grid-template-columns: repeat(2, 1fr); }
        .rj-archive-grid[data-cols="3"] { grid-template-columns: repeat(3, 1fr); }
        .rj-archive-grid > * {
            background: var(--q-card) !important;
            border: 1px solid var(--q-line) !important;
            border-radius: 28px !important;
            backdrop-filter: var(--q-blur);
            -webkit-backdrop-filter: var(--q-blur);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 20px 50px rgba(0, 0, 0, .35) !important;
            overflow: hidden;
        }

        .rj-archive-empty {
            text-align: center;
            padding: 80px 24px;
            background: var(--q-card);
            border: 1px solid var(--q-line);
            border-radius: 32px;
            backdrop-filter: var(--q-blur);
            -webkit-backdrop-filter: var(--q-blur);
        }
        .rj-archive-empty h2 {
            font-size: 28px;
            font-weight: 500;
            margin: 0 0 10px;
            color: #fff;
        }
        .rj-archive-empty p {
            font-size: 16px;
            color: rgba(255, 255, 255, .6);
            margin: 0 0 24px;
        }

        .rj-archive-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 32px;
            flex-wrap: wrap;
        }
        .rj-archive-pagination a,
        .rj-archive-pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            height: 48px;
            padding: 0 14px;
            border-radius: 16px;
            background: var(--q-card);
            backdrop-filter: var(--q-blur);
            -webkit-backdrop-filter: var(--q-blur);
            border: 1px solid var(--q-line);
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all .15s;
        }
        .rj-archive-pagination a:hover {
            border-color: var(--q-accent);
            background: rgba(47, 107, 255, .12);
        }
        .rj-archive-pagination .rj-current {
            background: var(--q-accent);
            border-color: transparent;
            color: #fff;
            font-weight: 700;
        }
        .rj-archive-pagination .rj-disabled {
            opacity: .4;
            cursor: default;
        }

        @media (max-width: 1200px) {
            .rj-archive-wrapper {
                grid-template-columns: 360px 1fr;
            }
            .rj-widget {
                padding: 32px 28px 36px;
            }
            .rj-recent-thumb {
                width: 96px;
                height: 96px;
            }
        }
        @media (max-width: 968px) {
            .rj-archive-wrapper {
                grid-template-columns: 1fr;
            }
            .rj-sidebar {
                position: static;
            }
            .rj-archive-grid[data-cols="3"],
            .rj-archive-grid[data-cols="2"] { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .rj-archive-wrapper { padding: 40px 20px 64px; }
            .rj-widget-title { font-size: 28px; }
            .rj-archive-grid,
            .rj-archive-grid[data-cols="3"],
            .rj-archive-grid[data-cols="2"],
            .rj-archive-grid[data-cols="1"] { grid-template-columns: 1fr; gap: 20px; }
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();

    $showExcerpt = filter_var(rj_theme_mod('show_excerpt', true, 'blog_list'), FILTER_VALIDATE_BOOLEAN);
    $gridColumns = rj_theme_mod('columns', '2', 'blog_list');

    $defaultBgVideo = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    $bgVideo = trim((string) rj_theme_mod('background_video', '', 'blog_list'));
    if ($bgVideo === '') {
        $bgVideo = $defaultBgVideo;
    }

    try {
        $sidebarCategories = \App\Models\Category::take(10)->get();
        $sidebarRecent = \App\Models\Post::where('type', 'post')->where('status', 'published')->orderByDesc('published_at')->take(5)->get();
        $sidebarTags = \App\Models\Tag::take(15)->get();
    } catch (\Throwable $e) {
        $sidebarCategories = collect();
        $sidebarRecent = collect();
        $sidebarTags = collect();
    }

    $blogUrl = route('frontend.posts.index', ['locale' => $locale]);
@endphp

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">
    <div class="rj-bg-video" aria-hidden="true">
        <div class="rj-bg-video-inner">
            <video autoplay muted loop playsinline preload="auto" src="{{ $bgVideo }}"></video>
            <div class="rj-bg-video-tint"></div>
            <div class="rj-bg-video-fade"></div>
        </div>
    </div>

    <div class="rj-archive-wrapper">

        <aside class="rj-sidebar">

            <div class="rj-widget">
                <h3 class="rj-widget-title">{{ __('Search') }}</h3>
                <form method="GET" action="{{ $blogUrl }}" class="rj-search-form">
                    <input type="text" name="s" class="rj-search-input" placeholder="{{ __('Search posts...') }}" value="{{ request('s') }}">
                    <button type="submit" class="rj-search-btn" aria-label="{{ __('Search') }}">
                        <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>

            @if($sidebarCategories->isNotEmpty())
                <div class="rj-widget">
                    <h3 class="rj-widget-title">{{ __('Categories') }}</h3>
                    <ul class="rj-cat-list">
                        @foreach($sidebarCategories as $cat)
                            <li>
                                <a href="{{ route('frontend.posts.index', ['locale' => $locale, 'term' => $cat->slug, 'taxonomy' => 'category']) }}">
                                    <span>{{ $cat->name }}</span>
                                    <svg class="rj-cat-arrow" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M9 7h8v8"/></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($sidebarRecent->isNotEmpty())
                <div class="rj-widget">
                    <h3 class="rj-widget-title">{{ __('Recent posts') }}</h3>
                    <ul class="rj-recent-list">
                        @foreach($sidebarRecent as $rPost)
                            <li class="rj-recent-item">
                                @if($rPost->featured_image)
                                    <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="rj-recent-thumb">
                                @else
                                    <div class="rj-recent-thumb" style="display:flex;align-items:center;justify-content:center;"><svg style="width:28px;height:28px;color:rgba(255,255,255,.5);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                @endif
                                <div class="rj-recent-info">
                                    @if($rPost->published_at)
                                        <span class="rj-recent-date">
                                            <svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
                                            {{ $rPost->published_at->format('F j, Y') }}
                                        </span>
                                    @endif
                                    <a href="{{ $rPost->public_url }}" class="rj-recent-title">{{ $rPost->title }}</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($sidebarTags->isNotEmpty())
                <div class="rj-widget">
                    <h3 class="rj-widget-title">{{ __('Tags') }}</h3>
                    <div class="rj-tag-cloud">
                        @foreach($sidebarTags as $tag)
                            <a href="{{ route('frontend.posts.index', ['locale' => $locale, 'term' => $tag->slug, 'taxonomy' => 'tag']) }}">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </aside>

        <div class="rj-archive-main">
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
                    <h2>{{ __('Nothing here yet') }}</h2>
                    <p>{{ __('No posts found. Try searching for something else.') }}</p>
                    <a href="{{ $blogUrl }}" style="color:#2f6bff;text-decoration:underline;">{{ __('Clear Search') }}</a>
                </div>
            @endif
        </div>

    </div>
</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
