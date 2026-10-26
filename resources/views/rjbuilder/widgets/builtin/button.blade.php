@php
    $text = $settings['text'] ?? '';
    $url = $settings['url'] ?? '#';
    $target = $settings['target'] ?? '_self';
    $icon = $settings['icon'] ?? '';
    $iconPos = $settings['icon_position'] ?? 'right';
    $style = $settings['style'] ?? 'solid';
    $size = $settings['size'] ?? 'md';
    $radius = $settings['border_radius'] ?? 'rounded-xl';
    $bgColor = $settings['bg_color'] ?? '#8b5cf6';
    $textColor = $settings['text_color'] ?? '#ffffff';
    $hoverBg = $settings['hover_bg_color'] ?? '#7c3aed';
    $hoverText = $settings['hover_text_color'] ?? '#ffffff';
    $animation = $settings['animation'] ?? 'hover-lift';
    $fullWidth = $settings['full_width'] ?? false;
    $align = $settings['align'] ?? 'left';

    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    $widthClass = $fullWidth ? 'w-full flex' : 'inline-flex';

    $sizeClass = match($size) {
        'sm' => 'px-4 py-2 text-xs',
        'lg' => 'px-8 py-4 text-base',
        'xl' => 'px-10 py-5 text-lg',
        default => 'px-6 py-3 text-sm',
    };

    $animClass = match($animation) {
        'hover-lift' => 'hover:-translate-y-1 hover:shadow-lg',
        'hover-glow' => 'hover:shadow-[0_0_20px_rgba(0,0,0,0.3)]',
        'hover-shine' => 'rj-btn-shine',
        'hover-slide' => 'group',
        default => '',
    };
@endphp

<style>
    #{{ $uid }} .rj-btn-base {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }

    @if($style === 'solid')
        #{{ $uid }} .rj-btn-base {
            background-color: {{ $bgColor }};
            color: {{ $textColor }};
            border: 2px solid transparent;
        }
        #{{ $uid }} .rj-btn-base:hover {
            background-color: {{ $hoverBg }};
            color: {{ $hoverText }};
            @if($animation === 'hover-glow')
                box-shadow: 0 0 25px {{ $hoverBg }}80;
            @endif
        }
    @elseif($style === 'outline')
        #{{ $uid }} .rj-btn-base {
            background-color: transparent;
            color: {{ $bgColor }};
            border: 2px solid {{ $bgColor }};
        }
        #{{ $uid }} .rj-btn-base:hover {
            background-color: {{ $hoverBg }};
            color: {{ $hoverText }};
            border-color: {{ $hoverBg }};
        }
    @elseif($style === 'ghost')
        #{{ $uid }} .rj-btn-base {
            background-color: transparent;
            color: {{ $bgColor }};
            border: 2px solid transparent;
        }
        #{{ $uid }} .rj-btn-base:hover {
            background-color: {{ $hoverBg }}15;
            color: {{ $hoverBg }};
        }
    @elseif($style === 'gradient')
        #{{ $uid }} .rj-btn-base {
            background: linear-gradient(135deg, {{ $bgColor }} 0%, {{ $hoverBg }} 100%);
            color: {{ $textColor }};
            border: none;
            background-size: 200% auto;
        }
        #{{ $uid }} .rj-btn-base:hover {
            background-position: right center;
            color: {{ $hoverText }};
        }
    @endif

    #{{ $uid }} .rj-btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: skewX(-20deg);
        transition: 0.5s;
    }
    #{{ $uid }} .rj-btn-shine:hover::after {
        left: 150%;
    }

    #{{ $uid }} .rj-btn-icon {
        transition: transform 0.3s ease;
    }
    #{{ $uid }} .group:hover .rj-btn-icon-right {
        transform: translateX(4px);
    }
    #{{ $uid }} .group:hover .rj-btn-icon-left {
        transform: translateX(-4px);
    }
</style>

<div id="{{ $uid }}" class="{{ $alignClass }}">
    <a href="{{ $url }}"
       target="{{ $target }}"
       class="rj-btn-base {{ $widthClass }} items-center justify-center gap-2 font-bold {{ $sizeClass }} {{ $radius }} {{ $animClass }}">

        @if($icon && $iconPos === 'left')
            <span class="rj-btn-icon rj-btn-icon-left flex-shrink-0">
                {!! rj_icon($icon, 'w-5 h-5') !!}
            </span>
        @endif

        <span>{{ $text }}</span>

        @if($icon && $iconPos === 'right')
            <span class="rj-btn-icon rj-btn-icon-right flex-shrink-0">
                {!! rj_icon($icon, 'w-5 h-5') !!}
            </span>
        @endif
    </a>
</div>
