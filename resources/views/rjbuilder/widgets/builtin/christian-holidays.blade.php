<style>
    @property --sky1 { syntax: '<color>'; inherits: true; initial-value: #0284c7; }
    @property --sky2 { syntax: '<color>'; inherits: true; initial-value: #7dd3fc; }

    #{{ $uid }} { --acc: {{ $o['accent'] }}; width: 100%; padding: 24px 12px; box-sizing: border-box; transition: --sky1 2s ease, --sky2 2s ease;
        --sky1:#0284c7; --sky2:#7dd3fc; --wall:#f1f5f9; --roof:#64748b; --gr:#3f9b6e; --win:#38bdf8; --glowO:0; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* Vaxta görə səma: gün, gecə, bayram */
    #{{ $uid }}[data-phase="day"]   { --sky1:#0284c7; --sky2:#7dd3fc; --wall:#f1f5f9; --roof:#64748b; --gr:#3f9b6e; --win:#38bdf8; --glowO:0; --starO:0; --moonO:0; --sunO:1; --sunY:0px; --cloudO:.9; }
    #{{ $uid }}[data-phase="night"] { --sky1:#070b1f; --sky2:#2b2766; --wall:#1e293b; --roof:#0f172a; --gr:#070b18; --win:#fbbf24; --glowO:.35; --starO:1; --moonO:1; --sunO:0; --sunY:240px; --cloudO:.12; }
    #{{ $uid }}[data-phase="feast"] { --sky1:#4c1d95; --sky2:#fbbf24; --wall:#fef3c7; --roof:#92400e; --gr:#1c1208; --win:#fff7ed; --glowO:1; --starO:.5; --moonO:0; --sunO:0; --sunY:240px; --cloudO:.3; }

    /* Kart */
    #{{ $uid }} .rjcd-card { position: relative; isolation: isolate; display: grid; grid-template-columns: 5fr 6fr; max-width: 980px; margin: 0 auto; border-radius: 26px; overflow: hidden; border: 1px solid rgba(255,255,255,.25); background: linear-gradient(180deg, var(--sky1), var(--sky2)); box-shadow: 0 24px 60px -24px rgba(2,6,23,.55); }
    #{{ $uid }} .rjcd-card.no-scene { grid-template-columns: 1fr; max-width: 520px; }
    #{{ $uid }}[data-side="right"] .rjcd-scene { order: 2; }

    #{{ $uid }} .rjcd-card::before,
    #{{ $uid }} .rjcd-card::after { content: ''; position: absolute; z-index: 0; border-radius: 50%; filter: blur(55px); pointer-events: none; animation: rjcd-float 16s ease-in-out infinite alternate; }
    #{{ $uid }} .rjcd-card::before { width: 280px; height: 280px; right: -70px; top: -70px; background: var(--acc); opacity: .45; }
    #{{ $uid }} .rjcd-card::after { width: 240px; height: 240px; left: 30%; bottom: -90px; background: #ec4899; opacity: .28; animation-duration: 20s; animation-direction: alternate-reverse; }

    /* Səhnə */
    #{{ $uid }} .rjcd-scene { position: relative; z-index: 1; min-height: 430px; overflow: hidden; }
    #{{ $uid }} .rjcd-svg { position: absolute; inset: 0; width: 100%; height: 100%; display: block; overflow: visible; }
    #{{ $uid }} .rjcd-g1 { stop-color: #fbbf24; stop-opacity: .6; }
    #{{ $uid }} .rjcd-g2 { stop-color: #fbbf24; stop-opacity: 0; }
    #{{ $uid }} .rjcd-gr { fill: var(--gr); transition: fill 2s; }
    #{{ $uid }} .rjcd-wall { fill: var(--wall); stroke: rgba(0,0,0,.18); stroke-width: 1; transition: fill 2s; }
    #{{ $uid }} .rjcd-roof { fill: var(--roof); transition: fill 2s; }
    #{{ $uid }} .rjcd-win { fill: var(--win); transition: fill 2s; }
    #{{ $uid }} .rjcd-sun { opacity: var(--sunO); transform: translateY(var(--sunY)); transition: transform 2.5s ease, opacity 2s ease; }
    #{{ $uid }} .rjcd-moon { opacity: var(--moonO); transition: opacity 2s ease; }
    #{{ $uid }} .rjcd-stars { opacity: var(--starO); transition: opacity 2s ease; }
    #{{ $uid }} .rjcd-clouds { opacity: var(--cloudO); transition: opacity 2s ease; }
    #{{ $uid }} .rjcd-star { fill: #fff; animation: rjcd-twinkle 3s ease-in-out infinite; }
    #{{ $uid }} .rjcd-cloud { fill: #fff; animation: rjcd-drift 75s linear infinite; }
    #{{ $uid }} .rjcd-cloud.c2 { animation-duration: 110s; animation-delay: -45s; }
    #{{ $uid }} .rjcd-sunhalo { transform-box: fill-box; transform-origin: center; animation: rjcd-pulse 6s ease-in-out infinite; }
    #{{ $uid }} .rjcd-halo { opacity: var(--glowO); transition: opacity 2s ease; transform-box: fill-box; transform-origin: center; animation: rjcd-pulse 5s ease-in-out infinite; }
    #{{ $uid }} .rjcd-bell { transform-box: fill-box; transform-origin: 50% 0; }
    #{{ $uid }}[data-phase="feast"] .rjcd-bell { animation: rjcd-ring 1.1s ease-in-out infinite alternate; }

    @keyframes rjcd-twinkle { 0%,100% { opacity: .2; } 50% { opacity: 1; } }
    @keyframes rjcd-drift { from { transform: translateX(-300px); } to { transform: translateX(700px); } }
    @keyframes rjcd-pulse { 0%,100% { transform: scale(.94); } 50% { transform: scale(1.08); } }
    @keyframes rjcd-ring { from { transform: rotate(-16deg); } to { transform: rotate(16deg); } }
    @keyframes rjcd-float { from { transform: translate(0,0) scale(1); } to { transform: translate(-40px,50px) scale(1.2); } }

    #{{ $uid }}[data-anim="0"] .rjcd-scene *, #{{ $uid }}[data-anim="0"] .rjcd-card::before, #{{ $uid }}[data-anim="0"] .rjcd-card::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjcd-scene *, #{{ $uid }} .rjcd-card::before, #{{ $uid }} .rjcd-card::after { animation: none !important; }
    }

    /* Şüşə panel */
    #{{ $uid }} .rjcd-info { position: relative; z-index: 1; min-width: 0; margin: 14px 14px 14px 0; padding: 20px; border-radius: 20px; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,.25);
        background: linear-gradient(145deg, rgba(255,255,255,.18), rgba(255,255,255,.04)), rgba(15,23,42,.30);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.28); box-shadow: 0 12px 40px rgba(2,6,23,.3), inset 0 1px 0 rgba(255,255,255,.4); }
    #{{ $uid }}[data-style="glass-dark"] .rjcd-info { background: linear-gradient(145deg, rgba(255,255,255,.1), rgba(255,255,255,.02)), rgba(8,12,28,.55); border-color: rgba(255,255,255,.18); }
    #{{ $uid }}[data-side="right"] .rjcd-info { margin: 14px 0 14px 14px; }
    #{{ $uid }} .rjcd-card.no-scene .rjcd-info { margin: 14px; }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) {
        #{{ $uid }} .rjcd-info { background: rgba(15,23,42,.72); }
    }

    #{{ $uid }} .rjcd-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    #{{ $uid }} .rjcd-title { margin: 0; font-size: 1.15rem; font-weight: 800; color: #fff; }
    #{{ $uid }} .rjcd-place { display: flex; align-items: center; gap: 4px; margin-top: 3px; font-size: .82rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .rjcd-place svg { width: 13px; height: 13px; flex: none; }
    #{{ $uid }} .rjcd-clock { flex: none; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.25); font-size: .95rem; font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
    #{{ $uid }} .rjcd-dates { margin: 10px 0 14px; font-size: .8rem; color: rgba(255,255,255,.75); }

    /* Növbəti bayram */
    #{{ $uid }} .rjcd-next { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; margin-bottom: 12px; border-radius: 16px; color: #fff;
        background: linear-gradient(135deg, color-mix(in srgb, var(--acc) 90%, transparent), color-mix(in srgb, var(--acc) 50%, #0ea5e9));
        border: 1px solid rgba(255,255,255,.35); box-shadow: 0 10px 28px -10px var(--acc), inset 0 1px 0 rgba(255,255,255,.35); }
    #{{ $uid }} .rjcd-next-txt { min-width: 0; }
    #{{ $uid }} .rjcd-next-lbl { font-size: .8rem; font-weight: 600; opacity: .92; }
    #{{ $uid }} .rjcd-count { margin-top: 2px; font-size: 1.9rem; font-weight: 800; letter-spacing: .02em; line-height: 1.2; }
    #{{ $uid }} .rjcd-ring { flex: none; width: 58px; height: 58px; }
    #{{ $uid }} .rjcd-ring .bg { fill: none; stroke: rgba(255,255,255,.28); stroke-width: 5; }
    #{{ $uid }} .rjcd-ring .fg { fill: none; stroke: #fff; stroke-width: 5; stroke-linecap: round; stroke-dasharray: 163.36; stroke-dashoffset: 163.36; transition: stroke-dashoffset 1s linear; }

    /* Siyahı */
    #{{ $uid }} .rjcd-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 5px; }
    #{{ $uid }} .rjcd-list li { display: grid; grid-template-columns: 10px 1fr auto; align-items: center; gap: 12px; padding: 9px 12px; border-radius: 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); font-size: .95rem; transition: background .3s, border-color .3s, transform .2s; }
    #{{ $uid }} .rjcd-list li[hidden] { display: none; }
    #{{ $uid }} .rjcd-list li:hover { transform: translateX(3px); background: rgba(255,255,255,.14); }
    #{{ $uid }} .rjcd-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.35); }
    #{{ $uid }} .rjcd-list li.is-major .rjcd-dot { background: var(--acc); box-shadow: 0 0 0 3px rgba(255,255,255,.35); }
    #{{ $uid }} .rjcd-what { min-width: 0; display: flex; flex-direction: column; line-height: 1.25; }
    #{{ $uid }} .rjcd-what b { font-weight: 700; }
    #{{ $uid }} .rjcd-what small { font-size: .74rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .rjcd-badge { font-size: .78rem; font-weight: 600; white-space: nowrap; padding: 3px 9px; border-radius: 999px; background: rgba(255,255,255,.14); }
    #{{ $uid }} .rjcd-list li.is-next { background: color-mix(in srgb, var(--acc) 45%, transparent); border-color: rgba(255,255,255,.5); }
    #{{ $uid }} .rjcd-list li.is-next .rjcd-dot { background: #fff; box-shadow: 0 0 0 4px rgba(255,255,255,.28); }
    #{{ $uid }} .rjcd-list li.is-next .rjcd-badge { background: rgba(255,255,255,.25); }

    #{{ $uid }} .rjcd-error { max-width: 520px; margin: 0 auto; padding: 20px; text-align: center; border-radius: 16px; background: rgba(15,23,42,.88); color: #e2e8f0; font-size: .9rem; }

    /* Mobil */
    @media (max-width: 760px) {
        #{{ $uid }} { padding: 12px 8px; }
        #{{ $uid }} .rjcd-card { grid-template-columns: 1fr; border-radius: 22px; }
        #{{ $uid }}[data-side="right"] .rjcd-scene { order: 0; }
        #{{ $uid }} .rjcd-scene { min-height: 0; height: 270px; }
        #{{ $uid }} .rjcd-info,
        #{{ $uid }}[data-side="right"] .rjcd-info { margin: -34px 10px 10px; padding: 16px 14px 14px; }
        #{{ $uid }} .rjcd-card.no-scene .rjcd-info { margin: 10px; }
        #{{ $uid }} .rjcd-count { font-size: 1.65rem; }
        #{{ $uid }} .rjcd-ring { width: 50px; height: 50px; }
        #{{ $uid }} .rjcd-list li { grid-template-columns: 1fr auto; gap: 8px; padding: 9px 10px; }
        #{{ $uid }} .rjcd-list li:hover { transform: none; }
        #{{ $uid }} .rjcd-dot { display: none; }
        #{{ $uid }} .rjcd-list li.is-major { border-color: rgba(255,255,255,.35); }
    }
</style>

@if ($error)
    <section id="{{ $uid }}" data-style="{{ $o['style'] }}"><div class="rjcd-error">{{ $error }}</div></section>
@else
@php
    $stars = [[24,30],[70,64],[118,24],[160,70],[210,36],[250,86],[300,28],[330,70],[48,110],[96,140],[236,130],[320,120],[190,100],[-30,60],[-60,120],[390,50],[420,110],[-10,20],[375,150]];
@endphp

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-side="{{ $o['side'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-phase="day">
    <div class="rjcd-card {{ $o['scene'] ? '' : 'no-scene' }}">

        @if ($o['scene'])
            <div class="rjcd-scene" aria-hidden="true">
                <svg class="rjcd-svg" viewBox="0 20 360 380" preserveAspectRatio="xMidYMax meet" focusable="false">
                    <defs>
                        <radialGradient id="{{ $uid }}-glow"><stop offset="0" class="rjcd-g1"/><stop offset="1" class="rjcd-g2"/></radialGradient>
                    </defs>

                    <g class="rjcd-stars">
                        @foreach ($stars as $i => $s)
                            <circle class="rjcd-star" cx="{{ $s[0] }}" cy="{{ $s[1] }}" r="{{ $i % 3 === 0 ? 1.8 : 1.2 }}" style="animation-delay: {{ number_format($i * 0.37, 2) }}s"/>
                        @endforeach
                    </g>

                    <g class="rjcd-moon">
                        <circle cx="290" cy="66" r="26" fill="#fef3c7"/>
                        <circle cx="282" cy="58" r="5" fill="#fde68a" opacity=".6"/>
                        <circle cx="298" cy="74" r="3.500" fill="#fde68a" opacity=".6"/>
                    </g>

                    <g class="rjcd-sun">
                        <circle class="rjcd-sunhalo" cx="70" cy="96" r="46" fill="#fde68a" opacity=".3"/>
                        <circle cx="70" cy="96" r="26" fill="#fde68a"/>
                    </g>

                    <g class="rjcd-clouds">
                        <g transform="translate(0,92)"><g class="rjcd-cloud"><ellipse cx="0" cy="0" rx="34" ry="11"/><ellipse cx="-18" cy="-6" rx="18" ry="10"/><ellipse cx="16" cy="-8" rx="20" ry="11"/></g></g>
                        <g transform="translate(0,150)"><g class="rjcd-cloud c2"><ellipse cx="0" cy="0" rx="28" ry="9"/><ellipse cx="-14" cy="-5" rx="15" ry="8"/><ellipse cx="14" cy="-6" rx="16" ry="9"/></g></g>
                    </g>

                    {{-- Bayram işığı --}}
                    <circle class="rjcd-halo" cx="170" cy="230" r="150" fill="url(#{{ $uid }}-glow)"/>

                    {{-- Zəng qülləsi --}}
                    <rect class="rjcd-wall" x="225" y="168" width="56" height="172"/>
                    <path class="rjcd-roof" d="M218 170 L253 102 L288 170Z"/>
                    <path d="M240 216 v-24 a13 13 0 0 1 26 0 v24z" fill="#0f172a" opacity=".85"/>
                    <g class="rjcd-bell"><path d="M247 214 q0 -14 6 -17 q6 3 6 17z" fill="#fbbf24"/><circle cx="253" cy="215" r="2" fill="#92400e"/></g>
                    <rect class="rjcd-win" x="249" y="244" width="8" height="22" rx="4"/>
                    <rect class="rjcd-win" x="249" y="284" width="8" height="22" rx="4"/>

                    {{-- Xaç --}}
                    <g stroke="#fbbf24" stroke-width="2.200" stroke-linecap="round" fill="none">
                        <line x1="253" y1="102" x2="253" y2="72"/>
                        <line x1="245" y1="82" x2="261" y2="82"/>
                        @if ($o['orthodox'])
                            <line x1="248" y1="76" x2="258" y2="76"/>
                            <line x1="248" y1="94" x2="258" y2="90"/>
                        @endif
                    </g>

                    {{-- Nef --}}
                    <rect class="rjcd-wall" x="70" y="250" width="170" height="90"/>
                    <path class="rjcd-roof" d="M62 252 L155 196 L248 252Z"/>
                    <circle class="rjcd-win" cx="155" cy="232" r="14"/>
                    <g stroke="#0f172a" stroke-opacity=".35" stroke-width="1.200">
                        <line x1="141" y1="232" x2="169" y2="232"/>
                        <line x1="155" y1="218" x2="155" y2="246"/>
                        <line x1="145" y1="222" x2="165" y2="242"/>
                        <line x1="165" y1="222" x2="145" y2="242"/>
                    </g>
                    <path class="rjcd-win" d="M88 330 v-30 a9 9 0 0 1 18 0 v30z"/>
                    <path class="rjcd-win" d="M204 330 v-30 a9 9 0 0 1 18 0 v30z"/>
                    <path d="M138 340 v-34 a17 17 0 0 1 34 0 v34z" fill="#3b2a1a"/>
                    <path d="M155 289 v51" stroke="#000" stroke-opacity=".3" stroke-width="1"/>

                    <rect class="rjcd-gr" x="-900" y="340" width="2160" height="220"/>
                </svg>
            </div>
        @endif

        <div class="rjcd-info">
            <div class="rjcd-head">
                <div>
                    @if ($o['title'] !== '')<h4 class="rjcd-title">{{ $o['title'] }}</h4>@endif
                    <div class="rjcd-place">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M7 8h10"/></svg>
                        <span>{{ $o['tradition_label'] }}</span>
                    </div>
                </div>
                <div class="rjcd-clock" data-el="clock">--:--</div>
            </div>

            <div class="rjcd-dates"><span data-el="greg"></span></div>

            @if ($o['countdown'])
                <div class="rjcd-next">
                    <div class="rjcd-next-txt">
                        <div class="rjcd-next-lbl" data-el="nextlbl">&nbsp;</div>
                        <div class="rjcd-count" data-el="count" role="timer" aria-live="off">--</div>
                    </div>
                    <svg class="rjcd-ring" viewBox="0 0 64 64" aria-hidden="true">
                        <circle class="bg" cx="32" cy="32" r="26"/>
                        <circle class="fg" data-el="ring" cx="32" cy="32" r="26" transform="rotate(-90 32 32)"/>
                    </svg>
                </div>
            @endif

            <ul class="rjcd-list" data-el="list"></ul>
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
        li.appendChild(mk('span', 'rjcd-dot'));
        var what = mk('span', 'rjcd-what');
        what.appendChild(mk('b', '', it.name));
        what.appendChild(mk('small', '', fmtDate(it.date)));
        li.appendChild(what);
        var badge = mk('span', 'rjcd-badge', '');
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
