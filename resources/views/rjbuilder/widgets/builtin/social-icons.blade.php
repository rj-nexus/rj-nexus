@php
    $layout = $settings['layout'] ?? 'horizontal';
    $align = $settings['align'] ?? 'center';
    $size = $settings['icon_size'] ?? 'md';
    $shape = $settings['shape'] ?? 'circle';
    $style = $settings['style'] ?? 'brand';
    $rawLinks = $settings['links'] ?? '';

    $justify = match($align) {
        'left' => 'flex-start',
        'right' => 'flex-end',
        default => 'center',
    };

    $box = match($size) {
        'sm' => '36px',
        'lg' => '56px',
        default => '44px',
    };

    $icon = match($size) {
        'sm' => '16px',
        'lg' => '28px',
        default => '20px',
    };

    $radius = match($shape) {
        'square' => '12px',
        'none' => '0',
        default => '9999px',
    };

    $customIcons = [
        'dehliz' => 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/social-media/dehliz/dehliz_icon.svg',
        'piokio' => 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/social-media/piokio/piokio_logo.svg',
        'cayvoy' => 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/monetization/cayvoy/cayvoy-icon.png',
        'kofe.al' => 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/monetization/kofe.al/kofe.al_icon.png',
    ];

    $stdIcons = [
        'facebook' => 'ph:facebook-logo-fill',
        'instagram' => 'ph:instagram-logo-fill',
        'twitter' => 'ph:x-logo-fill',
        'x' => 'ph:x-logo-fill',
        'linkedin' => 'ph:linkedin-logo-fill',
        'youtube' => 'ph:youtube-logo-fill',
        'tiktok' => 'ph:tiktok-logo-fill',
        'github' => 'ph:github-logo-fill',
        'telegram' => 'ph:telegram-logo-fill',
        'whatsapp' => 'ph:whatsapp-logo-fill',
    ];

    $brandColors = [
        'facebook' => '#1877F2',
        'instagram' => '#E4405F',
        'twitter' => '#000000',
        'x' => '#000000',
        'linkedin' => '#0A66C2',
        'youtube' => '#FF0000',
        'tiktok' => '#000000',
        'github' => '#181717',
        'telegram' => '#26A5E4',
        'whatsapp' => '#25D366',
        'dehliz' => '#0055FF',
        'piokio' => '#FF5722',
        'cayvoy' => '#008000',
        'kofe.al' => '#6F4E37',
    ];

    $links = [];
    if (!empty($rawLinks)) {
        foreach (explode("\n", $rawLinks) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $parts = explode('|', $line);
            if (count($parts) === 2) {
                $network = strtolower(trim($parts[0]));
                $url = trim($parts[1]);
                if (isset($stdIcons[$network]) || isset($customIcons[$network])) {
                    $links[] = [
                        'network' => $network,
                        'url' => $url,
                        'color' => $brandColors[$network] ?? '#6366f1',
                    ];
                }
            }
        }
    }
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        display: flex;
        justify-content: {{ $justify }};
    }
    #{{ $uid }} .rj-row {
        @if($layout === 'grid')
            display: grid;
            grid-template-columns: repeat(auto-fill, {{ $box }});
        @else
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        @endif
        justify-content: {{ $justify }};
        gap: 12px;
        width: 100%;
    }
    #{{ $uid }} .rj-social-item {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: {{ $box }};
        height: {{ $box }};
        border-radius: {{ $radius }};
        text-decoration: none;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), background-color .3s ease, border-color .3s ease, box-shadow .3s ease, filter .3s ease;
    }
    #{{ $uid }} .rj-social-item:hover {
        transform: translateY(-5px) scale(1.05);
    }
    #{{ $uid }} .rj-si,
    #{{ $uid }} .rj-social-item svg {
        display: block;
        flex-shrink: 0;
        width: {{ $icon }};
        height: {{ $icon }};
        max-width: {{ $icon }};
        max-height: {{ $icon }};
        object-fit: contain;
    }
    #{{ $uid }} .rj-mask {
        display: block;
        flex-shrink: 0;
        width: {{ $icon }};
        height: {{ $icon }};
        background-color: currentColor;
        -webkit-mask: var(--mask) no-repeat center / contain;
        mask: var(--mask) no-repeat center / contain;
    }

    @if($style === 'brand')
        #{{ $uid }} .rj-social-item {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        #{{ $uid }} .rj-social-item:hover {
            background-color: var(--brand);
            color: #ffffff;
            border-color: var(--brand);
            box-shadow: 0 10px 20px -5px var(--brand);
        }
    @elseif($style === 'monochrome')
        #{{ $uid }} .rj-social-item {
            background-color: #0f172a;
            color: #ffffff;
            border: 1px solid #0f172a;
        }
        #{{ $uid }} .rj-social-item:hover {
            background-color: #334155;
            border-color: #334155;
        }
    @else
        #{{ $uid }} .rj-social-item {
            background-color: var(--brand);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 10px -2px var(--brand);
        }
        #{{ $uid }} .rj-social-item:hover {
            filter: brightness(0.9);
            box-shadow: 0 12px 25px -5px var(--brand);
        }
    @endif

    @if($shape === 'none')
        #{{ $uid }} .rj-social-item,
        #{{ $uid }} .rj-social-item:hover {
            background-color: transparent;
            border-color: transparent;
            box-shadow: none;
        }
    @endif

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-social-item { transition: none; }
        #{{ $uid }} .rj-social-item:hover { transform: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-row">
        @foreach($links as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
               class="rj-social-item"
               style="--brand: {{ $link['color'] }};"
               title="{{ ucfirst($link['network']) }}">

                @if(isset($customIcons[$link['network']]))
                    <span class="rj-si rj-mask"
                          style="--mask: url('{{ $customIcons[$link['network']] }}');"
                          role="img"
                          aria-label="{{ $link['network'] }}"></span>
                @else
                    {!! rj_icon($stdIcons[$link['network']], 'rj-si') !!}
                @endif

            </a>
        @endforeach
    </div>
</div>
