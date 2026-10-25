@php
    $circles = $opts['layout'] === 'circles';
    $iconOk = function_exists('rj_icon');
    $cols = $opts['cols'];
@endphp

<style>
    @keyframes rjpShine-{{ $uid }} {
        0% { transform: translateX(-150%) skewX(-20deg); }
        100% { transform: translateX(150%) skewX(-20deg); }
    }
    @keyframes rjpGlow-{{ $uid }} {
        0%, 100% { box-shadow: 0 0 12px -2px var(--c); }
        50% { box-shadow: 0 0 24px 2px var(--c); }
    }
    @keyframes rjpRise-{{ $uid }} {
        from { opacity: 0; transform: translateY(24px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes rjpPulse-{{ $uid }} {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    #{{ $uid }} {
        width: 100%;
        padding: 24px;
        display: flex;
        justify-content: center;
    }

    #{{ $uid }} .rjp-card {
        position: relative;
        width: 100%;
        max-width: 80rem;
        padding: 48px 32px;
        background: #ffffff;
        border-radius: 32px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 20px 40px -20px rgba(15,23,42,0.15);
        overflow: hidden;
    }

    #{{ $uid }} .rjp-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 100% 0%, rgba(99,102,241,0.06), transparent 50%);
        pointer-events: none;
    }

    #{{ $uid }} .rjp-head-wrap {
        margin-bottom: 40px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    #{{ $uid }} .rjp-sec-title {
        margin: 0;
        font-size: clamp(1.8rem, 3.5vw, 2.5rem);
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.03em;
        line-height: 1.15;
    }

    #{{ $uid }} .rjp-sec-title::after {
        content: "";
        display: block;
        width: 56px;
        height: 4px;
        margin: 16px auto 0;
        border-radius: 4px;
        background: linear-gradient(90deg, #6366f1, #a855f7);
    }

    #{{ $uid }} .rjp-sec-sub {
        margin: 14px auto 0;
        max-width: 32rem;
        color: #64748b;
        font-size: 1rem;
        line-height: 1.6;
    }

    #{{ $uid }} .rjp-grid {
        display: grid;
        gap: 32px 24px;
        grid-template-columns: 1fr;
        position: relative;
        z-index: 1;
    }

    @media (min-width: 640px) {
        #{{ $uid }} .rjp-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 1024px) {
        #{{ $uid }} .rjp-grid { grid-template-columns: repeat({{ $cols }}, 1fr); }
    }

    #{{ $uid }} .rjp-item {
        position: relative;
        display: flex;
        flex-direction: column;
        opacity: 0;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #{{ $uid }}.rjp-in .rjp-item {
        animation: rjpRise-{{ $uid }} 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        animation-delay: calc(var(--i, 0) * 90ms);
    }

    #{{ $uid }} .rjp-item:hover {
        transform: translateY(-4px);
    }

    #{{ $uid }} .rjp-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    #{{ $uid }} .rjp-ico {
        flex: none;
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        color: var(--c);
        background: color-mix(in srgb, var(--c) 12%, transparent);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #{{ $uid }} .rjp-ico svg,
    #{{ $uid }} .rjp-ico img {
        width: 18px;
        height: 18px;
        max-width: none;
        display: block;
    }

    #{{ $uid }} .rjp-item:hover .rjp-ico {
        background: var(--c);
        color: #fff;
        transform: rotate(-8deg) scale(1.1);
        box-shadow: 0 8px 20px -6px var(--c);
    }

    #{{ $uid }} .rjp-label {
        flex: 1;
        min-width: 0;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    #{{ $uid }} .rjp-pct {
        flex: none;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--c);
        font-variant-numeric: tabular-nums;
        letter-spacing: -0.02em;
        transition: transform 0.3s ease;
    }

    #{{ $uid }} .rjp-item:hover .rjp-pct {
        transform: scale(1.08);
    }

    #{{ $uid }} .rjp-pct small {
        font-size: 0.65em;
        opacity: 0.7;
        margin-left: 1px;
    }

    #{{ $uid }} .rjp-track {
        position: relative;
        width: 100%;
        height: {{ $opts['bar_h'] }}px;
        border-radius: 999px;
        background: #f1f5f9;
        overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(15,23,42,0.08);
    }

    #{{ $uid }} .rjp-fill {
        position: relative;
        height: 100%;
        width: 0;
        border-radius: inherit;
        background: linear-gradient(90deg, var(--c), color-mix(in srgb, var(--c) 60%, #ffffff));
        overflow: hidden;
        transition: width 1.4s cubic-bezier(0.22, 1, 0.36, 1);
        transition-delay: calc(var(--i, 0) * 90ms + 150ms);
    }

    #{{ $uid }}.rjp-in .rjp-fill {
        width: calc(var(--v) * 1%);
    }

    #{{ $uid }} .rjp-fill::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.6) 50%, transparent 100%);
        animation: rjpShine-{{ $uid }} 2.2s ease-in-out infinite;
        animation-delay: calc(var(--i, 0) * 90ms + 1.2s);
    }

    #{{ $uid }}[data-style="minimal"] .rjp-ico {
        display: none;
    }

    #{{ $uid }}[data-style="minimal"] .rjp-track {
        border-radius: 0;
        height: 4px;
        box-shadow: none;
    }

    #{{ $uid }}[data-style="minimal"] .rjp-fill {
        border-radius: 0;
    }

    #{{ $uid }}[data-style="minimal"] .rjp-fill::after {
        display: none;
    }

    #{{ $uid }}[data-style="thick"] .rjp-track {
        border-radius: 12px;
    }

    #{{ $uid }}[data-style="thick"] .rjp-fill {
        border-radius: 12px;
        animation: rjpGlow-{{ $uid }} 2.5s ease-in-out infinite;
    }

    #{{ $uid }} .rjp-ring-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    #{{ $uid }} .rjp-ring {
        position: relative;
        width: 140px;
        height: 140px;
        margin-bottom: 16px;
    }

    #{{ $uid }} .rjp-ring svg {
        width: 100%;
        height: 100%;
        overflow: visible;
        transform: rotate(-90deg);
    }

    #{{ $uid }} .rjp-ring-bg {
        fill: none;
        stroke: #f1f5f9;
        stroke-width: {{ $opts['ring_w'] }};
    }

    #{{ $uid }} .rjp-ring-fg {
        fill: none;
        stroke-width: {{ $opts['ring_w'] }};
        stroke-linecap: round;
        stroke: var(--c);
        stroke-dasharray: {{ $opts['circ'] }};
        stroke-dashoffset: {{ $opts['circ'] }};
        filter: drop-shadow(0 0 6px var(--c));
        transition: stroke-dashoffset 1.6s cubic-bezier(0.22, 1, 0.36, 1);
        transition-delay: calc(var(--i, 0) * 90ms + 150ms);
    }

    #{{ $uid }}.rjp-in .rjp-ring-fg {
        stroke-dashoffset: var(--off);
    }

    #{{ $uid }} .rjp-center {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    #{{ $uid }} .rjp-center .rjp-ico {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: transparent;
        color: var(--c);
    }

    #{{ $uid }} .rjp-center .rjp-ico svg,
    #{{ $uid }} .rjp-center .rjp-ico img {
        width: 32px;
        height: 32px;
    }

    #{{ $uid }} .rjp-center .rjp-pct {
        font-size: 1.4rem;
        margin-top: 2px;
    }

    #{{ $uid }} .rjp-ring-wrap .rjp-label {
        margin-top: 8px;
        font-size: 1rem;
        text-align: center;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} * {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rjp-item {
            opacity: 1;
        }
        #{{ $uid }} .rjp-fill {
            width: calc(var(--v) * 1%);
        }
        #{{ $uid }} .rjp-ring-fg {
            stroke-dashoffset: var(--off);
        }
    }
