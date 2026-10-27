@php
    $image        = $settings['image'] ?? '';
    $title        = $settings['title'] ?? '';
    $trigger      = $settings['trigger'] ?? 'hover';
    $dotSize      = $settings['dot_size'] ?? 'md';
    $dotColor     = $settings['dot_color'] ?? '#ef4444';
    $dotStyle     = $settings['dot_style'] ?? 'ping';
    $tooltipTheme = $settings['tooltip_theme'] ?? 'dark';
    $radius       = $settings['radius'] ?? 'xl';
    $paddingY     = (int) ($settings['padding_y'] ?? 40);

    $radiusMap = ['none' => '0px', 'md' => '10px', 'xl' => '18px', '2xl' => '26px'];
    $radiusCss = $radiusMap[$radius] ?? '18px';

    $dotSizeMap = ['sm' => 12, 'md' => 16, 'lg' => 22];
    $dotPx      = $dotSizeMap[$dotSize] ?? 16;

    $spots = [];
    if (!empty($settings['hotspots']) && is_array($settings['hotspots'])) {
        foreach ($settings['hotspots'] as $row) {
            if (!is_array($row)) continue;
            if (!isset($row['x'], $row['y'])) continue;
            $x = (float) $row['x'];
            $y = (float) $row['y'];
            if ($x < 0) $x = 0; if ($x > 100) $x = 100;
            if ($y < 0) $y = 0; if ($y > 100) $y = 100;
            $spots[] = [
                'x'     => $x,
                'y'     => $y,
                'title' => $row['title'] ?? '',
                'desc'  => $row['desc'] ?? '',
                'image' => $row['image'] ?? '',
                'link'  => $row['link'] ?? '',
            ];
        }
    }
@endphp

