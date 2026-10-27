@php
    $safeColor = function ($value, $default) {
        $value = trim((string) $value);
        return preg_match('/^#[0-9a-fA-F]{3,8}$/', $value) ? $value : $default;
    };
    $bool = function ($key, $default) use ($settings) {
        return array_key_exists($key, $settings)
            ? filter_var($settings[$key], FILTER_VALIDATE_BOOLEAN)
            : $default;
    };

    $title      = $settings['title'] ?? __('Currency Rates');
    $subtitle   = $settings['subtitle'] ?? '';
    $apiSource  = $settings['api_source'] ?? 'exchangerate_host';
    $apiKey     = trim($settings['api_key'] ?? '');
    $base       = strtoupper(preg_replace('/[^A-Za-z]/', '', $settings['base'] ?? 'AZN')) ?: 'AZN';
    $refresh    = (int) ($settings['refresh'] ?? 3600);
    $mode       = ($settings['mode'] ?? 'auto') === 'custom' ? 'custom' : 'auto';
    $initial    = (int) ($settings['initial_count'] ?? 24);

    // old values (table/cards) are still understood
    $layoutRaw  = $settings['layout'] ?? 'grid';
    $layout     = ['table' => 'list', 'cards' => 'grid'][$layoutRaw] ?? $layoutRaw;
    if (!in_array($layout, ['grid', 'list', 'compact'], true)) {
        $layout = 'grid';
    }

    $accent     = $safeColor($settings['accent'] ?? '', '#1f4fff');
    $textColor  = $safeColor($settings['text_color'] ?? '', '#0e1a2b');
    $bgColor    = $safeColor($settings['bg_color'] ?? '', '#eef1f7');
    $paddingY   = (int) ($settings['padding_y'] ?? 40);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'lg' => '18px', 'xl' => '28px'];
    $radiusCss = $radiusMap[$settings['radius'] ?? 'lg'] ?? '18px';

    $currencyList = [];
    if (!empty($settings['currencies']) && is_array($settings['currencies'])) {
        foreach ($settings['currencies'] as $row) {
            if (!is_array($row)) continue;
            $code = strtoupper(trim($row['code'] ?? ''));
            if (!preg_match('/^[A-Z]{3}$/', $code)) continue;
            $currencyList[] = [
                'code' => $code,
                'name' => trim($row['name'] ?? ''),
                'flag' => trim($row['flag'] ?? ''),
            ];
        }
    }
    if (empty($currencyList)) {
        foreach (['USD','EUR','GBP','TRY','RUB','GEL','KZT','UAH','AED','CNY','JPY','CHF','CAD','AUD','SAR','IRR','INR','PLN'] as $code) {
            $currencyList[] = ['code' => $code, 'name' => '', 'flag' => ''];
        }
    }

    $cfg = [
        'layout'        => $layout,
        'base'          => $base,
        'source'        => $apiSource,
        'key'           => $apiKey,
        'refresh'       => $refresh,
        'mode'          => $mode,
        'initial'       => max(0, $initial),
        'extra'         => $bool('show_extra', false),
        'showFlags'     => $bool('show_flags', true),
        'showChange'    => $bool('show_change', true),
        'showSearch'    => $bool('show_search', true),
        'showConverter' => $bool('show_converter', true),
        'currencies'    => $currencyList,
    ];
@endphp

