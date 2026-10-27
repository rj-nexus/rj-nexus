@php
    $image        = $settings['image'] ?? '';
    $title        = $settings['title'] ?? '';
    $trigger      = in_array($settings['trigger'] ?? 'hover', ['hover', 'click'], true) ? $settings['trigger'] : 'hover';
    $dotSize      = $settings['dot_size'] ?? 'md';
    $dotStyle     = in_array($settings['dot_style'] ?? 'ping', ['ping', 'ring', 'bounce'], true) ? $settings['dot_style'] : 'ping';
    $tooltipTheme = in_array($settings['tooltip_theme'] ?? 'dark', ['dark', 'light', 'accent'], true) ? $settings['tooltip_theme'] : 'dark';
    $radius       = $settings['radius'] ?? 'xl';
    $paddingY     = max(0, min(240, (int) ($settings['padding_y'] ?? 40)));

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $dotColor = $hexOk($settings['dot_color'] ?? '', '#ef4444');

    $radiusMap = ['none' => '0px', 'md' => '10px', 'xl' => '18px', '2xl' => '26px'];
    $radiusCss = $radiusMap[$radius] ?? '18px';

    $dotPx = ['sm' => 12, 'md' => 16, 'lg' => 22][$dotSize] ?? 16;

    $spots = [];
    if (!empty($settings['hotspots']) && is_array($settings['hotspots'])) {
        foreach ($settings['hotspots'] as $row) {
            if (!is_array($row) || !isset($row['x'], $row['y'])) {
                continue;
            }
            $x = max(0, min(100, (float) $row['x']));
            $y = max(0, min(100, (float) $row['y']));

            $link = trim((string) ($row['link'] ?? ''));
            if ($link !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $link)) {
                $link = '';
            }

            $spots[] = [
                'x'     => $x,
                'y'     => $y,
                'title' => trim((string) ($row['title'] ?? '')),
                'desc'  => trim((string) ($row['desc'] ?? '')),
                'image' => trim((string) ($row['image'] ?? '')),
                'link'  => $link,
                'flip'  => $y < 30 ? 'flip-down' : '',
                'align' => $x < 15 ? 'align-left' : ($x > 85 ? 'align-right' : ''),
            ];
        }
    }
@endphp

