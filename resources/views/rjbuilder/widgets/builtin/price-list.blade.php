@php
    $subtitle    = $settings['subtitle'] ?? '';
    $title       = $settings['title'] ?? __('Our Menu');
    $desc        = $settings['desc'] ?? '';
    $imageShape  = $settings['image_shape'] ?? 'circle';
    $showLeaders = $settings['show_leaders'] ?? true;
    $leaderStyle = $settings['leader_style'] ?? 'dotted';
    $hoverSpin   = $settings['hover_spin'] ?? true;
    $accent      = $settings['accent'] ?? '#8b5cf6';
    $textColor   = $settings['text_color'] ?? '#0f172a';
    $columns     = (int) ($settings['columns'] ?? 1);
    $paddingY    = (int) ($settings['padding_y'] ?? 60);

    $items = [];
    if (!empty($settings['items']) && is_array($settings['items'])) {
        foreach ($settings['items'] as $row) {
            if (!is_array($row)) continue;
            if (empty($row['title']) && empty($row['price'])) continue;
            $items[] = [
                'title' => $row['title'] ?? '',
                'desc'  => $row['desc'] ?? '',
                'price' => $row['price'] ?? '',
                'icon'  => $row['icon'] ?? '',
                'image' => $row['image'] ?? '',
                'badge' => $row['badge'] ?? '',
            ];
        }
    }

    $shapeMap = [
        'circle'  => '9999px',
        'rounded' => '14px',
        'square'  => '0px',
    ];
    $shapeCss = $shapeMap[$imageShape] ?? '9999px';

    $leaderBorder = 'dotted';
    if ($leaderStyle === 'dashed') $leaderBorder = 'dashed';
    elseif ($leaderStyle === 'solid') $leaderBorder = 'solid';

    $iconUrl = function (string $name): string {
        if ($name === '') return '';
        $url = str_replace(':', '/', $name);
        return 'https://api.iconify.design/' . $url . '.svg';
    };
@endphp

<style>
    #{{ $uid }} {
        --pl-accent: {{ $accent }};
        --pl-text: {{ $textColor }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-pl-inner {
        max-width: 960px;
        margin: 0 auto;
    }

    #{{ $uid }} .rj-pl-head {
        text-align: center;
        margin-bottom: 36px;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-pl-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--pl-accent);
        margin: 0 0 10px;
    }
    #{{ $uid }} .rj-pl-title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: var(--pl-text);
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-pl-title { font-size: 42px; }
    }
    #{{ $uid }} .rj-pl-desc {
        font-size: 14px;
        color: #64748b;
        margin: 12px 0 0;
        line-height: 1.65;
    }

    #{{ $uid }} .rj-pl-list {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: 8px {{ $columns > 1 ? '32px' : '0px' }};
    }
    @media (max-width: 720px) {
        #{{ $uid }} .rj-pl-list { grid-template-columns: 1fr; gap: 8px; }
    }

    #{{ $uid }} .rj-pl-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 12px 10px;
        border-radius: 12px;
        transition: background .25s ease;
    }
    #{{ $uid }} .rj-pl-item:hover {
        background: color-mix(in srgb, var(--pl-accent) 6%, transparent);
    }

    #{{ $uid }} .rj-pl-media {
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: {{ $shapeCss }};
        background: color-mix(in srgb, var(--pl-accent) 12%, transparent);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: transform .6s cubic-bezier(.34,1.56,.64,1), background .3s ease;
        @if($hoverSpin)
        transform-origin: center;
        @endif
    }
    #{{ $uid }} .rj-pl-item:hover .rj-pl-media {
        background: color-mix(in srgb, var(--pl-accent) 22%, transparent);
        @if($hoverSpin)
        transform: rotate(360deg);
        @endif
    }
    #{{ $uid }} .rj-pl-media img.rj-pl-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    #{{ $uid }} .rj-pl-media img.rj-pl-icon {
        width: 22px;
        height: 22px;
        object-fit: contain;
        display: block;
        opacity: .85;
    }
    #{{ $uid }} .rj-pl-media-empty {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
    }

    #{{ $uid }} .rj-pl-body {
        flex: 1;
        min-width: 0;
        padding-top: 2px;
    }
    #{{ $uid }} .rj-pl-row {
        display: flex;
        align-items: baseline;
        gap: 10px;
        min-width: 0;
    }
    #{{ $uid }} .rj-pl-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--pl-text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        max-width: 68%;
    }
    #{{ $uid }} .rj-pl-name-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #{{ $uid }} .rj-pl-badge {
        font-size: 9.5px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #fff;
        background: var(--pl-accent);
        padding: 2px 6px;
        border-radius: 4px;
        flex-shrink: 0;
        line-height: 1.3;
    }
    #{{ $uid }} .rj-pl-leader {
        flex: 1;
        height: 1px;
        border-bottom: 2px {{ $leaderBorder }} color-mix(in srgb, var(--pl-text) 22%, transparent);
        margin-bottom: 4px;
        min-width: 20px;
        align-self: flex-end;
    }
    #{{ $uid }} .rj-pl-price {
        font-size: 15px;
        font-weight: 800;
        color: var(--pl-accent);
        white-space: nowrap;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-pl-item-desc {
        font-size: 12.5px;
        color: #64748b;
        margin: 5px 0 0;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    #{{ $uid }} .rj-pl-empty {
        max-width: 560px;
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

<div id="{{ $uid }}">
    <div class="rj-pl-inner">
        @if($title || $subtitle || $desc)
            <header class="rj-pl-head">
                @if($subtitle)
                    <p class="rj-pl-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-pl-title">{{ $title }}</h2>
                @endif
                @if($desc)
                    <p class="rj-pl-desc">{{ $desc }}</p>
                @endif
            </header>
        @endif

        @if(!empty($items))
            <div class="rj-pl-list">
                @foreach($items as $it)
                    <div class="rj-pl-item">
                        @if($it['image'] !== '')
                            <div class="rj-pl-media">
                                <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}" class="rj-pl-img" loading="lazy">
                            </div>
                        @elseif($it['icon'] !== '')
                            <div class="rj-pl-media">
                                <img src="{{ $iconUrl($it['icon']) }}?color=%23{{ ltrim($accent, '#') }}" alt="" class="rj-pl-icon" loading="lazy">
                            </div>
                        @else
                            <div class="rj-pl-media-empty"></div>
                        @endif

                        <div class="rj-pl-body">
                            <div class="rj-pl-row">
                                <div class="rj-pl-name">
                                    <span class="rj-pl-name-text">{{ $it['title'] }}</span>
                                    @if($it['badge'] !== '')
                                        <span class="rj-pl-badge">{{ $it['badge'] }}</span>
                                    @endif
                                </div>
                                @if($showLeaders)
                                    <span class="rj-pl-leader" aria-hidden="true"></span>
                                @endif
                                @if($it['price'] !== '')
                                    <span class="rj-pl-price">{{ $it['price'] }}</span>
                                @endif
                            </div>
                            @if($it['desc'] !== '')
                                <p class="rj-pl-item-desc">{{ $it['desc'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rj-pl-empty">{{ __('Please add at least one menu item.') }}</div>
        @endif
    </div>
</div>
