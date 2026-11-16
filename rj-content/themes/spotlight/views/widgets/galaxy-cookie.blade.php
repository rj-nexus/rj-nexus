@php
    $uid = $uid ?? ('gc_' . substr(md5(uniqid('', true)), 0, 8));
    $pos = in_array(($settings['position'] ?? 'bottom-right'), ['bottom-right', 'bottom-left', 'bottom-center'], true) ? ($settings['position'] ?? 'bottom-right') : 'bottom-right';
    $tag = $settings['tag'] ?? '[ COOKIES ]';
@endphp

<style>
    /*
     * Fixed element = always on screen, so it is kept cheap: no backdrop-filter, no animated filters or shadows,
     * only transform/opacity animations on a few small layers.
     */
    #{{ $uid }} {
        position: fixed; z-index: 99999; bottom: 24px; width: min(420px, calc(100% - 32px)); font-family: var(--rj-font-body, inherit);
        transition: translate .8s cubic-bezier(.16,1,.3,1), opacity .5s ease, scale .8s cubic-bezier(.16,1,.3,1);
    }
    #{{ $uid }}.rj-gc-hidden { translate: 0 160%; opacity: 0; scale: .96; pointer-events: none; }
    #{{ $uid }}[data-position="bottom-right"]  { right: 24px; }
    #{{ $uid }}[data-position="bottom-left"]   { left: 24px; }
    #{{ $uid }}[data-position="bottom-center"] { left: 0; right: 0; margin: 0 auto; }

    /* ---------- Card ---------- */
    #{{ $uid }} .rj-gc-card {
        position: relative; border-radius: 24px; overflow: hidden; isolation: isolate;
        box-shadow: 0 30px 70px -20px rgba(0,0,0,.9), 0 0 60px -25px hsl(265 90% 60% / .65);
    }
    #{{ $uid }} .rj-gc-beam { /* rotating border light (compositor-only) */
        position: absolute; left: 50%; top: 50%; width: 280%; aspect-ratio: 1; translate: -50% -50%; z-index: 0; pointer-events: none; will-change: transform;
        background: conic-gradient(from 0deg, rgba(255,255,255,.1) 0 55%, hsl(265 95% 70%) 74%, hsl(320 90% 66%) 88%, rgba(255,255,255,.1) 100%);
        animation: rjGcSpin 9s linear infinite;
    }
    #{{ $uid }} .rj-gc-glass {
        position: absolute; inset: 1px; z-index: 1; border-radius: 23px; overflow: hidden; pointer-events: none;
        background:
            radial-gradient(70% 90% at 0% 0%, hsl(265 85% 55% / .32), transparent 65%),
            radial-gradient(60% 80% at 100% 100%, hsl(320 85% 55% / .22), transparent 65%),
            radial-gradient(45% 55% at 60% 110%, hsl(215 90% 55% / .2), transparent 65%),
            linear-gradient(155deg, rgba(255,255,255,.09), rgba(255,255,255,.015) 40%, rgba(255,255,255,.04)),
            rgba(7, 6, 22, .94);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.22);
    }
    #{{ $uid }} .rj-gc-stars {
        position: absolute; inset: 0; opacity: .5; animation: rjGcTwinkle 5s ease-in-out infinite alternate;
        background-image:
            radial-gradient(1px 1px at 20px 30px, #fff, transparent), radial-gradient(1px 1px at 40px 70px, #fff, transparent),
            radial-gradient(1px 1px at 50px 160px, #fff, transparent), radial-gradient(1px 1px at 90px 40px, #fff, transparent),
            radial-gradient(1.5px 1.5px at 130px 80px, #c4b5fd, transparent), radial-gradient(1px 1px at 160px 120px, #fff, transparent),
            radial-gradient(1.5px 1.5px at 110px 150px, #f9a8d4, transparent);
        background-size: 200px 200px;
    }
    #{{ $uid }} .rj-gc-shoot { /* shooting star */
        position: absolute; top: 14%; left: -25%; width: 90px; height: 1.5px; opacity: 0; transform: rotate(18deg);
        background: linear-gradient(90deg, transparent, #fff); animation: rjGcShoot 8s ease-in 2.5s infinite;
    }

    /* ---------- Content ---------- */
    #{{ $uid }} .rj-gc-body { position: relative; z-index: 2; padding: 22px; }
    #{{ $uid }} .rj-gc-content { display: flex; gap: 22px; align-items: center; margin-bottom: 20px; }

    /* cookie planet */
    #{{ $uid }} .rj-gc-planet { position: relative; flex: none; width: 64px; height: 64px; margin: 6px 12px 6px 8px; animation: rjGcFloat 6s ease-in-out infinite; }
    #{{ $uid }} .rj-gc-atmos { position: absolute; inset: -38%; pointer-events: none; background: radial-gradient(closest-side, hsl(35 95% 60% / .4), transparent 70%); animation: rjGcBreathe 5s ease-in-out infinite; }
    #{{ $uid }} .rj-gc-tilt { position: absolute; inset: -34%; transform: rotate(-22deg) scaleY(.36); pointer-events: none; }
    #{{ $uid }} .rj-gc-spin { position: absolute; inset: 0; border-radius: 50%; border: 1.5px solid hsl(265 90% 82% / .5); animation: rjGcSpin 7s linear infinite; }
    #{{ $uid }} .rj-gc-spin::before { /* the moon */
        content: ''; position: absolute; left: 50%; top: -5px; width: 9px; height: 9px; margin-left: -4.5px; border-radius: 50%;
        background: radial-gradient(circle at 35% 30%, #fff, #c4b5fd 60%, #6d5bd0); box-shadow: 0 0 10px 2px hsl(265 95% 75% / .8);
    }
    #{{ $uid }} .rj-gc-cookie {
        position: absolute; inset: 0; border-radius: 50%; overflow: hidden; z-index: 1;
        background: radial-gradient(circle at 32% 28%, #f7c873 0%, #dc9c47 45%, #a8672a 100%);
        -webkit-mask: radial-gradient(circle at 85% 15%, transparent 0 11px, #000 12px); mask: radial-gradient(circle at 85% 15%, transparent 0 11px, #000 12px);
    }
    #{{ $uid }} .rj-gc-cookie::before { /* chocolate chips, 2x wide so it scrolls seamlessly = the planet rotates */
        content: ''; position: absolute; top: 0; bottom: 0; left: 0; width: 200%; background-size: 50% 100%; will-change: transform;
        background-image:
            radial-gradient(ellipse 5px 4px at 16% 28%, #3a1c0c 0 70%, transparent 74%), radial-gradient(ellipse 4px 5px at 42% 62%, #3a1c0c 0 70%, transparent 74%),
            radial-gradient(ellipse 6px 4px at 68% 22%, #2f160a 0 70%, transparent 74%), radial-gradient(ellipse 4px 4px at 84% 70%, #3a1c0c 0 70%, transparent 74%),
            radial-gradient(ellipse 3px 3px at 30% 84%, #3a1c0c 0 70%, transparent 74%), radial-gradient(ellipse 3px 3px at 56% 44%, #2f160a 0 70%, transparent 74%);
        animation: rjGcCookie 16s linear infinite;
    }
    #{{ $uid }} .rj-gc-cookie::after { /* light + night side */
        content: ''; position: absolute; inset: 0; border-radius: 50%;
        background: radial-gradient(circle at 30% 25%, rgba(255,244,214,.45), transparent 40%), radial-gradient(circle at 78% 82%, rgba(20,8,0,.75), transparent 66%);
        box-shadow: inset -8px -6px 14px rgba(40,18,0,.6);
    }

    #{{ $uid }} .rj-gc-text { min-width: 0; }
    #{{ $uid }} .rj-gc-tag { display: block; margin-bottom: 8px; font: 700 10px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .16em; text-transform: uppercase; color: hsl(265 95% 82%); }
    #{{ $uid }} .rj-gc-text h4 { margin: 0 0 6px; font-size: 17px; font-weight: 600; letter-spacing: -.02em; color: #f8fafc; }
    #{{ $uid }} .rj-gc-text p { margin: 0; font-size: 13px; line-height: 1.55; color: rgba(226,232,240,.7); }

    /* ---------- Buttons (glass) ---------- */
    #{{ $uid }} .rj-gc-actions { display: flex; gap: 10px; }
    #{{ $uid }} .rj-gc-btn {
        position: relative; overflow: hidden; flex: 1; padding: 12px 16px; border-radius: 12px; cursor: pointer; text-align: center; font-family: inherit; font-size: 13px; font-weight: 600;
        transition: transform .25s cubic-bezier(.16,1,.3,1), background .25s, border-color .25s, color .25s;
    }
    #{{ $uid }} .rj-gc-btn:focus-visible { outline: 2px solid hsl(265 95% 78%); outline-offset: 2px; }
    #{{ $uid }} .rj-gc-btn-decline { color: rgba(226,232,240,.75); background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.14); box-shadow: inset 0 1px 0 rgba(255,255,255,.1); }
    #{{ $uid }} .rj-gc-btn-decline:hover { color: #fff; background: rgba(255,255,255,.09); border-color: rgba(255,255,255,.3); }
    #{{ $uid }} .rj-gc-btn-accept {
        color: #fff; border: 1px solid rgba(255,255,255,.3);
        background: linear-gradient(160deg, rgba(255,255,255,.24), rgba(255,255,255,.06)), linear-gradient(135deg, hsl(265 85% 58% / .55), hsl(320 85% 58% / .55));
        box-shadow: inset 0 1px 0 rgba(255,255,255,.45), 0 12px 26px -12px hsl(280 95% 60% / .9);
    }
    #{{ $uid }} .rj-gc-btn-accept::after { content: ''; position: absolute; inset: 0; background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.5) 50%, transparent 70%); translate: -130% 0; }
    #{{ $uid }} .rj-gc-btn-accept:hover { transform: translateY(-2px); border-color: rgba(255,255,255,.55); }
    #{{ $uid }} .rj-gc-btn-accept:hover::after { translate: 130% 0; transition: translate .7s ease; }
    #{{ $uid }} .rj-gc-btn:active { transform: scale(.98); }

    /* accept: a burst of crumbs flies out of the cookie */
    #{{ $uid }} .rj-gc-burst { position: absolute; left: 50%; top: 50%; width: 0; height: 0; z-index: 3; pointer-events: none; }
    #{{ $uid }} .rj-gc-burst i { position: absolute; left: -3px; top: -3px; width: 6px; height: 6px; border-radius: 50%; opacity: 0; background: radial-gradient(circle, #fff 0 25%, #f7c873 60%, transparent 75%); }
    #{{ $uid }}.is-accepted .rj-gc-burst i { animation: rjGcBurst .8s ease-out forwards; }
    #{{ $uid }}.is-accepted .rj-gc-planet { animation: rjGcPop .5s ease-out; }

    @keyframes rjGcSpin { to { rotate: 360deg; } }
    @keyframes rjGcCookie { to { transform: translateX(-50%); } }
    @keyframes rjGcFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
    @keyframes rjGcBreathe { 0%, 100% { opacity: .6; transform: scale(.95); } 50% { opacity: 1; transform: scale(1.05); } }
    @keyframes rjGcTwinkle { from { opacity: .3; } to { opacity: .75; } }
    @keyframes rjGcShoot { 0% { opacity: 0; transform: translate3d(0,0,0) rotate(18deg); } 3% { opacity: 1; } 12%, 100% { opacity: 0; transform: translate3d(540px, 175px, 0) rotate(18deg); } }
    @keyframes rjGcBurst { 0% { opacity: 1; transform: rotate(var(--a)) translateX(0) scale(1); } 100% { opacity: 0; transform: rotate(var(--a)) translateX(62px) scale(.4); } }
    @keyframes rjGcPop { 0% { transform: scale(1); } 40% { transform: scale(1.25) rotate(8deg); } 100% { transform: scale(1); } }

    @media (max-width: 480px) {
        #{{ $uid }} { bottom: 16px; left: 16px !important; right: 16px !important; width: auto; margin: 0 !important; }
        #{{ $uid }} .rj-gc-body { padding: 18px; }
        #{{ $uid }} .rj-gc-content { gap: 16px; }
        #{{ $uid }} .rj-gc-planet { width: 54px; height: 54px; margin: 4px 8px 4px 6px; }
        #{{ $uid }} .rj-gc-actions { flex-direction: column-reverse; }
        #{{ $uid }} .rj-gc-btn { padding: 13px 16px; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; }
    }
</style>

<div id="{{ $uid }}" class="rj-gc-hidden" data-position="{{ $pos }}" role="dialog" aria-live="polite" aria-label="{{ $settings['title'] ?? __('We value your privacy') }}">
    <div class="rj-gc-card">
        <span class="rj-gc-beam"></span>
        <div class="rj-gc-glass"><div class="rj-gc-stars"></div><span class="rj-gc-shoot"></span></div>

        <div class="rj-gc-body">
            <div class="rj-gc-content">
                <div class="rj-gc-planet" aria-hidden="true">
                    <span class="rj-gc-atmos"></span>
                    <div class="rj-gc-tilt"><div class="rj-gc-spin"></div></div>
                    <div class="rj-gc-cookie"></div>
                    <div class="rj-gc-burst">
                        @for($b = 0; $b < 8; $b++)<i style="--a: {{ $b * 45 }}deg;"></i>@endfor
                    </div>
                </div>

                <div class="rj-gc-text">
                    @if($tag !== '')<span class="rj-gc-tag">{{ $tag }}</span>@endif
                    <h4>{{ $settings['title'] ?? __('We value your privacy') }}</h4>
                    <p>{{ $settings['message'] ?? __('We use cookies to enhance your browsing experience and analyze our traffic.') }}</p>
                </div>
            </div>

            <div class="rj-gc-actions">
                <button type="button" class="rj-gc-btn rj-gc-btn-decline" data-action="decline">
                    {{ $settings['decline_text'] ?? __('Decline') }}
                </button>
                <button type="button" class="rj-gc-btn rj-gc-btn-accept" data-action="accept">
                    {{ $settings['accept_text'] ?? __('Accept All') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var KEY = 'rj_cookie_consent';
    function read() { try { return localStorage.getItem(KEY); } catch (e) { return null; } }
    function write(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }

    // already answered: nothing to show
    if (read()) { root.remove(); return; }

    setTimeout(function () { root.classList.remove('rj-gc-hidden'); }, 1500);

    function answer(action) {
        write(KEY, action);
        write(KEY + '_date', new Date().toISOString());
        document.dispatchEvent(new CustomEvent('rj-cookie-consent', { detail: { action: action } }));

        var wait = 0;
        if (action === 'accept') { root.classList.add('is-accepted'); wait = 600; }   // let the crumbs fly first
        setTimeout(function () { root.classList.add('rj-gc-hidden'); }, wait);
        setTimeout(function () { root.remove(); }, wait + 900);
    }

    root.querySelectorAll('.rj-gc-btn').forEach(function (btn) {
        btn.addEventListener('click', function () { answer(this.getAttribute('data-action')); });
    });
})();
</script>