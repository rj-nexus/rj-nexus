@php
    $hasHead = $t['title'] !== '' || $t['subtitle'] !== '';
    $pillText = $o['mode'] === 'shift' ? __('Hold Shift to zoom & move') : __('Click to explore');
@endphp

<style>
    @property --rjg-ang { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

    #{{ $uid }} { position: relative; width: 100%; padding: clamp(24px, 4vw, 48px) clamp(12px, 3vw, 24px); background: linear-gradient(180deg, rgba(248, 250, 252, .75), rgba(238, 242, 255, .55)); font-family: inherit; --bc: {{ $o['bc'] }}; --bcl: {{ $o['bcl'] }}; --bcd: {{ $o['bcd'] }}; --brgb: {{ $o['brgb'] }}; --r: {{ $o['r_px'] }}px; --fw: {{ $o['fw_px'] }}px; --fsbg: {{ $o['fs_bg'] }}; --sh: {{ $o['shadow'] }}; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} button { font-family: inherit; }
    #{{ $uid }} svg { display: block; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjg-head { max-width: 760px; margin: 0 auto clamp(20px, 3vw, 32px); text-align: center; }
    #{{ $uid }} .rjg-sub { margin: 0 0 10px; color: var(--bc); font-size: .75rem; font-weight: 800; letter-spacing: .22em; text-transform: uppercase; }
    #{{ $uid }} .rjg-title { margin: 0; padding: 0; color: #0f172a; font-size: clamp(1.6rem, 3.4vw, 2.5rem); font-weight: 800; line-height: 1.15; letter-spacing: -.02em; }
    #{{ $uid }} .rjg-head::after { content: ""; display: block; width: 44px; height: 4px; margin: 16px auto 0; border-radius: 4px; background: var(--bc); }

    /* ---------- Shell / reveal ---------- */
    #{{ $uid }} .rjg-shell { max-width: {{ $o['shell_w'] }}; margin: 0 auto; }
    #{{ $uid }}.rjg-js .rjg-shell { opacity: 0; transform: translate3d(0, 34px, 0) scale(.97); }
    #{{ $uid }}.rjg-js.rjg-in .rjg-shell { opacity: 1; transform: none; transition: opacity .8s ease, transform .9s cubic-bezier(.2, .8, .2, 1); }

    #{{ $uid }} .rjg-fsroot { position: relative; }

    /* ---------- Frame ---------- */
    #{{ $uid }} .rjg-frame { position: relative; border-radius: var(--r); box-shadow: var(--sh); transition: transform .5s cubic-bezier(.2, .8, .2, 1), box-shadow .5s ease; --inset: 0px; }
    #{{ $uid }}[data-hover="1"] .rjg-frame:hover { transform: translateY(-4px); box-shadow: var(--sh), 0 26px 50px -18px rgba(var(--brgb), .55); }

    #{{ $uid }} .rjg-frame[data-frame="gradient"] { --inset: var(--fw); padding: var(--fw); background: var(--bc); background: conic-gradient(from var(--rjg-ang), var(--bc), var(--bcl), var(--bcd), var(--bcl), var(--bc)); animation: rjg-spin 7s linear infinite; }
    #{{ $uid }} .rjg-frame[data-frame="card"] { --inset: calc(var(--fw) + 8px); padding: 8px; background: #fff; border: var(--fw) solid var(--bc); }
    #{{ $uid }} .rjg-frame[data-frame="line"] { --inset: var(--fw); border: var(--fw) solid var(--bc); overflow: hidden; }
    #{{ $uid }} .rjg-frame[data-frame="none"] { --inset: 0px; }

    /* ---------- Stage ---------- */
    #{{ $uid }} .rjg-stage { position: relative; width: 100%; {{ $o['stage_css'] }} overflow: hidden; border-radius: max(0px, calc(var(--r) - var(--inset))); background: #e2e8f0; isolation: isolate; }
    #{{ $uid }} .rjg-skel { position: absolute; inset: 0; z-index: 0; display: grid; place-items: center; background-color: #e2e8f0; background-image: linear-gradient(100deg, transparent 30%, rgba(255, 255, 255, .55) 50%, transparent 70%); background-size: 220% 100%; animation: rjg-shimmer 1.6s linear infinite; color: var(--bc); }
    #{{ $uid }} .rjg-skel svg { width: 44px; height: 44px; opacity: .7; animation: rjg-bob 2.2s ease-in-out infinite; }
    #{{ $uid }} .rjg-iframe { position: absolute; inset: 0; z-index: 1; display: block; width: 100%; height: 100%; max-width: none; border: 0; background: transparent; }

    /* ---------- Cover (blocks the iframe until activated) ---------- */
    #{{ $uid }} .rjg-cover { position: absolute; inset: 0; z-index: 4; display: grid; place-items: center; background: linear-gradient(180deg, rgba(2, 6, 23, .04), rgba(2, 6, 23, .3)); transition: opacity .35s ease, visibility .35s ease, background .35s ease; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }}[data-eff="click"] .rjg-cover { cursor: pointer; }
    #{{ $uid }}[data-eff="click"] .rjg-cover:hover { background: linear-gradient(180deg, rgba(2, 6, 23, .1), rgba(2, 6, 23, .42)); }
    #{{ $uid }} .rjg-cover:focus-visible { outline: 3px solid var(--bc); outline-offset: -6px; }
    #{{ $uid }}.rjg-live .rjg-cover, #{{ $uid }}.rjg-fs .rjg-cover { opacity: 0; visibility: hidden; pointer-events: none; }

    #{{ $uid }} .rjg-pill { display: inline-flex; align-items: center; gap: 12px; max-width: calc(100% - 32px); padding: 10px 20px 10px 10px; border-radius: 999px; background: rgba(255, 255, 255, .94); color: #0f172a; font-size: .88rem; font-weight: 700; line-height: 1.2; -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); box-shadow: 0 16px 40px -10px rgba(2, 6, 23, .5); transition: transform .35s cubic-bezier(.34, 1.56, .64, 1); animation: rjg-pill 3s ease-in-out infinite; }
    #{{ $uid }}[data-eff="click"] .rjg-cover:hover .rjg-pill { transform: scale(1.06); animation: none; }
    #{{ $uid }} .rjg-pill-ic { flex: none; position: relative; width: 38px; height: 38px; display: grid; place-items: center; border-radius: 50%; background: var(--bc); color: #fff; }
    #{{ $uid }} .rjg-pill-ic svg { width: 20px; height: 20px; }
    #{{ $uid }} .rjg-pill-ic::after { content: ""; position: absolute; inset: 0; border-radius: 50%; border: 2px solid var(--bc); animation: rjg-ring 2s ease-out infinite; }
    #{{ $uid }} kbd { display: inline-block; margin: 0 2px; padding: 2px 8px; border: 1px solid rgba(15, 23, 42, .25); border-bottom-width: 2px; border-radius: 6px; background: #f1f5f9; font: 700 .78rem/1.3 ui-monospace, SFMono-Regular, Menlo, monospace; }

    /* ---------- Chips / buttons ---------- */
    #{{ $uid }} .rjg-badge { position: absolute; z-index: 5; left: 14px; bottom: 14px; display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 999px; background: rgba(2, 6, 23, .6); color: #fff; font-size: .78rem; font-weight: 800; letter-spacing: .08em; -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); pointer-events: none; }
    #{{ $uid }} .rjg-badge svg { width: 16px; height: 16px; color: var(--bcl); animation: rjg-turn 8s linear infinite; }

    #{{ $uid }} .rjg-status { position: absolute; z-index: 5; left: 14px; top: 14px; display: inline-flex; align-items: center; gap: 8px; max-width: calc(100% - 90px); padding: 8px 14px; border-radius: 999px; background: rgba(255, 255, 255, .94); color: #0f172a; font-size: .76rem; font-weight: 700; line-height: 1.25; box-shadow: 0 10px 24px -8px rgba(2, 6, 23, .45); pointer-events: none; opacity: 0; transform: translateY(-8px); transition: opacity .3s ease, transform .3s ease; }
    #{{ $uid }} .rjg-status i { flex: none; width: 8px; height: 8px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 0 rgba(34, 197, 94, .6); animation: rjg-ring-g 1.8s ease-out infinite; }
    #{{ $uid }}.rjg-live .rjg-status { opacity: 1; transform: none; }
    #{{ $uid }}.rjg-fs .rjg-status { opacity: 0; }

    #{{ $uid }} .rjg-btn { position: absolute; z-index: 6; width: 42px; height: 42px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid rgba(255, 255, 255, .35); border-radius: 12px; background: rgba(2, 6, 23, .6); color: #fff; cursor: pointer; -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); transition: background-color .25s ease, transform .3s cubic-bezier(.34, 1.56, .64, 1); }
    #{{ $uid }} .rjg-btn:hover { background: var(--bc); transform: scale(1.08); }
    #{{ $uid }} .rjg-btn:focus-visible { outline: 3px solid #fff; outline-offset: 2px; }
    #{{ $uid }} .rjg-btn svg { width: 18px; height: 18px; }
    #{{ $uid }} .rjg-fsbtn { top: 14px; right: 14px; }
    #{{ $uid }} .rjg-fsbtn .rjg-i-exit { display: none; }
    #{{ $uid }}.rjg-fs .rjg-fsbtn .rjg-i-exit { display: block; }
    #{{ $uid }}.rjg-fs .rjg-fsbtn .rjg-i-enter { display: none; }

    #{{ $uid }} .rjg-done { position: absolute; z-index: 6; left: 50%; bottom: 14px; display: none; align-items: center; gap: 8px; margin: 0; padding: 10px 18px; border: 0; border-radius: 999px; background: #fff; color: #0f172a; font-size: .8rem; font-weight: 800; cursor: pointer; transform: translateX(-50%); box-shadow: 0 12px 28px -8px rgba(2, 6, 23, .55); transition: background-color .2s ease, color .2s ease; }
    #{{ $uid }} .rjg-done:hover { background: var(--bc); color: #fff; }
    #{{ $uid }} .rjg-done svg { width: 14px; height: 14px; }
    #{{ $uid }}[data-eff="click"].rjg-live:not(.rjg-fs) .rjg-done { display: inline-flex; }

    /* ---------- Fullscreen (framed) ---------- */
    #{{ $uid }}.rjg-fs .rjg-fsroot { position: fixed; inset: 0; z-index: 99999; width: 100vw; height: 100vh; height: 100dvh; display: flex; padding: 14px; background: var(--fsbg); }
    #{{ $uid }}.rjg-fs .rjg-frame { flex: 1; min-width: 0; display: flex; transform: none !important; }
    #{{ $uid }}.rjg-fs .rjg-frame[data-frame="line"], #{{ $uid }}.rjg-fs .rjg-frame[data-frame="card"] { overflow: hidden; }
    #{{ $uid }}.rjg-fs .rjg-stage { flex: 1; width: auto; height: auto !important; min-height: 0 !important; max-height: none !important; aspect-ratio: auto !important; }

    /* ---------- Keyframes ---------- */
    @keyframes rjg-spin { to { --rjg-ang: 360deg; } }
    @keyframes rjg-shimmer { from { background-position: 220% 0; } to { background-position: -120% 0; } }
    @keyframes rjg-bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
    @keyframes rjg-pill { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
    @keyframes rjg-ring { 0% { opacity: .7; transform: scale(1); } 100% { opacity: 0; transform: scale(1.7); } }
    @keyframes rjg-ring-g { 0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, .6); } 80%, 100% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); } }
    @keyframes rjg-turn { to { transform: rotate(360deg); } }

    @media (max-width: 640px) {
        #{{ $uid }} .rjg-pill { padding: 8px 16px 8px 8px; font-size: .8rem; }
        #{{ $uid }} .rjg-pill-ic { width: 32px; height: 32px; }
        #{{ $uid }} .rjg-btn { width: 38px; height: 38px; top: 10px !important; right: 10px; }
        #{{ $uid }} .rjg-badge { left: 10px; bottom: 10px; padding: 6px 11px; }
        #{{ $uid }} .rjg-status { left: 10px; top: 10px; }
        #{{ $uid }}.rjg-fs .rjg-fsroot { padding: 8px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
    }
