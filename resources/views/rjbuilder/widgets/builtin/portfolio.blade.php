@php
    $subtitle   = $settings['subtitle'] ?? '';
    $title      = $settings['title'] ?? '';
    $showFilter = !empty($settings['show_filter'] ?? true);
    $columns    = max(1, min(4, (int) ($settings['columns'] ?? 3)));
    $gapMap     = ['sm' => '12px', 'md' => '20px', 'lg' => '30px'];
    $gapPx      = $gapMap[$settings['gap'] ?? 'md'] ?? '20px';

    $aspectRaw = trim((string) ($settings['aspect'] ?? '4/3'));
    if (!preg_match('/^\d+(\.\d+)?\s*\/\s*\d+(\.\d+)?$/', $aspectRaw)) {
        $aspectRaw = '4/3';
    }
    $aspectCss = str_replace('/', ' / ', $aspectRaw);

    $accent = trim((string) ($settings['accent'] ?? '#6366f1'));
    if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $accent)) {
        $accent = '#6366f1';
    }
    $ah = ltrim($accent, '#');
    if (strlen($ah) === 3) {
        $ah = $ah[0] . $ah[0] . $ah[1] . $ah[1] . $ah[2] . $ah[2];
    }
    $accent = '#' . strtolower($ah);
    $accentRgb = hexdec(substr($ah, 0, 2)) . ',' . hexdec(substr($ah, 2, 2)) . ',' . hexdec(substr($ah, 4, 2));

    $items = [];
    if (!empty($settings['items']) && is_array($settings['items'])) {
        foreach ($settings['items'] as $row) {
            if (!is_array($row)) {
                continue;
            }
            $img = $row['image'] ?? '';
            if (is_array($img)) {
                $img = $img['url'] ?? ($img['src'] ?? (reset($img) ?: ''));
            }
            $img = is_string($img) ? trim($img) : '';
            if ($img === '') {
                continue;
            }
            $cat = trim((string) ($row['category'] ?? ''));
            $link = trim((string) ($row['link'] ?? ''));
            if ($link !== '' && preg_match('/^\s*(javascript|data|vbscript):/i', $link)) {
                $link = '';
            }
            $items[] = [
                'image'    => $img,
                'title'    => (string) ($row['title'] ?? ''),
                'category' => $cat !== '' ? $cat : __('Uncategorized'),
                'link'     => $link,
            ];
        }
    }

    $categories = [];
    foreach ($items as $it) {
        $categories[$it['category']] = ($categories[$it['category']] ?? 0) + 1;
    }
@endphp

