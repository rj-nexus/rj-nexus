@php
    $title      = $settings['title'] ?? '';
    $align      = $settings['align'] ?? 'left';
    $gap        = $settings['gap'] ?? 'md';
    $height     = (int) ($settings['height'] ?? 36);
    $colorMode  = $settings['color_mode'] ?? 'original';
    $titleColor = $settings['title_color'] ?? '#ffffff';

    $gapMap = ['sm' => '12px', 'md' => '20px', 'lg' => '32px'];
    $gapCss = $gapMap[$gap] ?? '20px';
    $justify = $align === 'center' ? 'center' : ($align === 'right' ? 'flex-end' : 'flex-start');
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
    }
    #{{ $uid }} .rj-fb-title {
        font-size: 16px;
        font-weight: 700;
        color: {{ $titleColor }};
        margin: 0 0 16px;
        letter-spacing: -.01em;
    }
    #{{ $uid }} .rj-fb-wrap {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: {{ $justify }};
        gap: {{ $gapCss }};
    }
    #{{ $uid }} .rj-fb-item {
        display: flex;
        align-items: center;
        justify-content: center;
        height: {{ $height }}px;
        text-decoration: none;
        transition: transform 0.2s ease;
    }
    #{{ $uid }} .rj-fb-item:hover {
        transform: scale(1.05);
    }
    #{{ $uid }} .rj-fb-img {
        height: 100%;
        width: auto;
        max-width: 120px;
        object-fit: contain;
        display: block;
        transition: filter 0.3s ease;
    }

    #{{ $uid }}[data-color="grayscale"] .rj-fb-img {
        filter: grayscale(100%) opacity(0.7);
    }
    #{{ $uid }}[data-color="grayscale"] .rj-fb-item:hover .rj-fb-img {
        filter: grayscale(0%) opacity(1);
    }

    #{{ $uid }}[data-color="white"] .rj-fb-img {
        filter: brightness(0) invert(1) opacity(0.8);
    }
    #{{ $uid }}[data-color="white"] .rj-fb-item:hover .rj-fb-img {
        filter: brightness(0) invert(1) opacity(1);
    }

    #{{ $uid }}[data-color="black"] .rj-fb-img {
        filter: brightness(0) opacity(0.8);
    }
    #{{ $uid }}[data-color="black"] .rj-fb-item:hover .rj-fb-img {
        filter: brightness(0) opacity(1);
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-fb-wrap {
            justify-content: center;
        }
    }
</style>

<div id="{{ $uid }}" data-color="{{ $colorMode }}">
    @if($title !== '')
        <h3 class="rj-fb-title">{{ $title }}</h3>
    @endif

    @if(!empty($items))
        <div class="rj-fb-wrap">
            @foreach($items as $item)
                @if($item['link'] !== '')
                    <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer" class="rj-fb-item" title="{{ $item['name'] }}">
                        <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="rj-fb-img" loading="lazy">
                    </a>
                @else
                    <div class="rj-fb-item" title="{{ $item['name'] }}">
                        <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="rj-fb-img" loading="lazy">
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
