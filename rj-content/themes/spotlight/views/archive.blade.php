@extends('theme::layout')

@push('styles')
    <style>
        .rj-archive-wrapper {
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 64px 24px 96px;
            display: grid;
            grid-template-columns: 300px 1fr; /* Sol tərəf sidebar, sağ tərəf postlar */
            gap: 48px;
            align-items: start;
        }

        /* === SIDEBAR === */
        .rj-sidebar {
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .rj-widget {
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
            padding: 24px;
        }

        .rj-widget-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--rj-text);
            margin: 0 0 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--rj-border);
            letter-spacing: -0.02em;
        }

        /* Axtarış */
        .rj-search-form {
            position: relative;
            display: flex;
        }
        .rj-search-input {
            width: 100%;
            padding: 12px 40px 12px 16px;
            background: var(--rj-bg);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-sm);
            color: var(--rj-text);
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .rj-search-input:focus {
            border-color: var(--rj-primary);
        }
        .rj-search-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--rj-muted);
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }
        .rj-search-btn:hover {
            color: var(--rj-primary);
        }

        /* Kateqoriyalar və Linklər */
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
            color: var(--rj-muted);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }
        .rj-cat-list a:hover {
            color: var(--rj-primary);
        }
        .rj-cat-count {
            font-size: 12px;
            background: var(--rj-bg);
            padding: 2px 8px;
            border-radius: 999px;
            border: 1px solid var(--rj-border);
        }

        /* Son Yazılar */
        .rj-recent-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .rj-recent-item {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .rj-recent-thumb {
            width: 60px;
            height: 60px;
            border-radius: var(--rj-radius-sm);
            background: var(--rj-bg);
            object-fit: cover;
            flex-shrink: 0;
        }
        .rj-recent-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .rj-recent-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--rj-text);
            text-decoration: none;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s;
        }
        .rj-recent-title:hover {
            color: var(--rj-primary);
        }
        .rj-recent-date {
            font-size: 11px;
            color: var(--rj-muted);
        }

        /* Teqlər */
        .rj-tag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .rj-tag-cloud a {
            display: inline-flex;
            padding: 6px 12px;
            background: var(--rj-bg);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-sm);
            color: var(--rj-muted);
            font-size: 12px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .rj-tag-cloud a:hover {
            border-color: var(--rj-primary);
            color: var(--rj-primary);
            background: color-mix(in srgb, var(--rj-primary) 8%, var(--rj-bg));
        }

        /* === SAĞ TƏRƏF (POSTLAR) === */
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

        .rj-archive-empty {
            text-align: center;
            padding: 80px 24px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
        }
        .rj-archive-empty h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px;
            color: var(--rj-text);
        }
        .rj-archive-empty p {
            font-size: 15px;
            color: var(--rj-muted);
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

        /* Mobil uyğunluq */
        @media (max-width: 968px) {
            .rj-archive-wrapper {
                grid-template-columns: 1fr; /* Sidebar yuxarı keçir */
            }
            .rj-sidebar {
                position: static;
            }
            .rj-archive-grid[data-cols="3"],
            .rj-archive-grid[data-cols="2"] { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .rj-archive-wrapper { padding: 40px 20px 64px; }
            .rj-archive-grid,
            .rj-archive-grid[data-cols="3"],
            .rj-archive-grid[data-cols="2"],
            .rj-archive-grid[data-cols="1"] { grid-template-columns: 1fr; gap: 20px; }
        }
    </style>
@endpush

@php
    $locale = app()->getLocale();

    // Customizer dəyərlərini oxuyuruq
    $showExcerpt = filter_var(rj_theme_mod('show_excerpt', true, 'blog_list'), FILTER_VALIDATE_BOOLEAN);
    $gridColumns = rj_theme_mod('columns', '2', 'blog_list'); // Grid-i 2 sütuna saldıq ki, sidebar ilə yer olsun

    // Sidebar üçün məlumatları bazadan çəkirik
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
    <div class="rj-archive-wrapper">

        {{-- SOL TƏRƏF: SIDEBAR --}}
        <aside class="rj-sidebar">

            {{-- 1. Axtarış --}}
            <div class="rj-widget">
                <h3 class="rj-widget-title">{{ __('Search') }}</h3>
                <form method="GET" action="{{ $blogUrl }}" class="rj-search-form">
                    <input type="text" name="s" class="rj-search-input" placeholder="{{ __('Search posts...') }}" value="{{ request('s') }}">
                    <button type="submit" class="rj-search-btn">
                        <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>

            {{-- 2. Kateqoriyalar --}}
            @if($sidebarCategories->isNotEmpty())
                <div class="rj-widget">
                    <h3 class="rj-widget-title">{{ __('Categories') }}</h3>
                    <ul class="rj-cat-list">
                        @foreach($sidebarCategories as $cat)
                            <li>
                                <a href="{{ route('frontend.posts.index', ['locale' => $locale, 'term' => $cat->slug, 'taxonomy' => 'category']) }}">
                                    {{ $cat->name }}
                                    <span class="rj-cat-count">{{ $cat->posts()->count() ?? 0 }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 3. Son Yazılar --}}
            @if($sidebarRecent->isNotEmpty())
                <div class="rj-widget">
                    <h3 class="rj-widget-title">{{ __('Recent Posts') }}</h3>
                    <ul class="rj-recent-list">
                        @foreach($sidebarRecent as $rPost)
                            <li class="rj-recent-item">
                                @if($rPost->featured_image)
                                    <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="rj-recent-thumb">
                                @else
                                    <div class="rj-recent-thumb" style="display:flex;align-items:center;justify-content:center;background:var(--rj-surface);"><svg style="width:20px;height:20px;color:var(--rj-muted);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                                @endif
                                <div class="rj-recent-info">
                                    <a href="{{ $rPost->public_url }}" class="rj-recent-title">{{ $rPost->title }}</a>
                                    <span class="rj-recent-date">{{ $rPost->published_at ? $rPost->published_at->format('M d, Y') : '' }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 4. Teqlər --}}
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

        {{-- SAĞ TƏRƏF: POSTLAR --}}
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
                    <a href="{{ $blogUrl }}" style="color:var(--rj-primary);text-decoration:underline;">{{ __('Clear Search') }}</a>
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
