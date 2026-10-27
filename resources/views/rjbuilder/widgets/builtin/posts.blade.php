@php
    $layout = $settings['layout'] ?? 'grid';
    $columns = (int) ($settings['columns'] ?? 3);

    $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '20px', 'lg' => '32px', 'xl' => '48px'];
    $gap = $gapMap[$settings['gap'] ?? 'md'] ?? '20px';

    $radiusMap = ['none' => '0', 'sm' => '6px', 'md' => '14px', 'lg' => '24px'];
    $radius = $radiusMap[$settings['card_radius'] ?? 'md'] ?? '14px';

    $titleSizes = ['sm' => '15px', 'base' => '17px', 'lg' => '20px', 'xl' => '25px'];
    $titleSize = $titleSizes[$settings['title_size'] ?? 'lg'] ?? '20px';

    $wrapperStyles = [
        '--rj-posts-gap:' . $gap,
        '--rj-posts-radius:' . $radius,
        '--rj-posts-bg:' . ($settings['card_bg'] ?? '#ffffff'),
        '--rj-posts-title-color:' . ($settings['title_color'] ?? '#0f172a'),
        '--rj-posts-title-size:' . $titleSize,
        '--rj-posts-text-color:' . ($settings['text_color'] ?? '#64748b'),
        '--rj-posts-meta-color:' . ($settings['meta_color'] ?? '#94a3b8'),
        '--rj-posts-accent:' . ($settings['accent_color'] ?? '#7c3aed'),
    ];

    if ($padding !== '') $wrapperStyles[] = 'padding:' . $padding;
    if ($margin !== '') $wrapperStyles[] = 'margin:' . $margin;
    if ($bg !== '') $wrapperStyles[] = rtrim($bg, ';');

    $wrapperClasses = 'rj-posts rj-posts-' . $layout . ' rj-posts-cols-' . $columns . ' rj-posts-card-' . ($settings['card_style'] ?? 'default');
    if (!empty($settings['hover_lift'])) $wrapperClasses .= ' rj-posts-hover-lift';
    if ($class !== '') $wrapperClasses .= ' ' . $class;

    $showImage = !empty($settings['show_image']);
    $showExcerpt = !empty($settings['show_excerpt']);
    $showDate = !empty($settings['show_date']);
    $showAuthor = !empty($settings['show_author']);
    $showCategories = !empty($settings['show_categories']);
    $showReadMore = !empty($settings['show_read_more']);
    $excerptLength = max(5, (int) ($settings['excerpt_length'] ?? 20));
    $imageRatio = $settings['image_ratio'] ?? '16/9';
@endphp

