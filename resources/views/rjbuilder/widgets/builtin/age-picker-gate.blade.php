<style>
    @property --iris { syntax: '<color>'; inherits: true; initial-value: #8b5cf6; }
    html.ap-lock, html.ap-lock body { overflow: hidden !important; }

    #{{ $uid }} { --acc: {{ $o['accent'] }}; --iris: var(--acc); --es: clamp(150px, 30vmin, 250px);
        position: fixed; inset: 0; z-index: 2147483600; overflow: hidden; background: #02030a; color: #fff; font-family: inherit; transition: --iris .6s ease, opacity .5s ease; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }}[data-mode="inline"] { position: relative; inset: auto; z-index: 0; min-height: 700px; border-radius: 28px; border: 1px solid rgba(255,255,255,.18); }
    #{{ $uid }}[hidden] { display: none; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }
    #{{ $uid }}.is-gone { opacity: 0; pointer-events: none; }

    #{{ $uid }}[data-mood="happy"] { --iris: #f0abfc; }
    #{{ $uid }}[data-mood="scan"] { --iris: #22d3ee; }
    #{{ $uid }}[data-mood="ok"] { --iris: #22c55e; }
    #{{ $uid }}[data-mood="no"] { --iris: #ef4444; }

    /* Fon */
    #{{ $uid }} .ap-bg { position: absolute; inset: 0; overflow: hidden; perspective: 1200px;
        background: radial-gradient(ellipse at 20% 15%, color-mix(in srgb, var(--acc) 28%, transparent), transparent 55%), radial-gradient(ellipse at 85% 80%, rgba(236,72,153,.2), transparent 55%), radial-gradient(ellipse at 50% 50%, #0b1030, #02030a 70%); }
    #{{ $uid }} .ap-par { position: absolute; inset: -6%; transition: transform .25s ease-out; }
    #{{ $uid }} .ap-galaxy { position: absolute; left: 50%; top: 50%; width: 150vmax; aspect-ratio: 1; opacity: .42; filter: blur(46px); border-radius: 50%;
        background: conic-gradient(from 0deg, transparent, var(--acc) 9%, transparent 24%, #ec4899 38%, transparent 52%, #22d3ee 66%, transparent 82%, var(--acc) 94%, transparent);
        -webkit-mask-image: radial-gradient(circle, transparent 6%, #000 22%, transparent 68%); mask-image: radial-gradient(circle, transparent 6%, #000 22%, transparent 68%);
        transform: translate(-50%, -50%) rotateX(72deg); animation: ap-galaxy 120s linear infinite; }
    #{{ $uid }} .ap-blob { position: absolute; border-radius: 50%; filter: blur(70px); animation: ap-blob 22s ease-in-out infinite alternate; }
    #{{ $uid }} .ap-blob.b1 { width: 38vmax; height: 38vmax; left: -10%; top: -12%; background: var(--acc); opacity: .26; }
    #{{ $uid }} .ap-blob.b2 { width: 32vmax; height: 32vmax; right: -8%; bottom: -10%; background: #ec4899; opacity: .2; animation-duration: 28s; animation-direction: alternate-reverse; }
    #{{ $uid }} .ap-blob.b3 { width: 24vmax; height: 24vmax; right: 18%; top: 4%; background: #22d3ee; opacity: .14; animation-duration: 32s; }
    #{{ $uid }} .ap-planet { position: absolute; border-radius: 50%; box-shadow: inset -14px -10px 30px rgba(0,0,0,.65), 0 0 40px -6px var(--acc); animation: ap-float 9s ease-in-out infinite alternate; }
    #{{ $uid }} .ap-planet.p1 { width: clamp(46px, 9vmin, 92px); aspect-ratio: 1; left: 9%; bottom: 14%; background: radial-gradient(circle at 32% 28%, #fde68a, #f59e0b 45%, #7c2d12); }
    #{{ $uid }} .ap-planet.p2 { width: clamp(28px, 5vmin, 54px); aspect-ratio: 1; right: 11%; top: 16%; background: radial-gradient(circle at 32% 28%, #a5f3fc, #0ea5e9 50%, #082f49); animation-delay: -4s; }
    #{{ $uid }} .ap-shoot { position: absolute; width: 150px; height: 2px; opacity: 0; background: linear-gradient(90deg, transparent, #fff); transform-origin: 100% 50%; animation: ap-shoot 8s ease-in infinite; }
    #{{ $uid }} .ap-shoot.s1 { left: 12%; top: 10%; }
    #{{ $uid }} .ap-shoot.s2 { left: 52%; top: 4%; animation-delay: 3.2s; animation-duration: 10s; }
    #{{ $uid }} .ap-shoot.s3 { left: 30%; top: 38%; animation-delay: 5.8s; animation-duration: 12s; }
    #{{ $uid }} .ap-stars { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 1; display: block; pointer-events: none; }

    /* Məzmun */
    #{{ $uid }} .ap-scroll { position: relative; z-index: 2; height: 100%; overflow-y: auto; display: flex; padding: 28px 16px; overscroll-behavior: contain; }
    #{{ $uid }}[data-mode="inline"] .ap-scroll { min-height: 700px; }
    #{{ $uid }} .ap-wrap { margin: auto; display: flex; flex-direction: column; align-items: center; gap: clamp(20px, 4vh, 34px); width: 100%; max-width: 480px; }

    /* Personaj səhnəsi */
    #{{ $uid }} .ap-stage { position: relative; width: calc(var(--es) * .92); height: calc(var(--es) * 1.15); flex: none; perspective: 1000px; margin-top: clamp(12px, 3vh, 30px); }
    #{{ $uid }} .ap-orbz { position: absolute; inset: 0; transform-style: preserve-3d; }
    #{{ $uid }} .ap-orb { position: absolute; inset: 0; transform-style: preserve-3d; will-change: transform; }
    #{{ $uid }}[data-anim="1"] .ap-orbz { animation: ap-enter 1.3s cubic-bezier(.2,.9,.2,1.15) both; }
    #{{ $uid }} .ap-ring { position: absolute; border-radius: 50%; border: 2px solid color-mix(in srgb, var(--iris) 70%, #fff 10%); box-shadow: 0 0 16px color-mix(in srgb, var(--iris) 60%, transparent), inset 0 0 16px color-mix(in srgb, var(--iris) 40%, transparent); pointer-events: none; }
    #{{ $uid }} .ap-ring::after { content: ''; position: absolute; top: -6px; left: 50%; width: 11px; height: 11px; margin-left: -5px; border-radius: 50%; background: #fff; box-shadow: 0 0 14px 4px var(--iris); }
    #{{ $uid }} .ap-ring.r1 { inset: -22%; animation: ap-r1 13s linear infinite; }
    #{{ $uid }} .ap-ring.r2 { inset: -36%; border-width: 1px; opacity: .8; animation: ap-r2 19s linear infinite; }
    #{{ $uid }} .ap-ring.r3 { inset: -10%; border-style: dashed; opacity: .75; animation: ap-r3 9s linear infinite reverse; }
    #{{ $uid }} .ap-portal { position: absolute; inset: 0; overflow: hidden; border-radius: 50% 50% 24px 24px / 34% 34% 24px 24px; background: #0b1030; border: 2px solid rgba(255,255,255,.45);
        box-shadow: 0 0 0 2px rgba(255,255,255,.18), 0 0 70px -4px var(--iris), 0 0 140px -24px var(--iris), inset 0 0 30px rgba(0,0,0,.35); }
    #{{ $uid }} .ap-portal svg { display: block; width: 100%; height: 100%; }
    #{{ $uid }} .ap-portal::after { content: ''; position: absolute; inset: 0; z-index: 3; pointer-events: none; background: linear-gradient(160deg, rgba(255,255,255,.3), transparent 38%); }
    #{{ $uid }} .ap-portal.pop { animation: ap-pop .45s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .ap-portal.shake { animation: ap-shake .55s ease; }
    #{{ $uid }} .ap-scan { position: absolute; left: 0; right: 0; top: -22%; height: 18%; z-index: 2; opacity: 0; background: linear-gradient(transparent, rgba(34,211,238,.9), transparent); box-shadow: 0 0 26px 6px rgba(34,211,238,.6); }
    #{{ $uid }}[data-mood="scan"] .ap-scan { opacity: 1; animation: ap-scan .9s ease-in-out infinite alternate; }
    #{{ $uid }} .ap-pulse { position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--iris); opacity: 0; pointer-events: none; }
    #{{ $uid }}[data-mood="scan"] .ap-pulse, #{{ $uid }}[data-mood="ok"] .ap-pulse { animation: ap-pulse 1.1s ease-out infinite; }
    #{{ $uid }} .ap-cloud { animation: ap-cloud 14s ease-in-out infinite alternate; }
    #{{ $uid }} .ap-cloud.c2 { animation-duration: 19s; animation-delay: -6s; }
    #{{ $uid }} .ap-skin { fill: #fcd5b0; }
    #{{ $uid }} .ap-shirt { fill: var(--acc); stroke: rgba(0,0,0,.1); stroke-width: 1; }
    #{{ $uid }} .ap-pants { fill: #334155; }
    #{{ $uid }} .ap-shoe { fill: #f8fafc; }

    /* Şüşə panel */
    #{{ $uid }} .ap-panel { width: 100%; padding: 24px 24px 22px; border-radius: 28px; text-align: center; transition: opacity .5s, transform .6s cubic-bezier(.6,0,.4,1);
        background: linear-gradient(145deg, rgba(255,255,255,.16), rgba(255,255,255,.04)), rgba(10,14,40,.42);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.26); box-shadow: 0 26px 70px -22px rgba(0,0,0,.75), 0 0 60px -24px var(--acc), inset 0 1px 0 rgba(255,255,255,.35); }
    #{{ $uid }}[data-style="glass-dark"] .ap-panel { background: linear-gradient(145deg, rgba(255,255,255,.08), rgba(255,255,255,.02)), rgba(3,6,20,.74); border-color: rgba(255,255,255,.14); }
    #{{ $uid }}[data-anim="1"] .ap-panel { animation: ap-up .9s cubic-bezier(.2,.9,.2,1) .35s both; }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) { #{{ $uid }} .ap-panel { background: rgba(10,14,40,.85); } }
    #{{ $uid }} .ap-badge { display: inline-grid; place-items: center; min-width: 96px; height: 64px; padding: 0 16px; margin-bottom: 8px; border-radius: 999px; font-size: 1.9rem; font-weight: 800; letter-spacing: .02em;
        background: linear-gradient(135deg, var(--acc), #ec4899); box-shadow: 0 10px 30px -8px var(--acc), inset 0 1px 0 rgba(255,255,255,.4); animation: ap-float 4s ease-in-out infinite alternate; transition: background .4s, box-shadow .4s; }
    #{{ $uid }} .ap-badge.no { background: linear-gradient(135deg, #ef4444, #9f1239); box-shadow: 0 10px 30px -8px #ef4444; }
    #{{ $uid }} .ap-badge.x { min-width: 54px; height: 54px; font-size: 1.2rem; margin-bottom: 12px; }
    #{{ $uid }} .ap-chip { display: inline-block; min-height: 28px; margin: 0 0 10px; padding: 5px 14px; border-radius: 999px; font-size: .74rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.28); }
    #{{ $uid }} .ap-title { margin: 0; font-size: clamp(1.35rem, 4.6vw, 1.85rem); font-weight: 800; line-height: 1.2; text-shadow: 0 2px 16px rgba(0,0,0,.4); }
    #{{ $uid }} .ap-text { margin: 10px 0 0; font-size: .96rem; line-height: 1.5; color: rgba(255,255,255,.82); }

    /* Slider */
    #{{ $uid }} .ap-age { --fill: var(--acc); --v: .38; --minp: 0; margin-top: 18px; --trk: linear-gradient(90deg, var(--fill) calc(15px + var(--v) * (100% - 30px)), rgba(255,255,255,.18) 0); }
    #{{ $uid }} .ap-age[data-ok="0"] { --fill: #ef4444; }
    #{{ $uid }} .ap-slider { display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: 10px; }
    #{{ $uid }} .ap-rangewrap { position: relative; padding-top: 20px; }
    #{{ $uid }} .ap-minmark { position: absolute; top: 0; left: calc(15px + var(--minp) * (100% - 30px)); transform: translateX(-50%); font-size: .7rem; font-weight: 800; color: #fff; text-align: center; pointer-events: none; }
    #{{ $uid }} .ap-minmark::after { content: ''; display: block; width: 2px; height: 8px; margin: 2px auto 0; border-radius: 2px; background: rgba(255,255,255,.75); }
    #{{ $uid }} .ap-range { -webkit-appearance: none; appearance: none; width: 100%; height: 30px; margin: 0; background: transparent; cursor: pointer; outline: none; }
    #{{ $uid }} .ap-range::-webkit-slider-runnable-track { box-sizing: border-box; height: 12px; border-radius: 99px; border: 1px solid rgba(255,255,255,.3); background: var(--trk); }
    #{{ $uid }} .ap-range::-moz-range-track { box-sizing: border-box; height: 12px; border-radius: 99px; border: 1px solid rgba(255,255,255,.3); background: var(--trk); }
    #{{ $uid }} .ap-range::-webkit-slider-thumb { -webkit-appearance: none; box-sizing: border-box; width: 30px; height: 30px; margin-top: -9px; border-radius: 50%; background: #fff; border: 5px solid var(--fill); box-shadow: 0 6px 16px rgba(0,0,0,.4); transition: transform .15s; }
    #{{ $uid }} .ap-range::-moz-range-thumb { box-sizing: border-box; width: 30px; height: 30px; border-radius: 50%; background: #fff; border: 5px solid var(--fill); box-shadow: 0 6px 16px rgba(0,0,0,.4); }
    #{{ $uid }} .ap-range:active::-webkit-slider-thumb { transform: scale(1.12); }
    #{{ $uid }} .ap-range:focus-visible::-webkit-slider-thumb { box-shadow: 0 6px 16px rgba(0,0,0,.4), 0 0 0 6px color-mix(in srgb, var(--fill) 40%, transparent); }
    #{{ $uid }} .ap-range:disabled { opacity: .55; cursor: default; }
    #{{ $uid }} .ap-step { appearance: none; display: grid; place-items: center; width: 42px; height: 42px; padding: 0; border-radius: 50%; cursor: pointer; color: #fff; font: inherit; font-size: 1.35rem; font-weight: 700; line-height: 1;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.3); -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); transition: transform .2s cubic-bezier(.34,1.56,.64,1), background .2s; }
    #{{ $uid }} .ap-step:hover, #{{ $uid }} .ap-step:focus-visible { transform: scale(1.1); background: rgba(255,255,255,.22); outline: none; }
    #{{ $uid }} .ap-step:active { transform: scale(.94); }
    #{{ $uid }} .ap-step:disabled { opacity: .5; cursor: default; }
    #{{ $uid }} .ap-scale { display: flex; justify-content: space-between; margin: 2px 62px 0; font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.65); }

    #{{ $uid }} .ap-actions { display: flex; margin-top: 18px; }
    #{{ $uid }} .ap-btn { position: relative; overflow: hidden; flex: 1; appearance: none; cursor: pointer; padding: 14px 18px; border-radius: 999px; font: inherit; font-size: .98rem; font-weight: 700; color: #fff; border: 0;
        background: linear-gradient(135deg, var(--acc), color-mix(in srgb, var(--acc) 50%, #ec4899)); box-shadow: 0 14px 34px -12px var(--acc); transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s, filter .25s; }
    #{{ $uid }} .ap-btn:hover, #{{ $uid }} .ap-btn:focus-visible { transform: translateY(-3px) scale(1.03); box-shadow: 0 18px 44px -10px var(--acc); filter: brightness(1.1); outline: none; }
    #{{ $uid }} .ap-btn:active { transform: scale(.97); }
    #{{ $uid }} .ap-btn:disabled { opacity: .55; cursor: default; transform: none; }
    #{{ $uid }} .ap-btn::after { content: ''; position: absolute; top: 0; bottom: 0; width: 40%; left: -60%; transform: skewX(-20deg); background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent); animation: ap-shine 3.6s ease-in-out infinite; }
    #{{ $uid }} .ap-status { min-height: 1.5em; margin: 12px 0 0; font-size: .9rem; font-weight: 600; color: rgba(255,255,255,.9); }
    #{{ $uid }} .ap-status.bad { color: #fecaca; }
    #{{ $uid }} .ap-status.busy::after { content: ''; animation: ap-dots 1.2s steps(1) infinite; }

    /* Bağlanma: warp */
    #{{ $uid }} .ap-flash { position: absolute; inset: 0; z-index: 4; pointer-events: none; opacity: 0; background: radial-gradient(circle, #fff 0%, var(--acc) 38%, transparent 70%); }
    #{{ $uid }}.is-warp .ap-panel { opacity: 0; transform: translateY(46px) scale(.88); animation: none; }
    #{{ $uid }}.is-warp .ap-orbz { animation: none; transform: scale(9); opacity: 0; transition: transform 1.2s cubic-bezier(.6,0,.9,.4) .15s, opacity .5s ease .85s; }
    #{{ $uid }}.is-warp .ap-flash { animation: ap-flash 1s ease-in .75s both; }

    @keyframes ap-galaxy { to { transform: translate(-50%, -50%) rotateX(72deg) rotate(360deg); } }
    @keyframes ap-blob { from { transform: translate(0,0) scale(1); } to { transform: translate(60px,50px) scale(1.25); } }
    @keyframes ap-float { from { transform: translateY(0); } to { transform: translateY(-10px); } }
    @keyframes ap-shoot { 0% { opacity: 0; transform: translate(0,0) rotate(32deg); } 3% { opacity: 1; } 11% { opacity: 0; transform: translate(440px,275px) rotate(32deg); } 100% { opacity: 0; transform: translate(440px,275px) rotate(32deg); } }
    @keyframes ap-r1 { from { transform: rotateX(72deg) rotateZ(0); } to { transform: rotateX(72deg) rotateZ(360deg); } }
    @keyframes ap-r2 { from { transform: rotateY(74deg) rotateZ(0); } to { transform: rotateY(74deg) rotateZ(360deg); } }
    @keyframes ap-r3 { from { transform: rotateX(38deg) rotateY(42deg) rotateZ(0); } to { transform: rotateX(38deg) rotateY(42deg) rotateZ(360deg); } }
    @keyframes ap-enter { from { opacity: 0; transform: scale(.2) rotateY(-220deg); } to { opacity: 1; transform: none; } }
    @keyframes ap-up { from { opacity: 0; transform: translateY(40px) scale(.94); } to { opacity: 1; transform: none; } }
    @keyframes ap-scan { from { top: -22%; } to { top: 104%; } }
    @keyframes ap-shake { 0%,100% { transform: translateX(0); } 20% { transform: translateX(-12px); } 40% { transform: translateX(10px); } 60% { transform: translateX(-7px); } 80% { transform: translateX(4px); } }
    @keyframes ap-pulse { 0% { transform: scale(1); opacity: .7; } 100% { transform: scale(1.6); opacity: 0; } }
    @keyframes ap-pop { 0% { transform: scale(1); } 40% { transform: scale(1.07); } 100% { transform: scale(1); } }
    @keyframes ap-cloud { from { transform: translateX(-14px); } to { transform: translateX(14px); } }
    @keyframes ap-shine { 0%, 60% { left: -60%; } 100% { left: 140%; } }
    @keyframes ap-dots { 0% { content: ''; } 25% { content: '.'; } 50% { content: '..'; } 75% { content: '...'; } }
    @keyframes ap-flash { 0% { opacity: 0; transform: scale(.15); } 55% { opacity: .95; } 100% { opacity: 1; transform: scale(2.6); } }

    #{{ $uid }}[data-anim="0"] *, #{{ $uid }}[data-anim="0"] *::before, #{{ $uid }}[data-anim="0"] *::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01s !important; }
    }
    @media (max-width: 520px) {
        #{{ $uid }} { --es: clamp(130px, 26vmax, 200px); }
        #{{ $uid }} .ap-scroll { padding: 18px 12px; }
        #{{ $uid }} .ap-panel { padding: 20px 16px 18px; border-radius: 24px; }
        #{{ $uid }} .ap-step { width: 38px; height: 38px; }
        #{{ $uid }} .ap-scale { margin: 2px 56px 0; }
    }
    @media (max-height: 600px) and (orientation: landscape) {
        #{{ $uid }} { --es: clamp(110px, 40vh, 190px); }
        #{{ $uid }} .ap-wrap { flex-direction: row; max-width: 900px; gap: 36px; }
        #{{ $uid }} .ap-stage { margin: 0; }
    }
</style>

<section id="{{ $uid }}" class="ap" data-mode="{{ $o['mode'] }}" data-style="{{ $o['style'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-mood="calm"
    @if ($o['mode'] === 'overlay') hidden role="dialog" aria-modal="true" aria-labelledby="{{ $uid }}-t" @endif>

    <div class="ap-bg" aria-hidden="true">
        <div class="ap-par" data-el="par">
            <div class="ap-galaxy"></div>
            <i class="ap-blob b1"></i><i class="ap-blob b2"></i><i class="ap-blob b3"></i>
            <i class="ap-planet p1"></i><i class="ap-planet p2"></i>
            <i class="ap-shoot s1"></i><i class="ap-shoot s2"></i><i class="ap-shoot s3"></i>
        </div>
    </div>
    <canvas class="ap-stars" data-el="stars" aria-hidden="true"></canvas>

    <div class="ap-scroll">
        <div class="ap-wrap">
            <div class="ap-stage" data-el="stage" aria-hidden="true">
                <div class="ap-orbz">
                    <div class="ap-orb" data-el="orb">
                        <span class="ap-ring r2"></span>
                        <span class="ap-ring r1"></span>
                        <span class="ap-ring r3"></span>

                        <div class="ap-portal" data-el="portal">
                            <svg viewBox="0 0 200 250" preserveAspectRatio="xMidYMax meet" focusable="false">
                                <defs>
                                    <linearGradient id="{{ $uid }}-sky" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0" data-el="sk1" stop-color="#78cdff"/>
                                        <stop offset="1" data-el="sk2" stop-color="#d2f0ff"/>
                                    </linearGradient>
                                    <linearGradient id="{{ $uid }}-gr" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0" stop-color="#fff" stop-opacity=".45"/>
                                        <stop offset="1" stop-color="#fff" stop-opacity=".08"/>
                                    </linearGradient>
                                </defs>
                                <rect width="200" height="250" fill="url(#{{ $uid }}-sky)"/>
                                <circle data-el="sun" r="14" cx="28" cy="78" fill="#fde68a"/>
                                <g class="ap-cloud" opacity=".85"><ellipse cx="46" cy="52" rx="20" ry="7" fill="#fff"/><ellipse cx="58" cy="47" rx="13" ry="7" fill="#fff"/></g>
                                <g class="ap-cloud c2" opacity=".7"><ellipse cx="150" cy="92" rx="17" ry="6" fill="#fff"/><ellipse cx="160" cy="88" rx="11" ry="6" fill="#fff"/></g>
                                <ellipse cx="100" cy="238" rx="120" ry="30" fill="url(#{{ $uid }}-gr)"/>
                                <ellipse data-el="shadow" cx="100" cy="224" rx="30" ry="6" fill="#000" opacity=".25"/>

                                <g data-el="ch">
                                    <g data-el="bob">
                                        <g data-el="legL">
                                            <rect x="-9" y="0" width="18" height="62" rx="9" class="ap-pants"/>
                                            <ellipse cx="0" cy="64" rx="14" ry="7" class="ap-shoe"/>
                                        </g>
                                        <g data-el="legR">
                                            <rect x="-9" y="0" width="18" height="62" rx="9" class="ap-pants"/>
                                            <ellipse cx="0" cy="64" rx="14" ry="7" class="ap-shoe"/>
                                        </g>

                                        <g data-el="cane" opacity="0">
                                            <path data-el="canePath" d="M44 -90 L50 0" stroke="#7c4a2d" stroke-width="5" stroke-linecap="round" fill="none"/>
                                            <circle data-el="caneKnob" r="6" cx="44" cy="-90" fill="#a16207"/>
                                        </g>

                                        <g data-el="up">
                                            <rect x="-27" y="-148" width="54" height="82" rx="24" class="ap-shirt"/>
                                            <path d="M-18 -138 Q0 -126 18 -138" stroke="rgba(255,255,255,.4)" stroke-width="4" fill="none" stroke-linecap="round"/>
                                            <g data-el="armL">
                                                <rect x="-8" y="-4" width="16" height="50" rx="8" class="ap-shirt"/>
                                                <circle cx="0" cy="50" r="8.5" class="ap-skin"/>
                                            </g>
                                            <g data-el="armR">
                                                <rect x="-8" y="-4" width="16" height="50" rx="8" class="ap-shirt"/>
                                                <circle cx="0" cy="50" r="8.5" class="ap-skin"/>
                                            </g>
                                            <rect x="-7" y="-160" width="14" height="18" rx="6" class="ap-skin"/>

                                            <g data-el="head">
                                                <circle cx="-34" cy="-34" r="7" class="ap-skin"/>
                                                <circle cx="34" cy="-34" r="7" class="ap-skin"/>
                                                <circle cx="0" cy="-34" r="34" class="ap-skin"/>

                                                <g data-el="cheeks" opacity=".6">
                                                    <ellipse cx="-21" cy="-24" rx="6.5" ry="4" fill="#ff8fa3"/>
                                                    <ellipse cx="21" cy="-24" rx="6.5" ry="4" fill="#ff8fa3"/>
                                                </g>

                                                <g data-el="wr" fill="none" stroke="#a9795a" stroke-width="1.6" stroke-linecap="round" opacity="0">
                                                    <path d="M-15 -57 Q0 -62 15 -57"/><path d="M-11 -53 Q0 -57 11 -53"/>
                                                    <path d="M-25 -38 l-6 -2"/><path d="M-25 -33 l-6 1"/>
                                                    <path d="M25 -38 l6 -2"/><path d="M25 -33 l6 1"/>
                                                    <path d="M-14 -24 Q-17 -17 -12 -11"/><path d="M14 -24 Q17 -17 12 -11"/>
                                                </g>

                                                <ellipse data-el="nose" cx="0" cy="-26" rx="3.2" ry="2.5" fill="#eaa77a"/>

                                                <g data-el="eyeL">
                                                    <ellipse rx="6.6" ry="7.6" fill="#fff"/>
                                                    <g data-el="pupL"><circle r="4.2" fill="#1e1b3a"/><circle cx="1.4" cy="-1.6" r="1.4" fill="#fff"/></g>
                                                </g>
                                                <g data-el="eyeR">
                                                    <ellipse rx="6.6" ry="7.6" fill="#fff"/>
                                                    <g data-el="pupR"><circle r="4.2" fill="#1e1b3a"/><circle cx="1.4" cy="-1.6" r="1.4" fill="#fff"/></g>
                                                </g>

                                                <path data-el="mouth" d="M-10 -17 Q0 -11 10 -17" fill="none" stroke="#8a3b2a" stroke-width="3" stroke-linecap="round"/>
                                                <ellipse data-el="mouthO" cx="0" cy="-15" rx="5" ry="0" fill="#7f1d1d" opacity="0"/>

                                                <g data-el="gl" opacity="0" fill="rgba(255,255,255,.14)" stroke="#1e293b" stroke-width="2.4">
                                                    <circle cx="-12" cy="-36" r="11"/><circle cx="12" cy="-36" r="11"/>
                                                    <path d="M-1 -37 h2" fill="none"/><path d="M-23 -37 L-33 -39 M23 -37 L33 -39" fill="none"/>
                                                </g>

                                                <g data-el="hairc" style="color:#5b3a29">
                                                    <g data-el="sideHair" opacity="0">
                                                        <ellipse cx="-33" cy="-38" rx="6" ry="11" fill="currentColor"/>
                                                        <ellipse cx="33" cy="-38" rx="6" ry="11" fill="currentColor"/>
                                                    </g>
                                                    <path data-el="hair" d="M-33 -42 A34 34 0 0 1 33 -42 Q20 -58 0 -53 Q-20 -58 -33 -42 Z" fill="currentColor"/>
                                                    <path data-el="tuft" d="M0 -68 Q-7 -80 3 -83 Q0 -76 6 -74" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round"/>
                                                    <path data-el="brL" d="M-6 0 Q0 -3 6 0" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                                    <path data-el="brR" d="M-6 0 Q0 -3 6 0" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <span class="ap-scan"></span>
                        </div>
                        <span class="ap-pulse"></span>
                    </div>
                </div>
            </div>

            <div class="ap-panel">
                <div data-el="ask">
                    <span class="ap-badge" data-el="ageBadge">{{ $o['age'] }}</span>
                    <div class="ap-chip" data-el="stageName">&nbsp;</div>
                    <h2 class="ap-title" id="{{ $uid }}-t">{{ $o['title'] }}</h2>
                    @if ($o['text'] !== '')<p class="ap-text">{{ $o['text'] }}</p>@endif

                    <div class="ap-age" data-el="agebox" data-ok="1">
                        <div class="ap-slider">
                            <button type="button" class="ap-step" data-a="dec" aria-label="-1">&minus;</button>
                            <div class="ap-rangewrap">
                                <span class="ap-minmark"><b>{{ $o['age'] }}+</b></span>
                                <input type="range" class="ap-range" data-el="range" min="0" max="65" step="1" value="25" aria-label="{{ $labels['age'] }}">
                            </div>
                            <button type="button" class="ap-step" data-a="inc" aria-label="+1">+</button>
                        </div>
                        <div class="ap-scale"><span>0</span><span>65+</span></div>
                    </div>

                    <div class="ap-actions"><button type="button" class="ap-btn" data-a="verify">{{ $o['verify'] }}</button></div>
                    <p class="ap-status" data-el="status" aria-live="polite"></p>
                </div>

                <div data-el="den" hidden>
                    <span class="ap-badge no x" aria-hidden="true">&#10005;</span>
                    <h2 class="ap-title">{{ $o['deny_title'] }}</h2>
                    @if ($o['deny_text'] !== '')<p class="ap-text">{{ $o['deny_text'] }}</p>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="ap-flash" aria-hidden="true"></div>

    <script type="application/json" id="{{ $uid }}-data">{!! json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</section>

<script>
(function () {
    var UID = '{{ $uid }}';
    var root = document.getElementById(UID);
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var D;
    try { D = JSON.parse(document.getElementById(UID + '-data').textContent); } catch (e) { return; }
    if (!D) { return; }

    var L = D.labels, overlay = D.mode === 'overlay', MAXA = D.maxAge || 65;
    var COOKIE = 'rj_agepick_ok', DENY_KEY = 'rj_agepick_denied_' + D.age;
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var noAnim = !D.anim || reduce;

    function q(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var el = { stars: q('stars'), stage: q('stage'), orb: q('orb'), par: q('par'), ask: q('ask'), den: q('den'), status: q('status'),
               portal: q('portal'), range: q('range'), agebox: q('agebox'), badge: q('ageBadge'), chip: q('stageName') };

    /* ---------- Cookie ---------- */
    function getCookie(n) { var m = document.cookie.match(new RegExp('(?:^|; )' + n + '=([^;]*)')); return m ? decodeURIComponent(m[1]) : null; }
    function setCookie(n, v, days) {
        var s = n + '=' + encodeURIComponent(v) + '; path=/; SameSite=Lax';
        if (days > 0) { s += '; max-age=' + (days * 86400); }
        if (location.protocol === 'https:') { s += '; Secure'; }
        document.cookie = s;
    }
    function isVerified() { return parseInt(getCookie(COOKIE), 10) >= D.age; }
    function wasDenied() { try { return sessionStorage.getItem(DENY_KEY) === '1'; } catch (e) { return false; } }

    if (overlay && isVerified()) { return; }

    /* ---------- Vəziyyət ---------- */
    var busy = false, running = false, raf = 0, lastTs = 0, timers = [];
    function after(ms, fn) { timers.push(setTimeout(fn, ms)); }
    function clearTimers() { timers.forEach(clearTimeout); timers = []; }
    function setMood(m) { root.dataset.mood = m; }
    function say(t, busyDots) {
        el.status.textContent = t || '';
        el.status.classList.toggle('busy', !!busyDots);
        el.status.classList.remove('bad');
    }
    function lock(on) { if (overlay) { document.documentElement.classList.toggle('ap-lock', on); } }

    /* ---------- Ulduz sahəsi ---------- */
    var cv = el.stars, ctx = cv.getContext('2d');
    var W = 0, H = 0, F = 0, Z = 1000, stars = [], speed = 1.3, targetSpeed = 1.3;
    var COLORS = ['255,255,255', '255,255,255', '255,255,255', '196,181,253', '165,243,252', '251,207,232'];

    function spawn(s, far) {
        s.x = (Math.random() * 2 - 1) * W * 0.62;
        s.y = (Math.random() * 2 - 1) * H * 0.62;
        s.z = far ? Z : Math.random() * Z;
        s.c = COLORS[(Math.random() * COLORS.length) | 0];
        return s;
    }
    function sizeCanvas() {
        var r = root.getBoundingClientRect();
        W = r.width; H = r.height;
        var dpr = Math.min(window.devicePixelRatio || 1, 1.5);
        cv.width = Math.round(W * dpr); cv.height = Math.round(H * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        F = Math.max(W, H) * 0.5;
        var n = { low: 140, medium: 300, high: 520 }[D.stars] || 300;
        if (W < 640) { n = Math.round(n * 0.55); }
        if (noAnim) { n = Math.round(n * 0.5); }
        while (stars.length < n) { stars.push(spawn({}, false)); }
        stars.length = n;
    }

    /* ---------- Köməkçilər ---------- */
    function lerp(a, b, t) { return a + (b - a) * t; }
    function clamp(v, a, b) { return v < a ? a : (v > b ? b : v); }
    function smooth(t) { t = clamp(t, 0, 1); return t * t * (3 - 2 * t); }
    function mix(x, y, t) { return [lerp(x[0], y[0], t), lerp(x[1], y[1], t), lerp(x[2], y[2], t)]; }
    function rgb(c) { return 'rgb(' + Math.round(c[0]) + ',' + Math.round(c[1]) + ',' + Math.round(c[2]) + ')'; }
    function curve(tbl, x) {
        if (x <= tbl[0][0]) { return tbl[0][1]; }
        for (var i = 1; i < tbl.length; i++) {
            if (x <= tbl[i][0]) { var a = tbl[i - 1], b = tbl[i]; return lerp(a[1], b[1], (x - a[0]) / (b[0] - a[0])); }
        }
        return tbl[tbl.length - 1][1];
    }
    function pal(tbl, t) {
        for (var i = 1; i < tbl.length; i++) {
            if (t <= tbl[i][0]) { var a = tbl[i - 1], b = tbl[i]; return mix(a[1], b[1], (t - a[0]) / (b[0] - a[0])); }
        }
        return tbl[tbl.length - 1][1];
    }
    function setT(n, v) { n.setAttribute('transform', v); }
    function f2(n) { return n.toFixed(2); }

    /* ---------- Yaş personajı ---------- */
    var C_SCALE = [[0, .36], [1, .42], [3, .52], [6, .62], [12, .78], [18, .95], [24, 1], [50, 1], [65, .9]];
    var C_HEAD  = [[0, 1.78], [2, 1.62], [6, 1.35], [12, 1.12], [18, 1], [65, 1]];
    var C_HAIR  = [[0, 0], [1, .25], [4, .9], [8, 1], [50, 1], [65, .55]];
    var C_CHEEK = [[0, .9], [10, .7], [25, .35], [65, .2]];
    var C_DROP  = [[0, 9], [2.5, 6], [4, 0], [65, 0]];
    var SKY1 = [[0, [255, 170, 200]], [.15, [120, 205, 255]], [.55, [95, 165, 250]], [.8, [255, 160, 120]], [1, [120, 90, 190]]];
    var SKY2 = [[0, [255, 225, 170]], [.15, [210, 240, 255]], [.55, [205, 230, 255]], [.8, [255, 214, 160]], [1, [255, 150, 140]]];

    // yaş, tezlik, ayaqAmp, ayaqAçılma, güzgü, qaldırma, qolBaza, qolAmp, hoppanma, yan-sürüşmə, yan-əyilmə, əyilmə, baş-əyilməsi
    var KEYS = [
        [0,  6.0, 20, 30, 1,  0, 140, 38,  3,  0, 3,  0, 8],
        [3,  7.0, 26,  6, .8, 3,  30, 55, 16,  0, 2,  0, 6],
        [9,  8.0, 30,  6, .6, 4,  25, 60, 24,  4, 3,  0, 6],
        [15, 5.5, 16,  8, .2, 5,  30, 48,  7, 12, 7,  0, 8],
        [22, 4.4, 22,  3, 0,  9,   6, 26,  4,  0, 1.5, 0, 2],
        [45, 3.6, 18,  3, 0,  8,   6, 20,  3,  0, 1,  3, 2],
        [60, 2.6, 10,  3, 0,  5,   5,  8, 1.6, 0, .8, 11, 3],
        [65, 2.2,  8,  3, 0,  4,   5,  6, 1.2, 0, .6, 15, 4]
    ];
    function pose(age) {
        var i = 1;
        while (i < KEYS.length - 1 && age > KEYS[i][0]) { i++; }
        var a = KEYS[i - 1], b = KEYS[i], t = clamp((age - a[0]) / (b[0] - a[0]), 0, 1), o = [];
        for (var k = 1; k < a.length; k++) { o.push(lerp(a[k], b[k], t)); }
        return o;
    }
    function hairColor(a) {
        var br = [91, 58, 41], gr = [168, 174, 186], wh = [243, 246, 250];
        if (a <= 32) { return rgb(br); }
        if (a <= 52) { return rgb(mix(br, gr, (a - 32) / 20)); }
        return rgb(mix(gr, wh, clamp((a - 52) / 13, 0, 1)));
    }
    function stageIdx(v) { return v <= 2 ? 0 : v <= 12 ? 1 : v <= 19 ? 2 : v <= 34 ? 3 : v <= 54 ? 4 : v < MAXA ? 5 : 6; }
    function ageText(v) { return v >= MAXA ? MAXA + '+' : String(v); }

    var G = {}, S = { age: 0, target: 25, ph: 0, wOk: 0, wNo: 0, wHp: 0, wSc: 0, nextBlink: 1.2, blinkEnd: 0, stage: -1 };

    function initChar() {
        ['ch', 'bob', 'legL', 'legR', 'up', 'armL', 'armR', 'head', 'hairc', 'hair', 'sideHair', 'tuft', 'brL', 'brR', 'eyeL', 'eyeR', 'pupL', 'pupR',
         'mouth', 'mouthO', 'cheeks', 'wr', 'gl', 'nose', 'cane', 'canePath', 'caneKnob', 'shadow', 'sun', 'sk1', 'sk2'].forEach(function (n) { G[n] = q(n); });
        var start = clamp(Math.max(25, D.age), 0, MAXA);
        el.range.value = start;
        S.age = start;
        el.agebox.style.setProperty('--minp', String(D.age / MAXA));
        syncAge();
    }

    function syncAge() {
        var v = +el.range.value, ok = v >= D.age;
        S.target = v;
        el.agebox.style.setProperty('--v', String(v / MAXA));
        el.agebox.dataset.ok = ok ? '1' : '0';
        el.badge.textContent = ageText(v);
        el.badge.classList.toggle('no', !ok);
        var si = stageIdx(v);
        if (si !== S.stage) {
            S.stage = si;
            el.chip.textContent = (L.stages && L.stages[si]) || '';
            el.portal.classList.remove('pop'); void el.portal.offsetWidth; el.portal.classList.add('pop');
        }
        if (!busy) {
            if (ok) { say(''); } else { say(L.below); el.status.classList.add('bad'); }
        }
    }

    function charFrame(dt, now, ox, oy) {
        var kw = 1 - Math.exp(-dt * 6);
        S.age += (S.target - S.age) * kw;
        var a = S.age;

        var md = root.dataset.mood;
        S.wOk += ((md === 'ok' ? 1 : 0) - S.wOk) * kw;
        S.wNo += ((md === 'no' ? 1 : 0) - S.wNo) * kw;
        S.wHp += ((md === 'happy' ? 1 : 0) - S.wHp) * kw;
        S.wSc += ((md === 'scan' ? 1 : 0) - S.wSc) * kw;
        var wOk = S.wOk, wNo = S.wNo, wHp = S.wHp, wSc = S.wSc;

        var p = pose(a), live = !noAnim;
        if (live) { S.ph += dt * p[0] * (1 + wSc * .6 + wOk * .5) * (1 - wNo * .75); }
        var ph = S.ph, sn = Math.sin(ph);

        var s = curve(C_SCALE, a), hs = curve(C_HEAD, a);
        var mirror = p[3], dR = Math.PI * (1 - mirror), calm = 1 - wNo * .85;
        var legA = p[1] * calm, armA = p[6] * calm, lift = p[4] * calm, armBase = p[5];
        armBase += (160 - armBase) * wOk; armA += (24 - armA) * wOk;
        armBase += (3 - armBase) * wNo;
        var caneW = smooth((a - 58) / 5);

        var hop = (p[7] * calm + wOk * 14) * (live ? Math.abs(sn) : 0);
        var swayX = live ? p[8] * Math.sin(ph * .5) * calm : 0;
        var swayR = live ? p[9] * Math.sin(ph * .5 + .6) * calm : 0;
        var lean = p[10] + wNo * 12;
        var drop = curve(C_DROP, a);

        setT(G.ch, 'translate(100 222) scale(' + s.toFixed(3) + ')');
        setT(G.bob, 'translate(' + f2(swayX) + ' ' + f2(drop - hop) + ')');
        setT(G.up, 'translate(0 -72) rotate(' + f2(lean + swayR) + ') translate(0 72)');

        var legL = p[2] + legA * sn, legR = -(p[2] + legA * Math.sin(ph + dR));
        var liftL = live ? lift * Math.max(0, sn) : 0, liftR = live ? lift * Math.max(0, -sn) : 0;
        setT(G.legL, 'translate(-14 ' + f2(-72 - liftL) + ') rotate(' + f2(legL) + ')');
        setT(G.legR, 'translate(14 ' + f2(-72 - liftR) + ') rotate(' + f2(legR) + ')');

        var ap = ph + Math.PI;
        var armL = armBase + armA * Math.sin(ap), armR = -(armBase + armA * Math.sin(ap + dR));
        armL = clamp(armL, -4, 178); armR = clamp(armR, -178, 4);
        armR += (-12 - armR) * caneW;
        setT(G.armL, 'translate(-33 -138) rotate(' + f2(armL) + ')');
        setT(G.armR, 'translate(33 -138) rotate(' + f2(armR) + ')');

        G.cane.setAttribute('opacity', f2(caneW));
        if (caneW > .02) {
            var rr = armR * Math.PI / 180, th = (lean + swayR) * Math.PI / 180;
            var hx = 33 - 52 * Math.sin(rr), hy = -66 + 52 * Math.cos(rr);
            var X = hx * Math.cos(th) - hy * Math.sin(th), Y = hx * Math.sin(th) + hy * Math.cos(th);
            var tx = X, ty = -72 + Y, bx = X + 6, by = hop - drop;
            G.canePath.setAttribute('d', 'M' + f2(tx) + ' ' + f2(ty) + ' L' + f2(bx) + ' ' + f2(by));
            G.caneKnob.setAttribute('cx', f2(tx)); G.caneKnob.setAttribute('cy', f2(ty));
        }

        var hr = (live ? p[11] * Math.sin(ph * .5 + 1) : 0) + ox * 4 + wNo * 10;
        var nod = live ? Math.sin(ph * 2) * 1.2 : 0;
        setT(G.head, 'translate(0 ' + f2(-146 + nod) + ') rotate(' + f2(hr) + ') scale(' + hs.toFixed(3) + ')');

        G.hairc.style.color = hairColor(a);
        G.hair.setAttribute('opacity', f2(curve(C_HAIR, a)));
        G.tuft.setAttribute('opacity', f2(clamp(1 - a / 3.2, 0, 1)));
        G.sideHair.setAttribute('opacity', f2(smooth((a - 50) / 12)));
        G.wr.setAttribute('opacity', f2(clamp((a - 38) / 27, 0, 1) * .85));
        G.gl.setAttribute('opacity', f2(smooth((a - 44) / 6)));
        G.cheeks.setAttribute('opacity', f2(clamp(curve(C_CHEEK, a) + wOk * .15, 0, 1)));
        var nk = 1 + clamp((a - 30) / 35, 0, 1) * .3;
        G.nose.setAttribute('rx', f2(3.2 * nk)); G.nose.setAttribute('ry', f2(2.5 * nk));

        if (now > S.nextBlink) { S.blinkEnd = now + .14; S.nextBlink = now + 2.2 + Math.random() * 3.6; }
        var es = (now < S.blinkEnd ? .12 : 1) * (1 - wNo * .25 - wOk * .15);
        setT(G.eyeL, 'translate(-12 -36) scale(1 ' + f2(es) + ')');
        setT(G.eyeR, 'translate(12 -36) scale(1 ' + f2(es) + ')');
        var px = ox * 2.6, py = oy * 2.2 + wNo * 1.8;
        setT(G.pupL, 'translate(' + f2(px) + ' ' + f2(py) + ')');
        setT(G.pupR, 'translate(' + f2(px) + ' ' + f2(py) + ')');

        setT(G.brL, 'translate(-12 ' + f2(-49 - wHp * 1.5 - wOk * 2) + ') rotate(' + f2(-wNo * 14) + ')');
        setT(G.brR, 'translate(12 ' + f2(-49 - wHp * 1.5 - wOk * 2) + ') rotate(' + f2(wNo * 14) + ')');

        var c = 6 + wHp * 3 + wOk * 6 - wNo * 16;
        G.mouth.setAttribute('d', 'M-10 -17 Q0 ' + f2(-17 + c) + ' 10 -17');
        var open = Math.max(wOk, clamp(1 - a / 3, 0, 1) * .6);
        G.mouthO.setAttribute('rx', f2(4 + open * 4.5));
        G.mouthO.setAttribute('ry', f2(open * 7));
        G.mouthO.setAttribute('opacity', open > .05 ? '1' : '0');
        G.mouth.setAttribute('opacity', f2(1 - clamp(open * 1.4, 0, 1)));

        var t = clamp(a / MAXA, 0, 1);
        G.sk1.setAttribute('stop-color', rgb(pal(SKY1, t)));
        G.sk2.setAttribute('stop-color', rgb(pal(SKY2, t)));
        G.sun.setAttribute('cx', f2(28 + t * 144));
        G.sun.setAttribute('cy', f2(78 - Math.sin(Math.PI * t) * 52));
        G.sun.setAttribute('fill', rgb(mix([255, 236, 150], [255, 140, 70], t)));
        G.shadow.setAttribute('rx', f2((16 + 34 * s) * (1 - hop * .012)));
    }

    /* ---------- Əsas dövr ---------- */
    var ptr = { x: 0, y: 0, t: 0 }, cur = { x: 0, y: 0 }, look = { x: 0, y: 0 }, tilt = { x: 0, y: 0 }, par = { x: 0, y: 0 };
    function onMove(e) { ptr.x = e.clientX; ptr.y = e.clientY; ptr.t = performance.now(); }
    window.addEventListener('pointermove', onMove, { passive: true });
    window.addEventListener('pointerdown', onMove, { passive: true });

    function frame(ts) {
        if (!running) { return; }
        raf = requestAnimationFrame(frame);
        var dtt = lastTs ? Math.min(.05, (ts - lastTs) / 1000) : .016;
        lastTs = ts;

        var rr = root.getBoundingClientRect();
        if (Math.abs(rr.width - W) > 1 || Math.abs(rr.height - H) > 1) { sizeCanvas(); }

        var now = performance.now();
        var sr = el.stage.getBoundingClientRect();
        var ex = sr.left + sr.width / 2, ey = sr.top + sr.height / 2;

        var tx, ty;
        if (now - ptr.t < 2800) { tx = ptr.x; ty = ptr.y; }
        else { tx = rr.left + rr.width / 2 + Math.sin(now / 1300) * rr.width * 0.3; ty = rr.top + rr.height / 2 + Math.cos(now / 1700) * rr.height * 0.2; }
        cur.x += (tx - cur.x) * 0.12; cur.y += (ty - cur.y) * 0.12;

        var dx = cur.x - ex, dy = cur.y - ey, dist = Math.hypot(dx, dy), ang = Math.atan2(dy, dx);
        var k = Math.min(1, dist / (sr.width * 1.1));
        look.x += (Math.cos(ang) * k - look.x) * 0.22;
        look.y += (Math.sin(ang) * k - look.y) * 0.22;

        var nx = clamp(dx / (rr.width / 2), -1, 1), ny = clamp(dy / (rr.height / 2), -1, 1);
        tilt.x += ((-ny * 12) - tilt.x) * 0.08; tilt.y += ((nx * 18) - tilt.y) * 0.08;
        el.orb.style.transform = 'rotateX(' + tilt.x.toFixed(2) + 'deg) rotateY(' + tilt.y.toFixed(2) + 'deg)';

        par.x += (nx - par.x) * 0.05; par.y += (ny - par.y) * 0.05;
        el.par.style.transform = 'translate3d(' + (-par.x * 18).toFixed(1) + 'px,' + (-par.y * 14).toFixed(1) + 'px,0)';

        charFrame(dtt, now / 1000, look.x, look.y);

        speed += (targetSpeed - speed) * 0.06;
        var cx = W / 2 - par.x * W * 0.035, cy = H / 2 - par.y * H * 0.03;
        ctx.clearRect(0, 0, W, H);
        ctx.lineCap = 'round';
        var trail = 1 + Math.max(0, speed - 3) * 0.55;
        for (var i = 0; i < stars.length; i++) {
            var s = stars[i];
            s.z -= speed;
            if (s.z <= 2) { spawn(s, true); continue; }
            var kk = F / s.z, x = s.x * kk + cx, y = s.y * kk + cy;
            var z2 = s.z + speed * trail * 1.4 + 0.5, k2 = F / z2, x2 = s.x * k2 + cx, y2 = s.y * k2 + cy;
            var depth = 1 - s.z / Z;
            ctx.globalAlpha = Math.min(1, depth * 1.5);
            ctx.strokeStyle = 'rgb(' + s.c + ')';
            ctx.lineWidth = depth * 2.2 + 0.4;
            ctx.beginPath(); ctx.moveTo(x2, y2); ctx.lineTo(x, y); ctx.stroke();
        }
        ctx.globalAlpha = 1;
    }

    function startLoop() {
        if (running) { return; }
        running = true; lastTs = 0; sizeCanvas();
        raf = requestAnimationFrame(frame);
    }
    function stopLoop() { running = false; if (raf) { cancelAnimationFrame(raf); raf = 0; } }

    /* ---------- Axın ---------- */
    function disable(b) { [].forEach.call(root.querySelectorAll('.ap-btn, .ap-range, .ap-step'), function (n) { n.disabled = b; }); }

    function finish() {
        if (overlay) {
            root.classList.add('is-gone');
            after(520, function () { root.hidden = true; stopLoop(); lock(false); });
        } else {
            after(900, reset);
        }
    }

    function pass() {
        if (busy) { return; }
        busy = true;
        disable(true);
        setMood('scan'); say(L.verifying, true);
        if (noAnim) { if (overlay) { setCookie(COOKIE, D.age, D.remember); } after(300, finish); return; }
        after(950, function () { setMood('ok'); say(L.verified, false); if (overlay) { setCookie(COOKIE, D.age, D.remember); } });
        after(1650, function () { root.classList.add('is-warp'); targetSpeed = 46; });
        after(2750, finish);
    }

    function deny(silent) {
        busy = true;
        setMood('no');
        el.ask.hidden = true; el.den.hidden = false;
        if (!silent && !noAnim) { el.portal.classList.add('shake'); setTimeout(function () { el.portal.classList.remove('shake'); }, 600); }
        if (overlay) {
            try { sessionStorage.setItem(DENY_KEY, '1'); } catch (e) {}
            if (D.denyUrl) { after(2300, function () { location.href = D.denyUrl; }); }
        } else {
            after(3200, reset);
        }
    }

    function reset() {
        clearTimers();
        root.classList.remove('is-warp', 'is-gone');
        targetSpeed = 1.3; busy = false;
        setMood('calm'); say('');
        el.ask.hidden = false; el.den.hidden = true;
        disable(false);
        syncAge();
    }

    function verify() {
        if (busy) { return; }
        if (+el.range.value >= D.age) { pass(); } else { deny(false); }
    }

    /* ---------- Hadisələr ---------- */
    root.addEventListener('click', function (e) {
        var b = e.target.closest('[data-a]');
        if (!b || busy) { return; }
        var a = b.dataset.a;
        if (a === 'verify') { verify(); }
        else if (a === 'inc' || a === 'dec') {
            el.range.value = clamp(+el.range.value + (a === 'inc' ? 1 : -1), 0, MAXA);
            syncAge();
        }
    });
    root.addEventListener('input', function (e) { if (e.target === el.range) { syncAge(); } });
    root.addEventListener('mouseover', function (e) {
        if (busy) { return; }
        setMood(e.target.closest('.ap-btn') ? 'happy' : 'calm');
    });
    root.addEventListener('focusin', function (e) { if (!busy) { setMood(e.target.closest && e.target.closest('.ap-btn') ? 'happy' : 'calm'); } });

    root.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && e.target === el.range) { e.preventDefault(); verify(); return; }
        if (!overlay || e.key !== 'Tab') { return; }
        var f = [].slice.call(root.querySelectorAll('button:not([hidden]):not(:disabled), input:not(:disabled)')).filter(function (n) { return n.offsetParent !== null; });
        if (!f.length) { e.preventDefault(); return; }
        var first = f[0], last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });

    window.addEventListener('resize', function () { if (running) { sizeCanvas(); } });

    /* ---------- Başlat ---------- */
    initChar();

    function open() {
        root.hidden = false;
        lock(true);
        ptr.x = cur.x = window.innerWidth / 2; ptr.y = cur.y = window.innerHeight / 2;
        startLoop();
        if (wasDenied()) { deny(true); return; }
        try { el.range.focus({ preventScroll: true }); } catch (e) { el.range.focus(); }
    }

    if (overlay) {
        open();
    } else if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (es) {
            es.forEach(function (en) { if (en.isIntersecting) { startLoop(); } else { stopLoop(); } });
        }, { threshold: 0.05 }).observe(root);
    } else {
        startLoop();
    }
})();
</script>