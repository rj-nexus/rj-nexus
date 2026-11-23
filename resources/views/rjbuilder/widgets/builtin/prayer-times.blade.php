<style>
    @property --sky1 { syntax: '<color>'; inherits: true; initial-value: #0284c7; }
    @property --sky2 { syntax: '<color>'; inherits: true; initial-value: #7dd3fc; }

    #{{ $uid }} { --acc: {{ $o['accent'] }}; width: 100%; padding: 24px 12px; box-sizing: border-box; transition: --sky1 2s ease, --sky2 2s ease;
        --sky1:#0284c7; --sky2:#7dd3fc; --mq:#f8fafc; --mq2:#cbd5e1; --gr:#3f9b6e; --win:#38bdf8; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; --birdO:.7; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* Vaxta görə səma */
    #{{ $uid }}[data-phase="night"]   { --sky1:#070b1f; --sky2:#2b2766; --mq:#131c38; --mq2:#2a3a66; --gr:#070b18; --win:#fbbf24; --starO:1; --moonO:1; --sunO:0; --sunY:240px; --cloudO:.12; --birdO:0; }
    #{{ $uid }}[data-phase="fajr"]    { --sky1:#1e3a8a; --sky2:#f9a8d4; --mq:#2b2850; --mq2:#46427a; --gr:#1a1738; --win:#fbbf24; --starO:.55; --moonO:.8; --sunO:.9; --sunY:235px; --cloudO:.35; --birdO:0; }
    #{{ $uid }}[data-phase="day"]     { --sky1:#0284c7; --sky2:#7dd3fc; --mq:#f8fafc; --mq2:#cbd5e1; --gr:#3f9b6e; --win:#38bdf8; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; --birdO:.7; }
    #{{ $uid }}[data-phase="maghrib"] { --sky1:#4c1d95; --sky2:#fb923c; --mq:#2a1442; --mq2:#4a2160; --gr:#1f1233; --win:#fbbf24; --starO:.35; --moonO:0; --sunO:1; --sunY:215px; --cloudO:.5; --birdO:0; }

    /* Kart: səma = fon */
    #{{ $uid }} .rjpt-card { position: relative; isolation: isolate; display: grid; grid-template-columns: 5fr 6fr; max-width: 980px; margin: 0 auto; border-radius: 26px; overflow: hidden; border: 1px solid rgba(255,255,255,.25); background: linear-gradient(180deg, var(--sky1), var(--sky2)); box-shadow: 0 24px 60px -24px rgba(2,6,23,.55); }
    #{{ $uid }} .rjpt-card.no-scene { grid-template-columns: 1fr; max-width: 520px; }
    #{{ $uid }}[data-side="right"] .rjpt-scene { order: 2; }

    /* Arxa işıq topları (şüşənin altında görünür) */
    #{{ $uid }} .rjpt-card::before,
    #{{ $uid }} .rjpt-card::after { content: ''; position: absolute; z-index: 0; border-radius: 50%; filter: blur(55px); pointer-events: none; animation: rjpt-float 16s ease-in-out infinite alternate; }
    #{{ $uid }} .rjpt-card::before { width: 280px; height: 280px; right: -70px; top: -70px; background: var(--acc); opacity: .45; }
    #{{ $uid }} .rjpt-card::after { width: 240px; height: 240px; left: 30%; bottom: -90px; background: #ec4899; opacity: .28; animation-duration: 20s; animation-direction: alternate-reverse; }

    /* Səhnə */
    #{{ $uid }} .rjpt-scene { position: relative; z-index: 1; min-height: 430px; overflow: hidden; }
    #{{ $uid }} .rjpt-svg { position: absolute; inset: 0; width: 100%; height: 100%; display: block; overflow: visible; }
    #{{ $uid }} .rjpt-g1 { stop-color: var(--acc); stop-opacity: .55; }
    #{{ $uid }} .rjpt-g2 { stop-color: var(--acc); stop-opacity: 0; }
    #{{ $uid }} .rjpt-mq { fill: var(--mq); stroke: var(--mq2); stroke-width: 1; transition: fill 2s, stroke 2s; }
    #{{ $uid }} .rjpt-mq2 { fill: var(--mq2); transition: fill 2s; }
    #{{ $uid }} .rjpt-win { fill: var(--win); transition: fill 2s; }
    #{{ $uid }} .rjpt-gr { fill: var(--gr); transition: fill 2s; }
    #{{ $uid }} .rjpt-sun { opacity: var(--sunO); transform: translateY(var(--sunY)); transition: transform 2.5s ease, opacity 2s ease; }
    #{{ $uid }} .rjpt-moon { opacity: var(--moonO); transition: opacity 2s ease; }
    #{{ $uid }} .rjpt-stars { opacity: var(--starO); transition: opacity 2s ease; }
    #{{ $uid }} .rjpt-clouds { opacity: var(--cloudO); transition: opacity 2s ease; }
    #{{ $uid }} .rjpt-birds { opacity: var(--birdO); transition: opacity 2s ease; }

    #{{ $uid }} .rjpt-star { fill: #fff; animation: rjpt-twinkle 3s ease-in-out infinite; }
    #{{ $uid }} .rjpt-shoot { stroke: #fff; stroke-width: 1.6; stroke-linecap: round; animation: rjpt-shoot 9s ease-in infinite; opacity: 0; }
    #{{ $uid }} .rjpt-cloud { fill: #fff; animation: rjpt-drift 75s linear infinite; }
    #{{ $uid }} .rjpt-cloud.c2 { animation-duration: 110s; animation-delay: -45s; }
    #{{ $uid }} .rjpt-bird { fill: none; stroke: #1e293b; stroke-width: 1.6; stroke-linecap: round; animation: rjpt-fly 28s linear infinite; }
    #{{ $uid }} .rjpt-bird.b2 { animation-delay: -10s; animation-duration: 34s; }
    #{{ $uid }} .rjpt-glow { transform-box: fill-box; transform-origin: center; animation: rjpt-pulse 5s ease-in-out infinite; }
    #{{ $uid }}.is-call .rjpt-glow { animation: rjpt-pulse 1s ease-in-out infinite; }
    #{{ $uid }} .rjpt-win { animation: rjpt-lamp 4s ease-in-out infinite; }
    #{{ $uid }} .rjpt-sunhalo { transform-box: fill-box; transform-origin: center; animation: rjpt-pulse 6s ease-in-out infinite; }
    #{{ $uid }} .rjpt-wave { fill: none; stroke: #fbbf24; stroke-width: 2; opacity: 0; transform-box: fill-box; transform-origin: center; }
    #{{ $uid }}.is-call .rjpt-wave { animation: rjpt-wave 2.4s ease-out infinite; }
    #{{ $uid }}.is-call .rjpt-wave.w2 { animation-delay: 1.2s; }

    @keyframes rjpt-twinkle { 0%,100% { opacity: .2; } 50% { opacity: 1; } }
    @keyframes rjpt-drift { from { transform: translateX(-300px); } to { transform: translateX(700px); } }
    @keyframes rjpt-fly { from { transform: translateX(-200px); } to { transform: translateX(600px); } }
    @keyframes rjpt-pulse { 0%,100% { transform: scale(.92); opacity: .65; } 50% { transform: scale(1.1); opacity: 1; } }
    @keyframes rjpt-lamp { 0%,100% { opacity: .85; } 50% { opacity: 1; } }
    @keyframes rjpt-shoot { 0% { transform: translate(0,0); opacity: 0; } 2% { opacity: 1; } 9% { transform: translate(-150px,66px); opacity: 0; } 100% { transform: translate(-150px,66px); opacity: 0; } }
    @keyframes rjpt-wave { 0% { transform: scale(.6); opacity: .8; } 100% { transform: scale(3.2); opacity: 0; } }
    @keyframes rjpt-float { from { transform: translate(0,0) scale(1); } to { transform: translate(-40px,50px) scale(1.2); } }

    #{{ $uid }}[data-anim="0"] .rjpt-scene *, #{{ $uid }}[data-anim="0"] .rjpt-card::before, #{{ $uid }}[data-anim="0"] .rjpt-card::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjpt-scene *, #{{ $uid }} .rjpt-card::before, #{{ $uid }} .rjpt-card::after { animation: none !important; }
    }

    /* Şüşə panel */
    #{{ $uid }} .rjpt-info { position: relative; z-index: 1; min-width: 0; margin: 14px 14px 14px 0; padding: 20px; border-radius: 20px; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,.25);
        background: linear-gradient(145deg, rgba(255,255,255,.18), rgba(255,255,255,.04)), rgba(15,23,42,.30);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.28); box-shadow: 0 12px 40px rgba(2,6,23,.3), inset 0 1px 0 rgba(255,255,255,.4); }
    #{{ $uid }}[data-style="glass-dark"] .rjpt-info { background: linear-gradient(145deg, rgba(255,255,255,.1), rgba(255,255,255,.02)), rgba(8,12,28,.55); border-color: rgba(255,255,255,.18); }
    #{{ $uid }}[data-side="right"] .rjpt-info { margin: 14px 0 14px 14px; }
    #{{ $uid }} .rjpt-card.no-scene .rjpt-info { margin: 14px; }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) {
        #{{ $uid }} .rjpt-info { background: rgba(15,23,42,.72); }
    }

    #{{ $uid }} .rjpt-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    #{{ $uid }} .rjpt-title { margin: 0; font-size: 1.15rem; font-weight: 800; color: #fff; }
    #{{ $uid }} .rjpt-place { display: flex; align-items: center; gap: 4px; margin-top: 3px; font-size: .82rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .rjpt-place svg { width: 13px; height: 13px; flex: none; }
    #{{ $uid }} .rjpt-clock { flex: none; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.25); font-size: .95rem; font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
    #{{ $uid }} .rjpt-dates { display: flex; flex-wrap: wrap; gap: 2px 12px; margin: 10px 0 14px; font-size: .8rem; color: rgba(255,255,255,.75); }

    /* Növbəti namaz */
    #{{ $uid }} .rjpt-next { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; margin-bottom: 12px; border-radius: 16px; color: #fff;
        background: linear-gradient(135deg, color-mix(in srgb, var(--acc) 90%, transparent), color-mix(in srgb, var(--acc) 50%, #0ea5e9));
        border: 1px solid rgba(255,255,255,.35); box-shadow: 0 10px 28px -10px var(--acc), inset 0 1px 0 rgba(255,255,255,.35); }
    #{{ $uid }} .rjpt-next-txt { min-width: 0; }
    #{{ $uid }} .rjpt-next-lbl { font-size: .8rem; font-weight: 600; opacity: .92; }
    #{{ $uid }} .rjpt-count { margin-top: 2px; font-size: 1.9rem; font-weight: 800; letter-spacing: .02em; font-variant-numeric: tabular-nums; line-height: 1.2; }
    #{{ $uid }} .rjpt-ring { flex: none; width: 58px; height: 58px; }
    #{{ $uid }} .rjpt-ring .bg { fill: none; stroke: rgba(255,255,255,.28); stroke-width: 5; }
    #{{ $uid }} .rjpt-ring .fg { fill: none; stroke: #fff; stroke-width: 5; stroke-linecap: round; stroke-dasharray: 163.36; stroke-dashoffset: 163.36; transition: stroke-dashoffset 1s linear; }

    /* Siyahı */
    #{{ $uid }} .rjpt-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 5px; }
    #{{ $uid }} .rjpt-list li { display: grid; grid-template-columns: 10px 1fr auto; align-items: center; gap: 12px; padding: 9px 12px; border-radius: 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); font-size: .95rem; transition: background .3s, border-color .3s, opacity .3s, transform .2s; }
    #{{ $uid }} .rjpt-list li:hover { transform: translateX(3px); background: rgba(255,255,255,.14); }
    #{{ $uid }} .rjpt-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.35); }
    #{{ $uid }} .rjpt-time { font-weight: 700; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rjpt-list li.is-past { opacity: .55; }
    #{{ $uid }} .rjpt-list li.is-next { opacity: 1; font-weight: 700; background: color-mix(in srgb, var(--acc) 45%, transparent); border-color: rgba(255,255,255,.5); }
    #{{ $uid }} .rjpt-list li.is-next .rjpt-dot { background: #fff; box-shadow: 0 0 0 4px rgba(255,255,255,.28); }
    #{{ $uid }} .rjpt-list li.is-sun .rjpt-name { font-style: italic; }

    #{{ $uid }} .rjpt-error { max-width: 520px; margin: 0 auto; padding: 20px; text-align: center; border-radius: 16px; background: rgba(15,23,42,.88); color: #e2e8f0; font-size: .9rem; }

    /* Mobil */
    @media (max-width: 760px) {
        #{{ $uid }} { padding: 12px 8px; }
        #{{ $uid }} .rjpt-card { grid-template-columns: 1fr; border-radius: 22px; }
        #{{ $uid }}[data-side="right"] .rjpt-scene { order: 0; }
        #{{ $uid }} .rjpt-scene { min-height: 0; height: 270px; }
        #{{ $uid }} .rjpt-info,
        #{{ $uid }}[data-side="right"] .rjpt-info { margin: -34px 10px 10px; padding: 16px 14px 14px; }
        #{{ $uid }} .rjpt-card.no-scene .rjpt-info { margin: 10px; }
        #{{ $uid }} .rjpt-count { font-size: 1.65rem; }
        #{{ $uid }} .rjpt-ring { width: 50px; height: 50px; }

        #{{ $uid }} .rjpt-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
        #{{ $uid }} .rjpt-list li { display: flex; flex-direction: column; align-items: center; gap: 2px; padding: 10px 4px; text-align: center; }
        #{{ $uid }} .rjpt-list li:hover { transform: none; }
        #{{ $uid }} .rjpt-dot { display: none; }
        #{{ $uid }} .rjpt-name { font-size: .72rem; opacity: .85; }
        #{{ $uid }} .rjpt-time { font-size: 1rem; }
    }
</style>

@if ($error)
    <section id="{{ $uid }}" data-style="{{ $o['style'] }}"><div class="rjpt-error">{{ $error }}</div></section>
@else
@php
    $today = $payload['days'][$payload['today']] ?? [];
    $stars = [[24,30],[70,64],[118,24],[160,70],[210,36],[250,86],[300,28],[330,70],[48,110],[96,140],[236,130],[320,120],[190,100],[-30,60],[-60,120],[390,50],[420,110],[-10,20],[375,150]];
@endphp

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-side="{{ $o['side'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-phase="day">
    <div class="rjpt-card {{ $o['scene'] ? '' : 'no-scene' }}">

        @if ($o['scene'])
            <div class="rjpt-scene" aria-hidden="true">
                <svg class="rjpt-svg" viewBox="0 20 360 380" preserveAspectRatio="xMidYMax meet" focusable="false">
                    <defs>
                        <radialGradient id="{{ $uid }}-glow"><stop offset="0" class="rjpt-g1"/><stop offset="1" class="rjpt-g2"/></radialGradient>
                        <symbol id="{{ $uid }}-cres" viewBox="0 0 24 24">
                            <mask id="{{ $uid }}-cm"><rect width="24" height="24" fill="#fff"/><circle cx="15" cy="9.5" r="9" fill="#000"/></mask>
                            <circle cx="11" cy="12" r="10" fill="currentColor" mask="url(#{{ $uid }}-cm)"/>
                        </symbol>
                        <g id="{{ $uid }}-min">
                            <path class="rjpt-mq" d="M42 160 L50 124 L58 160Z"/>
                            <rect class="rjpt-mq" x="43" y="160" width="14" height="180"/>
                            <rect class="rjpt-mq2" x="38" y="152" width="24" height="6" rx="2"/>
                            <rect class="rjpt-mq2" x="35" y="198" width="30" height="7" rx="2"/>
                            <rect class="rjpt-win" x="47" y="228" width="6" height="16" rx="3"/>
                            <rect class="rjpt-win" x="47" y="268" width="6" height="16" rx="3"/>
                            <line x1="50" y1="124" x2="50" y2="112" stroke="#fbbf24" stroke-width="1.5"/>
                            <use href="#{{ $uid }}-cres" x="42" y="96" width="16" height="16" style="color:#fbbf24"/>
                        </g>
                    </defs>

                    <g class="rjpt-stars">
                        @foreach ($stars as $i => $s)
                            <circle class="rjpt-star" cx="{{ $s[0] }}" cy="{{ $s[1] }}" r="{{ $i % 3 === 0 ? 1.8 : 1.2 }}" style="animation-delay: {{ number_format($i * 0.37, 2) }}s"/>
                        @endforeach
                        <g transform="translate(320,44)"><line class="rjpt-shoot" x1="0" y1="0" x2="26" y2="-11"/></g>
                    </g>

                    <g class="rjpt-moon"><use href="#{{ $uid }}-cres" x="262" y="40" width="54" height="54" style="color:#fef3c7"/></g>

                    <g class="rjpt-sun">
                        <circle class="rjpt-sunhalo" cx="86" cy="96" r="46" fill="#fde68a" opacity=".3"/>
                        <circle cx="86" cy="96" r="26" fill="#fde68a"/>
                    </g>

                    <g class="rjpt-clouds">
                        <g transform="translate(0,92)"><g class="rjpt-cloud"><ellipse cx="0" cy="0" rx="34" ry="11"/><ellipse cx="-18" cy="-6" rx="18" ry="10"/><ellipse cx="16" cy="-8" rx="20" ry="11"/></g></g>
                        <g transform="translate(0,150)"><g class="rjpt-cloud c2"><ellipse cx="0" cy="0" rx="28" ry="9"/><ellipse cx="-14" cy="-5" rx="15" ry="8"/><ellipse cx="14" cy="-6" rx="16" ry="9"/></g></g>
                    </g>

                    <g class="rjpt-birds">
                        <g transform="translate(0,60)"><path class="rjpt-bird" d="M0 0 q5 -6 10 0 q5 -6 10 0"/></g>
                        <g transform="translate(0,78)"><path class="rjpt-bird b2" d="M0 0 q4 -5 8 0 q4 -5 8 0"/></g>
                    </g>

                    <circle class="rjpt-glow" cx="180" cy="215" r="95" fill="url(#{{ $uid }}-glow)"/>
                    <circle class="rjpt-wave" cx="180" cy="210" r="40"/>
                    <circle class="rjpt-wave w2" cx="180" cy="210" r="40"/>

                    <use href="#{{ $uid }}-min"/>
                    <use href="#{{ $uid }}-min" transform="translate(260,0)"/>

                    <rect class="rjpt-mq" x="82" y="285" width="30" height="55"/>
                    <path class="rjpt-mq" d="M82 285 Q97 258 112 285Z"/>
                    <rect class="rjpt-mq" x="248" y="285" width="30" height="55"/>
                    <path class="rjpt-mq" d="M248 285 Q263 258 278 285Z"/>

                    <rect class="rjpt-mq" x="110" y="250" width="140" height="90"/>
                    <rect class="rjpt-mq2" x="106" y="246" width="148" height="8" rx="2"/>
                    <path class="rjpt-mq" d="M118 248 Q118 176 180 166 Q242 176 242 248Z"/>
                    <path d="M140 232 Q142 190 180 176" fill="none" stroke="#fff" stroke-opacity=".25" stroke-width="3" stroke-linecap="round"/>
                    <line x1="180" y1="166" x2="180" y2="146" stroke="#fbbf24" stroke-width="2"/>
                    <use href="#{{ $uid }}-cres" x="168" y="124" width="24" height="24" style="color:#fbbf24"/>

                    <path class="rjpt-win" d="M124 304 v-16 a8 8 0 0 1 16 0 v16z"/>
                    <path class="rjpt-win" d="M220 304 v-16 a8 8 0 0 1 16 0 v16z"/>
                    <path class="rjpt-win" d="M168 340 v-34 a12 12 0 0 1 24 0 v34z"/>
                    <rect class="rjpt-win" x="92" y="304" width="10" height="16" rx="5"/>
                    <rect class="rjpt-win" x="258" y="304" width="10" height="16" rx="5"/>

                    <rect class="rjpt-gr" x="-900" y="340" width="2160" height="220"/>
                </svg>
            </div>
        @endif

        <div class="rjpt-info">
            <div class="rjpt-head">
                <div>
                    @if ($o['title'] !== '')<h4 class="rjpt-title">{{ $o['title'] }}</h4>@endif
                    <div class="rjpt-place">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <span>{{ $o['place'] }}</span>
                    </div>
                </div>
                <div class="rjpt-clock" data-el="clock">--:--</div>
            </div>

            <div class="rjpt-dates"><span data-el="greg"></span><span data-el="hijri">{{ $payload['hijri'] ? ($today['hijri'] ?? '') : '' }}</span></div>

            @if ($o['countdown'])
                <div class="rjpt-next">
                    <div class="rjpt-next-txt">
                        <div class="rjpt-next-lbl" data-el="nextlbl">&nbsp;</div>
                        <div class="rjpt-count" data-el="count" role="timer" aria-live="off">--:--:--</div>
                    </div>
                    <svg class="rjpt-ring" viewBox="0 0 64 64" aria-hidden="true">
                        <circle class="bg" cx="32" cy="32" r="26"/>
                        <circle class="fg" data-el="ring" cx="32" cy="32" r="26" transform="rotate(-90 32 32)"/>
                    </svg>
                </div>
            @endif

            <ul class="rjpt-list">
                @foreach ($order as $k)
                    <li data-k="{{ $k }}" class="{{ $k === 'sunrise' ? 'is-sun' : '' }}">
                        <span class="rjpt-dot"></span>
                        <span class="rjpt-name">{{ $labels[$k] }}</span>
                        <span class="rjpt-time" data-t="{{ $k }}">{{ $today[$k] ?? '--:--' }}</span>
                    </li>
                @endforeach
            </ul>
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
    if (!D || !D.days) { return; }

    var tz = D.tz;
    try { new Intl.DateTimeFormat('en', { timeZone: tz }); } catch (e) { tz = 'UTC'; }

    var L = D.labels, order = D.order;
    var lang = document.documentElement.lang || navigator.language || 'en';
    var PRAYERS = ['fajr', 'dhuhr', 'asr', 'maghrib', 'isha'];
    var RING = 163.36;

    function el(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var elClock = el('clock'), elGreg = el('greg'), elHijri = el('hijri');
    var elCount = el('count'), elLbl = el('nextlbl'), elRing = el('ring');
    var rows = {};
    root.querySelectorAll('.rjpt-list li').forEach(function (li) { rows[li.dataset.k] = li; });

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

    function offset(ms) {
        var p = parts(ms);
        var asUtc = Date.UTC(+p.year, +p.month - 1, +p.day, (+p.hour) % 24, +p.minute, +p.second);
        return asUtc - Math.floor(ms / 1000) * 1000;
    }

    // "YYYY-MM-DD" + "HH:MM" (şəhərin yerli vaxtı) -> UTC millisaniyə
    function inst(k, t) {
        var a = k.split('-'), b = t.split(':');
        var guess = Date.UTC(+a[0], +a[1] - 1, +a[2], +b[0], +b[1], 0);
        var u = guess - offset(guess);
        return guess - offset(u);
    }

    function addDays(k, n) {
        var a = k.split('-');
        var d = new Date(Date.UTC(+a[0], +a[1] - 1, +a[2] + n));
        return d.getUTCFullYear() + '-' + pad(d.getUTCMonth() + 1) + '-' + pad(d.getUTCDate());
    }

    function build(k) {
        var day = D.days[k];
        if (!day) { return null; }
        return order.map(function (n) { return { k: n, t: inst(k, day[n]) }; });
    }

    function fmt(t) {
        if (D.fmt !== '12') { return t; }
        var s = t.split(':'), h = +s[0];
        return (h % 12 || 12) + ':' + s[1] + ' ' + (h < 12 ? 'AM' : 'PM');
    }

    function fmtHMS(p) {
        if (D.fmt !== '12') { return pad((+p.hour) % 24) + ':' + p.minute + ':' + p.second; }
        var h = (+p.hour) % 24;
        return (h % 12 || 12) + ':' + p.minute + ':' + p.second + ' ' + (h < 12 ? 'AM' : 'PM');
    }

    function hms(ms) {
        var s = Math.max(0, Math.floor(ms / 1000));
        return pad(Math.floor(s / 3600)) + ':' + pad(Math.floor((s % 3600) / 60)) + ':' + pad(s % 60);
    }

    var lastKey = null;

    function paintDay(k, now) {
        var day = D.days[k];
        PRAYERS.concat(['sunrise']).forEach(function (n) {
            var t = root.querySelector('[data-t="' + n + '"]');
            if (t && day[n]) { t.textContent = fmt(day[n]); }
        });

        if (elGreg) {
            try {
                elGreg.textContent = new Intl.DateTimeFormat(lang, { timeZone: tz, weekday: 'long', day: 'numeric', month: 'long' }).format(new Date(now));
            } catch (e) { elGreg.textContent = k; }
        }

        if (elHijri) {
            if (!D.hijri) { elHijri.textContent = ''; return; }
            try {
                elHijri.textContent = new Intl.DateTimeFormat(lang + '-u-ca-islamic-umalqura', { timeZone: tz, day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(now));
            } catch (e) { elHijri.textContent = day.hijri || ''; }
        }
    }

    function tick() {
        var now = Date.now();
        var p = parts(now);
        var k = p.year + '-' + p.month + '-' + p.day;
        var day = D.days[k];

        if (elClock) { elClock.textContent = fmtHMS(p); }
        if (!day) { return; }

        if (k !== lastKey) { lastKey = k; paintDay(k, now); }

        // Faza (səma)
        var f = inst(k, day.fajr), s = inst(k, day.sunrise), m = inst(k, day.maghrib), i = inst(k, day.isha);
        var phase = now < f ? 'night' : now < s ? 'fajr' : now < m ? 'day' : now < i ? 'maghrib' : 'night';
        if (root.dataset.phase !== phase) { root.dataset.phase = phase; }

        // Növbəti və əvvəlki hadisə
        var ev = build(k), next = null, prev = null;
        for (var x = 0; x < ev.length; x++) {
            if (ev[x].t <= now) { prev = ev[x]; } else { next = ev[x]; break; }
        }
        if (!next) {
            var nb = build(addDays(k, 1));
            if (nb) { next = nb[0]; }
        }
        if (!prev) {
            var pb = build(addDays(k, -1));
            if (pb) { prev = pb[pb.length - 1]; }
        }

        // Namaz vaxtı gələndə günbəz işığı və dalğalar
        root.classList.toggle('is-call', !!(prev && prev.k !== 'sunrise' && now - prev.t < 60000));

        // Siyahı
        order.forEach(function (n, idx) {
            var li = rows[n];
            if (!li) { return; }
            li.classList.toggle('is-next', !!next && next.k === n);
            li.classList.toggle('is-past', ev[idx].t <= now);
        });

        // Geri sayım və halqa
        if (elCount && next) {
            elCount.textContent = hms(next.t - now);
            if (elLbl) { elLbl.textContent = L.next.replace(':prayer', L[next.k]); }
            if (elRing) {
                var pct = prev ? ((now - prev.t) / (next.t - prev.t)) * 100 : 0;
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