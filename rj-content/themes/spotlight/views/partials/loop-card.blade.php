@php
    $cardImage = $post->featured_image ?? null;
    $cardUrl = $post->public_url ?? '#';
    $cardCategory = $post->categories->first() ?? null;
    $cardExcerpt = $post->excerpt ?? null;
    $locale = app()->getLocale();

    $showExcerpt = isset($showExcerpt) ? $showExcerpt : true;

    $catUrl = $cardCategory
        ? route('frontend.posts.index', ['locale' => $locale, 'term' => $cardCategory->slug, 'taxonomy' => 'category'])
        : null;
@endphp

<article class="rj-card">
    <a href="{{ $cardUrl }}" class="rj-card-media">
        @if($cardImage)
            <img src="{{ $cardImage }}" alt="{{ $post->title ?? '' }}" loading="lazy">
        @else
            <div class="rj-card-media-placeholder">
                <svg style="width:40px;height:40px;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif

        @if($cardCategory && $catUrl)
            <span class="rj-card-cat">{{ $cardCategory->name ?? '' }}</span>
        @endif
    </a>

    <div class="rj-card-body">
        <a href="{{ $cardUrl }}" class="rj-card-title">{{ $post->title ?? '' }}</a>

        @if($showExcerpt && $cardExcerpt)
            <p class="rj-card-excerpt">{{ $cardExcerpt }}</p>
        @endif

        <div class="rj-card-meta">
            @if($post->published_at)
                <time datetime="{{ $post->published_at->toIso8601String() }}">
                    {{ $post->published_at->format('M d, Y') }}
                </time>
            @endif

            @if(optional($post->author)->name)
                <span class="rj-card-meta-dot"></span>
                <span>{{ $post->author->name }}</span>
            @endif
        </div>
    </div>

    <style>
        .rj-card {
            display: flex;
            flex-direction: column;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
            overflow: hidden;
            transition: transform .22s, border-color .22s, box-shadow .22s;
        }
        .rj-card:hover {
            transform: translateY(-4px);
            border-color: color-mix(in srgb, var(--rj-primary) 45%, var(--rj-border));
            box-shadow: 0 20px 48px -20px color-mix(in srgb, var(--rj-primary) 35%, transparent);
        }
        .rj-card-media {
            position: relative;
            display: block;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: var(--rj-bg);
        }
        .rj-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }
        .rj-card:hover .rj-card-media img {
            transform: scale(1.06);
        }
        .rj-card-media-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--rj-border);
            background: linear-gradient(135deg, var(--rj-surface), var(--rj-bg));
        }
        .rj-card-cat {
            position: absolute;
            top: 14px;
            left: 14px;
            padding: 5px 12px;
            border-radius: 999px;
            background: color-mix(in srgb, var(--rj-bg) 80%, transparent);
            border: 1px solid color-mix(in srgb, var(--rj-primary) 40%, transparent);
            color: var(--rj-primary);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .rj-card-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 24px;
            flex: 1;
        }
        .rj-card-title {
            font-size: 19px;
            line-height: 1.35;
            font-weight: 700;
            letter-spacing: -.015em;
            color: var(--rj-text);
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color .15s;
        }
        .rj-card-title:hover {
            color: var(--rj-primary);
        }
        .rj-card-excerpt {
            font-size: 14px;
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .rj-card-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
            padding-top: 12px;
            font-size: 12px;
            font-weight: 500;
            color: var(--rj-muted);
        }
        .rj-card-meta-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: currentColor;
            opacity: .6;
        }
        @media (max-width: 480px) {
            .rj-card-body { padding: 20px; }
            .rj-card-title { font-size: 17px; }
        }
    </style>
</article>
