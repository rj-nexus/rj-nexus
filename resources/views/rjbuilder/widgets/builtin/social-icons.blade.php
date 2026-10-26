@php
    $layout = $settings['layout'] ?? 'horizontal';
    $align = $settings['align'] ?? 'center';
    $size = $settings['icon_size'] ?? 'md';
    $shape = $settings['shape'] ?? 'circle';
    $style = $settings['style'] ?? 'brand';
    $rawLinks = $settings['links'] ?? '';

    $alignClass = match($align) {
        'left' => 'justify-start',
        'right' => 'justify-end',
        default => 'justify-center',
    };

    $layoutClass = $layout === 'grid' ? 'grid grid-cols-4 sm:grid-cols-6 gap-4' : 'flex flex-wrap items-center gap-3 sm:gap-4';

    $sizeClass = match($size) {
        'sm' => 'w-9 h-9',
        'lg' => 'w-14 h-14',
        default => 'w-11 h-11',
    };

    $iconSize = match($size) {
        'sm' => 'w-4 h-4',
        'lg' => 'w-7 h-7',
        default => 'w-5 h-5',
    };

    $shapeClass = match($shape) {
        'square' => 'rounded-xl',
        'none' => 'rounded-none bg-transparent',
        default => 'rounded-full',
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
        $lines = explode("\n", $rawLinks);
        foreach ($lines as $line) {
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
    #{{ $uid }} .rj-social-item {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    #{{ $uid }} .rj-social-item:hover {
        transform: translateY(-5px) scale(1.05);
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
        #{{ $uid }} .rj-social-item img {
            filter: grayscale(100%) opacity(60%);
            transition: all 0.3s ease;
        }
        #{{ $uid }} .rj-social-item:hover img {
            filter: grayscale(0%) opacity(100%);
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
        #{{ $uid }} .rj-social-item img {
            filter: brightness(0) invert(1);
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
</style>

<div id="{{ $uid }}" class="w-full flex {{ $alignClass }}">
    <div class="{{ $layoutClass }}">
        @foreach($links as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
               class="rj-social-item {{ $sizeClass }} {{ $shapeClass }} flex items-center justify-center"
               style="--brand: {{ $link['color'] }};"
               title="{{ ucfirst($link['network']) }}">

                @if(isset($customIcons[$link['network']]))
                    <img src="{{ $customIcons[$link['network']] }}" class="{{ $iconSize }} object-contain" alt="{{ $link['network'] }}">
                @else
                    {!! rj_icon($stdIcons[$link['network']], $iconSize) !!}
                @endif

            </a>
        @endforeach
    </div>
</div>
