<style>
    @property --iris { syntax: '<color>'; inherits: true; initial-value: #8b5cf6; }
    html.ag-lock, html.ag-lock body { overflow: hidden !important; }

    #{{ $uid }} { --acc: {{ $o['accent'] }}; --iris: var(--acc); --es: clamp(140px, 28vmin, 240px); --ps: 1; --ix: 0px; --iy: 0px; --lt: 0%; --lb: 0%; --lr: 0deg;
        position: fixed; inset: 0; z-index: 2147483600; overflow: hidden; background: #02030a; color: #fff; font-family: inherit; transition: --iris .6s ease, opacity .5s ease; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }}[data-mode="inline"] { position: relative; inset: auto; z-index: 0; min-height: 660px; border-radius: 28px; border: 1px solid rgba(255,255,255,.18); }
    #{{ $uid }}[hidden] { display: none; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }
    #{{ $uid }}.is-gone { opacity: 0; pointer-events: none; }

    /* Əhval: gözün rəngi və göz qapaqları */
    #{{ $uid }}[data-mood="happy"] { --lt: 8%; --lb: 24%; }
    #{{ $uid }}[data-mood="scan"] { --iris: #22d3ee; --lt: 16%; --lb: 16%; --ps: 1.3; }
    #{{ $uid }}[data-mood="ok"] { --iris: #22c55e; --lt: 4%; --lb: 22%; --ps: 1.5; }
    #{{ $uid }}[data-mood="no"] { --iris: #ef4444; --lt: 34%; --lb: 6%; --lr: -11deg; --ps: .55; }

    /* Fon: dumanlıq, 3D qalaktika diski, ulduz yağışı */
    #{{ $uid }} .ag-bg { position: absolute; inset: 0; overflow: hidden; perspective: 1200px;
        background: radial-gradient(ellipse at 20% 15%, color-mix(in srgb, var(--acc) 28%, transparent), transparent 55%), radial-gradient(ellipse at 85% 80%, rgba(236,72,153,.2), transparent 55%), radial-gradient(ellipse at 50% 50%, #0b1030, #02030a 70%); }
    #{{ $uid }} .ag-par { position: absolute; inset: -6%; transition: transform .25s ease-out; }
    #{{ $uid }} .ag-galaxy { position: absolute; left: 50%; top: 50%; width: 150vmax; aspect-ratio: 1; opacity: .42; filter: blur(46px); border-radius: 50%;
        background: conic-gradient(from 0deg, transparent, var(--acc) 9%, transparent 24%, #ec4899 38%, transparent 52%, #22d3ee 66%, transparent 82%, var(--acc) 94%, transparent);
        -webkit-mask-image: radial-gradient(circle, transparent 6%, #000 22%, transparent 68%); mask-image: radial-gradient(circle, transparent 6%, #000 22%, transparent 68%);
        transform: translate(-50%, -50%) rotateX(72deg) rotate(0deg); animation: ag-galaxy 120s linear infinite; }
    #{{ $uid }} .ag-blob { position: absolute; border-radius: 50%; filter: blur(70px); animation: ag-blob 22s ease-in-out infinite alternate; }
    #{{ $uid }} .ag-blob.b1 { width: 38vmax; height: 38vmax; left: -10%; top: -12%; background: var(--acc); opacity: .26; }
    #{{ $uid }} .ag-blob.b2 { width: 32vmax; height: 32vmax; right: -8%; bottom: -10%; background: #ec4899; opacity: .2; animation-duration: 28s; animation-direction: alternate-reverse; }
    #{{ $uid }} .ag-blob.b3 { width: 24vmax; height: 24vmax; right: 18%; top: 4%; background: #22d3ee; opacity: .14; animation-duration: 32s; }
    #{{ $uid }} .ag-planet { position: absolute; border-radius: 50%; box-shadow: inset -14px -10px 30px rgba(0,0,0,.65), 0 0 40px -6px var(--acc); animation: ag-float 9s ease-in-out infinite alternate; }
    #{{ $uid }} .ag-planet.p1 { width: clamp(46px, 9vmin, 92px); aspect-ratio: 1; left: 9%; bottom: 14%; background: radial-gradient(circle at 32% 28%, #fde68a, #f59e0b 45%, #7c2d12); }
    #{{ $uid }} .ag-planet.p2 { width: clamp(28px, 5vmin, 54px); aspect-ratio: 1; right: 11%; top: 16%; background: radial-gradient(circle at 32% 28%, #a5f3fc, #0ea5e9 50%, #082f49); animation-delay: -4s; }
    #{{ $uid }} .ag-shoot { position: absolute; width: 150px; height: 2px; opacity: 0; background: linear-gradient(90deg, transparent, #fff); transform-origin: 100% 50%; animation: ag-shoot 8s ease-in infinite; }
    #{{ $uid }} .ag-shoot.s1 { left: 12%; top: 10%; }
    #{{ $uid }} .ag-shoot.s2 { left: 52%; top: 4%; animation-delay: 3.2s; animation-duration: 10s; }
    #{{ $uid }} .ag-shoot.s3 { left: 30%; top: 38%; animation-delay: 5.8s; animation-duration: 12s; }
    #{{ $uid }} .ag-stars { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 1; display: block; pointer-events: none; }

    /* Məzmun */
    #{{ $uid }} .ag-scroll { position: relative; z-index: 2; height: 100%; overflow-y: auto; display: flex; padding: 28px 16px; overscroll-behavior: contain; }
    #{{ $uid }}[data-mode="inline"] .ag-scroll { min-height: 660px; }
    #{{ $uid }} .ag-wrap { margin: auto; display: flex; flex-direction: column; align-items: center; gap: clamp(22px, 5vh, 40px); width: 100%; max-width: 480px; }

    /* 3D göz */
    #{{ $uid }} .ag-stage { position: relative; width: var(--es); height: var(--es); flex: none; perspective: 1000px; margin: clamp(20px, 5vh, 44px) 0 0; }
    #{{ $uid }} .ag-orbz { position: absolute; inset: 0; transform-style: preserve-3d; }
    #{{ $uid }} .ag-orb { position: absolute; inset: 0; transform-style: preserve-3d; will-change: transform; }
    #{{ $uid }}[data-anim="1"] .ag-orbz { animation: ag-enter 1.3s cubic-bezier(.2,.9,.2,1.15) both; }
    #{{ $uid }} .ag-ring { position: absolute; border-radius: 50%; border: 2px solid color-mix(in srgb, var(--iris) 70%, #fff 10%); box-shadow: 0 0 16px color-mix(in srgb, var(--iris) 60%, transparent), inset 0 0 16px color-mix(in srgb, var(--iris) 40%, transparent); pointer-events: none; }
    #{{ $uid }} .ag-ring::after { content: ''; position: absolute; top: -6px; left: 50%; width: 11px; height: 11px; margin-left: -5px; border-radius: 50%; background: #fff; box-shadow: 0 0 14px 4px var(--iris); }
    #{{ $uid }} .ag-ring.r1 { inset: -26%; animation: ag-r1 13s linear infinite; }
    #{{ $uid }} .ag-ring.r2 { inset: -40%; border-width: 1px; opacity: .8; animation: ag-r2 19s linear infinite; }
    #{{ $uid }} .ag-ring.r3 { inset: -14%; border-style: dashed; opacity: .75; animation: ag-r3 9s linear infinite reverse; }
    #{{ $uid }} .ag-eye { position: absolute; inset: 0; border-radius: 50%; overflow: hidden;
        background: radial-gradient(circle at 34% 28%, #ffffff, #e5e9ff 38%, #9aa6e0 72%, #4a5399 100%);
        box-shadow: 0 0 0 2px rgba(255,255,255,.35), 0 0 70px -4px var(--iris), 0 0 140px -20px var(--iris), inset -18px -22px 40px rgba(20,24,80,.55), inset 10px 10px 30px rgba(255,255,255,.5); }
    #{{ $uid }} .ag-iris { position: absolute; left: 50%; top: 50%; width: 48%; height: 48%; margin: -24% 0 0 -24%; border-radius: 50%; transform: translate(var(--ix), var(--iy));
        background: repeating-conic-gradient(from 0deg, color-mix(in srgb, var(--iris) 100%, #fff 18%) 0 7deg, color-mix(in srgb, var(--iris) 70%, #000) 7deg 14deg), radial-gradient(circle, var(--iris), #000 90%);
        background-blend-mode: multiply, normal; box-shadow: 0 0 0 3px rgba(0,0,0,.4), 0 0 32px var(--iris), inset 0 0 18px rgba(0,0,0,.6); }
    #{{ $uid }} .ag-iris::before { content: ''; position: absolute; inset: 0; border-radius: 50%; background: radial-gradient(circle, transparent 38%, rgba(0,0,0,.45) 100%); }
    #{{ $uid }} .ag-pupil { position: absolute; left: 50%; top: 50%; width: 40%; height: 40%; margin: -20% 0 0 -20%; border-radius: 50%; background: #000; transform: scale(var(--ps)); transition: transform .25s ease; box-shadow: 0 0 14px rgba(0,0,0,.9); }
    #{{ $uid }} .ag-glint { position: absolute; left: 22%; top: 18%; width: 20%; height: 20%; border-radius: 50%; background: #fff; opacity: .95; filter: blur(.5px); }
    #{{ $uid }} .ag-glint.g2 { left: 60%; top: 62%; width: 9%; height: 9%; opacity: .6; }
    #{{ $uid }} .ag-lid { position: absolute; left: -8%; right: -8%; z-index: 3; background: linear-gradient(#050818, #141a4c); transition: height .16s ease, transform .2s ease; }
    #{{ $uid }} .ag-lid.t { top: 0; height: var(--lt); border-radius: 0 0 50% 50% / 0 0 36% 36%; transform: rotate(var(--lr)); transform-origin: 50% 0; box-shadow: 0 6px 14px rgba(0,0,0,.4); }
    #{{ $uid }} .ag-lid.b { bottom: 0; height: var(--lb); border-radius: 50% 50% 0 0 / 36% 36% 0 0; box-shadow: 0 -6px 14px rgba(0,0,0,.4); }
    #{{ $uid }} .ag-eye.blink { --lt: 54%; --lb: 54%; }
    #{{ $uid }} .ag-scan { position: absolute; left: -10%; right: -10%; top: -22%; height: 18%; z-index: 2; opacity: 0; background: linear-gradient(transparent, rgba(34,211,238,.9), transparent); box-shadow: 0 0 26px 6px rgba(34,211,238,.6); }
    #{{ $uid }}[data-mood="scan"] .ag-scan { opacity: 1; animation: ag-scan .9s ease-in-out infinite alternate; }
    #{{ $uid }} .ag-eye.shake { animation: ag-shake .55s ease; }
    #{{ $uid }} .ag-pulse { position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--iris); opacity: 0; pointer-events: none; }
    #{{ $uid }}[data-mood="scan"] .ag-pulse, #{{ $uid }}[data-mood="ok"] .ag-pulse { animation: ag-pulse 1.1s ease-out infinite; }

    /* Şüşə panel */
    #{{ $uid }} .ag-panel { width: 100%; padding: 26px 24px 22px; border-radius: 28px; text-align: center; transition: opacity .5s, transform .6s cubic-bezier(.6,0,.4,1);
        background: linear-gradient(145deg, rgba(255,255,255,.16), rgba(255,255,255,.04)), rgba(10,14,40,.42);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.26); box-shadow: 0 26px 70px -22px rgba(0,0,0,.75), 0 0 60px -24px var(--acc), inset 0 1px 0 rgba(255,255,255,.35); }
    #{{ $uid }}[data-style="glass-dark"] .ag-panel { background: linear-gradient(145deg, rgba(255,255,255,.08), rgba(255,255,255,.02)), rgba(3,6,20,.74); border-color: rgba(255,255,255,.14); }
    #{{ $uid }}[data-anim="1"] .ag-panel { animation: ag-up .9s cubic-bezier(.2,.9,.2,1) .35s both; }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) { #{{ $uid }} .ag-panel { background: rgba(10,14,40,.85); } }
    #{{ $uid }} .ag-badge { display: inline-grid; place-items: center; min-width: 54px; height: 54px; padding: 0 14px; margin-bottom: 12px; border-radius: 999px; font-size: 1.2rem; font-weight: 800; letter-spacing: .02em;
        background: linear-gradient(135deg, var(--acc), #ec4899); box-shadow: 0 10px 30px -8px var(--acc), inset 0 1px 0 rgba(255,255,255,.4); animation: ag-float 4s ease-in-out infinite alternate; }
    #{{ $uid }} .ag-badge.no { background: linear-gradient(135deg, #ef4444, #9f1239); box-shadow: 0 10px 30px -8px #ef4444; }
    #{{ $uid }} .ag-title { margin: 0; font-size: clamp(1.35rem, 4.6vw, 1.85rem); font-weight: 800; line-height: 1.2; text-shadow: 0 2px 16px rgba(0,0,0,.4); }
    #{{ $uid }} .ag-text { margin: 10px 0 0; font-size: .96rem; line-height: 1.5; color: rgba(255,255,255,.82); }
    #{{ $uid }} .ag-actions { display: flex; gap: 10px; margin-top: 20px; }
    #{{ $uid }} .ag-btn { position: relative; overflow: hidden; flex: 1; appearance: none; cursor: pointer; padding: 14px 18px; border-radius: 999px; font: inherit; font-size: .95rem; font-weight: 700; color: #fff;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.3); -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s, background .25s; }
    #{{ $uid }} .ag-btn:hover, #{{ $uid }} .ag-btn:focus-visible { transform: translateY(-3px) scale(1.04); background: rgba(255,255,255,.2); outline: none; }
    #{{ $uid }} .ag-btn:active { transform: scale(.97); }
    #{{ $uid }} .ag-btn:disabled { opacity: .55; cursor: default; transform: none; }
    #{{ $uid }} .ag-btn.yes { border-color: transparent; background: linear-gradient(135deg, var(--acc), color-mix(in srgb, var(--acc) 50%, #ec4899)); box-shadow: 0 14px 34px -12px var(--acc); }
    #{{ $uid }} .ag-btn.yes:hover, #{{ $uid }} .ag-btn.yes:focus-visible { box-shadow: 0 18px 44px -10px var(--acc); filter: brightness(1.1); }
    #{{ $uid }} .ag-btn.yes::after { content: ''; position: absolute; top: 0; bottom: 0; width: 40%; left: -60%; transform: skewX(-20deg); background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent); animation: ag-shine 3.6s ease-in-out infinite; }
    #{{ $uid }} .ag-dob { display: grid; grid-template-columns: 1fr 1.5fr 1.2fr; gap: 8px; margin-top: 20px; }
    #{{ $uid }} .ag-dob select { width: 100%; min-width: 0; padding: 12px 8px; border-radius: 14px; font: inherit; font-size: .92rem; color: #fff; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.3); outline: none; }
    #{{ $uid }} .ag-dob select:focus { border-color: var(--acc); box-shadow: 0 0 0 3px color-mix(in srgb, var(--acc) 40%, transparent); }
    #{{ $uid }} .ag-dob option { color: #0f172a; background: #fff; }
    #{{ $uid }} .ag-status { min-height: 1.5em; margin: 14px 0 0; font-size: .9rem; font-weight: 600; color: rgba(255,255,255,.9); }
    #{{ $uid }} .ag-status.busy::after { content: ''; animation: ag-dots 1.2s steps(1) infinite; }

    /* Bağlanma: warp */
    #{{ $uid }} .ag-flash { position: absolute; inset: 0; z-index: 4; pointer-events: none; opacity: 0; background: radial-gradient(circle, #fff 0%, var(--acc) 38%, transparent 70%); }
    #{{ $uid }}.is-warp .ag-panel { opacity: 0; transform: translateY(46px) scale(.88); animation: none; }
    #{{ $uid }}.is-warp .ag-orbz { animation: none; transform: scale(9); opacity: 0; transition: transform 1.2s cubic-bezier(.6,0,.9,.4) .15s, opacity .5s ease .85s; }
    #{{ $uid }}.is-warp .ag-flash { animation: ag-flash 1s ease-in .75s both; }

    @keyframes ag-galaxy { to { transform: translate(-50%, -50%) rotateX(72deg) rotate(360deg); } }
    @keyframes ag-blob { from { transform: translate(0,0) scale(1); } to { transform: translate(60px,50px) scale(1.25); } }
    @keyframes ag-float { from { transform: translateY(0); } to { transform: translateY(-12px); } }
    @keyframes ag-shoot { 0% { opacity: 0; transform: translate(0,0) rotate(32deg); } 3% { opacity: 1; } 11% { opacity: 0; transform: translate(440px,275px) rotate(32deg); } 100% { opacity: 0; transform: translate(440px,275px) rotate(32deg); } }
    @keyframes ag-r1 { from { transform: rotateX(72deg) rotateZ(0); } to { transform: rotateX(72deg) rotateZ(360deg); } }
    @keyframes ag-r2 { from { transform: rotateY(74deg) rotateZ(0); } to { transform: rotateY(74deg) rotateZ(360deg); } }
    @keyframes ag-r3 { from { transform: rotateX(38deg) rotateY(42deg) rotateZ(0); } to { transform: rotateX(38deg) rotateY(42deg) rotateZ(360deg); } }
    @keyframes ag-enter { from { opacity: 0; transform: scale(.2) rotateY(-220deg); } to { opacity: 1; transform: none; } }
    @keyframes ag-up { from { opacity: 0; transform: translateY(40px) scale(.94); } to { opacity: 1; transform: none; } }
    @keyframes ag-scan { from { top: -22%; } to { top: 104%; } }
    @keyframes ag-shake { 0%,100% { transform: translateX(0); } 20% { transform: translateX(-12px); } 40% { transform: translateX(10px); } 60% { transform: translateX(-7px); } 80% { transform: translateX(4px); } }
    @keyframes ag-pulse { 0% { transform: scale(1); opacity: .7; } 100% { transform: scale(1.7); opacity: 0; } }
    @keyframes ag-shine { 0%, 60% { left: -60%; } 100% { left: 140%; } }
    @keyframes ag-dots { 0% { content: ''; } 25% { content: '.'; } 50% { content: '..'; } 75% { content: '...'; } }
    @keyframes ag-flash { 0% { opacity: 0; transform: scale(.15); } 55% { opacity: .95; } 100% { opacity: 1; transform: scale(2.6); } }

    #{{ $uid }}[data-anim="0"] *, #{{ $uid }}[data-anim="0"] *::before, #{{ $uid }}[data-anim="0"] *::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01s !important; }
    }

    @media (max-width: 520px) {
        #{{ $uid }} { --es: clamp(120px, 24vmax, 190px); }
        #{{ $uid }} .ag-scroll { padding: 18px 12px; }
        #{{ $uid }} .ag-panel { padding: 22px 16px 18px; border-radius: 24px; }
        #{{ $uid }} .ag-actions { flex-direction: column; }
        #{{ $uid }} .ag-btn { padding: 15px 18px; }
    }
    @media (max-height: 560px) and (orientation: landscape) {
        #{{ $uid }} { --es: clamp(100px, 42vh, 180px); }
        #{{ $uid }} .ag-wrap { flex-direction: row; max-width: 900px; gap: 36px; }
        #{{ $uid }} .ag-stage { margin: 0; }
        #{{ $uid }} .ag-actions { flex-direction: row; }
    }
</style>

<section id="{{ $uid }}" class="ag" data-mode="{{ $o['mode'] }}" data-style="{{ $o['style'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-mood="calm"
    @if ($o['mode'] === 'overlay') hidden role="dialog" aria-modal="true" aria-labelledby="{{ $uid }}-t" @endif>

    <div class="ag-bg" aria-hidden="true">
        <div class="ag-par" data-el="par">
            <div class="ag-galaxy"></div>
            <i class="ag-blob b1"></i><i class="ag-blob b2"></i><i class="ag-blob b3"></i>
            <i class="ag-planet p1"></i><i class="ag-planet p2"></i>
            <i class="ag-shoot s1"></i><i class="ag-shoot s2"></i><i class="ag-shoot s3"></i>
        </div>
    </div>
    <canvas class="ag-stars" data-el="stars" aria-hidden="true"></canvas>

    <div class="ag-scroll">
        <div class="ag-wrap">
            <div class="ag-stage" data-el="stage" aria-hidden="true">
                <div class="ag-orbz">
                    <div class="ag-orb" data-el="orb">
                        <span class="ag-ring r2"></span>
                        <span class="ag-ring r1"></span>
                        <span class="ag-ring r3"></span>
                        <div class="ag-eye" data-el="eye">
                            <span class="ag-iris"><span class="ag-pupil"></span></span>
                            <span class="ag-glint"></span><span class="ag-glint g2"></span>
                            <span class="ag-scan"></span>
                            <span class="ag-lid t"></span><span class="ag-lid b"></span>
                        </div>
                        <span class="ag-pulse"></span>
                    </div>
                </div>
            </div>

            <div class="ag-panel">
                <div data-el="ask">
                    <span class="ag-badge">{{ $o['age'] }}+</span>
                    <h2 class="ag-title" id="{{ $uid }}-t">{{ $o['title'] }}</h2>
                    @if ($o['text'] !== '')<p class="ag-text">{{ $o['text'] }}</p>@endif

                    @if ($o['method'] === 'birthdate')
                        <div class="ag-dob">
                            <select data-el="dd" aria-label="{{ $labels['day'] }}"></select>
                            <select data-el="mm" aria-label="{{ $labels['month'] }}"></select>
                            <select data-el="yy" aria-label="{{ $labels['year'] }}"></select>
                        </div>
                        <div class="ag-actions"><button type="button" class="ag-btn yes" data-a="verify">{{ $o['verify'] }}</button></div>
                    @else
                        <div class="ag-actions">
                            <button type="button" class="ag-btn yes" data-a="yes">{{ $o['yes'] }}</button>
                            <button type="button" class="ag-btn no" data-a="no">{{ $o['no'] }}</button>
                        </div>
                    @endif
                    <p class="ag-status" data-el="status" aria-live="polite"></p>
                </div>

                <div data-el="den" hidden>
                    <span class="ag-badge no" aria-hidden="true">&#10005;</span>
                    <h2 class="ag-title">{{ $o['deny_title'] }}</h2>
                    @if ($o['deny_text'] !== '')<p class="ag-text">{{ $o['deny_text'] }}</p>@endif
                </div>
            </div>
        </div>
    </div>

    <div class="ag-flash" aria-hidden="true"></div>

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

    var L = D.labels, overlay = D.mode === 'overlay';
    var COOKIE = 'rj_age_ok', DENY_KEY = 'rj_age_denied_' + D.age;
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var noAnim = !D.anim || reduce;

    function q(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var el = { stars: q('stars'), stage: q('stage'), orb: q('orb'), eye: q('eye'), par: q('par'), ask: q('ask'), den: q('den'), status: q('status'),
               dd: q('dd'), mm: q('mm'), yy: q('yy') };

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
    var busy = false, running = false, raf = 0, timers = [];
    function after(ms, fn) { timers.push(setTimeout(fn, ms)); }
    function clearTimers() { timers.forEach(clearTimeout); timers = []; }
    function setMood(m) { root.dataset.mood = m; }
    function say(t, busyDots) { el.status.textContent = t || ''; el.status.classList.toggle('busy', !!busyDots); }
    function lock(on) { if (overlay) { document.documentElement.classList.toggle('ag-lock', on); } }

    /* ---------- Ulduz sahəsi (3D proyeksiya) ---------- */
    var cv = el.stars, ctx = cv.getContext('2d');
    var W = 0, H = 0, F = 0, Z = 1000, stars = [], speed = 1.3, targetSpeed = 1.3, warp = 0;
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

    /* ---------- İzləyən göz ---------- */
    var ptr = { x: 0, y: 0, t: 0 }, cur = { x: 0, y: 0 }, eyeOff = { x: 0, y: 0 }, tilt = { x: 0, y: 0 }, par = { x: 0, y: 0 }, ps = 1;
    function onMove(e) { ptr.x = e.clientX; ptr.y = e.clientY; ptr.t = performance.now(); }
    window.addEventListener('pointermove', onMove, { passive: true });
    window.addEventListener('pointerdown', onMove, { passive: true });

    var nextBlink = 0;
    function blink() {
        el.eye.classList.add('blink');
        setTimeout(function () { el.eye.classList.remove('blink'); }, 150);
    }

    function frame(ts) {
        if (!running) { return; }
        raf = requestAnimationFrame(frame);

        var rr = root.getBoundingClientRect();
        if (Math.abs(rr.width - W) > 1 || Math.abs(rr.height - H) > 1) { sizeCanvas(); }

        var now = performance.now();
        var sr = el.stage.getBoundingClientRect();
        var ex = sr.left + sr.width / 2, ey = sr.top + sr.height / 2;

        // Hədəf: kursor/toxunuş; hərəkət yoxdursa göz özü ətrafa baxır
        var tx, ty;
        if (now - ptr.t < 2800) { tx = ptr.x; ty = ptr.y; }
        else { tx = rr.left + rr.width / 2 + Math.sin(now / 1300) * rr.width * 0.3; ty = rr.top + rr.height / 2 + Math.cos(now / 1700) * rr.height * 0.2; }
        cur.x += (tx - cur.x) * 0.12; cur.y += (ty - cur.y) * 0.12;

        var dx = cur.x - ex, dy = cur.y - ey, dist = Math.hypot(dx, dy), ang = Math.atan2(dy, dx);
        var max = sr.width * 0.2, k = Math.min(1, dist / (sr.width * 1.1));
        eyeOff.x += (Math.cos(ang) * max * k - eyeOff.x) * 0.22;
        eyeOff.y += (Math.sin(ang) * max * k - eyeOff.y) * 0.22;
        el.eye.style.setProperty('--ix', eyeOff.x.toFixed(2) + 'px');
        el.eye.style.setProperty('--iy', eyeOff.y.toFixed(2) + 'px');

        var nx = Math.max(-1, Math.min(1, dx / (rr.width / 2))), ny = Math.max(-1, Math.min(1, dy / (rr.height / 2)));
        tilt.x += ((-ny * 14) - tilt.x) * 0.08; tilt.y += ((nx * 20) - tilt.y) * 0.08;
        el.orb.style.transform = 'rotateX(' + tilt.x.toFixed(2) + 'deg) rotateY(' + tilt.y.toFixed(2) + 'deg)';

        par.x += (nx - par.x) * 0.05; par.y += (ny - par.y) * 0.05;
        el.par.style.transform = 'translate3d(' + (-par.x * 18).toFixed(1) + 'px,' + (-par.y * 14).toFixed(1) + 'px,0)';

        var mood = root.dataset.mood, base = { scan: 1.3, ok: 1.5, no: 0.55, happy: 1.15 }[mood] || (1.05 + (1 - Math.min(dist, 420) / 420) * 0.3);
        ps += (base - ps) * 0.12;
        root.style.setProperty('--ps', ps.toFixed(3));

        if (now > nextBlink) { blink(); nextBlink = now + 2200 + Math.random() * 3800; }

        // Ulduzlar
        speed += (targetSpeed - speed) * 0.06;
        var dts = 1;
        var cx = W / 2 - par.x * W * 0.035, cy = H / 2 - par.y * H * 0.03;
        ctx.clearRect(0, 0, W, H);
        ctx.lineCap = 'round';
        var trail = 1 + Math.max(0, speed - 3) * 0.55;
        for (var i = 0; i < stars.length; i++) {
            var s = stars[i];
            s.z -= speed * dts;
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
        running = true; sizeCanvas();
        nextBlink = performance.now() + 1500;
        raf = requestAnimationFrame(frame);
    }
    function stopLoop() { running = false; if (raf) { cancelAnimationFrame(raf); raf = 0; } }

    /* ---------- Axın: doğrulama, warp, bağlanma ---------- */
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
        if (noAnim) { setCookie(COOKIE, D.age, D.remember); after(300, finish); return; }
        after(950, function () { setMood('ok'); say(L.verified, false); if (overlay) { setCookie(COOKIE, D.age, D.remember); } });
        after(1650, function () { root.classList.add('is-warp'); targetSpeed = 46; });
        after(2750, finish);
    }

    function deny(silent) {
        busy = true;
        setMood('no');
        el.ask.hidden = true; el.den.hidden = false;
        if (!silent && !noAnim) { el.eye.classList.add('shake'); setTimeout(function () { el.eye.classList.remove('shake'); }, 600); }
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
    }

    function disable(b) { [].forEach.call(root.querySelectorAll('.ag-btn, .ag-dob select'), function (n) { n.disabled = b; }); }

    /* ---------- Doğum tarixi rejimi ---------- */
    function fillDob() {
        if (!el.dd) { return; }
        var lang = document.documentElement.lang || navigator.language || 'en';
        function opt(sel, val, txt) { var o = document.createElement('option'); o.value = val; o.textContent = txt; sel.appendChild(o); }
        opt(el.dd, '', L.day); opt(el.mm, '', L.month); opt(el.yy, '', L.year);
        for (var d = 1; d <= 31; d++) { opt(el.dd, d, d); }
        for (var m = 0; m < 12; m++) {
            var name;
            try { name = new Intl.DateTimeFormat(lang, { month: 'long' }).format(new Date(2000, m, 1)); } catch (e) { name = m + 1; }
            opt(el.mm, m + 1, name);
        }
        var y = new Date().getFullYear();
        for (var i = y; i >= y - 100; i--) { opt(el.yy, i, i); }
    }

    function verifyDob() {
        var d = +el.dd.value, m = +el.mm.value, y = +el.yy.value;
        if (!d || !m || !y) { say(L.pick); return; }
        var dt = new Date(y, m - 1, d);
        if (dt.getFullYear() !== y || dt.getMonth() !== m - 1 || dt.getDate() !== d) { say(L.invalid); return; }
        var n = new Date(), age = n.getFullYear() - y - ((n.getMonth() < m - 1 || (n.getMonth() === m - 1 && n.getDate() < d)) ? 1 : 0);
        if (age >= D.age) { pass(); } else { deny(false); }
    }

    /* ---------- Düymələr ---------- */
    root.addEventListener('click', function (e) {
        var b = e.target.closest('[data-a]');
        if (!b || busy) { return; }
        var a = b.dataset.a;
        if (a === 'yes') { pass(); } else if (a === 'no') { deny(false); } else if (a === 'verify') { verifyDob(); }
    });
    root.addEventListener('mouseover', function (e) {
        if (busy) { return; }
        var y = e.target.closest('.ag-btn.yes');
        setMood(y ? 'happy' : 'calm');
    });
    root.addEventListener('focusin', function (e) { if (!busy) { setMood(e.target.closest && e.target.closest('.ag-btn.yes') ? 'happy' : 'calm'); } });

    root.addEventListener('keydown', function (e) {
        if (!overlay || e.key !== 'Tab') { return; }
        var f = [].slice.call(root.querySelectorAll('button:not([hidden]):not(:disabled), select:not(:disabled)')).filter(function (n) { return n.offsetParent !== null; });
        if (!f.length) { e.preventDefault(); return; }
        var first = f[0], last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });

    window.addEventListener('resize', function () { if (running) { sizeCanvas(); } });

    /* ---------- Başlat ---------- */
    fillDob();

    function open() {
        root.hidden = false;
        lock(true);
        ptr.x = cur.x = window.innerWidth / 2; ptr.y = cur.y = window.innerHeight / 2;
        startLoop();
        if (wasDenied() && overlay) { deny(true); return; }
        var first = root.querySelector('.ag-btn.yes');
        if (first) { try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); } }
    }

    if (overlay) {
        open();
    } else if ('IntersectionObserver' in window) {
        ptr.x = cur.x = 0; ptr.y = cur.y = 0;
        new IntersectionObserver(function (es) {
            es.forEach(function (en) { if (en.isIntersecting) { startLoop(); } else { stopLoop(); } });
        }, { threshold: 0.05 }).observe(root);
    } else {
        startLoop();
    }
})();
</script>
