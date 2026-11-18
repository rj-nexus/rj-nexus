@php
    $uid   = $uid ?? ('cta_' . substr(md5(uniqid('', true)), 0, 8));
    $style = in_array(($settings['style'] ?? 'gradient'), ['dark', 'glass', 'gradient'], true) ? ($settings['style'] ?? 'gradient') : 'gradient';
    // optional "hue" setting (0-360); otherwise violet for "gradient", blue for the others
    $hue   = isset($settings['hue']) && $settings['hue'] !== '' ? max(0, min(360, (int) $settings['hue'])) : ($style === 'gradient' ? 262 : 217);
@endphp

<style>
    /*
     * All three styles are glass now (they only differ in tint). No backdrop-filter and no animated filters:
     * everything that moves uses transform/opacity only, and pauses while the block is off-screen.
     */
    #{{ $uid }} { --h: {{ $hue }}; width: 100%; padding: 96px 24px; background: transparent; font-family: var(--rj-font-body); }
    #{{ $uid }}[data-style="gradient"] { --base: rgba(12, 9, 34, .88); --ta: .36; --tb: .28; }
    #{{ $uid }}[data-style="glass"]    { --base: rgba(12, 16, 30, .70); --ta: .17; --tb: .11; }
    #{{ $uid }}[data-style="dark"]     { --base: rgba(8, 10, 20, .92);  --ta: .09; --tb: .05; }
    #{{ $uid }}:not(.is-live) *, #{{ $uid }}:not(.is-live) *::before, #{{ $uid }}:not(.is-live) *::after { animation-play-state: paused !important; }

    /* ---------- Wrapper ---------- */
    #{{ $uid }} .rj-cta-wrap {
        position: relative; max-width: var(--rj-container, 1200px); margin: 0 auto; border-radius: 30px; overflow: hidden; isolation: isolate; text-align: center;
        padding: 88px 32px; box-shadow: 0 40px 80px -40px rgba(0,0,0,.9), 0 0 80px -30px hsl(var(--h) 90% 55% / .5);
    }
    #{{ $uid }}.rj-js:not(.is-in) .rj-cta-wrap { opacity: 0; }
    #{{ $uid }}.is-in .rj-cta-wrap { animation: rjCtaIn .9s cubic-bezier(.2,.8,.2,1) backwards; }
    @keyframes rjCtaIn { from { opacity: 0; translate: 0 36px; scale: .98; } }

    /* border light: a huge conic gradient that only rotates, seen through a 1px gap */
    #{{ $uid }} .rj-cta-beam {
        position: absolute; left: 50%; top: 50%; width: 220%; aspect-ratio: 1; translate: -50% -50%; z-index: 0; pointer-events: none; will-change: transform;
        background: conic-gradient(from 0deg, rgba(255,255,255,.1) 0 55%, hsl(var(--h) 95% 68%) 74%, hsl(calc(var(--h) + 60) 90% 66%) 88%, rgba(255,255,255,.1) 100%);
        animation: rjCtaSpin 10s linear infinite;
    }
    #{{ $uid }}[data-style="dark"] .rj-cta-beam { animation: none; background: rgba(255,255,255,.1); }
    @keyframes rjCtaSpin { to { rotate: 360deg; } }

    /* glass panel */
    #{{ $uid }} .rj-cta-panel {
        position: absolute; inset: 1px; z-index: 1; border-radius: 29px; overflow: hidden; pointer-events: none;
        background:
            radial-gradient(60% 80% at 50% 115%, hsl(var(--h) 85% 58% / var(--ta)), transparent 70%),
            radial-gradient(45% 60% at 88% 8%, hsl(calc(var(--h) + 60) 85% 58% / var(--tb)), transparent 65%),
            linear-gradient(155deg, rgba(255,255,255,.09), rgba(255,255,255,.015) 40%, rgba(255,255,255,.045)),
            var(--base);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.26), inset 0 0 0 1px rgba(255,255,255,.04);
    }

    /* drifting colour orbs (plain gradients, moved with transform) */
    #{{ $uid }} .rj-cta-orb { position: absolute; width: 46%; aspect-ratio: 1; border-radius: 50%; will-change: transform; }
    #{{ $uid }} .rj-cta-orb.o1 { left: -10%; top: -30%; background: radial-gradient(circle closest-side, hsl(var(--h) 90% 60% / .38), transparent); animation: rjCtaDrift1 16s ease-in-out infinite alternate; }
    #{{ $uid }} .rj-cta-orb.o2 { right: -12%; bottom: -35%; background: radial-gradient(circle closest-side, hsl(calc(var(--h) + 60) 90% 62% / .32), transparent); animation: rjCtaDrift2 19s ease-in-out infinite alternate; }
    @keyframes rjCtaDrift1 { to { transform: translate3d(22%, 18%, 0) scale(1.15); } }
    @keyframes rjCtaDrift2 { to { transform: translate3d(-24%, -14%, 0) scale(1.2); } }

    /* perspective grid floor: the lines slide toward the viewer */
    #{{ $uid }} .rj-cta-floor {
        position: absolute; left: -25%; right: -25%; bottom: -8%; height: 62%; overflow: hidden; transform-origin: 50% 100%; transform: perspective(520px) rotateX(64deg);
        -webkit-mask-image: linear-gradient(to top, #000 5%, transparent 85%); mask-image: linear-gradient(to top, #000 5%, transparent 85%);
    }
    #{{ $uid }} .rj-cta-floor i {
        position: absolute; left: 0; right: 0; top: -56px; bottom: 0; will-change: transform;
        background-image: linear-gradient(hsl(var(--h) 90% 78% / .4) 1px, transparent 1px), linear-gradient(90deg, hsl(var(--h) 90% 78% / .4) 1px, transparent 1px);
        background-size: 56px 56px; animation: rjCtaFloor 2.6s linear infinite;
    }
    @keyframes rjCtaFloor { to { transform: translateY(56px); } }

    /* light falling from the top + lamp line */
    #{{ $uid }} .rj-cta-cone { position: absolute; top: 0; left: 15%; right: 15%; height: 75%; background: radial-gradient(ellipse 50% 100% at 50% 0%, hsl(var(--h) 95% 76% / .26), transparent 72%); }
    #{{ $uid }} .rj-cta-cone::before {
        content: ''; position: absolute; top: 0; left: 28%; right: 28%; height: 2px;
        background: linear-gradient(90deg, transparent, hsl(var(--h) 100% 90%), transparent); box-shadow: 0 0 20px 3px hsl(var(--h) 95% 68% / .8);
    }

    /* rising sparks */
    #{{ $uid }} .rj-cta-p {
        position: absolute; bottom: -8px; left: var(--x); width: 5px; height: 5px; border-radius: 50%; opacity: 0;
        background: radial-gradient(circle, #fff 0 25%, hsl(var(--h) 95% 72% / .6) 55%, transparent 72%); animation: rjCtaRise var(--t) ease-out var(--d) infinite;
    }
    @keyframes rjCtaRise { 0% { transform: translateY(0) scale(.6); opacity: 0; } 15% { opacity: 1; } 100% { transform: translateY(-340px) scale(1.1); opacity: 0; } }

    /* specular sheen across the whole panel */
    #{{ $uid }} .rj-cta-sheen {
        position: absolute; top: -20%; bottom: -20%; left: 0; width: 45%; opacity: 0; transform: translateX(-130%) skewX(-18deg);
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.08) 50%, transparent); animation: rjCtaSheen 9s ease-in-out 1.5s infinite;
    }
    @keyframes rjCtaSheen { 0% { opacity: 1; transform: translateX(-130%) skewX(-18deg); } 22%, 100% { opacity: 1; transform: translateX(330%) skewX(-18deg); } }

    /* cursor light (desktop only, moved with transform by JS) */
    #{{ $uid }} .rj-cta-light {
        position: absolute; left: 0; top: 0; width: 460px; height: 460px; z-index: 2; pointer-events: none; opacity: 0; will-change: transform, opacity;
        transform: translate3d(40px, 20px, 0); background: radial-gradient(circle closest-side, hsl(var(--h) 95% 72% / .15), transparent); transition: opacity .5s;
    }
    #{{ $uid }} .rj-cta-wrap:hover .rj-cta-light { opacity: 1; }

    /* ---------- Content ---------- */
    #{{ $uid }} .rj-cta-content { position: relative; z-index: 3; max-width: 680px; margin: 0 auto; }
    #{{ $uid }} .rj-cta-title {
        margin: 0 0 20px; font-size: clamp(32px, 5vw, 54px); font-weight: 500; line-height: 1.08; letter-spacing: -.04em;
        background: linear-gradient(180deg, #fff 30%, hsl(var(--h) 80% 88%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .rj-cta-subtitle { margin: 0 0 42px; font-size: clamp(16px, 2vw, 19px); line-height: 1.6; color: rgba(255,255,255,.7); }

    /* glass button */
    #{{ $uid }} .rj-cta-btnwrap { position: relative; display: inline-block; }
    #{{ $uid }} .rj-cta-btnglow {
        position: absolute; inset: -45% -16%; pointer-events: none; opacity: .55; animation: rjCtaBreathe 4.5s ease-in-out infinite;
        background: radial-gradient(closest-side, hsl(var(--h) 95% 62% / .55), transparent); transition: transform .4s;
    }
    @keyframes rjCtaBreathe { 0%, 100% { opacity: .4; } 50% { opacity: .85; } }
    #{{ $uid }} .rj-cta-btnwrap:hover .rj-cta-btnglow { transform: scale(1.12); }
    #{{ $uid }} .rj-cta-btn {
        position: relative; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; gap: 12px; padding: 17px 38px; border-radius: 18px;
        font-size: 16px; font-weight: 600; letter-spacing: .01em; text-decoration: none; color: #fff;
        background: linear-gradient(160deg, rgba(255,255,255,.22), rgba(255,255,255,.06)), hsl(var(--h) 80% 50% / .2);
        border: 1px solid rgba(255,255,255,.32);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.5), inset 0 -1px 0 rgba(255,255,255,.08), 0 18px 36px -14px hsl(var(--h) 95% 55% / .8);
        transition: transform .3s cubic-bezier(.16,1,.3,1), background .3s, border-color .3s;
    }
    #{{ $uid }} .rj-cta-btn::after { content: ''; position: absolute; inset: 0; background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.5) 50%, transparent 70%); translate: -130% 0; }
    #{{ $uid }} .rj-cta-btn:hover { transform: translateY(-3px); color: #fff; border-color: rgba(255,255,255,.55); background: linear-gradient(160deg, rgba(255,255,255,.3), rgba(255,255,255,.1)), hsl(var(--h) 85% 55% / .32); }
    #{{ $uid }} .rj-cta-btn:hover::after { translate: 130% 0; transition: translate .8s ease; }
    #{{ $uid }} .rj-cta-btn:active { transform: translateY(-1px) scale(.99); }
    #{{ $uid }} .rj-cta-btn svg { width: 18px; height: 18px; transition: transform .3s ease; }
    #{{ $uid }} .rj-cta-btn:hover svg { transform: translateX(5px); }

    /* ---------- Mobile ---------- */
    @media (max-width: 768px) {
        #{{ $uid }} { padding: 56px 16px; }
        #{{ $uid }} .rj-cta-wrap { padding: 60px 22px 64px; border-radius: 24px; }
        #{{ $uid }} .rj-cta-panel { border-radius: 23px; }
        #{{ $uid }} .rj-cta-subtitle { margin-bottom: 34px; }
        #{{ $uid }} .rj-cta-floor { height: 48%; }
        #{{ $uid }} .rj-cta-orb { width: 70%; }
        #{{ $uid }} .rj-cta-p.x { display: none; }
        #{{ $uid }} .rj-cta-btnwrap { display: block; }
        #{{ $uid }} .rj-cta-btn { display: flex; width: 100%; padding: 17px 24px; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-cta-beam, #{{ $uid }} .rj-cta-orb, #{{ $uid }} .rj-cta-floor i, #{{ $uid }} .rj-cta-p,
        #{{ $uid }} .rj-cta-sheen, #{{ $uid }} .rj-cta-btnglow { animation: none; }
    }
