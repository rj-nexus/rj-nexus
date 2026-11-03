@extends('theme::layout')

@push('styles')
    <style>
        .rj-single-wrap {
            max-width: 800px;
            margin: 0 auto;
            padding: 64px 24px 96px;
        }
        .rj-single-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--rj-muted);
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        .rj-single-breadcrumb a {
            color: var(--rj-muted);
            text-decoration: none;
            transition: color .15s;
        }
        .rj-single-breadcrumb a:hover { color: var(--rj-primary); }
        .rj-single-breadcrumb-sep { opacity: .5; }

        .rj-single-cats {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }
        .rj-single-cat {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--rj-primary) 14%, transparent);
            border: 1px solid color-mix(in srgb, var(--rj-primary) 35%, transparent);
            color: var(--rj-primary);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            text-decoration: none;
            transition: background .15s;
        }
        .rj-single-cat:hover {
            background: color-mix(in srgb, var(--rj-primary) 22%, transparent);
            color: var(--rj-primary);
        }

        .rj-single-title {
            font-size: clamp(32px, 4.5vw, 52px);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0 0 24px;
            color: var(--rj-text);
        }

        .rj-single-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 32px;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--rj-border);
            font-size: 14px;
            color: var(--rj-muted);
        }
        .rj-single-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .rj-single-meta-item svg {
            width: 15px;
            height: 15px;
            opacity: .7;
        }
        .rj-single-author {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--rj-text);
        }
        .rj-single-author-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #0a0a0f;
            font-size: 13px;
            font-weight: 800;
        }

        .rj-single-hero {
            margin: 0 -24px 48px;
            border-radius: 0;
            overflow: hidden;
            position: relative;
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
            line-height: 1.65;
            color: var(--rj-muted);
            margin: 0 0 40px;
            padding-left: 20px;
            border-left: 3px solid var(--rj-primary);
            font-style: italic;
        }

        .rj-single-content {
            font-size: 17px;
            line-height: 1.75;
            color: var(--rj-text);
        }
        .rj-single-content > * { margin: 0 0 24px; }
        .rj-single-content > *:last-child { margin-bottom: 0; }
        .rj-single-content h2 {
            font-size: 28px;
            line-height: 1.25;
            margin: 48px 0 20px;
            letter-spacing: -.02em;
        }
        .rj-single-content h3 {
            font-size: 22px;
            line-height: 1.3;
            margin: 36px 0 16px;
            letter-spacing: -.015em;
        }
        .rj-single-content h4 {
            font-size: 18px;
            line-height: 1.4;
            margin: 28px 0 12px;
        }
        .rj-single-content p { color: var(--rj-text); }
        .rj-single-content a {
            color: var(--rj-link);
            text-decoration: underline;
            text-decoration-color: color-mix(in srgb, var(--rj-link) 40%, transparent);
            text-underline-offset: 3px;
            transition: text-decoration-color .15s;
        }
        .rj-single-content a:hover {
            text-decoration-color: var(--rj-link);
            color: var(--rj-secondary);
        }
        .rj-single-content ul,
        .rj-single-content ol {
            padding-left: 28px;
            margin: 0 0 24px;
        }
        .rj-single-content li { margin: 0 0 8px; }
        .rj-single-content blockquote {
            margin: 32px 0;
            padding: 20px 24px;
            background: var(--rj-surface);
            border-left: 3px solid var(--rj-primary);
            border-radius: 0 var(--rj-radius-sm) var(--rj-radius-sm) 0;
            color: var(--rj-muted);
            font-style: italic;
            font-size: 18px;
        }
        .rj-single-content blockquote p:last-child { margin-bottom: 0; }
        .rj-single-content code {
            padding: 2px 8px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: 6px;
            font-size: .9em;
            color: var(--rj-accent);
            font-family: ui-monospace, 'SF Mono', Menlo, monospace;
        }
        .rj-single-content pre {
            padding: 20px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius);
            overflow-x: auto;
            margin: 0 0 24px;
        }
        .rj-single-content pre code {
            padding: 0;
            background: none;
            border: 0;
            color: var(--rj-text);
        }
        .rj-single-content img {
            border-radius: var(--rj-radius);
            margin: 8px 0;
        }
        .rj-single-content hr {
            border: 0;
            border-top: 1px solid var(--rj-border);
            margin: 48px 0;
        }
        .rj-single-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 24px;
            font-size: 15px;
        }
        .rj-single-content th,
        .rj-single-content td {
            padding: 12px 16px;
            border: 1px solid var(--rj-border);
            text-align: left;
        }
        .rj-single-content th {
            background: var(--rj-surface);
            font-weight: 600;
        }

        .rj-single-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid var(--rj-border);
        }
        .rj-single-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: var(--rj-radius-sm);
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            color: var(--rj-text);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all .15s;
        }
        .rj-single-tag::before {
            content: '#';
            color: var(--rj-muted);
        }
        .rj-single-tag:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 60%, var(--rj-border));
            color: var(--rj-primary);
            background: color-mix(in srgb, var(--rj-primary) 8%, var(--rj-surface));
        }

        .rj-single-nav {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 64px;
            padding-top: 48px;
            border-top: 1px solid var(--rj-border);
        }
        .rj-single-nav-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 24px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius);
            text-decoration: none;
            transition: all .18s;
        }
        .rj-single-nav-item:hover {
            border-color: color-mix(in srgb, var(--rj-primary) 50%, var(--rj-border));
            transform: translateY(-2px);
            background: color-mix(in srgb, var(--rj-primary) 5%, var(--rj-surface));
        }
        .rj-single-nav-item.rj-next { text-align: right; }
        .rj-single-nav-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--rj-muted);
        }
        .rj-single-nav-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--rj-text);
            line-height: 1.4;
        }

        @media (max-width: 768px) {
            .rj-single-wrap { padding: 40px 20px 64px; }
            .rj-single-hero { margin-left: -20px; margin-right: -20px; }
            .rj-single-meta { gap: 14px; }
            .rj-single-content { font-size: 16px; }
            .rj-single-content h2 { font-size: 24px; margin-top: 36px; }
            .rj-single-content h3 { font-size: 20px; margin-top: 28px; }
            .rj-single-nav { grid-template-columns: 1fr; }
            .rj-single-nav-item.rj-next { text-align: left; }
        }
    </style>
