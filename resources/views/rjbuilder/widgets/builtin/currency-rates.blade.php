@php
    $title       = $settings['title'] ?? __('Currency Rates');
    $subtitle    = $settings['subtitle'] ?? '';
    $apiSource   = $settings['api_source'] ?? 'exchangerate_host';
    $apiKey      = trim($settings['api_key'] ?? '');
    $base        = $settings['base'] ?? 'AZN';
    $refresh     = (int) ($settings['refresh'] ?? 3600);
    $layout      = $settings['layout'] ?? 'table';
    $accent      = $settings['accent'] ?? '#8b5cf6';
    $textColor   = $settings['text_color'] ?? '#0f172a';
    $bgColor     = $settings['bg_color'] ?? '#ffffff';
    $showFlags   = $settings['show_flags'] ?? true;
    $showChange  = $settings['show_change'] ?? true;
    $radius      = $settings['radius'] ?? 'lg';
    $paddingY    = (int) ($settings['padding_y'] ?? 40);

    $radiusMap = ['none' => '0px', 'md' => '10px', 'lg' => '16px', 'xl' => '22px'];
    $radiusCss = $radiusMap[$radius] ?? '16px';

    $currencyList = [];
    if (!empty($settings['currencies']) && is_array($settings['currencies'])) {
        foreach ($settings['currencies'] as $row) {
            if (!is_array($row)) continue;
            $code = strtoupper(trim($row['code'] ?? ''));
            if ($code === '') continue;
            $currencyList[] = [
                'code' => $code,
                'name' => $row['name'] ?? $code,
                'flag' => $row['flag'] ?? '',
            ];
        }
    }
    if (empty($currencyList)) {
        $currencyList = [
            ['code' => 'USD', 'name' => 'US Dollar',    'flag' => '🇺🇸'],
            ['code' => 'EUR', 'name' => 'Euro',         'flag' => '🇪🇺'],
            ['code' => 'TRY', 'name' => 'Turkish Lira', 'flag' => '🇹🇷'],
            ['code' => 'RUB', 'name' => 'Russian Ruble','flag' => '🇷🇺'],
            ['code' => 'GBP', 'name' => 'British Pound','flag' => '🇬🇧'],
        ];
    }

    $fallbackFlags = [
        'USD'=>'🇺🇸','EUR'=>'🇪🇺','GBP'=>'🇬🇧','TRY'=>'🇹🇷','RUB'=>'🇷🇺','AZN'=>'🇦🇿',
        'JPY'=>'🇯🇵','CNY'=>'🇨🇳','CHF'=>'🇨🇭','AED'=>'🇦🇪','SAR'=>'🇸🇦','KZT'=>'🇰🇿',
        'UAH'=>'🇺🇦','INR'=>'🇮🇳','CAD'=>'🇨🇦','AUD'=>'🇦🇺','NZD'=>'🇳🇿','GEL'=>'🇬🇪',
        'ILS'=>'🇮🇱','KRW'=>'🇰🇷','BRL'=>'🇧🇷','MXN'=>'🇲🇽','IRR'=>'🇮🇷','PKR'=>'🇵🇰',
        'SGD'=>'🇸🇬','HKD'=>'🇭🇰','SEK'=>'🇸🇪','NOK'=>'🇳🇴','DKK'=>'🇩🇰','PLN'=>'🇵🇱',
        'CZK'=>'🇨🇿','HUF'=>'🇭🇺','RON'=>'🇷🇴','BGN'=>'🇧🇬','BYN'=>'🇧🇾','MDL'=>'🇲🇩',
    ];
@endphp