</style>

<div id="{{ $uid }}" data-style="{{ $style }}">
    <div class="rj-cta-wrap">
        <span class="rj-cta-beam"></span>

        <div class="rj-cta-panel">
            <span class="rj-cta-orb o1"></span>
            <span class="rj-cta-orb o2"></span>
            <div class="rj-cta-floor"><i></i></div>
            <div class="rj-cta-cone"></div>
            @for($s = 0; $s < 6; $s++)
                <span class="rj-cta-p {{ $s >= 4 ? 'x' : '' }}" style="--x: {{ ($s * 17 + 9) % 90 }}%; --d: {{ number_format($s * 0.6, 1) }}s; --t: {{ 3.4 + ($s % 3) * 0.9 }}s;"></span>
            @endfor
            <span class="rj-cta-sheen"></span>
        </div>

        <span class="rj-cta-light"></span>

        <div class="rj-cta-content">
            @if(!empty($settings['title']))
                <h2 class="rj-cta-title">{{ $settings['title'] }}</h2>
            @endif

            @if(!empty($settings['subtitle']))
                <p class="rj-cta-subtitle">{{ $settings['subtitle'] }}</p>
            @endif

            @if(!empty($settings['button_text']))
                <span class="rj-cta-btnwrap">
                    <span class="rj-cta-btnglow"></span>
                    <a href="{{ $settings['button_url'] ?? '#' }}" class="rj-cta-btn">
                        <span>{{ $settings['button_text'] }}</span>
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </span>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    root.classList.add('rj-js');

    // reveal once + run animations only while the block is on screen
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (e, o) { if (e[0].isIntersecting) { root.classList.add('is-in'); o.disconnect(); } }, { threshold: 0.15 }).observe(root);
        new IntersectionObserver(function (e) { root.classList.toggle('is-live', e[0].isIntersecting); }).observe(root);
    } else { root.classList.add('is-in', 'is-live'); }

    // cursor light: one transform write per frame (desktop only)
    if (window.matchMedia && window.matchMedia('(hover: hover)').matches) {
        var wrap = root.querySelector('.rj-cta-wrap'), light = root.querySelector('.rj-cta-light'), raf = 0, px = 0, py = 0;
        function frame() {
            raf = 0;
            var r = wrap.getBoundingClientRect();
            light.style.transform = 'translate3d(' + (px - r.left - 230) + 'px,' + (py - r.top - 230) + 'px,0)';
        }
        wrap.addEventListener('pointermove', function (e) { px = e.clientX; py = e.clientY; if (!raf) raf = requestAnimationFrame(frame); });
    }
})();
</script>