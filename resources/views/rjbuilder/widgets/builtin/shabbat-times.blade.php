<style>
    @property --sky1 { syntax: '<color>'; inherits: true; initial-value: #0284c7; }
    @property --sky2 { syntax: '<color>'; inherits: true; initial-value: #7dd3fc; }

    #{{ $uid }} { --acc: {{ $o['accent'] }}; width: 100%; padding: 24px 12px; box-sizing: border-box; transition: --sky1 2s ease, --sky2 2s ease;
        --sky1:#0284c7; --sky2:#7dd3fc; --cloth:#f8fafc; --gr:#3f9b6e; --flameO:0; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* Vaxta görə səma: gün, gecə, şabbat */
    #{{ $uid }}[data-phase="day"]     { --sky1:#0284c7; --sky2:#7dd3fc; --cloth:#f8fafc; --gr:#3f9b6e; --flameO:0; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; }
    #{{ $uid }}[data-phase="night"]   { --sky1:#070b1f; --sky2:#2b2766; --cloth:#cbd5e1; --gr:#070b18; --flameO:0; --starO:1; --moonO:1; --sunO:0; --sunY:240px; --cloudO:.12; }
    #{{ $uid }}[data-phase="shabbat"] { --sky1:#1e1b4b; --sky2:#b45309; --cloth:#fef3c7; --gr:#1c1208; --flameO:1; --starO:.6; --moonO:.8; --sunO:0; --sunY:240px; --cloudO:.25; }

    /* Kart */
    #{{ $uid }} .rjsb-card { position: relative; isolation: isolate; display: grid; grid-template-columns: 5fr 6fr; max-width: 980px; margin: 0 auto; border-radius: 26px; overflow: hidden; border: 1px solid rgba(255,255,255,.25); background: linear-gradient(180deg, var(--sky1), var(--sky2)); box-shadow: 0 24px 60px -24px rgba(2,6,23,.55); }
    #{{ $uid }} .rjsb-card.no-scene { grid-template-columns: 1fr; max-width: 520px; }
    #{{ $uid }}[data-side="right"] .rjsb-scene { order: 2; }

    #{{ $uid }} .rjsb-card::before,
    #{{ $uid }} .rjsb-card::after { content: ''; position: absolute; z-index: 0; border-radius: 50%; filter: blur(55px); pointer-events: none; animation: rjsb-float 16s ease-in-out infinite alternate; }
    #{{ $uid }} .rjsb-card::before { width: 280px; height: 280px; right: -70px; top: -70px; background: var(--acc); opacity: .45; }
    #{{ $uid }} .rjsb-card::after { width: 240px; height: 240px; left: 30%; bottom: -90px; background: #ec4899; opacity: .28; animation-duration: 20s; animation-direction: alternate-reverse; }

    /* Səhnə */
    #{{ $uid }} .rjsb-scene { position: relative; z-index: 1; min-height: 430px; overflow: hidden; }
    #{{ $uid }} .rjsb-svg { position: absolute; inset: 0; width: 100%; height: 100%; display: block; overflow: visible; }
    #{{ $uid }} .rjsb-g1 { stop-color: #fbbf24; stop-opacity: .6; }
    #{{ $uid }} .rjsb-g2 { stop-color: #fbbf24; stop-opacity: 0; }
    #{{ $uid }} .rjsb-gr { fill: var(--gr); transition: fill 2s; }
    #{{ $uid }} .rjsb-cloth { fill: var(--cloth); transition: fill 2s; }
    #{{ $uid }} .rjsb-sun { opacity: var(--sunO); transform: translateY(var(--sunY)); transition: transform 2.5s ease, opacity 2s ease; }
    #{{ $uid }} .rjsb-moon { opacity: var(--moonO); transition: opacity 2s ease; }
    #{{ $uid }} .rjsb-stars { opacity: var(--starO); transition: opacity 2s ease; }
    #{{ $uid }} .rjsb-clouds { opacity: var(--cloudO); transition: opacity 2s ease; }
    #{{ $uid }} .rjsb-star { fill: #fff; animation: rjsb-twinkle 3s ease-in-out infinite; }
    #{{ $uid }} .rjsb-cloud { fill: #fff; animation: rjsb-drift 75s linear infinite; }
    #{{ $uid }} .rjsb-cloud.c2 { animation-duration: 110s; animation-delay: -45s; }
    #{{ $uid }} .rjsb-sunhalo { transform-box: fill-box; transform-origin: center; animation: rjsb-pulse 6s ease-in-out infinite; }

    /* Şamlar yalnız şabbat vaxtı yanır */
    #{{ $uid }} .rjsb-flame { opacity: var(--flameO); transition: opacity 1.4s ease; transform-box: fill-box; transform-origin: 50% 100%; animation: rjsb-flick 1.6s ease-in-out infinite alternate; }
    #{{ $uid }} .rjsb-flame.f2 { animation-duration: 1.9s; animation-delay: -.7s; }
    #{{ $uid }} .rjsb-halo { opacity: var(--flameO); transition: opacity 1.4s ease; transform-box: fill-box; transform-origin: center; animation: rjsb-pulse 3s ease-in-out infinite; }

    @keyframes rjsb-twinkle { 0%,100% { opacity: .2; } 50% { opacity: 1; } }
    @keyframes rjsb-drift { from { transform: translateX(-300px); } to { transform: translateX(700px); } }
    @keyframes rjsb-pulse { 0%,100% { transform: scale(.92); } 50% { transform: scale(1.1); } }
    @keyframes rjsb-flick { 0% { transform: scale(1,1) rotate(-1.5deg); } 50% { transform: scale(.94,1.07) rotate(1.5deg); } 100% { transform: scale(1.04,.96) rotate(-.5deg); } }
    @keyframes rjsb-float { from { transform: translate(0,0) scale(1); } to { transform: translate(-40px,50px) scale(1.2); } }

    #{{ $uid }}[data-anim="0"] .rjsb-scene *, #{{ $uid }}[data-anim="0"] .rjsb-card::before, #{{ $uid }}[data-anim="0"] .rjsb-card::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjsb-scene *, #{{ $uid }} .rjsb-card::before, #{{ $uid }} .rjsb-card::after { animation: none !important; }
    }

    /* Şüşə panel */
    #{{ $uid }} .rjsb-info { position: relative; z-index: 1; min-width: 0; margin: 14px 14px 14px 0; padding: 20px; border-radius: 20px; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,.25);
        background: linear-gradient(145deg, rgba(255,255,255,.18), rgba(255,255,255,.04)), rgba(15,23,42,.30);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.28); box-shadow: 0 12px 40px rgba(2,6,23,.3), inset 0 1px 0 rgba(255,255,255,.4); }
    #{{ $uid }}[data-style="glass-dark"] .rjsb-info { background: linear-gradient(145deg, rgba(255,255,255,.1), rgba(255,255,255,.02)), rgba(8,12,28,.55); border-color: rgba(255,255,255,.18); }
    #{{ $uid }}[data-side="right"] .rjsb-info { margin: 14px 0 14px 14px; }
    #{{ $uid }} .rjsb-card.no-scene .rjsb-info { margin: 14px; }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) {
        #{{ $uid }} .rjsb-info { background: rgba(15,23,42,.72); }
    }

    #{{ $uid }} .rjsb-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    #{{ $uid }} .rjsb-title { margin: 0; font-size: 1.15rem; font-weight: 800; color: #fff; }
    #{{ $uid }} .rjsb-place { display: flex; align-items: center; gap: 4px; margin-top: 3px; font-size: .82rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .rjsb-place svg { width: 13px; height: 13px; flex: none; }
    #{{ $uid }} .rjsb-clock { flex: none; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.25); font-size: .95rem; font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
    #{{ $uid }} .rjsb-dates { display: flex; flex-wrap: wrap; gap: 2px 12px; margin: 10px 0 14px; font-size: .8rem; color: rgba(255,255,255,.75); }

    /* Geri sayım */
    #{{ $uid }} .rjsb-next { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; margin-bottom: 12px; border-radius: 16px; color: #fff;
        background: linear-gradient(135deg, color-mix(in srgb, var(--acc) 90%, transparent), color-mix(in srgb, var(--acc) 50%, #7c3aed));
        border: 1px solid rgba(255,255,255,.35); box-shadow: 0 10px 28px -10px var(--acc), inset 0 1px 0 rgba(255,255,255,.35); }
    #{{ $uid }} .rjsb-next-txt { min-width: 0; }
    #{{ $uid }} .rjsb-next-lbl { font-size: .8rem; font-weight: 600; opacity: .92; }
    #{{ $uid }} .rjsb-count { margin-top: 2px; font-size: 1.9rem; font-weight: 800; letter-spacing: .02em; font-variant-numeric: tabular-nums; line-height: 1.2; }
    #{{ $uid }} .rjsb-ring { flex: none; width: 58px; height: 58px; }
    #{{ $uid }} .rjsb-ring .bg { fill: none; stroke: rgba(255,255,255,.28); stroke-width: 5; }
    #{{ $uid }} .rjsb-ring .fg { fill: none; stroke: #fff; stroke-width: 5; stroke-linecap: round; stroke-dasharray: 163.36; stroke-dashoffset: 163.36; transition: stroke-dashoffset 1s linear; }

    /* Siyahı */
    #{{ $uid }} .rjsb-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 5px; }
    #{{ $uid }} .rjsb-list li { display: grid; grid-template-columns: 10px 1fr auto; align-items: center; gap: 12px; padding: 9px 12px; border-radius: 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); font-size: .95rem; transition: background .3s, border-color .3s, transform .2s; }
    #{{ $uid }} .rjsb-list li[hidden] { display: none; }
    #{{ $uid }} .rjsb-list li:hover { transform: translateX(3px); background: rgba(255,255,255,.14); }
    #{{ $uid }} .rjsb-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.35); }
    #{{ $uid }} .rjsb-when { min-width: 0; display: flex; flex-direction: column; line-height: 1.25; }
    #{{ $uid }} .rjsb-when b { font-weight: 700; }
    #{{ $uid }} .rjsb-when small { font-size: .74rem; color: rgba(255,255,255,.75); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    #{{ $uid }} .rjsb-times { display: flex; gap: 14px; }
    #{{ $uid }} .rjsb-t { display: flex; flex-direction: column; align-items: flex-end; line-height: 1.25; }
    #{{ $uid }} .rjsb-t i { font-style: normal; font-size: .66rem; color: rgba(255,255,255,.7); }
    #{{ $uid }} .rjsb-t b { font-weight: 700; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rjsb-list li.is-next { background: color-mix(in srgb, var(--acc) 45%, transparent); border-color: rgba(255,255,255,.5); }
    #{{ $uid }} .rjsb-list li.is-next .rjsb-dot { background: #fff; box-shadow: 0 0 0 4px rgba(255,255,255,.28); }

    #{{ $uid }} .rjsb-error { max-width: 520px; margin: 0 auto; padding: 20px; text-align: center; border-radius: 16px; background: rgba(15,23,42,.88); color: #e2e8f0; font-size: .9rem; }

    /* Mobil */
    @media (max-width: 760px) {
        #{{ $uid }} { padding: 12px 8px; }
        #{{ $uid }} .rjsb-card { grid-template-columns: 1fr; border-radius: 22px; }
        #{{ $uid }}[data-side="right"] .rjsb-scene { order: 0; }
        #{{ $uid }} .rjsb-scene { min-height: 0; height: 270px; }
        #{{ $uid }} .rjsb-info,
        #{{ $uid }}[data-side="right"] .rjsb-info { margin: -34px 10px 10px; padding: 16px 14px 14px; }
        #{{ $uid }} .rjsb-card.no-scene .rjsb-info { margin: 10px; }
        #{{ $uid }} .rjsb-count { font-size: 1.65rem; }
        #{{ $uid }} .rjsb-ring { width: 50px; height: 50px; }
        #{{ $uid }} .rjsb-list li { grid-template-columns: 1fr auto; gap: 8px; padding: 9px 10px; }
        #{{ $uid }} .rjsb-list li:hover { transform: none; }
        #{{ $uid }} .rjsb-dot { display: none; }
        #{{ $uid }} .rjsb-times { gap: 10px; }
    }
</style>

@if ($error)
    <section id="{{ $uid }}" data-style="{{ $o['style'] }}"><div class="rjsb-error">{{ $error }}</div></section>
@else
@php
    $stars = [[24,30],[70,64],[118,24],[160,70],[210,36],[250,86],[300,28],[330,70],[48,110],[96,140],[236,130],[320,120],[190,100],[-30,60],[-60,120],[390,50],[420,110],[-10,20],[375,150]];
@endphp

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-side="{{ $o['side'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-phase="day">
    <div class="rjsb-card {{ $o['scene'] ? '' : 'no-scene' }}">

        @if ($o['scene'])
            <div class="rjsb-scene" aria-hidden="true">
                <svg class="rjsb-svg" viewBox="0 20 360 380" preserveAspectRatio="xMidYMax meet" focusable="false">
                    <defs>
                        <radialGradient id="{{ $uid }}-glow"><stop offset="0" class="rjsb-g1"/><stop offset="1" class="rjsb-g2"/></radialGradient>
                        <symbol id="{{ $uid }}-cres" viewBox="0 0 24 24">
                            <mask id="{{ $uid }}-cm"><rect width="24" height="24" fill="#fff"/><circle cx="15" cy="9.5" r="9" fill="#000"/></mask>
                            <circle cx="11" cy="12" r="10" fill="currentColor" mask="url(#{{ $uid }}-cm)"/>
                        </symbol>
                    </defs>

                    <g class="rjsb-stars">
                        @foreach ($stars as $i => $s)
                            <circle class="rjsb-star" cx="{{ $s[0] }}" cy="{{ $s[1] }}" r="{{ $i % 3 === 0 ? 1.8 : 1.2 }}" style="animation-delay: {{ number_format($i * 0.37, 2) }}s"/>
                        @endforeach
                    </g>

                    <g class="rjsb-moon"><use href="#{{ $uid }}-cres" x="262" y="40" width="54" height="54" style="color:#fef3c7"/></g>

                    <g class="rjsb-sun">
                        <circle class="rjsb-sunhalo" cx="86" cy="96" r="46" fill="#fde68a" opacity=".3"/>
                        <circle cx="86" cy="96" r="26" fill="#fde68a"/>
                    </g>

                    <g class="rjsb-clouds">
                        <g transform="translate(0,92)"><g class="rjsb-cloud"><ellipse cx="0" cy="0" rx="34" ry="11"/><ellipse cx="-18" cy="-6" rx="18" ry="10"/><ellipse cx="16" cy="-8" rx="20" ry="11"/></g></g>
                        <g transform="translate(0,150)"><g class="rjsb-cloud c2"><ellipse cx="0" cy="0" rx="28" ry="9"/><ellipse cx="-14" cy="-5" rx="15" ry="8"/><ellipse cx="14" cy="-6" rx="16" ry="9"/></g></g>
                    </g>

                    <rect class="rjsb-gr" x="-900" y="330" width="2160" height="220"/>

                    {{-- Süfrə --}}
                    <rect class="rjsb-cloth" x="30" y="296" width="300" height="120" rx="8"/>
                    <rect x="30" y="296" width="300" height="4" rx="2" fill="#000" opacity=".12"/>

                    {{-- Xallah çörəyi --}}
                    <ellipse cx="180" cy="284" rx="52" ry="14" fill="#d97706"/>
                    <ellipse cx="180" cy="279" rx="42" ry="6" fill="#fbbf24" opacity=".35"/>
                    @foreach (range(-3, 3) as $k)
                        <path d="M{{ 180 + $k * 14 - 5 }} 275 q5 9 10 18" stroke="#92400e" stroke-width="2" fill="none" stroke-linecap="round" opacity=".6"/>
                    @endforeach

                    {{-- İki şam --}}
                    @foreach ([110, 250] as $n => $cx)
                        <g transform="translate({{ $cx }},0)">
                            <circle class="rjsb-halo" cx="0" cy="190" r="62" fill="url(#{{ $uid }}-glow)"/>
                            <path d="M-14 296 h28 l-5 -10 h-18z" fill="#d4a017"/>
                            <rect x="-2.500" y="262" width="5" height="24" fill="#d4a017"/>
                            <path d="M-9 256 h18 l-3 8 h-12z" fill="#d4a017"/>
                            <rect x="-4" y="206" width="8" height="52" rx="1.500" fill="#fef3c7" stroke="#e7d9a8" stroke-width=".6"/>
                            <line x1="0" y1="206" x2="0" y2="201" stroke="#3f2a14" stroke-width="1.200"/>
                            <g class="rjsb-flame {{ $n === 1 ? 'f2' : '' }}">
                                <path d="M0 176 C6 186 6 198 0 202 C-6 198 -6 186 0 176Z" fill="#fbbf24"/>
                                <path d="M0 187 C3 192 3 198 0 201 C-3 198 -3 192 0 187Z" fill="#fff7ed"/>
                            </g>
                        </g>
                    @endforeach
                </svg>
            </div>
        @endif

        <div class="rjsb-info">
            <div class="rjsb-head">
                <div>
                    @if ($o['title'] !== '')<h4 class="rjsb-title">{{ $o['title'] }}</h4>@endif
                    <div class="rjsb-place">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <span>{{ $o['place'] }}</span>
                    </div>
                </div>
                <div class="rjsb-clock" data-el="clock">--:--</div>
            </div>

            <div class="rjsb-dates"><span data-el="greg"></span><span data-el="hebrew"></span></div>

            @if ($o['countdown'])
                <div class="rjsb-next">
                    <div class="rjsb-next-txt">
                        <div class="rjsb-next-lbl" data-el="nextlbl">&nbsp;</div>
                        <div class="rjsb-count" data-el="count" role="timer" aria-live="off">--:--:--</div>
                    </div>
                    <svg class="rjsb-ring" viewBox="0 0 64 64" aria-hidden="true">
                        <circle class="bg" cx="32" cy="32" r="26"/>
                        <circle class="fg" data-el="ring" cx="32" cy="32" r="26" transform="rotate(-90 32 32)"/>
                    </svg>
                </div>
            @endif

            <ul class="rjsb-list" data-el="list"></ul>
        </div>
    </div>

    <script type="application/json" id="{{ $uid }}-data">{!! json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var D;
    try { D = JSON.parse(document.getElementById('{{ $uid }}-data').textContent); } catch (e) { return; }
    if (!D || !D.items || !D.items.length) { return; }

    var tz = D.tz;
    try { new Intl.DateTimeFormat('en', { timeZone: tz }); } catch (e) { tz = 'UTC'; }

    var L = D.labels, items = D.items;
    var lang = document.documentElement.lang || navigator.language || 'en';
    var WEEK = 7 * 86400000;
    var RING = 163.36;

    function el(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var elClock = el('clock'), elGreg = el('greg'), elHebrew = el('hebrew');
    var elCount = el('count'), elLbl = el('nextlbl'), elRing = el('ring'), elList = el('list');

    var dtf = new Intl.DateTimeFormat('en-US', {
        timeZone: tz, hourCycle: 'h23', year: 'numeric', month: '2-digit', day: '2-digit',
        hour: '2-digit', minute: '2-digit', second: '2-digit'
    });
    var tf = new Intl.DateTimeFormat('en-US', {
        timeZone: tz, hour: D.fmt === '12' ? 'numeric' : '2-digit', minute: '2-digit', hourCycle: D.fmt === '12' ? 'h12' : 'h23'
    });

    function pad(n) { return (n < 10 ? '0' : '') + n; }

    function parts(ms) {
        var o = {};
        dtf.formatToParts(new Date(ms)).forEach(function (p) { if (p.type !== 'literal') { o[p.type] = p.value; } });
        return o;
    }

    function fmtT(ms) {
        return ms == null ? '—' : tf.format(new Date(ms));
    }

    function fmtHMS(p) {
        var h = (+p.hour) % 24;
        if (D.fmt !== '12') { return pad(h) + ':' + p.minute + ':' + p.second; }
        return (h % 12 || 12) + ':' + p.minute + ':' + p.second + ' ' + (h < 12 ? 'AM' : 'PM');
    }

    function hms(ms) {
        var s = Math.max(0, Math.floor(ms / 1000));
        var d = Math.floor(s / 86400);
        var r = s % 86400;
        var t = pad(Math.floor(r / 3600)) + ':' + pad(Math.floor((r % 3600) / 60)) + ':' + pad(r % 60);
        return d > 0 ? d + 'd ' + t : t;
    }

    function fmtDate(k) {
        var a = k.split('-');
        try {
            return new Intl.DateTimeFormat(lang, { timeZone: 'UTC', day: 'numeric', month: 'long' }).format(new Date(Date.UTC(+a[0], +a[1] - 1, +a[2], 12)));
        } catch (e) { return k; }
    }

    // Siyahını bir dəfə qururuq (textContent ilə, təhlükəsiz)
    function mk(tag, cls, txt) {
        var n = document.createElement(tag);
        if (cls) { n.className = cls; }
        if (txt != null) { n.textContent = txt; }
        return n;
    }

    var rows = items.map(function (it) {
        var li = mk('li');
        li.appendChild(mk('span', 'rjsb-dot'));

        var when = mk('span', 'rjsb-when');
        when.appendChild(mk('b', '', fmtDate(it.date)));
        if (D.parasha && it.parasha) { when.appendChild(mk('small', '', it.parasha)); }
        li.appendChild(when);

        var times = mk('span', 'rjsb-times');
        [['candles', it.candle], ['havdalah', it.havdalah]].forEach(function (x) {
            var t = mk('span', 'rjsb-t');
            t.appendChild(mk('i', '', L[x[0]]));
            t.appendChild(mk('b', '', fmtT(x[1])));
            times.appendChild(t);
        });
        li.appendChild(times);

        elList.appendChild(li);
        return li;
    });

    var events = [];
    items.forEach(function (it) {
        if (it.candle != null) { events.push({ k: 'candle', t: it.candle }); }
        if (it.havdalah != null) { events.push({ k: 'havdalah', t: it.havdalah }); }
    });
    events.sort(function (a, b) { return a.t - b.t; });

    var lastKey = null;

    function paintDay(k, now) {
        if (elGreg) {
            try {
                elGreg.textContent = new Intl.DateTimeFormat(lang, { timeZone: tz, weekday: 'long', day: 'numeric', month: 'long' }).format(new Date(now));
            } catch (e) { elGreg.textContent = k; }
        }
        if (elHebrew) {
            if (!D.hebrew) { elHebrew.textContent = ''; return; }
            try {
                elHebrew.textContent = new Intl.DateTimeFormat(lang + '-u-ca-hebrew', { timeZone: tz, day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(now));
            } catch (e) { elHebrew.textContent = ''; }
        }
    }

    function tick() {
        var now = Date.now();
        var p = parts(now);
        var k = p.year + '-' + p.month + '-' + p.day;
        var hour = (+p.hour) % 24;

        if (elClock) { elClock.textContent = fmtHMS(p); }
        if (k !== lastKey) { lastKey = k; paintDay(k, now); }

        // Şabbat gedirmi?
        var live = null;
        items.forEach(function (it) {
            if (it.candle != null && it.havdalah != null && it.candle <= now && now < it.havdalah) { live = it; }
        });

        var phase = live ? 'shabbat' : (hour >= 6 && hour < 18 ? 'day' : 'night');
        if (root.dataset.phase !== phase) { root.dataset.phase = phase; }

        // Siyahı: keçmişləri gizlət, ilkini vurğula
        var shown = 0;
        items.forEach(function (it, i) {
            var past = it.havdalah != null ? it.havdalah <= now : it.date < k;
            var hide = past || shown >= D.count;
            rows[i].hidden = hide;
            rows[i].classList.toggle('is-next', !hide && shown === 0);
            if (!hide) { shown++; }
        });

        // Geri sayım və halqa
        var next = null, prev = null;
        for (var x = 0; x < events.length; x++) {
            if (events[x].t <= now) { prev = events[x]; } else { next = events[x]; break; }
        }

        if (elCount && next) {
            elCount.textContent = hms(next.t - now);
            if (elLbl) { elLbl.textContent = next.k === 'havdalah' ? L.in_end : L.in_candles; }
            if (elRing) {
                var start = prev ? prev.t : next.t - WEEK;
                var pct = ((now - start) / (next.t - start)) * 100;
                pct = Math.max(0, Math.min(100, pct));
                elRing.style.strokeDashoffset = (RING * (1 - pct / 100)).toFixed(2);
            }
        }
    }

    tick();
    setInterval(tick, 1000);
    document.addEventListener('visibilitychange', function () { if (!document.hidden) { tick(); } });
})();
</script>
@endif
