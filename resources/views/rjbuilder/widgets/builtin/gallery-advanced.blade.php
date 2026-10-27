@php
    $subtitle   = $settings['subtitle'] ?? '';
    $title      = $settings['title'] ?? '';
    $showFilter = !empty($settings['show_filter'] ?? true);
    $showSort   = !empty($settings['show_sort'] ?? true);
    $layout     = ($settings['layout'] ?? 'masonry') === 'grid' ? 'grid' : 'masonry';
    $columns    = max(2, min(4, (int) ($settings['columns'] ?? 3)));
    $gapMap     = ['sm' => '10px', 'md' => '16px', 'lg' => '24px'];
    $gapPx      = $gapMap[$settings['gap'] ?? 'md'] ?? '16px';

    $accent = trim((string) ($settings['accent'] ?? '#14b8a6'));
    if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $accent)) {
        $accent = '#14b8a6';
    }
    $ah = ltrim($accent, '#');
    if (strlen($ah) === 3) {
        $ah = $ah[0] . $ah[0] . $ah[1] . $ah[1] . $ah[2] . $ah[2];
    }
    $accent = '#' . strtolower($ah);
    $accentRgb = hexdec(substr($ah, 0, 2)) . ',' . hexdec(substr($ah, 2, 2)) . ',' . hexdec(substr($ah, 4, 2));

    $canon = [];
    foreach (explode(',', (string) ($settings['categories'] ?? '')) as $c) {
        $c = trim($c);
        if ($c !== '' && !isset($canon[mb_strtolower($c)])) {
            $canon[mb_strtolower($c)] = $c;
        }
    }

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
            if ($cat === '') {
                $cat = __('Uncategorized');
            }
            $key = mb_strtolower($cat);
            if (!isset($canon[$key])) {
                $canon[$key] = $cat;
            }
            $items[] = [
                'image'    => $img,
                'title'    => (string) ($row['title'] ?? ''),
                'category' => $canon[$key],
            ];
        }
    }

    $counts = [];
    foreach ($canon as $name) {
        $counts[$name] = 0;
    }
    foreach ($items as $it) {
        $counts[$it['category']]++;
    }
    $unc = __('Uncategorized');
    if (isset($counts[$unc]) && $counts[$unc] === 0) {
        unset($counts[$unc]);
    }
    $hasAside = $showFilter && count($counts) > 0 && !empty($items);
@endphp

