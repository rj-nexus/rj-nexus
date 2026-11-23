<style>
    #{{ $uid }} { --acc: {{ $o['accent'] }}; width: 100%; padding: 24px 12px; box-sizing: border-box; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .cf-card { position: relative; isolation: isolate; max-width: 560px; margin: 0 auto; border-radius: 26px; overflow: hidden; color: #fff; padding: 20px;
        background: linear-gradient(160deg, #991b1b, #7f1d1d 55%, #450a0a); border: 1px solid rgba(250,204,21,.35); box-shadow: 0 24px 60px -24px rgba(69,10,10,.7); }
    #{{ $uid }}[data-style="dark"] .cf-card { background: linear-gradient(160deg, #1c1917, #0c0a09); border-color: rgba(255,255,255,.15); }
    #{{ $uid }} .cf-card::before { content: ''; position: absolute; z-index: -1; width: 260px; height: 260px; right: -80px; top: -80px; border-radius: 50%; background: var(--acc); opacity: .25; filter: blur(60px); animation: cf-float 16s ease-in-out infinite alternate; }

    /* Fənərlər */
    #{{ $uid }} .cf-lanterns { position: absolute; top: 0; right: 18px; display: flex; gap: 10px; pointer-events: none; }
    #{{ $uid }} .cf-lan { transform-origin: 50% 0; animation: cf-sway 4s ease-in-out infinite alternate; }
    #{{ $uid }} .cf-lan:nth-child(2) { animation-delay: -1.5s; animation-duration: 5s; }
    #{{ $uid }} .cf-lan i { display: block; width: 1px; height: 14px; margin: 0 auto; background: var(--acc); }
    #{{ $uid }} .cf-lan b { display: block; width: 26px; height: 32px; border-radius: 50%; background: radial-gradient(circle at 50% 40%, #ef4444, #b91c1c); border-top: 3px solid var(--acc); border-bottom: 3px solid var(--acc); box-shadow: 0 0 18px rgba(239,68,68,.7); }
    #{{ $uid }} .cf-lan:nth-child(2) b { width: 20px; height: 26px; }
    @keyframes cf-sway { from { transform: rotate(-6deg); } to { transform: rotate(6deg); } }
    @keyframes cf-float { from { transform: translate(0,0) scale(1); } to { transform: translate(-40px,50px) scale(1.2); } }
    #{{ $uid }}[data-anim="0"] .cf-lan, #{{ $uid }}[data-anim="0"] .cf-card::before { animation: none !important; }
    @media (prefers-reduced-motion: reduce) { #{{ $uid }} .cf-lan, #{{ $uid }} .cf-card::before { animation: none !important; } }

    #{{ $uid }} .cf-head { padding-right: 90px; }
    #{{ $uid }} .cf-title { margin: 0; font-size: 1.4rem; font-weight: 800; color: var(--acc); letter-spacing: .04em; }
    #{{ $uid }} .cf-clock { margin-top: 4px; font-size: .85rem; color: rgba(255,255,255,.8); font-variant-numeric: tabular-nums; }

    #{{ $uid }} .cf-today { margin-top: 14px; padding: 14px 16px; border-radius: 16px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); }
    #{{ $uid }} .cf-lunar { font-size: 1.5rem; font-weight: 800; }
    #{{ $uid }} .cf-sub { margin-top: 2px; font-size: .8rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .cf-yj { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px; }
    #{{ $uid }} .cf-yj div { font-size: .8rem; line-height: 1.5; }
    #{{ $uid }} .cf-yj b { display: inline-grid; place-items: center; width: 22px; height: 22px; margin-right: 6px; border-radius: 6px; font-size: .8rem; }
    #{{ $uid }} .cf-yj .y b { background: #16a34a; }
    #{{ $uid }} .cf-yj .j b { background: #475569; }
    #{{ $uid }} .cf-yj span { color: rgba(255,255,255,.85); }
    #{{ $uid }} .cf-hour { margin-top: 12px; padding-top: 10px; border-top: 1px dashed rgba(255,255,255,.25); font-size: .85rem; }
    #{{ $uid }} .cf-hour b { color: var(--acc); font-size: 1.1rem; }

    #{{ $uid }} .cf-next { margin-top: 14px; padding: 14px 16px; border-radius: 16px; color: #450a0a; background: linear-gradient(135deg, var(--acc), #f59e0b); box-shadow: 0 10px 28px -10px var(--acc); }
    #{{ $uid }} .cf-next-lbl { font-size: .8rem; font-weight: 700; }
    #{{ $uid }} .cf-next-zh { font-size: 1.3rem; font-weight: 800; }
    #{{ $uid }} .cf-count { margin-top: 2px; font-size: 1.7rem; font-weight: 800; font-variant-numeric: tabular-nums; }

    #{{ $uid }} .cf-list { list-style: none; margin: 14px 0 0; padding: 0; display: flex; flex-direction: column; gap: 5px; }
    #{{ $uid }} .cf-list li { display: grid; grid-template-columns: 1fr auto; gap: 10px; align-items: center; padding: 9px 12px; border-radius: 12px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); }
    #{{ $uid }} .cf-list li.is-next { border-color: var(--acc); background: rgba(250,204,21,.15); }
    #{{ $uid }} .cf-nm { display: flex; flex-direction: column; line-height: 1.25; min-width: 0; }
    #{{ $uid }} .cf-nm b { font-size: 1rem; }
    #{{ $uid }} .cf-nm small { font-size: .74rem; color: rgba(255,255,255,.75); }
    #{{ $uid }} .cf-dt { font-size: .82rem; text-align: right; line-height: 1.25; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .cf-dt i { display: block; font-style: normal; font-size: .7rem; color: rgba(255,255,255,.7); }

    #{{ $uid }} .cf-error { max-width: 520px; margin: 0 auto; padding: 20px; text-align: center; border-radius: 16px; background: rgba(15,23,42,.88); color: #e2e8f0; font-size: .9rem; }

    @media (max-width: 520px) { #{{ $uid }} .cf-yj { grid-template-columns: 1fr; } #{{ $uid }} .cf-count { font-size: 1.45rem; } }
</style>

@if ($error)
    <section id="{{ $uid }}"><div class="cf-error">{{ $error }}</div></section>
@else
<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}">
    <div class="cf-card">
        <div class="cf-lanterns" aria-hidden="true">
            <div class="cf-lan"><i></i><b></b></div>
            <div class="cf-lan"><i></i><b></b></div>
        </div>

        <div class="cf-head">
            @if ($o['title'] !== '')<h4 class="cf-title">{{ $o['title'] }}</h4>@endif
            <div class="cf-clock" data-el="clock">--:--</div>
        </div>

        @if ($payload['today'])
            <div class="cf-today">
                <div class="cf-lunar">{{ $payload['today_info']['lunar'] }}</div>
                <div class="cf-sub">{{ $payload['today_info']['ganzhi'] }} · {{ $payload['today_info']['zodiac'] }}
                    @if ($payload['today_info']['term']) · {{ $payload['labels']['term'] }}: {{ $payload['today_info']['term']['zh'] }} ({{ $payload['today_info']['term']['date'] }})@endif
                </div>

                @if ($payload['yiji'])
                    <div class="cf-yj">
                        <div class="y"><b>宜</b><span>{{ implode(' ', $payload['today_info']['yi']) ?: '—' }}</span></div>
                        <div class="j"><b>忌</b><span>{{ implode(' ', $payload['today_info']['ji']) ?: '—' }}</span></div>
                    </div>
                @endif

                @if ($payload['shichen'])
                    <div class="cf-hour">{{ $payload['labels']['hour'] }}: <b data-el="shichen">—</b> <span data-el="shirange"></span></div>
                @endif
            </div>
        @endif

        @if ($o['countdown'])
            <div class="cf-next">
                <div class="cf-next-lbl" data-el="nextlbl">&nbsp;</div>
                <div class="cf-next-zh" data-el="nextzh"></div>
                <div class="cf-count" data-el="count" role="timer" aria-live="off">--</div>
            </div>
        @endif

        <ul class="cf-list" data-el="list"></ul>
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
    if (!D || !D.items) { return; }

    var tz = D.tz;
    try { new Intl.DateTimeFormat('en', { timeZone: tz }); } catch (e) { tz = 'UTC'; }

    var L = D.labels;
    var lang = document.documentElement.lang || navigator.language || 'en';
    var DAY = 86400000;

    var ZHI = ['子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥'];
    var ANI = ['鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪'];

    function el(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var elClock = el('clock'), elCount = el('count'), elLbl = el('nextlbl'), elZh = el('nextzh'),
        elList = el('list'), elSh = el('shichen'), elShR = el('shirange');

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
    function fmtHMS(p) {
        var h = (+p.hour) % 24;
        if (D.fmt !== '12') { return pad(h) + ':' + p.minute + ':' + p.second; }
        return (h % 12 || 12) + ':' + p.minute + ':' + p.second + ' ' + (h < 12 ? 'AM' : 'PM');
    }
    function fmtDate(k) {
        var a = k.split('-');
        try {
            return new Intl.DateTimeFormat(lang, { timeZone: 'UTC', weekday: 'short', day: 'numeric', month: 'long', year: 'numeric' })
                .format(new Date(Date.UTC(+a[0], +a[1] - 1, +a[2], 12)));
        } catch (e) { return k; }
    }
    function mk(tag, cls, txt) {
        var n = document.createElement(tag);
        if (cls) { n.className = cls; }
        if (txt != null) { n.textContent = txt; }
        return n;
    }

    var rows = D.items.map(function (it) {
        var li = mk('li');
        var nm = mk('span', 'cf-nm');
        nm.appendChild(mk('b', '', it.zh + (D.pinyin ? '  ' + it.py : '')));
        nm.appendChild(mk('small', '', it.name));
        li.appendChild(nm);
        var dt = mk('span', 'cf-dt', fmtDate(it.date));
        var left = mk('i', '', '');
        dt.appendChild(left);
        li.appendChild(dt);
        elList.appendChild(li);
        return { li: li, left: left };
    });

    function tick() {
        var now = Date.now();
        var p = parts(now);
        var hour = (+p.hour) % 24;
        var min = +p.minute;
        var todayKey = p.year + '-' + p.month + '-' + p.day;

        if (elClock) { elClock.textContent = fmtHMS(p); }

        // Shi Chen: 子 23:00–00:59, 丑 01:00–02:59 ...
        if (elSh) {
            var idx = Math.floor(((hour + 1) % 24) / 2);
            var s = (idx * 2 + 23) % 24, e = (s + 2) % 24;
            elSh.textContent = ZHI[idx] + '时 · ' + ANI[idx];
            if (elShR) { elShR.textContent = pad(s) + ':00–' + pad(e) + ':00'; }
        }

        var nextIdx = -1;
        D.items.forEach(function (it, i) {
            var days = Math.round((it.ts - Date.parse(todayKey + 'T00:00:00Z') + (it.ts - it.ts)) / DAY);
            var a = it.date.split('-'), b = todayKey.split('-');
            days = Math.round((Date.UTC(+a[0], +a[1] - 1, +a[2]) - Date.UTC(+b[0], +b[1] - 1, +b[2])) / DAY);
            rows[i].left.textContent = days === 0 ? L.now : days + ' ' + L.days;
            if (nextIdx < 0 && days >= 0) { nextIdx = i; }
            rows[i].li.classList.toggle('is-next', i === nextIdx);
        });

        if (elCount && nextIdx >= 0) {
            var it = D.items[nextIdx];
            var diff = it.ts - now;
            elZh.textContent = it.zh + ' · ' + it.name;
            if (diff <= 0) {
                elLbl.textContent = L.today;
                elCount.textContent = L.now;
            } else {
                var s2 = Math.floor(diff / 1000);
                var d = Math.floor(s2 / 86400), r = s2 % 86400;
                elLbl.textContent = L.until;
                elCount.textContent = d + 'd ' + pad(Math.floor(r / 3600)) + ':' + pad(Math.floor((r % 3600) / 60)) + ':' + pad(r % 60);
            }
        }
    }

    tick();
    setInterval(tick, 1000);
    document.addEventListener('visibilitychange', function () { if (!document.hidden) { tick(); } });
})();
</script>
@endif
