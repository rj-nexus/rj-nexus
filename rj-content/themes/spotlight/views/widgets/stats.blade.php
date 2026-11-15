@php
    $uid = $uid ?? ('stats_' . substr(md5(uniqid('', true)), 0, 8));
    $style = ($settings['style'] ?? 'glass') === 'minimal' ? 'minimal' : 'glass';
    $hue   = max(0, min(360, (int) ($settings['hue'] ?? 217)));   // first card's hue; the others shift gradually
    $stats = $settings['stats'] ?? [];
    if (!is_array($stats)) $stats = [];
    $stats = array_slice(array_values($stats), 0, 8);
@endphp

<style>
    /*
     * Glass look without backdrop-filter (cheap on the GPU, no lag over the animated starfield):
     * translucent layers + edge highlights + a light that follows the cursor (transform only).
     */
    #{{ $uid }} { --h: {{ $hue }}; width: 100%; padding: 80px 24px; background: transparent; font-family: var(--rj-font-body); }
    #{{ $uid }} .rj-stats-container { max-width: var(--rj-container, 1200px); margin: 0 auto; }

    #{{ $uid }} .rj-stats-head { text-align: center; margin-bottom: 52px; }
    #{{ $uid }} .rj-stats-title {
        margin: 0; font-size: clamp(26px, 3.4vw, 40px); font-weight: 500; line-height: 1.12; letter-spacing: -.035em;
        background: linear-gradient(180deg, #fff 30%, hsl(var(--h) 75% 86%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .rj-stats-sub { margin: 14px auto 0; max-width: 560px; font-size: 16px; line-height: 1.6; color: rgba(255,255,255,.65); }

    #{{ $uid }} .rj-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; }

    /* ---------- Card ---------- */
    #{{ $uid }} .rj-stat-card {
        --c: calc(var(--h) + var(--i) * 22);
        position: relative; isolation: isolate; overflow: hidden; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
        padding: 42px 24px 38px; border-radius: var(--rj-radius-lg, 20px);
        transition: translate .45s cubic-bezier(.16,1,.3,1), border-color .4s, box-shadow .4s;
    }
    #{{ $uid }}[data-style="glass"] .rj-stat-card {
        background:
            radial-gradient(120% 90% at 50% 0%, hsl(var(--c) 85% 60% / .17), transparent 62%),
            linear-gradient(160deg, rgba(255,255,255,.085), rgba(255,255,255,.02) 45%, rgba(255,255,255,.045)),
            rgba(10, 12, 24, .78);
        border: 1px solid rgba(255,255,255,.1);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 26px 44px -26px rgba(0,0,0,.75);
    }
    #{{ $uid }}[data-style="glass"] .rj-stat-card:hover {
        translate: 0 -6px; border-color: hsl(var(--c) 90% 72% / .45);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.26), 0 34px 54px -26px hsl(var(--c) 90% 50% / .45);
    }
    #{{ $uid }}[data-style="minimal"] .rj-stat-card { padding: 20px; background: none; border: 0; box-shadow: none; }

    /* lamp line on the top edge */
    #{{ $uid }} .rj-stat-card::before {
        content: ''; position: absolute; top: 0; left: 15%; right: 15%; height: 2px; z-index: 3; pointer-events: none; transform: scaleX(.35);
        background: linear-gradient(90deg, transparent, hsl(var(--c) 100% 88%), transparent); box-shadow: 0 0 18px 2px hsl(var(--c) 95% 65% / .75);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-stat-card:hover::before { transform: none; }
    #{{ $uid }}[data-style="minimal"] .rj-stat-card::before,
    #{{ $uid }}[data-style="minimal"] .rj-stat-light,
    #{{ $uid }}[data-style="minimal"] .rj-stat-sheen,
    #{{ $uid }}[data-style="minimal"] .rj-stat-bar { display: none; }

    /* cursor light (moved by JS with transform only) */
    #{{ $uid }} .rj-stat-light {
        position: absolute; left: 0; top: 0; width: 300px; height: 300px; z-index: 0; pointer-events: none; opacity: 0; will-change: transform, opacity;
        transform: translate3d(-40px, -60px, 0); background: radial-gradient(circle closest-side, hsl(var(--c) 95% 70% / .2), transparent); transition: opacity .4s;
    }
    #{{ $uid }} .rj-stat-card:hover .rj-stat-light { opacity: 1; }

    /* specular sweep, plays once when the number finishes counting */
    #{{ $uid }} .rj-stat-sheen {
        position: absolute; top: -20%; bottom: -20%; left: 0; width: 55%; z-index: 1; pointer-events: none; opacity: 0;
        transform: translateX(-120%) skewX(-18deg); background: linear-gradient(90deg, transparent, rgba(255,255,255,.12) 50%, transparent);
    }
    #{{ $uid }} .rj-stat-card.is-done .rj-stat-sheen { animation: rjStSheen 1.4s ease-out .1s 1 both; }
    @keyframes rjStSheen { 0% { opacity: 1; transform: translateX(-120%) skewX(-18deg); } 100% { opacity: 1; transform: translateX(260%) skewX(-18deg); } }

    #{{ $uid }} .rj-stat-card > *:not(.rj-stat-light):not(.rj-stat-sheen) { position: relative; z-index: 2; }

    /* ---------- Icon ---------- */
    #{{ $uid }} .rj-stat-icon {
        position: relative; display: flex; align-items: center; justify-content: center; width: 58px; height: 58px; margin-bottom: 22px; border-radius: 16px;
        color: hsl(var(--c) 95% 86%); background: linear-gradient(160deg, hsl(var(--c) 90% 65% / .3), hsl(var(--c) 90% 55% / .08));
        border: 1px solid hsl(var(--c) 90% 78% / .35); box-shadow: inset 0 1px 0 rgba(255,255,255,.3), 0 10px 26px -10px hsl(var(--c) 95% 55% / .65);
        transition: transform .5s cubic-bezier(.16,1,.3,1);
    }
    #{{ $uid }} .rj-stat-icon::after { content: ''; position: absolute; inset: 0; border-radius: inherit; border: 1px solid hsl(var(--c) 95% 75% / .6); opacity: 0; }
    #{{ $uid }} .rj-stat-card:hover .rj-stat-icon { transform: translateY(-2px) rotate(-6deg) scale(1.08); }
    #{{ $uid }} .rj-stat-card:hover .rj-stat-icon::after { animation: rjStPing 1.6s ease-out infinite; }
    #{{ $uid }} .rj-stat-icon svg { width: 26px; height: 26px; }
    @keyframes rjStPing { from { opacity: .8; transform: scale(1); } to { opacity: 0; transform: scale(1.7); } }

    /* ---------- Value + label ---------- */
    #{{ $uid }} .rj-stat-value {
        margin: 0 0 10px; font-size: clamp(38px, 5vw, 56px); font-weight: 500; line-height: 1.05; letter-spacing: -.045em; font-variant-numeric: tabular-nums;
        background: linear-gradient(180deg, #fff 25%, hsl(var(--c) 85% 82%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .rj-stat-label {
        margin: 0; font: 700 12px/1.4 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.62);
    }

    /* thin bar that fills while the number counts */
    #{{ $uid }} .rj-stat-bar { display: block; width: 44px; height: 2px; margin-top: 22px; border-radius: 2px; background: rgba(255,255,255,.1); overflow: hidden; }
    #{{ $uid }} .rj-stat-bar i { display: block; height: 100%; transform: scaleX(0); transform-origin: left; background: hsl(var(--c) 95% 70%); box-shadow: 0 0 10px hsl(var(--c) 95% 60% / .8); }
    #{{ $uid }}.is-in .rj-stat-bar i { animation: rjStFill 2s cubic-bezier(.16,1,.3,1) calc(var(--i) * .1s) forwards; }
    @keyframes rjStFill { to { transform: scaleX(1); } }

    /* reveal */
    #{{ $uid }}.rj-js:not(.is-in) .rj-stat-card { opacity: 0; }
    #{{ $uid }}.is-in .rj-stat-card { animation: rjStIn .8s cubic-bezier(.2,.8,.2,1) calc(var(--i) * .1s) backwards; }
    @keyframes rjStIn { from { opacity: 0; translate: 0 30px; } }

    @media (max-width: 768px) {
        #{{ $uid }} { padding: 56px 20px; }
        #{{ $uid }} .rj-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        #{{ $uid }} .rj-stat-card { padding: 28px 14px 26px; }
        #{{ $uid }} .rj-stat-icon { width: 50px; height: 50px; margin-bottom: 16px; }
        #{{ $uid }} .rj-stat-value { font-size: 34px; }
        #{{ $uid }} .rj-stat-label { font-size: 11px; }
    }
    @media (max-width: 480px) {
        #{{ $uid }} .rj-stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div id="{{ $uid }}" data-style="{{ $style }}">
    <div class="rj-stats-container">
        @if(!empty($settings['title']) || !empty($settings['subtitle']))
            <div class="rj-stats-head">
                @if(!empty($settings['title']))<h2 class="rj-stats-title">{{ $settings['title'] }}</h2>@endif
                @if(!empty($settings['subtitle']))<p class="rj-stats-sub">{{ $settings['subtitle'] }}</p>@endif
            </div>
        @endif

        <div class="rj-stats-grid">
            @foreach($stats as $i => $stat)
                <div class="rj-stat-card" style="--i: {{ $i }};">
                    <span class="rj-stat-light"></span>
                    <span class="rj-stat-sheen"></span>

                    @if(!empty($stat['icon']) && function_exists('rj_icon'))
                        <div class="rj-stat-icon">{!! rj_icon($stat['icon']) !!}</div>
                    @endif

                    <div class="rj-stat-value" data-target="{{ $stat['value'] ?? '0' }}">{{ $stat['value'] ?? '0' }}</div>
                    <p class="rj-stat-label">{{ $stat['label'] ?? '' }}</p>
                    <span class="rj-stat-bar"><i></i></span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    root.classList.add('rj-js');

    var cards = root.querySelectorAll('.rj-stat-card');
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // "$1,250.5M" -> prefix "$", number 1250.5, suffix "M"; keeps decimals and thousand separators
    function parse(str) {
        var m = String(str).match(/^(.*?)(\d[\d,]*\.?\d*)(.*)$/);
        if (!m) return null;
        var raw = m[2];
        return {
            pre: m[1], suf: m[3], num: parseFloat(raw.replace(/,/g, '')),
            dec: raw.indexOf('.') > -1 ? raw.split('.')[1].length : 0, sep: raw.indexOf(',') > -1
        };
    }
    function fmt(p, v) {
        return p.pre + v.toLocaleString('en-US', { minimumFractionDigits: p.dec, maximumFractionDigits: p.dec, useGrouping: p.sep }) + p.suf;
    }

    function count(card) {
        var el = card.querySelector('.rj-stat-value');
        var p = parse(el.getAttribute('data-target'));
        if (!p || reduce) { card.classList.add('is-done'); return; }
        var t0 = null;
        (function step(t) {
            if (t0 === null) t0 = t;
            var k = Math.min((t - t0) / 2000, 1), e = 1 - Math.pow(1 - k, 4);
            el.textContent = fmt(p, p.num * e);
            if (k < 1) requestAnimationFrame(step); else card.classList.add('is-done');
        })(performance.now());
    }

    // start from 0 right before the reveal (so nothing flashes if JS is slow)
    cards.forEach(function (c) {
        var el = c.querySelector('.rj-stat-value'), p = parse(el.getAttribute('data-target'));
        if (p && !reduce) el.textContent = fmt(p, 0);
    });

    function start() {
        root.classList.add('is-in');
        cards.forEach(function (c, i) { setTimeout(function () { count(c); }, i * 100); });
    }
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { start(); o.disconnect(); } }, { threshold: 0.25 }).observe(root);
    } else { start(); }

    // cursor light: one transform write per frame, no CSS-variable updates
    if (window.matchMedia && window.matchMedia('(hover: hover)').matches) {
        cards.forEach(function (c) {
            var light = c.querySelector('.rj-stat-light'), raf = 0, px = 0, py = 0;
            function frame() {
                raf = 0;
                var r = c.getBoundingClientRect();
                light.style.transform = 'translate3d(' + (px - r.left - 150) + 'px,' + (py - r.top - 150) + 'px,0)';
            }
            c.addEventListener('pointermove', function (e) { px = e.clientX; py = e.clientY; if (!raf) raf = requestAnimationFrame(frame); });
        });
    }
})();
</script>