@once
<style>
    @keyframes rjGxPop {
        from { opacity: 0; transform: translateY(26px) scale(.95); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjGxFade {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjGxSwap {
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
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rj-gx-top {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        max-width: 1280px;
        margin: 0 auto 36px;
    }
    #{{ $uid }} .rj-gx-sub {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 12px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--a);
    }
    #{{ $uid }} .rj-gx-sub::before {
        content: "";
        width: 0;
        height: 2px;
        border-radius: 2px;
        background: var(--a);
        transition: width .9s cubic-bezier(.2,.8,.2,1) .2s;
    }
    #{{ $uid }}.is-in .rj-gx-sub::before { width: 32px; }
    #{{ $uid }} .rj-gx-title {
        margin: 0;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -.03em;
        color: #0f172a;
    }
    @media (min-width: 768px) { #{{ $uid }} .rj-gx-title { font-size: 48px; } }
    #{{ $uid }}:not(.is-in) .rj-gx-top { opacity: 0; }
    #{{ $uid }}.is-in .rj-gx-top { animation: rjGxFade .8s cubic-bezier(.2,.8,.2,1) backwards; }

    #{{ $uid }} .rj-gx-sort {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #64748b;
    }
    #{{ $uid }} .rj-gx-sort select {
        appearance: none;
        -webkit-appearance: none;
        padding: 11px 38px 11px 16px;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%23475569' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 14px center;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0;
        text-transform: none;
        color: #0f172a;
        cursor: pointer;
        transition: border-color .3s ease, box-shadow .3s ease;
    }
    #{{ $uid }} .rj-gx-sort select:hover,
    #{{ $uid }} .rj-gx-sort select:focus {
        outline: none;
        border-color: var(--a);
        box-shadow: 0 0 0 4px rgba(var(--ar), .15);
    }

    #{{ $uid }} .rj-gx-wrap {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 40px;
        max-width: 1280px;
        margin: 0 auto;
        align-items: start;
    }
    #{{ $uid }} .rj-gx-wrap.has-aside { grid-template-columns: 250px minmax(0, 1fr); }

    #{{ $uid }} .rj-gx-aside {
        position: sticky;
        top: 24px;
        display: block;
    }
    #{{ $uid }} .rj-gx-aside-h {
        margin: 0 0 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: #94a3b8;
    }
    #{{ $uid }} .rj-gx-list { display: flex; flex-direction: column; gap: 4px; }
    #{{ $uid }} .rj-gx-cat {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px 14px 12px 18px;
        border: 0;
        border-radius: 14px;
        background: transparent;
        text-align: left;
        font-family: inherit;
        cursor: pointer;
        color: #475569;
        transition: background-color .35s ease, color .35s ease, transform .45s cubic-bezier(.34,1.5,.64,1);
    }
    #{{ $uid }} .rj-gx-cat::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 4px;
        height: 0;
        border-radius: 4px;
        background: var(--a);
        transform: translateY(-50%);
        transition: height .45s cubic-bezier(.34,1.5,.64,1);
    }
    #{{ $uid }} .rj-gx-no {
        flex: 0 0 auto;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .1em;
        font-variant-numeric: tabular-nums;
        opacity: .5;
    }
    #{{ $uid }} .rj-gx-nm {
        flex: 1 1 auto;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 15px;
        font-weight: 700;
    }
    #{{ $uid }} .rj-gx-ct {
        flex: 0 0 auto;
        min-width: 28px;
        padding: 3px 8px;
        border-radius: 999px;
        text-align: center;
        font-size: 11px;
        font-weight: 800;
        background: #f1f5f9;
        color: #64748b;
        transition: background-color .35s ease, color .35s ease;
    }
    #{{ $uid }} .rj-gx-cat.is-zero { opacity: .5; }
    #{{ $uid }} .rj-gx-cat:hover { background: rgba(var(--ar), .08); color: #0f172a; transform: translateX(4px); }
    #{{ $uid }} .rj-gx-cat.is-active,
    #{{ $uid }} .rj-gx-cat.is-active:hover {
        background: var(--a);
        color: #fff;
        opacity: 1;
        transform: translateX(8px);
        box-shadow: 0 16px 28px -16px var(--a);
    }
    #{{ $uid }} .rj-gx-cat.is-active::before { height: 60%; left: -8px; }
    #{{ $uid }} .rj-gx-cat.is-active .rj-gx-no { opacity: .8; }
    #{{ $uid }} .rj-gx-cat.is-active .rj-gx-ct { background: rgba(255,255,255,.25); color: #fff; }
    #{{ $uid }} .rj-gx-cat:focus-visible { outline: 3px solid var(--a); outline-offset: 2px; }

    #{{ $uid }} .rj-gx-now {
        display: flex;
        align-items: baseline;
        gap: 14px;
        margin: 0 0 22px;
    }
    #{{ $uid }} .rj-gx-now b {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
    }
    #{{ $uid }} .rj-gx-now span {
        font-size: 13px;
        font-weight: 700;
        color: var(--a);
    }
    #{{ $uid }} .rj-gx-now.is-swap { animation: rjGxFade .5s cubic-bezier(.2,.8,.2,1); }

    #{{ $uid }} .rj-gx-grid[data-layout="masonry"] {
        column-count: {{ $columns }};
        column-gap: {{ $gapPx }};
    }
    #{{ $uid }} .rj-gx-grid[data-layout="grid"] {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: {{ $gapPx }};
    }
    #{{ $uid }} .rj-gx-wrap.has-aside .rj-gx-grid[data-layout="masonry"] { column-count: {{ min($columns, 3) }}; }
    #{{ $uid }} .rj-gx-wrap.has-aside .rj-gx-grid[data-layout="grid"] { grid-template-columns: repeat({{ min($columns, 3) }}, minmax(0, 1fr)); }

    #{{ $uid }} .rj-gx-item {
        position: relative;
        display: block;
        break-inside: avoid;
        margin: 0 0 {{ $gapPx }};
        border-radius: 20px;
        overflow: hidden;
        background: #e2e8f0;
        cursor: pointer;
        outline: none;
        box-shadow: 0 18px 36px -26px rgba(15,23,42,.5);
        transition: box-shadow .5s ease;
    }
    #{{ $uid }} .rj-gx-grid[data-layout="grid"] .rj-gx-item { margin: 0; aspect-ratio: 1 / 1; }
    #{{ $uid }}:not(.is-in) .rj-gx-item { opacity: 0; }
    #{{ $uid }} .rj-gx-item.is-pop { animation: rjGxPop .8s cubic-bezier(.2,.8,.2,1) var(--d, 0s) backwards; }
    #{{ $uid }} .rj-gx-item.is-hidden { display: none; }
    #{{ $uid }} .rj-gx-item img {
        display: block;
        width: 100%;
        height: auto;
        transition: transform 1s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-gx-grid[data-layout="grid"] .rj-gx-item img { height: 100%; object-fit: cover; }
    #{{ $uid }} .rj-gx-item::after {
        content: "";
        position: absolute;
        inset: 12px;
        border: 2px solid rgba(255,255,255,.9);
        border-radius: 12px;
        opacity: 0;
        transform: scale(1.06);
        transition: opacity .4s ease, transform .6s cubic-bezier(.2,.8,.2,1);
        pointer-events: none;
    }
    #{{ $uid }} .rj-gx-item:hover,
    #{{ $uid }} .rj-gx-item:focus-visible { box-shadow: 0 30px 50px -26px rgba(var(--ar), .7); }
    #{{ $uid }} .rj-gx-item:hover img,
    #{{ $uid }} .rj-gx-item:focus-visible img { transform: scale(1.07); }
    #{{ $uid }} .rj-gx-item:hover::after,
    #{{ $uid }} .rj-gx-item:focus-visible::after { opacity: 1; transform: none; }
    #{{ $uid }} .rj-gx-item:focus-visible { outline: 3px solid var(--a); outline-offset: 3px; }

    #{{ $uid }} .rj-gx-cap {
        position: absolute;
        left: 22px;
        right: 22px;
        bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 12px;
        background: rgba(255,255,255,.92);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        opacity: 0;
        transform: translateY(18px);
        transition: opacity .4s ease, transform .6s cubic-bezier(.34,1.4,.64,1);
        pointer-events: none;
    }
    #{{ $uid }} .rj-gx-cap i {
        flex: 0 0 auto;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: var(--a);
    }
    #{{ $uid }} .rj-gx-cap span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }
    #{{ $uid }} .rj-gx-cap em {
        margin-left: auto;
        flex: 0 0 auto;
        font-style: normal;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #64748b;
    }
    #{{ $uid }} .rj-gx-item:hover .rj-gx-cap,
    #{{ $uid }} .rj-gx-item:focus-visible .rj-gx-cap { opacity: 1; transform: none; }
    @media (hover: none) {
        #{{ $uid }} .rj-gx-cap { opacity: 1; transform: none; }
    }

    #{{ $uid }} .rj-gx-none,
    #{{ $uid }} .rj-gx-empty {
        display: none;
        padding: 56px 24px;
        text-align: center;
        font-size: 14px;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
    }
    #{{ $uid }} .rj-gx-none.is-on,
    #{{ $uid }} .rj-gx-empty { display: block; }
    #{{ $uid }} .rj-gx-empty { max-width: 560px; margin: 0 auto; }

    #{{ $uid }} .rj-gx-lb {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 40px 80px 90px;
        background: #020617;
        overflow: hidden;
    }
    #{{ $uid }} .rj-gx-lb.is-open { display: flex; animation: rjGxFade .35s ease both; }
    #{{ $uid }} .rj-gx-bg {
        position: absolute;
        inset: -60px;
        background-size: cover;
        background-position: center;
        filter: blur(50px) brightness(.4) saturate(1.4);
        transition: background-image .5s ease;
    }
    #{{ $uid }} .rj-gx-big {
        position: relative;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 18px;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.8);
    }
    #{{ $uid }} .rj-gx-big.is-swap { animation: rjGxSwap .45s cubic-bezier(.2,.8,.2,1) both; }
    #{{ $uid }} .rj-gx-bar {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        padding: 22px 24px 26px;
        text-align: center;
        color: #fff;
    }
    #{{ $uid }} .rj-gx-bar b { font-size: 17px; font-weight: 800; }
    #{{ $uid }} .rj-gx-bar span {
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        background: var(--a);
    }
    #{{ $uid }} .rj-gx-bar em {
        font-style: normal;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .14em;
        color: rgba(255,255,255,.65);
    }
    #{{ $uid }} .rj-gx-btn {
        position: absolute;
        z-index: 2;
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
    #{{ $uid }} .rj-gx-btn:hover { background: rgba(255,255,255,.26); transform: scale(1.1); }
    #{{ $uid }} .rj-gx-btn svg { display: block; width: 22px; height: 22px; }
    #{{ $uid }} .rj-gx-x { top: 20px; right: 20px; }
    #{{ $uid }} .rj-gx-pv { left: 20px; top: 50%; margin-top: -25px; }
    #{{ $uid }} .rj-gx-nx { right: 20px; top: 50%; margin-top: -25px; }

    @media (max-width: 960px) {
        #{{ $uid }} .rj-gx-wrap.has-aside { grid-template-columns: minmax(0, 1fr); gap: 24px; }
        #{{ $uid }} .rj-gx-aside { position: static; }
        #{{ $uid }} .rj-gx-aside-h { display: none; }
        #{{ $uid }} .rj-gx-list {
            flex-direction: row;
            gap: 8px;
            overflow-x: auto;
            padding: 4px 2px 10px;
            scrollbar-width: none;
        }
        #{{ $uid }} .rj-gx-list::-webkit-scrollbar { display: none; }
        #{{ $uid }} .rj-gx-cat {
            flex: 0 0 auto;
            width: auto;
            padding: 10px 16px;
            border-radius: 999px;
            background: #f1f5f9;
        }
        #{{ $uid }} .rj-gx-cat::before { display: none; }
        #{{ $uid }} .rj-gx-no { display: none; }
        #{{ $uid }} .rj-gx-cat:hover,
        #{{ $uid }} .rj-gx-cat.is-active,
        #{{ $uid }} .rj-gx-cat.is-active:hover { transform: none; }
        #{{ $uid }} .rj-gx-wrap.has-aside .rj-gx-grid[data-layout="masonry"] { column-count: 2; }
        #{{ $uid }} .rj-gx-wrap.has-aside .rj-gx-grid[data-layout="grid"] { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        #{{ $uid }} .rj-gx-grid[data-layout="masonry"] { column-count: 2; }
        #{{ $uid }} .rj-gx-grid[data-layout="grid"] { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-gx-wrap.has-aside .rj-gx-grid[data-layout="masonry"],
        #{{ $uid }} .rj-gx-grid[data-layout="masonry"] { column-count: 1; }
        #{{ $uid }} .rj-gx-wrap.has-aside .rj-gx-grid[data-layout="grid"],
        #{{ $uid }} .rj-gx-grid[data-layout="grid"] { grid-template-columns: 1fr; }
        #{{ $uid }} .rj-gx-lb { padding: 64px 14px 100px; }
        #{{ $uid }} .rj-gx-pv { left: 10px; top: auto; bottom: 20px; margin-top: 0; }
        #{{ $uid }} .rj-gx-nx { right: 10px; top: auto; bottom: 20px; margin-top: 0; }
        #{{ $uid }} .rj-gx-x { top: 12px; right: 12px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}, #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-gx-item, #{{ $uid }} .rj-gx-top { opacity: 1 !important; }
    }
