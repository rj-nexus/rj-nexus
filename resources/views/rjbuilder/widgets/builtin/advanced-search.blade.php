<style>
    #{{ $uid }} { position: relative; width: 100%; max-width: {{ $o['max_width'] }}; margin: {{ $o['margin'] }}; padding: 8px 0; font-family: inherit; --acc: {{ $o['accent'] }}; --rgb: {{ $o['accent_rgb'] }}; --py: {{ $o['py'] }}; --fs: {{ $o['fs'] }}; --rad: {{ $o['radius'] }}; --bg: transparent; --fg: #0f172a; --muted: #94a3b8; --bc: #cbd5e1; --sh: none; --pbg: #fff; --pfg: #0f172a; --pmuted: #64748b; --phover: #f1f5f9; --pbc: #e2e8f0; color: var(--fg); }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}[data-style="filled"] { --bg: #f1f5f9; --bc: transparent; }
    #{{ $uid }}[data-style="dark"] { --bg: #1e293b; --fg: #f8fafc; --muted: #94a3b8; --bc: #334155; --pbg: #0f172a; --pfg: #f8fafc; --pmuted: #94a3b8; --phover: #1e293b; --pbc: #334155; }
    #{{ $uid }}[data-style="outline"] { --bg: #fff; --sh: 0 1px 2px rgba(15, 23, 42, .06), 0 8px 24px rgba(15, 23, 42, .06); }

    /* ---------- Field ---------- */
    #{{ $uid }} .rjsr-form { margin: 0; padding: 0; }
    #{{ $uid }} .rjsr-field { display: flex; align-items: center; gap: 12px; padding: 0 18px; background: var(--bg); color: var(--fg); border: 1.5px solid var(--bc); border-radius: var(--rad); box-shadow: var(--sh); transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease; }
    #{{ $uid }}[data-style="minimal"] .rjsr-field { padding: 0 4px; border-width: 0 0 2px; border-radius: 0; }
    #{{ $uid }} .rjsr-field:focus-within { border-color: var(--acc); box-shadow: var(--sh), 0 0 0 4px rgba(var(--rgb), .18); }
    #{{ $uid }}[data-style="minimal"] .rjsr-field:focus-within { box-shadow: none; }
    #{{ $uid }}[data-style="filled"] .rjsr-field:focus-within { background: #fff; }

    #{{ $uid }} .rjsr-icon { flex: none; display: flex; color: var(--muted); transition: color .2s ease; }
    #{{ $uid }} .rjsr-field:focus-within .rjsr-icon { color: var(--acc); }
    #{{ $uid }} .rjsr-icon svg { width: 20px; height: 20px; display: block; }

    #{{ $uid }} .rjsr-input { flex: 1; min-width: 0; width: 100%; margin: 0; padding: var(--py) 0; border: 0 !important; outline: 0 !important; box-shadow: none !important; background: transparent !important; color: inherit !important; font: inherit; font-size: max(16px, var(--fs)); line-height: 1.4; -webkit-appearance: none; appearance: none; }
    #{{ $uid }} .rjsr-input:focus { outline: 0 !important; box-shadow: none !important; }
    #{{ $uid }} .rjsr-input::placeholder { color: var(--muted); opacity: 1; }
    #{{ $uid }} .rjsr-input:-webkit-autofill { transition: background-color 99999s ease-out; -webkit-text-fill-color: var(--fg); }

    #{{ $uid }} .rjsr-spinner { display: none; flex: none; width: 18px; height: 18px; border: 2px solid rgba(var(--rgb), .25); border-top-color: var(--acc); border-radius: 50%; animation: rjsr-spin .7s linear infinite; }
    #{{ $uid }}.rjsr-loading .rjsr-spinner { display: block; }

    #{{ $uid }} .rjsr-clear { display: none; flex: none; width: 28px; height: 28px; margin: 0; padding: 0; place-items: center; border: 0; border-radius: 50%; background: rgba(148, 163, 184, .2); color: var(--muted); cursor: pointer; transition: background-color .2s ease, color .2s ease; }
    #{{ $uid }} .rjsr-clear:hover { background: rgba(148, 163, 184, .35); color: var(--fg); }
    #{{ $uid }} .rjsr-clear svg { width: 14px; height: 14px; display: block; }
    #{{ $uid }}.rjsr-has-value .rjsr-clear { display: grid; }
    #{{ $uid }}.rjsr-has-value.rjsr-loading .rjsr-clear { display: none; }

    #{{ $uid }} .rjsr-kbd { flex: none; min-width: 24px; padding: 2px 7px; border: 1px solid var(--bc); border-bottom-width: 2px; border-radius: 6px; color: var(--muted); font: 600 .75rem/1.4 ui-monospace, SFMono-Regular, Menlo, monospace; text-align: center; }
    #{{ $uid }} .rjsr-field:focus-within .rjsr-kbd, #{{ $uid }}.rjsr-has-value .rjsr-kbd { display: none; }

    /* ---------- Panel ---------- */
    #{{ $uid }} .rjsr-panel { position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; max-height: 420px; overflow-y: auto; overscroll-behavior: contain; padding: 8px; background: var(--pbg); color: var(--pfg); border: 1px solid var(--pbc); border-radius: 16px; box-shadow: 0 24px 60px -12px rgba(15, 23, 42, .35); animation: rjsr-pop .18s ease-out; }
    #{{ $uid }} .rjsr-panel[hidden] { display: none; }

    #{{ $uid }} .rjsr-opt { position: relative; display: flex; align-items: center; gap: 14px; width: 100%; margin: 0; padding: 10px 12px; border: 0; border-radius: 12px; background: transparent; color: inherit; font: inherit; text-align: left; text-decoration: none !important; cursor: pointer; }
    #{{ $uid }} .rjsr-opt.rjsr-active { background: var(--phover); }
    #{{ $uid }} .rjsr-opt.rjsr-active::before { content: ""; position: absolute; left: 0; top: 10px; bottom: 10px; width: 3px; border-radius: 2px; background: var(--acc); }

    #{{ $uid }} .rjsr-thumb { flex: none; width: 48px; height: 48px; display: grid; place-items: center; overflow: hidden; border-radius: 10px; background: rgba(var(--rgb), .1); color: var(--acc); }
    #{{ $uid }} .rjsr-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    #{{ $uid }} .rjsr-thumb svg { width: 22px; height: 22px; display: block; }

    #{{ $uid }} .rjsr-body { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 3px; }
    #{{ $uid }} .rjsr-title { font-size: .95rem; font-weight: 700; line-height: 1.3; color: var(--pfg); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    #{{ $uid }} .rjsr-excerpt { font-size: .8rem; line-height: 1.4; color: var(--pmuted); overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
    #{{ $uid }} .rjsr-meta { display: flex; align-items: center; gap: 8px; }
    #{{ $uid }} .rjsr-badge { padding: 2px 8px; border-radius: 999px; background: rgba(var(--rgb), .12); color: var(--acc); font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    #{{ $uid }} .rjsr-price { font-size: .8rem; font-weight: 700; color: var(--pfg); }
    #{{ $uid }} .rjsr-chev { flex: none; color: var(--pmuted); opacity: .6; transition: transform .2s ease, color .2s ease, opacity .2s ease; }
    #{{ $uid }} .rjsr-chev svg { width: 18px; height: 18px; display: block; }
    #{{ $uid }} .rjsr-opt.rjsr-active .rjsr-chev { color: var(--acc); opacity: 1; transform: translateX(3px); }
    #{{ $uid }} mark { padding: 0 1px; border-radius: 3px; background: rgba(var(--rgb), .22); color: inherit; }

    #{{ $uid }} .rjsr-group { padding: 10px 12px 4px; font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--pmuted); }
    #{{ $uid }} .rjsr-group-row { display: flex; align-items: center; justify-content: space-between; }
    #{{ $uid }} .rjsr-clear-recent { margin: 0; padding: 0; border: 0; background: transparent; color: var(--acc); font: inherit; font-size: .72rem; font-weight: 700; letter-spacing: 0; text-transform: none; cursor: pointer; }
    #{{ $uid }} .rjsr-recent { gap: 12px; }
    #{{ $uid }} .rjsr-recent svg { flex: none; width: 18px; height: 18px; color: var(--pmuted); }
    #{{ $uid }} .rjsr-recent span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    #{{ $uid }} .rjsr-all { justify-content: space-between; margin-top: 6px; padding: 14px 12px; border-top: 1px solid var(--pbc); border-radius: 0 0 12px 12px; color: var(--acc); font-size: .85rem; font-weight: 700; }
    #{{ $uid }} .rjsr-all svg { flex: none; width: 18px; height: 18px; }

    #{{ $uid }} .rjsr-state { padding: 28px 16px 12px; text-align: center; color: var(--pmuted); }
    #{{ $uid }} .rjsr-state svg { width: 36px; height: 36px; margin: 0 auto 10px; display: block; opacity: .6; }
    #{{ $uid }} .rjsr-state p { margin: 0; font-size: .9rem; line-height: 1.5; }
    #{{ $uid }} .rjsr-retry { margin: 14px 0 6px; padding: 9px 20px; border: 0; border-radius: 999px; background: var(--acc); color: #fff; font: inherit; font-size: .8rem; font-weight: 700; cursor: pointer; }

    #{{ $uid }} .rjsr-skel { display: flex; align-items: center; gap: 14px; padding: 10px 12px; }
    #{{ $uid }} .rjsr-skel i, #{{ $uid }} .rjsr-skel b { display: block; border-radius: 8px; background: linear-gradient(90deg, rgba(148, 163, 184, .18) 25%, rgba(148, 163, 184, .34) 50%, rgba(148, 163, 184, .18) 75%); background-size: 200% 100%; animation: rjsr-shimmer 1.2s linear infinite; }
    #{{ $uid }} .rjsr-skel i { flex: none; width: 48px; height: 48px; border-radius: 10px; }
    #{{ $uid }} .rjsr-skel div { flex: 1; display: flex; flex-direction: column; gap: 8px; }
    #{{ $uid }} .rjsr-skel b { height: 10px; width: 60%; }
    #{{ $uid }} .rjsr-skel b + b { width: 35%; }

    #{{ $uid }} .rjsr-sr { position: absolute; width: 1px; height: 1px; margin: -1px; padding: 0; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }

    @keyframes rjsr-spin { to { transform: rotate(360deg); } }
    @keyframes rjsr-shimmer { from { background-position: 200% 0; } to { background-position: -200% 0; } }
    @keyframes rjsr-pop { from { opacity: 0; transform: translateY(-6px) scale(.985); } to { opacity: 1; transform: none; } }

    @media (max-width: 640px) {
        #{{ $uid }} .rjsr-thumb, #{{ $uid }} .rjsr-skel i { width: 42px; height: 42px; }
        #{{ $uid }} .rjsr-excerpt { display: none; }
        #{{ $uid }} .rjsr-field { padding: 0 14px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjsr-panel { animation: none; }
        #{{ $uid }} .rjsr-spinner, #{{ $uid }} .rjsr-skel i, #{{ $uid }} .rjsr-skel b { animation: none; }
    }