</style>

<section id="{{ $uid }}" data-style="{{ $opts['style'] }}">
    <div class="rjp-card">

        @if ($opts['title'] !== '' || $opts['subtitle'] !== '')
            <div class="rjp-head-wrap">
                @if ($opts['title'] !== '')
                    <h2 class="rjp-sec-title">{{ $opts['title'] }}</h2>
                @endif
                @if ($opts['subtitle'] !== '')
                    <p class="rjp-sec-sub">{{ $opts['subtitle'] }}</p>
                @endif
            </div>
        @endif

        <div class="rjp-grid">
            @foreach ($items as $item)
                @php
                    $hasIcon = $item['icon'] !== '' && $iconOk;
                @endphp

                <div class="rjp-item"
                     style="--c: {{ $item['color'] }}; --v: {{ $item['value'] }}; --off: {{ $item['off'] }}; --i: {{ min($loop->index, 12) }};"
                     role="progressbar"
                     aria-label="{{ $item['label'] }}"
                     aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $item['value'] }}">

                    @if ($circles)
                        <div class="rjp-ring-wrap">
                            <div class="rjp-ring">
                                <svg viewBox="0 0 120 120" aria-hidden="true">
                                    <circle class="rjp-ring-bg" cx="60" cy="60" r="52"/>
                                    <circle class="rjp-ring-fg" cx="60" cy="60" r="52"/>
                                </svg>
                                <div class="rjp-center">
                                    @if ($hasIcon)
                                        <span class="rjp-ico" aria-hidden="true">{!! rj_icon($item['icon'], 'w-8 h-8') !!}</span>
                                    @endif
                                    @if ($opts['percent'])
                                        <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span><small>%</small></span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="rjp-label">{{ $item['label'] }}</h3>
                        </div>
                    @else
                        <div class="rjp-head">
                            @if ($hasIcon)
                                <span class="rjp-ico" aria-hidden="true">{!! rj_icon($item['icon'], 'w-4 h-4') !!}</span>
                            @endif
                            <h3 class="rjp-label">{{ $item['label'] }}</h3>
                            @if ($opts['percent'])
                                <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span><small>%</small></span>
                            @endif
                        </div>
                        <div class="rjp-track">
                            <div class="rjp-fill"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) return;
    root.dataset.ready = '1';

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var items = [].slice.call(root.querySelectorAll('.rjp-item'));

    function ease(t) { return 1 - Math.pow(1 - t, 3); }

    function count(el, delay) {
        var to = parseInt(el.dataset.to, 10) || 0;
        var dur = 1200;
        setTimeout(function () {
            var t0 = null;
            (function step(ts) {
                if (t0 === null) t0 = ts;
                var p = Math.min(1, (ts - t0) / dur);
                el.textContent = Math.round(to * ease(p));
                if (p < 1) requestAnimationFrame(step);
            })(performance.now());
        }, delay);
    }

    function play() {
        root.classList.add('rjp-in');
        if (reduce) return;
        items.forEach(function (item, k) {
            [].forEach.call(item.querySelectorAll('.rjp-num'), function (n) {
                count(n, k * 90 + 150);
            });
        });
    }

    if (!reduce) {
        [].forEach.call(root.querySelectorAll('.rjp-num'), function (n) {
            n.textContent = '0';
        });
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                play();
                io.disconnect();
            }
        }, { threshold: 0.15 });
        io.observe(root);
    } else {
        play();
    }
})();
</script>