</style>

<section id="{{ $uid }}"
         class="rjg"
         data-mode="{{ $o['mode'] }}"
         data-eff="{{ $o['mode'] }}"
         data-hover="{{ $o['hover'] ? 1 : 0 }}"
         data-entrance="{{ $o['entrance'] ? 1 : 0 }}"
         data-config="{{ $o['config_json'] }}">

    @if ($hasHead)
        <header class="rjg-head">
            @if ($t['subtitle'] !== '')
                <p class="rjg-sub">{{ $t['subtitle'] }}</p>
            @endif
            @if ($t['title'] !== '')
                <h2 class="rjg-title">{{ $t['title'] }}</h2>
            @endif
        </header>
    @endif

    <div class="rjg-shell">
        <div class="rjg-fsroot">
            <div class="rjg-frame" data-frame="{{ $o['frame'] }}">
                <div class="rjg-stage">
                    <div class="rjg-skel" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>

                    <iframe class="rjg-iframe"
                            src="{{ $iframeUrl }}"
                            title="{{ $t['title'] !== '' ? $t['title'] : __('360° tour') }}"
                            allow="fullscreen; accelerometer; gyroscope; xr-spatial-tracking"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                            sandbox="allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-forms allow-presentation"></iframe>

                    @if ($o['mode'] !== 'free')
                        <div class="rjg-cover">
                            <span class="rjg-pill">
                                <span class="rjg-pill-ic" aria-hidden="true">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 11V5a2 2 0 114 0v6m0-1a2 2 0 114 0v2m0-1a2 2 0 114 0v4a7 7 0 01-7 7h-1a7 7 0 01-5.6-2.8L4 15.5a2 2 0 013-2.6L9 15"/></svg>
                                </span>
                                <span class="rjg-pill-text">{{ $pillText }}</span>
                            </span>
                        </div>
                    @endif

                    @if ($o['badge'] !== '')
                        <span class="rjg-badge">
                            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12a9 9 0 11-3-6.7"/><path d="M21 4v5h-5"/></svg>
                            {{ $o['badge'] }}
                        </span>
                    @endif

                    <span class="rjg-status" role="status" aria-live="polite"><i aria-hidden="true"></i><span class="rjg-status-text">{{ __('Interactive') }}</span></span>

                    @if ($o['show_fs'])
                        <button type="button" class="rjg-btn rjg-fsbtn" aria-label="{{ __('Fullscreen') }}" aria-pressed="false">
                            <svg class="rjg-i-enter" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                            <svg class="rjg-i-exit" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M8 3v3a2 2 0 01-2 2H3m18 0h-3a2 2 0 01-2-2V3m0 18v-3a2 2 0 012-2h3M3 16h3a2 2 0 012 2v3"/></svg>
                        </button>
                    @endif

                    @if ($o['mode'] !== 'free')
                        <button type="button" class="rjg-done">
                            <svg fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                            {{ __('Done') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var cfg;
    try { cfg = JSON.parse(root.getAttribute('data-config')); } catch (e) { return; }
    var S = cfg.strings;

    var stage = root.querySelector('.rjg-stage');
    var fsRoot = root.querySelector('.rjg-fsroot');
    var iframe = root.querySelector('.rjg-iframe');
    var cover = root.querySelector('.rjg-cover');
    var pillText = root.querySelector('.rjg-pill-text');
    var statusText = root.querySelector('.rjg-status-text');
    var btnFs = root.querySelector('.rjg-fsbtn');
    var btnDone = root.querySelector('.rjg-done');

    var reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    var coarse = !(window.matchMedia && window.matchMedia('(hover: hover)').matches);

    // Shift needs a keyboard: on touch devices fall back to tap-to-activate
    var mode = cfg.mode;
    if (mode === 'shift' && coarse) { mode = 'click'; }
    root.setAttribute('data-eff', mode);

    var live = (mode === 'free');
    var hovering = false;
    var fsOn = false;
    var nativeFs = false;
    var htmlOverflow = '';

    function blurFrame() {
        try { if (document.activeElement === iframe) { iframe.blur(); } } catch (e) {}
    }

    function setLive(on) {
        if (mode === 'free' || on === live) { return; }
        live = on;
        root.classList.toggle('rjg-live', on);
        if (!on) { blurFrame(); }
    }

    // ---------- Copy for the chosen mode ----------
    if (pillText) {
        if (mode === 'shift') { pillText.innerHTML = ''; var k = document.createElement('kbd'); k.textContent = 'Shift'; pillText.appendChild(k); pillText.appendChild(document.createTextNode(' + ' + S.shift.replace(/^Hold\s+Shift\s*/i, '').replace(/^\+\s*/, ''))); pillText.textContent = S.shift; }
        else { pillText.textContent = coarse ? S.tap : S.click; }
    }
    if (statusText) { statusText.textContent = mode === 'shift' ? S.activeShift : S.activeClick; }

    // ---------- Click / tap mode ----------
    if (cover && mode === 'click') {
        cover.setAttribute('role', 'button');
        cover.setAttribute('tabindex', '0');
        cover.setAttribute('aria-label', coarse ? S.tap : S.click);

        cover.addEventListener('click', function () { setLive(true); });
        cover.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setLive(true); }
        });
    }

    if (btnDone) { btnDone.addEventListener('click', function () { setLive(false); }); }

    // ---------- Pointer handling (desktop) ----------
    stage.addEventListener('pointerenter', function (e) {
        if (e.pointerType !== 'mouse') { return; }
        hovering = true;
        blurFrame();
        if (mode === 'shift') { setLive(!!e.shiftKey); }
    });

    stage.addEventListener('pointermove', function (e) {
        if (mode === 'shift' && e.pointerType === 'mouse') { setLive(!!e.shiftKey); }
    });

    stage.addEventListener('pointerleave', function (e) {
        if (e.pointerType !== 'mouse') { return; }
        hovering = false;
        if (mode !== 'free' && !fsOn) { setLive(false); }
        else { blurFrame(); }
    });

    // ---------- Keyboard / outside taps ----------
    function onKeyDown(e) {
        if (!root.isConnected) { cleanup(); return; }

        if (e.key === 'Shift' && mode === 'shift' && hovering) { setLive(true); }
        else if (e.key === 'Escape') {
            if (fsOn) { exitFs(); }
            else if (mode === 'click') { setLive(false); }
        }
    }

    function onKeyUp(e) {
        if (e.key === 'Shift' && mode === 'shift') { setLive(false); }
    }

    function onDocDown(e) {
        if (!root.isConnected) { cleanup(); return; }
        if (mode === 'click' && live && !stage.contains(e.target)) { setLive(false); }
    }

    document.addEventListener('keydown', onKeyDown);
    document.addEventListener('keyup', onKeyUp);
    document.addEventListener('pointerdown', onDocDown, true);

    function cleanup() {
        document.removeEventListener('keydown', onKeyDown);
        document.removeEventListener('keyup', onKeyUp);
        document.removeEventListener('pointerdown', onDocDown, true);
        document.removeEventListener('fullscreenchange', onFsChange);
        document.removeEventListener('webkitfullscreenchange', onFsChange);
    }

    // ---------- Fullscreen (framed) ----------
    function syncFsUi(on) {
        if (!btnFs) { return; }
        btnFs.setAttribute('aria-pressed', on ? 'true' : 'false');
        btnFs.setAttribute('aria-label', on ? S.exitFs : S.enterFs);
    }

    function enterFs() {
        if (fsOn) { return; }
        fsOn = true;
        root.classList.add('rjg-fs');
        htmlOverflow = document.documentElement.style.overflow;
        document.documentElement.style.overflow = 'hidden';

        var req = fsRoot.requestFullscreen || fsRoot.webkitRequestFullscreen;
        if (req) {
            try {
                var p = req.call(fsRoot);
                if (p && p.catch) { p.catch(function () {}); }
            } catch (err) {}
        }
        syncFsUi(true);
    }

    function exitFs() {
        if (!fsOn) { return; }
        fsOn = false;
        nativeFs = false;
        root.classList.remove('rjg-fs');
        document.documentElement.style.overflow = htmlOverflow;

        var el = document.fullscreenElement || document.webkitFullscreenElement;
        if (el) {
            var ex = document.exitFullscreen || document.webkitExitFullscreen;
            if (ex) {
                try {
                    var p = ex.call(document);
                    if (p && p.catch) { p.catch(function () {}); }
                } catch (err) {}
            }
        }

        syncFsUi(false);
        if (mode !== 'free') { live = true; setLive(false); }
    }

    function onFsChange() {
        if (!root.isConnected) { cleanup(); return; }
        var el = document.fullscreenElement || document.webkitFullscreenElement;
        if (el === fsRoot) { nativeFs = true; }
        else if (fsOn && nativeFs && !el) { exitFs(); }
    }

    document.addEventListener('fullscreenchange', onFsChange);
    document.addEventListener('webkitfullscreenchange', onFsChange);

    if (btnFs) { btnFs.addEventListener('click', function () { if (fsOn) { exitFs(); } else { enterFs(); } }); }

    // ---------- Reveal on scroll ----------
    if (root.getAttribute('data-entrance') === '1' && !reduce) {
        root.classList.add('rjg-js');
        void root.offsetWidth;

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    io.disconnect();
                    root.classList.add('rjg-in');
                }
            }, { threshold: 0.12 });
            io.observe(root);
        } else {
            root.classList.add('rjg-in');
        }
    }
})();
</script>