</style>

<div id="{{ $uid }}" class="rjsr @if($o['prefill'] !== '') rjsr-has-value @endif" data-style="{{ $o['style'] }}" data-config="{{ $o['config_json'] }}">
    <form class="rjsr-form" role="search" action="{{ $o['search_url'] }}" method="get" autocomplete="off">
        <div class="rjsr-field">
            <span class="rjsr-icon" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>

            <input type="text"
                   class="rjsr-input"
                   name="{{ $o['param'] }}"
                   value="{{ $o['prefill'] }}"
                   placeholder="{{ $o['placeholder'] }}"
                   aria-label="{{ $o['placeholder'] }}"
                   role="combobox"
                   aria-autocomplete="list"
                   aria-expanded="false"
                   aria-controls="{{ $uid }}-list"
                   inputmode="search"
                   enterkeyhint="search"
                   autocomplete="off"
                   autocapitalize="off"
                   spellcheck="false">

            <span class="rjsr-spinner" aria-hidden="true"></span>

            <button type="button" class="rjsr-clear" aria-label="{{ __('Clear search') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>

            @if ($o['shortcut'])
                <kbd class="rjsr-kbd" aria-hidden="true">/</kbd>
            @endif
        </div>
    </form>

    <div class="rjsr-panel" id="{{ $uid }}-list" role="listbox" aria-label="{{ __('Search results') }}" hidden></div>
    <div class="rjsr-sr" role="status" aria-live="polite"></div>
