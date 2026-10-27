@php
    $title          = $settings['title'] ?? '';
    $subtitle       = $settings['subtitle'] ?? '';
    $layout         = $settings['layout'] ?? 'grid';
    $columns        = (int) ($settings['columns'] ?? 3);
    $gap            = $settings['gap'] ?? 'md';
    $aspect         = $settings['aspect'] ?? '1/1';
    $showPlatform   = $settings['show_platform'] ?? true;
    $showCaption    = $settings['show_caption'] ?? true;
    $showDate       = $settings['show_date'] ?? false;
    $accent         = $settings['accent'] ?? '#8b5cf6';
    $radius         = $settings['radius'] ?? 'lg';
    $paddingY       = (int) ($settings['padding_y'] ?? 60);
    $showTabs       = $settings['show_tabs'] ?? true;

    $radiusMap = ['none' => '0px', 'md' => '10px', 'lg' => '16px', 'xl' => '24px'];
    $radiusCss = $radiusMap[$radius] ?? '16px';

    $gapMap = ['sm' => '10px', 'md' => '16px', 'lg' => '24px'];
    $gapCss = $gapMap[$gap] ?? '16px';

    $rawBase = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/social-media';

    $platforms = [
        'twitter' => [
            'name'     => 'Twitter',
            'color'    => '#000000',
            'svg'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
            'fallback' => 'T',
        ],
        'instagram' => [
            'name'     => 'Instagram',
            'color'    => '#E4405F',
            'svg'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
            'fallback' => 'IG',
        ],
        'piokio' => [
            'name'     => 'Piokio',
            'color'    => '#FF6B35',
            'image'    => $rawBase . '/piokio/piokio_logo.svg',
            'fallback' => 'P',
        ],
        'dehliz' => [
            'name'     => 'Dehliz',
            'color'    => '#0f172a',
            'image'    => $rawBase . '/dehliz/dehliz_icon.svg',
            'fallback' => 'D',
        ],
        'reax' => [
            'name'     => 'Reax',
            'color'    => '#dc2626',
            'image'    => $rawBase . '/reax/icon.svg',
            'fallback' => 'R',
        ],
    ];

    $items = [];
    if (!empty($settings['items']) && is_array($settings['items'])) {
        foreach ($settings['items'] as $i => $row) {
            if (!is_array($row) || empty($row['image'])) continue;
            $p = $row['platform'] ?? 'twitter';
            if (!isset($platforms[$p])) $p = 'twitter';
            $items[] = [
                'id'       => $i,
                'platform' => $p,
                'image'    => $row['image'],
                'caption'  => $row['caption'] ?? '',
                'url'      => $row['url'] ?? '',
                'date'     => $row['date'] ?? '',
            ];
        }
    }

    $usedPlatforms = [];
    foreach ($items as $it) {
        if (!in_array($it['platform'], $usedPlatforms, true)) {
            $usedPlatforms[] = $it['platform'];
        }
    }

    $aspectCss = str_replace('/', ' / ', $aspect);
@endphp

