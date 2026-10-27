@php
    $title         = $settings['title'] ?? '';
    $subtitle      = $settings['subtitle'] ?? '';
    $layout        = $settings['layout'] ?? 'grid';
    $columns       = (int) ($settings['columns'] ?? 4);
    $logoHeight    = (int) ($settings['logo_height'] ?? 60);
    $grayscale     = $settings['grayscale'] ?? true;
    $hoverEffect   = $settings['hover_effect'] ?? 'color';
    $cardStyle     = $settings['card_style'] ?? 'plain';
    $align         = $settings['align'] ?? 'center';
    $bgColor       = $settings['bg_color'] ?? '#ffffff';
    $accent        = $settings['accent'] ?? '#8b5cf6';
    $marqueeSpeed  = (int) ($settings['marquee_speed'] ?? 30);
    $paddingY      = (int) ($settings['padding_y'] ?? 60);

    $logos = [];
    if (!empty($settings['logos']) && is_array($settings['logos'])) {
        foreach ($settings['logos'] as $row) {
            if (!is_array($row)) continue;
            $img = $row['image'] ?? '';
            if ($img === '') continue;
            $logos[] = [
                'image' => $img,
                'name'  => $row['name'] ?? '',
                'url'   => $row['url'] ?? '',
            ];
        }
    }

    $isMarquee = $layout === 'marquee' && count($logos) > 0;
@endphp