@endpush

@section('content')

<header class="rj-frontend-header">
    @if($header)
        {!! rj_render_template($header) !!}
    @endif
</header>

<main class="rj-frontend-main">
    <article class="rj-single-wrap">

        <nav class="rj-single-breadcrumb">
            <a href="{{ url('/') }}">{{ __('Home') }}</a>
            <span class="rj-single-breadcrumb-sep">/</span>
            <a href="{{ route('frontend.posts.index') }}">{{ __('Blog') }}</a>
            <span class="rj-single-breadcrumb-sep">/</span>
            <span>{{ \Illuminate\Support\Str::limit($post->title ?? '', 60) }}</span>
        </nav>

        @if($post->categories && $post->categories->isNotEmpty())
            <div class="rj-single-cats">
                @foreach($post->categories as $cat)
                    <a href="{{ route('frontend.categories.show', $cat->slug ?? $cat->id) }}" class="rj-single-cat">
                        {{ $cat->name ?? '' }}
                    </a>
                @endforeach
            </div>
        @endif

        <h1 class="rj-single-title">{{ $post->title ?? '' }}</h1>

        <div class="rj-single-meta">
            <div class="rj-single-meta-item rj-single-author">
                <span class="rj-single-author-avatar">
                    {{ strtoupper(substr(optional($post->author)->name ?? __('A'), 0, 1)) }}
                </span>
                <span>{{ optional($post->author)->name ?? __('Unknown author') }}</span>
            </div>

            @if($post->published_at)
                <div class="rj-single-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <time datetime="{{ $post->published_at->toIso8601String() }}">
                        {{ $post->published_at->format('M d, Y') }}
                    </time>
                </div>
            @endif

            @if($post->reading_time ?? false)
                <div class="rj-single-meta-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $post->reading_time }} {{ __('min read') }}</span>
                </div>
            @endif
        </div>

        @if($post->featured_image ?? $post->thumbnail ?? null)
            <figure class="rj-single-hero">
                <img src="{{ $post->featured_image ?? $post->thumbnail }}" alt="{{ $post->title ?? '' }}">
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
                    <a href="{{ route('frontend.tags.show', $tag->slug ?? $tag->id) }}" class="rj-single-tag">
                        {{ $tag->name ?? '' }}
                    </a>
                @endforeach
            </div>
        @endif

        @if(($previousPost ?? null) || ($nextPost ?? null))
            <nav class="rj-single-nav">
                @if($previousPost ?? null)
                    <a href="{{ route('frontend.posts.show', $previousPost->slug ?? $previousPost->id) }}" class="rj-single-nav-item rj-prev">
                        <span class="rj-single-nav-label">← {{ __('Previous') }}</span>
                        <span class="rj-single-nav-title">{{ $previousPost->title ?? '' }}</span>
                    </a>
                @else
                    <span></span>
                @endif

                @if($nextPost ?? null)
                    <a href="{{ route('frontend.posts.show', $nextPost->slug ?? $nextPost->id) }}" class="rj-single-nav-item rj-next">
                        <span class="rj-single-nav-label">{{ __('Next') }} →</span>
                        <span class="rj-single-nav-title">{{ $nextPost->title ?? '' }}</span>
                    </a>
                @endif
            </nav>
        @endif

    </article>
</main>

<footer class="rj-frontend-footer">
    @if($footer)
        {!! rj_render_template($footer) !!}
    @endif
</footer>

@endsection
