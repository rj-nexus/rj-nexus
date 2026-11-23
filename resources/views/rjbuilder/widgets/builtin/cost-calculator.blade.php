<style>
    #{{ $uid }} { --fg: #fff; --mut: rgba(255,255,255,.64); --line: rgba(255,255,255,.14); --card: rgba(255,255,255,.06); --inp: rgba(255,255,255,.08); --bg: #0b1030; --optbg: #151a3a;
        position: relative; isolation: isolate; max-width: 1100px; margin: 0 auto; padding: clamp(18px, 4vw, 38px); box-sizing: border-box; border-radius: 28px; overflow: hidden; overflow: clip;
        color: var(--fg); font-family: inherit; border: 1px solid var(--line); -webkit-tap-highlight-color: transparent;
        background: radial-gradient(ellipse at 0 0, color-mix(in srgb, var(--acc) 30%, transparent), transparent 55%), radial-gradient(ellipse at 100% 100%, color-mix(in srgb, var(--acc2) 24%, transparent), transparent 55%), var(--bg); }
    #{{ $uid }}[data-theme="light"] { --fg: #0f172a; --mut: #64748b; --line: rgba(15,23,42,.12); --card: #f8fafc; --inp: #fff; --bg: #fff; --optbg: #fff;
        background: radial-gradient(ellipse at 0 0, color-mix(in srgb, var(--acc) 14%, transparent), transparent 55%), radial-gradient(ellipse at 100% 100%, color-mix(in srgb, var(--acc2) 12%, transparent), transparent 55%), var(--bg); }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }

    #{{ $uid }} .cc-top { margin-bottom: clamp(16px, 3vw, 26px); animation: cc-in .6s cubic-bezier(.2,.9,.2,1) both; }
    #{{ $uid }} .cc-title { margin: 0; font-size: clamp(1.4rem, 4.6vw, 2.1rem); font-weight: 800; line-height: 1.15; background: linear-gradient(90deg, var(--fg), color-mix(in srgb, var(--fg) 55%, var(--acc))); -webkit-background-clip: text; background-clip: text; color: transparent; }
    #{{ $uid }} .cc-sub { margin: 8px 0 0; font-size: .98rem; color: var(--mut); }
    #{{ $uid }} .cc-grid { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr); gap: 22px; align-items: start; }
    #{{ $uid }} .cc-rows { display: grid; gap: 12px; min-width: 0; }

    #{{ $uid }} .cc-row { padding: 16px 18px; border-radius: 20px; background: var(--card); border: 1px solid var(--line); transition: border-color .3s, box-shadow .3s, transform .3s; animation: cc-in .55s cubic-bezier(.2,.9,.2,1) both; animation-delay: calc(var(--i, 0) * 70ms + 80ms); }
    #{{ $uid }} .cc-row:hover, #{{ $uid }} .cc-row:focus-within { border-color: color-mix(in srgb, var(--acc) 65%, transparent); box-shadow: 0 10px 30px -18px var(--acc); }
    #{{ $uid }} .cc-row.on { border-color: color-mix(in srgb, var(--acc) 80%, transparent); box-shadow: 0 10px 34px -16px var(--acc); }
    #{{ $uid }} .cc-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    #{{ $uid }} .cc-lw { flex: 1 1 150px; min-width: 0; display: grid; gap: 2px; }
    #{{ $uid }} .cc-label { font-weight: 700; font-size: 1rem; line-height: 1.3; }
    #{{ $uid }} .cc-hint { font-size: .78rem; font-weight: 600; color: var(--mut); }
    #{{ $uid }} .cc-val { display: flex; align-items: center; gap: 8px; }
    #{{ $uid }} .cc-unit { font-size: .82rem; font-weight: 600; color: var(--mut); }
    #{{ $uid }} .cc-num { width: 92px; padding: 9px 10px; border-radius: 12px; border: 1px solid var(--line); background: var(--inp); color: var(--fg); font: inherit; font-size: 16px; font-weight: 800; text-align: center; outline: none; -moz-appearance: textfield; appearance: textfield; transition: border-color .2s, box-shadow .2s; }
    #{{ $uid }} .cc-num::-webkit-outer-spin-button, #{{ $uid }} .cc-num::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    #{{ $uid }} .cc-num:focus { border-color: var(--acc); box-shadow: 0 0 0 4px color-mix(in srgb, var(--acc) 25%, transparent); }
    #{{ $uid }} .cc-step { appearance: none; display: grid; place-items: center; width: 40px; height: 40px; padding: 0; border-radius: 50%; cursor: pointer; color: var(--fg); font: inherit; font-size: 1.3rem; font-weight: 700; line-height: 1; background: var(--inp); border: 1px solid var(--line); transition: transform .2s cubic-bezier(.34,1.56,.64,1), background .2s, border-color .2s; }
    #{{ $uid }} .cc-step:hover, #{{ $uid }} .cc-step:focus-visible { transform: scale(1.1); border-color: var(--acc); outline: none; }
    #{{ $uid }} .cc-step:active { transform: scale(.92); }

    #{{ $uid }} .cc-range { --trk: linear-gradient(90deg, var(--acc), var(--acc2) calc(14px + var(--p, 0) * (100% - 28px)), var(--line) calc(14px + var(--p, 0) * (100% - 28px)));
        -webkit-appearance: none; appearance: none; display: block; width: 100%; height: 28px; margin: 12px 0 0; background: transparent; cursor: pointer; outline: none; touch-action: pan-y; }
    #{{ $uid }} .cc-range::-webkit-slider-runnable-track { height: 10px; border-radius: 99px; background: var(--trk); }
    #{{ $uid }} .cc-range::-moz-range-track { height: 10px; border-radius: 99px; background: var(--trk); }
    #{{ $uid }} .cc-range::-webkit-slider-thumb { -webkit-appearance: none; width: 28px; height: 28px; margin-top: -9px; border-radius: 50%; background: #fff; border: 6px solid var(--acc2); box-shadow: 0 6px 16px rgba(0,0,0,.35), 0 0 0 0 color-mix(in srgb, var(--acc2) 40%, transparent); transition: transform .2s, box-shadow .2s; }
    #{{ $uid }} .cc-range::-moz-range-thumb { width: 16px; height: 16px; border-radius: 50%; background: #fff; border: 6px solid var(--acc2); box-shadow: 0 6px 16px rgba(0,0,0,.35); }
    #{{ $uid }} .cc-range:active::-webkit-slider-thumb { transform: scale(1.18); box-shadow: 0 6px 16px rgba(0,0,0,.35), 0 0 0 8px color-mix(in srgb, var(--acc2) 30%, transparent); }
    #{{ $uid }} .cc-range:focus-visible::-webkit-slider-thumb { box-shadow: 0 6px 16px rgba(0,0,0,.35), 0 0 0 6px color-mix(in srgb, var(--acc) 40%, transparent); }
    #{{ $uid }} .cc-scale { display: flex; justify-content: space-between; margin-top: 2px; font-size: .72rem; font-weight: 700; color: var(--mut); }

    #{{ $uid }} .cc-sw { display: flex; align-items: center; gap: 14px; cursor: pointer; user-select: none; }
    #{{ $uid }} .cc-sw input { position: absolute; opacity: 0; pointer-events: none; }
    #{{ $uid }} .cc-tr { flex: none; position: relative; width: 52px; height: 30px; border-radius: 99px; background: var(--line); transition: background .3s; }
    #{{ $uid }} .cc-tr::after { content: ''; position: absolute; top: 3px; left: 3px; width: 24px; height: 24px; border-radius: 50%; background: #fff; box-shadow: 0 3px 8px rgba(0,0,0,.35); transition: transform .35s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .cc-sw input:checked + .cc-tr { background: linear-gradient(135deg, var(--acc), var(--acc2)); }
    #{{ $uid }} .cc-sw input:checked + .cc-tr::after { transform: translateX(22px); }
    #{{ $uid }} .cc-sw input:focus-visible + .cc-tr { outline: 2px solid var(--acc); outline-offset: 3px; }
    #{{ $uid }} .cc-sw .cc-lw { flex: 1; }

    #{{ $uid }} .cc-sel { position: relative; margin-top: 12px; }
    #{{ $uid }} .cc-sel::after { content: ''; position: absolute; right: 18px; top: 50%; width: 8px; height: 8px; border: solid var(--fg); border-width: 0 2px 2px 0; transform: translateY(-70%) rotate(45deg); pointer-events: none; transition: transform .3s; }
    #{{ $uid }} .cc-sel:focus-within::after { transform: translateY(-30%) rotate(225deg); }
    #{{ $uid }} .cc-select { -webkit-appearance: none; appearance: none; width: 100%; padding: 13px 44px 13px 16px; border-radius: 14px; border: 1px solid var(--line); background: var(--inp); color: var(--fg); font: inherit; font-size: 16px; font-weight: 600; cursor: pointer; outline: none; transition: border-color .2s, box-shadow .2s; }
    #{{ $uid }} .cc-select:focus { border-color: var(--acc); box-shadow: 0 0 0 4px color-mix(in srgb, var(--acc) 25%, transparent); }
    #{{ $uid }} .cc-select option { background: var(--optbg); color: var(--fg); }

    #{{ $uid }} .cc-result { --r: 0; position: sticky; top: 20px; isolation: isolate; overflow: hidden; padding: 22px; border-radius: 26px; background: linear-gradient(145deg, rgba(255,255,255,.1), rgba(255,255,255,.02)), var(--card); border: 1px solid var(--line); box-shadow: 0 26px 60px -30px var(--acc); animation: cc-in .7s cubic-bezier(.2,.9,.2,1) .2s both; }
    #{{ $uid }}[data-theme="light"] .cc-result { background: linear-gradient(145deg, #fff, #f1f5f9); }
    #{{ $uid }} .cc-orb { position: absolute; z-index: -1; left: 50%; top: 4%; width: 74%; aspect-ratio: 1; border-radius: 50%; opacity: .5; filter: blur(48px); background: radial-gradient(circle at 35% 35%, var(--acc), var(--acc2) 60%, transparent 75%); transform: translateX(-50%) scale(calc(.55 + var(--r) * .95)); transition: transform .9s cubic-bezier(.2,.9,.2,1); animation: cc-float 7s ease-in-out infinite alternate; }
    #{{ $uid }} .cc-resin { display: grid; gap: 14px; justify-items: center; text-align: center; }
    #{{ $uid }} .cc-lbl { font-size: .74rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: var(--mut); }
    #{{ $uid }} .cc-ringwrap { position: relative; width: min(100%, 210px); aspect-ratio: 1; }
    #{{ $uid }} .cc-ringwrap svg { display: block; width: 100%; height: 100%; transform: rotate(-90deg); overflow: visible; }
    #{{ $uid }} .cc-track { fill: none; stroke: var(--line); stroke-width: 8; }
    #{{ $uid }} .cc-prog { fill: none; stroke-width: 8; stroke-linecap: round; transition: stroke-dashoffset .9s cubic-bezier(.2,.9,.2,1); filter: drop-shadow(0 0 8px var(--acc)); }
    #{{ $uid }} .cc-dash { fill: none; stroke: var(--acc2); stroke-width: 1; stroke-dasharray: 2 7; opacity: .7; transform-origin: 60px 60px; animation: cc-spin 24s linear infinite; }
    #{{ $uid }} .cc-total { position: absolute; inset: 0; display: grid; place-items: center; padding: 0 20px; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; word-break: keep-all; white-space: nowrap; }
    #{{ $uid }} .cc-total.bump { animation: cc-bump .45s cubic-bezier(.34,1.56,.64,1); }

    #{{ $uid }} .cc-bar { display: flex; gap: 3px; width: 100%; height: 10px; border-radius: 99px; overflow: hidden; background: var(--line); }
    #{{ $uid }} .cc-seg { flex: 1 1 0; min-width: 0; transition: flex-grow .6s cubic-bezier(.2,.9,.2,1); animation: cc-grow .5s ease both; }
    #{{ $uid }} .cc-list { width: 100%; margin: 0; padding: 0; list-style: none; text-align: left; }
    #{{ $uid }} .cc-list li { display: grid; grid-template-columns: auto minmax(0, 1fr) auto; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px dashed var(--line); font-size: .9rem; max-height: 60px; overflow: hidden; animation: cc-li .4s ease both; }
    #{{ $uid }} .cc-list li.out { animation: cc-out .3s ease forwards; }
    #{{ $uid }} .cc-dot { width: 10px; height: 10px; border-radius: 50%; }
    #{{ $uid }} .cc-n { overflow: hidden; text-overflow: ellipsis; color: var(--mut); font-weight: 600; }
    #{{ $uid }} .cc-a { font-weight: 800; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .cc-note { margin: 0; font-size: .8rem; color: var(--mut); }

    #{{ $uid }} .cc-btn { position: relative; overflow: hidden; appearance: none; width: 100%; padding: 15px 20px; border: 0; border-radius: 99px; cursor: pointer; font: inherit; font-size: 1rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--acc), var(--acc2)); box-shadow: 0 16px 36px -14px var(--acc); transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s, filter .25s; }
    #{{ $uid }} .cc-btn:hover, #{{ $uid }} .cc-btn:focus-visible { transform: translateY(-3px) scale(1.02); filter: brightness(1.1); outline: none; }
    #{{ $uid }} .cc-btn:active { transform: scale(.97); }
    #{{ $uid }} .cc-btn:disabled { opacity: .6; cursor: default; transform: none; }
    #{{ $uid }} .cc-btn::after { content: ''; position: absolute; top: 0; bottom: 0; width: 40%; left: -60%; transform: skewX(-20deg); background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent); animation: cc-shine 3.6s ease-in-out infinite; }

    #{{ $uid }} .cc-form { display: grid; gap: 10px; width: 100%; text-align: left; animation: cc-in .45s cubic-bezier(.2,.9,.2,1) both; }
    #{{ $uid }} .cc-field { width: 100%; padding: 13px 14px; border-radius: 14px; border: 1px solid var(--line); background: var(--inp); color: var(--fg); font: inherit; font-size: 16px; outline: none; resize: vertical; transition: border-color .2s, box-shadow .2s; }
    #{{ $uid }} .cc-field:focus { border-color: var(--acc); box-shadow: 0 0 0 4px color-mix(in srgb, var(--acc) 25%, transparent); }
    #{{ $uid }} .cc-status { min-height: 1.3em; margin: 0; font-size: .88rem; font-weight: 700; text-align: center; }
    #{{ $uid }} .cc-status.bad { color: #f87171; }
    #{{ $uid }} .cc-status.ok { color: #22c55e; }
    #{{ $uid }} .cc-p { position: absolute; left: 50%; top: 40%; width: 8px; height: 8px; border-radius: 50%; pointer-events: none; animation: cc-burst .9s ease-out forwards; }

    #{{ $uid }}-mini { --acc: {{ $o['accent'] }}; --acc2: {{ $o['accent2'] }}; position: fixed; z-index: 2147483000; left: 12px; right: 12px; bottom: calc(12px + env(safe-area-inset-bottom, 0px)); display: none; align-items: center; justify-content: space-between; gap: 12px; max-width: 520px; margin: 0 auto; padding: 8px 8px 8px 22px; border-radius: 99px; color: #fff; font-family: inherit;
        background: rgba(10,14,40,.88); -webkit-backdrop-filter: blur(16px); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.2); box-shadow: 0 18px 44px -14px rgba(0,0,0,.6), 0 0 30px -10px var(--acc); transform: translateY(160%); transition: transform .45s cubic-bezier(.2,.9,.2,1); }
    #{{ $uid }}-mini.show { transform: none; }
    #{{ $uid }}-mini b { font-size: 1.1rem; font-weight: 800; font-variant-numeric: tabular-nums; white-space: nowrap; }
    #{{ $uid }}-mini button { appearance: none; border: 0; cursor: pointer; padding: 11px 20px; border-radius: 99px; font: inherit; font-size: .9rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--acc), var(--acc2)); }

    @keyframes cc-in { from { opacity: 0; transform: translateY(22px) scale(.97); } to { opacity: 1; transform: none; } }
    @keyframes cc-float { from { translate: 0 0; } to { translate: 0 14px; } }
    @keyframes cc-spin { to { transform: rotate(360deg); } }
    @keyframes cc-bump { 0% { transform: scale(1); } 45% { transform: scale(1.1); } 100% { transform: scale(1); } }
    @keyframes cc-grow { from { opacity: 0; } to { opacity: 1; } }
    @keyframes cc-li { from { opacity: 0; transform: translateX(-16px); } to { opacity: 1; transform: none; } }
    @keyframes cc-out { to { opacity: 0; transform: translateX(16px); max-height: 0; padding: 0; border-width: 0; } }
    @keyframes cc-shine { 0%, 60% { left: -60%; } 100% { left: 140%; } }
    @keyframes cc-burst { from { opacity: 1; transform: translate(-50%, -50%) scale(1); } to { opacity: 0; transform: translate(calc(-50% + var(--dx)), calc(-50% + var(--dy))) scale(0); } }

    #{{ $uid }}[data-anim="0"] *, #{{ $uid }}[data-anim="0"] *::before, #{{ $uid }}[data-anim="0"] *::after { animation: none !important; transition-duration: .01s !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01s !important; }
        #{{ $uid }}-mini { transition-duration: .01s; }
    }
    @media (max-width: 900px) {
        #{{ $uid }} .cc-grid { grid-template-columns: minmax(0, 1fr); }
        #{{ $uid }} .cc-result { position: relative; top: auto; }
        #{{ $uid }}-mini { display: flex; }
    }
    @media (max-width: 480px) {
        #{{ $uid }} { border-radius: 22px; }
        #{{ $uid }} .cc-row { padding: 14px; border-radius: 18px; }
        #{{ $uid }} .cc-num { width: 78px; }
        #{{ $uid }} .cc-result { padding: 18px 16px; border-radius: 22px; }
    }