<style>
    #{{ $uid }} {
        --cr-accent: {{ $accent }};
        --cr-text: {{ $textColor }};
        --cr-bg: {{ $bgColor }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-cr-inner {
        max-width: 820px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-cr-head {
        text-align: center;
        margin-bottom: 24px;
    }
    #{{ $uid }} .rj-cr-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--cr-accent);
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-cr-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--cr-text);
        letter-spacing: -.02em;
        margin: 0;
    }
    #{{ $uid }} .rj-cr-base {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding: 5px 12px;
        border-radius: 999px;
        background: color-mix(in srgb, var(--cr-accent) 12%, transparent);
        color: var(--cr-accent);
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .04em;
    }
    #{{ $uid }} .rj-cr-base::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--cr-accent) 25%, transparent);
        animation: rjCrPulse 2s ease-in-out infinite;
    }
    @keyframes rjCrPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .35; }
    }

    #{{ $uid }} .rj-cr-card {
        background: var(--cr-bg);
        border: 1px solid #e5e7eb;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.15);
    }

    /* ---------- TABLE ---------- */
    #{{ $uid }} table.rj-cr-table {
        width: 100%;
        border-collapse: collapse;
    }
    #{{ $uid }} .rj-cr-table thead th {
        text-align: left;
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #94a3b8;
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }
    #{{ $uid }} .rj-cr-table thead th.th-rate,
    #{{ $uid }} .rj-cr-table thead th.th-change { text-align: right; }
    #{{ $uid }} .rj-cr-table tbody td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: var(--cr-text);
        vertical-align: middle;
    }
    #{{ $uid }} .rj-cr-table tbody tr:last-child td { border-bottom: 0; }
    #{{ $uid }} .rj-cr-table tbody tr {
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-cr-table tbody tr:hover {
        background: color-mix(in srgb, var(--cr-accent) 5%, transparent);
    }
    #{{ $uid }} .rj-cr-code-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    #{{ $uid }} .rj-cr-flag {
        font-size: 22px;
        line-height: 1;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-cr-code {
        font-size: 14px;
        font-weight: 800;
        color: var(--cr-text);
        letter-spacing: .02em;
    }
    #{{ $uid }} .rj-cr-name {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }
    #{{ $uid }} .rj-cr-rate {
        text-align: right;
        font-size: 15px;
        font-weight: 800;
        color: var(--cr-text);
        font-variant-numeric: tabular-nums;
        letter-spacing: -.01em;
    }
    #{{ $uid }} .rj-cr-unit {
        font-size: 10.5px;
        color: #94a3b8;
        font-weight: 600;
        display: block;
        margin-top: 2px;
    }

    /* ---------- CHANGE ---------- */
    #{{ $uid }} .rj-cr-change {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 12px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        padding: 3px 8px;
        border-radius: 6px;
    }
    #{{ $uid }} .rj-cr-change.up {
        color: #059669;
        background: rgba(16,185,129,.1);
    }
    #{{ $uid }} .rj-cr-change.down {
        color: #dc2626;
        background: rgba(239,68,68,.1);
    }
    #{{ $uid }} .rj-cr-change.flat {
        color: #94a3b8;
        background: rgba(148,163,184,.1);
    }
    #{{ $uid }} .rj-cr-change svg { width: 10px; height: 10px; }

    /* ---------- CARDS ---------- */
    #{{ $uid }} .rj-cr-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 12px;
        padding: 20px;
        background: var(--cr-bg);
        border: 1px solid #e5e7eb;
        border-radius: {{ $radiusCss }};
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.15);
    }
    #{{ $uid }} .rj-cr-card-item {
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #eef2f7;
        background: #fafbfc;
        transition: border-color .25s ease, transform .25s ease;
    }
    #{{ $uid }} .rj-cr-card-item:hover {
        border-color: color-mix(in srgb, var(--cr-accent) 40%, transparent);
        transform: translateY(-2px);
    }
    #{{ $uid }} .rj-cr-card-item-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    #{{ $uid }} .rj-cr-card-item-code {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
        color: var(--cr-text);
    }
    #{{ $uid }} .rj-cr-card-item-rate {
        font-size: 20px;
        font-weight: 800;
        color: var(--cr-text);
        font-variant-numeric: tabular-nums;
        letter-spacing: -.02em;
        line-height: 1.1;
    }
    #{{ $uid }} .rj-cr-card-item-unit {
        font-size: 10.5px;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 4px;
    }

    /* ---------- COMPACT ---------- */
    #{{ $uid }} .rj-cr-compact {
        background: var(--cr-bg);
        border: 1px solid #e5e7eb;
        border-radius: {{ $radiusCss }};
        padding: 6px;
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.15);
    }
    #{{ $uid }} .rj-cr-compact-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 14px;
        border-radius: 10px;
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-cr-compact-row + .rj-cr-compact-row {
        border-top: 1px solid #f1f5f9;
    }
    #{{ $uid }} .rj-cr-compact-row:hover {
        background: color-mix(in srgb, var(--cr-accent) 5%, transparent);
    }
    #{{ $uid }} .rj-cr-compact-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 0;
    }
    #{{ $uid }} .rj-cr-compact-code {
        font-size: 13px;
        font-weight: 800;
        color: var(--cr-text);
    }
    #{{ $uid }} .rj-cr-compact-name {
        font-size: 11px;
        color: #64748b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #{{ $uid }} .rj-cr-compact-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-cr-compact-rate {
        font-size: 14px;
        font-weight: 800;
        color: var(--cr-text);
        font-variant-numeric: tabular-nums;
    }

    /* ---------- STATES ---------- */
    #{{ $uid }} .rj-cr-skel {
        background: linear-gradient(90deg, #f1f5f9 0%, #e2e8f0 50%, #f1f5f9 100%);
        background-size: 200% 100%;
        animation: rjCrShimmer 1.4s linear infinite;
        border-radius: 4px;
        height: 12px;
    }
    @keyframes rjCrShimmer {
        from { background-position: 200% 0; }
        to   { background-position: -200% 0; }
    }
    #{{ $uid }} .rj-cr-loading {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    #{{ $uid }} .rj-cr-error {
        padding: 24px;
        text-align: center;
        color: #dc2626;
        background: #fef2f2;
        border-radius: 12px;
        border: 1px solid #fecaca;
        font-size: 13px;
    }
    #{{ $uid }} .rj-cr-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
        font-size: 11px;
        color: #94a3b8;
    }
    #{{ $uid }} .rj-cr-refresh {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: none;
        border: 0;
        color: var(--cr-accent);
        font-weight: 700;
        font-size: 11px;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-cr-refresh:hover {
        background: color-mix(in srgb, var(--cr-accent) 12%, transparent);
    }
    #{{ $uid }} .rj-cr-refresh svg { width: 11px; height: 11px; }
    #{{ $uid }} .rj-cr-refresh.is-spinning svg {
        animation: rjCrSpin .8s linear infinite;
    }
    @keyframes rjCrSpin { to { transform: rotate(360deg); } }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}"
     data-layout="{{ $layout }}"
     data-base="{{ $base }}"
     data-source="{{ $apiSource }}"
     data-key="{{ $apiKey }}"
     data-refresh="{{ $refresh }}"
     data-show-flags="{{ $showFlags ? '1' : '0' }}"
     data-show-change="{{ $showChange ? '1' : '0' }}"
     data-currencies='@json($currencyList)'
     data-fallback-flags='@json($fallbackFlags)'>

    <div class="rj-cr-inner">
        @if($title || $subtitle)
            <header class="rj-cr-head">
                @if($subtitle)
                    <p class="rj-cr-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-cr-title">{{ $title }}</h2>
                @endif
                <span class="rj-cr-base">{{ __('Base') }}: {{ $base }}</span>
            </header>
        @endif

        <div class="rj-cr-card" data-card>
            <div class="rj-cr-loading" data-loading>
                <div class="rj-cr-skel" style="width: 60%;"></div>
                <div class="rj-cr-skel" style="width: 80%;"></div>
                <div class="rj-cr-skel" style="width: 70%;"></div>
                <div class="rj-cr-skel" style="width: 85%;"></div>
            </div>
            <div data-content style="display:none;"></div>
            <div data-error style="display:none;"></div>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var layout       = root.getAttribute('data-layout') || 'table';
    var base         = root.getAttribute('data-base') || 'AZN';
    var source       = root.getAttribute('data-source') || 'exchangerate_host';
    var apiKey       = root.getAttribute('data-key') || '';
    var refreshSec   = parseInt(root.getAttribute('data-refresh'), 10) || 0;
    var showFlags    = root.getAttribute('data-show-flags') === '1';
    var showChange   = root.getAttribute('data-show-change') === '1';
    var currencies   = JSON.parse(root.getAttribute('data-currencies') || '[]');
    var flagsMap     = JSON.parse(root.getAttribute('data-fallback-flags') || '{}');

    var card         = root.querySelector('[data-card]');
    var loadingEl    = root.querySelector('[data-loading]');
    var contentEl    = root.querySelector('[data-content]');
    var errorEl      = root.querySelector('[data-error]');

    var cacheKey     = 'rj_cr_' + source + '_' + base;
    var refreshTimer = null;

    function getFlag(code, explicit) {
        if (explicit) return explicit;
        return flagsMap[code] || '💱';
    }

    function fmt(n) {
        if (!isFinite(n)) return '—';
        var abs = Math.abs(n);
        if (abs >= 100) return n.toFixed(2);
        if (abs >= 1)   return n.toFixed(4);
        return n.toFixed(6);
    }

    function pct(curr, prev) {
        if (!prev || !curr || prev === 0) return null;
        return ((curr - prev) / prev) * 100;
    }

    function readCache() {
        try {
            var raw = localStorage.getItem(cacheKey);
            if (!raw) return null;
            return JSON.parse(raw);
        } catch (e) { return null; }
    }

    function writeCache(rates, ts) {
        try {
            var prev = readCache();
            var yesterday = null;
            if (prev && prev.rates && prev.ts && (ts - prev.ts) > 20 * 3600 * 1000) {
                yesterday = { rates: prev.rates, ts: prev.ts };
            } else if (prev && prev.yesterday) {
                yesterday = prev.yesterday;
            }
            localStorage.setItem(cacheKey, JSON.stringify({ rates: rates, ts: ts, yesterday: yesterday }));
        } catch (e) {}
    }

    function normalizeRates(data) {
        if (!data) return null;
        if (data.rates && typeof data.rates === 'object') return data.rates;
        if (data.data && typeof data.data === 'object') return data.data;
        if (Array.isArray(data)) {
            var out = {};
            data.forEach(function (item) {
                if (item && item.code && item.rate) {
                    out[item.code] = parseFloat(item.rate);
                }
            });
            return out;
        }
        return null;
    }

    async function fetchRates() {
        var endpoints = [];

        if (source === 'allratestoday' && apiKey) {
            endpoints.push('https://allratestoday.com/api/v1/latest?api_key=' + encodeURIComponent(apiKey) + '&base=' + encodeURIComponent(base));
        }
        endpoints.push('https://open.er-api.com/v6/latest/' + encodeURIComponent(base));

        for (var i = 0; i < endpoints.length; i++) {
            try {
                var res = await fetch(endpoints[i], { headers: { 'Accept': 'application/json' } });
                if (!res.ok) continue;
                var json = await res.json();
                var rates = normalizeRates(json);
                if (rates && Object.keys(rates).length > 0) return rates;
            } catch (e) {}
        }
        return null;
    }

    function render(rates, yesterdayRates) {
        loadingEl.style.display = 'none';
        errorEl.style.display = 'none';
        contentEl.style.display = 'block';
        contentEl.innerHTML = '';

        var rows = currencies.map(function (c) {
            var code = (c.code || '').toUpperCase();
            var rate = rates[code];
            var display = (rate && rate > 0) ? (1 / rate) : null;
            var yRate = yesterdayRates ? yesterdayRates[code] : null;
            var yDisplay = (yRate && yRate > 0) ? (1 / yRate) : null;
            var change = (display && yDisplay) ? pct(display, yDisplay) : null;
            return {
                code: code,
                name: c.name || code,
                flag: getFlag(code, c.flag || ''),
                display: display,
                change: change,
            };
        });

        if (layout === 'table') {
            contentEl.innerHTML = buildTable(rows);
        } else if (layout === 'cards') {
            contentEl.innerHTML = buildCards(rows);
        } else {
            contentEl.innerHTML = buildCompact(rows);
        }

        contentEl.insertAdjacentHTML('beforeend', buildFooter());
        bindRefresh();
    }

    function changeHtml(change) {
        if (!showChange) return '';
        if (change === null || !isFinite(change)) {
            return '<span class="rj-cr-change flat">—</span>';
        }
        var cls = change > 0.01 ? 'up' : (change < -0.01 ? 'down' : 'flat');
        var arrow = change > 0.01
            ? '<svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>'
            : (change < -0.01
                ? '<svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>'
                : '<svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>');
        var label = (change > 0 ? '+' : '') + change.toFixed(2) + '%';
        return '<span class="rj-cr-change ' + cls + '">' + arrow + '<span>' + label + '</span></span>';
    }

    function buildTable(rows) {
        var html = '<table class="rj-cr-table"><thead><tr>';
        html += '<th>' + @js(__('Currency')) + '</th>';
        html += '<th class="th-rate">' + @js(__('Rate')) + '</th>';
        if (showChange) html += '<th class="th-change">' + @js(__('Change')) + '</th>';
        html += '</tr></thead><tbody>';

        rows.forEach(function (r) {
            html += '<tr>';
            html += '<td><div class="rj-cr-code-wrap">';
            if (showFlags) html += '<span class="rj-cr-flag">' + r.flag + '</span>';
            html += '<div><div class="rj-cr-code">' + r.code + '</div><div class="rj-cr-name">' + escapeHtml(r.name) + '</div></div>';
            html += '</div></td>';
            html += '<td class="rj-cr-rate">' + (r.display ? fmt(r.display) : '—') + '<span class="rj-cr-unit">' + base + '</span></td>';
            if (showChange) html += '<td style="text-align:right;">' + changeHtml(r.change) + '</td>';
            html += '</tr>';
        });
        html += '</tbody></table>';
        return html;
    }

    function buildCards(rows) {
        var html = '<div class="rj-cr-cards">';
        rows.forEach(function (r) {
            html += '<div class="rj-cr-card-item">';
            html += '<div class="rj-cr-card-item-head"><div class="rj-cr-card-item-code">';
            if (showFlags) html += '<span class="rj-cr-flag" style="font-size:18px;">' + r.flag + '</span>';
            html += '<span>' + r.code + '</span></div>';
            html += changeHtml(r.change);
            html += '</div>';
            html += '<div class="rj-cr-card-item-rate">' + (r.display ? fmt(r.display) : '—') + '</div>';
            html += '<div class="rj-cr-card-item-unit">1 ' + r.code + ' = ' + base + '</div>';
            html += '</div>';
        });
        html += '</div>';
        return html;
    }

    function buildCompact(rows) {
        var html = '<div class="rj-cr-compact">';
        rows.forEach(function (r) {
            html += '<div class="rj-cr-compact-row">';
            html += '<div class="rj-cr-compact-left">';
            if (showFlags) html += '<span class="rj-cr-flag">' + r.flag + '</span>';
            html += '<div style="min-width:0;"><div class="rj-cr-compact-code">' + r.code + '</div><div class="rj-cr-compact-name">' + escapeHtml(r.name) + '</div></div>';
            html += '</div>';
            html += '<div class="rj-cr-compact-right">';
            if (showChange) html += changeHtml(r.change);
            html += '<span class="rj-cr-compact-rate">' + (r.display ? fmt(r.display) : '—') + ' <span style="font-size:10px;color:#94a3b8;font-weight:600;">' + base + '</span></span>';
            html += '</div></div>';
        });
        html += '</div>';
        return html;
    }

    function buildFooter() {
        var html = '<div class="rj-cr-foot">';
        html += '<span data-updated>' + @js(__('Updated just now')) + '</span>';
        html += '<button type="button" class="rj-cr-refresh" data-refresh-btn>';
        html += '<svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v6h6M20 20v-6h-6M20 10A8 8 0 006.3 6.3L4 10m16 4l-2.3 3.7A8 8 0 014 14"/></svg>';
        html += '<span>' + @js(__('Refresh')) + '</span>';
        html += '</button>';
        html += '</div>';
        return html;
    }

    function bindRefresh() {
        var btn = contentEl.querySelector('[data-refresh-btn]');
        if (!btn) return;
        btn.addEventListener('click', function () {
            btn.classList.add('is-spinning');
            load(true);
        });
    }

    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function showError(msg) {
        loadingEl.style.display = 'none';
        contentEl.style.display = 'none';
        errorEl.style.display = 'block';
        errorEl.innerHTML = '<div class="rj-cr-error">' + escapeHtml(msg) + '</div>';
    }

    var lastRenderTs = 0;

    async function load(force) {
        var cached = readCache();
        var now = Date.now();

        if (!force && cached && cached.rates && refreshSec > 0) {
            var age = now - (cached.ts || 0);
            if (age < refreshSec * 1000) {
                lastRenderTs = cached.ts || now;
                render(cached.rates, cached.yesterday ? cached.yesterday.rates : null);
                return;
            }
        }

        if (!force && !cached) {
            loadingEl.style.display = 'flex';
            contentEl.style.display = 'none';
        }

        var rates = await fetchRates();
        if (!rates) {
            if (cached && cached.rates) {
                render(cached.rates, cached.yesterday ? cached.yesterday.rates : null);
                return;
            }
            showError(@js(__('Could not load exchange rates. Please try again later.')));
            return;
        }

        writeCache(rates, now);
        var after = readCache();
        lastRenderTs = now;
        render(rates, after && after.yesterday ? after.yesterday.rates : null);

        var btn = contentEl.querySelector('[data-refresh-btn]');
        if (btn) btn.classList.remove('is-spinning');
    }

    load(false);

    if (refreshSec > 0) {
        refreshTimer = setInterval(function () { load(true); }, refreshSec * 1000);
    }
})();
</script>
