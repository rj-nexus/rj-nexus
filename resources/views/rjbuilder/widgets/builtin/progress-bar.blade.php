@php
    $circles = $opts['layout'] === 'circles';
    $iconOk = function_exists('rj_icon');
@endphp

<style>
    #{{ $uid }} { --h: {{ $opts['bar_h'] }}px; --rw: {{ $opts['ring_w'] }}; width: 100%; padding: 48px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} .rjp-box { max-width: 56rem; margin: 0 auto; }
    #{{ $uid }}[data-layout="grid-2"] .rjp-box, #{{ $uid }}[data-layout="circles"] .rjp-box { max-width: 72rem; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjp-head-wrap { margin-bottom: 36px; text-align: center; }
    #{{ $uid }} .rjp-sec-title { margin: 0; padding: 0; font-size: clamp(1.9rem, 4.2vw, 2.8rem); font-weight: 800; line-height: 1.12; letter-spacing: -.03em; color: #0f172a; }
    #{{ $uid }} .rjp-sec-title::after { content: ""; display: block; width: 56px; height: 4px; margin: 18px auto 0; border-radius: 4px; background: #6366f1; }
    #{{ $uid }} .rjp-sec-sub { margin: 16px auto 0; max-width: 36rem; color: #64748b; line-height: 1.7; font-size: 1.05rem; }

    /* ---------- Grid ---------- */
    #{{ $uid }} .rjp-grid { display: grid; gap: 18px; grid-template-columns: minmax(0, 1fr); }
    @media (min-width: 768px) { #{{ $uid }}[data-layout="grid-2"] .rjp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px 28px; } }
    #{{ $uid }}[data-layout="circles"] .rjp-grid { grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 24px; }

    /* ---------- Item card ---------- */
    #{{ $uid }} .rjp-item { --c: #6366f1; --c2: #6366f1; position: relative; padding: 20px 22px 22px; border: 1px solid #e2e8f0; border-radius: 22px; background: #fff; box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 14px 30px -20px rgba(15,23,42,.2); transition: transform .45s cubic-bezier(.2,.8,.2,1), box-shadow .45s ease, border-color .45s ease; }
    @supports (color: color-mix(in srgb, red, blue)) { #{{ $uid }} .rjp-item { --c2: color-mix(in srgb, var(--c) 55%, #fff); } }
    #{{ $uid }} .rjp-item:hover { transform: translateY(-4px); border-color: var(--c); box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 26px 42px -22px var(--c); }

    /* ---------- Icon badge ---------- */
    #{{ $uid }} .rjp-ico { position: relative; flex: none; display: grid; place-items: center; width: 42px; height: 42px; border-radius: 14px; color: var(--c); background: var(--c); transition: transform .5s cubic-bezier(.34,1.56,.64,1), box-shadow .35s ease, color .35s ease; }
    @supports (color: color-mix(in srgb, red, blue)) { #{{ $uid }} .rjp-ico { background: color-mix(in srgb, var(--c) 13%, transparent); } }
    #{{ $uid }} .rjp-ico svg, #{{ $uid }} .rjp-ico img { display: block; width: 22px; height: 22px; max-width: none; }
    #{{ $uid }} .rjp-item:hover .rjp-ico { transform: rotate(-8deg) scale(1.1); background: var(--c); color: #fff; box-shadow: 0 12px 22px -10px var(--c); }

    /* ---------- Linear ---------- */
    #{{ $uid }} .rjp-head { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
    #{{ $uid }} .rjp-label { flex: 1; min-width: 0; margin: 0; font-size: 1rem; font-weight: 700; line-height: 1.3; letter-spacing: -.01em; color: #0f172a; }
    #{{ $uid }} .rjp-pct { flex: none; font-size: 1.2rem; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; letter-spacing: -.02em; color: var(--c); }
    #{{ $uid }} .rjp-pct small { margin-left: 1px; font-size: .65em; font-weight: 700; opacity: .75; }

    #{{ $uid }} .rjp-track { position: relative; width: 100%; height: var(--h); border-radius: 999px; background: #eef2f7; box-shadow: inset 0 1px 3px rgba(15,23,42,.1); overflow: hidden; }
    #{{ $uid }} .rjp-fill { position: relative; height: 100%; width: calc(var(--v) * 1%); border-radius: inherit; overflow: hidden; background: var(--c); background: linear-gradient(90deg, var(--c), var(--c2)); box-shadow: 0 0 18px -2px var(--c); }
    #{{ $uid }}.rjp-ready .rjp-fill { width: 0; }
    #{{ $uid }}.rjp-in .rjp-fill { width: calc(var(--v) * 1%); transition: width 1.5s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i, 0) * 120ms + 150ms); }

    #{{ $uid }} .rjp-fill::after { content: ""; position: absolute; inset: 0; background: linear-gradient(100deg, transparent 20%, rgba(255,255,255,.55) 50%, transparent 80%); transform: translateX(-120%); animation: rjp-shine 2.8s ease-in-out infinite; animation-delay: calc(var(--i, 0) * 120ms + 1.7s); }
    @keyframes rjp-shine { 0% { transform: translateX(-120%); } 55%, 100% { transform: translateX(120%); } }

    /* minimal */
    #{{ $uid }}[data-style="minimal"] .rjp-item { padding: 8px 0 14px; border: 0; border-radius: 0; background: transparent; box-shadow: none; }
    #{{ $uid }}[data-style="minimal"]:not([data-layout="circles"]) .rjp-item:hover { transform: none; box-shadow: none; }
    #{{ $uid }}[data-style="minimal"] .rjp-label { font-size: .78rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #475569; }
    #{{ $uid }}[data-style="minimal"] .rjp-pct { font-size: .95rem; }
    #{{ $uid }}[data-style="minimal"] .rjp-track { border-radius: 0; background: #e2e8f0; box-shadow: none; }
    #{{ $uid }}[data-style="minimal"] .rjp-fill { border-radius: 0; background: var(--c); box-shadow: none; }
    #{{ $uid }}[data-style="minimal"] .rjp-fill::after { display: none; }
    #{{ $uid }}[data-style="minimal"] .rjp-ico { width: 34px; height: 34px; border-radius: 10px; }
    #{{ $uid }}[data-style="minimal"] .rjp-ico svg, #{{ $uid }}[data-style="minimal"] .rjp-ico img { width: 18px; height: 18px; }

    /* thick */
    #{{ $uid }}[data-style="thick"] .rjp-track { border-radius: 14px; box-shadow: inset 0 2px 5px rgba(15,23,42,.14); }
    #{{ $uid }}[data-style="thick"] .rjp-fill { border-radius: 14px; box-shadow: 0 6px 18px -6px var(--c); }
    #{{ $uid }}[data-style="thick"] .rjp-fill::before { content: ""; position: absolute; inset: 0; background: repeating-linear-gradient(-45deg, rgba(255,255,255,.22) 0 10px, transparent 10px 20px); background-size: 28.28px 28.28px; animation: rjp-stripes 1s linear infinite; }
    @keyframes rjp-stripes { to { background-position: 28.28px 0; } }
    #{{ $uid }} .rjp-inbar { position: absolute; z-index: 2; top: 50%; right: 12px; transform: translateY(-50%); font-size: .75rem; font-weight: 800; line-height: 1; color: #fff; text-shadow: 0 1px 3px rgba(0,0,0,.35); font-variant-numeric: tabular-nums; }
    #{{ $uid }}[data-style="thick"] .rjp-item[data-inbar="1"] .rjp-head .rjp-pct { display: none; }

    /* ---------- Circles ---------- */
    #{{ $uid }} .rjp-ring-wrap { display: flex; flex-direction: column; align-items: center; text-align: center; }
    #{{ $uid }} .rjp-ring { position: relative; width: 148px; height: 148px; }
    #{{ $uid }} .rjp-ring svg.rjp-svg { display: block; width: 100%; height: 100%; max-width: none; overflow: visible; }
    #{{ $uid }} .rjp-ring-bg { fill: none; stroke: #eef2f7; stroke-width: var(--rw); }
    #{{ $uid }} .rjp-ring-fg { fill: none; stroke-width: var(--rw); stroke-linecap: round; stroke-dasharray: {{ $opts['circ'] }}; stroke-dashoffset: var(--off); filter: drop-shadow(0 0 6px var(--c)); }
    #{{ $uid }}.rjp-ready .rjp-ring-fg { stroke-dashoffset: {{ $opts['circ'] }}; }
    #{{ $uid }}.rjp-in .rjp-ring-fg { stroke-dashoffset: var(--off); transition: stroke-dashoffset 1.6s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i, 0) * 120ms + 150ms); }

    #{{ $uid }} .rjp-center { position: absolute; inset: 0; display: grid; place-items: center; }
    #{{ $uid }} .rjp-center .rjp-ico { width: 62px; height: 62px; border-radius: 50%; }
    #{{ $uid }} .rjp-center .rjp-ico svg, #{{ $uid }} .rjp-center .rjp-ico img { width: 30px; height: 30px; }
    #{{ $uid }} .rjp-center .rjp-pct { font-size: 1.9rem; }
    #{{ $uid }} .rjp-ring-wrap .rjp-label { flex: none; margin-top: 16px; }
    #{{ $uid }} .rjp-ring-wrap .rjp-pct { margin-top: 6px; font-size: 1.05rem; }

    /* ---------- Reveal ---------- */
    #{{ $uid }}.rjp-ready:not(.rjp-in) .rjp-item { opacity: 0; transform: translateY(24px); }
    #{{ $uid }}.rjp-in .rjp-item { animation: rjp-rise .8s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--i, 0) * 90ms); }
    @keyframes rjp-rise { from { opacity: 0; transform: translateY(26px) scale(.97); } }

    @media (max-width: 639px) {
        #{{ $uid }} { padding: 32px 12px; }
        #{{ $uid }} .rjp-item { padding: 16px 16px 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }}.rjp-ready:not(.rjp-in) .rjp-item { opacity: 1; transform: none; }
    }
</style>

<section id="{{ $uid }}" data-layout="{{ $opts['layout'] }}" data-style="{{ $opts['style'] }}">
    <div class="rjp-box">

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
                    $inbar = $opts['style'] === 'thick' && $opts['percent'] && $item['value'] >= 14;
                @endphp

                <div class="rjp-item"
                     style="--c: {{ $item['color'] }}; --v: {{ $item['value'] }}; --off: {{ $item['off'] }}; --i: {{ min($loop->index, 12) }};"
                     data-inbar="{{ $inbar ? '1' : '0' }}"
                     role="progressbar"
                     aria-label="{{ $item['label'] }}"
                     aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $item['value'] }}">

                    @if ($circles)
                        <div class="rjp-ring-wrap">
                            <div class="rjp-ring">
                                <svg class="rjp-svg" viewBox="0 0 120 120" aria-hidden="true">
                                    <circle class="rjp-ring-bg" cx="60" cy="60" r="52"/>
                                    <circle class="rjp-ring-fg" cx="60" cy="60" r="52" stroke="{{ $item['color'] }}" transform="rotate(-90 60 60)"/>
                                </svg>
                                <div class="rjp-center">
                                    @if ($hasIcon)
                                        <span class="rjp-ico" aria-hidden="true">{!! rj_icon($item['icon'], 'w-6 h-6') !!}</span>
                                    @elseif ($opts['percent'])
                                        <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span><small>%</small></span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="rjp-label">{{ $item['label'] }}</h3>
                            @if ($opts['percent'] && $hasIcon)
                                <span class="rjp-pct"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span><small>%</small></span>
                            @endif
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
                            <div class="rjp-fill">
                                @if ($inbar)
                                    <span class="rjp-inbar"><span class="rjp-num" data-to="{{ $item['value'] }}">{{ $item['value'] }}</span>%</span>
                                @endif
                            </div>
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
                if (p < 1) { requestAnimationFrame(step); }
            })(performance.now());
        }, delay);
    }

    function play() {
        root.classList.add('rjp-in');
        if (reduce) { return; }
        items.forEach(function (item, k) {
            [].forEach.call(item.querySelectorAll('.rjp-num'), function (n) { count(n, k * 120 + 150); });
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