<style>
    @property --rj-posts-angle {
        syntax: '<angle>';
        inherits: false;
        initial-value: 0deg;
    }
    @keyframes rj-posts-spin { to { --rj-posts-angle: 360deg; } }
    @keyframes rj-posts-rise {
        from { opacity: 0; transform: translateY(28px) scale(.97); }
        to   { opacity: 1; transform: none; }
    }

    #{{ $uid }} {
        display: grid;
        gap: var(--rj-posts-gap);
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
    }
    @media (max-width: 900px) {
        #{{ $uid }} { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} { grid-template-columns: 1fr; }
    }

    /* ---------- Card ---------- */
    #{{ $uid }} .rj-post-card {
        position: relative;
        isolation: isolate;
        display: flex;
        flex-direction: column;
        background: var(--rj-posts-bg);
        border-radius: var(--rj-posts-radius);
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .05), 0 14px 32px -18px rgba(15, 23, 42, .22);
        transition: transform .45s cubic-bezier(.2, .8, .2, 1), box-shadow .45s ease;
    }
    #{{ $uid }}.rj-posts-card-bordered .rj-post-card { box-shadow: none; border: 1px solid rgba(100, 116, 139, .22); }
    #{{ $uid }}.rj-posts-card-flat .rj-post-card { box-shadow: none; }
    #{{ $uid }}.rj-posts-card-shadow .rj-post-card { box-shadow: 0 2px 4px rgba(15, 23, 42, .06), 0 28px 48px -22px rgba(15, 23, 42, .38); }

    /* Glowing ring that circles the card on hover */
    #{{ $uid }} .rj-post-card::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 4;
        border-radius: inherit;
        padding: 2px;
        pointer-events: none;
        background: conic-gradient(from var(--rj-posts-angle), transparent 0 55%, var(--rj-posts-accent) 80%, transparent 100%);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
                mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
        opacity: 0;
        transition: opacity .4s ease;
    }

    @media (hover: hover) {
        #{{ $uid }} .rj-post-card:hover::before {
            opacity: 1;
            animation: rj-posts-spin 3.2s linear infinite;
        }
        #{{ $uid }}.rj-posts-hover-lift .rj-post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 2px 4px rgba(15, 23, 42, .06), 0 32px 56px -24px color-mix(in srgb, var(--rj-posts-accent) 55%, #0f172a);
        }
        #{{ $uid }} .rj-post-card:hover .rj-post-image img { transform: scale(1.07); }
        #{{ $uid }} .rj-post-card:hover .rj-post-read-more svg { transform: translateX(3px); }
        #{{ $uid }} .rj-post-card:hover .rj-post-read-more-icon {
            background: var(--rj-posts-accent);
            color: #fff;
        }
    }

    /* ---------- Image ---------- */
    #{{ $uid }} .rj-post-image {
        position: relative;
        display: block;
        width: 100%;
        aspect-ratio: {{ str_replace('/', ' / ', $imageRatio) }};
        overflow: hidden;
        background: #e2e8f0;
    }
    #{{ $uid }} .rj-post-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, .45), transparent 55%);
        pointer-events: none;
    }
    #{{ $uid }} .rj-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .9s cubic-bezier(.2, .8, .2, 1);
    }
    #{{ $uid }} .rj-post-image--empty {
        display: grid;
        place-items: center;
        background:
            radial-gradient(circle at 20% 15%, color-mix(in srgb, var(--rj-posts-accent) 70%, #fff) 0, transparent 55%),
            radial-gradient(circle at 85% 90%, color-mix(in srgb, var(--rj-posts-accent) 85%, #0f172a) 0, transparent 60%),
            color-mix(in srgb, var(--rj-posts-accent) 40%, #e2e8f0);
    }
    #{{ $uid }} .rj-post-image--empty span {
        position: relative;
        z-index: 1;
        font-size: clamp(48px, 9vw, 88px);
        font-weight: 900;
        line-height: 1;
        color: rgba(255, 255, 255, .85);
        text-shadow: 0 6px 30px rgba(15, 23, 42, .3);
    }

    /* Category chips that float over the image */
    #{{ $uid }} .rj-post-chips {
        position: absolute;
        top: 14px;
        left: 14px;
        right: 14px;
        z-index: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    #{{ $uid }} .rj-post-chip {
        padding: 5px 11px;
        font-size: 11.5px;
        font-weight: 600;
        color: #fff;
        background: rgba(15, 23, 42, .32);
        border: 1px solid rgba(255, 255, 255, .28);
        -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
        border-radius: 999px;
    }

    /* ---------- Body panel (slides over the image) ---------- */
    #{{ $uid }} .rj-post-body {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 22px 24px 20px;
        background: var(--rj-posts-bg);
    }
    #{{ $uid }} .rj-post-card--img .rj-post-body {
        margin-top: calc(var(--rj-posts-radius) * -1.4);
        border-radius: calc(var(--rj-posts-radius) * 1.4) calc(var(--rj-posts-radius) * 1.4) 0 0;
    }

    #{{ $uid }} .rj-post-cats {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }
    #{{ $uid }} .rj-post-cat {
        padding: 4px 10px;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--rj-posts-accent);
        background: color-mix(in srgb, var(--rj-posts-accent) 11%, transparent);
        border-radius: 999px;
    }

    #{{ $uid }} .rj-post-title {
        margin: 0 0 10px;
        font-size: var(--rj-posts-title-size);
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -.02em;
        color: var(--rj-posts-title-color);
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #{{ $uid }} .rj-post-title a {
        color: inherit;
        text-decoration: none;
        background: linear-gradient(var(--rj-posts-accent), var(--rj-posts-accent)) 0 100% / 0 2px no-repeat;
        transition: background-size .45s cubic-bezier(.2, .8, .2, 1);
    }
    #{{ $uid }} .rj-post-title a::after { /* whole card is clickable */
        content: '';
        position: absolute;
        inset: 0;
        z-index: 3;
    }
    #{{ $uid }} .rj-post-card:hover .rj-post-title a { background-size: 100% 2px; }
    #{{ $uid }} .rj-post-title a:focus-visible { outline: none; }
    #{{ $uid }} .rj-post-card:has(.rj-post-title a:focus-visible) {
        outline: 3px solid var(--rj-posts-accent);
        outline-offset: 3px;
    }

    #{{ $uid }} .rj-post-excerpt {
        margin: 0 0 18px;
        font-size: 14.5px;
        line-height: 1.65;
        color: var(--rj-posts-text-color);
    }

    /* ---------- Meta ---------- */
    #{{ $uid }} .rj-post-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid rgba(100, 116, 139, .16);
        font-size: 12.5px;
        color: var(--rj-posts-meta-color);
    }
    #{{ $uid }} .rj-post-avatar {
        flex-shrink: 0;
        display: grid;
        place-items: center;
        width: 26px;
        height: 26px;
        font-size: 12px;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, var(--rj-posts-accent), color-mix(in srgb, var(--rj-posts-accent) 55%, #0ea5e9));
        border-radius: 50%;
    }
    #{{ $uid }} .rj-post-author {
        font-weight: 600;
        color: var(--rj-posts-text-color);
    }
    #{{ $uid }} .rj-post-date { margin-left: auto; }

    #{{ $uid }} .rj-post-read-more {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--rj-posts-accent);
    }
    #{{ $uid }} .rj-post-read-more-icon {
        display: grid;
        place-items: center;
        width: 30px;
        height: 30px;
        color: var(--rj-posts-accent);
        background: color-mix(in srgb, var(--rj-posts-accent) 12%, transparent);
        border-radius: 50%;
        transition: background .3s ease, color .3s ease;
    }
    #{{ $uid }} .rj-post-read-more svg { transition: transform .3s ease; }

    /* ---------- Compact layout ---------- */
    #{{ $uid }}.rj-posts-compact {
        display: flex;
        flex-direction: column;
        gap: var(--rj-posts-gap);
    }
    #{{ $uid }} .rj-cmp-item {
        position: relative;
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 12px 16px 12px 12px;
        text-decoration: none;
        color: inherit;
        background: var(--rj-posts-bg);
        border-radius: var(--rj-posts-radius);
        box-shadow: 0 1px 2px rgba(15, 23, 42, .05), 0 10px 24px -16px rgba(15, 23, 42, .25);
        transition: transform .35s cubic-bezier(.2, .8, .2, 1), box-shadow .35s ease;
    }
    #{{ $uid }} .rj-cmp-item::before { /* accent bar */
        content: '';
        position: absolute;
        left: 0;
        top: 18%;
        bottom: 18%;
        width: 4px;
        border-radius: 0 4px 4px 0;
        background: linear-gradient(var(--rj-posts-accent), color-mix(in srgb, var(--rj-posts-accent) 50%, #0ea5e9));
        transform: scaleY(0);
        transition: transform .4s cubic-bezier(.2, .8, .2, 1);
    }
    #{{ $uid }} .rj-cmp-item:focus-visible {
        outline: 3px solid var(--rj-posts-accent);
        outline-offset: 3px;
    }
    @media (hover: hover) {
        #{{ $uid }} .rj-cmp-item:hover::before { transform: scaleY(1); }
        #{{ $uid }}.rj-posts-hover-lift .rj-cmp-item:hover {
            transform: translateX(6px);
            box-shadow: 0 2px 4px rgba(15, 23, 42, .06), 0 18px 32px -18px color-mix(in srgb, var(--rj-posts-accent) 50%, #0f172a);
        }
        #{{ $uid }} .rj-cmp-item:hover .rj-cmp-thumb img { transform: scale(1.12); }
        #{{ $uid }} .rj-cmp-item:hover .rj-cmp-title { color: var(--rj-posts-accent); }
    }
    #{{ $uid }} .rj-cmp-thumb {
        width: 84px;
        height: 84px;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: calc(var(--rj-posts-radius) * .75);
        background: #e2e8f0;
    }
    #{{ $uid }} .rj-cmp-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .7s cubic-bezier(.2, .8, .2, 1);
    }
    #{{ $uid }} .rj-cmp-thumb--empty {
        display: grid;
        place-items: center;
        font-size: 28px;
        font-weight: 900;
        color: rgba(255, 255, 255, .9);
        background: linear-gradient(135deg, var(--rj-posts-accent), color-mix(in srgb, var(--rj-posts-accent) 45%, #0ea5e9));
    }
    #{{ $uid }} .rj-cmp-body { flex: 1; min-width: 0; }
    #{{ $uid }} .rj-cmp-cat {
        display: inline-block;
        margin-bottom: 5px;
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 600;
        color: var(--rj-posts-accent);
        background: color-mix(in srgb, var(--rj-posts-accent) 11%, transparent);
        border-radius: 999px;
    }
    #{{ $uid }} .rj-cmp-title {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.35;
        letter-spacing: -.01em;
        color: var(--rj-posts-title-color);
        transition: color .25s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #{{ $uid }} .rj-cmp-excerpt {
        margin: 0 0 6px;
        font-size: 12.5px;
        color: var(--rj-posts-text-color);
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #{{ $uid }} .rj-cmp-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11.5px;
        color: var(--rj-posts-meta-color);
    }
    #{{ $uid }} .rj-cmp-meta span + span::before {
        content: '';
        display: inline-block;
        width: 3px;
        height: 3px;
        margin-right: 8px;
        vertical-align: middle;
        background: currentColor;
        border-radius: 50%;
        opacity: .7;
    }

    /* ---------- Load more / pagination ---------- */
    #{{ $uid }} .rj-posts-btn-load {
        padding: 13px 30px;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--rj-posts-accent), color-mix(in srgb, var(--rj-posts-accent) 55%, #0ea5e9));
        box-shadow: 0 14px 28px -14px var(--rj-posts-accent);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    #{{ $uid }} .rj-posts-btn-load:hover { transform: translateY(-2px); box-shadow: 0 20px 32px -14px var(--rj-posts-accent); }
    #{{ $uid }} .rj-posts-btn-load:focus-visible { outline: 3px solid var(--rj-posts-accent); outline-offset: 3px; }

    /* ---------- Scroll reveal (only where supported) ---------- */
    @supports (animation-timeline: view()) {
        @media (prefers-reduced-motion: no-preference) {
            #{{ $uid }} .rj-post-card,
            #{{ $uid }} .rj-cmp-item {
                animation: rj-posts-rise linear both;
                animation-timeline: view();
                animation-range: entry 0% entry 30%;
            }
        }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before { animation: none !important; transition: none !important; }
    }