</div>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var cfg;
    try { cfg = JSON.parse(root.getAttribute('data-config')); } catch (e) { return; }
    var S = cfg.strings;
    var uid = root.id;

    var form = root.querySelector('.rjsr-form');
    var input = root.querySelector('.rjsr-input');
    var clearBtn = root.querySelector('.rjsr-clear');
    var panel = root.querySelector('.rjsr-panel');
    var field = root.querySelector('.rjsr-field');
    var live = root.querySelector('.rjsr-sr');

    var ICON_DOC = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
    var ICON_CHEV = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>';
    var ICON_ARROW = '<svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>';
    var ICON_CLOCK = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    var ICON_EMPTY = '<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM8.5 10h3"/></svg>';
    var ICON_ERROR = '<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>';

    var ESC = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' };
    var STORE = 'rjsr:recent';

    var cache = new Map();
    var timer = null;
    var ctrl = null;
    var reqId = 0;
    var active = -1;
    var isOpen = false;
    var lastQuery = '';

    // ---------- Helpers ----------
    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return ESC[c]; });
    }

    function safeUrl(u) {
        u = String(u == null ? '' : u).trim();
        if (!u) { return '#'; }
        if (/^(https?:)?\/\//i.test(u) || /^[\/#?.]/.test(u)) { return u; }
        if (/^[a-z][a-z0-9+.\-]*:/i.test(u)) { return '#'; }
        return u;
    }

    function pretty(t) {
        t = String(t || '').replace(/[_\-]+/g, ' ').trim();
        return t.charAt(0).toUpperCase() + t.slice(1);
    }

    function wrapMark(s, marked) {
        return marked ? '<mark>' + esc(s) + '</mark>' : esc(s);
    }

    function highlight(text, q) {
        text = String(text == null ? '' : text);
        var terms = q.toLowerCase().split(/\s+/).filter(Boolean);
        var lower = text.toLowerCase();
        if (!terms.length || lower.length !== text.length) { return esc(text); }

        var mask = new Array(text.length);
        terms.forEach(function (t) {
            var from = 0, idx;
            while ((idx = lower.indexOf(t, from)) !== -1) {
                for (var k = idx; k < idx + t.length; k++) { mask[k] = true; }
                from = idx + t.length;
            }
        });

        var out = '', run = '', marked = false;
        for (var i = 0; i < text.length; i++) {
            var m = !!mask[i];
            if (m !== marked) { out += wrapMark(run, marked); run = ''; marked = m; }
            run += text.charAt(i);
        }
        return out + wrapMark(run, marked);
    }

    function buildUrl(q) {
        try {
            var u = new URL(cfg.searchUrl, window.location.origin);
            u.searchParams.set(cfg.param, q);
            return u.toString();
        } catch (e) { return '#'; }
    }

    // ---------- Recent searches ----------
    function getRecent() {
        try {
            var list = JSON.parse(window.localStorage.getItem(STORE) || '[]');
            return Array.isArray(list) ? list.filter(function (x) { return typeof x === 'string'; }).slice(0, 5) : [];
        } catch (e) { return []; }
    }

    function saveRecent(q) {
        if (!cfg.showRecent || !q || q.length < cfg.minChars) { return; }
        try {
            var list = getRecent().filter(function (x) { return x.toLowerCase() !== q.toLowerCase(); });
            list.unshift(q);
            window.localStorage.setItem(STORE, JSON.stringify(list.slice(0, 5)));
        } catch (e) {}
    }

    function clearRecent() {
        try { window.localStorage.removeItem(STORE); } catch (e) {}
    }

    // ---------- Panel ----------
    function options() {
        return Array.prototype.slice.call(panel.querySelectorAll('.rjsr-opt'));
    }

    function place() {
        if (!isOpen) { return; }
        var r = field.getBoundingClientRect();
        var vh = window.innerHeight;
        var below = vh - r.bottom - 16;
        var above = r.top - 16;
        var want = Math.min(panel.scrollHeight + 2, 420);
        var up = below < Math.min(want, 240) && above > below;

        panel.style.left = r.left + 'px';
        panel.style.width = r.width + 'px';

        if (up) {
            panel.style.top = 'auto';
            panel.style.bottom = (vh - r.top + 8) + 'px';
            panel.style.maxHeight = Math.max(160, Math.min(420, above)) + 'px';
        } else {
            panel.style.bottom = 'auto';
            panel.style.top = (r.bottom + 8) + 'px';
            panel.style.maxHeight = Math.max(160, Math.min(420, below)) + 'px';
        }
    }

    function openPanel() {
        if (!isOpen) {
            isOpen = true;
            panel.hidden = false;
            input.setAttribute('aria-expanded', 'true');
        }
        place();
    }

    function closePanel() {
        if (!isOpen) { return; }
        isOpen = false;
        active = -1;
        panel.hidden = true;
        input.setAttribute('aria-expanded', 'false');
        input.removeAttribute('aria-activedescendant');
    }

    function decorate() {
        options().forEach(function (el, i) {
            el.id = uid + '-o' + i;
            el.setAttribute('role', 'option');
            el.setAttribute('aria-selected', 'false');
        });

        Array.prototype.forEach.call(panel.querySelectorAll('.rjsr-thumb img'), function (img) {
            img.addEventListener('error', function () {
                var box = img.parentNode;
                box.innerHTML = ICON_DOC;
            }, { once: true });
        });

        active = -1;
        input.removeAttribute('aria-activedescendant');
        panel.scrollTop = 0;
    }

    function setActive(i, scroll) {
        var opts = options();
        opts.forEach(function (o) {
            o.classList.remove('rjsr-active');
            o.setAttribute('aria-selected', 'false');
        });

        if (!opts.length || i < 0) {
            active = -1;
            input.removeAttribute('aria-activedescendant');
            return;
        }

        active = (i + opts.length) % opts.length;
        var el = opts[active];
        el.classList.add('rjsr-active');
        el.setAttribute('aria-selected', 'true');
        input.setAttribute('aria-activedescendant', el.id);
        if (scroll !== false && el.scrollIntoView) { el.scrollIntoView({ block: 'nearest' }); }
    }

    function announce(text) { live.textContent = text; }

    function setLoading(on) { root.classList.toggle('rjsr-loading', on); }

    // ---------- Views ----------
    function showSkeleton() {
        var row = '<div class="rjsr-skel" aria-hidden="true"><i></i><div><b></b><b></b></div></div>';
        panel.innerHTML = row + row + row;
        openPanel();
    }

    function showRecent() {
        if (!cfg.showRecent) { closePanel(); return; }
        var list = getRecent();
        if (!list.length) { closePanel(); return; }

        var html = '<div class="rjsr-group rjsr-group-row" role="presentation"><span>' + esc(S.recent) + '</span>'
            + '<button type="button" class="rjsr-clear-recent">' + esc(S.clearRecent) + '</button></div>';

        list.forEach(function (q) {
            html += '<button type="button" class="rjsr-opt rjsr-recent" data-q="' + esc(q) + '">' + ICON_CLOCK + '<span>' + esc(q) + '</span></button>';
        });

        panel.innerHTML = html;
        decorate();
        openPanel();
    }

    function footer(q) {
        if (!cfg.showViewAll) { return ''; }
        return '<a class="rjsr-opt rjsr-all" href="' + esc(buildUrl(q)) + '"><span>' + esc(S.viewAll.replace(':query', q)) + '</span>' + ICON_ARROW + '</a>';
    }

    function itemHtml(it, q) {
        var thumb = (cfg.showImage && it.image)
            ? '<span class="rjsr-thumb"><img src="' + esc(safeUrl(it.image)) + '" alt="" loading="lazy"></span>'
            : '<span class="rjsr-thumb">' + ICON_DOC + '</span>';

        var meta = '';
        if (cfg.showType && it.type) { meta += '<span class="rjsr-badge">' + esc(pretty(it.type)) + '</span>'; }
        if (it.price) { meta += '<span class="rjsr-price">' + esc(it.price) + '</span>'; }

        return '<a class="rjsr-opt rjsr-item" href="' + esc(safeUrl(it.url)) + '">'
            + thumb
            + '<span class="rjsr-body">'
            + '<span class="rjsr-title">' + highlight(it.title, q) + '</span>'
            + ((cfg.showExcerpt && it.excerpt) ? '<span class="rjsr-excerpt">' + highlight(it.excerpt, q) + '</span>' : '')
            + (meta ? '<span class="rjsr-meta">' + meta + '</span>' : '')
            + '</span>'
            + '<span class="rjsr-chev">' + ICON_CHEV + '</span>'
            + '</a>';
    }

    function render(list, q) {
        setLoading(false);
        var html = '';

        if (!list.length) {
            html = '<div class="rjsr-state">' + ICON_EMPTY + '<p>' + esc(S.noResults.replace(':query', q)) + '</p></div>' + footer(q);
            announce(S.none);
        } else {
            var groups = [];
            var map = Object.create(null);

            list.forEach(function (it) {
                var key = cfg.group ? (it.type || '') : '';
                if (!(key in map)) { map[key] = []; groups.push(key); }
                map[key].push(it);
            });

            groups.forEach(function (g) {
                if (cfg.group && g) { html += '<div class="rjsr-group" role="presentation">' + esc(pretty(g)) + '</div>'; }
                map[g].forEach(function (it) { html += itemHtml(it, q); });
            });

            html += footer(q);
            announce(S.count.replace(':count', String(list.length)));
        }

        panel.innerHTML = html;
        decorate();
        openPanel();
    }

    function showError() {
        setLoading(false);
        panel.innerHTML = '<div class="rjsr-state">' + ICON_ERROR + '<p>' + esc(S.error) + '</p>'
            + '<button type="button" class="rjsr-retry">' + esc(S.retry) + '</button></div>';
        decorate();
        openPanel();
    }

    // ---------- Data ----------
    function normalize(raw) {
        var list = Array.isArray(raw) ? raw : ((raw && (raw.results || raw.data || raw.items)) || []);
        if (!Array.isArray(list)) { list = []; }

        return list.slice(0, cfg.maxResults).map(function (it) {
            it = it || {};
            return {
                title: it.title || it.name || it.label || 'Untitled',
                url: it.url || it.link || '#',
                type: it.type || '',
                image: it.image || it.featured_image || '',
                excerpt: String(it.excerpt || it.description || '').slice(0, 140),
                price: it.price == null ? '' : it.price
            };
        });
    }

    function abortCurrent() {
        if (ctrl) { try { ctrl.abort(); } catch (e) {} ctrl = null; }
    }

    function fetchResults(q) {
        abortCurrent();
        var id = ++reqId;
        ctrl = (typeof AbortController !== 'undefined') ? new AbortController() : null;

        var url;
        try {
            url = new URL(cfg.searchUrl, window.location.origin);
            url.searchParams.set(cfg.param, q);
        } catch (e) { showError(); return; }

        fetch(url.toString(), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            signal: ctrl ? ctrl.signal : undefined
        })
            .then(function (res) {
                if (!res.ok) { throw new Error('HTTP ' + res.status); }
                return res.json();
            })
            .then(function (data) {
                if (id !== reqId) { return; }
                var list = normalize(data);
                if (cache.size > 30) { cache.delete(cache.keys().next().value); }
                cache.set(q.toLowerCase(), list);
                if (input.value.trim().toLowerCase() === q.toLowerCase()) { render(list, q); } else { setLoading(false); }
            })
            .catch(function (err) {
                if (err && err.name === 'AbortError') { return; }
                if (id !== reqId) { return; }
                showError();
            });
    }

    function onInput() {
        var raw = input.value;
        var q = raw.trim();
        root.classList.toggle('rjsr-has-value', raw.length > 0);
        clearTimeout(timer);

        if (q.length < cfg.minChars) {
            reqId++;
            abortCurrent();
            setLoading(false);
            if (!q) { showRecent(); } else { closePanel(); }
            return;
        }

        lastQuery = q;
        var cached = cache.get(q.toLowerCase());
        if (cached) {
            reqId++;
            abortCurrent();
            render(cached, q);
            return;
        }

        setLoading(true);
        if (!isOpen || !panel.querySelector('.rjsr-item')) { showSkeleton(); }
        timer = setTimeout(function () { fetchResults(q); }, cfg.debounce);
    }

    // ---------- Events ----------
    input.addEventListener('input', onInput);

    input.addEventListener('focus', function () {
        var q = input.value.trim();
        if (!q) { showRecent(); }
        else if (q.length >= cfg.minChars && panel.innerHTML.trim() !== '') { openPanel(); }
    });

    input.addEventListener('keydown', function (e) {
        var opts = options();

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!isOpen) {
                var q = input.value.trim();
                if (!q) { showRecent(); } else if (q.length >= cfg.minChars && panel.innerHTML.trim() !== '') { openPanel(); }
                return;
            }
            setActive(active + 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (!isOpen) { return; }
            setActive(active <= 0 ? opts.length - 1 : active - 1);
        } else if (e.key === 'Enter') {
            if (isOpen && active >= 0 && opts[active]) {
                e.preventDefault();
                opts[active].click();
            }
        } else if (e.key === 'Escape') {
            if (isOpen) { e.preventDefault(); closePanel(); }
            else if (input.value) { input.value = ''; onInput(); }
        } else if (e.key === 'Tab') {
            closePanel();
        }
    });

    form.addEventListener('submit', function () {
        saveRecent(input.value.trim());
    });

    clearBtn.addEventListener('click', function () {
        input.value = '';
        onInput();
        input.focus();
    });

    panel.addEventListener('mousedown', function (e) { e.preventDefault(); });

    panel.addEventListener('mousemove', function (e) {
        var opt = e.target.closest ? e.target.closest('.rjsr-opt') : null;
        if (opt) {
            var idx = options().indexOf(opt);
            if (idx !== active) { setActive(idx, false); }
        }
    });

    panel.addEventListener('click', function (e) {
        var t = e.target;
        if (!t.closest) { return; }

        if (t.closest('.rjsr-clear-recent')) { clearRecent(); closePanel(); return; }

        var rec = t.closest('.rjsr-recent');
        if (rec) {
            input.value = rec.getAttribute('data-q') || '';
            onInput();
            input.focus();
            return;
        }

        if (t.closest('.rjsr-retry')) {
            setLoading(true);
            showSkeleton();
            fetchResults(lastQuery || input.value.trim());
            return;
        }

        if (t.closest('.rjsr-opt')) { saveRecent(input.value.trim()); }
    });

    // Outside click / reposition / cleanup
    function onDocDown(e) {
        if (!root.isConnected) { document.removeEventListener('mousedown', onDocDown); return; }
        if (!root.contains(e.target)) { closePanel(); }
    }
    document.addEventListener('mousedown', onDocDown);

    function onReposition() {
        if (!root.isConnected) {
            window.removeEventListener('scroll', onReposition, true);
            window.removeEventListener('resize', onReposition);
            return;
        }
        place();
    }
    window.addEventListener('scroll', onReposition, true);
    window.addEventListener('resize', onReposition);

    if (cfg.shortcut) {
        var onKey = function (e) {
            if (!root.isConnected) { document.removeEventListener('keydown', onKey); return; }
            if (e.key !== '/' || e.ctrlKey || e.metaKey || e.altKey) { return; }
            var t = e.target;
            var tag = t && t.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || (t && t.isContentEditable)) { return; }
            e.preventDefault();
            input.focus();
            input.select();
        };
        document.addEventListener('keydown', onKey);
    }
})();
</script>