@once
<style>
    @keyframes rjHsPing {
        0%   { transform: scale(1); opacity: .6; }
        80%, 100% { transform: scale(2.4); opacity: 0; }
    }
    @keyframes rjHsRing {
        0%   { box-shadow: 0 0 0 0 var(--hs-color); }
        70%  { box-shadow: 0 0 0 14px rgba(0,0,0,0); }
        100% { box-shadow: 0 0 0 0 rgba(0,0,0,0); }
    }
    @keyframes rjHsBounce {
        0%, 100% { transform: translate(-50%, -50%) scale(1); }
        50%      { transform: translate(-50%, -50%) scale(1.25); }
    }
    @keyframes rjHsFade {
        from { opacity: 0; transform: translateY(6px) scale(.95); }
        to   { opacity: 1; transform: none; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --hs-color: {{ $dotColor }};
        --hs-dot: {{ $dotPx }}px;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-hs-inner {
        max-width: 1100px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-hs-title {
        text-align: center;
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        margin: 0 0 24px;
    }
    #{{ $uid }} .rj-hs-stage {
        position: relative;
        width: 100%;
        border-radius: {{ $radiusCss }};
        overflow: visible;
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.35);
    }
    #{{ $uid }} .rj-hs-img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: {{ $radiusCss }};
        user-select: none;
    }
    #{{ $uid }} .rj-hs-empty {
        padding: 40px;
        text-align: center;
        color: #94a3b8;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: {{ $radiusCss }};
        font-size: 13px;
    }

    #{{ $uid }} .rj-hs-spot {
        position: absolute;
        transform: translate(-50%, -50%);
        z-index: 5;
    }

    #{{ $uid }} .rj-hs-dot {
        position: relative;
        width: var(--hs-dot);
        height: var(--hs-dot);
        border-radius: 50%;
        background: var(--hs-color);
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 4px 14px -2px color-mix(in srgb, var(--hs-color) 60%, transparent);
        display: block;
        transition: transform .25s ease;
    }
    #{{ $uid }} .rj-hs-spot:hover .rj-hs-dot,
    #{{ $uid }} .rj-hs-spot:focus-visible .rj-hs-dot {
        transform: scale(1.15);
    }

    #{{ $uid }}[data-dot="ping"] .rj-hs-dot::before,
    #{{ $uid }}[data-dot="ping"] .rj-hs-dot::after {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 50%;
        background: var(--hs-color);
        opacity: .55;
        z-index: -1;
        animation: rjHsPing 2s cubic-bezier(0, 0, .2, 1) infinite;
    }
    #{{ $uid }}[data-dot="ping"] .rj-hs-dot::after {
        animation-delay: 1s;
    }

    #{{ $uid }}[data-dot="ring"] .rj-hs-dot {
        animation: rjHsRing 2s ease-out infinite;
    }

    #{{ $uid }}[data-dot="bounce"] .rj-hs-dot {
        animation: rjHsBounce 2s ease-in-out infinite;
        transform-origin: center;
    }
    #{{ $uid }}[data-dot="bounce"] .rj-hs-spot:hover .rj-hs-dot,
    #{{ $uid }}[data-dot="bounce"] .rj-hs-spot:focus-visible .rj-hs-dot {
        animation-play-state: paused;
    }

    #{{ $uid }} .rj-hs-tip {
        position: absolute;
        bottom: calc(100% + 14px);
        left: 50%;
        transform: translateX(-50%) translateY(6px);
        min-width: 200px;
        max-width: 260px;
        padding: 14px 16px;
        border-radius: 12px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease, transform .3s cubic-bezier(.34,1.56,.64,1);
        z-index: 20;
        box-shadow: 0 20px 40px -16px rgba(15,23,42,.5);
    }
    #{{ $uid }} .rj-hs-tip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-top-color: inherit;
        margin-top: -1px;
    }

    #{{ $uid }} .rj-hs-spot:hover .rj-hs-tip,
    #{{ $uid }} .rj-hs-spot:focus-visible .rj-hs-tip,
    #{{ $uid }} .rj-hs-spot.is-open .rj-hs-tip {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(-50%) translateY(0);
    }

    #{{ $uid }}[data-tip="dark"] .rj-hs-tip {
        background: #0f172a;
        color: #f1f5f9;
        border-top-color: #0f172a;
    }
    #{{ $uid }}[data-tip="light"] .rj-hs-tip {
        background: #fff;
        color: #0f172a;
        border: 1px solid #e5e7eb;
        border-top-color: #fff;
    }
    #{{ $uid }}[data-tip="light"] .rj-hs-tip::after {
        border-top-color: #fff;
        filter: drop-shadow(0 1px 0 #e5e7eb);
    }
    #{{ $uid }}[data-tip="accent"] .rj-hs-tip {
        background: var(--hs-color);
        color: #fff;
        border-top-color: var(--hs-color);
    }

    #{{ $uid }} .rj-hs-tip-img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
        display: block;
    }
    #{{ $uid }} .rj-hs-tip-title {
        font-size: 14px;
        font-weight: 800;
        margin: 0 0 4px;
        line-height: 1.3;
    }
    #{{ $uid }} .rj-hs-tip-desc {
        font-size: 12px;
        line-height: 1.5;
        margin: 0;
        opacity: .85;
    }
    #{{ $uid }} .rj-hs-tip-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 10px;
        font-size: 11.5px;
        font-weight: 700;
        color: inherit;
        text-decoration: underline;
        opacity: .9;
    }
    #{{ $uid }}[data-tip="dark"] .rj-hs-tip-link { color: #a5b4fc; }
    #{{ $uid }}[data-tip="light"] .rj-hs-tip-link { color: var(--hs-color); }
    #{{ $uid }}[data-tip="accent"] .rj-hs-tip-link { color: #fff; }

    /* Smart: flip tooltip below if near top */
    #{{ $uid }} .rj-hs-spot.flip-down .rj-hs-tip {
        bottom: auto;
        top: calc(100% + 14px);
        transform: translateX(-50%) translateY(-6px);
    }
    #{{ $uid }} .rj-hs-spot.flip-down .rj-hs-tip::after {
        top: auto;
        bottom: 100%;
        border-top-color: transparent;
        border-bottom-color: inherit;
        margin-top: 0;
        margin-bottom: -1px;
    }
    #{{ $uid }}[data-tip="light"] .rj-hs-spot.flip-down .rj-hs-tip::after {
        border-bottom-color: #fff;
    }
    #{{ $uid }} .rj-hs-spot.flip-down:hover .rj-hs-tip,
    #{{ $uid }} .rj-hs-spot.flip-down.is-open .rj-hs-tip {
        transform: translateX(-50%) translateY(0);
    }

    /* Smart: left/right edge nudge */
    #{{ $uid }} .rj-hs-spot.align-left .rj-hs-tip {
        left: 0;
        transform: translateX(-20%) translateY(6px);
    }
    #{{ $uid }} .rj-hs-spot.align-left:hover .rj-hs-tip,
    #{{ $uid }} .rj-hs-spot.align-left.is-open .rj-hs-tip {
        transform: translateX(-20%) translateY(0);
    }
    #{{ $uid }} .rj-hs-spot.align-left .rj-hs-tip::after {
        left: 20%;
    }
    #{{ $uid }} .rj-hs-spot.align-right .rj-hs-tip {
        left: auto;
        right: 0;
        transform: translateX(20%) translateY(6px);
    }
    #{{ $uid }} .rj-hs-spot.align-right:hover .rj-hs-tip,
    #{{ $uid }} .rj-hs-spot.align-right.is-open .rj-hs-tip {
        transform: translateX(20%) translateY(0);
    }
    #{{ $uid }} .rj-hs-spot.align-right .rj-hs-tip::after {
        left: auto;
        right: 20%;
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

