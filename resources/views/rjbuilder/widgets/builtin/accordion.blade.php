@php
    $count = count($items);
    $faq = null;
    if ($opts['seo']) {
        $faq = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($it) => [
                '@type' => 'Question',
                'name' => $it['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $it['answer']],
            ], $items),
        ];
    }
@endphp

<style>
    @property --rjacc-angle { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

    #{{ $uid }} { --acc: {{ $opts['accent'] }}; position: relative; width: 100%; padding: 56px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Box + theme variables ---------- */
    #{{ $uid }} .rjacc-box { --r: 20px; --px: 24px; --t: #0f172a; --m: #475569; --card: #fff; --bd: #e2e8f0; --sh: 0 1px 2px rgba(15,23,42,.04), 0 10px 30px -14px rgba(15,23,42,.16); position: relative; isolation: isolate; max-width: 48rem; margin: 0 auto; }
    #{{ $uid }}[data-style="dark"] .rjacc-box { --t: #fff; --m: #a5b0c5; --card: rgba(255,255,255,.04); --bd: rgba(255,255,255,.1); --sh: none; padding: clamp(24px, 5vw, 48px); border-radius: 32px; background: #0b1020; background: radial-gradient(120% 80% at 100% 0%, color-mix(in srgb, var(--acc) 30%, transparent), transparent 55%), radial-gradient(90% 70% at 0% 100%, color-mix(in srgb, var(--acc) 18%, transparent), transparent 60%), #0b1020; box-shadow: 0 30px 80px -30px rgba(2,6,23,.7); }
    #{{ $uid }}[data-style="bordered"] .rjacc-box { --r: 0px; --px: 4px; --card: transparent; --sh: none; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjacc-title { margin: 0; padding: 0; text-align: center; font-size: clamp(1.9rem, 4.2vw, 2.8rem); font-weight: 800; line-height: 1.12; letter-spacing: -.03em; color: var(--t); }
    #{{ $uid }} .rjacc-title::after { content: ""; display: block; width: 56px; height: 4px; margin: 18px auto 0; border-radius: 4px; background: var(--acc); }
    #{{ $uid }} .rjacc-sub { margin: 16px auto 0; max-width: 34rem; text-align: center; color: var(--m); line-height: 1.7; font-size: 1.05rem; }
    #{{ $uid }} .rjacc-head { margin-bottom: 36px; }

    /* ---------- Search ---------- */
    #{{ $uid }} .rjacc-search { position: relative; display: block; margin: 0 0 20px; }
    #{{ $uid }} .rjacc-search svg { position: absolute; left: 18px; top: 50%; width: 18px; height: 18px; margin-top: -9px; color: var(--m); pointer-events: none; }
    #{{ $uid }} .rjacc-search input { display: block; width: 100%; margin: 0; padding: 14px 20px 14px 46px; border: 1px solid var(--bd); border-radius: 999px; background: var(--card); color: var(--t); font: inherit; font-size: .95rem; box-shadow: var(--sh); transition: border-color .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .rjacc-search input::placeholder { color: var(--m); opacity: .8; }
    #{{ $uid }} .rjacc-search input:focus { outline: none; border-color: var(--acc); box-shadow: 0 0 0 4px color-mix(in srgb, var(--acc) 22%, transparent); }
    #{{ $uid }} .rjacc-empty { margin: 24px 0 0; text-align: center; color: var(--m); }
    #{{ $uid }} .rjacc-empty[hidden] { display: none; }

    /* ---------- Item ---------- */
    #{{ $uid }} .rjacc-item { position: relative; margin: 0 0 14px; border: 1px solid var(--bd); border-radius: var(--r); background: var(--card); box-shadow: var(--sh); transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease, background .4s ease; }
    #{{ $uid }} .rjacc-item[hidden] { display: none; }
    #{{ $uid }} .rjacc-item:hover { transform: translateY(-2px); }
    #{{ $uid }} .rjacc-item.is-open { border-color: transparent; }

    /* spinning light border (cards only) */
    #{{ $uid }}:not([data-style="bordered"]) .rjacc-item::before { content: ""; position: absolute; inset: -1px; border-radius: inherit; padding: 1.5px; background: conic-gradient(from var(--rjacc-angle), transparent 0 55%, var(--acc) 80%, transparent 100%); -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0); mask-composite: exclude; opacity: 0; transition: opacity .5s ease; pointer-events: none; animation: rjacc-spin 4s linear infinite; }
    #{{ $uid }}:not([data-style="bordered"]) .rjacc-item.is-open::before { opacity: 1; }
    @keyframes rjacc-spin { to { --rjacc-angle: 360deg; } }

    /* bordered: growing underline */
    #{{ $uid }}[data-style="bordered"] .rjacc-item { border: 0; border-bottom: 1px solid var(--bd); margin: 0; }
    #{{ $uid }}[data-style="bordered"] .rjacc-item:hover { transform: none; }
    #{{ $uid }}[data-style="bordered"] .rjacc-item::after { content: ""; position: absolute; left: 0; bottom: -1px; width: 100%; height: 2px; background: var(--acc); transform: scaleX(0); transform-origin: left; transition: transform .6s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }}[data-style="bordered"] .rjacc-item.is-open::after { transform: scaleX(1); }

    /* glow: open card becomes a gradient */
    #{{ $uid }}[data-style="glow"] .rjacc-item.is-open { --t: #fff; --m: rgba(255,255,255,.9); background: var(--acc); background: linear-gradient(135deg, var(--acc), color-mix(in srgb, var(--acc) 45%, #7c3aed)); box-shadow: 0 22px 44px -18px color-mix(in srgb, var(--acc) 70%, transparent); }
    #{{ $uid }}[data-style="glow"] .rjacc-item.is-open .rjacc-num { color: #fff; }
    #{{ $uid }}[data-style="glow"] .rjacc-item.is-open .rjacc-ico { background: rgba(255,255,255,.22); }

    /* ---------- Button ---------- */
    #{{ $uid }} .rjacc-h { margin: 0; padding: 0; font: inherit; }
    #{{ $uid }} .rjacc-btn { all: unset; box-sizing: border-box; display: flex; align-items: center; gap: 16px; width: 100%; padding: 20px var(--px); cursor: pointer; color: var(--t); border-radius: var(--r); -webkit-tap-highlight-color: transparent; }
    #{{ $uid }} .rjacc-btn:focus-visible { outline: 2px solid var(--acc); outline-offset: 2px; }
    #{{ $uid }} .rjacc-num { flex: none; width: 28px; font-size: .8rem; font-weight: 800; letter-spacing: .08em; font-variant-numeric: tabular-nums; color: var(--acc); transition: color .3s ease; }
    #{{ $uid }}[data-numbers="0"] .rjacc-num { display: none; }
    #{{ $uid }} .rjacc-q { flex: 1; font-size: clamp(1rem, 1.7vw, 1.15rem); font-weight: 700; line-height: 1.4; transition: color .3s ease; }
    #{{ $uid }} .rjacc-item:not(.is-open) .rjacc-btn:hover .rjacc-q { color: var(--acc); }

    /* plus -> minus icon */
    #{{ $uid }} .rjacc-ico { position: relative; flex: none; width: 36px; height: 36px; border-radius: 50%; background: rgba(128,128,128,.14); background: color-mix(in srgb, var(--acc) 12%, transparent); transition: background .35s ease, transform .55s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rjacc-ico::before, #{{ $uid }} .rjacc-ico::after { content: ""; position: absolute; left: 50%; top: 50%; width: 14px; height: 2px; margin: -1px 0 0 -7px; border-radius: 2px; background: var(--acc); transition: transform .45s cubic-bezier(.34,1.56,.64,1), background .3s ease; }
    #{{ $uid }} .rjacc-ico::after { transform: rotate(90deg); }
    #{{ $uid }} .rjacc-item:hover .rjacc-ico { transform: scale(1.1); }
    #{{ $uid }} .rjacc-item.is-open .rjacc-ico { background: var(--acc); transform: rotate(180deg); }
    #{{ $uid }} .rjacc-item.is-open .rjacc-ico::before, #{{ $uid }} .rjacc-item.is-open .rjacc-ico::after { background: #fff; }
    #{{ $uid }} .rjacc-item.is-open .rjacc-ico::after { transform: rotate(0deg); }

    /* ---------- Panel ---------- */
    #{{ $uid }} .rjacc-panel { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjacc-item.is-open .rjacc-panel { grid-template-rows: 1fr; }
    #{{ $uid }} .rjacc-inner { min-height: 0; overflow: hidden; visibility: hidden; transition: visibility 0s linear .5s; }
    #{{ $uid }} .rjacc-item.is-open .rjacc-inner { visibility: visible; transition-delay: 0s; }
    #{{ $uid }} .rjacc-a { padding: 0 var(--px) 24px var(--px); color: var(--m); font-size: .98rem; line-height: 1.8; opacity: 0; transform: translateY(-12px); transition: opacity .3s ease, transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }}[data-numbers="1"] .rjacc-a { padding-left: calc(var(--px) + 44px); }
    #{{ $uid }} .rjacc-item.is-open .rjacc-a { opacity: 1; transform: none; transition-delay: .12s; }

    /* ---------- Reveal on scroll ---------- */
    #{{ $uid }}.rjacc-ready:not(.rjacc-in) .rjacc-item { opacity: 0; }
    #{{ $uid }}.rjacc-in .rjacc-item { animation: rjacc-rise .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--i, 0) * 90ms + 100ms); }
    @keyframes rjacc-rise { from { opacity: 0; transform: translateY(28px) scale(.97); } }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 40px 12px; }
        #{{ $uid }} .rjacc-box { --px: 16px; }
        #{{ $uid }}[data-style="bordered"] .rjacc-box { --px: 2px; }
        #{{ $uid }} .rjacc-btn { gap: 12px; padding-top: 16px; padding-bottom: 16px; }
        #{{ $uid }}[data-numbers="1"] .rjacc-a { padding-left: var(--px); }
        #{{ $uid }} .rjacc-ico { width: 32px; height: 32px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }}.rjacc-ready:not(.rjacc-in) .rjacc-item { opacity: 1; }
    }