<style>
    #{{ $uid }} {
        --sf-accent: {{ $accent }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-sf-inner {
        max-width: 1240px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-sf-head {
        text-align: center;
        margin-bottom: 28px;
    }
    #{{ $uid }} .rj-sf-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--sf-accent);
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-sf-title {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        margin: 0;
    }

    #{{ $uid }} .rj-sf-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        margin: 0 0 28px;
    }
    #{{ $uid }} .rj-sf-tab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 999px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }
    #{{ $uid }} .rj-sf-tab:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    #{{ $uid }} .rj-sf-tab.is-active {
        background: #0f172a;
        border-color: #0f172a;
        color: #fff;
    }
    #{{ $uid }} .rj-sf-tab .rj-sf-badge-mini {
        width: 18px;
        height: 18px;
    }

    /* ============================================
       STANDARD PLATFORM BADGE — 24x24 fixed size
       ============================================ */
    #{{ $uid }} .rj-sf-badge {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        border-radius: 6px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(15,23,42,.15);
        position: relative;
    }
    #{{ $uid }} .rj-sf-badge > svg,
    #{{ $uid }} .rj-sf-badge > img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 3px;
        display: block;
        color: inherit;
    }
    #{{ $uid }} .rj-sf-badge-fallback {
        position: absolute;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        background: var(--badge-color, #666);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .02em;
    }
    #{{ $uid }} .rj-sf-badge.is-fallback .rj-sf-badge-fallback {
        display: flex;
    }
    #{{ $uid }} .rj-sf-badge.is-fallback > img {
        display: none;
    }

    /* ---------- GRID ---------- */
    #{{ $uid }} .rj-sf-grid {
        display: grid;
        gap: {{ $gapCss }};
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-sf-grid { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-sf-grid { grid-template-columns: 1fr; }
    }

    /* ---------- MASONRY ---------- */
    #{{ $uid }} .rj-sf-masonry {
        column-count: {{ $columns }};
        column-gap: {{ $gapCss }};
    }
    #{{ $uid }} .rj-sf-masonry .rj-sf-card {
        break-inside: avoid;
        page-break-inside: avoid;
        margin-bottom: {{ $gapCss }};
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-sf-masonry { column-count: {{ $columns > 2 ? 2 : 1 }}; }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-sf-masonry { column-count: 1; }
    }

    /* ---------- CAROUSEL ---------- */
    #{{ $uid }} .rj-sf-carousel {
        display: flex;
        gap: {{ $gapCss }};
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 10px;
        -webkit-overflow-scrolling: touch;
    }
    #{{ $uid }} .rj-sf-carousel .rj-sf-card {
        flex: 0 0 auto;
        width: calc((100% - {{ $gapCss }} * ({{ $columns }} - 1)) / {{ $columns }});
        scroll-snap-align: start;
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-sf-carousel .rj-sf-card {
            width: calc((100% - {{ $gapCss }}) / 2);
        }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-sf-carousel .rj-sf-card {
            width: 80%;
        }
    }

    /* ---------- CARD ---------- */
    #{{ $uid }} .rj-sf-card {
        position: relative;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        background: #0f172a;
        cursor: pointer;
        text-decoration: none;
        display: block;
        transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease;
    }
    #{{ $uid }}[data-layout="grid"] .rj-sf-card,
    #{{ $uid }}[data-layout="carousel"] .rj-sf-card {
        aspect-ratio: {{ $aspectCss }};
    }
    #{{ $uid }} .rj-sf-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -16px rgba(15,23,42,.4);
    }
    #{{ $uid }} .rj-sf-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .8s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-sf-card:hover .rj-sf-card-img {
        transform: scale(1.06);
    }

    #{{ $uid }} .rj-sf-card-veil {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(2,6,23,.15) 0%, transparent 30%, transparent 45%, rgba(2,6,23,.85) 100%);
        pointer-events: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 12px;
    }
    #{{ $uid }} .rj-sf-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }
    #{{ $uid }} .rj-sf-card-date {
        font-size: 10.5px;
        font-weight: 700;
        color: #fff;
        background: rgba(255,255,255,.18);
        backdrop-filter: blur(6px);
        padding: 3px 8px;
        border-radius: 6px;
    }
    #{{ $uid }} .rj-sf-card-caption {
        font-size: 12.5px;
        color: #fff;
        line-height: 1.45;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        opacity: 0;
        transform: translateY(6px);
        transition: opacity .35s ease, transform .35s ease;
    }
    #{{ $uid }} .rj-sf-card:hover .rj-sf-card-caption {
        opacity: 1;
        transform: none;
    }

    #{{ $uid }} .rj-sf-card.is-hidden {
        display: none !important;
    }

    #{{ $uid }} .rj-sf-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        font-size: 14px;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}" data-layout="{{ $layout }}">
    <div class="rj-sf-inner">
        @if($title || $subtitle)
            <header class="rj-sf-head">
                @if($subtitle)
                    <p class="rj-sf-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-sf-title">{{ $title }}</h2>
                @endif
            </header>
        @endif

        @if(!empty($items))
            @if($showTabs && count($usedPlatforms) > 1)
                <div class="rj-sf-tabs">
                    <button type="button" class="rj-sf-tab is-active" data-filter="">
                        <span>{{ __('All') }}</span>
                    </button>
                    @foreach($usedPlatforms as $pk)
                        @php $pinfo = $platforms[$pk]; @endphp
                        <button type="button" class="rj-sf-tab" data-filter="{{ $pk }}">
                            <span class="rj-sf-badge rj-sf-badge-mini" data-platform="{{ $pk }}" style="--badge-color: {{ $pinfo['color'] }};">
                                @if(!empty($pinfo['svg']))
                                    {!! $pinfo['svg'] !!}
                                @elseif(!empty($pinfo['image']))
                                    <img src="{{ $pinfo['image'] }}" alt="" loading="lazy" onerror="this.closest('.rj-sf-badge').classList.add('is-fallback')">
                                @endif
                                <span class="rj-sf-badge-fallback">{{ $pinfo['fallback'] }}</span>
                            </span>
                            <span>{{ $pinfo['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            @endif

            @if($layout === 'masonry')
                <div class="rj-sf-masonry">
                    @foreach($items as $it)
                        @include('rjbuilder.widgets.builtin.partials.social-card', ['it' => $it, 'platforms' => $platforms, 'showPlatform' => $showPlatform, 'showCaption' => $showCaption, 'showDate' => $showDate])
                    @endforeach
                </div>
            @elseif($layout === 'carousel')
                <div class="rj-sf-carousel">
                    @foreach($items as $it)
                        @include('rjbuilder.widgets.builtin.partials.social-card', ['it' => $it, 'platforms' => $platforms, 'showPlatform' => $showPlatform, 'showCaption' => $showCaption, 'showDate' => $showDate])
                    @endforeach
                </div>
            @else
                <div class="rj-sf-grid">
                    @foreach($items as $it)
                        @include('rjbuilder.widgets.builtin.partials.social-card', ['it' => $it, 'platforms' => $platforms, 'showPlatform' => $showPlatform, 'showCaption' => $showCaption, 'showDate' => $showDate])
                    @endforeach
                </div>
            @endif
        @else
            <div class="rj-sf-empty">{{ __('Please add at least one social post.') }}</div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var tabs = root.querySelectorAll('[data-filter]');
    var cards = root.querySelectorAll('.rj-sf-card');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');
            var filter = tab.getAttribute('data-filter') || '';
            cards.forEach(function (card) {
                if (filter === '' || card.getAttribute('data-platform') === filter) {
                    card.classList.remove('is-hidden');
                } else {
                    card.classList.add('is-hidden');
                }
            });
        });
    });
})();
</script>