<div id="{{ $uid }}" data-dot="{{ $dotStyle }}" data-tip="{{ $tooltipTheme }}" data-trigger="{{ $trigger }}">
    <div class="rj-hs-inner">
        @if($title !== '')
            <h2 class="rj-hs-title">{{ $title }}</h2>
        @endif

        @if($image !== '' && !empty($spots))
            <div class="rj-hs-stage">
                <img src="{{ $image }}" alt="{{ $title }}" class="rj-hs-img" draggable="false" loading="lazy">

                @foreach($spots as $i => $spot)
                    @php
                        $flipDown = $spot['y'] < 30 ? 'flip-down' : '';
                        $alignX   = '';
                        if ($spot['x'] < 15) $alignX = 'align-left';
                        elseif ($spot['x'] > 85) $alignX = 'align-right';
                    @endphp
                    <div class="rj-hs-spot {{ $flipDown }} {{ $alignX }}"
                         style="left: {{ $spot['x'] }}%; top: {{ $spot['y'] }}%;"
                         tabindex="0"
                         data-trigger="{{ $trigger }}">
                        <span class="rj-hs-dot" aria-label="{{ $spot['title'] ?: __('Hotspot') }}"></span>
                        <div class="rj-hs-tip" role="tooltip">
                            @if($spot['image'] !== '')
                                <img src="{{ $spot['image'] }}" alt="" class="rj-hs-tip-img" loading="lazy">
                            @endif
                            @if($spot['title'] !== '')
                                <h4 class="rj-hs-tip-title">{{ $spot['title'] }}</h4>
                            @endif
                            @if($spot['desc'] !== '')
                                <p class="rj-hs-tip-desc">{{ $spot['desc'] }}</p>
                            @endif
                            @if($spot['link'] !== '')
                                <a href="{{ $spot['link'] }}" class="rj-hs-tip-link">
                                    <span>{{ __('View more') }}</span>
                                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($image !== '' && empty($spots))
            <div class="rj-hs-empty">{{ __('Please add at least one hotspot.') }}</div>
        @else
            <div class="rj-hs-empty">{{ __('Please select a background image.') }}</div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var trigger = root.getAttribute('data-trigger') || 'hover';
    if (trigger === 'hover') return;

    var spots = root.querySelectorAll('.rj-hs-spot');

    function closeAll(except) {
        spots.forEach(function (s) {
            if (s !== except) s.classList.remove('is-open');
        });
    }

    spots.forEach(function (spot) {
        spot.addEventListener('click', function (e) {
            if (e.target.closest('.rj-hs-tip-link')) return;
            var wasOpen = spot.classList.contains('is-open');
            closeAll();
            if (!wasOpen) spot.classList.add('is-open');
        });
        spot.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                spot.click();
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!root.contains(e.target)) closeAll();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });
})();
</script>
