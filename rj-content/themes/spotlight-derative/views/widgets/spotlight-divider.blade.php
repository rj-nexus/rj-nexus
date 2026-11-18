@php
    $uid = 'div_' . substr(md5(uniqid('', true)), 0, 8);

    $heightMap = [
        'sm' => '60px',
        'md' => '100px',
        'lg' => '160px',
        'xl' => '240px',
    ];
    $height = $heightMap[$settings['height'] ?? 'md'] ?? '100px';

    $textSizeMap = [
        'sm' => 'clamp(24px, 4vw, 40px)',
        'md' => 'clamp(40px, 6vw, 80px)',
        'lg' => 'clamp(60px, 10vw, 140px)',
    ];
    $fontSize = $textSizeMap[$settings['text_size'] ?? 'md'] ?? 'clamp(40px, 6vw, 80px)';

    $opacity = max(0, min(100, (int) ($settings['text_opacity'] ?? 5))) / 100;
    $text = $settings['text'] ?? 'loremipsum';
    $borderStyle = $settings['border_style'] ?? 'gradient';

    $repeatedText = str_repeat(e($text) . ' ', 40);
@endphp

<section class="rj-divider-section" id="{{ $uid }}" style="height: {{ $height }};">

    @if($borderStyle !== 'none')
        <div class="rj-divider-border rj-divider-top {{ $borderStyle }}"></div>
    @endif

    <div class="rj-divider-text-wrap">
        <div class="rj-divider-text" style="font-size: {{ $fontSize }}; opacity: {{ $opacity }};">
            {{ $repeatedText }}
        </div>
    </div>

    @if($borderStyle !== 'none')
        <div class="rj-divider-border rj-divider-bottom {{ $borderStyle }}"></div>
    @endif

    <style>
        #{{ $uid }}.rj-divider-section {
            position: relative;
            width: 100%;
            /* Arxa fonu şəffaf etdik */
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            isolation: isolate;
        }

        #{{ $uid }} .rj-divider-border {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: var(--rj-container);
            height: 1px;
            z-index: 2;
            pointer-events: none;
        }
        #{{ $uid }} .rj-divider-top { top: 0; }
        #{{ $uid }} .rj-divider-bottom { bottom: 0; }

        #{{ $uid }} .rj-divider-border.solid {
            background: var(--rj-border);
        }

        #{{ $uid }} .rj-divider-border.gradient {
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.1) 15%,
                color-mix(in srgb, var(--rj-primary) 30%, transparent) 50%,
                rgba(255, 255, 255, 0.1) 85%,
                transparent 100%
            );
        }

        #{{ $uid }} .rj-divider-text-wrap {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            user-select: none;
            pointer-events: none;
            z-index: 1;
        }

        #{{ $uid }} .rj-divider-text {
            font-family: var(--rj-font-heading);
            font-weight: 800;
            text-transform: uppercase;
            color: var(--rj-text);
            white-space: nowrap;
            letter-spacing: -0.02em;
            filter: blur(1px);
        }
    </style>
</section>
