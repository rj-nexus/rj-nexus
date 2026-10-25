@php
    $circles = $opts['layout'] === 'circles';
    $iconOk = function_exists('rj_icon');
    $cols = (int) ($opts['cols'] ?? 3);
    $cols = max(1, min(6, $cols));
@endphp

<style>
    @keyframes rjpRise-{{ $uid }} {
        from { opacity: 0; transform: translateY(28px) scale(.95); filter: blur(8px); }
        to   { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }
    @keyframes rjpShine-{{ $uid }} {
        0%   { transform: translateX(-150%) skewX(-20deg); }
        100% { transform: translateX(150%) skewX(-20deg); }
    }
    @keyframes rjpStripes-{{ $uid }} { to { background-position: 28.28px 0; } }
    @keyframes rjpGlow-{{ $uid }} {
        0%, 100% { filter: drop-shadow(0 0 5px var(--c)); }
        50%      { filter: drop-shadow(0 0 16px var(--c)); }
    }
    @keyframes rjpPulse-{{ $uid }} {
        0%   { box-shadow: 0 0 0 0 color-mix(in srgb, var(--c) 55%, transparent); }
        100% { box-shadow: 0 0 0 12px transparent; }
    }
    @keyframes rjpSpin-{{ $uid }} { to { transform: rotate(360deg); } }
    @keyframes rjpRipple-{{ $uid }} {
        0%   { transform: scale(.92); opacity: .55; }
        100% { transform: scale(1.28); opacity: 0; }
    }
    @keyframes rjpBounce-{{ $uid }} {
        0%, 100% { transform: translateY(0) scale(1); }
        35%      { transform: translateY(-9px) scale(1.12) rotate(-6deg); }
        65%      { transform: translateY(2px) scale(.96); }
    }
    @keyframes rjpPop-{{ $uid }} {
        0%   { transform: scale(1); }
        45%  { transform: scale(1.35); }
        100% { transform: scale(1); }
    }
    @keyframes rjpFloatA-{{ $uid }} {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(60px, 40px) scale(1.15); }
    }
    @keyframes rjpFloatB-{{ $uid }} {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(-70px, -30px) scale(1.1); }
    }

    #{{ $uid }} { width: 100%; padding: 32px 16px; display: flex; justify-content: center; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Card + aurora ---------- */
    #{{ $uid }} .rjp-card { position: relative; width: 100%; max-width: 80rem; padding: 48px 40px; background: #fff; border-radius: 32px; border: 1px solid #e2e8f0; box-shadow: 0 10px 40px -10px rgba(15,23,42,.08); overflow: hidden; isolation: isolate; }
    #{{ $uid }} .rjp-blob { position: absolute; z-index: -1; width: 340px; height: 340px; border-radius: 50%; filter: blur(70px); opacity: .22; pointer-events: none; }
    #{{ $uid }} .rjp-blob.b1 { top: -120px; left: -80px; background: #6366f1; animation: rjpFloatA-{{ $uid }} 14s ease-in-out infinite; }
    #{{ $uid }} .rjp-blob.b2 { bottom: -140px; right: -90px; background: #ec4899; animation: rjpFloatB-{{ $uid }} 17s ease-in-out infinite; }
    #{{ $uid }} .rjp-blob.b3 { top: 40%; left: 45%; width: 260px; height: 260px; background: #06b6d4; opacity: .14; animation: rjpFloatA-{{ $uid }} 20s ease-in-out infinite reverse; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjp-head-wrap { position: relative; z-index: 1; margin-bottom: 40px; text-align: center; }
    #{{ $uid }} .rjp-sec-title { margin: 0; padding: 0; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; line-height: 1.15; letter-spacing: -.03em; color: #0f172a; }
    #{{ $uid }} .rjp-sec-title::after { content: ""; display: block; width: 56px; height: 4px; margin: 16px auto 0; border-radius: 4px; background: linear-gradient(90deg, #6366f1, #a855f7); transform-origin: center; }
    #{{ $uid }} .rjp-sec-sub { margin: 14px auto 0; max-width: 32rem; color: #64748b; font-size: 1rem; line-height: 1.6; }
    #{{ $uid }}.rjp-ready .rjp-sec-title::after { transform: scaleX(0); }
    #{{ $uid }}.rjp-in .rjp-sec-title::after { transform: scaleX(1); transition: transform .9s cubic-bezier(.2,.8,.2,1) .2s; }

    /* ---------- Grid ---------- */
    #{{ $uid }} .rjp-grid { position: relative; z-index: 1; display: grid; gap: 28px 24px; grid-template-columns: minmax(0, 1fr); }
    @media (min-width: 640px)  { #{{ $uid }} .rjp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (min-width: 1024px) { #{{ $uid }} .rjp-grid { grid-template-columns: repeat({{ $cols }}, minmax(0, 1fr)); } }
    @media (max-width: 639px)  { #{{ $uid }} .rjp-card { padding: 32px 18px; border-radius: 24px; } }

    /* ---------- Item ---------- */
    #{{ $uid }} .rjp-item { --c: #6366f1; --rx: 0deg; --ry: 0deg; position: relative; display: flex; flex-direction: column; width: 100%; padding: 16px 18px 18px; border-radius: 20px; border: 1px solid transparent; transform: perspective(900px) rotateX(var(--rx)) rotateY(var(--ry)); transition: transform .35s cubic-bezier(.2,.8,.2,1), background-color .4s ease, border-color .4s ease, box-shadow .4s ease; }
    #{{ $uid }}.rjp-ready:not(.rjp-in) .rjp-item { opacity: 0; }
    #{{ $uid }}.rjp-in .rjp-item { animation: rjpRise-{{ $uid }} .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--i, 0) * 90ms); }

    /* cursor spotlight */
    #{{ $uid }} .rjp-item::before { content: ""; position: absolute; inset: 0; z-index: 0; border-radius: inherit; pointer-events: none; opacity: 0; transition: opacity .4s ease; background: radial-gradient(260px circle at var(--mx, 50%) var(--my, 50%), color-mix(in srgb, var(--c) 16%, transparent), transparent 70%); }
    #{{ $uid }} .rjp-item > * { position: relative; z-index: 1; }

    #{{ $uid }} .rjp-item:hover { background-color: color-mix(in srgb, var(--c) 4%, #fff); border-color: color-mix(in srgb, var(--c) 35%, #e2e8f0); box-shadow: 0 24px 40px -24px var(--c); transform: perspective(900px) rotateX(var(--rx)) rotateY(var(--ry)) translateY(-5px); }
    #{{ $uid }} .rjp-item:hover::before { opacity: 1; }

    /* ---------- Linear ---------- */
    #{{ $uid }} .rjp-head { display: flex; align-items: center; gap: 12px; width: 100%; margin-bottom: 14px; }

    #{{ $uid }} .rjp-ico { flex: none; display: grid; place-items: center; width: 38px; height: 38px; border-radius: 12px; color: var(--c); background: color-mix(in srgb, var(--c) 12%, transparent); transition: transform .55s cubic-bezier(.34,1.56,.64,1), background-color .3s ease, color .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .rjp-ico svg, #{{ $uid }} .rjp-ico img { display: block; width: 19px; height: 19px; max-width: none; }
    #{{ $uid }} .rjp-item:hover .rjp-ico { transform: rotate(-10deg) scale(1.15); background: var(--c); color: #fff; box-shadow: 0 12px 22px -8px var(--c); }

    #{{ $uid }} .rjp-label { flex: 1; min-width: 0; margin: 0; font-size: .95rem; font-weight: 700; line-height: 1.3; letter-spacing: -.01em; color: #1e293b; transition: transform .4s cubic-bezier(.2,.8,.2,1), color .3s ease; }
    #{{ $uid }} .rjp-item:hover .rjp-label { transform: translateX(5px); color: #0f172a; }

    #{{ $uid }} .rjp-pct { flex: none; display: inline-block; font-size: 1.15rem; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; letter-spacing: -.02em; color: var(--c); transition: transform .4s cubic-bezier(.34,1.56,.64,1); transform-origin: right center; }
    #{{ $uid }} .rjp-pct small { margin-left: 1px; font-size: .65em; opacity: .7; }
    #{{ $uid }} .rjp-item:hover .rjp-pct { transform: scale(1.18); }
    #{{ $uid }} .rjp-pct.rjp-done { animation: rjpPop-{{ $uid }} .6s cubic-bezier(.34,1.56,.64,1); }

    #{{ $uid }} .rjp-track { position: relative; width: 100%; height: {{ $opts['bar_h'] }}px; border-radius: 999px; background: #eef2f7; box-shadow: inset 0 1px 3px rgba(15,23,42,.1); transition: height .4s cubic-bezier(.34,1.56,.64,1), transform .4s ease; }
    #{{ $uid }} .rjp-item:hover .rjp-track { height: {{ $opts['bar_h'] + 4 }}px; margin-top: -2px; margin-bottom: -2px; }

    #{{ $uid }} .rjp-fill { position: relative; height: 100%; width: calc(var(--v) * 1%); border-radius: inherit; overflow: hidden; background: linear-gradient(90deg, var(--c), color-mix(in srgb, var(--c) 58%, #fff)); box-shadow: 0 0 18px -2px var(--c); }
    #{{ $uid }}.rjp-ready .rjp-fill { width: 0; }
    #{{ $uid }}.rjp-in .rjp-fill { width: calc(var(--v) * 1%); transition: width 1.5s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i, 0) * 90ms + 150ms); }

    #{{ $uid }} .rjp-fill::after { content: ""; position: absolute; inset: 0; background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.55) 50%, transparent 100%); animation: rjpShine-{{ $uid }} 2.4s ease-in-out infinite; animation-delay: calc(var(--i, 0) * 90ms + 1.6s); }
    #{{ $uid }} .rjp-fill::before { content: ""; position: absolute; inset: 0; z-index: 1; opacity: 0; transition: opacity .4s ease; background: repeating-linear-gradient(-45deg, rgba(255,255,255,.25) 0 8px, transparent 8px 16px); background-size: 22.62px 22.62px; animation: rjpStripes-{{ $uid }} .8s linear infinite; }
    #{{ $uid }} .rjp-item:hover .rjp-fill::before { opacity: 1; }

    /* glowing knob at the tip of the bar */
    #{{ $uid }} .rjp-knob { position: absolute; top: 50%; left: calc(var(--v) * 1%); z-index: 2; width: calc(100% - 4px); max-width: 18px; aspect-ratio: 1; border-radius: 50%; background: #fff; border: 3px solid var(--c); transform: translate(calc(-100% - 2px), -50%); animation: rjpPulse-{{ $uid }} 1.8s ease-out infinite; pointer-events: none; }
    #{{ $uid }}.rjp-ready .rjp-knob { left: 0; opacity: 0; }
    #{{ $uid }}.rjp-in .rjp-knob { left: calc(var(--v) * 1%); opacity: 1; transition: left 1.5s cubic-bezier(.22,1,.36,1), opacity .4s ease; transition-delay: calc(var(--i, 0) * 90ms + 150ms), calc(var(--i, 0) * 90ms + 150ms); }

    /* ---------- Circles ---------- */
    #{{ $uid }} .rjp-ring-wrap { display: flex; flex-direction: column; align-items: center; width: 100%; text-align: center; }
    #{{ $uid }} .rjp-ring { position: relative; display: flex; align-items: center; justify-content: center; width: 150px; height: 150px; margin-bottom: 18px; transition: transform .6s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rjp-item:hover .rjp-ring { transform: scale(1.07); }

    /* orbit */
    #{{ $uid }} .rjp-ring::before { content: ""; position: absolute; inset: -12px; border-radius: 50%; border: 1.5px dashed color-mix(in srgb, var(--c) 40%, transparent); opacity: .7; animation: rjpSpin-{{ $uid }} 16s linear infinite; pointer-events: none; transition: opacity .3s ease; }
    #{{ $uid }} .rjp-item:hover .rjp-ring::before { opacity: 1; animation-duration: 5s; }
    /* ripple */
    #{{ $uid }} .rjp-ring::after { content: ""; position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--c); opacity: 0; pointer-events: none; }
    #{{ $uid }} .rjp-item:hover .rjp-ring::after { animation: rjpRipple-{{ $uid }} 1.4s ease-out infinite; }

    #{{ $uid }} .rjp-ring svg.rjp-svg { position: absolute; inset: 0; width: 100%; height: 100%; max-width: none; overflow: visible; transform: rotate(-90deg); transform-origin: 50% 50%; }
    #{{ $uid }} .rjp-ring-bg { fill: none; stroke: #eef2f7; stroke-width: {{ $opts['ring_w'] }}; transition: stroke-width .4s ease; }
    #{{ $uid }} .rjp-ring-fg { fill: none; stroke: var(--c); stroke-width: {{ $opts['ring_w'] }}; stroke-linecap: round; stroke-dasharray: {{ $opts['circ'] }}; stroke-dashoffset: var(--off); transition: stroke-width .4s ease; }
    #{{ $uid }}.rjp-ready .rjp-ring-fg { stroke-dashoffset: {{ $opts['circ'] }}; }
    #{{ $uid }}.rjp-in .rjp-ring-fg { stroke-dashoffset: var(--off); transition: stroke-dashoffset 1.7s cubic-bezier(.22,1,.36,1), stroke-width .4s ease; transition-delay: calc(var(--i, 0) * 90ms + 150ms), 0s; animation: rjpGlow-{{ $uid }} 3s ease-in-out 2s infinite; }
    #{{ $uid }} .rjp-item:hover .rjp-ring-fg { stroke-width: {{ $opts['ring_w'] + 3 }}; }
    #{{ $uid }} .rjp-item:hover .rjp-ring-bg { stroke-width: {{ $opts['ring_w'] + 3 }}; }

    #{{ $uid }} .rjp-center { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; }
    #{{ $uid }} .rjp-center .rjp-ico { width: 46px; height: 46px; border-radius: 50%; }
    #{{ $uid }} .rjp-center .rjp-ico svg, #{{ $uid }} .rjp-center .rjp-ico img { width: 24px; height: 24px; }
    #{{ $uid }} .rjp-item:hover .rjp-center .rjp-ico { animation: rjpBounce-{{ $uid }} .8s ease; transform: none; }
    #{{ $uid }} .rjp-center .rjp-pct { font-size: 1.35rem; transform-origin: center; }
    #{{ $uid }} .rjp-ring-wrap .rjp-label { margin-top: 2px; font-size: 1.05rem; color: #0f172a; text-align: center; }
    #{{ $uid }} .rjp-item:hover .rjp-ring-wrap .rjp-label { transform: translateY(2px); }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }}.rjp-ready:not(.rjp-in) .rjp-item { opacity: 1; }
        #{{ $uid }}.rjp-ready .rjp-fill { width: calc(var(--v) * 1%); }
        #{{ $uid }}.rjp-ready .rjp-knob { left: calc(var(--v) * 1%); opacity: 1; }
        #{{ $uid }}.rjp-ready .rjp-ring-fg { stroke-dashoffset: var(--off); }
        #{{ $uid }}.rjp-ready .rjp-sec-title::after { transform: none; }
    }
</style>

<section id="{{ $uid }}">
    <div class="rjp-card">
        <span class="rjp-blob b1" aria-hidden="true"></span>
        <span class="rjp-blob b2" aria-hidden="true"></span>
        <span class="rjp-blob b3" aria-hidden="true"></span>

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
                                <svg class="rjp-svg" viewBox="0 0 120 120" aria-hidden="true">
                                    <circle class="rjp-ring-bg" cx="60" cy="60" r="52"/>
                                    <circle class="rjp-ring-fg" cx="60" cy="60" r="52"/>
                                </svg>
                                <div class="rjp-center">
                                    @if ($hasIcon)
                                        <span class="rjp-ico" aria-hidden="true">{!! rj_icon($item['icon'], 'w-6 h-6') !!}</span>
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
                                <span class="rjp-ico" aria-hidden="true">{!! rj_icon($item['icon'], 'w-5 h-5') !!}</span>
                            @endif
                            <h3 class="rjp-label">{{ $item['label'] }}</h3>
                            @if ($opts['percent'])
                                <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span><small>%</small></span>
                            @endif
                        </div>
                        <div class="rjp-track">
                            <div class="rjp-fill"></div>
                            <span class="rjp-knob" aria-hidden="true"></span>
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
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;
    var circles = {{ $circles ? 'true' : 'false' }};
    var items = [].slice.call(root.querySelectorAll('.rjp-item'));

    function ease(t) { return 1 - Math.pow(1 - t, 3); }

    function count(el, delay) {
        var to = parseInt(el.dataset.to, 10) || 0;
        var dur = 1500;
        setTimeout(function () {
            var t0 = null;
            (function step(ts) {
                if (t0 === null) { t0 = ts; }
                var p = Math.min(1, (ts - t0) / dur);
                el.textContent = Math.round(to * ease(p));
                if (p < 1) {
                    requestAnimationFrame(step);
                } else if (el.parentNode) {
                    el.parentNode.classList.add('rjp-done');
                }
            })(performance.now());
        }, delay);
    }

    function play() {
        root.classList.add('rjp-in');
        if (reduce) { return; }
        items.forEach(function (item, k) {
            [].forEach.call(item.querySelectorAll('.rjp-num'), function (n) { count(n, k * 90 + 150); });
        });
    }

    // Hover: cursor spotlight + 3D tilt (mouse devices only)
    if (canHover && !reduce) {
        items.forEach(function (item) {
            item.addEventListener('pointermove', function (e) {
                var r = item.getBoundingClientRect();
                var x = e.clientX - r.left, y = e.clientY - r.top;
                item.style.setProperty('--mx', x + 'px');
                item.style.setProperty('--my', y + 'px');
                if (circles) {
                    item.style.setProperty('--ry', ((x / r.width - .5) * 12).toFixed(2) + 'deg');
                    item.style.setProperty('--rx', ((.5 - y / r.height) * 12).toFixed(2) + 'deg');
                }
            });
            item.addEventListener('pointerleave', function () {
                item.style.setProperty('--rx', '0deg');
                item.style.setProperty('--ry', '0deg');
            });
        });
    }

    root.classList.add('rjp-ready');

    if (!reduce) {
        [].forEach.call(root.querySelectorAll('.rjp-num'), function (n) { n.textContent = '0'; });
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) { play(); io.disconnect(); }
        }, { threshold: 0.15 });
        io.observe(root);
    } else {
        play();
    }
})();
</script>