@once
<style>
    @keyframes rjHsIn {
        from { opacity: 0; transform: translateY(24px) scale(.98); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjHsPop {
        0%   { opacity: 0; transform: translate(-50%, -50%) scale(.2); }
        100% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
    }
    @keyframes rjHsWave {
        0%   { transform: scale(1); opacity: .7; }
        100% { transform: scale(2.6); opacity: 0; }
    }
    @keyframes rjHsBounce {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-6px); }
    }
    @keyframes rjHsSheen {
        0%   { background-position: 150% 0; }
        100% { background-position: -50% 0; }
    }
    @keyframes rjHsShimmer {
        0%   { background-position: 0% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes rjHsHint {
        0%, 100% { transform: translate(-50%, 0); }
        50%      { transform: translate(-50%, -4px); }
    }
    @keyframes rjHsFadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: none; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --hs-color: {{ $dotColor }};
        --hs-dot: {{ $dotPx }}px;
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }}[data-tip="dark"] {
        --tip-bg: #0f172a;
        --tip-fg: #f1f5f9;
        --tip-border: rgba(255, 255, 255, .08);
        --tip-link: #a5b4fc;
    }
    #{{ $uid }}[data-tip="light"] {
        --tip-bg: #ffffff;
        --tip-fg: #0f172a;
        --tip-border: #e5e7eb;
        --tip-link: var(--hs-color);
    }
    #{{ $uid }}[data-tip="accent"] {
        --tip-bg: var(--hs-color);
        --tip-fg: #ffffff;
        --tip-border: transparent;
        --tip-link: #ffffff;
    }

    #{{ $uid }} .rj-hs-inner { max-width: 1100px; margin: 0 auto; }

    #{{ $uid }} .rj-hs-title {
        margin: 0 0 28px;
        text-align: center;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.02em;
        color: #0f172a;
        animation: rjHsFadeUp .8s cubic-bezier(.2,.8,.2,1) both;
    }
    @media (min-width: 768px) { #{{ $uid }} .rj-hs-title { font-size: 38px; } }
    #{{ $uid }} .rj-hs-title::after {
        content: "";
        display: block;
        width: 56px;
        height: 4px;
        margin: 12px auto 0;
        border-radius: 4px;
        background: linear-gradient(90deg, var(--hs-color), #a78bfa, var(--hs-color));
        background-size: 200% 100%;
        animation: rjHsShimmer 3s linear infinite;
    }

    #{{ $uid }} .rj-hs-wrap { animation: rjHsIn .9s cubic-bezier(.2,.8,.2,1) .1s both; }

    #{{ $uid }} .rj-hs-stage {
        --rx: 0deg;
        --ry: 0deg;
        position: relative;
        width: 100%;
        border-radius: {{ $radiusCss }};
        transform: perspective(1400px) rotateX(var(--rx)) rotateY(var(--ry));
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
        box-shadow: 0 30px 60px -28px rgba(15, 23, 42, .45);
    }
    #{{ $uid }} .rj-hs-stage::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 4;
        border-radius: {{ $radiusCss }};
        pointer-events: none;
        background: linear-gradient(115deg, transparent 40%, rgba(255,255,255,.22) 50%, transparent 60%);
        background-size: 250% 100%;
        animation: rjHsSheen 6s ease-in-out infinite;
    }
    #{{ $uid }} .rj-hs-img {
        display: block;
        width: 100%;
        height: auto;
        border-radius: {{ $radiusCss }};
        user-select: none;
    }

    #{{ $uid }} .rj-hs-empty {
        padding: 40px;
        text-align: center;
        font-size: 13px;
        color: #94a3b8;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: {{ $radiusCss }};
    }

    /* Hint pill */
    #{{ $uid }} .rj-hs-hint {
        position: absolute;
        left: 50%;
        bottom: 16px;
        z-index: 6;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .85);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        transform: translate(-50%, 0);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        animation: rjHsHint 2.4s ease-in-out infinite;
        transition: opacity .4s ease;
        pointer-events: none;
    }
    #{{ $uid }}.is-touched .rj-hs-hint { opacity: 0; }

    /* Spot */
    #{{ $uid }} .rj-hs-spot {
        position: absolute;
        z-index: 5;
        transform: translate(-50%, -50%);
        outline: none;
        animation: rjHsPop .7s cubic-bezier(.34,1.56,.64,1) both;
        animation-delay: calc(.4s + var(--i, 0) * .12s);
    }
    #{{ $uid }} .rj-hs-spot:hover,
    #{{ $uid }} .rj-hs-spot.is-open,
    #{{ $uid }} .rj-hs-spot:focus-visible { z-index: 30; }

    /* Halo waves (behind dot) */
    #{{ $uid }} .rj-hs-halo {
        position: absolute;
        inset: 0;
        z-index: -1;
        border-radius: 50%;
        background: var(--hs-color);
        pointer-events: none;
        opacity: 0;
    }
    #{{ $uid }}[data-dot="ping"] .rj-hs-halo {
        animation: rjHsWave 2s cubic-bezier(0,0,.2,1) infinite;
    }
    #{{ $uid }}[data-dot="ping"] .rj-hs-halo.b { animation-delay: 1s; }
    #{{ $uid }}[data-dot="ring"] .rj-hs-halo {
        background: transparent;
        border: 2px solid var(--hs-color);
        animation: rjHsWave 2s ease-out infinite;
    }
    #{{ $uid }}[data-dot="ring"] .rj-hs-halo.b { animation-delay: 1s; }

    /* Dot */
    #{{ $uid }} .rj-hs-dot {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: var(--hs-dot);
        height: var(--hs-dot);
        border-radius: 50%;
        background: var(--hs-color);
        border: 2px solid #fff;
        box-shadow: 0 6px 16px -4px color-mix(in srgb, var(--hs-color) 70%, transparent);
        cursor: pointer;
        transition: transform .35s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }}[data-dot="bounce"] .rj-hs-dot { animation: rjHsBounce 1.8s ease-in-out infinite; }
    #{{ $uid }}[data-dot="bounce"] .rj-hs-spot:hover .rj-hs-dot { animation-play-state: paused; }
    #{{ $uid }} .rj-hs-spot:hover .rj-hs-dot,
    #{{ $uid }} .rj-hs-spot:focus-visible .rj-hs-dot,
    #{{ $uid }} .rj-hs-spot.is-open .rj-hs-dot { transform: scale(1.18); }

    /* Plus icon that turns into × when open */
    #{{ $uid }} .rj-hs-plus {
        position: relative;
        width: calc(var(--hs-dot) * .42);
        height: calc(var(--hs-dot) * .42);
        transition: transform .45s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .rj-hs-plus::before,
    #{{ $uid }} .rj-hs-plus::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 100%;
        height: 2px;
        border-radius: 2px;
        background: #fff;
        transform: translate(-50%, -50%);
    }
    #{{ $uid }} .rj-hs-plus::after { transform: translate(-50%, -50%) rotate(90deg); }
    #{{ $uid }} .rj-hs-spot:hover .rj-hs-plus,
    #{{ $uid }} .rj-hs-spot.is-open .rj-hs-plus { transform: rotate(45deg); }

    /* Tooltip */
    #{{ $uid }} .rj-hs-tip {
        --tx: -50%;
        --ty: 10px;
        --ts: .92;
        --ax: 50%;
        position: absolute;
        bottom: calc(100% + 16px);
        left: 0;
        width: max-content;
        min-width: 200px;
        max-width: 260px;
        padding: 14px 16px;
        border-radius: 14px;
        background: var(--tip-bg);
        color: var(--tip-fg);
        border: 1px solid var(--tip-border);
        box-shadow: 0 24px 48px -18px rgba(15, 23, 42, .5);
        text-align: left;
        opacity: 0;
        visibility: hidden;
        filter: blur(4px);
        pointer-events: none;
        transform: translate(var(--tx), var(--ty)) scale(var(--ts));
        transition: opacity .3s ease, transform .45s cubic-bezier(.34,1.56,.64,1), filter .3s ease, visibility .3s;
    }
    #{{ $uid }} .rj-hs-tip::after {
        content: "";
        position: absolute;
        top: 100%;
        left: var(--ax);
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-top-color: var(--tip-bg);
    }

    /* Flip below when near the top */
    #{{ $uid }} .rj-hs-spot.flip-down .rj-hs-tip {
        bottom: auto;
        top: calc(100% + 16px);
        --ty: -10px;
    }
    #{{ $uid }} .rj-hs-spot.flip-down .rj-hs-tip::after {
        top: auto;
        bottom: 100%;
        border-top-color: transparent;
        border-bottom-color: var(--tip-bg);
    }

    /* Keep tooltip inside the stage at the edges */
    #{{ $uid }} .rj-hs-spot.align-left .rj-hs-tip { --tx: 0; --ax: 24px; }
    #{{ $uid }} .rj-hs-spot.align-right .rj-hs-tip { --tx: -100%; --ax: calc(100% - 24px); }

    /* Open states (last, so they win) */
    #{{ $uid }} .rj-hs-spot.is-open .rj-hs-tip,
    #{{ $uid }} .rj-hs-spot:focus-visible .rj-hs-tip,
    #{{ $uid }}[data-trigger="hover"] .rj-hs-spot:hover .rj-hs-tip {
        --ty: 0;
        --ts: 1;
        opacity: 1;
        visibility: visible;
        filter: blur(0);
        pointer-events: auto;
    }

    #{{ $uid }} .rj-hs-tip-img {
        display: block;
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    #{{ $uid }} .rj-hs-tip-title {
        margin: 0 0 4px;
        font-size: 14px;
        font-weight: 800;
        line-height: 1.3;
        color: inherit;
    }
    #{{ $uid }} .rj-hs-tip-desc {
        margin: 0;
        font-size: 12.5px;
        line-height: 1.55;
        opacity: .85;
    }
    #{{ $uid }} .rj-hs-tip-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        font-size: 12px;
        font-weight: 700;
        color: var(--tip-link);
        text-decoration: none;
    }
    #{{ $uid }} .rj-hs-tip-link svg { transition: transform .3s ease; }
    #{{ $uid }} .rj-hs-tip-link:hover svg { transform: translateX(3px); }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-hs-tip { min-width: 180px; max-width: 210px; padding: 12px 14px; }
        #{{ $uid }} .rj-hs-tip-img { height: 90px; }
        #{{ $uid }} .rj-hs-hint { font-size: 11px; padding: 6px 12px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-hs-halo { display: none; }
        #{{ $uid }} .rj-hs-spot,
        #{{ $uid }} .rj-hs-wrap,
        #{{ $uid }} .rj-hs-title { opacity: 1; }
    }
