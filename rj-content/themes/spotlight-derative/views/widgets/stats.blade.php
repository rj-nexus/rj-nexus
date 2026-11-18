@php
    $uid = $uid ?? ('stats_' . substr(md5(uniqid('', true)), 0, 8));
    $style = ($settings['style'] ?? 'glass') === 'minimal' ? 'minimal' : 'glass';
    $hue   = max(0, min(360, (int) ($settings['hue'] ?? 217)));   // only a very soft tint on the icons
    $stats = $settings['stats'] ?? [];
    if (!is_array($stats)) $stats = [];
    $stats = array_slice(array_values($stats), 0, 8);
@endphp

<style>
    /*
     * Glass without backdrop-filter (no lag over the animated starfield): translucent layers,
     * hairline edges, a top reflection and a light that follows the cursor (transform only).
     * Every effect lives inside its card, nothing leaks outside.
     */
    #{{ $uid }} {
        --h: {{ $hue }};
        width: 100%; padding: 88px 24px; background: transparent; color: #fff;
        font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
        -webkit-font-smoothing: antialiased;
    }
    #{{ $uid }} .rj-stats-container { max-width: var(--rj-container, 1200px); margin: 0 auto; }

    #{{ $uid }} .rj-stats-head { text-align: center; margin-bottom: 52px; }
    #{{ $uid }} .rj-stats-title { margin: 0; font-size: clamp(28px, 4vw, 44px); font-weight: 600; line-height: 1.1; letter-spacing: -.04em; color: #fff; }
    #{{ $uid }} .rj-stats-sub { margin: 14px auto 0; max-width: 560px; font-size: clamp(15px, 1.8vw, 17px); line-height: 1.6; color: rgba(255,255,255,.62); }

    #{{ $uid }} .rj-stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 20px; }

    /* ---------- Card ---------- */
    #{{ $uid }} .rj-stat-card {
        --c: calc(var(--h) + var(--i) * 14);
        position: relative; isolation: isolate; overflow: hidden;
        display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
        padding: 44px 24px 38px; border-radius: 24px; -webkit-tap-highlight-color: transparent;
        transition: translate .5s cubic-bezier(.32,.72,0,1), scale .35s cubic-bezier(.32,.72,0,1), background .4s ease;
    }
    #{{ $uid }}[data-style="glass"] .rj-stat-card {
        background: linear-gradient(180deg, rgba(255,255,255,.09) 0%, rgba(255,255,255,.04) 100%);
        box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.24);
    }
    /* top reflection of the glass */
    #{{ $uid }} .rj-stat-card::after {
        content: ''; position: absolute; left: 0; right: 0; top: 0; height: 50%; z-index: 0; pointer-events: none;
        background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,0));
    }
    /* thin lamp on the top edge */
    #{{ $uid }} .rj-stat-card::before {
        content: ''; position: absolute; top: 0; left: 18%; right: 18%; height: 1px; z-index: 3; pointer-events: none;
        background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,.85), rgba(255,255,255,0));
        opacity: .35; transform: scaleX(.4); transition: transform .7s cubic-bezier(.32,.72,0,1), opacity .5s ease;
    }
    #{{ $uid }}[data-style="minimal"] .rj-stat-card { padding: 20px; background: none; box-shadow: none; }
    #{{ $uid }}[data-style="minimal"] .rj-stat-card::before,
    #{{ $uid }}[data-style="minimal"] .rj-stat-card::after,
    #{{ $uid }}[data-style="minimal"] .rj-stat-light,
    #{{ $uid }}[data-style="minimal"] .rj-stat-sheen,
    #{{ $uid }}[data-style="minimal"] .rj-stat-bar { display: none; }

    /* hover only where a real hover exists; touch gets a press instead */
    @media (hover: hover) {
        #{{ $uid }}[data-style="glass"] .rj-stat-card:hover {
            translate: 0 -6px; background: linear-gradient(180deg, rgba(255,255,255,.12) 0%, rgba(255,255,255,.055) 100%);
        }
        #{{ $uid }} .rj-stat-card:hover::before { transform: none; opacity: 1; }
        #{{ $uid }} .rj-stat-card:hover .rj-stat-light { opacity: 1; }
        #{{ $uid }} .rj-stat-card:hover .rj-stat-icon { transform: translateY(-2px) scale(1.07); }
    }
    @media (hover: none) {
        #{{ $uid }} .rj-stat-card:active { scale: .97; }
    }

    /* cursor light (JS moves it with transform only) */
    #{{ $uid }} .rj-stat-light {
        position: absolute; left: 0; top: 0; width: 320px; height: 320px; z-index: 0; pointer-events: none; opacity: 0; will-change: transform, opacity;
        transform: translate3d(-40px, -60px, 0); background: radial-gradient(circle closest-side, rgba(255,255,255,.14), rgba(255,255,255,0)); transition: opacity .4s ease;
    }

    /* specular sweep: plays once when the digits settle (and on every tap/click replay) */
    #{{ $uid }} .rj-stat-sheen {
        position: absolute; top: -20%; bottom: -20%; left: 0; width: 55%; z-index: 1; pointer-events: none; opacity: 0;
        transform: translateX(-120%) skewX(-18deg); background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,.14) 50%, rgba(255,255,255,0));
    }
    #{{ $uid }} .rj-stat-card.is-done .rj-stat-sheen { animation: rjStSheen 1.4s ease-out 1 both; }
    @keyframes rjStSheen { 0% { opacity: 1; transform: translateX(-120%) skewX(-18deg); } 100% { opacity: 1; transform: translateX(260%) skewX(-18deg); } }

    #{{ $uid }} .rj-stat-card > *:not(.rj-stat-light):not(.rj-stat-sheen) { position: relative; z-index: 2; }

    /* ---------- Icon ---------- */
    #{{ $uid }} .rj-stat-icon {
        display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; margin-bottom: 22px; border-radius: 17px;
        color: hsl(var(--c) 85% 90%);
        background: linear-gradient(180deg, hsl(var(--c) 80% 70% / .2), rgba(255,255,255,.05));
        box-shadow: inset 0 0 0 .5px rgba(255,255,255,.26), inset 0 1px 0 rgba(255,255,255,.34);
        transition: transform .6s cubic-bezier(.32,.72,0,1);
    }
    #{{ $uid }} .rj-stat-icon svg { width: 26px; height: 26px; }

    /* ---------- Rolling-digit odometer ---------- */
    #{{ $uid }} .rj-stat-value {
        display: flex; justify-content: center; align-items: center; margin: 0 0 12px; max-width: 100%;
        font-size: clamp(38px, 5vw, 56px); font-weight: 600; line-height: 1.1; letter-spacing: -.04em; font-variant-numeric: tabular-nums; color: #fff;
    }
    #{{ $uid }} .rj-od-wrap { display: inline-flex; align-items: center; white-space: pre; }
    #{{ $uid }} .rj-od {
        display: inline-block; height: 1.1em; overflow: hidden;
        -webkit-mask-image: linear-gradient(180deg, transparent 0, #000 16%, #000 84%, transparent 100%);
                mask-image: linear-gradient(180deg, transparent 0, #000 16%, #000 84%, transparent 100%);
    }
    #{{ $uid }} .rj-od-strip { display: block; will-change: transform; }
    #{{ $uid }} .rj-od-strip i { display: block; height: 1.1em; line-height: 1.1em; font-style: normal; }
    #{{ $uid }} .rj-od-ch { display: inline-block; line-height: 1.1em; }
    #{{ $uid }} .rj-od-pre { font-size: .56em; align-self: flex-start; margin: .22em .08em 0 0; opacity: .8; }
    #{{ $uid }} .rj-od-suf { font-size: .56em; align-self: flex-end; margin: 0 0 .2em .1em; opacity: .85; }
    /* screen readers get the real text, sighted users get the rolling digits */
    #{{ $uid }}.rj-od-on .rj-sr { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; border: 0; }

    #{{ $uid }} .rj-stat-label {
        margin: 0; font: 700 12px/1.45 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.6);
    }

    /* thin bar that fills while the digits roll */
    #{{ $uid }} .rj-stat-bar { display: block; width: 44px; height: 2px; margin-top: 22px; border-radius: 2px; background: rgba(255,255,255,.12); overflow: hidden; }
    #{{ $uid }} .rj-stat-bar i { display: block; height: 100%; transform: scaleX(0); transform-origin: left; background: rgba(255,255,255,.85); }
    #{{ $uid }}.is-in .rj-stat-bar i { animation: rjStFill 2s cubic-bezier(.16,1,.3,1) calc(var(--i) * .1s) forwards; }
    @keyframes rjStFill { to { transform: scaleX(1); } }

    /* reveal */
    #{{ $uid }}.rj-js:not(.is-in) .rj-stat-card { opacity: 0; }
    #{{ $uid }}.is-in .rj-stat-card { animation: rjStIn .9s cubic-bezier(.32,.72,0,1) calc(var(--i) * .09s) backwards; }
    @keyframes rjStIn { from { opacity: 0; translate: 0 28px; filter: blur(6px); } }

    /* ---------- Mobile: compact 2-column grid, last odd card spans full width ---------- */
    @media (max-width: 640px) {
        #{{ $uid }} { padding: 56px 16px; }
        #{{ $uid }} .rj-stats-head { margin-bottom: 32px; }
        #{{ $uid }} .rj-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        #{{ $uid }} .rj-stat-card:last-child:nth-child(odd) { grid-column: 1 / -1; }
        #{{ $uid }} .rj-stat-card { padding: 26px 12px 22px; border-radius: 20px; }
        #{{ $uid }} .rj-stat-icon { width: 46px; height: 46px; margin-bottom: 16px; border-radius: 14px; }
        #{{ $uid }} .rj-stat-icon svg { width: 22px; height: 22px; }
        #{{ $uid }} .rj-stat-value { font-size: 34px; margin-bottom: 8px; }
        #{{ $uid }} .rj-stat-label { font-size: 10.5px; letter-spacing: .1em; }
        #{{ $uid }} .rj-stat-bar { width: 32px; margin-top: 16px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01s !important; }
        #{{ $uid }}.rj-js:not(.is-in) .rj-stat-card { opacity: 1; }
        #{{ $uid }} .rj-stat-bar i { transform: scaleX(1); }
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

                    <div class="rj-stat-value" data-target="{{ $stat['value'] ?? '0' }}"><span class="rj-sr">{{ $stat['value'] ?? '0' }}</span></div>
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

    var cards = Array.prototype.slice.call(root.querySelectorAll('.rj-stat-card'));
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Build the odometer: every digit becomes a window onto a 0-9-0-9 strip, other characters stay put.
       "$1,250.5M" -> "$" (small, raised) 1 , 2 5 0 . 5 and "M" (small, on the baseline) */
    function build(card) {
        var el = card.querySelector('.rj-stat-value');
        var text = String(el.getAttribute('data-target') || '');
        var first = text.search(/\d/);
        if (first === -1) { card._od = null; return; }          // nothing to roll, keep the plain text
        var last = text.length - 1 - text.split('').reverse().join('').search(/\d/);

        var wrap = document.createElement('span');
        wrap.className = 'rj-od-wrap';
        wrap.setAttribute('aria-hidden', 'true');
        var strips = [];

        for (var i = 0; i < text.length; i++) {
            var ch = text.charAt(i);
            if (/\d/.test(ch)) {
                var od = document.createElement('span'); od.className = 'rj-od';
                var strip = document.createElement('span'); strip.className = 'rj-od-strip';
                for (var r = 0; r < 20; r++) { var row = document.createElement('i'); row.textContent = String(r % 10); strip.appendChild(row); }
                od.appendChild(strip); wrap.appendChild(od);
                strips.push({ strip: strip, d: parseInt(ch, 10) });
            } else {
                var s = document.createElement('span');
                s.className = 'rj-od-ch' + (i < first ? ' rj-od-pre' : (i > last ? ' rj-od-suf' : ''));
                s.textContent = ch;
                wrap.appendChild(s);
            }
        }
        el.appendChild(wrap);
        card._od = strips;
        root.classList.add('rj-od-on');
    }

    /* roll every digit to its target (20 rows, 5% each -> row 10+d shows the digit d after one full spin) */
    function roll(card) {
        card.classList.remove('is-done');
        var strips = card._od;
        if (!strips) { card.classList.add('is-done'); return; }
        var jobs = [];
        strips.forEach(function (o, i) {
            var to = 'translateY(' + (-(10 + o.d) * 5) + '%)';
            if (o.anim) o.anim.cancel();
            if (reduce || !o.strip.animate) { o.strip.style.transform = to; return; }
            o.anim = o.strip.animate(
                [{ transform: 'translateY(0%)' }, { transform: to }],
                { duration: 1500 + i * 120, delay: i * 70, easing: 'cubic-bezier(.16,1,.3,1)', fill: 'forwards' }
            );
            jobs.push(o.anim.finished);
        });
        Promise.all(jobs).then(function () { void card.offsetWidth; card.classList.add('is-done'); }).catch(function () {});
    }

    /* shrink the number if it does not fit the card (small phones, long values like 1,250.5M) */
    function fit(card) {
        var el = card.querySelector('.rj-stat-value'), wrap = el.querySelector('.rj-od-wrap');
        if (!wrap) return;
        el.style.fontSize = '';
        var cs = getComputedStyle(card);
        var avail = card.clientWidth - parseFloat(cs.paddingLeft) - parseFloat(cs.paddingRight);
        var w = wrap.getBoundingClientRect().width;
        if (w > avail && avail > 0) {
            el.style.fontSize = (parseFloat(getComputedStyle(el).fontSize) * avail / w * 0.97) + 'px';
        }
    }

    cards.forEach(build);
    cards.forEach(fit);
    var fitQueued = false;
    function refit() { if (fitQueued) return; fitQueued = true; requestAnimationFrame(function () { fitQueued = false; cards.forEach(fit); }); }
    if ('ResizeObserver' in window) new ResizeObserver(refit).observe(root); else window.addEventListener('resize', refit);

    var started = false;
    function start() {
        started = true;
        root.classList.add('is-in');
        cards.forEach(function (c, i) { setTimeout(function () { roll(c); }, i * 100); });
    }
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { start(); o.disconnect(); } }, { threshold: 0.2 }).observe(root);
    } else { start(); }

    /* tap or click a card to roll its numbers again */
    cards.forEach(function (c) {
        c.addEventListener('click', function () { if (started) roll(c); });
    });

    /* cursor light: one transform write per frame, no CSS-variable updates */
    if (window.matchMedia && window.matchMedia('(hover: hover)').matches) {
        cards.forEach(function (c) {
            var light = c.querySelector('.rj-stat-light'), raf = 0, px = 0, py = 0;
            function frame() {
                raf = 0;
                var r = c.getBoundingClientRect();
                light.style.transform = 'translate3d(' + (px - r.left - 160) + 'px,' + (py - r.top - 160) + 'px,0)';
            }
            c.addEventListener('pointermove', function (e) { px = e.clientX; py = e.clientY; if (!raf) raf = requestAnimationFrame(frame); });
        });
    }
})();
</script>