<style>
    #{{ $uid }} { --acc: {{ $o['accent'] }}; --sz0: {{ $o['size'] }}px; --sz: var(--sz0); --hex: url(#{{ $uid }}-hex);
        --pill-bg: rgba(255,255,255,.62); --pill-fg: #0f172a; --pill-bd: rgba(255,255,255,.7); --gapc: #fff;
        position: relative; width: 100%; padding: 8px 0; box-sizing: border-box; }
    #{{ $uid }}[data-style="glass-dark"] { --pill-bg: rgba(15,23,42,.62); --pill-fg: #fff; --pill-bd: rgba(255,255,255,.2); --gapc: #0f172a; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }

    /* Karusel zolağı */
    #{{ $uid }} .hx-wrap { position: relative; max-width: 100%; }
    #{{ $uid }} .hx-track { display: flex; gap: 14px; padding: 22px 16px 20px; margin: -14px 0; overflow-x: auto; overflow-y: hidden; scroll-snap-type: x proximity; scroll-padding: 0 16px; -webkit-overflow-scrolling: touch; scrollbar-width: none; overscroll-behavior-x: contain; }
    #{{ $uid }} .hx-track::-webkit-scrollbar { display: none; }
    #{{ $uid }}[data-align="center"] .hx-item:first-child { margin-left: auto; }
    #{{ $uid }}[data-align="center"] .hx-item:last-child { margin-right: auto; }
    #{{ $uid }} .hx-track.fade-l { -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 36px); mask-image: linear-gradient(90deg, transparent 0, #000 36px); }
    #{{ $uid }} .hx-track.fade-r { -webkit-mask-image: linear-gradient(90deg, #000 calc(100% - 36px), transparent 100%); mask-image: linear-gradient(90deg, #000 calc(100% - 36px), transparent 100%); }
    #{{ $uid }} .hx-track.fade-l.fade-r { -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 36px, #000 calc(100% - 36px), transparent 100%); mask-image: linear-gradient(90deg, transparent 0, #000 36px, #000 calc(100% - 36px), transparent 100%); }

    /* Ox düymələri (glass) */
    #{{ $uid }} .hx-arrow { position: absolute; top: calc(var(--sz) / 2 + 8px); z-index: 3; width: 40px; height: 40px; display: grid; place-items: center; border-radius: 50%; cursor: pointer; color: var(--pill-fg);
        background: var(--pill-bg); border: 1px solid var(--pill-bd); -webkit-backdrop-filter: blur(14px) saturate(160%); backdrop-filter: blur(14px) saturate(160%); box-shadow: 0 8px 24px -8px rgba(2,6,23,.5); transition: transform .2s, background .2s; }
    #{{ $uid }} .hx-arrow:hover { transform: scale(1.1); background: var(--acc); color: #fff; }
    #{{ $uid }} .hx-arrow.l { left: 4px; }
    #{{ $uid }} .hx-arrow.r { right: 4px; }

    /* Element */
    #{{ $uid }} .hx-item { flex: 0 0 auto; display: flex; flex-direction: column; align-items: center; gap: 10px; width: calc(var(--sz) * .9 + 8px); padding: 0; margin: 0; border: 0; background: none; font: inherit; color: inherit; cursor: pointer; scroll-snap-align: center; -webkit-tap-highlight-color: transparent; outline: none; }
    #{{ $uid }} .hx-hex { position: relative; display: block; width: var(--sz); height: var(--sz); margin: 0 calc(var(--sz) * -.05); filter: drop-shadow(0 8px 12px rgba(2,6,23,.28));
        transition: transform .5s cubic-bezier(.34,1.56,.64,1), filter .3s; }
    #{{ $uid }} .hx-item:hover .hx-hex, #{{ $uid }} .hx-item:focus-visible .hx-hex { transform: translateY(-6px) scale(1.1); filter: drop-shadow(0 16px 22px color-mix(in srgb, var(--acc) 55%, rgba(2,6,23,.5))); }
    #{{ $uid }} .hx-item:active .hx-hex { transform: scale(.95); transition-duration: .15s; }

    #{{ $uid }} .hx-wave, #{{ $uid }} .hx-ring, #{{ $uid }} .hx-gap, #{{ $uid }} .hx-img { position: absolute; display: block; clip-path: var(--hex); -webkit-clip-path: var(--hex); }
    #{{ $uid }} .hx-wave { inset: 0; background: var(--acc); opacity: 0; pointer-events: none; }
    #{{ $uid }} .hx-item:hover .hx-wave, #{{ $uid }} .hx-item:focus-visible .hx-wave { animation: hx-wave 1.3s ease-out infinite; }
    #{{ $uid }} .hx-ring { inset: 0; overflow: hidden; }
    #{{ $uid }} .hx-ring::before { content: ''; position: absolute; inset: -35%; background: conic-gradient(from 0deg, var(--acc), #ec4899, #f59e0b, #22d3ee, var(--acc)); animation: hx-spin 7s linear infinite; }
    #{{ $uid }} .hx-item:hover .hx-ring::before, #{{ $uid }} .hx-item:focus-visible .hx-ring::before { animation-duration: 1.8s; }
    #{{ $uid }} .hx-item.seen .hx-ring::before { background: rgba(148,163,184,.65); animation: none; }
    #{{ $uid }} .hx-gap { inset: 4px; background: var(--gapc); }
    #{{ $uid }} .hx-img { inset: 8px; overflow: hidden; background: #1e293b; }
    #{{ $uid }} .hx-img img, #{{ $uid }} .hx-img video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s cubic-bezier(.2,.8,.2,1), opacity .4s; }
    #{{ $uid }} .hx-item:hover .hx-img img, #{{ $uid }} .hx-item:hover .hx-img video { transform: scale(1.14); }
    #{{ $uid }} .hx-pv { opacity: 0; pointer-events: none; }
    #{{ $uid }} .hx-pv.hx-self { opacity: 1; }
    #{{ $uid }} .hx-item.pv-on .hx-pv { opacity: 1; }
    #{{ $uid }} .hx-play { position: absolute; left: 50%; top: 50%; width: 34%; aspect-ratio: 1; transform: translate(-50%,-50%) scale(.6); display: grid; place-items: center; border-radius: 50%; color: #fff; opacity: 0; z-index: 2;
        background: rgba(15,23,42,.35); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,.5); transition: opacity .3s, transform .4s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .hx-play svg { width: 46%; height: 46%; margin-left: 8%; }
    #{{ $uid }} .hx-item:hover .hx-play, #{{ $uid }} .hx-item:focus-visible .hx-play { opacity: 1; transform: translate(-50%,-50%) scale(1); }
    #{{ $uid }} .hx-item.pv-on .hx-play { opacity: 0; }

    #{{ $uid }} .hx-title { display: block; max-width: 100%; padding: 4px 10px; border-radius: 999px; font-size: .76rem; font-weight: 700; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--pill-fg);
        background: var(--pill-bg); border: 1px solid var(--pill-bd); -webkit-backdrop-filter: blur(12px) saturate(160%); backdrop-filter: blur(12px) saturate(160%); transition: transform .3s, background .3s, color .3s; }
    #{{ $uid }} .hx-item:hover .hx-title, #{{ $uid }} .hx-item:focus-visible .hx-title { transform: translateY(-3px); background: var(--acc); color: #fff; border-color: transparent; }

    #{{ $uid }}[data-anim="1"] .hx-item { animation: hx-pop .65s cubic-bezier(.34,1.56,.64,1) both; animation-delay: calc(var(--i) * 70ms); }
    @keyframes hx-pop { from { opacity: 0; transform: translateY(18px) scale(.7); } to { opacity: 1; transform: none; } }
    @keyframes hx-spin { to { transform: rotate(360deg); } }
    @keyframes hx-wave { 0% { transform: scale(1); opacity: .5; } 100% { transform: scale(1.5); opacity: 0; } }
    #{{ $uid }}[data-anim="0"] *, #{{ $uid }}[data-anim="0"] *::before { animation: none !important; }
    @media (prefers-reduced-motion: reduce) { #{{ $uid }} *, #{{ $uid }} *::before { animation: none !important; transition: none !important; } }

    @media (max-width: 900px) { #{{ $uid }} { --sz: calc(var(--sz0) * .94); } }
    @media (max-width: 600px) {
        #{{ $uid }} { --sz: calc(var(--sz0) * .84); }
        #{{ $uid }} .hx-track { gap: 10px; padding-inline: 12px; scroll-padding: 0 12px; }
        #{{ $uid }} .hx-title { font-size: .7rem; padding: 3px 8px; }
    }
    @media (hover: none) { #{{ $uid }} .hx-arrow { display: none; } }

    /* ===== Tam ekran story görüntüləyici (body-yə köçürülür) ===== */
    .hxv { --acc: #8b5cf6; position: fixed; inset: 0; z-index: 2147483000; display: flex; align-items: center; justify-content: center; gap: 22px; color: #fff; opacity: 0; visibility: hidden; transition: opacity .3s, visibility .3s; -webkit-tap-highlight-color: transparent; overscroll-behavior: contain; }
    .hxv *, .hxv *::before, .hxv *::after { box-sizing: border-box; }
    .hxv[hidden] { display: none; }
    .hxv.is-open { opacity: 1; visibility: visible; }
    .hxv-bg { position: absolute; inset: -60px; background: #0b1020 center / cover no-repeat; filter: blur(50px) saturate(1.7) brightness(.5); transform: scale(1.1); transition: background-image .5s; }
    .hxv-frame { position: relative; height: min(92vh, 900px); height: min(92dvh, 900px); aspect-ratio: 9 / 16; max-width: 100%; border-radius: 28px; overflow: hidden; background: #000; box-shadow: 0 34px 90px rgba(0,0,0,.65), 0 0 0 1px rgba(255,255,255,.16); transform: scale(.9) translateY(20px); transition: transform .45s cubic-bezier(.2,.9,.3,1.15); }
    .hxv.is-open .hxv-frame { transform: none; }
    .hxv-media, .hxv-zone { position: absolute; inset: 0; }
    .hxv-media video, .hxv-media img { width: 100%; height: 100%; object-fit: cover; display: block; animation: hxv-in .45s ease both; }
    .hxv-media .contain { object-fit: contain; }
    @keyframes hxv-in { from { opacity: 0; transform: scale(1.04); } to { opacity: 1; transform: none; } }
    .hxv-zone { z-index: 1; touch-action: none; cursor: pointer; user-select: none; -webkit-user-select: none; }
    .hxv-top { position: absolute; z-index: 2; left: 0; right: 0; top: 0; padding: calc(12px + env(safe-area-inset-top, 0px)) 12px 40px; pointer-events: none; background: linear-gradient(rgba(0,0,0,.6), transparent); }
    .hxv-bars { display: flex; gap: 4px; }
    .hxv-bars i { flex: 1; height: 3px; border-radius: 3px; background: rgba(255,255,255,.32); overflow: hidden; }
    .hxv-bars b { display: block; height: 100%; background: #fff; transform-origin: 0 50%; transform: scaleX(0); }
    .hxv-head { display: flex; align-items: center; gap: 10px; margin-top: 12px; }
    .hxv-av { position: relative; width: 40px; height: 40px; flex: none; display: grid; place-items: center; clip-path: var(--hexclip); -webkit-clip-path: var(--hexclip); background: linear-gradient(135deg, var(--acc), #ec4899); font-weight: 800; }
    .hxv-av img { position: absolute; inset: 3px; width: calc(100% - 6px); height: calc(100% - 6px); object-fit: cover; clip-path: var(--hexclip); -webkit-clip-path: var(--hexclip); }
    .hxv-name { min-width: 0; font-weight: 700; font-size: .95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-shadow: 0 1px 6px rgba(0,0,0,.6); }
    .hxv-sp { flex: 1; }
    .hxv-btn, .hxv-nav { display: grid; place-items: center; flex: none; border-radius: 50%; color: #fff; cursor: pointer; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.3);
        -webkit-backdrop-filter: blur(14px) saturate(160%); backdrop-filter: blur(14px) saturate(160%); transition: background .2s, transform .2s; }
    .hxv-btn { pointer-events: auto; width: 38px; height: 38px; padding: 0; }
    .hxv-btn:hover, .hxv-nav:hover { background: var(--acc); transform: scale(1.08); }
    .hxv-nav { position: relative; z-index: 1; width: 48px; height: 48px; padding: 0; }
    .hxv-nav:disabled { opacity: .3; cursor: default; transform: none; background: rgba(255,255,255,.16); }
    .hxv-bottom { position: absolute; z-index: 2; left: 0; right: 0; bottom: 0; padding: 70px 18px calc(22px + env(safe-area-inset-bottom, 0px)); pointer-events: none; background: linear-gradient(transparent, rgba(0,0,0,.75)); }
    .hxv-cap { margin: 0 0 14px; font-size: 1rem; line-height: 1.4; font-weight: 600; text-shadow: 0 1px 8px rgba(0,0,0,.6); animation: hxv-up .5s ease both; }
    .hxv-cap:empty { display: none; }
    @keyframes hxv-up { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    .hxv-cta { pointer-events: auto; display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; border-radius: 999px; font-size: .9rem; font-weight: 700; text-decoration: none; color: #fff;
        background: linear-gradient(135deg, var(--acc), color-mix(in srgb, var(--acc) 50%, #ec4899)); box-shadow: 0 12px 28px -10px var(--acc); transition: transform .2s, filter .2s; }
    .hxv-cta:hover { transform: translateY(-2px); filter: brightness(1.1); }
    .hxv.is-paused .hxv-bars b { opacity: .6; }

    @media (max-width: 900px) { .hxv-nav { display: none; } .hxv { gap: 0; } }
    @media (max-width: 640px) {
        .hxv-frame { width: 100%; height: 100%; aspect-ratio: auto; border-radius: 0; box-shadow: none; }
        .hxv-bg { display: none; }
        .hxv { background: #000; }
    }
    @media (prefers-reduced-motion: reduce) { .hxv *, .hxv { animation: none !important; transition: none !important; } }
</style>

<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <defs>
        <clipPath id="{{ $uid }}-hex" clipPathUnits="objectBoundingBox"><path d="{{ $o['hex'] }}"/></clipPath>
    </defs>
</svg>

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-align="{{ $o['align'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}">
    <div class="hx-wrap">
        @if ($o['arrows'])
            <button type="button" class="hx-arrow l" data-dir="-1" hidden aria-label="{{ $labels['scroll_l'] }}"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg></button>
            <button type="button" class="hx-arrow r" data-dir="1" hidden aria-label="{{ $labels['scroll_r'] }}"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg></button>
        @endif

        <div class="hx-track" role="list">
            @foreach ($items as $i => $it)
                <button type="button" class="hx-item" role="listitem" data-i="{{ $i }}" style="--i: {{ $i }}" aria-label="{{ $it['title'] !== '' ? $it['title'] : $labels['story'] . ' ' . ($i + 1) }}">
                    <span class="hx-hex">
                        <span class="hx-wave"></span>
                        <span class="hx-ring"></span>
                        <span class="hx-gap"></span>
                        <span class="hx-img">
                            @if ($it['cover'] !== '')
                                <img src="{{ $it['cover'] }}" alt="" loading="lazy" decoding="async" draggable="false">
                                @if ($it['video'] !== '')
                                    <video class="hx-pv" data-src="{{ $it['video'] }}" muted loop playsinline preload="none" tabindex="-1" aria-hidden="true"></video>
                                @endif
                            @else
                                <video class="hx-pv hx-self" src="{{ $it['video'] }}#t=0.5" data-src="{{ $it['video'] }}#t=0.5" muted loop playsinline preload="metadata" tabindex="-1" aria-hidden="true"></video>
                            @endif
                            @if ($it['video'] !== '')
                                <span class="hx-play" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 4.5v15l13-7.5z"/></svg></span>
                            @endif
                        </span>
                    </span>
                    @if ($o['titles'] && $it['title'] !== '')
                        <span class="hx-title">{{ $it['title'] }}</span>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

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
    if (!D || !D.items || !D.items.length) { return; }

    var items = D.items, L = D.labels;
    var track = root.querySelector('.hx-track');
    var btns = [].slice.call(root.querySelectorAll('.hx-item'));
    var arL = root.querySelector('.hx-arrow.l'), arR = root.querySelector('.hx-arrow.r');
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canHover = window.matchMedia && matchMedia('(hover: hover)').matches && !reduce;

    function mk(tag, cls) { var n = document.createElement(tag); if (cls) { n.className = cls; } return n; }

    /* ---------- Baxılmış story-lər ---------- */
    var KEY = 'hx_seen_' + D.sig, seen = {};
    try { seen = JSON.parse(localStorage.getItem(KEY) || '{}') || {}; } catch (e) { seen = {}; }
    function paintSeen() { btns.forEach(function (b, i) { b.classList.toggle('seen', !!seen[i]); }); }
    function markSeen(i) {
        if (seen[i]) { return; }
        seen[i] = 1;
        try { localStorage.setItem(KEY, JSON.stringify(seen)); } catch (e) {}
        paintSeen();
    }
    paintSeen();

    /* ---------- Zolaq: oxlar və kənar solması ---------- */
    function upd() {
        var max = track.scrollWidth - track.clientWidth;
        var over = max > 2, l = over && track.scrollLeft > 4, r = over && track.scrollLeft < max - 4;
        track.classList.toggle('fade-l', l);
        track.classList.toggle('fade-r', r);
        if (arL) { arL.hidden = !l; }
        if (arR) { arR.hidden = !r; }
    }
    [arL, arR].forEach(function (a) {
        if (!a) { return; }
        a.addEventListener('click', function () {
            track.scrollBy({ left: (+a.dataset.dir) * track.clientWidth * 0.8, behavior: reduce ? 'auto' : 'smooth' });
        });
    });
    track.addEventListener('scroll', upd, { passive: true });
    window.addEventListener('resize', upd);
    if (window.ResizeObserver) { new ResizeObserver(upd).observe(track); }
    window.addEventListener('load', upd);
    upd();

    /* ---------- Hover önizləmə (səssiz video) ---------- */
    if (canHover) {
        btns.forEach(function (b) {
            var pv = b.querySelector('.hx-pv');
            if (!pv) { return; }
            pv.addEventListener('playing', function () { b.classList.add('pv-on'); });
            b.addEventListener('mouseenter', function () {
                if (!pv.getAttribute('src')) { pv.src = pv.dataset.src; }
                var p = pv.play(); if (p && p.catch) { p.catch(function () {}); }
            });
            b.addEventListener('mouseleave', function () {
                pv.pause(); b.classList.remove('pv-on');
                try { pv.currentTime = 0; } catch (e) {}
            });
        });
    }

    /* ---------- Tam ekran görüntüləyici ---------- */
    var ICON = {
        close: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>',
        on: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 9v6h4l5 4V5L8 9H4z" fill="currentColor" stroke="none"/><path d="M16.5 8.5a5 5 0 010 7M19 6a8.5 8.5 0 010 12"/></svg>',
        off: '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 9v6h4l5 4V5L8 9H4z" fill="currentColor" stroke="none"/><path d="M17 9l5 6M22 9l-5 6"/></svg>',
        prev: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg>',
        next: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg>'
    };

    var V = null, el = {}, S = { cur: -1, muted: !!D.muted, paused: false, elapsed: 0, last: 0, raf: 0, vid: null, opener: null, overflow: '' };

    function build() {
        V = mk('div', 'hxv');
        V.setAttribute('role', 'dialog');
        V.setAttribute('aria-modal', 'true');
        V.setAttribute('aria-label', L.story);
        V.style.setProperty('--acc', D.accent);
        V.style.setProperty('--hexclip', 'url(#' + UID + '-hex)');
        V.innerHTML =
            '<div class="hxv-bg"></div>' +
            '<button type="button" class="hxv-nav" data-a="prev">' + ICON.prev + '</button>' +
            '<div class="hxv-frame">' +
                '<div class="hxv-media"></div><div class="hxv-zone"></div>' +
                '<div class="hxv-top"><div class="hxv-bars"></div>' +
                    '<div class="hxv-head"><span class="hxv-av"></span><span class="hxv-name"></span><span class="hxv-sp"></span>' +
                    '<button type="button" class="hxv-btn" data-a="mute"></button>' +
                    '<button type="button" class="hxv-btn" data-a="close">' + ICON.close + '</button></div></div>' +
                '<div class="hxv-bottom"><p class="hxv-cap"></p><a class="hxv-cta" hidden></a></div>' +
            '</div>' +
            '<button type="button" class="hxv-nav" data-a="next">' + ICON.next + '</button>';

        function q(s) { return V.querySelector(s); }
        el = { bg: q('.hxv-bg'), media: q('.hxv-media'), zone: q('.hxv-zone'), bars: q('.hxv-bars'), av: q('.hxv-av'), name: q('.hxv-name'),
               cap: q('.hxv-cap'), cta: q('.hxv-cta'), mute: q('[data-a="mute"]'), close: q('[data-a="close"]'),
               prev: q('[data-a="prev"]'), next: q('[data-a="next"]') };

        el.close.setAttribute('aria-label', L.close);
        el.prev.setAttribute('aria-label', L.prev);
        el.next.setAttribute('aria-label', L.next);

        items.forEach(function () { var i = mk('i'); i.appendChild(mk('b')); el.bars.appendChild(i); });

        el.close.addEventListener('click', close);
        el.prev.addEventListener('click', prev);
        el.next.addEventListener('click', next);
        el.mute.addEventListener('click', function () {
            S.muted = !S.muted;
            if (S.vid) { S.vid.muted = S.muted; }
            paintMute();
        });
        if (D.blank) { el.cta.target = '_blank'; el.cta.rel = 'noopener noreferrer nofollow'; }

        /* Toxunuş: sol 1/3 = geri, qalanı = irəli, basılı saxla = pauza, yana sürüşdür = keçid, aşağı = bağla */
        var st = null, zone = el.zone;
        zone.addEventListener('pointerdown', function (e) {
            st = { x: e.clientX, y: e.clientY, held: false };
            if (zone.setPointerCapture) { try { zone.setPointerCapture(e.pointerId); } catch (x) {} }
            st.timer = setTimeout(function () { if (st) { st.held = true; setPaused(true); } }, 220);
        });
        function end(e, cancel) {
            if (!st) { return; }
            clearTimeout(st.timer);
            var s = st; st = null;
            if (s.held) { setPaused(false); }
            if (cancel) { return; }
            var dx = e.clientX - s.x, dy = e.clientY - s.y, ax = Math.abs(dx), ay = Math.abs(dy);
            if (ax > 50 && ax > ay) { if (dx < 0) { next(); } else { prev(); } }
            else if (dy > 90 && ay > ax) { close(); }
            else if (!s.held && ax < 12 && ay < 12) {
                var r = zone.getBoundingClientRect();
                if (e.clientX - r.left < r.width * 0.33) { prev(); } else { next(); }
            }
        }
        zone.addEventListener('pointerup', function (e) { end(e, false); });
        zone.addEventListener('pointercancel', function (e) { end(e, true); });
        zone.addEventListener('contextmenu', function (e) { e.preventDefault(); });
    }

    function paintMute() {
        el.mute.innerHTML = S.muted ? ICON.off : ICON.on;
        el.mute.setAttribute('aria-label', S.muted ? L.unmute : L.mute);
    }

    function playVid(v) {
        var p = v.play();
        if (p && p.catch) {
            p.catch(function () {
                if (!v.muted) {
                    v.muted = true; S.muted = true; paintMute();
                    var p2 = v.play(); if (p2 && p2.catch) { p2.catch(function () {}); }
                }
            });
        }
    }

    function setPaused(b) {
        S.paused = b;
        V.classList.toggle('is-paused', b);
        if (S.vid) { if (b) { S.vid.pause(); } else { playVid(S.vid); } }
    }

    function stopLoop() { if (S.raf) { cancelAnimationFrame(S.raf); S.raf = 0; } }

    function paint(p) {
        var b = el.bars.children[S.cur];
        if (b) { b.firstChild.style.transform = 'scaleX(' + Math.max(0, Math.min(1, p)) + ')'; }
    }

    function loop(ts) {
        var dt = S.last ? ts - S.last : 0;
        S.last = ts;
        var p = 0;
        if (S.vid) {
            var d = S.vid.duration;
            p = d && isFinite(d) ? S.vid.currentTime / d : 0;
        } else {
            if (!S.paused) { S.elapsed += dt; }
            p = S.elapsed / D.dur;
            if (p >= 1) { paint(1); next(); return; }
        }
        paint(p);
        S.raf = requestAnimationFrame(loop);
    }

    function show(i) {
        stopLoop();
        var it = items[i];
        S.cur = i; S.elapsed = 0; S.last = 0; S.paused = false; S.vid = null;
        V.classList.remove('is-paused');

        el.media.textContent = '';
        el.bg.style.backgroundImage = it.cover ? 'url("' + it.cover.replace(/"/g, '%22') + '")' : '';

        [].forEach.call(el.bars.children, function (bar, j) {
            bar.firstChild.style.transform = 'scaleX(' + (j < i ? 1 : 0) + ')';
        });

        function showImage() {
            if (!it.cover) { return; }
            var im = mk('img'); im.src = it.cover; im.alt = ''; im.draggable = false;
            el.media.appendChild(im);
        }

        if (it.video) {
            var v = mk('video');
            v.setAttribute('playsinline', ''); v.playsInline = true;
            v.muted = S.muted; v.preload = 'auto';
            if (it.cover) { v.poster = it.cover; }
            v.src = it.video;
            v.addEventListener('loadedmetadata', function () { if (v.videoWidth > v.videoHeight * 1.1) { v.classList.add('contain'); } });
            v.addEventListener('ended', function () { if (S.vid === v) { next(); } });
            v.addEventListener('error', function () {
                if (S.vid !== v) { return; }
                S.vid = null; S.elapsed = 0; S.last = 0;
                el.media.textContent = '';
                showImage();
            });
            el.media.appendChild(v);
            S.vid = v;
            playVid(v);
        } else {
            showImage();
        }

        el.name.textContent = it.title || (L.story + ' ' + (i + 1));
        el.av.textContent = '';
        if (it.cover) {
            var a = mk('img'); a.src = it.cover; a.alt = ''; el.av.appendChild(a);
        } else {
            el.av.textContent = (it.title || 'S').charAt(0).toUpperCase();
        }

        el.cap.textContent = it.caption || '';
        el.cap.style.animation = 'none'; void el.cap.offsetWidth; el.cap.style.animation = '';

        if (it.url && D.cta) {
            el.cta.hidden = false; el.cta.href = it.url; el.cta.textContent = D.cta;
        } else {
            el.cta.hidden = true;
        }

        el.mute.hidden = !it.video;
        paintMute();
        el.prev.disabled = i === 0;
        el.next.disabled = i === items.length - 1;

        markSeen(i);
        S.raf = requestAnimationFrame(loop);
    }

    function next() { if (S.cur < items.length - 1) { show(S.cur + 1); } else { close(); } }
    function prev() { show(S.cur > 0 ? S.cur - 1 : 0); }

    function onKey(e) {
        if (e.key === 'Escape') { close(); }
        else if (e.key === 'ArrowRight') { next(); }
        else if (e.key === 'ArrowLeft') { prev(); }
        else if (e.key === 'Tab') {
            var f = [].slice.call(V.querySelectorAll('button:not([hidden]):not(:disabled), a[href]:not([hidden])'));
            if (!f.length) { return; }
            var first = f[0], last = f[f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    }
    function onVis() { if (V && V.classList.contains('is-open')) { setPaused(document.hidden); } }

    function open(i, opener) {
        if (!V) { build(); document.body.appendChild(V); }
        S.opener = opener;
        S.overflow = document.documentElement.style.overflow;
        document.documentElement.style.overflow = 'hidden';
        document.addEventListener('keydown', onKey);
        document.addEventListener('visibilitychange', onVis);
        show(i);
        requestAnimationFrame(function () { V.classList.add('is-open'); el.close.focus(); });
    }

    function close() {
        if (!V || !V.classList.contains('is-open')) { return; }
        stopLoop();
        if (S.vid) { S.vid.pause(); S.vid = null; }
        V.classList.remove('is-open');
        setTimeout(function () { if (!V.classList.contains('is-open')) { el.media.textContent = ''; } }, 320);
        document.documentElement.style.overflow = S.overflow;
        document.removeEventListener('keydown', onKey);
        document.removeEventListener('visibilitychange', onVis);
        if (S.opener && S.opener.focus) { S.opener.focus(); }
    }

    btns.forEach(function (b, i) { b.addEventListener('click', function () { open(i, b); }); });
})();
</script>
