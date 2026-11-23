<style>
    #{{ $uid }} { --acc: {{ $o['accent'] }}; --n: {{ $n }}; width: 100%; padding: 24px 12px; box-sizing: border-box; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }
    #{{ $uid }} .pc-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; }

    /* Kart və fon */
    #{{ $uid }} .pc-card { position: relative; isolation: isolate; max-width: 1040px; margin: 0 auto; padding: 26px; border-radius: 28px; overflow: hidden; color: #fff;
        background: linear-gradient(150deg, color-mix(in srgb, var(--acc) 70%, #0f172a), #0f172a 70%);
        border: 1px solid rgba(255,255,255,.22); box-shadow: 0 28px 70px -28px rgba(2,6,23,.65); }
    #{{ $uid }} .pc-blob { position: absolute; z-index: -1; border-radius: 50%; filter: blur(60px); pointer-events: none; animation: pc-float 18s ease-in-out infinite alternate; }
    #{{ $uid }} .pc-blob.b1 { width: 300px; height: 300px; right: -80px; top: -90px; background: var(--acc); opacity: .5; }
    #{{ $uid }} .pc-blob.b2 { width: 260px; height: 260px; left: -70px; bottom: -80px; background: #ec4899; opacity: .3; animation-duration: 23s; animation-direction: alternate-reverse; }
    #{{ $uid }} .pc-blob.b3 { width: 200px; height: 200px; left: 45%; top: 35%; background: #38bdf8; opacity: .18; animation-duration: 28s; }
    @keyframes pc-float { from { transform: translate(0,0) scale(1); } to { transform: translate(-50px,60px) scale(1.25); } }

    #{{ $uid }} .pc-top { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 12px; margin-bottom: 18px; }
    #{{ $uid }} .pc-title { margin: 0; font-size: 1.6rem; font-weight: 800; line-height: 1.15; text-shadow: 0 2px 12px rgba(0,0,0,.3); }
    #{{ $uid }} .pc-sub { margin-top: 4px; font-size: .9rem; color: rgba(255,255,255,.78); }
    #{{ $uid }} .pc-diff { cursor: pointer; padding: 8px 16px; border-radius: 999px; font: inherit; font-size: .82rem; font-weight: 600; color: #fff; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.3);
        -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); transition: background .25s, transform .2s; }
    #{{ $uid }} .pc-diff:hover { background: rgba(255,255,255,.24); transform: translateY(-1px); }
    #{{ $uid }} .pc-diff[aria-pressed="true"] { background: var(--acc); border-color: transparent; box-shadow: 0 8px 22px -8px var(--acc); }

    /* Şüşə panel */
    #{{ $uid }} .pc-glass { padding: 14px; border-radius: 22px;
        background: linear-gradient(145deg, rgba(255,255,255,.18), rgba(255,255,255,.04)), rgba(15,23,42,.28);
        -webkit-backdrop-filter: blur(22px) saturate(170%); backdrop-filter: blur(22px) saturate(170%);
        border: 1px solid rgba(255,255,255,.28); box-shadow: 0 12px 40px rgba(2,6,23,.3), inset 0 1px 0 rgba(255,255,255,.4); }
    #{{ $uid }}[data-style="glass-dark"] .pc-glass { background: linear-gradient(145deg, rgba(255,255,255,.09), rgba(255,255,255,.02)), rgba(8,12,28,.58); border-color: rgba(255,255,255,.16); }
    @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) { #{{ $uid }} .pc-glass { background: rgba(15,23,42,.8); } }

    /* Cədvəl şəbəkəsi: desktop = etiket + n sütun */
    #{{ $uid }} .pc-head, #{{ $uid }} .pc-row { display: grid; grid-template-columns: minmax(120px, 1.1fr) repeat(var(--n), minmax(0, 1fr)); gap: 8px; align-items: stretch; }
    #{{ $uid }} .pc-head { margin-bottom: 10px; }

    /* Məhsul başlığı */
    #{{ $uid }} .pc-prod { position: relative; display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 18px 10px 14px; text-align: center; border-radius: 18px; cursor: pointer;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.16); transition: transform .3s, background .3s, border-color .3s, box-shadow .3s; }
    #{{ $uid }} .pc-prod:hover, #{{ $uid }} .pc-prod.col-on { transform: translateY(-4px); background: rgba(255,255,255,.16); border-color: rgba(255,255,255,.4); }
    #{{ $uid }} .pc-prod.is-hl { border-color: var(--acc); background: color-mix(in srgb, var(--acc) 28%, transparent); box-shadow: 0 0 0 1px var(--acc), 0 16px 40px -14px var(--acc); }
    #{{ $uid }} .pc-badge { position: absolute; top: -11px; left: 50%; transform: translateX(-50%); padding: 3px 12px; border-radius: 999px; white-space: nowrap; font-size: .68rem; font-weight: 800; letter-spacing: .03em; color: #1e1b4b;
        background: linear-gradient(110deg, #fde68a 20%, #fff 40%, #fde68a 60%); background-size: 200% 100%; animation: pc-shine 3s linear infinite; box-shadow: 0 6px 16px -6px rgba(0,0,0,.5); }
    @keyframes pc-shine { from { background-position: 200% 0; } to { background-position: -200% 0; } }
    #{{ $uid }} .pc-img { width: 92px; height: 92px; display: grid; place-items: center; border-radius: 18px; overflow: hidden; background: rgba(255,255,255,.14); animation: pc-bob 5s ease-in-out infinite alternate; }
    #{{ $uid }} .pc-prod:nth-child(3n) .pc-img { animation-delay: -1.5s; }
    #{{ $uid }} .pc-prod:nth-child(3n+1) .pc-img { animation-delay: -3s; }
    @keyframes pc-bob { from { transform: translateY(0); } to { transform: translateY(-5px); } }
    #{{ $uid }} .pc-img img { width: 100%; height: 100%; object-fit: contain; display: block; }
    #{{ $uid }} .pc-img span { font-size: 2rem; font-weight: 800; color: rgba(255,255,255,.85); }
    #{{ $uid }} .pc-name { font-weight: 800; font-size: 1rem; line-height: 1.2; overflow-wrap: anywhere; }
    #{{ $uid }} .pc-price { font-size: 1.05rem; font-weight: 800; color: #fde68a; }
    #{{ $uid }} .pc-cta { display: inline-block; margin-top: 4px; padding: 6px 16px; border-radius: 999px; font-size: .78rem; font-weight: 700; text-decoration: none; color: #fff;
        background: linear-gradient(135deg, var(--acc), color-mix(in srgb, var(--acc) 55%, #ec4899)); box-shadow: 0 8px 20px -8px var(--acc); transition: transform .2s, filter .2s; }
    #{{ $uid }} .pc-cta:hover { transform: translateY(-2px); filter: brightness(1.12); }

    /* Qrup başlığı */
    #{{ $uid }} .pc-group { margin: 14px 0 6px; padding: 0 4px; font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--acc); filter: brightness(1.6) saturate(1.2); }

    /* Sətirlər */
    #{{ $uid }} .pc-row { margin-top: 5px; }
    #{{ $uid }} .pc-label { display: flex; align-items: center; padding: 11px 12px; border-radius: 12px; font-size: .88rem; font-weight: 700; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); }
    #{{ $uid }} .pc-cell { display: grid; place-items: center; min-height: 44px; padding: 10px 8px; border-radius: 12px; text-align: center; font-size: .9rem; font-weight: 600; overflow-wrap: anywhere;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); transition: background .25s, border-color .25s; }
    #{{ $uid }} .pc-cell.col-on { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.4); }
    #{{ $uid }} .pc-cell.is-hl { background: color-mix(in srgb, var(--acc) 22%, transparent); border-color: color-mix(in srgb, var(--acc) 60%, transparent); }
    #{{ $uid }} .pc-cell.is-hl.col-on { background: color-mix(in srgb, var(--acc) 38%, transparent); }
    #{{ $uid }} .pc-ico { width: 24px; height: 24px; }
    #{{ $uid }} .pc-ico.yes { color: #4ade80; }
    #{{ $uid }} .pc-ico.no { color: #fb7185; opacity: .85; }
    #{{ $uid }} .pc-dash { color: rgba(255,255,255,.4); }

    /* Animasiya: JS hazır olduqda gizlənir, görünəndə açılır */
    #{{ $uid }}.js[data-anim="1"] .pc-row:not(.in), #{{ $uid }}.js[data-anim="1"] .pc-group:not(.in) { opacity: 0; transform: translateY(16px); }
    #{{ $uid }} .pc-row, #{{ $uid }} .pc-group { transition: opacity .5s ease, transform .5s ease; transition-delay: var(--d, 0ms); }
    #{{ $uid }} .pc-ico.yes path, #{{ $uid }} .pc-ico.no path { stroke-dasharray: 30; stroke-dashoffset: 0; }
    #{{ $uid }}.js[data-anim="1"] .pc-row:not(.in) .pc-ico path { stroke-dashoffset: 30; }
    #{{ $uid }} .pc-row.in .pc-ico path { transition: stroke-dashoffset .6s ease .25s; }

    #{{ $uid }}[data-anim="0"] *, #{{ $uid }}[data-anim="0"] .pc-blob { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} .pc-blob { animation: none !important; transition: none !important; }
        #{{ $uid }}.js[data-anim="1"] .pc-row:not(.in), #{{ $uid }}.js[data-anim="1"] .pc-group:not(.in) { opacity: 1; transform: none; }
    }

    /* Mobil: etiket tam en, altında n bərabər sütun */
    @media (max-width: 720px) {
        #{{ $uid }} { padding: 12px 8px; }
        #{{ $uid }} .pc-card { padding: 16px 12px; border-radius: 22px; }
        #{{ $uid }} .pc-title { font-size: 1.3rem; }
        #{{ $uid }} .pc-glass { padding: 10px; border-radius: 18px; }
        #{{ $uid }} .pc-head, #{{ $uid }} .pc-row { grid-template-columns: repeat(var(--n), minmax(0, 1fr)); gap: 6px; }
        #{{ $uid }} .pc-corner { display: none; }
        #{{ $uid }} .pc-label { grid-column: 1 / -1; padding: 6px 4px 0; font-size: .72rem; letter-spacing: .06em; text-transform: uppercase; color: rgba(255,255,255,.8); background: none; border: 0; }
        #{{ $uid }} .pc-row { margin-top: 10px; }
        #{{ $uid }} .pc-prod { padding: 16px 6px 10px; gap: 4px; border-radius: 14px; }
        #{{ $uid }} .pc-img { width: 54px; height: 54px; border-radius: 12px; }
        #{{ $uid }} .pc-img span { font-size: 1.3rem; }
        #{{ $uid }} .pc-name { font-size: .78rem; }
        #{{ $uid }} .pc-price { font-size: .82rem; }
        #{{ $uid }} .pc-cta { padding: 5px 10px; font-size: .68rem; }
        #{{ $uid }} .pc-badge { font-size: .58rem; padding: 2px 8px; }
        #{{ $uid }} .pc-cell { min-height: 40px; padding: 8px 4px; font-size: .78rem; }
        #{{ $uid }} .pc-prod:hover { transform: none; }
    }
</style>

<section id="{{ $uid }}" data-style="{{ $o['style'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}">
    <div class="pc-card">
        <span class="pc-blob b1"></span><span class="pc-blob b2"></span><span class="pc-blob b3"></span>

        @if ($o['title'] !== '' || $o['subtitle'] !== '' || $o['diff'])
            <div class="pc-top">
                <div>
                    @if ($o['title'] !== '')<h4 class="pc-title">{{ $o['title'] }}</h4>@endif
                    @if ($o['subtitle'] !== '')<div class="pc-sub">{{ $o['subtitle'] }}</div>@endif
                </div>
                @if ($o['diff'])
                    <button type="button" class="pc-diff" data-el="diff" aria-pressed="false">{{ $labels['diff'] }}</button>
                @endif
            </div>
        @endif

        <div class="pc-glass" role="table">
            <div class="pc-head" role="row">
                <div class="pc-corner" role="presentation"></div>
                @foreach ($products as $i => $p)
                    @php $isHl = $o['hl'] === $i; @endphp
                    <div class="pc-prod {{ $isHl ? 'is-hl' : '' }}" data-col="{{ $i }}" role="columnheader">
                        @if ($isHl && $o['badge'] !== '')<span class="pc-badge">{{ $o['badge'] }}</span>@endif
                        <div class="pc-img">
                            @if ($p['img'] !== '')
                                <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}" loading="lazy" decoding="async">
                            @else
                                <span aria-hidden="true">{{ $p['initial'] }}</span>
                            @endif
                        </div>
                        <div class="pc-name">{{ $p['name'] }}</div>
                        @if ($p['price'] !== '')<div class="pc-price">{{ $p['price'] }}</div>@endif
                        @if ($p['url'] !== '' && $o['cta'] !== '')
                            <a class="pc-cta" href="{{ $p['url'] }}" @if ($o['blank']) target="_blank" rel="noopener noreferrer nofollow" @endif>{{ $o['cta'] }}</a>
                        @endif
                    </div>
                @endforeach
            </div>

            @php $r = 0; @endphp
            @foreach ($rows as $row)
                @php $r++; @endphp
                @if ($row['type'] === 'group')
                    <div class="pc-group" data-el="group" style="--d: {{ min($r * 45, 700) }}ms">{{ $row['label'] }}</div>
                @else
                    <div class="pc-row" role="row" data-same="{{ $row['same'] ? '1' : '0' }}" style="--d: {{ min($r * 45, 700) }}ms">
                        <div class="pc-label" role="rowheader">{{ $row['label'] }}</div>
                        @foreach ($row['cells'] as $ci => $c)
                            <div class="pc-cell {{ $o['hl'] === $ci ? 'is-hl' : '' }}" data-col="{{ $ci }}" role="cell">
                                @if ($c['kind'] === 'yes')
                                    <svg class="pc-ico yes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
                                    <span class="pc-sr">{{ $labels['yes'] }}</span>
                                @elseif ($c['kind'] === 'no')
                                    <svg class="pc-ico no" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                                    <span class="pc-sr">{{ $labels['no'] }}</span>
                                @elseif ($c['kind'] === 'none')
                                    <span class="pc-dash">—</span>
                                @else
                                    {{ $c['text'] }}
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <script type="application/json" id="{{ $uid }}-labels">{!! json_encode(['diff' => $labels['diff'], 'all' => $labels['all']], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';
    root.classList.add('js');

    var L = { diff: '', all: '' };
    try { L = JSON.parse(document.getElementById('{{ $uid }}-labels').textContent); } catch (e) {}

    var items = [].slice.call(root.querySelectorAll('.pc-row, .pc-group'));
    var animate = root.dataset.anim === '1';

    function reveal(n) { n.classList.add('in'); }

    if (animate && 'IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (es) {
            es.forEach(function (e) { if (e.isIntersecting) { reveal(e.target); io.unobserve(e.target); } });
        }, { threshold: .15 });
        items.forEach(function (n) { io.observe(n); });
    } else {
        items.forEach(reveal);
    }

    // Sütun vurğulama: hover (siçan) və toxunuş/klik (sabitləmə)
    var cols = [].slice.call(root.querySelectorAll('[data-col]'));
    var pinned = null;

    function setCol(c) {
        cols.forEach(function (n) { n.classList.toggle('col-on', c !== null && n.dataset.col === c); });
    }

    root.addEventListener('mouseover', function (e) {
        if (pinned !== null) { return; }
        var t = e.target.closest('[data-col]');
        setCol(t ? t.dataset.col : null);
    });
    root.addEventListener('mouseleave', function () { if (pinned === null) { setCol(null); } });
    root.addEventListener('click', function (e) {
        if (e.target.closest('a, button')) { return; }
        var t = e.target.closest('[data-col]');
        if (!t) { return; }
        pinned = pinned === t.dataset.col ? null : t.dataset.col;
        setCol(pinned);
    });

    // Yalnız fərqləri göstər
    var btn = root.querySelector('[data-el="diff"]');
    if (btn) {
        var on = false;
        btn.addEventListener('click', function () {
            on = !on;
            btn.setAttribute('aria-pressed', on ? 'true' : 'false');
            btn.textContent = on ? L.all : L.diff;

            var group = null, groupHasVisible = false;
            function closeGroup() { if (group) { group.hidden = on && !groupHasVisible; } }

            items.forEach(function (n) {
                if (n.classList.contains('pc-group')) {
                    closeGroup();
                    group = n;
                    groupHasVisible = false;
                } else {
                    var hide = on && n.dataset.same === '1';
                    n.hidden = hide;
                    if (!hide) { groupHasVisible = true; reveal(n); }
                }
            });
            closeGroup();
        });
    }
})();
</script>