</style>

@if($posts->isEmpty())
    <div class="rj-posts rj-posts-empty" {!! $id ? 'id="'.e($id).'"' : '' !!}>
        <div style="padding:44px 24px; text-align:center; color:#64748b; font-size:14px; border:2px dashed rgba(100,116,139,.3); border-radius:18px; background:linear-gradient(135deg, rgba(124,58,237,.05), rgba(14,165,233,.05));">
            <svg width="40" height="40" fill="none" stroke="#7c3aed" stroke-width="1.5" viewBox="0 0 24 24" style="display:block; margin:0 auto 12px;"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M8 9h8M8 13h8M8 17h5" stroke-linecap="round"/></svg>
            {{ __('No posts found.') }}
        </div>
    </div>
@else
    <div id="{{ $uid }}" class="{{ $wrapperClasses }}" style="{{ implode(';', $wrapperStyles) }}">

        @if($layout === 'compact')
            @foreach($posts as $post)
                @php $url = url('/blog/' . $post->slug); @endphp
                <a href="{{ $url }}" class="rj-cmp-item">
                    @if($showImage)
                        @if($post->featured_image)
                            <div class="rj-cmp-thumb">
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
                            </div>
                        @else
                            <div class="rj-cmp-thumb rj-cmp-thumb--empty" aria-hidden="true">{{ mb_strtoupper(mb_substr((string) $post->title, 0, 1)) }}</div>
                        @endif
                    @endif
                    <div class="rj-cmp-body">
                        @if($showCategories && $post->categories->isNotEmpty())
                            <span class="rj-cmp-cat">{{ $post->categories->first()->name }}</span>
                        @endif

                        <h4 class="rj-cmp-title">{{ $post->title }}</h4>

                        @if($showExcerpt)
                            @php $excerpt = \Illuminate\Support\Str::words(strip_tags((string) $post->excerpt), $excerptLength, '…'); @endphp
                            @if($excerpt)
                                <p class="rj-cmp-excerpt">{{ $excerpt }}</p>
                            @endif
                        @endif

                        @if($showDate || $showAuthor)
                            <div class="rj-cmp-meta">
                                @if($showAuthor && $post->author)
                                    <span>{{ $post->author->name }}</span>
                                @endif
                                @if($showDate && $post->published_at)
                                    <span>{{ $post->published_at->format('M j, Y') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        @else
            @foreach($posts as $post)
                @php
                    $url = url('/blog/' . $post->slug);
                    $hasImage = $showImage;
                    $chipsOnImage = $hasImage && $showCategories && $post->categories->isNotEmpty();
                @endphp
                <article class="rj-post-card {{ $hasImage ? 'rj-post-card--img' : '' }}">
                    @if($hasImage)
                        @if($post->featured_image)
                            <div class="rj-post-image">
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
                                @if($chipsOnImage)
                                    <div class="rj-post-chips">
                                        @foreach($post->categories->take(2) as $cat)
                                            <span class="rj-post-chip">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="rj-post-image rj-post-image--empty" aria-hidden="true">
                                <span>{{ mb_strtoupper(mb_substr((string) $post->title, 0, 1)) }}</span>
                                @if($chipsOnImage)
                                    <div class="rj-post-chips">
                                        @foreach($post->categories->take(2) as $cat)
                                            <span class="rj-post-chip">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif

                    <div class="rj-post-body">
                        @if(!$hasImage && $showCategories && $post->categories->isNotEmpty())
                            <div class="rj-post-cats">
                                @foreach($post->categories->take(2) as $cat)
                                    <span class="rj-post-cat">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <h3 class="rj-post-title">
                            <a href="{{ $url }}">{{ $post->title }}</a>
                        </h3>

                        @if($showExcerpt)
                            @php $excerpt = \Illuminate\Support\Str::words(strip_tags((string) $post->excerpt), $excerptLength, '...'); @endphp
                            @if($excerpt)
                                <p class="rj-post-excerpt">{{ $excerpt }}</p>
                            @endif
                        @endif

                        @if($showReadMore)
                            <span class="rj-post-read-more" aria-hidden="true">
                                {{ $settings['read_more_text'] ?? __('Read more') }}
                                <span class="rj-post-read-more-icon">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                </span>
                            </span>
                        @endif

                        @if($showDate || $showAuthor)
                            <div class="rj-post-meta">
                                @if($showAuthor && $post->author)
                                    <span class="rj-post-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr((string) $post->author->name, 0, 1)) }}</span>
                                    <span class="rj-post-author">{{ $post->author->name }}</span>
                                @endif
                                @if($showDate && $post->published_at)
                                    <time class="rj-post-date" datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('M j, Y') }}</time>
                                @endif
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        @endif

        @if(($settings['pagination'] ?? 'none') === 'load_more')
            <div class="rj-posts-loadmore" style="grid-column: 1 / -1; text-align: center; margin-top: 20px;">
                <button type="button" class="rj-posts-btn-load" data-post-type="{{ e($settings['post_type'] ?? 'post') }}">
                    {{ __('Load More') }}
                </button>
            </div>
        @elseif(($settings['pagination'] ?? 'none') === 'numbers')
            <div class="rj-posts-pagination" style="grid-column: 1 / -1; text-align: center; margin-top: 20px;"></div>
        @endif
    </div>
@endif
