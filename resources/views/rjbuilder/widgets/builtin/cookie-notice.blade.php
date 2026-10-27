@php
    $color = fn ($v, $d) => preg_match('/^#[0-9a-f]{3,8}$/i', (string) $v) ? $v : $d;
    $bool  = fn ($k, $d = true) => filter_var($settings[$k] ?? $d, FILTER_VALIDATE_BOOLEAN);
    $pick  = fn ($k, $opts, $d) => in_array($settings[$k] ?? $d, $opts, true) ? $settings[$k] : $d;
    $text  = fn ($k, $d) => trim((string) ($settings[$k] ?? '')) !== '' ? $settings[$k] : $d;

    $pos       = $pick('position', ['bottom', 'bottom-left', 'bottom-right', 'center', 'top'], 'bottom');
    $style     = $pick('style', ['card', 'dark', 'glass', 'minimal'], 'card');
    $accent    = $color($settings['accent'] ?? '', '#8b5cf6');
    $ink       = $color($settings['text_color'] ?? '', '#0f172a');
    $muted     = $color($settings['muted_color'] ?? '', '#64748b');
    $bg        = $color($settings['bg_color'] ?? '', '#ffffff');
    $radiusCss = ['none' => '0px', 'md' => '12px', 'lg' => '20px', 'xl' => '28px'][$settings['radius'] ?? 'lg'] ?? '20px';
    $days      = max(1, (int) ($settings['expire_days'] ?? 365));

    $title   = $settings['title'] ?? __('We value your privacy');
    $message = $settings['message'] ?? '';
    $privacy = trim((string) ($settings['privacy_url'] ?? ''));
    $privacy = preg_match('#^(https?://|/|\#)#i', $privacy) ? $privacy : '';

    $showSettings = $bool('show_settings');
    $showReject   = $bool('show_reject');
    $showCookie   = $bool('show_icon');

    $cats = [];
    foreach (['necessary' => __('Necessary'), 'analytics' => __('Analytics'), 'marketing' => __('Marketing'), 'preferences' => __('Preferences')] as $k => $label) {
        $cats[$k] = ['label' => $text("cat_{$k}_label", $label), 'desc' => (string) ($settings["cat_{$k}_desc"] ?? '')];
    }

    $scripts = [];
    foreach (['gaId' => 'ga_id', 'gtmId' => 'gtm_id', 'fbPixelId' => 'fb_pixel_id', 'hotjarId' => 'hotjar_id', 'customAnalytics' => 'custom_analytics_script', 'customMarketing' => 'custom_marketing_script', 'customNecessary' => 'custom_necessary_script'] as $js => $key) {
        $scripts[$js] = trim((string) ($settings[$key] ?? ''));
    }

    $storageKey = 'rj_cookie_consent_' . substr(md5($title . '|' . $privacy), 0, 8);
@endphp