</style>

<section id="{{ $uid }}" class="cc" data-theme="{{ $o['theme'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" style="--acc: {{ $o['accent'] }}; --acc2: {{ $o['accent2'] }};">
    <header class="cc-top">
        <h2 class="cc-title">{{ $o['title'] }}</h2>
        @if ($o['subtitle'] !== '')<p class="cc-sub">{{ $o['subtitle'] }}</p>@endif
    </header>

    <div class="cc-grid">
        <div class="cc-rows" data-el="rows"></div>

        <aside class="cc-result" data-el="result">
            <div class="cc-orb" aria-hidden="true"></div>
            <div class="cc-resin">
                <div class="cc-lbl">{{ $o['result_label'] }}</div>

                <div class="cc-ringwrap">
                    <svg viewBox="0 0 120 120" aria-hidden="true" focusable="false">
                        <defs>
                            <linearGradient id="{{ $uid }}-g" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="{{ $o['accent'] }}"/>
                                <stop offset="1" stop-color="{{ $o['accent2'] }}"/>
                            </linearGradient>
                        </defs>
                        <circle class="cc-dash" cx="60" cy="60" r="58"/>
                        <circle class="cc-track" cx="60" cy="60" r="52"/>
                        <circle class="cc-prog" data-el="ring" cx="60" cy="60" r="52" stroke="url(#{{ $uid }}-g)"/>
                    </svg>
                    <div class="cc-total" data-el="total" aria-live="polite">0</div>
                </div>

                <div class="cc-bar" data-el="bar" aria-hidden="true"></div>
                <ul class="cc-list" data-el="list" @if (!$o['breakdown']) hidden @endif></ul>

                @if ($o['note'] !== '')<p class="cc-note">{{ $o['note'] }}</p>@endif

                @if ($o['mode'] !== 'none')
                    <button type="button" class="cc-btn" data-el="order">{{ $o['button'] }}</button>

                    <form class="cc-form" data-el="form" hidden novalidate>
                        <input class="cc-field" data-el="name" type="text" maxlength="80" autocomplete="name" placeholder="{{ $labels['name'] }}" aria-label="{{ $labels['name'] }}">
                        <input class="cc-field" data-el="phone" type="tel" maxlength="30" autocomplete="tel" inputmode="tel" placeholder="{{ $labels['phone'] }}" aria-label="{{ $labels['phone'] }}" required>
                        <textarea class="cc-field" data-el="note" rows="2" maxlength="400" placeholder="{{ $labels['message'] }}" aria-label="{{ $labels['message'] }}"></textarea>
                        <button type="submit" class="cc-btn" data-el="send">{{ $labels['send'] }}</button>
                        <p class="cc-status" data-el="status" aria-live="polite"></p>
                    </form>
                @endif
            </div>
        </aside>
    </div>

    <script type="application/json" id="{{ $uid }}-data">{!! json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</section>

<div id="{{ $uid }}-mini" aria-hidden="true">
    <b id="{{ $uid }}-mini-total">0</b>
    <button type="button" id="{{ $uid }}-mini-go" tabindex="-1">{{ $labels['details'] }}</button>
</div>

<script>
(function () {
    var UID = '{{ $uid }}';
    var root = document.getElementById(UID);
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var D;
    try { D = JSON.parse(document.getElementById(UID + '-data').textContent); } catch (e) { return; }
    if (!D) { return; }

    var L = D.labels;
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var noAnim = !D.anim || reduce;
    var COLORS = [D.acc, D.acc2, '#22d3ee', '#f59e0b', '#22c55e', '#f472b6', '#a78bfa', '#fb7185'];
    var CIRC = 2 * Math.PI * 52;

    function q(n) { return root.querySelector('[data-el="' + n + '"]'); }
    var el = { rows: q('rows'), result: q('result'), ring: q('ring'), total: q('total'), bar: q('bar'), list: q('list'),
               order: q('order'), form: q('form'), name: q('name'), phone: q('phone'), note: q('note'), send: q('send'), status: q('status') };
    var mini = document.getElementById(UID + '-mini');
    var miniTotal = document.getElementById(UID + '-mini-total');
    var miniGo = document.getElementById(UID + '-mini-go');

    function mk(tag, cls, txt) {
        var n = document.createElement(tag);
        if (cls) { n.className = cls; }
        if (txt != null) { n.textContent = txt; }
        return n;
    }
    function clamp(v, a, b) { return v < a ? a : (v > b ? b : v); }
    function isRange(it) { return it.type === 'slider' || it.type === 'number'; }

    function money(n) {
        var s = Math.abs(n).toLocaleString(undefined, { minimumFractionDigits: D.dec, maximumFractionDigits: D.dec });
        s = D.pos === 'after' ? s + ' ' + D.cur : D.cur + s;
        return (n < 0 ? '-' : '') + s;
    }
    function plain(n) { return String(parseFloat(n.toFixed(4))); }
    function priceText(it, p) {
        var sign = p > 0 ? '+' : '';
        return it.pt === 'percent' ? sign + plain(p) + '%' : sign + money(p);
    }
    function hint(it) {
        var t = priceText(it, it.price);
        if (isRange(it)) { t += it.unit ? ' / ' + it.unit : ' / 1'; }
        return t;
    }
    function snap(it, v) {
        var n = Math.round((v - it.min) / it.step) * it.step + it.min;
        n = clamp(n, it.min, it.max);
        return parseFloat(n.toFixed(6));
    }

    var state = {};

    function unitPrice(it, st) { return it.type === 'select' ? it.options[st[it.id]][1] : it.price; }
    function qty(it, st) {
        if (it.type === 'checkbox') { return st[it.id] ? 1 : 0; }
        if (it.type === 'select') { return 1; }
        return +st[it.id] || 0;
    }
    function lineLabel(it, st) {
        if (it.type === 'select') { return it.label + ': ' + it.options[st[it.id]][0]; }
        if (it.type === 'checkbox') { return it.label; }
        return it.label + ' x ' + plain(+st[it.id] || 0) + (it.unit ? ' ' + it.unit : '');
    }

    function calc(st) {
        var lines = [], sub = D.base, pcts = [];
        if (D.base !== 0) { lines.push({ k: 'base', l: D.baseLabel, a: D.base }); }
        D.items.forEach(function (it) {
            var n = qty(it, st), p = unitPrice(it, st);
            if (!n || !p) { return; }
            if (it.pt === 'percent') { pcts.push({ it: it, n: n, p: p }); return; }
            sub += n * p;
            lines.push({ k: it.id, l: lineLabel(it, st), a: n * p });
        });
        var total = sub;
        pcts.forEach(function (x) {
            var a = sub * x.p * x.n / 100;
            total += a;
            lines.push({ k: x.it.id, l: lineLabel(x.it, st), a: a });
        });
        return { lines: lines, total: total };
    }

    function extreme(max) {
        var st = {};
        D.items.forEach(function (it) {
            var pos = it.type === 'select' ? true : it.price >= 0;
            if (isRange(it)) { st[it.id] = (max === pos) ? it.max : it.min; }
            else if (it.type === 'checkbox') { st[it.id] = (max === pos); }
            else {
                var bi = 0;
                it.options.forEach(function (o, k) {
                    if (max ? o[1] > it.options[bi][1] : o[1] < it.options[bi][1]) { bi = k; }
                });
                st[it.id] = bi;
            }
        });
        return st;
    }

    function build(it, i) {
        var row = mk('div', 'cc-row');
        row.style.setProperty('--i', i);

        if (isRange(it)) {
            state[it.id] = snap(it, it.def);

            var head = mk('div', 'cc-head'), lw = mk('div', 'cc-lw'), box = mk('div', 'cc-val');
            lw.appendChild(mk('span', 'cc-label', it.label));
            lw.appendChild(mk('span', 'cc-hint', hint(it)));

            var num = document.createElement('input');
            num.type = 'number'; num.className = 'cc-num'; num.min = it.min; num.max = it.max; num.step = it.step;
            num.inputMode = 'decimal'; num.value = state[it.id]; num.setAttribute('aria-label', it.label);

            var rng = null, minus = null, plus = null;
            if (it.type === 'number') {
                minus = mk('button', 'cc-step', '\u2212'); minus.type = 'button'; minus.setAttribute('aria-label', '-');
                plus = mk('button', 'cc-step', '+'); plus.type = 'button'; plus.setAttribute('aria-label', '+');
                box.appendChild(minus);
            }
            box.appendChild(num);
            if (plus) { box.appendChild(plus); }
            if (it.unit) { box.appendChild(mk('span', 'cc-unit', it.unit)); }
            head.appendChild(lw); head.appendChild(box); row.appendChild(head);

            var paint = function () {
                if (rng) { rng.value = state[it.id]; }
                row.style.setProperty('--p', clamp((state[it.id] - it.min) / (it.max - it.min), 0, 1));
            };
            var set = function (v) {
                state[it.id] = snap(it, v);
                num.value = state[it.id];
                paint();
                update();
            };

            if (it.type === 'slider') {
                rng = document.createElement('input');
                rng.type = 'range'; rng.className = 'cc-range'; rng.min = it.min; rng.max = it.max; rng.step = it.step;
                rng.value = state[it.id]; rng.setAttribute('aria-label', it.label);
                rng.addEventListener('input', function () { set(+rng.value); });
                row.appendChild(rng);
                var sc = mk('div', 'cc-scale');
                sc.appendChild(mk('span', '', plain(it.min)));
                sc.appendChild(mk('span', '', plain(it.max)));
                row.appendChild(sc);
            }
            if (minus) { minus.addEventListener('click', function () { set((+state[it.id] || 0) - it.step); }); }
            if (plus) { plus.addEventListener('click', function () { set((+state[it.id] || 0) + it.step); }); }

            num.addEventListener('input', function () {
                var v = parseFloat(num.value);
                if (!isFinite(v)) { return; }
                state[it.id] = clamp(v, it.min, it.max);
                paint();
                update();
            });
            num.addEventListener('change', function () {
                var v = parseFloat(num.value);
                set(isFinite(v) ? v : it.min);
            });
            paint();
        } else if (it.type === 'checkbox') {
            state[it.id] = !!it.def;
            var lab = mk('label', 'cc-sw'), cb = document.createElement('input');
            cb.type = 'checkbox'; cb.checked = state[it.id];
            var lw2 = mk('span', 'cc-lw');
            lw2.appendChild(mk('span', 'cc-label', it.label));
            lw2.appendChild(mk('span', 'cc-hint', hint(it)));
            lab.appendChild(cb); lab.appendChild(mk('span', 'cc-tr')); lab.appendChild(lw2);
            row.appendChild(lab);
            row.classList.toggle('on', cb.checked);
            cb.addEventListener('change', function () {
                state[it.id] = cb.checked;
                row.classList.toggle('on', cb.checked);
                update();
            });
        } else {
            state[it.id] = it.def;
            var hd = mk('div', 'cc-head'), lw3 = mk('div', 'cc-lw');
            lw3.appendChild(mk('span', 'cc-label', it.label));
            hd.appendChild(lw3); row.appendChild(hd);
            var wrap = mk('div', 'cc-sel'), sel = mk('select', 'cc-select');
            sel.setAttribute('aria-label', it.label);
            it.options.forEach(function (o, k) {
                var t = o[0] + (o[1] !== 0 ? '  (' + priceText(it, o[1]) + ')' : '');
                var op = mk('option', '', t);
                op.value = k;
                sel.appendChild(op);
            });
            sel.value = state[it.id];
            sel.addEventListener('change', function () { state[it.id] = +sel.value; update(); });
            wrap.appendChild(sel); row.appendChild(wrap);
        }
        return row;
    }

    D.items.forEach(function (it, i) { el.rows.appendChild(build(it, i)); });

    var LO = calc(extreme(false)).total, HI = calc(extreme(true)).total;
    el.ring.style.strokeDasharray = CIRC.toFixed(2);
    el.ring.style.strokeDashoffset = CIRC.toFixed(2);

    function colorOf(k) {
        if (k === 'base') { return COLORS[0]; }
        return COLORS[(parseInt(k.slice(1), 10) + 1) % COLORS.length];
    }

    var shown = 0, anim = 0, lastTarget = null, liMap = {}, segMap = {};

    function paintTotal(v) {
        var s = money(v);
        el.total.textContent = s;
        el.total.style.fontSize = Math.max(1.05, 1.95 - Math.max(0, s.length - 7) * 0.11) + 'rem';
        miniTotal.textContent = s;
    }

    function tween(to) {
        if (noAnim) { shown = to; paintTotal(to); return; }
        cancelAnimationFrame(anim);
        var from = shown, t0 = performance.now(), dur = 700;
        (function step(now) {
            var t = Math.min(1, (now - t0) / dur), e = 1 - Math.pow(1 - t, 3);
            shown = from + (to - from) * e;
            paintTotal(shown);
            if (t < 1) { anim = requestAnimationFrame(step); }
        })(t0);
    }

    function reconcile(lines) {
        var seen = {};
        lines.forEach(function (ln) {
            var li = liMap[ln.k];
            if (!li) {
                li = mk('li');
                var dot = mk('i', 'cc-dot'); dot.style.background = colorOf(ln.k);
                li.appendChild(dot); li.appendChild(mk('span', 'cc-n')); li.appendChild(mk('b', 'cc-a'));
                liMap[ln.k] = li;
            }
            li.classList.remove('out');
            li.children[1].textContent = ln.l;
            li.children[2].textContent = (ln.a > 0 && ln.k !== 'base' ? '+' : '') + money(ln.a);
            el.list.appendChild(li);
            seen[ln.k] = true;
        });
        Object.keys(liMap).forEach(function (k) {
            if (seen[k]) { return; }
            var li = liMap[k];
            el.list.appendChild(li);
            if (li.classList.contains('out')) { return; }
            li.classList.add('out');
            setTimeout(function () {
                if (li.classList.contains('out')) { li.remove(); delete liMap[k]; }
            }, noAnim ? 0 : 320);
        });
    }

    function segments(lines) {
        var seen = {};
        lines.forEach(function (ln) {
            if (ln.a <= 0) { return; }
            var sg = segMap[ln.k];
            if (!sg) {
                sg = mk('span', 'cc-seg');
                sg.style.background = colorOf(ln.k);
                segMap[ln.k] = sg;
                el.bar.appendChild(sg);
            }
            sg.style.flexGrow = ln.a;
            seen[ln.k] = true;
        });
        Object.keys(segMap).forEach(function (k) {
            if (!seen[k]) { segMap[k].remove(); delete segMap[k]; }
        });
    }

    function update() {
        var r = calc(state);
        var ratio = HI > LO ? clamp((r.total - LO) / (HI - LO), 0, 1) : 1;
        el.ring.style.strokeDashoffset = (CIRC * (1 - ratio)).toFixed(2);
        el.result.style.setProperty('--r', ratio.toFixed(3));
        if (lastTarget !== r.total) {
            if (lastTarget !== null && !noAnim) {
                el.total.classList.remove('bump'); void el.total.offsetWidth; el.total.classList.add('bump');
            }
            lastTarget = r.total;
            tween(r.total);
        }
        reconcile(r.lines);
        segments(r.lines);
    }

    function compose(name, phone, note) {
        var r = calc(state), t = [D.title, ''];
        r.lines.forEach(function (l) { t.push('- ' + l.l + ': ' + money(l.a)); });
        t.push('', L.total + ': ' + money(r.total), '');
        if (name) { t.push(L.name + ': ' + name); }
        t.push(L.phone + ': ' + phone);
        if (note) { t.push(L.message + ': ' + note); }
        return t.join('\n');
    }

    function stat(msg, cls) {
        el.status.textContent = msg || '';
        el.status.className = 'cc-status' + (cls ? ' ' + cls : '');
    }

    function burst() {
        if (noAnim) { return; }
        for (var i = 0; i < 18; i++) {
            var s = mk('i', 'cc-p'), a = Math.PI * 2 * i / 18 + Math.random() * 0.4, d = 70 + Math.random() * 90;
            s.style.setProperty('--dx', (Math.cos(a) * d).toFixed(1) + 'px');
            s.style.setProperty('--dy', (Math.sin(a) * d).toFixed(1) + 'px');
            s.style.background = COLORS[i % COLORS.length];
            el.result.appendChild(s);
            (function (n) { setTimeout(function () { n.remove(); }, 1000); })(s);
        }
    }

    function done() {
        stat(L.sent, 'ok');
        burst();
        el.name.value = ''; el.phone.value = ''; el.note.value = '';
    }

    if (el.order && el.form) {
        el.order.addEventListener('click', function () {
            var open = el.form.hidden;
            el.form.hidden = !open;
            if (open) {
                stat('');
                try { el.name.focus({ preventScroll: true }); } catch (e) { el.name.focus(); }
                el.form.scrollIntoView({ behavior: noAnim ? 'auto' : 'smooth', block: 'nearest' });
            }
        });

        el.form.addEventListener('submit', function (e) {
            e.preventDefault();
            var name = el.name.value.trim(), phone = el.phone.value.trim(), note = el.note.value.trim();
            if (phone.replace(/\D/g, '').length < 5) { stat(L.invalid, 'bad'); el.phone.focus(); return; }

            var msg = compose(name, phone, note), r = calc(state);

            if (D.mode === 'whatsapp') {
                window.open('https://wa.me/' + D.target + '?text=' + encodeURIComponent(msg), '_blank', 'noopener');
                done();
            } else if (D.mode === 'email') {
                window.location.href = 'mailto:' + D.target + '?subject=' + encodeURIComponent(D.title) + '&body=' + encodeURIComponent(msg);
                done();
            } else {
                var meta = document.querySelector('meta[name="csrf-token"]');
                var headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
                if (meta) { headers['X-CSRF-TOKEN'] = meta.content; }
                el.send.disabled = true;
                stat(L.sending);
                fetch(D.target, {
                    method: 'POST',
                    headers: headers,
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        name: name, phone: phone, note: note, total: r.total, currency: D.cur, message: msg,
                        items: r.lines.map(function (l) { return { label: l.l, amount: l.a }; })
                    })
                }).then(function (res) {
                    if (!res.ok) { throw new Error('http'); }
                    done();
                }).catch(function () {
                    stat(L.failed, 'bad');
                }).then(function () {
                    el.send.disabled = false;
                });
            }
        });
    }

    miniGo.addEventListener('click', function () {
        el.result.scrollIntoView({ behavior: noAnim ? 'auto' : 'smooth', block: 'center' });
    });

    var secVis = false, resVis = false;
    function syncMini() { mini.classList.toggle('show', secVis && !resVis); }
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (es) { secVis = es[0].isIntersecting; syncMini(); }, { threshold: 0.05 }).observe(root);
        new IntersectionObserver(function (es) { resVis = es[0].isIntersecting; syncMini(); }, { threshold: 0.2 }).observe(el.result);
    }

    update();
})();
</script>