<style>
    #{{ $uid }} {
        --lg-accent: {{ $accent }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        background: {{ $bgColor }};
    }
    #{{ $uid }} .rj-lg-inner {
        max-width: 1240px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-lg-head {
        text-align: {{ $align }};
        margin-bottom: 36px;
    }
    #{{ $uid }} .rj-lg-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--lg-accent);
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-lg-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-lg-title { font-size: 34px; }
    }

    /* ---------- GRID ---------- */
    #{{ $uid }} .rj-lg-grid {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: 16px;
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-lg-grid { grid-template-columns: repeat({{ min($columns, 3) }}, minmax(0, 1fr)); }
    }
    @media (max-width: 640px) {
        #{{ $uid }} .rj-lg-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    /* ---------- CAROUSEL ---------- */
    #{{ $uid }} .rj-lg-carousel {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 10px;
        scrollbar-width: thin;
        -webkit-overflow-scrolling: touch;
    }
    #{{ $uid }} .rj-lg-carousel::-webkit-scrollbar { height: 6px; }
    #{{ $uid }} .rj-lg-carousel::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
    #{{ $uid }} .rj-lg-carousel::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    #{{ $uid }} .rj-lg-carousel .rj-lg-item {
        flex: 0 0 auto;
        width: {{ max(140, 100 / $columns) }}px;
        scroll-snap-align: start;
    }

    /* ---------- MARQUEE ---------- */
    #{{ $uid }} .rj-lg-marquee {
        position: relative;
        overflow: hidden;
        mask-image: linear-gradient(90deg, transparent 0%, #000 8%, #000 92%, transparent 100%);
        -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 8%, #000 92%, transparent 100%);
    }
    #{{ $uid }} .rj-lg-track {
        display: flex;
        gap: 44px;
        width: max-content;
        animation: rjLgScroll {{ $marqueeSpeed }}s linear infinite;
    }
    #{{ $uid }} .rj-lg-marquee:hover .rj-lg-track {
        animation-play-state: paused;
    }
    @keyframes rjLgScroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* ---------- ITEM ---------- */
    #{{ $uid }} .rj-lg-item {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 20px;
        border-radius: 14px;
        transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .35s ease, background .3s ease;
        text-decoration: none;
        position: relative;
    }
    #{{ $uid }}[data-card="boxed"] .rj-lg-item {
        background: #fff;
        border: 1px solid #e5e7eb;
    }
    #{{ $uid }}[data-card="ring"] .rj-lg-item {
        background: #fff;
        border: 2px solid #e5e7eb;
    }

    #{{ $uid }} .rj-lg-item img {
        height: {{ $logoHeight }}px;
        width: auto;
        max-width: 100%;
        object-fit: contain;
        display: block;
        transition: filter .4s ease, opacity .4s ease, transform .4s ease;
        @if($grayscale)
        filter: grayscale(1);
        opacity: .55;
        @else
        opacity: .9;
        @endif
    }
    #{{ $uid }} .rj-lg-item:hover img {
        @if($grayscale)
        filter: grayscale(0);
        opacity: 1;
        @endif
    }

    /* ---------- HOVER EFFECTS ---------- */
    #{{ $uid }}[data-hover="scale"] .rj-lg-item:hover {
        transform: scale(1.06);
    }
    #{{ $uid }}[data-hover="lift"] .rj-lg-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 32px -16px rgba(15,23,42,.25);
    }
    #{{ $uid }}[data-hover="glow"] .rj-lg-item:hover {
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--lg-accent) 30%, transparent), 0 18px 36px -18px color-mix(in srgb, var(--lg-accent) 45%, transparent);
        border-color: color-mix(in srgb, var(--lg-accent) 40%, transparent);
    }
    #{{ $uid }}[data-hover="glow"] .rj-lg-item:hover img {
        @if($grayscale)
        filter: grayscale(0);
        opacity: 1;
        @endif
    }
    #{{ $uid }}[data-hover="scale"] .rj-lg-item:hover img,
    #{{ $uid }}[data-hover="lift"] .rj-lg-item:hover img {
        transform: scale(1.04);
    }

    /* ---------- EMPTY ---------- */
    #{{ $uid }} .rj-lg-empty {
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
        #{{ $uid }} .rj-lg-track { animation: none; }
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}" data-card="{{ $cardStyle }}" data-hover="{{ $hoverEffect }}">
    <div class="rj-lg-inner">
        @if($title || $subtitle)
            <header class="rj-lg-head">
                @if($subtitle)
                    <p class="rj-lg-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-lg-title">{{ $title }}</h2>
                @endif
            </header>
        @endif

        @if(!empty($logos))
            @if($layout === 'marquee')
                <div class="rj-lg-marquee">
                    <div class="rj-lg-track">
                        @for($loop = 0; $loop < 2; $loop++)
                            @foreach($logos as $logo)
                                @if($logo['url'] !== '')
                                    <a href="{{ $logo['url'] }}" class="rj-lg-item" target="_blank" rel="noopener noreferrer" @if($loop === 1) aria-hidden="true" @endif>
                                        <img src="{{ $logo['image'] }}" alt="{{ $logo['name'] }}" loading="lazy">
                                    </a>
                                @else
                                    <div class="rj-lg-item" @if($loop === 1) aria-hidden="true" @endif>
                                        <img src="{{ $logo['image'] }}" alt="{{ $logo['name'] }}" loading="lazy">
                                    </div>
                                @endif
                            @endforeach
                        @endfor
                    </div>
                </div>
            @elseif($layout === 'carousel')
                <div class="rj-lg-carousel">
                    @foreach($logos as $logo)
                        @if($logo['url'] !== '')
                            <a href="{{ $logo['url'] }}" class="rj-lg-item" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $logo['image'] }}" alt="{{ $logo['name'] }}" loading="lazy">
                            </a>
                        @else
                            <div class="rj-lg-item">
                                <img src="{{ $logo['image'] }}" alt="{{ $logo['name'] }}" loading="lazy">
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="rj-lg-grid">
                    @foreach($logos as $logo)
                        @if($logo['url'] !== '')
                            <a href="{{ $logo['url'] }}" class="rj-lg-item" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $logo['image'] }}" alt="{{ $logo['name'] }}" loading="lazy">
                            </a>
                        @else
                            <div class="rj-lg-item">
                                <img src="{{ $logo['image'] }}" alt="{{ $logo['name'] }}" loading="lazy">
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @else
            <div class="rj-lg-empty">{{ __('Please add at least one logo.') }}</div>
        @endif
    </div>
</div>