</style>

<section id="{{ $uid }}"
         data-style="{{ $opts['style'] }}"
         data-multiple="{{ $opts['multiple'] ? '1' : '0' }}"
         data-first="{{ $opts['first_open'] ? '1' : '0' }}"
         data-numbers="{{ $opts['numbers'] ? '1' : '0' }}">
    <div class="rjacc-box">

        @if ($opts['title'] !== '' || $opts['subtitle'] !== '')
            <div class="rjacc-head">
                @if ($opts['title'] !== '')
                    <h2 class="rjacc-title">{{ $opts['title'] }}</h2>
                @endif
                @if ($opts['subtitle'] !== '')
                    <p class="rjacc-sub">{{ $opts['subtitle'] }}</p>
                @endif
            </div>
        @endif

        @if ($opts['search'])
            <label class="rjacc-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="search" placeholder="{{ __('Search questions...') }}" aria-label="{{ __('Search questions') }}" autocomplete="off">
            </label>
        @endif

        <div class="rjacc-list">
            @foreach ($items as $item)
                <div class="rjacc-item" style="--i: {{ min($loop->index, 10) }};">
                    <h3 class="rjacc-h">
                        <button type="button" class="rjacc-btn" id="{{ $uid }}-b{{ $loop->iteration }}" aria-expanded="false" aria-controls="{{ $uid }}-p{{ $loop->iteration }}">
                            <span class="rjacc-num">{{ sprintf('%02d', $loop->iteration) }}</span>
                            <span class="rjacc-q">{{ $item['question'] }}</span>
                            <span class="rjacc-ico" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div class="rjacc-panel" id="{{ $uid }}-p{{ $loop->iteration }}" role="region" aria-labelledby="{{ $uid }}-b{{ $loop->iteration }}">
                        <div class="rjacc-inner">
                            <div class="rjacc-a">{!! nl2br(e($item['answer'])) !!}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($opts['search'])
            <p class="rjacc-empty" hidden>{{ __('No questions found.') }}</p>
        @endif
    </div>