<style>
    #{{ $uid }} {
        --accent: {{ $accent }};
        --ink: {{ $ink }};
        --muted: {{ $muted }};
        --bg: {{ $bg }};
        --solid: {{ $bg }};
        --r: {{ $radiusCss }};
        --line: color-mix(in srgb, var(--muted) 28%, transparent);
        --link: var(--accent);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

        &[data-style="dark"] { --bg: #0f172a; --solid: #0f172a; --ink: #f1f5f9; --muted: #94a3b8; --link: color-mix(in srgb, var(--accent) 55%, #fff); }
        &[data-style="glass"] { --bg: rgba(255, 255, 255, .72); --solid: #fff;
            .cn-card { -webkit-backdrop-filter: blur(16px); backdrop-filter: blur(16px); }
        }
        &[data-style="minimal"] .cn-card { box-shadow: none; }

        .cn-banner { position: fixed; z-index: 99980; display: none; --cr: var(--r); --from: 50px;
            &.is-visible { display: block; animation: rj-cn-in .7s cubic-bezier(.2, .9, .3, 1.1) both; }
        }
        &[data-pos="bottom"] .cn-banner { inset: auto 0 0; --cr: var(--r) var(--r) 0 0; }
        &[data-pos="top"] .cn-banner { inset: 0 0 auto; --cr: 0 0 var(--r) var(--r); --from: -50px; }
        &[data-pos="bottom-left"] .cn-banner { left: 20px; bottom: 20px; width: min(460px, calc(100% - 24px)); }
        &[data-pos="bottom-right"] .cn-banner { right: 20px; bottom: 20px; width: min(460px, calc(100% - 24px)); }
        &[data-pos="center"] .cn-banner { top: 50%; left: 50%; translate: -50% -50%; width: min(560px, calc(100% - 32px)); }

        .cn-card { --px: 24px; position: relative; display: flex; flex-wrap: wrap; align-items: center; gap: 16px 24px; padding: 26px var(--px) 44px; overflow: hidden; border: 1px solid var(--line); border-radius: var(--cr); background: var(--bg); color: var(--ink); box-shadow: 0 -18px 60px -24px rgba(15, 23, 42, .4);
            &::before { content: ""; position: absolute; inset: 0 0 auto; z-index: 2; height: 3px; background: linear-gradient(90deg, var(--accent), #fbbc04, #34a853, #ea4335, var(--accent)) 0 0 / 200% 100%; animation: rj-cn-flow 5s linear infinite; }
        }
        &[data-pos="bottom"] .cn-card, &[data-pos="top"] .cn-card { --px: max(24px, calc((100% - 1200px) / 2)); }
        .has-cookie .cn-card { padding-inline-start: calc(var(--px) + 64px); }

        .cn-waves { position: absolute; inset: auto 0 0; z-index: 0; height: 36px; pointer-events: none;
            svg { position: absolute; bottom: 0; left: 0; width: 200%; height: 100%; fill: var(--accent); }
            svg:nth-child(1) { opacity: .14; animation: rj-cn-wave 9s linear infinite; }
            svg:nth-child(2) { height: 72%; opacity: .2; animation: rj-cn-wave 6s linear infinite reverse; }
            svg:nth-child(3) { height: 44%; opacity: .28; animation: rj-cn-wave 4s linear infinite; }
        }

        .cn-cookie { position: absolute; top: 14px; inset-inline-start: max(14px, calc(var(--px) - 6px)); z-index: 3; width: 58px; height: 58px; pointer-events: none;
            svg { display: block; width: 100%; height: 100%; filter: drop-shadow(0 8px 8px rgba(120, 66, 18, .35)); animation: rj-cn-wobble 5s ease-in-out infinite; }
            i { position: absolute; top: 80%; left: 50%; width: 5px; height: 5px; border-radius: 50%; background: #b9743a; opacity: 0; translate: var(--x) 0; animation: rj-cn-crumb 2.6s ease-in infinite var(--d); }
        }

        .cn-body, .cn-actions { position: relative; z-index: 1; }
        .cn-body { flex: 1; min-width: 240px; }
        .cn-title { margin: 0 0 6px; font-size: 16px; font-weight: 800; letter-spacing: -.01em; }
        .cn-msg { margin: 0; font-size: 13.5px; line-height: 1.6; color: var(--muted); }
        .cn-link { margin-inline-start: 4px; color: var(--link); font-weight: 600; text-decoration: underline; text-underline-offset: 2px; }

        .cn-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
        .cn-btn { position: relative; overflow: hidden; padding: 11px 20px; border: 1.5px solid var(--line); border-radius: 12px; background: transparent; color: var(--ink); font-family: inherit; font-size: 13px; font-weight: 700; line-height: 1; white-space: nowrap; cursor: pointer; transition: transform .15s, background .2s, border-color .2s;
            &:hover { background: color-mix(in srgb, var(--muted) 12%, transparent); }
            &:active { transform: scale(.97); }
            &.is-primary { border-color: var(--accent); background: var(--accent); color: #fff; box-shadow: 0 12px 22px -12px var(--accent);
                &:hover { background: var(--accent); filter: brightness(1.08); }
                &::after { content: ""; position: absolute; top: 0; bottom: 0; left: -60%; width: 40%; background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .55), transparent); transform: skewX(-20deg); animation: rj-cn-shine 3.4s ease-in-out infinite; }
            }
        }

        .cn-modal { position: fixed; inset: 0; z-index: 99990; display: none; place-items: center; padding: 20px;
            &.is-open { display: grid; }
        }
        .cn-back { position: absolute; inset: 0; background: rgba(2, 6, 23, .65); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); }
        .cn-box { position: relative; display: flex; flex-direction: column; width: 100%; max-width: 520px; max-height: 85vh; overflow: hidden; border-radius: var(--r); background: var(--solid); color: var(--ink); box-shadow: 0 40px 80px -20px rgba(0, 0, 0, .55); animation: rj-cn-pop .4s cubic-bezier(.34, 1.56, .64, 1) both; }
        .cn-box-head { display: flex; align-items: center; gap: 12px; padding: 18px 22px; border-bottom: 1px solid var(--line);
            svg { width: 32px; height: 32px; animation: rj-cn-wobble 5s ease-in-out infinite; }
            h4 { flex: 1; margin: 0; font-size: 17px; font-weight: 800; letter-spacing: -.01em; }
            button { display: grid; place-items: center; width: 32px; height: 32px; padding: 0; border: 0; border-radius: 10px; background: color-mix(in srgb, var(--muted) 16%, transparent); color: var(--muted); cursor: pointer; transition: .2s;
                &:hover { color: var(--ink); }
                svg { width: 14px; height: 14px; animation: none; }
            }
        }
        .cn-box-body { flex: 1; padding: 6px 22px; overflow-y: auto; }
        .cn-cat { padding: 14px 0; border-bottom: 1px solid var(--line);
            &:last-child { border-bottom: 0; }
            div { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 4px; }
            b { font-size: 13.5px; font-weight: 700; }
            p { margin: 0; font-size: 12px; line-height: 1.5; color: var(--muted); }
        }
        .cn-switch { position: relative; flex: none; width: 42px; height: 24px;
            input { position: absolute; width: 0; height: 0; opacity: 0; }
            span { position: absolute; inset: 0; border-radius: 24px; background: color-mix(in srgb, var(--muted) 40%, transparent); cursor: pointer; transition: background .25s;
                &::before { content: ""; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 50%; background: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, .2); transition: transform .25s cubic-bezier(.34, 1.56, .64, 1); }
            }
            input:checked + span { background: var(--accent); }
            input:checked + span::before { transform: translateX(18px); }
            input:disabled + span { opacity: .55; cursor: not-allowed; }
        }
        .cn-box-foot { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 22px; border-top: 1px solid var(--line); }

        @media (max-width: 720px) {
            .cn-actions { width: 100%; }
            .cn-btn { flex: 1; }
        }
        @media (max-width: 640px) {
            &[data-pos="bottom-left"] .cn-banner, &[data-pos="bottom-right"] .cn-banner { left: 12px; right: 12px; bottom: 12px; width: auto; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    }

    @keyframes rj-cn-in { from { opacity: 0; transform: translateY(var(--from)); } to { opacity: 1; transform: none; } }
    @keyframes rj-cn-pop { from { opacity: 0; transform: scale(.9) translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes rj-cn-flow { to { background-position: 200% 0; } }
    @keyframes rj-cn-shine { 0%, 55% { left: -60%; } 100% { left: 130%; } }
    @keyframes rj-cn-wave { to { transform: translateX(-50%); } }
    @keyframes rj-cn-wobble { 0%, 100% { transform: rotate(-9deg); } 50% { transform: rotate(9deg) translateY(-4px); } }
    @keyframes rj-cn-crumb { 0% { opacity: 0; transform: translateY(0) scale(.6); } 15% { opacity: 1; } 100% { opacity: 0; transform: translateY(34px) rotate(200deg) scale(1); } }
</style>

<div id="{{ $uid }}" data-pos="{{ $pos }}" data-style="{{ $style }}" data-key="{{ $storageKey }}" data-days="{{ $days }}" data-scripts="{{ json_encode($scripts) }}">
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <mask id="{{ $uid }}-m"><rect width="64" height="64" fill="#fff"/><circle cx="53" cy="13" r="10" fill="#000"/></mask>
            <path id="{{ $uid }}-w" d="M0 20Q150 0 300 20T600 20T900 20T1200 20V40H0Z"/>
        </defs>
        <symbol id="{{ $uid }}-ck" viewBox="0 0 64 64">
            <g mask="url(#{{ $uid }}-m)">
                <circle cx="32" cy="32" r="29" fill="#e0a363"/>
                <circle cx="32" cy="32" r="29" fill="none" stroke="#b9743a" stroke-width="3"/>
                <path d="M12 24a22 22 0 0 1 14-14" fill="none" stroke="#f3c78f" stroke-width="3" stroke-linecap="round"/>
                <g fill="#5a3825">
                    <ellipse cx="22" cy="26" rx="4.2" ry="3.4" transform="rotate(-20 22 26)"/>
                    <ellipse cx="38" cy="36" rx="4.6" ry="3.6" transform="rotate(25 38 36)"/>
                    <ellipse cx="21" cy="42" rx="3.6" ry="3"/>
                    <ellipse cx="34" cy="21" rx="3.4" ry="2.8"/>
                    <ellipse cx="45" cy="48" rx="3.4" ry="2.8" transform="rotate(-30 45 48)"/>
                    <ellipse cx="31" cy="50" rx="3" ry="2.4"/>
                </g>
            </g>
        </symbol>
    </svg>

    <div class="cn-banner {{ $showCookie ? 'has-cookie' : '' }}" role="region" aria-label="{{ $title }}">
        <div class="cn-card">
            <div class="cn-waves" aria-hidden="true">
                @foreach([0, 1, 2] as $i)
                    <svg viewBox="0 0 1200 40" preserveAspectRatio="none"><use href="#{{ $uid }}-w"/></svg>
                @endforeach
            </div>

            @if($showCookie)
                <div class="cn-cookie" aria-hidden="true">
                    <svg viewBox="0 0 64 64"><use href="#{{ $uid }}-ck"/></svg>
                    <i style="--x:-12px;--d:0s"></i><i style="--x:2px;--d:.9s"></i><i style="--x:14px;--d:1.7s"></i>
                </div>
            @endif

            <div class="cn-body">
                @if($title !== '')<h3 class="cn-title">{{ $title }}</h3>@endif
                @if($message !== '' || $privacy !== '')
                    <p class="cn-msg">
                        {{ $message }}
                        @if($privacy !== '')<a class="cn-link" href="{{ $privacy }}">{{ $text('privacy_label', __('Privacy Policy')) }}</a>@endif
                    </p>
                @endif
            </div>

            <div class="cn-actions">
                @if($showSettings)<button type="button" class="cn-btn" data-do="customize">{{ $text('settings_label', __('Customize')) }}</button>@endif
                @if($showReject)<button type="button" class="cn-btn" data-do="reject">{{ $text('reject_label', __('Reject All')) }}</button>@endif
                <button type="button" class="cn-btn is-primary" data-do="accept">{{ $text('accept_label', __('Accept All')) }}</button>
            </div>
        </div>
    </div>

    <div class="cn-modal">
        <div class="cn-back" data-do="close"></div>
        <div class="cn-box" role="dialog" aria-modal="true">
            <div class="cn-box-head">
                <svg viewBox="0 0 64 64"><use href="#{{ $uid }}-ck"/></svg>
                <h4>{{ __('Cookie Settings') }}</h4>
                <button type="button" data-do="close" aria-label="{{ __('Close') }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="cn-box-body">
                @foreach($cats as $key => $cat)
                    <div class="cn-cat">
                        <div>
                            <b>{{ $cat['label'] }}</b>
                            <label class="cn-switch">
                                <input type="checkbox" data-cat="{{ $key }}" checked @if($key === 'necessary') disabled @endif>
                                <span></span>
                            </label>
                        </div>
                        @if($cat['desc'] !== '')<p>{{ $cat['desc'] }}</p>@endif
                    </div>
                @endforeach
            </div>
            <div class="cn-box-foot">
                <button type="button" class="cn-btn is-primary" data-do="save">{{ $text('save_label', __('Save Preferences')) }}</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var banner = root.querySelector('.cn-banner');
    var modal  = root.querySelector('.cn-modal');
    var inputs = root.querySelectorAll('[data-cat]');
    var key    = root.dataset.key;
    var days   = parseInt(root.dataset.days, 10) || 365;
    var cfg    = {};
    var done   = {};
    try { cfg = JSON.parse(root.dataset.scripts || '{}'); } catch (e) {}

    function addScript(src) {
        var s = document.createElement('script');
        s.async = true;
        s.src = src;
        document.head.appendChild(s);
    }

    function inject(html) {
        if (!html) return;
        var box = document.createElement('div');
        box.innerHTML = html;
        Array.prototype.slice.call(box.children).forEach(function (node) {
            if (node.tagName !== 'SCRIPT') { document.head.appendChild(node); return; }
            var s = document.createElement('script');
            Array.prototype.forEach.call(node.attributes, function (a) { s.setAttribute(a.name, a.value); });
            s.text = node.textContent;
            document.head.appendChild(s);
        });
    }

    var loaders = {
        necessary: function () {
            inject(cfg.customNecessary);
        },
        analytics: function () {
            window.dataLayer = window.dataLayer || [];
            if (cfg.gaId) {
                addScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(cfg.gaId));
                window.gtag = function () { window.dataLayer.push(arguments); };
                window.gtag('js', new Date());
                window.gtag('config', cfg.gaId, { anonymize_ip: true });
            }
            if (cfg.gtmId) {
                window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' });
                addScript('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(cfg.gtmId));
            }
            if (cfg.hotjarId) {
                window.hj = window.hj || function () { (window.hj.q = window.hj.q || []).push(arguments); };
                window._hjSettings = { hjid: parseInt(cfg.hotjarId, 10), hjsv: 6 };
                addScript('https://static.hotjar.com/c/hotjar-' + encodeURIComponent(cfg.hotjarId) + '.js?sv=6');
            }
            inject(cfg.customAnalytics);
        },
        marketing: function () {
            if (cfg.fbPixelId) {
                if (!window.fbq) {
                    var n = window.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
                    if (!window._fbq) window._fbq = n;
                    n.push = n; n.loaded = true; n.version = '2.0'; n.queue = [];
                    addScript('https://connect.facebook.net/en_US/fbevents.js');
                }
                window.fbq('init', cfg.fbPixelId);
                window.fbq('track', 'PageView');
            }
            inject(cfg.customMarketing);
        }
    };

    function apply(cats) {
        Object.keys(loaders).forEach(function (k) {
            if (cats[k] && !done[k]) { done[k] = true; loaders[k](); }
        });
    }

    function read() {
        try {
            var d = JSON.parse(localStorage.getItem(key));
            if (d && d.expires > Date.now()) return d;
            localStorage.removeItem(key);
        } catch (e) {}
        return null;
    }

    function save(cats) {
        var payload = { categories: cats, timestamp: Date.now(), expires: Date.now() + days * 86400000 };
        try { localStorage.setItem(key, JSON.stringify(payload)); } catch (e) {}
        try { document.dispatchEvent(new CustomEvent('rj:cookie-consent', { detail: payload })); } catch (e) {}
        apply(cats);
    }

    function collect() {
        var cats = {};
        inputs.forEach(function (i) { cats[i.dataset.cat] = i.checked; });
        cats.necessary = true;
        return cats;
    }

    function fill(cats) {
        inputs.forEach(function (i) {
            if (!i.disabled && typeof cats[i.dataset.cat] === 'boolean') i.checked = cats[i.dataset.cat];
        });
    }

    function choose(cats) {
        save(cats);
        banner.classList.remove('is-visible');
        modal.classList.remove('is-open');
    }

    function openSettings() {
        var c = read();
        if (c) fill(c.categories || {});
        modal.classList.add('is-open');
    }

    window.rjCookieSettings = openSettings;
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-cookie-settings]')) { e.preventDefault(); openSettings(); }
    });

    apply({ necessary: true });

    var existing = read();
    if (existing) {
        fill(existing.categories || {});
        apply(existing.categories || {});
    } else {
        banner.classList.add('is-visible');
    }

    root.addEventListener('click', function (e) {
        var t = e.target.closest('[data-do]');
        if (!t) return;
        var a = t.dataset.do;
        if (a === 'accept') choose({ necessary: true, analytics: true, marketing: true, preferences: true });
        else if (a === 'reject') choose({ necessary: true, analytics: false, marketing: false, preferences: false });
        else if (a === 'save') choose(collect());
        else if (a === 'customize') openSettings();
        else if (a === 'close') modal.classList.remove('is-open');
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') modal.classList.remove('is-open');
    });
})();
</script>
