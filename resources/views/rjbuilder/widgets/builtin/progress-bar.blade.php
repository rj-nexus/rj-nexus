@php
    $circles = $opts['layout'] === 'circles';
    $iconOk = function_exists('rj_icon');
    $cols = $opts['cols'];
@endphp

<style>
    #{{ $uid }} { --h: {{ $opts['bar_h'] }}px; --rw: {{ $opts['ring_w'] }}; width: 100%; padding: 40px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} .rjp-box { max-width: 72rem; margin: 0 auto; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjp-head-wrap { margin-bottom: 32px; text-align: center; }
    #{{ $uid }} .rjp-sec-title { margin: 0; padding: 0; font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 800; line-height: 1.12; letter-spacing: -.03em; color: #0f172a; }
    #{{ $uid }} .rjp-sec-title::after { content: ""; display: block; width: 50px; height: 4px; margin: 14px auto 0; border-radius: 4px; background: #6366f1; }
    #{{ $uid }} .rjp-sec-sub { margin: 12px auto 0; max-width: 36rem; color: #64748b; line-height: 1.6; font-size: 1rem; }

    /* ---------- Grid ---------- */
    #{{ $uid }} .rjp-grid { display: grid; gap: 24px; grid-template-columns: 1fr; }
    @media (min-width: 640px) { #{{ $uid }} .rjp-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { #{{ $uid }} .rjp-grid { grid-template-columns: repeat({{ $cols }}, 1fr); gap: 32px; } }

    /* ---------- Item Card ---------- */
    #{{ $uid }} .rjp-item { --c: #6366f1; --c2: #6366f1; position: relative; display: flex; flex-direction: column; }
    #{{ $uid }} .rjp-item:hover { transform: translateY(-2px); }
    @supports (color: color-mix(in srgb, red, blue)) { #{{ $uid }} .rjp-item { --c2: color-mix(in srgb, var(--c) 55%, #fff); } }

    /* ---------- Linear ---------- */
    #{{ $uid }} .rjp-head { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    #{{ $uid }} .rjp-ico { flex: none; display: grid; place-items: center; width: 32px; height: 32px; border-radius: 8px; color: var(--c); background: var(--c); transition: transform 0.4s ease, background-color 0.4s ease, color 0.4s ease; }
    @supports (color: color-mix(in srgb, red, blue)) { #{{ $uid }} .rjp-ico { background: color-mix(in srgb, var(--c) 15%, transparent); } }
    #{{ $uid }} .rjp-ico svg, #{{ $uid }} .rjp-ico img { display: block; width: 16px; height: 16px; max-width: none; }
    #{{ $uid }} .rjp-item:hover .rjp-ico { background: var(--c); color: #fff; transform: scale(1.05); }

    #{{ $uid }} .rjp-label { flex: 1; min-width: 0; margin: 0; font-size: 0.95rem; font-weight: 700; line-height: 1.2; color: #0f172a; }
    #{{ $uid }} .rjp-pct { flex: none; font-size: 1rem; font-weight: 800; color: var(--c); }
    #{{ $uid }} .rjp-pct small { font-size: 0.7em; opacity: 0.7; }

    #{{ $uid }} .rjp-track { position: relative; width: 100%; height: var(--h); border-radius: 999px; background: #e2e8f0; overflow: hidden; }
    #{{ $uid }} .rjp-fill { position: relative; height: 100%; width: calc(var(--v) * 1%); border-radius: inherit; background: var(--c); background: linear-gradient(90deg, var(--c), var(--c2)); }
    #{{ $uid }}.rjp-ready .rjp-fill { width: 0; }
    #{{ $uid }}.rjp-in .rjp-fill { width: calc(var(--v) * 1%); transition: width 1.2s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i, 0) * 100ms + 100ms); }

    /* Minimal & Thick adjustments */
    #{{ $uid }}[data-style="minimal"] .rjp-track { border-radius: 0; height: 4px; }
    #{{ $uid }}[data-style="minimal"] .rjp-fill { border-radius: 0; }
    #{{ $uid }}[data-style="minimal"] .rjp-ico { display: none; } /* Hide icons in minimal to keep it clean */

    #{{ $uid }}[data-style="thick"] .rjp-track { border-radius: 8px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1); }
    #{{ $uid }}[data-style="thick"] .rjp-fill { border-radius: 8px; box-shadow: 0 2px 8px -2px var(--c); }

    /* ---------- Circles ---------- */
    #{{ $uid }} .rjp-ring-wrap { display: flex; flex-direction: column; align-items: center; text-align: center; }
    #{{ $uid }} .rjp-ring { position: relative; width: 130px; height: 130px; margin-bottom: 12px; }
    #{{ $uid }} .rjp-ring svg.rjp-svg { display: block; width: 100%; height: 100%; max-width: none; overflow: visible; }
    #{{ $uid }} .rjp-ring-bg { fill: none; stroke: #e2e8f0; stroke-width: var(--rw); }
    #{{ $uid }} .rjp-ring-fg { fill: none; stroke-width: var(--rw); stroke-linecap: round; stroke-dasharray: {{ $opts['circ'] }}; stroke-dashoffset: var(--off); filter: drop-shadow(0 0 4px var(--c)); }
    #{{ $uid }}.rjp-ready .rjp-ring-fg { stroke-dashoffset: {{ $opts['circ'] }}; }
    #{{ $uid }}.rjp-in .rjp-ring-fg { stroke-dashoffset: var(--off); transition: stroke-dashoffset 1.4s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i, 0) * 100ms + 100ms); }

    #{{ $uid }} .rjp-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
    #{{ $uid }} .rjp-center .rjp-ico { width: 48px; height: 48px; border-radius: 50%; background: transparent; color: var(--c); }
    #{{ $uid }} .rjp-center .rjp-ico svg, #{{ $uid }} .rjp-center .rjp-ico img { width: 32px; height: 32px; }
    #{{ $uid }} .rjp-center .rjp-pct { font-size: 1.4rem; margin-top: 2px; }

    /* ---------- Reveal ---------- */
    #{{ $uid }}.rjp-ready:not(.rjp-in) .rjp-item { opacity: 0; transform: translateY(20px); }
    #{{ $uid }}.rjp-in .rjp-item { animation: rjp-rise 0.6s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--i, 0) * 80ms); }
    @keyframes rjp-rise { from { opacity: 0; transform: translateY(20px) scale(0.96); } }

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
                                    <circle class="rjp-ring-fg" cx="60" cy="60" r="52" stroke="{{ $item['color'] }}" transform="rotate(-90 60 60)"/>
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
    if (!root || root.dataset.ready) { return; }
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
            [].forEach.call(item.querySelectorAll('.rjp-num'), function (n) { count(n, k * 100 + 100); });
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
