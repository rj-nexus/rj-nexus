<style>
    @property --sky1 { syntax: '<color>'; inherits: true; initial-value: #0284c7; }
    @property --sky2 { syntax: '<color>'; inherits: true; initial-value: #7dd3fc; }

    #{{ $uid }} { --acc: {{ $o['accent'] }}; width: 100%; padding: 24px 12px; box-sizing: border-box; transition: --sky1 2s ease, --sky2 2s ease;
        --sky1:#0284c7; --sky2:#7dd3fc; --wall:#fbe6c6; --roof:#b45309; --gr:#3f9b6e; --win:#38bdf8; --glowO:0; --flameO:0; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* Vaxta görə səma: gün, gecə, bayram */
    #{{ $uid }}[data-phase="day"]   { --sky1:#0284c7; --sky2:#7dd3fc; --wall:#fbe6c6; --roof:#b45309; --gr:#3f9b6e; --win:#38bdf8; --glowO:0; --flameO:0; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; }
    #{{ $uid }}[data-phase="night"] { --sky1:#070b1f; --sky2:#2b2766; --wall:#3b2f4a; --roof:#1f1535; --gr:#070b18; --win:#fbbf24; --glowO:.35; --flameO:1; --starO:1; --moonO:1; --sunO:0; --sunY:240px; --cloudO:.12; }
    #{{ $uid }}[data-phase="feast"] { --sky1:#3b0764; --sky2:#f97316; --wall:#ffedd5; --roof:#9a3412; --gr:#1c1208; --win:#fff7ed; --glowO:1; --flameO:1; --starO:.5; --moonO:0; --sunO:0; --sunY:240px; --cloudO:.3; }

    /* Kart */
    #{{ $uid }} .rjhd-card { position: relative; isolation: isolate; display: grid; grid-template-columns: 5fr 6fr; max-width: 980px; margin: 0 auto; border-radius: 26px; overflow: hidden; border: 1px solid rgba(255,255,255,.25); background: linear-gradient(180deg, var(--sky1), var(--sky2)); box-shadow: 0 24px 60px -24px rgba(2,6,23,.55); }
    #{{ $uid }} .rjhd-card.no-scene { grid-template-columns: 1fr; max-width: 520px; }
    #{{ $uid }}[data-side="right"] .rjhd-scene { order: 2; }

    #{{ $uid }} .rjhd-card::before,
    #{{ $uid }} .rjhd-card::after { content: ''; position: absolute; z-index: 0; border-radius: 50%; filter: blur(55px); pointer-events: none; animation: rjhd-float 16s ease-in-out infinite alternate; }
    #{{ $uid }} .rjhd-card::before { width: 280px; height: 280px; right: -70px; top: -70px; background: var(--acc); opacity: .45; }
    #{{ $uid }} .rjhd-card::after { width: 240px; height: 240px; left: 30%; bottom: -90px; background: #ec4899; opacity: .28; animation-duration: 20s; animation-direction: alternate-reverse; }

    /* Səhnə */
    #{{ $uid }} .rjhd-scene { position: relative; z-index: 1; min-height: 430px; overflow: hidden; }
    #{{ $uid }} .rjhd-svg { position: absolute; inset: 0; width: 100%; height: 100%; display: block; overflow: visible; }
    #{{ $uid }} .rjhd-g1 { stop-color: #fbbf24; stop-opacity: .6; }
    #{{ $uid }} .rjhd-g2 { stop-color: #fbbf24; stop-opacity: 0; }
    #{{ $uid }} .rjhd-gr { fill: var(--gr); transition: fill 2s; }
    #{{ $uid }} .rjhd-wall { fill: var(--wall); stroke: rgba(0,0,0,.2); stroke-width: 1; transition: fill 2s; }
    #{{ $uid }} .rjhd-roof { fill: var(--roof); stroke: rgba(0,0,0,.2); stroke-width: 1; transition: fill 2s; }
    #{{ $uid }} .rjhd-win { fill: var(--win); transition: fill 2s; }
    #{{ $uid }} .rjhd-sun { opacity: var(--sunO); transform: translateY(var(--sunY)); transition: transform 2.5s ease, opacity 2s ease; }
    #{{ $uid }} .rjhd-moon { opacity: var(--moonO); transition: opacity 2s ease; }
    #{{ $uid }} .rjhd-stars { opacity: var(--starO); transition: opacity 2s ease; }
    #{{ $uid }} .rjhd-clouds { opacity: var(--cloudO); transition: opacity 2s ease; }
    #{{ $uid }} .rjhd-star { fill: #fff; animation: rjhd-twinkle 3s ease-in-out infinite; }
    #{{ $uid }} .rjhd-cloud { fill: #fff; animation: rjhd-drift 75s linear infinite; }
    #{{ $uid }} .rjhd-cloud.c2 { animation-duration: 110s; animation-delay: -45s; }
    #{{ $uid }} .rjhd-sunhalo { transform-box: fill-box; transform-origin: center; animation: rjhd-pulse 6s ease-in-out infinite; }
    #{{ $uid }} .rjhd-halo { opacity: var(--glowO); transition: opacity 2s ease; transform-box: fill-box; transform-origin: center; animation: rjhd-pulse 5s ease-in-out infinite; }
    #{{ $uid }} .rjhd-flag { transform-box: fill-box; transform-origin: 0 50%; animation: rjhd-wave 2.4s ease-in-out infinite alternate; }

    /* Diya alovları yalnız gecə və bayram günü yanır */
    #{{ $uid }} .rjhd-flame { opacity: var(--flameO); transition: opacity 1.4s ease; transform-box: fill-box; transform-origin: 50% 100%; animation: rjhd-flick 1.5s ease-in-out infinite alternate; }
    #{{ $uid }} .rjhd-flame.f2 { animation-duration: 1.9s; animation-delay: -.6s; }
    #{{ $uid }} .rjhd-flame.f3 { animation-duration: 1.3s; animation-delay: -.3s; }

    @keyframes rjhd-twinkle { 0%,100% { opacity: .2; } 50% { opacity: 1; } }
    @keyframes rjhd-drift { from { transform: translateX(-300px); } to { transform: translateX(700px); } }
    @keyframes rjhd-pulse { 0%,100% { transform: scale(.94); } 50% { transform: scale(1.08); } }
    @keyframes rjhd-wave { from { transform: skewY(-6deg) scaleX(1); } to { transform: skewY(6deg) scaleX(.9); } }
    @keyframes rjhd-flick { 0% { transform: scale(1,1) rotate(-3deg); } 50% { transform: scale(.9,1.12) rotate(3deg); } 100% { transform: scale(1.06,.94) rotate(-1deg); } }
    @keyframes rjhd-float { from { transform: translate(0,0) scale(1); } to { transform: translate(-40px,50px) scale(1.2); } }

    #{{ $uid }}[data-anim="0"] .rjhd-scene *, #{{ $uid }}[data-anim="0"] .rjhd-card::before, #{{ $uid }}[data-anim="0"] .rjhd-card::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjhd-scene *, #{{ $uid }} .rjhd-card::before, #{{ $uid }} .rjhd-card::after { animation: none !important; }
    }

    /* Şüşə panel */
    #{{ $uid }} .rjhd-info { position: relative; z-index: 1; min-width: 0; margin: 14px 14px 14px 0; padding: 20px; border-radius: 20px; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,.25);
        background: linear-gradient(145deg, rgba(255,255,255,.18), rgba(255,255,255,.04)), rgba(15,23,42,.30);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.28); box-shadow: 0 12px 40px rgba(2,6,23,.3), inset 0 1px 0 rgba(255,255,255,.4); }
    #{{ $uid }}[data-style="glass-dark"] .rjhd-info { background: linear-gradient(145deg, rgba(255,255,255,.1), rgba(255,255,255,.02)), rgba(8,12,28,.55); border-color: rgba(255,255,255,.18); }
    #{{ $uid }}[data-side="right"] .rjhd-info { margin: 14px 0 14px 14px; }
    #{{ $uid }} .rjhd-card.no-scene .rjhd-info { margin: 14px; }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) {
        #{{ $uid }} .rjhd-info { background: rgba(15,23,42,.72); }
    }

    #{{ $uid }} .rjhd-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    #{{ $uid }} .rjhd-title { margin: 0; font-size: 1.15rem; font-weight: 800; color: #fff; }
    #{{ $uid }} .rjhd-place { display: flex; align-items: center; gap: 4px; margin-top: 3px; font-size: .82rem; color: rgba(255,255,255,.8); }
    #{{ $uid }} .rjhd-place svg { width: 13px; height: 13px; flex: none; }
    #{{ $uid }} .rjhd-clock { flex: none; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.25); font-size: .95rem; font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
    #{{ $uid }} .rjhd-dates { margin: 10px 0 14px; font-size: .8rem; color: rgba(255,255,255,.75); }

    /* Növbəti bayram */
    #{{ $uid }} .rjhd-next { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; margin-bottom: 12px; border-radius: 16px; color: #fff;
        background: linear-gradient(135deg, color-mix(in srgb, var(--acc) 90%, transparent), color-mix(in srgb, var(--acc) 50%, #e11d48));
        border: 1px solid rgba(255,255,255,.35); box-shadow: 0 10px 28px -10px var(--acc), inset 0 1px 0 rgba(255,255,255,.35); }
    #{{ $uid }} .rjhd-next-txt { min-width: 0; }
    #{{ $uid }} .rjhd-next-lbl { font-size: .8rem; font-weight: 600; opacity: .92; }
    #{{ $uid }} .rjhd-count { margin-top: 2px; font-size: 1.9rem; font-weight: 800; letter-spacing: .02em; line-height: 1.2; }
    #{{ $uid }} .rjhd-ring { flex: none; width: 58px; height: 58px; }
    #{{ $uid }} .rjhd-ring .bg { fill: none; stroke: rgba(255,255,255,.28); stroke-width: 5; }
    #{{ $uid }} .rjhd-ring .fg { fill: none; stroke: #fff; stroke-width: 5; stroke-linecap: round; stroke-dasharray: 163.36; stroke-dashoffset: 163.36; transition: stroke-dashoffset 1s linear; }

    /* Siyahı */
    #{{ $uid }} .rjhd-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 5px; }
    #{{ $uid }} .rjhd-list li { display: grid; grid-template-columns: 10px 1fr auto; align-items: center; gap: 12px; padding: 9px 12px; border-radius: 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); font-size: .95rem; transition: background .3s, border-color .3s, transform .2s; }
    #{{ $uid }} .rjhd-list li[hidden] { display: none; }
    #{{ $uid }} .rjhd-list li:hover { transform: translateX(3px); background: rgba(255,255,255,.14); }
    #{{ $uid }} .rjhd-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.35); }
    #{{ $uid }} .rjhd-list li.is-major .rjhd-dot { background: var(--acc); box-shadow: 0 0 0 3px rgba(255,255,255,.35); }
    #{{ $uid }} .rjhd-what { min-width: 0; display: flex; flex-direction: column; line-height: 1.25; }
    #{{ $uid }} .rjhd-what b { font-weight: 700; }
    #{{ $uid }} .rjhd-what small { font-size: .74rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .rjhd-badge { font-size: .78rem; font-weight: 600; white-space: nowrap; padding: 3px 9px; border-radius: 999px; background: rgba(255,255,255,.14); }
    #{{ $uid }} .rjhd-list li.is-next { background: color-mix(in srgb, var(--acc) 45%, transparent); border-color: rgba(255,255,255,.5); }
    #{{ $uid }} .rjhd-list li.is-next .rjhd-dot { background: #fff; box-shadow: 0 0 0 4px rgba(255,255,255,.28); }
    #{{ $uid }} .rjhd-list li.is-next .rjhd-badge { background: rgba(255,255,255,.25); }
    #{{ $uid }} .rjhd-note { margin: 10px 2px 0; font-size: .7rem; color: rgba(255,255,255,.65); line-height: 1.35; }

    #{{ $uid }} .rjhd-error { max-width: 520px; margin: 0 auto; padding: 20px; text-align: center; border-radius: 16px; background: rgba(15,23,42,.88); color: #e2e8f0; font-size: .9rem; }

    /* Mobil */
    @media (max-width: 760px) {
        #{{ $uid }} { padding: 12px 8px; }
        #{{ $uid }} .rjhd-card { grid-template-columns: 1fr; border-radius: 22px; }
        #{{ $uid }}[data-side="right"] .rjhd-scene { order: 0; }
        #{{ $uid }} .rjhd-scene { min-height: 0; height: 270px; }
        #{{ $uid }} .rjhd-info,
        #{{ $uid }}[data-side="right"] .rjhd-info { margin: -34px 10px 10px; padding: 16px 14px 14px; }
        #{{ $uid }} .rjhd-card.no-scene .rjhd-info { margin: 10px; }
        #{{ $uid }} .rjhd-count { font-size: 1.65rem; }
        #{{ $uid }} .rjhd-ring { width: 50px; height: 50px; }
        #{{ $uid }} .rjhd-list li { grid-template-columns: 1fr auto; gap: 8px; padding: 9px 10px; }
        #{{ $uid }} .rjhd-list li:hover { transform: none; }
        #{{ $uid }} .rjhd-dot { display: none; }
        #{{ $uid }} .rjhd-list li.is-major { border-color: rgba(255,255,255,.35); }
    }
</style>

@if ($error)
    <section id="{{ $uid }}" data-style="{{ $o['style'] }}"><div class="rjhd-error">{{ $error }}</div></section>
@else
@php
    $stars = [[24,30],[70,64],[118,24],[160,70],[210,36],[250,86],[300,28],[330,70],[48,110],[96,140],[236,130],[320,120],[190,100],[-30,60],[-60,120],[390,50],[420,110],[-10,20],[375,150]];
@endphp

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-side="{{ $o['side'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-phase="day">
    <div class="rjhd-card {{ $o['scene'] ? '' : 'no-scene' }}">

        @if ($o['scene'])
            <div class="rjhd-scene" aria-hidden="true">
                <svg class="rjhd-svg" viewBox="0 20 360 380" preserveAspectRatio="xMidYMax meet" focusable="false">
                    <defs>
                        <radialGradient id="{{ $uid }}-glow"><stop offset="0" class="rjhd-g1"/><stop offset="1" class="rjhd-g2"/></radialGradient>
                    </defs>

                    <g class="rjhd-stars">
                        @foreach ($stars as $i => $s)
                            <circle class="rjhd-star" cx="{{ $s[0] }}" cy="{{ $s[1] }}" r="{{ $i % 3 === 0 ? 1.8 : 1.2 }}" style="animation-delay: {{ number_format($i * 0.37, 2) }}s"/>
                        @endforeach
                    </g>

                    <g class="rjhd-moon">
                        <circle cx="300" cy="66" r="26" fill="#fef3c7"/>
                        <circle cx="292" cy="58" r="5" fill="#fde68a" opacity=".6"/>
                        <circle cx="308" cy="74" r="3.500" fill="#fde68a" opacity=".6"/>
                    </g>

                    <g class="rjhd-sun">
                        <circle class="rjhd-sunhalo" cx="62" cy="100" r="46" fill="#fde68a" opacity=".3"/>
                        <circle cx="62" cy="100" r="26" fill="#fde68a"/>
                    </g>

                    <g class="rjhd-clouds">
                        <g transform="translate(0,92)"><g class="rjhd-cloud"><ellipse cx="0" cy="0" rx="34" ry="11"/><ellipse cx="-18" cy="-6" rx="18" ry="10"/><ellipse cx="16" cy="-8" rx="20" ry="11"/></g></g>
                        <g transform="translate(0,150)"><g class="rjhd-cloud c2"><ellipse cx="0" cy="0" rx="28" ry="9"/><ellipse cx="-14" cy="-5" rx="15" ry="8"/><ellipse cx="14" cy="-6" rx="16" ry="9"/></g></g>
                    </g>

                    {{-- Bayram işığı --}}
                    <circle class="rjhd-halo" cx="180" cy="210" r="160" fill="url(#{{ $uid }}-glow)"/>

                    {{-- Pilləkən --}}
                    <rect class="rjhd-wall" x="40" y="326" width="280" height="14"/>
                    <rect class="rjhd-wall" x="55" y="314" width="250" height="12"/>

                    {{-- Mandapa (zal) --}}
                    <rect class="rjhd-wall" x="70" y="262" width="220" height="52"/>
                    <rect class="rjhd-roof" x="62" y="254" width="236" height="8" rx="2"/>
                    <path class="rjhd-win" d="M92 308 v-26 a8 8 0 0 1 16 0 v26z"/>
                    <path class="rjhd-win" d="M252 308 v-26 a8 8 0 0 1 16 0 v26z"/>
                    <path d="M165 314 v-32 a15 15 0 0 1 30 0 v32z" fill="#2a1a10"/>
                    <path class="rjhd-win" d="M171 314 v-26 a9 9 0 0 1 18 0 v26z" opacity=".55"/>

                    {{-- Şikhara (qüllə pillələri) --}}
                    <path class="rjhd-wall" d="M110 254 L120 214 L240 214 L250 254Z"/>
                    <path class="rjhd-wall" d="M122 214 L132 178 L228 178 L238 214Z"/>
                    <path class="rjhd-wall" d="M134 178 L146 146 L214 146 L226 178Z"/>
                    <path class="rjhd-win" d="M168 250 v-22 a12 12 0 0 1 24 0 v22z"/>
                    <path class="rjhd-win" d="M172 210 v-16 a8 8 0 0 1 16 0 v16z"/>
                    <path class="rjhd-win" d="M174 174 v-12 a6 6 0 0 1 12 0 v12z"/>
                    <path class="rjhd-roof" d="M148 146 Q158 100 180 76 Q202 100 212 146Z"/>
                    <g stroke="#000" stroke-opacity=".18" stroke-width="1" fill="none">
                        <path d="M160 140 Q166 108 180 88"/>
                        <path d="M200 140 Q194 108 180 88"/>
                        <line x1="180" y1="146" x2="180" y2="88"/>
                    </g>

                    {{-- Amalaka, kalasha və bayraq --}}
                    <ellipse cx="180" cy="74" rx="12" ry="5" fill="#fbbf24"/>
                    <path d="M174 70 q6 -16 12 0z" fill="#fbbf24"/>
                    <line x1="180" y1="56" x2="180" y2="26" stroke="#fbbf24" stroke-width="2" stroke-linecap="round"/>
                    <path class="rjhd-flag" d="M180 26 L206 33 L180 42Z" fill="#f97316"/>

                    {{-- Diya çıraqları --}}
                    @foreach (range(0, 7) as $n)
                        @php $x = 68 + $n * 32.6; @endphp
                        <g transform="translate({{ $x }},0)">
                            <path d="M-7 324 q7 7 14 0 z" fill="#b45309"/>
                            <ellipse cx="0" cy="324" rx="7" ry="1.800" fill="#d97706"/>
                            <g class="rjhd-flame {{ $n % 3 === 1 ? 'f2' : ($n % 3 === 2 ? 'f3' : '') }}">
                                <path d="M0 308 C4 314 4 320 0 323 C-4 320 -4 314 0 308Z" fill="#fbbf24"/>
                                <path d="M0 315 C2 318 2 321 0 322.500 C-2 321 -2 318 0 315Z" fill="#fff7ed"/>
                            </g>
                        </g>
                    @endforeach

                    <rect class="rjhd-gr" x="-900" y="340" width="2160" height="220"/>
                </svg>
            </div>
        @endif

        <div class="rjhd-info">
            <div class="rjhd-head">
                <div>
                    @if ($o['title'] !== '')<h4 class="rjhd-title">{{ $o['title'] }}</h4>@endif
                    <div class="rjhd-place">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3 4 5 6.500 5 10a5 5 0 01-10 0c0-3.500 2-6 5-10z"/></svg>
                        <span>{{ $o['dharma_label'] }}</span>
                    </div>
                </div>
                <div class="rjhd-clock" data-el="clock">--:--</div>
            </div>

            <div class="rjhd-dates"><span data-el="greg"></span></div>

            @if ($o['countdown'])
                <div class="rjhd-next">
                    <div class="rjhd-next-txt">
                        <div class="rjhd-next-lbl" data-el="nextlbl">&nbsp;</div>
                        <div class="rjhd-count" data-el="count" role="timer" aria-live="off">--</div>
                    </div>
                    <svg class="rjhd-ring" viewBox="0 0 64 64" aria-hidden="true">
                        <circle class="bg" cx="32" cy="32" r="26"/>
                        <circle class="fg" data-el="ring" cx="32" cy="32" r="26" transform="rotate(-90 32 32)"/>
                    </svg>
                </div>
            @endif

            <ul class="rjhd-list" data-el="list"></ul>

            @if ($note !== '')<p class="rjhd-note">{{ $note }}</p>@endif
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
    var RING = 163.36;

    function el(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var elClock = el('clock'), elGreg = el('greg');
    var elCount = el('count'), elLbl = el('nextlbl'), elRing = el('ring'), elList = el('list');

    var dtf = new Intl.DateTimeFormat('en-US', {
        timeZone: tz, hourCycle: 'h23', year: 'numeric', month: '2-digit', day: '2-digit',
        hour: '2-digit', minute: '2-digit', second: '2-digit'
    });

    function pad(n) { return (n < 10 ? '0' : '') + n; }

    function parts(ms) {
        var o = {};
        dtf.formatToParts(new Date(ms)).forEach(function (p) { if (p.type !== 'literal') { o[p.type] = p.value; } });
        return o;
    }

    function dayNum(k) {
        var a = k.split('-');
        return Date.UTC(+a[0], +a[1] - 1, +a[2]) / 86400000;
    }

    function fmtDate(k) {
        var a = k.split('-');
        try {
            return new Intl.DateTimeFormat(lang, { timeZone: 'UTC', weekday: 'short', day: 'numeric', month: 'long' }).format(new Date(Date.UTC(+a[0], +a[1] - 1, +a[2], 12)));
        } catch (e) { return k; }
    }

    function mk(tag, cls, txt) {
        var n = document.createElement(tag);
        if (cls) { n.className = cls; }
        if (txt != null) { n.textContent = txt; }
        return n;
    }

    items.forEach(function (it) { it.n = dayNum(it.date); });

    var rows = items.map(function (it) {
        var li = mk('li', it.major ? 'is-major' : '');
        li.appendChild(mk('span', 'rjhd-dot'));
        var what = mk('span', 'rjhd-what');
        what.appendChild(mk('b', '', it.name));
        what.appendChild(mk('small', '', fmtDate(it.date)));
        li.appendChild(what);
        var badge = mk('span', 'rjhd-badge', '');
        li.appendChild(badge);
        li._badge = badge;
        elList.appendChild(li);
        return li;
    });

    function badgeText(diff) {
        if (diff === 0) { return L.today; }
        if (diff === 1) { return L.tomorrow; }
        return L.in_days.replace(':n', diff);
    }

    var lastKey = null;

    function tick() {
        var now = Date.now();
        var p = parts(now);
        var k = p.year + '-' + p.month + '-' + p.day;
        var hour = (+p.hour) % 24;
        var n = dayNum(k);

        if (elClock) { elClock.textContent = pad(hour) + ':' + p.minute + ':' + p.second; }

        if (k !== lastKey) {
            lastKey = k;
            if (elGreg) {
                try {
                    elGreg.textContent = new Intl.DateTimeFormat(lang, { timeZone: tz, weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(now));
                } catch (e) { elGreg.textContent = k; }
            }
        }

        var shown = 0, next = null, prev = null, feastToday = false;

        items.forEach(function (it, i) {
            var diff = it.n - n;
            if (diff < 0) { prev = it; }
            if (diff === 0) { feastToday = true; }
            var hide = diff < 0 || shown >= D.count;
            rows[i].hidden = hide;
            rows[i].classList.toggle('is-next', !hide && shown === 0);
            if (!hide) {
                rows[i]._badge.textContent = badgeText(diff);
                if (!next) { next = it; }
                shown++;
            }
        });

        var phase = feastToday ? 'feast' : (hour >= 6 && hour < 18 ? 'day' : 'night');
        if (root.dataset.phase !== phase) { root.dataset.phase = phase; }

        if (elCount && next) {
            var diffN = next.n - n;
            elCount.textContent = diffN === 0 ? L.today : diffN + ' ' + (diffN === 1 ? L.day : L.days);
            if (elLbl) { elLbl.textContent = (diffN === 0 ? L.now : L.next).replace(':name', next.name); }
            if (elRing) {
                var frac = (hour * 3600 + (+p.minute) * 60 + (+p.second)) / 86400;
                var startN = prev ? prev.n : next.n - 120;
                var pct = diffN === 0 ? 100 : ((n + frac - startN) / (next.n - startN)) * 100;
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
