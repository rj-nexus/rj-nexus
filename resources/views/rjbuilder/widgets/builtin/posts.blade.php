@php
    $layout = $settings['layout'] ?? 'grid';
    $columns = (int) ($settings['columns'] ?? 3);

    $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '20px', 'lg' => '32px', 'xl' => '48px'];
    $gap = $gapMap[$settings['gap'] ?? 'md'] ?? '20px';

    $radiusMap = ['none' => '0', 'sm' => '4px', 'md' => '8px', 'lg' => '16px'];
    $radius = $radiusMap[$settings['card_radius'] ?? 'md'] ?? '8px';

    $titleSizes = ['sm' => '14px', 'base' => '16px', 'lg' => '18px', 'xl' => '22px'];
    $titleSize = $titleSizes[$settings['title_size'] ?? 'lg'] ?? '18px';

    $wrapperStyles = [
        '--rj-posts-gap:' . $gap,
        '--rj-posts-radius:' . $radius,
        '--rj-posts-bg:' . ($settings['card_bg'] ?? '#ffffff'),
        '--rj-posts-title-color:' . ($settings['title_color'] ?? '#111827'),
        '--rj-posts-title-size:' . $titleSize,
        '--rj-posts-text-color:' . ($settings['text_color'] ?? '#6b7280'),
        '--rj-posts-meta-color:' . ($settings['meta_color'] ?? '#9ca3af'),
    ];

    // Artıq $this istifadə etmirik, çünki bu dəyərlər Widget-dən gəlir
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

    #{{ $uid }} .rj-post-card {
        background: var(--rj-posts-bg);
        border-radius: var(--rj-posts-radius);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    #{{ $uid }}.rj-posts-hover-lift .rj-post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -10px rgba(0,0,0,0.1);
    }

    #{{ $uid }} .rj-post-image {
        display: block;
        width: 100%;
        overflow: hidden;
        position: relative;
    }
    #{{ $uid }} .rj-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        aspect-ratio: {{ str_replace('/', ' / ', $imageRatio) }};
        transition: transform 0.5s ease;
    }
    #{{ $uid }} .rj-post-card:hover .rj-post-image img {
        transform: scale(1.05);
    }

    #{{ $uid }} .rj-post-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    #{{ $uid }} .rj-post-cats {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 10px;
    }
    #{{ $uid }} .rj-post-cat {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #8b5cf6;
    }

    #{{ $uid }} .rj-post-title {
        font-size: var(--rj-posts-title-size);
        font-weight: 800;
        color: var(--rj-posts-title-color);
        margin: 0 0 10px;
        line-height: 1.3;
    }
    #{{ $uid }} .rj-post-title a {
        color: inherit;
        text-decoration: none;
    }
    #{{ $uid }} .rj-post-title a:hover {
        color: #8b5cf6;
    }

    #{{ $uid }} .rj-post-excerpt {
        font-size: 14px;
        color: var(--rj-posts-text-color);
        line-height: 1.6;
        margin: 0 0 16px;
    }

    #{{ $uid }} .rj-post-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--rj-posts-meta-color);
        margin-top: auto;
    }
    #{{ $uid }} .rj-post-meta-sep {
        opacity: 0.5;
    }

    #{{ $uid }} .rj-post-read-more {
        display: inline-block;
        margin-top: 14px;
        font-size: 13px;
        font-weight: 700;
        color: #8b5cf6;
        text-decoration: none;
    }

    /* Compact Layout */
    #{{ $uid }}.rj-posts-compact {
        display: flex;
        flex-direction: column;
        gap: var(--rj-posts-gap);
    }
    #{{ $uid }}.rj-posts-compact .rj-cmp-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        text-decoration: none;
        color: inherit;
        transition: transform 0.25s ease;
    }
    #{{ $uid }}.rj-posts-hover-lift.rj-posts-compact .rj-cmp-item:hover {
        transform: translateX(4px);
    }
    #{{ $uid }} .rj-cmp-thumb {
        width: 72px;
        height: 72px;
        flex-shrink: 0;
        border-radius: var(--rj-posts-radius);
        overflow: hidden;
        background: #f1f5f9;
    }
    #{{ $uid }} .rj-cmp-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    #{{ $uid }} .rj-cmp-body {
        flex: 1;
        min-width: 0;
        padding-top: 2px;
    }
    #{{ $uid }} .rj-cmp-cats {
        display: flex;
        gap: 4px;
        margin-bottom: 4px;
    }
    #{{ $uid }} .rj-cmp-cat {
        font-size: 9.5px;
        font-weight: 700;
        text-transform: uppercase;
        color: #8b5cf6;
    }
    #{{ $uid }} .rj-cmp-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--rj-posts-title-color);
        margin: 0 0 4px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #{{ $uid }} .rj-cmp-excerpt {
        font-size: 11.5px;
        color: var(--rj-posts-text-color);
        margin: 3px 0 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #{{ $uid }} .rj-cmp-meta {
        font-size: 10.5px;
        color: var(--rj-posts-meta-color);
        display: flex;
        gap: 5px;
    }
</style>

@if($posts->isEmpty())
    <div class="rj-posts rj-posts-empty" {!! $id ? 'id="'.e($id).'"' : '' !!}>
        <div style="padding:32px 20px; text-align:center; color:#9ca3af; font-size:13px; border:1px dashed #e5e7eb; border-radius:8px;">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="display:block; margin:0 auto 8px;"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 12h6M9 16h4"/></svg>
            {{ __('No posts found.') }}
        </div>
    </div>
@else
    <div id="{{ $uid }}" class="{{ $wrapperClasses }}" style="{{ implode(';', $wrapperStyles) }}">

        @if($layout === 'compact')
            @foreach($posts as $post)
                @php $url = url('/blog/' . $post->slug); @endphp
                <a href="{{ $url }}" class="rj-cmp-item">
                    @if($showImage && $post->featured_image)
                        <div class="rj-cmp-thumb">
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
                        </div>
                    @endif
                    <div class="rj-cmp-body">
                        @if($showCategories && $post->categories->isNotEmpty())
                            <div class="rj-cmp-cats">
                                @foreach($post->categories->take(1) as $cat)
                                    <span class="rj-cmp-cat">{{ $cat->name }}</span>
                                @endforeach
                            </div>
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
                                @if($showDate && $post->published_at)
                                    <span>{{ $post->published_at->format('M j, Y') }}</span>
                                @endif
                                @if($showAuthor && $post->author)
                                    <span>· {{ $post->author->name }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        @else
            @foreach($posts as $post)
                @php $url = url('/blog/' . $post->slug); @endphp
                <article class="rj-post-card">
                    @if($showImage && $post->featured_image)
                        <a href="{{ $url }}" class="rj-post-image">
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
                        </a>
                    @endif

                    <div class="rj-post-body">
                        @if($showCategories && $post->categories->isNotEmpty())
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

                        @if($showDate || $showAuthor)
                            <div class="rj-post-meta">
                                @if($showDate && $post->published_at)
                                    <span class="rj-post-meta-item">{{ $post->published_at->format('M j, Y') }}</span>
                                @endif
                                @if($showDate && $showAuthor && $post->author)
                                    <span class="rj-post-meta-sep">·</span>
                                @endif
                                @if($showAuthor && $post->author)
                                    <span class="rj-post-meta-item">{{ $post->author->name }}</span>
                                @endif
                            </div>
                        @endif

                        @if($showReadMore)
                            <a href="{{ $url }}" class="rj-post-read-more">
                                {{ $settings['read_more_text'] ?? __('Read more') }} →
                            </a>
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