<style>
    #{{ $uid }} {
        --a: {{ $accent }};
        --t: {{ $textColor }};
        --b: {{ $bgColor }};
        --r: {{ $radiusCss }};
        --paper: color-mix(in srgb, var(--b) 55%, #fff);
        --tint:  color-mix(in srgb, var(--t) 6%, var(--paper));
        --ln:    color-mix(in srgb, var(--t) 14%, transparent);
        --mu:    color-mix(in srgb, var(--t) 60%, var(--paper));
        --up: #0f9d6b;
        --dn: #d6336c;
        width: 100%;
        box-sizing: border-box;
        padding: {{ $paddingY }}px 16px;
        color: var(--t);
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} [hidden] { display: none !important; }
    #{{ $uid }} button { font: inherit; color: inherit; cursor: pointer; }
    #{{ $uid }} :focus-visible { outline: 2px solid var(--a); outline-offset: 2px; }

    .rjc2-wrap { max-width: 980px; margin: 0 auto; }
    .rjc2-panel {
        background: var(--paper);
        border: 1px solid var(--ln);
        border-radius: var(--r);
        overflow: hidden;
    }

    /* ---------- header ---------- */
    .rjc2-head {
        display: flex; align-items: flex-end; justify-content: space-between;
        gap: 16px; flex-wrap: wrap;
        padding: 26px 28px 20px;
    }
    .rjc2-title { margin: 0; font-size: 30px; line-height: 1.1; font-weight: 800; letter-spacing: -.03em; }
    .rjc2-sub { margin: 6px 0 0; font-size: 14px; color: var(--mu); }
    .rjc2-meta { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--mu); }
    .rjc2-live { display: inline-flex; align-items: center; gap: 7px; }
    .rjc2-live i { width: 8px; height: 8px; border-radius: 50%; background: var(--up); }
    .rjc2-live.is-stale i { background: #e0a100; }
    .rjc2-live.is-busy i { animation: rjc2Blink 1s ease-in-out infinite; }
    @keyframes rjc2Blink { 50% { opacity: .25; } }
    .rjc2-iconbtn {
        display: inline-grid; place-items: center; width: 32px; height: 32px;
        border: 1px solid var(--ln); border-radius: 50%; background: transparent;
    }
    .rjc2-iconbtn:hover { background: var(--tint); }
    .rjc2-iconbtn svg { width: 14px; height: 14px; }
    .rjc2-iconbtn.is-spin svg { animation: rjc2Spin .8s linear infinite; }
    @keyframes rjc2Spin { to { transform: rotate(360deg); } }

    /* ---------- converter ---------- */
    .rjc2-conv {
        display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        padding: 18px 28px;
        background: var(--t);
        color: var(--paper);
    }
    .rjc2-conv-in {
        width: 150px; max-width: 100%;
        font: inherit; font-size: 28px; font-weight: 800; letter-spacing: -.02em;
        font-variant-numeric: tabular-nums;
        color: inherit; background: transparent;
        border: 0; border-bottom: 2px solid color-mix(in srgb, var(--paper) 35%, transparent);
        padding: 2px 0;
    }
    .rjc2-conv-in:focus { outline: none; border-bottom-color: var(--paper); }
    .rjc2-conv-out { font-size: 28px; font-weight: 800; letter-spacing: -.02em; font-variant-numeric: tabular-nums; }
    .rjc2-conv-tag, .rjc2-conv select {
        font: inherit; font-size: 14px; font-weight: 700;
        padding: 7px 12px; border-radius: 999px;
        color: var(--paper); background: color-mix(in srgb, var(--paper) 14%, transparent);
        border: 1px solid color-mix(in srgb, var(--paper) 25%, transparent);
    }
    .rjc2-conv select option { color: #111; background: #fff; }
    .rjc2-conv-swap {
        width: 34px; height: 34px; border-radius: 50%;
        border: 1px solid color-mix(in srgb, var(--paper) 30%, transparent);
        background: transparent; color: inherit; font-size: 16px; line-height: 1;
    }
    .rjc2-conv-swap:hover { background: color-mix(in srgb, var(--paper) 16%, transparent); }

    /* ---------- toolbar ---------- */
    .rjc2-bar {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
        padding: 14px 28px;
        border-bottom: 1px solid var(--ln);
    }
    .rjc2-search { position: relative; flex: 1 1 200px; min-width: 160px; }
    .rjc2-search svg { position: absolute; left: 12px; top: 50%; width: 15px; height: 15px; transform: translateY(-50%); color: var(--mu); }
    .rjc2-search input {
        width: 100%; font: inherit; font-size: 14px; color: var(--t);
        padding: 9px 12px 9px 34px; border-radius: 999px;
        border: 1px solid var(--ln); background: var(--paper);
    }
    .rjc2-search input::placeholder { color: var(--mu); }
    .rjc2-chips { display: flex; gap: 4px; padding: 3px; border-radius: 999px; background: var(--tint); }
    .rjc2-chip { border: 0; background: transparent; padding: 6px 12px; border-radius: 999px; font-size: 13px; font-weight: 600; color: var(--mu); }
    .rjc2-chip[aria-pressed="true"] { background: var(--paper); color: var(--t); box-shadow: 0 0 0 1px var(--ln); }
    .rjc2-sort {
        font: inherit; font-size: 13px; font-weight: 600; color: var(--t);
        padding: 8px 12px; border-radius: 999px; border: 1px solid var(--ln); background: var(--paper);
    }
    .rjc2-views { display: flex; gap: 2px; }
    .rjc2-view { width: 32px; height: 32px; display: grid; place-items: center; border: 0; border-radius: 8px; background: transparent; color: var(--mu); }
    .rjc2-view[aria-pressed="true"] { background: var(--tint); color: var(--a); }
    .rjc2-view svg { width: 16px; height: 16px; }

    .rjc2-notice {
        margin: 0; padding: 10px 28px; font-size: 13px;
        color: #8a4b00; background: color-mix(in srgb, #f5a524 16%, var(--paper));
        border-bottom: 1px solid var(--ln);
    }

    /* ---------- shared bits ---------- */
    .rjc2-badge {
        flex: none; width: 36px; height: 36px; display: grid; place-items: center;
        border-radius: 50%; background: var(--tint); border: 1px solid var(--ln);
        font-size: 20px; line-height: 1;
    }
    .rjc2-id { min-width: 0; display: flex; flex-direction: column; gap: 1px; }
    .rjc2-id b { font-size: 15px; letter-spacing: .01em; }
    .rjc2-id span { font-size: 12.5px; color: var(--mu); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .rjc2-star { flex: none; width: 28px; height: 28px; display: grid; place-items: center; border: 0; border-radius: 50%; background: transparent; color: var(--mu); }
    .rjc2-star:hover { background: var(--tint); }
    .rjc2-star svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 1.8; }
    .rjc2-star.on { color: #e0a100; }
    .rjc2-star.on svg { fill: currentColor; }
    .rjc2-chg {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 12.5px; font-weight: 700; font-variant-numeric: tabular-nums;
        padding: 3px 8px; border-radius: 6px; white-space: nowrap;
    }
    .rjc2-chg.up   { color: var(--up); background: color-mix(in srgb, var(--up) 12%, transparent); }
    .rjc2-chg.dn   { color: var(--dn); background: color-mix(in srgb, var(--dn) 12%, transparent); }
    .rjc2-chg.flat { color: var(--mu); background: var(--tint); }
    .rjc2-off { font-size: 13px; font-weight: 600; color: var(--dn); }

    /* ---------- grid: one lattice, shared hairlines ---------- */
    .rjc2-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 1px; background: var(--ln);
    }
    .rjc2-tile { display: flex; flex-direction: column; gap: 14px; padding: 18px 20px; background: var(--paper); border-left: 3px solid transparent; }
    .rjc2-tile.is-up { border-left-color: var(--up); }
    .rjc2-tile.is-dn { border-left-color: var(--dn); }
    .rjc2-tile-top { display: flex; align-items: center; gap: 10px; }
    .rjc2-tile-top .rjc2-id { flex: 1; }
    .rjc2-val { font-size: 30px; font-weight: 800; letter-spacing: -.035em; line-height: 1; font-variant-numeric: tabular-nums; }
    .rjc2-val small { margin-left: 6px; font-size: 13px; font-weight: 600; letter-spacing: 0; color: var(--mu); }
    .rjc2-tile-foot { display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 12.5px; color: var(--mu); }

    /* ---------- list / compact ---------- */
    .rjc2-list { display: flex; flex-direction: column; }
    .rjc2-row {
        display: grid; grid-template-columns: auto minmax(0, 1.4fr) minmax(0, 1fr) minmax(0, 1fr) auto auto;
        align-items: center; gap: 14px; padding: 12px 28px;
        border-bottom: 1px solid var(--ln);
    }
    .rjc2-row:last-child { border-bottom: 0; }
    .rjc2-row:hover { background: var(--tint); }
    .rjc2-row .rjc2-unit { font-size: 13px; color: var(--mu); }
    .rjc2-row .rjc2-val { font-size: 19px; text-align: right; letter-spacing: -.02em; }
    .rjc2-row .rjc2-off { grid-column: span 2; text-align: right; }
    .rjc2-compact .rjc2-row { padding-top: 7px; padding-bottom: 7px; }
    .rjc2-compact .rjc2-badge { width: 26px; height: 26px; font-size: 15px; }
    .rjc2-compact .rjc2-id span { display: none; }
    .rjc2-compact .rjc2-row .rjc2-val { font-size: 16px; }

    /* ---------- footer, states ---------- */
    .rjc2-foot {
        display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
        padding: 14px 28px; border-top: 1px solid var(--ln); font-size: 12.5px; color: var(--mu);
    }
    .rjc2-more { border: 1px solid var(--ln); background: var(--paper); padding: 8px 16px; border-radius: 999px; font-size: 13px; font-weight: 700; }
    .rjc2-more:hover { background: var(--tint); }
    .rjc2-empty { padding: 36px 28px; text-align: center; color: var(--mu); font-size: 14px; }
    .rjc2-error { padding: 40px 28px; text-align: center; }
    .rjc2-error p { margin: 0 0 14px; font-size: 15px; font-weight: 600; color: var(--dn); }
    .rjc2-retry { border: 0; background: var(--a); color: #fff; padding: 9px 18px; border-radius: 999px; font-weight: 700; font-size: 14px; }
    .rjc2-skel { padding: 8px 28px 24px; display: flex; flex-direction: column; gap: 14px; }
    .rjc2-skel div {
        height: 14px; border-radius: 4px;
        background: linear-gradient(90deg, var(--tint) 0%, var(--ln) 50%, var(--tint) 100%);
        background-size: 200% 100%; animation: rjc2Sh 1.4s linear infinite;
    }
    @keyframes rjc2Sh { from { background-position: 200% 0; } to { background-position: -200% 0; } }
    .rjc2-note { margin: 10px 4px 0; font-size: 12px; color: var(--mu); }

    @media (max-width: 640px) {
        .rjc2-head, .rjc2-bar, .rjc2-conv, .rjc2-foot, .rjc2-notice { padding-left: 18px; padding-right: 18px; }
        .rjc2-title { font-size: 25px; }
        .rjc2-row { grid-template-columns: auto minmax(0, 1fr) auto auto; padding: 12px 18px; gap: 10px; }
        .rjc2-row .rjc2-unit { display: none; }
        .rjc2-row .rjc2-val { grid-column: auto; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition: none !important; }
    }
</style>

<div id="{{ $uid }}" data-config="{{ json_encode($cfg, JSON_UNESCAPED_UNICODE) }}">
    <div class="rjc2-wrap">
        <div class="rjc2-panel">

            <header class="rjc2-head">
                <div>
                    @if($title)<h2 class="rjc2-title">{{ $title }}</h2>@endif
                    @if($subtitle)<p class="rjc2-sub">{{ $subtitle }}</p>@endif
                </div>
                <div class="rjc2-meta">
                    <span class="rjc2-live is-busy" data-status><i></i><span data-status-text>{{ __('Loading') }}…</span></span>
                    <button type="button" class="rjc2-iconbtn" data-refresh aria-label="{{ __('Refresh') }}" title="{{ __('Refresh') }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v6h6M20 20v-6h-6M20 10A8 8 0 006.3 6.3L4 10m16 4l-2.3 3.7A8 8 0 014 14"/></svg>
                    </button>
                </div>
            </header>

            <div data-state="loading" class="rjc2-skel">
                <div style="width:100%"></div><div style="width:86%"></div><div style="width:94%"></div><div style="width:72%"></div><div style="width:90%"></div>
            </div>

            <div data-state="error" class="rjc2-error" hidden>
                <p data-error-msg></p>
                <button type="button" class="rjc2-retry" data-retry>{{ __('Try again') }}</button>
            </div>

            <div data-state="ready" hidden>
                @if($cfg['showConverter'])
                    <div class="rjc2-conv" data-conv></div>
                @endif

                <div class="rjc2-bar">
                    @if($cfg['showSearch'])
                        <label class="rjc2-search">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M20 20l-3.5-3.5"/></svg>
                            <input type="search" data-search placeholder="{{ __('Search by name or code') }}" aria-label="{{ __('Search by name or code') }}" autocomplete="off">
                        </label>
                    @endif
                    <div class="rjc2-chips" role="group" aria-label="{{ __('Filter') }}">
                        <button type="button" class="rjc2-chip" data-filter="all" aria-pressed="true">{{ __('All') }}</button>
                        @if($cfg['showChange'])
                            <button type="button" class="rjc2-chip" data-filter="up" aria-pressed="false">{{ __('Rising') }}</button>
                            <button type="button" class="rjc2-chip" data-filter="dn" aria-pressed="false">{{ __('Falling') }}</button>
                        @endif
                        <button type="button" class="rjc2-chip" data-filter="fav" aria-pressed="false">{{ __('Starred') }}</button>
                    </div>
                    <select class="rjc2-sort" data-sort aria-label="{{ __('Sort') }}">
                        <option value="default">{{ __('Default order') }}</option>
                        <option value="az">{{ __('Code A–Z') }}</option>
                        <option value="rate">{{ __('Highest rate') }}</option>
                        @if($cfg['showChange'])<option value="change">{{ __('Biggest gain') }}</option>@endif
                    </select>
                    <div class="rjc2-views" role="group" aria-label="{{ __('Layout') }}">
                        <button type="button" class="rjc2-view" data-view="grid" aria-pressed="false" title="{{ __('Grid') }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="4" width="6" height="6"/><rect x="14" y="4" width="6" height="6"/><rect x="4" y="14" width="6" height="6"/><rect x="14" y="14" width="6" height="6"/></svg>
                        </button>
                        <button type="button" class="rjc2-view" data-view="list" aria-pressed="false" title="{{ __('List') }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        </button>
                        <button type="button" class="rjc2-view" data-view="compact" aria-pressed="false" title="{{ __('Compact') }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 5h16M4 9h16M4 13h16M4 17h16M4 21h16"/></svg>
                        </button>
                    </div>
                </div>

                <p class="rjc2-notice" data-notice hidden></p>

                <div data-list></div>

                <div class="rjc2-foot">
                    <span data-count></span>
                    <button type="button" class="rjc2-more" data-more hidden></button>
                </div>
            </div>
        </div>
        <p class="rjc2-note">{{ __('Rates are indicative and may differ from official bank rates.') }}</p>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var cfg;
    try { cfg = JSON.parse(root.getAttribute('data-config') || '{}'); } catch (e) { cfg = {}; }
    cfg.currencies = cfg.currencies || [];
    var base = cfg.base || 'AZN';
    var baseLc = base.toLowerCase();

    var T = {
        live: @js(__('Updated')),
        stale: @js(__('Offline, showing saved rates from')),
        loading: @js(__('Loading')),
        unavailable: @js(__('Not available from the rate source')),
        noResults: @js(__('No currency matches your search.')),
        showAll: @js(__('Show all')),
        showLess: @js(__('Show less')),
        currencies: @js(__('currencies')),
        amount: @js(__('Amount')),
        swap: @js(__('Swap direction')),
        star: @js(__('Add to starred')),
        unstar: @js(__('Remove from starred')),
        missing: @js(__('Not available from the source:')),
        error: @js(__('Could not load exchange rates. Check your connection and try again.'))
    };

    var CACHE_KEY = 'rj_cr2_' + base;
    var FAV_KEY = 'rj_cr2_fav';
    var lang = document.documentElement.lang || undefined;

    function $(sel) { return root.querySelector(sel); }
    var els = {
        loading: $('[data-state="loading"]'), error: $('[data-state="error"]'), ready: $('[data-state="ready"]'),
        errMsg: $('[data-error-msg]'), list: $('[data-list]'), more: $('[data-more]'), count: $('[data-count]'),
        notice: $('[data-notice]'), conv: $('[data-conv]'), status: $('[data-status]'), statusText: $('[data-status-text]'),
        refresh: $('[data-refresh]'), search: $('[data-search]'), sort: $('[data-sort]')
    };

    var state = {
        rates: null, extras: null, change: {}, ts: 0, stale: false, rows: [],
        query: '', sort: 'default', filter: 'all', expanded: false, view: cfg.layout || 'grid',
        favs: readFavs(), conv: { amount: 100, code: null, rev: false }
    };

    /* ---------- names & flags ---------- */
    var dn = null;
    try { dn = new Intl.DisplayNames([lang || 'az', 'en'], { type: 'currency', fallback: 'none' }); } catch (e) { dn = null; }

    function knownName(code) {
        try { return dn ? dn.of(code) || null : null; } catch (e) { return null; }
    }
    function nameOf(code, explicit) {
        if (explicit && explicit !== code) return explicit;
        return knownName(code) || code;
    }

    var FLAG_CC = {
        EUR: 'EU', ANG: 'CW', XCG: 'CW', XAF: 'CM', XOF: 'SN', XCD: 'AG', XPF: 'PF', CNH: 'CN',
        GGP: 'GG', JEP: 'JE', IMP: 'IM', FOK: 'FO', KID: 'KI', TVD: 'TV', SLE: 'SL', ZWG: 'ZW', ZWL: 'ZW',
        BTN: 'BT', SHP: 'SH', FKP: 'FK', GIP: 'GI', KMF: 'KM'
    };
    var FLAG_SPECIAL = { XDR: '🌐', XAU: '🥇', XAG: '🥈', XPT: '⚪', XPD: '⚪', BTC: '₿', ETH: 'Ξ', USDT: '₮' };

    function flagOf(code, explicit) {
        if (explicit) return explicit;
        if (FLAG_SPECIAL[code]) return FLAG_SPECIAL[code];
        var cc = FLAG_CC[code] || code.slice(0, 2);
        if (!/^[A-Z]{2}$/.test(cc)) return '💱';
        return String.fromCodePoint(127397 + cc.charCodeAt(0), 127397 + cc.charCodeAt(1));
    }

    /* ---------- number formatting ---------- */
    function fmtN(n) {
        if (!isFinite(n)) return '—';
        var d = Math.abs(n) >= 100 ? 2 : 4;
        try { return n.toLocaleString(lang, { minimumFractionDigits: d, maximumFractionDigits: d }); }
        catch (e) { return n.toFixed(d); }
    }
    function unitFor(v) {
        // tiny values (e.g. 1 JPY = 0.0111 AZN) are shown per 10/100/1000… units
        if (v >= 0.1) return 1;
        var u = 10;
        while (v * u < 1 && u < 1e9) u *= 10;
        return u;
    }
    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    /* ---------- storage ---------- */
    function readFavs() {
        try { return JSON.parse(localStorage.getItem(FAV_KEY) || '{}') || {}; } catch (e) { return {}; }
    }
    function saveFavs() { try { localStorage.setItem(FAV_KEY, JSON.stringify(state.favs)); } catch (e) {} }
    function readCache() {
        try { var raw = localStorage.getItem(CACHE_KEY); return raw ? JSON.parse(raw) : null; } catch (e) { return null; }
    }
    function writeCache(obj) { try { localStorage.setItem(CACHE_KEY, JSON.stringify(obj)); } catch (e) {} }

    /* ---------- network ---------- */
    async function getJson(url) {
        var ctrl = (typeof AbortController !== 'undefined') ? new AbortController() : null;
        var timer = ctrl ? setTimeout(function () { ctrl.abort(); }, 12000) : null;
        try {
            var res = await fetch(url, { headers: { 'Accept': 'application/json' }, signal: ctrl ? ctrl.signal : undefined });
            if (!res.ok) return null;
            return await res.json();
        } catch (e) { return null; }
        finally { if (timer) clearTimeout(timer); }
    }

    function normalize(data) {
        if (!data) return null;
        var src = null;
        if (Array.isArray(data)) {
            src = {};
            data.forEach(function (it) { if (it && it.code && it.rate) src[it.code] = it.rate; });
        } else if (data.rates && typeof data.rates === 'object') src = data.rates;
        else if (data.conversion_rates && typeof data.conversion_rates === 'object') src = data.conversion_rates;
        else if (data[baseLc] && typeof data[baseLc] === 'object') src = data[baseLc];
        else if (data.data && typeof data.data === 'object') src = data.data;
        if (!src) return null;
        var out = {}, n = 0;
        Object.keys(src).forEach(function (k) {
            var code = k.toUpperCase(), v = parseFloat(src[k]);
            if (/^[A-Z]{3,5}$/.test(code) && isFinite(v) && v > 0) { out[code] = v; n++; }
        });
        return n ? out : null;
    }

    async function fetchPrimary() {
        var urls = [];
        if (cfg.source === 'allratestoday' && cfg.key) {
            urls.push('https://allratestoday.com/api/v1/latest?api_key=' + encodeURIComponent(cfg.key) + '&base=' + encodeURIComponent(base));
        }
        urls.push('https://open.er-api.com/v6/latest/' + encodeURIComponent(base));
        for (var i = 0; i < urls.length; i++) {
            var n = normalize(await getJson(urls[i]));
            if (n) return n;
        }
        return null;
    }

    // Secondary source: more currencies (metals, crypto…) and a real day-over-day comparison.
    async function fetchSecondary(version) {
        var urls = [
            'https://cdn.jsdelivr.net/npm/@@fawazahmed0/currency-api@' + version + '/v1/currencies/' + baseLc + '.json',
            'https://' + version + '.currency-api.pages.dev/v1/currencies/' + baseLc + '.json'
        ];
        for (var i = 0; i < urls.length; i++) {
            var n = normalize(await getJson(urls[i]));
            if (n) return n;
        }
        return null;
    }

    function yesterday() { return new Date(Date.now() - 864e5).toISOString().slice(0, 10); }

    async function load(force) {
        var cached = readCache();
        var now = Date.now();

        if (!force && cached && cached.rates && cfg.refresh > 0 && (now - cached.ts) < cfg.refresh * 1000) {
            apply(cached, false);
            return;
        }

        setBusy(true);
        if (!state.rates && !(cached && cached.rates)) showPane('loading');

        var res = await Promise.all([fetchPrimary(), fetchSecondary('latest'), fetchSecondary(yesterday())]);
        var primary = res[0], latest = res[1], prevDay = res[2];
        var rates = primary || latest;

        if (!rates) {
            setBusy(false);
            if (cached && cached.rates) { apply(cached, true); return; }
            showError(T.error);
            return;
        }

        var change = {};
        if (latest && prevDay) {
            Object.keys(latest).forEach(function (k) {
                if (prevDay[k]) change[k] = (prevDay[k] / latest[k] - 1) * 100;
            });
        } else if (cached && cached.prev && cached.prev.rates) {
            Object.keys(rates).forEach(function (k) {
                var p = cached.prev.rates[k];
                if (p) change[k] = (p / rates[k] - 1) * 100;
            });
        }

        var prev = null;
        if (cached && cached.rates && (now - cached.ts) > 20 * 3600 * 1000) prev = { rates: cached.rates, ts: cached.ts };
        else if (cached && cached.prev) prev = cached.prev;

        var fresh = { rates: rates, extras: latest || {}, change: change, ts: now, prev: prev };
        writeCache(fresh);
        apply(fresh, false);
    }

    /* ---------- data → rows ---------- */
    function buildRows() {
        var rates = state.rates || {}, extras = state.extras || {}, change = state.change || {};
        var seen = {}, rows = [], order = 0;

        function make(code, c, pinned) {
            var r = rates[code] || extras[code] || null;
            var disp = r ? 1 / r : null;
            var u = disp ? unitFor(disp) : 1;
            var ch = change[code];
            return {
                code: code, name: nameOf(code, c && c.name), flag: flagOf(code, c && c.flag),
                disp: disp, unit: u, value: disp ? disp * u : null, available: !!disp,
                change: (ch !== undefined && isFinite(ch)) ? ch : null, pinned: pinned, order: order++
            };
        }

        cfg.currencies.forEach(function (c) {
            var code = (c.code || '').toUpperCase();
            if (!code || code === base || seen[code]) return;
            seen[code] = 1;
            rows.push(make(code, c, true));
        });

        if (cfg.mode !== 'custom') {
            Object.keys(rates).sort().forEach(function (code) {
                if (code === base || seen[code]) return;
                seen[code] = 1;
                rows.push(make(code, null, false));
            });
            if (cfg.extra) {
                Object.keys(extras).sort().forEach(function (code) {
                    if (code === base || seen[code] || !knownName(code)) return;
                    seen[code] = 1;
                    rows.push(make(code, null, false));
                });
            }
        }
        return rows;
    }

    function apply(data, stale) {
        state.rates = data.rates;
        state.extras = data.extras || {};
        state.change = data.change || {};
        state.ts = data.ts || Date.now();
        state.stale = !!stale;
        state.rows = buildRows();

        var avail = state.rows.filter(function (r) { return r.available; });
        if (!state.conv.code || !avail.some(function (r) { return r.code === state.conv.code; })) {
            state.conv.code = avail.length ? avail[0].code : null;
        }

        if (!avail.length) { setBusy(false); showError(T.error); return; }

        var missing = state.rows.filter(function (r) { return r.pinned && !r.available; })
                                .map(function (r) { return r.code; });
        if (missing.length) { els.notice.textContent = T.missing + ' ' + missing.join(', '); els.notice.hidden = false; }
        else { els.notice.hidden = true; }

        showPane('ready');
        setBusy(false);
        setStatus();
        renderConv();
        renderList();
        syncControls();
    }

    /* ---------- UI helpers ---------- */
    function showPane(name) {
        els.loading.hidden = name !== 'loading';
        els.error.hidden = name !== 'error';
        els.ready.hidden = name !== 'ready';
    }
    function showError(msg) {
        showPane('error');
        els.errMsg.textContent = msg;
        els.status.classList.add('is-stale');
        els.statusText.textContent = '—';
    }
    function setBusy(on) {
        els.status.classList.toggle('is-busy', on);
        els.refresh.classList.toggle('is-spin', on);
    }
    function timeStr() {
        try { return new Date(state.ts).toLocaleTimeString(lang, { hour: '2-digit', minute: '2-digit' }); }
        catch (e) { return new Date(state.ts).toTimeString().slice(0, 5); }
    }
    function setStatus() {
        els.status.classList.toggle('is-stale', state.stale);
        els.statusText.textContent = (state.stale ? T.stale : T.live) + ' ' + timeStr();
    }
    function syncControls() {
        Array.prototype.forEach.call(root.querySelectorAll('[data-view]'), function (b) {
            b.setAttribute('aria-pressed', b.getAttribute('data-view') === state.view ? 'true' : 'false');
        });
        Array.prototype.forEach.call(root.querySelectorAll('[data-filter]'), function (b) {
            b.setAttribute('aria-pressed', b.getAttribute('data-filter') === state.filter ? 'true' : 'false');
        });
    }

    /* ---------- converter ---------- */
    function renderConv() {
        if (!els.conv) return;
        var opts = state.rows.filter(function (r) { return r.available; }).map(function (r) {
            return '<option value="' + r.code + '"' + (r.code === state.conv.code ? ' selected' : '') + '>' +
                   r.code + ' · ' + esc(r.name) + '</option>';
        }).join('');
        var sel = '<select data-conv-code aria-label="' + esc(T.amount) + '">' + opts + '</select>';
        var tag = '<span class="rjc2-conv-tag">' + esc(base) + '</span>';
        els.conv.innerHTML =
            '<input class="rjc2-conv-in" type="number" min="0" step="any" inputmode="decimal" value="' + esc(state.conv.amount) + '" data-conv-amount aria-label="' + esc(T.amount) + '">' +
            (state.conv.rev ? tag : sel) +
            '<button type="button" class="rjc2-conv-swap" data-conv-swap aria-label="' + esc(T.swap) + '" title="' + esc(T.swap) + '">⇄</button>' +
            '<span class="rjc2-conv-out" data-conv-result>—</span>' +
            (state.conv.rev ? sel : tag);
        updateConv();
    }
    function updateConv() {
        var out = els.conv && els.conv.querySelector('[data-conv-result]');
        if (!out) return;
        var row = state.rows.filter(function (r) { return r.code === state.conv.code && r.available; })[0];
        var amt = parseFloat(state.conv.amount);
        if (!row || !isFinite(amt)) { out.textContent = '—'; return; }
        out.textContent = fmtN(state.conv.rev ? amt / row.disp : amt * row.disp);
    }

    /* ---------- list ---------- */
    function chgHtml(c) {
        if (!cfg.showChange) return '';
        if (c === null) return '<span class="rjc2-chg flat">—</span>';
        var cls = c > 0.005 ? 'up' : (c < -0.005 ? 'dn' : 'flat');
        var mark = cls === 'up' ? '▲' : (cls === 'dn' ? '▼' : '–');
        return '<span class="rjc2-chg ' + cls + '">' + mark + ' ' + (c > 0 ? '+' : '') + c.toFixed(2) + '%</span>';
    }
    function badge(r) { return cfg.showFlags ? '<span class="rjc2-badge" aria-hidden="true">' + r.flag + '</span>' : ''; }
    function starBtn(r) {
        var on = !!state.favs[r.code];
        return '<button type="button" class="rjc2-star' + (on ? ' on' : '') + '" data-fav="' + r.code + '" aria-pressed="' + on + '" aria-label="' + esc(on ? T.unstar : T.star) + ' ' + r.code + '">' +
               '<svg viewBox="0 0 24 24"><path stroke-linejoin="round" d="M12 3.5l2.6 5.4 5.9.8-4.3 4.1 1 5.9L12 16.9 6.8 19.7l1-5.9L3.5 9.7l5.9-.8z"/></svg></button>';
    }
    function dirCls(r) { return r.available ? (r.change > 0.005 ? ' is-up' : (r.change < -0.005 ? ' is-dn' : '')) : ' is-off'; }

    function tileHtml(r) {
        var h = '<article class="rjc2-tile' + dirCls(r) + '">';
        h += '<div class="rjc2-tile-top">' + badge(r) + '<div class="rjc2-id"><b>' + r.code + '</b><span>' + esc(r.name) + '</span></div>' + starBtn(r) + '</div>';
        if (r.available) {
            h += '<div class="rjc2-val">' + fmtN(r.value) + '<small>' + esc(base) + '</small></div>';
            h += '<div class="rjc2-tile-foot"><span>' + r.unit + ' ' + r.code + '</span>' + chgHtml(r.change) + '</div>';
        } else {
            h += '<div class="rjc2-off">' + esc(T.unavailable) + '</div>';
        }
        return h + '</article>';
    }
    function rowHtml(r) {
        var h = '<div class="rjc2-row' + dirCls(r) + '">';
        h += badge(r) || '<span></span>';
        h += '<div class="rjc2-id"><b>' + r.code + '</b><span>' + esc(r.name) + '</span></div>';
        if (r.available) {
            h += '<span class="rjc2-unit">' + r.unit + ' ' + r.code + ' =</span>';
            h += '<span class="rjc2-val">' + fmtN(r.value) + ' <small>' + esc(base) + '</small></span>';
            h += chgHtml(r.change) || '<span></span>';
        } else {
            h += '<span class="rjc2-off">' + esc(T.unavailable) + '</span>';
        }
        return h + starBtn(r) + '</div>';
    }

    function visibleRows() {
        var q = state.query.trim().toLowerCase();
        var list = state.rows.filter(function (r) {
            if (state.filter === 'up' && !(r.change > 0.005)) return false;
            if (state.filter === 'dn' && !(r.change < -0.005)) return false;
            if (state.filter === 'fav' && !state.favs[r.code]) return false;
            if (q && r.code.toLowerCase().indexOf(q) < 0 && r.name.toLowerCase().indexOf(q) < 0) return false;
            return true;
        });
        var s = state.sort;
        list.sort(function (a, b) {
            if (s === 'az') return a.code < b.code ? -1 : 1;
            if (s === 'rate') return (b.disp || -1) - (a.disp || -1);
            if (s === 'change') return (b.change === null ? -999 : b.change) - (a.change === null ? -999 : a.change);
            var fa = state.favs[a.code] ? 1 : 0, fb = state.favs[b.code] ? 1 : 0;
            if (fa !== fb) return fb - fa;
            return a.order - b.order;
        });
        return list;
    }

    function renderList() {
        var all = visibleRows();
        var searching = state.query.trim() !== '';
        var collapsible = cfg.initial > 0 && !searching && state.filter === 'all' && all.length > cfg.initial;
        var shown = (collapsible && !state.expanded) ? all.slice(0, cfg.initial) : all;

        if (!shown.length) {
            els.list.className = 'rjc2-empty';
            els.list.innerHTML = esc(T.noResults);
        } else if (state.view === 'grid') {
            els.list.className = 'rjc2-grid';
            els.list.innerHTML = shown.map(tileHtml).join('');
        } else {
            els.list.className = 'rjc2-list' + (state.view === 'compact' ? ' rjc2-compact' : '');
            els.list.innerHTML = shown.map(rowHtml).join('');
        }

        els.more.hidden = !collapsible;
        els.more.textContent = state.expanded ? T.showLess : T.showAll + ' (' + all.length + ')';
        els.count.textContent = shown.length + ' / ' + state.rows.length + ' ' + T.currencies;
    }

    /* ---------- events ---------- */
    root.addEventListener('click', function (e) {
        var t = e.target;
        if (!t.closest) return;
        var el;
        if ((el = t.closest('[data-fav]'))) {
            var code = el.getAttribute('data-fav');
            if (state.favs[code]) delete state.favs[code]; else state.favs[code] = 1;
            saveFavs(); renderList();
        } else if ((el = t.closest('[data-filter]'))) {
            state.filter = el.getAttribute('data-filter'); state.expanded = false; syncControls(); renderList();
        } else if ((el = t.closest('[data-view]'))) {
            state.view = el.getAttribute('data-view'); syncControls(); renderList();
        } else if (t.closest('[data-more]')) {
            state.expanded = !state.expanded; renderList();
        } else if (t.closest('[data-conv-swap]')) {
            state.conv.rev = !state.conv.rev; renderConv();
        } else if (t.closest('[data-refresh]') || t.closest('[data-retry]')) {
            load(true);
        }
    });
    root.addEventListener('input', function (e) {
        if (e.target.matches('[data-search]')) { state.query = e.target.value; renderList(); }
        else if (e.target.matches('[data-conv-amount]')) { state.conv.amount = e.target.value; updateConv(); }
    });
    root.addEventListener('change', function (e) {
        if (e.target.matches('[data-sort]')) { state.sort = e.target.value; renderList(); }
        else if (e.target.matches('[data-conv-code]')) { state.conv.code = e.target.value; updateConv(); }
    });

    load(false);
    if (cfg.refresh > 0) setInterval(function () { load(true); }, cfg.refresh * 1000);
})();
</script>