</style>

<div id="{{ $uid }}">
    @if(!empty($items))
        @if($title || $subtitle || $showSort)
            <div class="rj-gx-top">
                <header>
                    @if($subtitle)
                        <p class="rj-gx-sub">{{ $subtitle }}</p>
                    @endif
                    @if($title)
                        <h2 class="rj-gx-title">{{ $title }}</h2>
                    @endif
                </header>
                @if($showSort)
                    <label class="rj-gx-sort">
                        <span>{{ __('Sort') }}</span>
                        <select data-sort>
                            <option value="default">{{ __('Default') }}</option>
                            <option value="asc">{{ __('Title A → Z') }}</option>
                            <option value="desc">{{ __('Title Z → A') }}</option>
                        </select>
                    </label>
                @endif
            </div>
        @endif

        <div class="rj-gx-wrap {{ $hasAside ? 'has-aside' : '' }}">
            @if($hasAside)
                <aside class="rj-gx-aside">
                    <p class="rj-gx-aside-h">{{ __('Categories') }}</p>
                    <div class="rj-gx-list">
                        <button type="button" class="rj-gx-cat is-active" data-cat="" aria-pressed="true">
                            <span class="rj-gx-no">00</span>
                            <span class="rj-gx-nm">{{ __('All') }}</span>
                            <span class="rj-gx-ct">{{ count($items) }}</span>
                        </button>
                        @php $n = 0; @endphp
                        @foreach($counts as $catName => $catCount)
                            @php $n++; @endphp
                            <button type="button" class="rj-gx-cat {{ $catCount === 0 ? 'is-zero' : '' }}" data-cat="{{ $catName }}" aria-pressed="false">
                                <span class="rj-gx-no">{{ sprintf('%02d', $n) }}</span>
                                <span class="rj-gx-nm">{{ $catName }}</span>
                                <span class="rj-gx-ct">{{ $catCount }}</span>
                            </button>
                        @endforeach
                    </div>
                </aside>
            @endif

            <div class="rj-gx-main">
                @if($hasAside)
                    <div class="rj-gx-now" data-now>
                        <b data-now-name>{{ __('All') }}</b>
                        <span data-now-count>{{ count($items) }} {{ __('items') }}</span>
                    </div>
                @endif

                <div class="rj-gx-grid" data-layout="{{ $layout }}">
                    @foreach($items as $i => $it)
                        <figure class="rj-gx-item"
                                style="--d: {{ number_format(min($i, 14) * 0.06, 2, '.', '') }}s;"
                                data-cat="{{ $it['category'] }}"
                                data-src="{{ $it['image'] }}"
                                data-title="{{ $it['title'] }}"
                                data-order="{{ $i }}"
                                tabindex="0"
                                role="button"
                                aria-label="{{ $it['title'] !== '' ? $it['title'] : __('Open image') }}">
                            <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}" loading="lazy">
                            <span class="rj-gx-cap">
                                <i></i>
                                <span>{{ $it['title'] !== '' ? $it['title'] : $it['category'] }}</span>
                                @if($it['title'] !== '')
                                    <em>{{ $it['category'] }}</em>
                                @endif
                            </span>
                        </figure>
                    @endforeach
                </div>
                <div class="rj-gx-none" data-none>{{ __('There are no images in this category yet.') }}</div>
            </div>
        </div>
    @else
        <div class="rj-gx-empty">{{ __('Please add at least one gallery item.') }}</div>
    @endif

    <div class="rj-gx-lb" role="dialog" aria-modal="true">
        <div class="rj-gx-bg"></div>
        <button type="button" class="rj-gx-btn rj-gx-x" data-x aria-label="{{ __('Close') }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button type="button" class="rj-gx-btn rj-gx-pv" data-prev aria-label="{{ __('Previous') }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
        </button>
        <img class="rj-gx-big" src="" alt="">
        <button type="button" class="rj-gx-btn rj-gx-nx" data-next aria-label="{{ __('Next') }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
        </button>
        <div class="rj-gx-bar">
            <span data-lcat></span>
            <b data-ltitle></b>
            <em data-lcount></em>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    var grid = root.querySelector('.rj-gx-grid');
    if (!grid) return;

    var items = [].slice.call(grid.querySelectorAll('.rj-gx-item'));
    var cats = [].slice.call(root.querySelectorAll('.rj-gx-cat'));
    var sortSel = root.querySelector('[data-sort]');
    var now = root.querySelector('[data-now]');
    var nowName = root.querySelector('[data-now-name]');
    var nowCount = root.querySelector('[data-now-count]');
    var none = root.querySelector('[data-none]');
    var total = items.length;
    var itemsLabel = @json(__('items'));
    var allLabel = @json(__('All'));
    var active = '';

    function visible() {
        return items.filter(function (el) { return !el.classList.contains('is-hidden'); });
    }

    function replay() {
        var k = 0;
        visible().forEach(function (el) {
            el.classList.remove('is-pop');
            el.style.setProperty('--d', (Math.min(k, 14) * 0.05).toFixed(2) + 's');
            k++;
        });
        void grid.offsetWidth;
        visible().forEach(function (el) { el.classList.add('is-pop'); });
    }

    function apply() {
        items.forEach(function (el) {
            var show = active === '' || el.getAttribute('data-cat') === active;
            el.classList.toggle('is-hidden', !show);
        });
        cats.forEach(function (b) {
            var on = b.getAttribute('data-cat') === active;
            b.classList.toggle('is-active', on);
            b.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        var n = visible().length;
        if (now) {
            nowName.textContent = active === '' ? allLabel : active;
            nowCount.textContent = n + ' ' + itemsLabel;
            now.classList.remove('is-swap');
            void now.offsetWidth;
            now.classList.add('is-swap');
        }
        if (none) none.classList.toggle('is-on', n === 0);
        replay();
    }

    cats.forEach(function (b) {
        b.addEventListener('click', function () {
            active = b.getAttribute('data-cat') || '';
            apply();
        });
    });

    if (sortSel) {
        sortSel.addEventListener('change', function () {
            var arr = items.slice();
            var v = sortSel.value;
            if (v === 'asc') {
                arr.sort(function (a, b) { return (a.getAttribute('data-title') || '').localeCompare(b.getAttribute('data-title') || ''); });
            } else if (v === 'desc') {
                arr.sort(function (a, b) { return (b.getAttribute('data-title') || '').localeCompare(a.getAttribute('data-title') || ''); });
            } else {
                arr.sort(function (a, b) { return (+a.getAttribute('data-order')) - (+b.getAttribute('data-order')); });
            }
            arr.forEach(function (el) { grid.appendChild(el); });
            items = arr;
            replay();
        });
    }

    var lb = root.querySelector('.rj-gx-lb');
    var bg = lb.querySelector('.rj-gx-bg');
    var big = lb.querySelector('.rj-gx-big');
    var lcat = lb.querySelector('[data-lcat]');
    var ltitle = lb.querySelector('[data-ltitle]');
    var lcount = lb.querySelector('[data-lcount]');
    var list = [];
    var pos = 0;
    var startX = null;

    function show(i) {
        if (!list.length) return;
        pos = (i + list.length) % list.length;
        var el = list[pos];
        var src = el.getAttribute('data-src');
        big.classList.remove('is-swap');
        void big.offsetWidth;
        big.src = src;
        big.alt = el.getAttribute('data-title') || '';
        big.classList.add('is-swap');
        bg.style.backgroundImage = 'url("' + src.replace(/"/g, '%22') + '")';
        lcat.textContent = el.getAttribute('data-cat') || '';
        ltitle.textContent = el.getAttribute('data-title') || '';
        lcount.textContent = (pos + 1) + ' / ' + list.length;
    }

    function openLb(el) {
        list = visible();
        show(Math.max(0, list.indexOf(el)));
        lb.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeLb() {
        lb.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    items.forEach(function (el) {
        el.addEventListener('click', function () { openLb(el); });
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openLb(el);
            }
        });
    });

    lb.querySelector('[data-x]').addEventListener('click', closeLb);
    lb.querySelector('[data-prev]').addEventListener('click', function (e) { e.stopPropagation(); show(pos - 1); });
    lb.querySelector('[data-next]').addEventListener('click', function (e) { e.stopPropagation(); show(pos + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb || e.target === bg) closeLb(); });

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

    function go() {
        if (root.classList.contains('is-in')) return;
        root.classList.add('is-in');
        items.forEach(function (el) { el.classList.add('is-pop'); });
    }
    if (!('IntersectionObserver' in window)) {
        go();
    } else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { go(); io.disconnect(); }
            });
        }, { threshold: 0.08 });
        io.observe(root);
        setTimeout(go, 2500);
    }
})();
</script>
