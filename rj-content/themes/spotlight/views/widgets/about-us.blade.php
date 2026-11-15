@php
    $uid = $uid ?? ('au_' . substr(md5(uniqid('', true)), 0, 8));

    $imgLeft = ($settings['image_position'] ?? 'right') === 'left';
    $hue     = max(0, min(360, (int) ($settings['hue'] ?? 262)));

    // Optional glass stat tiles: one per line "Value | Label" (e.g. "120K+ | Creators")
    $stats = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($settings['stats'] ?? '')) as $l) {
        $l = trim($l);
        if ($l === '') continue;
        [$v, $t] = array_pad(explode('|', $l, 2), 2, '');
        if (trim($v) !== '') $stats[] = ['v' => trim($v), 'l' => trim($t)];
    }
    $stats = array_slice($stats, 0, 4);
@endphp

<style>
    /*
     * Glass look WITHOUT backdrop-filter / animated filters (those make the page lag over an animated starfield).
     * Glass = translucent layers + edge highlights + a specular sheen.
     * Everything that moves uses transform / opacity only and pauses while off-screen.
     */
    #{{ $uid }} {
        --h: {{ $hue }};
        width: 100%; padding: clamp(28px, 4vw, 56px) 20px; background: transparent; font-family: inherit; box-sizing: border-box;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}:not(.is-live) *, #{{ $uid }}:not(.is-live) *::before, #{{ $uid }}:not(.is-live) *::after { animation-play-state: paused !important; }

    /* ---------- Card ---------- */
    #{{ $uid }} .rj-au-card {
        position: relative; max-width: 1120px; margin: 0 auto; border-radius: 30px; overflow: hidden; isolation: isolate;
        box-shadow: 0 40px 80px -40px rgba(0,0,0,.9), 0 0 70px -30px hsl(var(--h) 90% 55% / .45);
        animation: rj-au-in .9s cubic-bezier(.2,.8,.2,1) both;
    }
    @supports (animation-timeline: view()) {
        #{{ $uid }} .rj-au-card { animation: rj-au-in linear both; animation-timeline: view(); animation-range: entry 0% entry 45%; }
    }
    /* border light: big conic gradient that only rotates (compositor), visible through a 1px gap */
    #{{ $uid }} .rj-au-beam {
        position: absolute; left: 50%; top: 50%; width: 260%; aspect-ratio: 1; translate: -50% -50%; z-index: 0; pointer-events: none; will-change: transform;
        background: conic-gradient(from 0deg, rgba(255,255,255,.1) 0 55%, hsl(var(--h) 95% 68%) 74%, hsl(calc(var(--h) + 60) 90% 66%) 88%, rgba(255,255,255,.1) 100%);
        animation: rj-au-spin 10s linear infinite;
    }
    #{{ $uid }} .rj-au-glass {
        position: absolute; inset: 1px; z-index: 1; border-radius: 29px; overflow: hidden; pointer-events: none;
        background:
            radial-gradient(60% 70% at 8% 0%, hsl(var(--h) 85% 55% / .26), transparent 65%),
            radial-gradient(55% 65% at 100% 100%, hsl(calc(var(--h) + 60) 85% 55% / .2), transparent 65%),
            linear-gradient(155deg, rgba(255,255,255,.09), rgba(255,255,255,.015) 40%, rgba(255,255,255,.045)),
            rgba(10, 8, 26, .84);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.24), inset 0 0 0 1px rgba(255,255,255,.04), inset 0 -50px 90px -50px hsl(var(--h) 80% 50% / .25);
    }
    #{{ $uid }} .rj-au-sheen { /* diagonal specular band, slides across on hover */
        position: absolute; top: -20%; bottom: -20%; left: -10%; width: 70%; transform: translateX(-60%) skewX(-18deg);
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.07) 50%, transparent); transition: transform 1.2s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-au-card:hover .rj-au-sheen { transform: translateX(170%) skewX(-18deg); }
    #{{ $uid }} .rj-au-stars {
        position: absolute; inset: 0; opacity: .6; animation: rj-au-twinkle 6s ease-in-out infinite alternate;
        background-image:
            radial-gradient(1.5px 1.5px at 12% 22%, #fff, transparent), radial-gradient(1px 1px at 28% 78%, #c4b5fd, transparent),
            radial-gradient(1.5px 1.5px at 46% 14%, #fff, transparent), radial-gradient(1px 1px at 63% 66%, #f9a8d4, transparent),
            radial-gradient(1.5px 1.5px at 78% 30%, #fff, transparent), radial-gradient(1px 1px at 90% 82%, #93c5fd, transparent),
            radial-gradient(1px 1px at 8% 60%, #fff, transparent), radial-gradient(1.5px 1.5px at 55% 90%, #fff, transparent);
    }
    /* soft light that follows the cursor (moved by transform from JS) */
    #{{ $uid }} .rj-au-light {
        position: absolute; left: 0; top: 0; width: 440px; height: 440px; z-index: 2; pointer-events: none; opacity: 0; will-change: transform, opacity;
        transform: translate3d(40px, 20px, 0); background: radial-gradient(circle closest-side, hsl(var(--h) 95% 72% / .16), transparent); transition: opacity .5s;
    }
    #{{ $uid }} .rj-au-card:hover .rj-au-light { opacity: 1; }

    #{{ $uid }} .rj-au-grid {
        position: relative; z-index: 3; display: grid; align-items: stretch; padding: clamp(22px, 3.6vw, 42px);
        gap: clamp(22px, 3.4vw, 46px); grid-template-columns: minmax(0, 1.12fr) minmax(0, .88fr); grid-template-areas: "text media";
    }
    #{{ $uid }} .rj-au-grid.is-left { grid-template-columns: minmax(0, .88fr) minmax(0, 1.12fr); grid-template-areas: "media text"; }

    /* ---------- Text ---------- */
    #{{ $uid }} .rj-au-text { grid-area: text; align-self: center; min-width: 0; }
    #{{ $uid }} .rj-au-badge {
        display: inline-flex; align-items: center; gap: 10px; margin: 0 0 18px; padding: 7px 14px; border-radius: 999px;
        font: 700 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; text-transform: uppercase; color: hsl(var(--h) 95% 88%);
        background: linear-gradient(160deg, hsl(var(--h) 90% 65% / .2), hsl(var(--h) 90% 55% / .08)); border: 1px solid hsl(var(--h) 90% 75% / .32);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.18);
    }
    #{{ $uid }} .rj-au-badge i { position: relative; width: 7px; height: 7px; border-radius: 50%; background: hsl(var(--h) 95% 70%); }
    #{{ $uid }} .rj-au-badge i::after { content: ''; position: absolute; inset: 0; border-radius: 50%; background: inherit; animation: rj-au-ping 2s ease-out infinite; }
    #{{ $uid }} .rj-au-title {
        margin: 0; font-size: clamp(28px, 3.8vw, 44px); font-weight: 500; line-height: 1.1; letter-spacing: -.035em;
        background: linear-gradient(180deg, #fff 30%, hsl(var(--h) 80% 86%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
    }
    #{{ $uid }} .rj-au-title::after {
        content: ''; display: block; width: 56px; height: 3px; margin-top: 18px; border-radius: 3px;
        background: linear-gradient(90deg, hsl(var(--h) 90% 62%), hsl(calc(var(--h) + 60) 90% 64%)); box-shadow: 0 0 14px hsl(var(--h) 95% 60% / .7);
    }
    #{{ $uid }} .rj-au-content { margin: 20px 0 0; max-width: 60ch; font-size: 16px; line-height: 1.7; color: rgba(255,255,255,.72); }

    /* glass stat tiles (optional) */
    #{{ $uid }} .rj-au-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 12px; margin-top: 26px; max-width: 520px; }
    #{{ $uid }} .rj-au-stat {
        padding: 14px 16px; border-radius: 16px; background: linear-gradient(160deg, rgba(255,255,255,.1), rgba(255,255,255,.03));
        border: 1px solid rgba(255,255,255,.1); box-shadow: inset 0 1px 0 rgba(255,255,255,.18); transition: transform .35s cubic-bezier(.2,.8,.2,1), border-color .35s;
    }
    #{{ $uid }} .rj-au-stat:hover { transform: translateY(-3px); border-color: hsl(var(--h) 90% 72% / .5); }
    #{{ $uid }} .rj-au-stat b { display: block; font-size: 24px; font-weight: 500; letter-spacing: -.03em; color: #fff; }
    #{{ $uid }} .rj-au-stat span { display: block; margin-top: 4px; font: 700 10px/1.3 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .12em; text-transform: uppercase; color: hsl(var(--h) 90% 80% / .8); }

    #{{ $uid }} .rj-au-btn {
        position: relative; overflow: hidden; display: inline-flex; align-items: center; gap: 10px; margin-top: 28px; padding: 14px 26px; border-radius: 14px;
        font-size: 15px; font-weight: 600; text-decoration: none; color: #fff;
        background: linear-gradient(135deg, hsl(var(--h) 85% 58%), hsl(calc(var(--h) + 60) 85% 58%)); border: 1px solid rgba(255,255,255,.25);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.35), 0 14px 30px -12px hsl(var(--h) 90% 55% / .8); transition: transform .25s ease;
    }
    #{{ $uid }} .rj-au-btn::after { content: ''; position: absolute; inset: 0; background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.45) 50%, transparent 70%); translate: -130% 0; }
    #{{ $uid }} .rj-au-btn:hover { transform: translateY(-2px); color: #fff; }
    #{{ $uid }} .rj-au-btn:hover::after { translate: 130% 0; transition: translate .7s ease; }
    #{{ $uid }} .rj-au-btn svg { transition: transform .25s ease; }
    #{{ $uid }} .rj-au-btn:hover svg { transform: translateX(4px); }

    /* ---------- Media: image inside a glass bezel ---------- */
    #{{ $uid }} .rj-au-media-wrap { grid-area: media; position: relative; min-width: 0; min-height: 260px; animation: rj-au-float 8s ease-in-out infinite; }
    #{{ $uid }} .rj-au-aura { position: absolute; inset: -12%; pointer-events: none; background: radial-gradient(closest-side, hsl(var(--h) 90% 60% / .38), transparent 72%); animation: rj-au-breathe 6s ease-in-out infinite; }
    #{{ $uid }} .rj-au-frame {
        position: absolute; inset: 0; padding: 10px; border-radius: 26px;
        background: linear-gradient(150deg, rgba(255,255,255,.16), rgba(255,255,255,.04) 45%, rgba(255,255,255,.09));
        border: 1px solid rgba(255,255,255,.16); box-shadow: inset 0 1px 0 rgba(255,255,255,.3), 0 30px 60px -28px hsl(var(--h) 90% 50% / .7);
    }
    #{{ $uid }} .rj-au-media { position: relative; width: 100%; height: 100%; overflow: hidden; border-radius: 18px; background: rgba(10,8,30,.7); }
    #{{ $uid }} .rj-au-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 1s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rj-au-media:hover .rj-au-img { transform: scale(1.05); }
    #{{ $uid }} .rj-au-veil { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(180deg, hsl(var(--h) 80% 55% / .1), transparent 40%, rgba(5,4,15,.55)); }
    #{{ $uid }} .rj-au-gloss { position: absolute; inset: 0; pointer-events: none; background: linear-gradient(125deg, rgba(255,255,255,.22) 0%, rgba(255,255,255,.05) 26%, transparent 40%); }
    #{{ $uid }} .rj-au-orbit {
        position: absolute; left: 50%; top: 50%; height: 86%; aspect-ratio: 1; border-radius: 50%; border: 1px dashed rgba(255,255,255,.28);
        translate: -50% -50%; animation: rj-au-orbit 30s linear infinite; pointer-events: none;
    }
    #{{ $uid }} .rj-au-orbit::before { content: ''; position: absolute; left: 50%; top: -4px; width: 8px; height: 8px; margin-left: -4px; border-radius: 50%; background: #fff; box-shadow: 0 0 12px 3px hsl(var(--h) 95% 65% / .9); }
    #{{ $uid }} .rj-au-corner { position: absolute; width: 22px; height: 22px; border: 2px solid hsl(var(--h) 95% 82%); pointer-events: none; }
    #{{ $uid }} .rj-au-corner.tl { top: 12px; left: 12px; border-right: 0; border-bottom: 0; border-top-left-radius: 8px; }
    #{{ $uid }} .rj-au-corner.br { right: 12px; bottom: 12px; border-left: 0; border-top: 0; border-bottom-right-radius: 8px; }
    #{{ $uid }} .rj-au-empty { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: hsl(var(--h) 90% 82%); }
    #{{ $uid }} .rj-au-empty svg { width: 120px; height: 120px; animation: rj-au-float 6s ease-in-out infinite; }

    @keyframes rj-au-in { from { opacity: 0; transform: translateY(32px) scale(.98); } to { opacity: 1; transform: none; } }
    @keyframes rj-au-spin { to { rotate: 360deg; } }
    @keyframes rj-au-orbit { to { rotate: 360deg; } }
    @keyframes rj-au-float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
    @keyframes rj-au-twinkle { from { opacity: .3; } to { opacity: .8; } }
    @keyframes rj-au-breathe { 0%, 100% { opacity: .65; transform: scale(.97); } 50% { opacity: 1; transform: scale(1.04); } }
    @keyframes rj-au-ping { from { transform: scale(1); opacity: .7; } to { transform: scale(2.8); opacity: 0; } }

    @media (max-width: 820px) {
        #{{ $uid }} .rj-au-card { border-radius: 24px; }
        #{{ $uid }} .rj-au-glass { border-radius: 23px; }
        #{{ $uid }} .rj-au-grid, #{{ $uid }} .rj-au-grid.is-left { grid-template-columns: minmax(0, 1fr); grid-template-areas: "media" "text"; }
        #{{ $uid }} .rj-au-media-wrap { min-height: 0; aspect-ratio: 16 / 10; }
        #{{ $uid }} .rj-au-content { font-size: 15px; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-au-card, #{{ $uid }} .rj-au-beam, #{{ $uid }} .rj-au-stars, #{{ $uid }} .rj-au-badge i::after,
        #{{ $uid }} .rj-au-media-wrap, #{{ $uid }} .rj-au-aura, #{{ $uid }} .rj-au-orbit, #{{ $uid }} .rj-au-empty svg { animation: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-au-card">
        <span class="rj-au-beam"></span>
        <div class="rj-au-glass"><div class="rj-au-stars"></div><div class="rj-au-sheen"></div></div>
        <span class="rj-au-light"></span>

        <div class="rj-au-grid {{ $imgLeft ? 'is-left' : '' }}">
            <div class="rj-au-text">
                @if(!empty($settings['badge']))
                    <div class="rj-au-badge"><i></i>{{ $settings['badge'] }}</div>
                @endif

                @if(!empty($settings['title']))
                    <h2 class="rj-au-title">{{ $settings['title'] }}</h2>
                @endif

                @if(!empty($settings['content']))
                    <div class="rj-au-content">{!! nl2br(e($settings['content'])) !!}</div>
                @endif

                @if(!empty($stats))
                    <div class="rj-au-stats">
                        @foreach($stats as $s)
                            <div class="rj-au-stat"><b>{{ $s['v'] }}</b>@if($s['l'])<span>{{ $s['l'] }}</span>@endif</div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($settings['button_text']))
                    <a href="{{ $settings['button_url'] ?? '#' }}" class="rj-au-btn">
                        {{ $settings['button_text'] }}
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>

            <div class="rj-au-media-wrap">
                <div class="rj-au-aura"></div>
                <div class="rj-au-frame">
                    <div class="rj-au-media">
                        @if(!empty($settings['image']))
                            <img src="{{ $settings['image'] }}" alt="{{ $settings['title'] ?? 'About Us' }}" class="rj-au-img" loading="lazy" decoding="async">
                            <div class="rj-au-veil"></div>
                            <div class="rj-au-gloss"></div>
                        @else
                            <div class="rj-au-empty">
                                <svg viewBox="0 0 120 120" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <circle cx="60" cy="60" r="26" fill="rgba(124,58,237,0.35)"/>
                                    <ellipse cx="60" cy="62" rx="52" ry="14" transform="rotate(-18 60 62)"/>
                                    <circle cx="104" cy="44" r="3" fill="currentColor"/>
                                </svg>
                            </div>
                        @endif
                        <div class="rj-au-orbit"></div>
                        <span class="rj-au-corner tl"></span>
                        <span class="rj-au-corner br"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    // run animations only while the card is on screen
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (e) { root.classList.toggle('is-live', e[0].isIntersecting); }).observe(root);
    } else { root.classList.add('is-live'); }

    // cursor light: one transform write per frame
    if (window.matchMedia && window.matchMedia('(hover: hover)').matches) {
        var card = root.querySelector('.rj-au-card'), light = root.querySelector('.rj-au-light'), raf = 0, px = 0, py = 0;
        function frame() {
            raf = 0;
            var r = card.getBoundingClientRect();
            light.style.transform = 'translate3d(' + (px - r.left - 220) + 'px,' + (py - r.top - 220) + 'px,0)';
        }
        card.addEventListener('pointermove', function (e) { px = e.clientX; py = e.clientY; if (!raf) raf = requestAnimationFrame(frame); });
    }
})();
</script>