</section>

@if ($faq)
    <script type="application/ld+json">{!! json_encode($faq, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endif

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var items = [].slice.call(root.querySelectorAll('.rjacc-item'));
    var multiple = root.dataset.multiple === '1';

    function setOpen(item, open) {
        item.classList.toggle('is-open', open);
        var b = item.querySelector('.rjacc-btn');
        if (b) { b.setAttribute('aria-expanded', open ? 'true' : 'false'); }
    }

    items.forEach(function (item) {
        var btn = item.querySelector('.rjacc-btn');
        if (!btn) { return; }

        btn.addEventListener('click', function () {
            var open = !item.classList.contains('is-open');
            if (open && !multiple) {
                items.forEach(function (o) { if (o !== item) { setOpen(o, false); } });
            }
            setOpen(item, open);
        });

        btn.addEventListener('keydown', function (e) {
            var k = e.key;
            if (['ArrowDown', 'ArrowUp', 'Home', 'End'].indexOf(k) < 0) { return; }
            var vis = items.filter(function (i) { return !i.hidden; });
            var idx = vis.indexOf(item);
            var n = k === 'ArrowDown' ? (idx + 1) % vis.length
                  : k === 'ArrowUp' ? (idx - 1 + vis.length) % vis.length
                  : k === 'Home' ? 0 : vis.length - 1;
            e.preventDefault();
            vis[n].querySelector('.rjacc-btn').focus();
        });
    });

    if (root.dataset.first === '1' && items[0]) { setOpen(items[0], true); }

    // Search
    var input = root.querySelector('.rjacc-search input');
    var empty = root.querySelector('.rjacc-empty');
    if (input) {
        input.addEventListener('input', function () {
            var q = input.value.trim().toLowerCase();
            var shown = 0;
            items.forEach(function (it) {
                var match = !q || it.textContent.toLowerCase().indexOf(q) > -1;
                it.hidden = !match;
                if (match) { shown++; }
            });
            if (empty) { empty.hidden = shown > 0; }
        });
    }

    // Reveal on scroll
    root.classList.add('rjacc-ready');
    function show() { root.classList.add('rjacc-in'); }
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) { show(); io.disconnect(); }
        }, { threshold: 0.12 });
        io.observe(root);
    } else {
        show();
    }
})();
</script>