@once
<style>
    @keyframes rjPgRise {
        from { opacity: 0; transform: translateY(34px) scale(.96); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjPgFade {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjPgSwap {
        from { opacity: 0; transform: scale(.96); }
        to   { opacity: 1; transform: none; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --ar: {{ $accentRgb }};
        box-sizing: border-box;
        display: block;
        position: relative;
        width: 100%;
        padding: 56px 16px;
    }
    #{{ $uid }} *,
    #{{ $uid }} *::before,
    #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-pg-top {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px 32px;
        max-width: 1280px;
        margin: 0 auto 40px;
    }
    #{{ $uid }} .rj-pg-head { min-width: 0; }
    #{{ $uid }} .rj-pg-sub {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 14px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--a);
    }
    #{{ $uid }} .rj-pg-sub::before {
        content: "";
        display: block;
        width: 0;
        height: 2px;
        border-radius: 2px;
        background: var(--a);
        transition: width .9s cubic-bezier(.2,.8,.2,1) .2s;
    }
    #{{ $uid }}.is-in .rj-pg-sub::before { width: 32px; }
    #{{ $uid }} .rj-pg-title {
        margin: 0;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -.03em;
        color: #0f172a;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-pg-title { font-size: 50px; }
    }
    #{{ $uid }}:not(.is-in) .rj-pg-top { opacity: 0; }
    #{{ $uid }}.is-in .rj-pg-top { animation: rjPgFade .8s cubic-bezier(.2,.8,.2,1) backwards; }

    #{{ $uid }} .rj-pg-filters {
        position: relative;
        display: inline-flex;
        max-width: 100%;
        padding: 5px;
        border-radius: 999px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
        scrollbar-width: none;
    }
    #{{ $uid }} .rj-pg-filters::-webkit-scrollbar { display: none; }
    #{{ $uid }} .rj-pg-ind {
        position: absolute;
        left: 0;
        top: 5px;
        bottom: 5px;
        width: 0;
        border-radius: 999px;
        background: #0f172a;
        box-shadow: 0 10px 20px -10px rgba(15,23,42,.7);
        transition: transform .55s cubic-bezier(.34,1.3,.64,1), width .55s cubic-bezier(.34,1.3,.64,1);
        pointer-events: none;
    }
    #{{ $uid }} .rj-pg-chip {
        position: relative;
        z-index: 1;
        flex: 0 0 auto;
        display: inline-flex;
        align-items: flex-start;
        gap: 4px;
        padding: 9px 18px;
        border: 0;
        border-radius: 999px;
        background: transparent;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        white-space: nowrap;
        transition: color .35s ease;
    }
    #{{ $uid }} .rj-pg-chip sup {
        font-size: 9.5px;
        font-weight: 800;
        opacity: .6;
        line-height: 1;
        margin-top: 1px;
    }
    #{{ $uid }} .rj-pg-chip:hover { color: #0f172a; }
    #{{ $uid }} .rj-pg-chip.is-active,
    #{{ $uid }} .rj-pg-chip.is-active:hover { color: #fff; }
    #{{ $uid }} .rj-pg-chip:focus-visible { outline: 2px solid var(--a); outline-offset: 2px; }

    #{{ $uid }} .rj-pg-grid {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: {{ $gapPx }};
        max-width: 1280px;
        margin: 0 auto;
    }
    @media (max-width: 900px) {
        #{{ $uid }} .rj-pg-grid { grid-template-columns: repeat({{ min($columns, 2) }}, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-pg-grid { grid-template-columns: 1fr; }
    }

    #{{ $uid }} .rj-pg-card {
        position: relative;
        display: block;
        min-width: 0;
        margin: 0;
        perspective: 900px;
        cursor: pointer;
        outline: none;
    }
    #{{ $uid }} .rj-pg-card.is-hidden { display: none; }
    #{{ $uid }}:not(.is-in) .rj-pg-card { opacity: 0; }
    #{{ $uid }}.is-in .rj-pg-card {
        animation: rjPgRise .9s cubic-bezier(.2,.8,.2,1) calc(var(--i) * 70ms) backwards;
    }
    #{{ $uid }}.is-ready .rj-pg-card { animation: none; opacity: 1; }

    #{{ $uid }} .rj-pg-in {
        position: relative;
        display: block;
        aspect-ratio: {{ $aspectCss }};
        overflow: hidden;
        border-radius: 22px;
        background: #e2e8f0;
        box-shadow: 0 20px 40px -28px rgba(15,23,42,.5);
        transform: rotateX(var(--rx, 0deg)) rotateY(var(--ry, 0deg));
        transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .5s ease;
    }
    #{{ $uid }} .rj-pg-card:hover .rj-pg-in,
    #{{ $uid }} .rj-pg-card:focus-visible .rj-pg-in {
        box-shadow: 0 34px 54px -26px rgba(var(--ar), .65);
    }
    #{{ $uid }} .rj-pg-card:focus-visible .rj-pg-in {
        outline: 3px solid var(--a);
        outline-offset: 3px;
    }
    #{{ $uid }} .rj-pg-in img {
        position: absolute;
        inset: 0;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: saturate(.8);
        transition: transform 1s cubic-bezier(.2,.8,.2,1), filter .6s ease;
    }
    #{{ $uid }} .rj-pg-card:hover .rj-pg-in img,
    #{{ $uid }} .rj-pg-card:focus-visible .rj-pg-in img {
        transform: scale(1.1);
        filter: saturate(1.1);
    }
    #{{ $uid }} .rj-pg-wash {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(var(--ar), .42), rgba(var(--ar), 0) 62%);
        mix-blend-mode: multiply;
        transition: opacity .6s ease;
        pointer-events: none;
    }
    #{{ $uid }} .rj-pg-card:hover .rj-pg-wash,
    #{{ $uid }} .rj-pg-card:focus-visible .rj-pg-wash { opacity: 0; }
    #{{ $uid }} .rj-pg-glare {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at var(--gx, 50%) var(--gy, 50%), rgba(255,255,255,.38), rgba(255,255,255,0) 46%);
        opacity: 0;
        transition: opacity .4s ease;
        pointer-events: none;
    }
    #{{ $uid }} .rj-pg-card:hover .rj-pg-glare { opacity: 1; }

    #{{ $uid }} .rj-pg-no {
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .14em;
        color: #fff;
        background: rgba(15,23,42,.35);
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.25);
    }
    #{{ $uid }} .rj-pg-eye {
        position: absolute;
        top: 14px;
        right: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 999px;
        color: var(--a);
        background: #fff;
        box-shadow: 0 10px 22px -10px rgba(15,23,42,.6);
        opacity: 0;
        transform: scale(.5) rotate(-90deg);
        transition: opacity .35s ease, transform .6s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .rj-pg-eye svg { display: block; width: 16px; height: 16px; }
    #{{ $uid }} .rj-pg-card:hover .rj-pg-eye,
    #{{ $uid }} .rj-pg-card:focus-visible .rj-pg-eye {
        opacity: 1;
        transform: none;
    }

    #{{ $uid }} .rj-pg-cap {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        display: block;
        padding: 54px 20px 20px;
        background: linear-gradient(to top, rgba(2,6,23,.82), rgba(2,6,23,0));
        pointer-events: none;
    }
    #{{ $uid }} .rj-pg-cat {
        display: block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: rgba(255,255,255,.85);
    }
    #{{ $uid }} .rj-pg-name {
        display: block;
        margin: 6px 0 0;
        font-size: 19px;
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -.01em;
        color: #fff;
        opacity: 0;
        transform: translateY(14px);
        transition: opacity .45s ease, transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-pg-card:hover .rj-pg-name,
    #{{ $uid }} .rj-pg-card:focus-visible .rj-pg-name {
        opacity: 1;
        transform: none;
    }
    @media (hover: none) {
        #{{ $uid }} .rj-pg-name { opacity: 1; transform: none; }
        #{{ $uid }} .rj-pg-eye { opacity: 1; transform: none; }
    }

    #{{ $uid }} .rj-pg-empty {
        max-width: 560px;
        margin: 0 auto;
        padding: 48px 24px;
        text-align: center;
        font-size: 14px;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
    }

    #{{ $uid }} .rj-pg-lb {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        flex-direction: column;
        background: rgba(2,6,23,.95);
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }
    #{{ $uid }} .rj-pg-lb.is-open {
        display: flex;
        animation: rjPgFade .35s ease both;
    }
    #{{ $uid }} .rj-pg-stage {
        position: relative;
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 84px 12px;
    }
    #{{ $uid }} .rj-pg-big {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 20px;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.7);
    }
    #{{ $uid }} .rj-pg-big.is-swap { animation: rjPgSwap .45s cubic-bezier(.2,.8,.2,1) both; }
    #{{ $uid }} .rj-pg-btn {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 999px;
        color: #fff;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        cursor: pointer;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), background .3s ease;
    }
    #{{ $uid }} .rj-pg-btn:hover { background: rgba(255,255,255,.26); transform: scale(1.1); }
    #{{ $uid }} .rj-pg-btn svg { display: block; width: 22px; height: 22px; }
    #{{ $uid }} .rj-pg-x { top: 20px; right: 20px; }
    #{{ $uid }} .rj-pg-prev { left: 20px; top: 50%; margin-top: -25px; }
    #{{ $uid }} .rj-pg-next { right: 20px; top: 50%; margin-top: -25px; }
    #{{ $uid }} .rj-pg-count {
        position: absolute;
        top: 30px;
        left: 28px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .14em;
        color: rgba(255,255,255,.7);
    }
    #{{ $uid }} .rj-pg-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        padding: 6px 24px 12px;
        text-align: center;
        color: #fff;
    }
    #{{ $uid }} .rj-pg-mcat {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: #a5b4fc;
    }
    #{{ $uid }} .rj-pg-mtitle { font-size: 18px; font-weight: 800; }
    #{{ $uid }} .rj-pg-open {
        display: none;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        color: #0f172a;
        text-decoration: none;
        background: #fff;
    }
    #{{ $uid }} .rj-pg-open.is-on { display: inline-block; }
    #{{ $uid }} .rj-pg-thumbs {
        display: flex;
        gap: 8px;
        justify-content: center;
        padding: 6px 20px 20px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    #{{ $uid }} .rj-pg-thumbs::-webkit-scrollbar { display: none; }
    #{{ $uid }} .rj-pg-th {
        flex: 0 0 auto;
        width: 64px;
        height: 48px;
        padding: 0;
        border: 2px solid transparent;
        border-radius: 10px;
        overflow: hidden;
        background: #1e293b;
        cursor: pointer;
        opacity: .5;
        transition: opacity .3s ease, border-color .3s ease, transform .3s ease;
    }
    #{{ $uid }} .rj-pg-th img { display: block; width: 100%; height: 100%; object-fit: cover; }
    #{{ $uid }} .rj-pg-th:hover { opacity: .85; }
    #{{ $uid }} .rj-pg-th.is-on { opacity: 1; border-color: var(--a); transform: translateY(-3px); }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-pg-stage { padding: 64px 14px 8px; }
        #{{ $uid }} .rj-pg-prev { left: 10px; top: auto; bottom: 8px; margin-top: 0; }
        #{{ $uid }} .rj-pg-next { right: 10px; top: auto; bottom: 8px; margin-top: 0; }
        #{{ $uid }} .rj-pg-x { top: 12px; right: 12px; }
        #{{ $uid }} .rj-pg-count { top: 24px; left: 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }},
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-pg-card,
        #{{ $uid }} .rj-pg-top { opacity: 1 !important; }
    }