</style>

<div id="{{ $uid }}" data-dot="{{ $dotStyle }}" data-tip="{{ $tooltipTheme }}" data-trigger="{{ $trigger }}">
    <div class="rj-hs-inner">
        @if($title !== '')
            <h2 class="rj-hs-title">{{ $title }}</h2>
        @endif

        @if($image !== '')
            <div class="rj-hs-wrap">
                <div class="rj-hs-stage">
                    <img src="{{ $image }}" alt="{{ $title }}" class="rj-hs-img" draggable="false" loading="lazy">

                    @foreach($spots as $i => $spot)
                        <div class="rj-hs-spot {{ $spot['flip'] }} {{ $spot['align'] }}"
                             style="left: {{ $spot['x'] }}%; top: {{ $spot['y'] }}%; --i: {{ $i }};"
                             role="button"
                             tabindex="0"
                             aria-expanded="false"
                             aria-label="{{ $spot['title'] !== '' ? $spot['title'] : __('Hotspot') }}">
                            <span class="rj-hs-halo"></span>
                            <span class="rj-hs-halo b"></span>
                            <span class="rj-hs-dot"><span class="rj-hs-plus"></span></span>

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

                    @if(!empty($spots))
                        <span class="rj-hs-hint">{{ __('Explore the points') }}</span>
                    @endif
                </div>
            </div>
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
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var stage = root.querySelector('.rj-hs-stage');
    var spots = [].slice.call(root.querySelectorAll('.rj-hs-spot'));
    var lastPointer = 'mouse';

    function setOpen(spot, open) {
        spot.classList.toggle('is-open', open);
        spot.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function closeAll(except) {
        spots.forEach(function (s) {
            if (s !== except) setOpen(s, false);
        });
    }

    function toggle(spot) {
        var open = !spot.classList.contains('is-open');
        closeAll(spot);
        setOpen(spot, open);
        root.classList.add('is-touched');
    }

    spots.forEach(function (spot) {
        spot.addEventListener('pointerdown', function (e) {
            lastPointer = e.pointerType || 'mouse';
        });

        spot.addEventListener('click', function (e) {
            if (e.target.closest('a')) return;
            // In hover mode, mouse users get the hover tooltip; click only for touch/pen
            if (trigger === 'hover' && lastPointer === 'mouse') return;
            toggle(spot);
        });

        spot.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggle(spot);
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!root.contains(e.target)) closeAll();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAll();
    });

    // Subtle 3D tilt that follows the cursor
    if (stage && !reduce && window.matchMedia('(hover: hover)').matches) {
        stage.addEventListener('mousemove', function (e) {
            var r = stage.getBoundingClientRect();
            var px = (e.clientX - r.left) / r.width - 0.5;
            var py = (e.clientY - r.top) / r.height - 0.5;
            stage.style.setProperty('--rx', (-py * 6).toFixed(2) + 'deg');
            stage.style.setProperty('--ry', (px * 8).toFixed(2) + 'deg');
        });
        stage.addEventListener('mouseleave', function () {
            stage.style.setProperty('--rx', '0deg');
            stage.style.setProperty('--ry', '0deg');
        });
    }
})();
</script>
