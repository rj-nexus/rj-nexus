@php
    $circles = $opts['layout'] === 'circles';
    $iconOk = function_exists('rj_icon');
@endphp

<style>
    @keyframes rjpRise-{{ $uid }} {
        from { opacity: 0; transform: translateY(15px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes rjpGlow-{{ $uid }} {
        0%, 100% { filter: drop-shadow(0 0 4px var(--c)); }
        50%      { filter: drop-shadow(0 0 12px var(--c)); }
    }
    @keyframes rjpShine-{{ $uid }} {
        0% { transform: translateX(-150%); }
        100% { transform: translateX(150%); }
    }

    #{{ $uid }} {
        width: 100%;
        padding: 32px 16px;
    }

    #{{ $uid }} .rjp-head-wrap {
        margin-bottom: 32px;
        text-align: center;
    }

    #{{ $uid }} .rjp-sec-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
    }

    #{{ $uid }} .rjp-sec-sub {
        margin: 6px auto 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    #{{ $uid }} .rjp-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        gap: 32px;
        max-width: 1200px;
        margin: 0 auto;
    }

    #{{ $uid }} .rjp-item {
        position: relative;
        width: 100%;
        max-width: 260px;
        display: flex;
        flex-direction: column;
        opacity: 0;
        padding: 10px 0;
    }

    #{{ $uid }}.rjp-in .rjp-item {
        animation: rjpRise-{{ $uid }} 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        animation-delay: calc(var(--i, 0) * 80ms);
    }

    /* ---------- Linear Bar ---------- */
    #{{ $uid }} .rjp-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    #{{ $uid }} .rjp-ico {
        flex: none;
        display: grid;
        place-items: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        color: #64748b;
        background: #f1f5f9;
        transition: all 0.3s ease;
    }

    #{{ $uid }} .rjp-ico svg, #{{ $uid }} .rjp-ico img {
        width: 16px; height: 16px;
    }

    #{{ $uid }} .rjp-item:hover .rjp-ico {
        color: #fff;
        background: var(--c);
        transform: scale(1.1);
    }

    #{{ $uid }} .rjp-label {
        flex: 1;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #334155;
    }

    #{{ $uid }} .rjp-pct {
        font-size: 1rem;
        font-weight: 800;
        color: var(--c);
        font-variant-numeric: tabular-nums;
    }

    #{{ $uid }} .rjp-track {
        position: relative;
        width: 100%;
        height: 8px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    #{{ $uid }} .rjp-fill {
        position: relative;
        height: 100%;
        width: 0;
        border-radius: inherit;
        background: var(--c);
        transition: width 1.2s cubic-bezier(0.2, 0.8, 0.2, 1);
        transition-delay: calc(var(--i, 0) * 80ms + 100ms);
    }

    #{{ $uid }}.rjp-in .rjp-fill {
        width: calc(var(--v) * 1%);
    }

    #{{ $uid }} .rjp-item:hover .rjp-fill::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7), transparent);
        animation: rjpShine-{{ $uid }} 1.5s linear infinite;
    }

    /* ---------- Circles ---------- */
    #{{ $uid }} .rjp-ring-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 10px; /* Kölgələrin kəsilməməsi üçün */
    }

    #{{ $uid }} .rjp-ring {
        position: relative;
        width: 110px;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.4s ease;
    }

    #{{ $uid }} .rjp-item:hover .rjp-ring {
        transform: scale(1.05);
    }

    /* overflow: visible - Kölgələrin və glownun kəsilməməsi üçün ən vacib hissə */
    #{{ $uid }} .rjp-ring svg.rjp-svg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
        overflow: visible;
    }

    #{{ $uid }} .rjp-ring-bg {
        fill: none;
        stroke: #e2e8f0;
        stroke-width: 8;
    }

    #{{ $uid }} .rjp-ring-fg {
        fill: none;
        stroke: var(--c);
        stroke-width: 8;
        stroke-linecap: round;
        stroke-dasharray: {{ $opts['circ'] }};
        stroke-dashoffset: var(--off);
        transition: stroke-dashoffset 1.2s cubic-bezier(0.2, 0.8, 0.2, 1);
        transition-delay: calc(var(--i, 0) * 80ms + 100ms);
    }

    #{{ $uid }}.rjp-ready .rjp-ring-fg {
        stroke-dashoffset: {{ $opts['circ'] }};
    }

    #{{ $uid }}.rjp-in .rjp-ring-fg {
        stroke-dashoffset: var(--off);
        animation: rjpGlow-{{ $uid }} 2s ease-in-out infinite alternate;
    }

    #{{ $uid }} .rjp-center {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #{{ $uid }} .rjp-center .rjp-ico {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        margin-bottom: 4px;
        background: color-mix(in srgb, var(--c) 10%, transparent);
        color: var(--c);
    }

    #{{ $uid }} .rjp-center .rjp-ico svg,
    #{{ $uid }} .rjp-center .rjp-ico img {
        width: 18px;
        height: 18px;
    }

    #{{ $uid }} .rjp-center .rjp-pct {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
    }

    #{{ $uid }} .rjp-ring-wrap .rjp-label {
        margin-top: 8px;
        font-size: 0.95rem;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} * { animation: none !important; transition: none !important; }
        #{{ $uid }} .rjp-item { opacity: 1; }
        #{{ $uid }} .rjp-fill { width: calc(var(--v) * 1%); }
        #{{ $uid }} .rjp-ring-fg { stroke-dashoffset: var(--off); }
    }
</style>

<section id="{{ $uid }}">
    <div>
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
                     style="--c: {{ $item['color'] }}; --v: {{ $item['value'] }}; --off: {{ $item['off'] }}; --i: {{ min($loop->index, 12) }};">

                    @if ($circles)
                        <div class="rjp-ring-wrap">
                            <div class="rjp-ring">
                                <svg class="rjp-svg" viewBox="0 0 120 120" aria-hidden="true">
                                    <circle class="rjp-ring-bg" cx="60" cy="60" r="48"/>
                                    <circle class="rjp-ring-fg" cx="60" cy="60" r="48"/>
                                </svg>
                                <div class="rjp-center">
                                    @if ($hasIcon)
                                        <span class="rjp-ico">{!! rj_icon($item['icon'], 'w-4 h-4') !!}</span>
                                    @endif
                                    @if ($opts['percent'])
                                        <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span>%</span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="rjp-label">{{ $item['label'] }}</h3>
                        </div>
                    @else
                        <div class="rjp-head">
                            @if ($hasIcon)
                                <span class="rjp-ico">{!! rj_icon($item['icon'], 'w-4 h-4') !!}</span>
                            @endif
                            <h3 class="rjp-label">{{ $item['label'] }}</h3>
                            @if ($opts['percent'])
                                <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span>%</span>
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
                count(n, k * 80 + 100);
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
        }, { threshold: 0.1 });
        io.observe(root);
    } else {
        play();
    }
})();
</script>