</style>

<div id="{{ $uid }}">
    @if(!empty($items))
        @if($title || $subtitle || ($showFilter && count($categories) > 1))
            <div class="rj-pg-top">
                @if($title || $subtitle)
                    <header class="rj-pg-head">
                        @if($subtitle)
                            <p class="rj-pg-sub">{{ $subtitle }}</p>
                        @endif
                        @if($title)
                            <h2 class="rj-pg-title">{{ $title }}</h2>
                        @endif
                    </header>
                @endif

                @if($showFilter && count($categories) > 1)
                    <div class="rj-pg-filters" role="tablist">
                        <span class="rj-pg-ind" aria-hidden="true"></span>
                        <button type="button" class="rj-pg-chip is-active" data-cat="">
                            {{ __('All') }}<sup>{{ count($items) }}</sup>
                        </button>
                        @foreach($categories as $catName => $catCount)
                            <button type="button" class="rj-pg-chip" data-cat="{{ $catName }}">
                                {{ $catName }}<sup>{{ $catCount }}</sup>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <div class="rj-pg-grid">
            @foreach($items as $i => $it)
                <figure class="rj-pg-card"
                        style="--i: {{ min($i, 12) }};"
                        data-cat="{{ $it['category'] }}"
                        data-src="{{ $it['image'] }}"
                        data-title="{{ $it['title'] }}"
                        data-link="{{ $it['link'] }}"
                        tabindex="0"
                        role="button"
                        aria-label="{{ $it['title'] !== '' ? $it['title'] : __('Open image') }}">
                    <span class="rj-pg-in">
                        <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}" loading="lazy">
                        <span class="rj-pg-wash"></span>
                        <span class="rj-pg-glare"></span>
                        <span class="rj-pg-no">{{ sprintf('%02d', $i + 1) }}</span>
                        <span class="rj-pg-eye" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 9V4h5M20 9V4h-5M4 15v5h5M20 15v5h-5"/></svg>
                        </span>
                        <span class="rj-pg-cap">
                            <span class="rj-pg-cat">{{ $it['category'] }}</span>
                            @if($it['title'] !== '')
                                <span class="rj-pg-name">{{ $it['title'] }}</span>
                            @endif
                        </span>
                    </span>
                </figure>
            @endforeach
        </div>
    @else
        <div class="rj-pg-empty">{{ __('Please add at least one portfolio item.') }}</div>
    @endif

    <div class="rj-pg-lb" role="dialog" aria-modal="true">
        <span class="rj-pg-count"></span>
        <button type="button" class="rj-pg-btn rj-pg-x" data-x aria-label="{{ __('Close') }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="rj-pg-stage" data-stage>
            <button type="button" class="rj-pg-btn rj-pg-prev" data-prev aria-label="{{ __('Previous') }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
            </button>
            <img class="rj-pg-big" src="" alt="">
            <button type="button" class="rj-pg-btn rj-pg-next" data-next aria-label="{{ __('Next') }}">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
            </button>
        </div>
        <div class="rj-pg-meta">
            <span class="rj-pg-mcat"></span>
            <span class="rj-pg-mtitle"></span>
            <a class="rj-pg-open" href="#" target="_blank" rel="noopener noreferrer">{{ __('Open') }}</a>
        </div>
        <div class="rj-pg-thumbs"></div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    var cards = [].slice.call(root.querySelectorAll('.rj-pg-card'));
    var chips = [].slice.call(root.querySelectorAll('.rj-pg-chip'));
    var ind = root.querySelector('.rj-pg-ind');
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;

    function go() {
        root.classList.add('is-in');
        setTimeout(function () { root.classList.add('is-ready'); }, 1900);
    }
    if (!('IntersectionObserver' in window)) {
        go();
    } else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { go(); io.disconnect(); }
            });
        }, { threshold: 0.1 });
        io.observe(root);
        setTimeout(function () { if (!root.classList.contains('is-in')) go(); }, 2500);
    }

    function moveInd(btn) {
        if (!ind || !btn) return;
        ind.style.width = btn.offsetWidth + 'px';
        ind.style.transform = 'translateX(' + btn.offsetLeft + 'px)';
    }
    function activeChip() {
        return chips.filter(function (c) { return c.classList.contains('is-active'); })[0];
    }
    if (chips.length) {
        moveInd(activeChip());
        window.addEventListener('resize', function () { moveInd(activeChip()); });
        setTimeout(function () { moveInd(activeChip()); }, 300);
    }

    function visible() {
        return cards.filter(function (c) { return !c.classList.contains('is-hidden'); });
    }

    function filter(cat) {
        var first = new Map();
        cards.forEach(function (c) {
            if (!c.classList.contains('is-hidden')) first.set(c, c.getBoundingClientRect());
        });
        cards.forEach(function (c) {
            var show = cat === '' || c.getAttribute('data-cat') === cat;
            c.classList.toggle('is-hidden', !show);
        });
        if (reduce || !cards[0].animate) return;
        cards.forEach(function (c) {
            if (c.classList.contains('is-hidden')) return;
            var f = first.get(c);
            var l = c.getBoundingClientRect();
            if (f && l.width && l.height) {
                var dx = f.left - l.left;
                var dy = f.top - l.top;
                var sx = f.width / l.width;
                var sy = f.height / l.height;
                if (dx || dy || sx !== 1 || sy !== 1) {
                    c.animate([
                        { transformOrigin: 'top left', transform: 'translate(' + dx + 'px,' + dy + 'px) scale(' + sx + ',' + sy + ')' },
                        { transformOrigin: 'top left', transform: 'none' }
                    ], { duration: 650, easing: 'cubic-bezier(.2,.8,.2,1)' });
                }
            } else {
                c.animate([
                    { opacity: 0, transform: 'scale(.82) translateY(24px)' },
                    { opacity: 1, transform: 'none' }
                ], { duration: 600, easing: 'cubic-bezier(.2,.8,.2,1)' });
            }
        });
    }

    chips.forEach(function (btn) {
        btn.addEventListener('click', function () {
            chips.forEach(function (c) { c.classList.toggle('is-active', c === btn); });
            moveInd(btn);
            filter(btn.getAttribute('data-cat') || '');
        });
    });

    if (canHover && !reduce) {
        cards.forEach(function (card) {
            var box = card.querySelector('.rj-pg-in');
            card.addEventListener('mousemove', function (e) {
                var r = card.getBoundingClientRect();
                var px = (e.clientX - r.left) / r.width;
                var py = (e.clientY - r.top) / r.height;
                box.style.setProperty('--ry', ((px - 0.5) * 12).toFixed(2) + 'deg');
                box.style.setProperty('--rx', ((0.5 - py) * 12).toFixed(2) + 'deg');
                box.style.setProperty('--gx', (px * 100).toFixed(1) + '%');
                box.style.setProperty('--gy', (py * 100).toFixed(1) + '%');
            });
            card.addEventListener('mouseleave', function () {
                box.style.setProperty('--rx', '0deg');
                box.style.setProperty('--ry', '0deg');
            });
        });
    }

    var lb = root.querySelector('.rj-pg-lb');
    var big = lb.querySelector('.rj-pg-big');
    var count = lb.querySelector('.rj-pg-count');
    var mcat = lb.querySelector('.rj-pg-mcat');
    var mtitle = lb.querySelector('.rj-pg-mtitle');
    var open = lb.querySelector('.rj-pg-open');
    var thumbs = lb.querySelector('.rj-pg-thumbs');
    var list = [];
    var pos = 0;
    var startX = null;

    function buildThumbs() {
        thumbs.innerHTML = '';
        list.forEach(function (c, i) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'rj-pg-th';
            var im = document.createElement('img');
            im.src = c.getAttribute('data-src');
            im.alt = '';
            b.appendChild(im);
            b.addEventListener('click', function () { show(i); });
            thumbs.appendChild(b);
        });
    }

    function show(i) {
        if (!list.length) return;
        pos = (i + list.length) % list.length;
        var c = list[pos];
        big.classList.remove('is-swap');
        void big.offsetWidth;
        big.src = c.getAttribute('data-src');
        big.alt = c.getAttribute('data-title') || '';
        big.classList.add('is-swap');
        count.textContent = (pos + 1) + ' / ' + list.length;
        mcat.textContent = c.getAttribute('data-cat') || '';
        mtitle.textContent = c.getAttribute('data-title') || '';
        var link = c.getAttribute('data-link') || '';
        if (link) {
            open.setAttribute('href', link);
            open.classList.add('is-on');
        } else {
            open.classList.remove('is-on');
        }
        [].slice.call(thumbs.children).forEach(function (t, k) {
            t.classList.toggle('is-on', k === pos);
            if (k === pos && t.scrollIntoView) {
                t.scrollIntoView({ block: 'nearest', inline: 'center', behavior: reduce ? 'auto' : 'smooth' });
            }
        });
    }

    function openLb(card) {
        list = visible();
        buildThumbs();
        show(Math.max(0, list.indexOf(card)));
        lb.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeLb() {
        lb.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    cards.forEach(function (c) {
        c.addEventListener('click', function () { openLb(c); });
        c.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openLb(c);
            }
        });
    });

    lb.querySelector('[data-x]').addEventListener('click', closeLb);
    lb.querySelector('[data-prev]').addEventListener('click', function (e) { e.stopPropagation(); show(pos - 1); });
    lb.querySelector('[data-next]').addEventListener('click', function (e) { e.stopPropagation(); show(pos + 1); });
    lb.querySelector('[data-stage]').addEventListener('click', function (e) {
        if (e.target === e.currentTarget) closeLb();
    });
    lb.addEventListener('click', function (e) { if (e.target === lb) closeLb(); });

    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('is-open')) return;
        if (e.key === 'Escape') closeLb();
        if (e.key === 'ArrowLeft') show(pos - 1);
        if (e.key === 'ArrowRight') show(pos + 1);
    });

    lb.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 50) show(dx < 0 ? pos + 1 : pos - 1);
        startX = null;
    }, { passive: true });
})();
</script>
