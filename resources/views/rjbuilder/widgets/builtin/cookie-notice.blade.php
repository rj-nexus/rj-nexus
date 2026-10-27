@php
    $position      = $settings['position'] ?? 'bottom';
    $style         = $settings['style'] ?? 'card';
    $title         = $settings['title'] ?? __('We value your privacy');
    $message       = $settings['message'] ?? '';
    $privacyUrl    = trim($settings['privacy_url'] ?? '');
    $privacyLabel  = $settings['privacy_label'] ?? __('Privacy Policy');
    $acceptLabel   = $settings['accept_label'] ?? __('Accept All');
    $rejectLabel   = $settings['reject_label'] ?? __('Reject All');
    $settingsLabel = $settings['settings_label'] ?? __('Customize');
    $showSettings  = $settings['show_settings'] ?? true;
    $showReject    = $settings['show_reject'] ?? true;
    $showIcon      = $settings['show_icon'] ?? true;
    $accent        = $settings['accent'] ?? '#8b5cf6';
    $textColor     = $settings['text_color'] ?? '#0f172a';
    $mutedColor    = $settings['muted_color'] ?? '#64748b';
    $bgColor       = $settings['bg_color'] ?? '#ffffff';
    $radius        = $settings['radius'] ?? 'lg';
    $expireDays    = (int) ($settings['expire_days'] ?? 365);
    $enableCats    = $settings['enable_categories'] ?? true;
    $saveLabel     = $settings['save_label'] ?? __('Save Preferences');

    $gaId           = trim($settings['ga_id'] ?? '');
    $gtmId          = trim($settings['gtm_id'] ?? '');
    $fbPixelId      = trim($settings['fb_pixel_id'] ?? '');
    $hotjarId       = trim($settings['hotjar_id'] ?? '');
    $customAnalytics = trim($settings['custom_analytics_script'] ?? '');
    $customMarketing = trim($settings['custom_marketing_script'] ?? '');
    $customNecessary = trim($settings['custom_necessary_script'] ?? '');

    $radiusMap = ['none' => '0px', 'md' => '12px', 'lg' => '18px', 'xl' => '26px'];
    $radiusCss = $radiusMap[$radius] ?? '18px';

    $cats = [
        'necessary' => [
            'label'    => $settings['cat_necessary_label'] ?? __('Necessary'),
            'desc'     => $settings['cat_necessary_desc'] ?? '',
            'required' => true,
        ],
        'analytics' => [
            'label'    => $settings['cat_analytics_label'] ?? __('Analytics'),
            'desc'     => $settings['cat_analytics_desc'] ?? '',
            'required' => false,
        ],
        'marketing' => [
            'label'    => $settings['cat_marketing_label'] ?? __('Marketing'),
            'desc'     => $settings['cat_marketing_desc'] ?? '',
            'required' => false,
        ],
        'preferences' => [
            'label'    => $settings['cat_preferences_label'] ?? __('Preferences'),
            'desc'     => $settings['cat_preferences_desc'] ?? '',
            'required' => false,
        ],
    ];

    $storageKey = 'rj_cookie_consent_' . substr(md5($title . '|' . $privacyUrl), 0, 8);

    $scriptsConfig = [
        'gaId'              => $gaId,
        'gtmId'             => $gtmId,
        'fbPixelId'         => $fbPixelId,
        'hotjarId'          => $hotjarId,
        'customAnalytics'   => $customAnalytics,
        'customMarketing'   => $customMarketing,
        'customNecessary'   => $customNecessary,
    ];

    $hasAnyScript = $gaId || $gtmId || $fbPixelId || $hotjarId || $customAnalytics || $customMarketing || $customNecessary;
@endphp

<style>
    #{{ $uid }} {
        position: fixed;
        z-index: 99980;
        display: none;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    #{{ $uid }}.is-visible { display: block; }
    #{{ $uid }}.is-hidden { display: none !important; }

    #{{ $uid }}[data-pos="bottom"] {
        bottom: 0; left: 0; right: 0;
        padding: 0;
    }
    #{{ $uid }}[data-pos="bottom-left"] {
        bottom: 20px; left: 20px;
        max-width: 420px;
    }
    #{{ $uid }}[data-pos="bottom-right"] {
        bottom: 20px; right: 20px;
        max-width: 420px;
    }
    #{{ $uid }}[data-pos="center"] {
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        max-width: 520px;
        width: calc(100% - 32px);
    }
    #{{ $uid }}[data-pos="top"] {
        top: 0; left: 0; right: 0;
    }
    @media (max-width: 640px) {
        #{{ $uid }}[data-pos="bottom-left"],
        #{{ $uid }}[data-pos="bottom-right"] {
            left: 12px; right: 12px; bottom: 12px;
            max-width: none;
        }
    }

    #{{ $uid }} .rj-cn-card {
        position: relative;
        border-radius: {{ $radiusCss }};
        padding: 22px 24px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    #{{ $uid }}[data-pos="bottom"] .rj-cn-card,
    #{{ $uid }}[data-pos="top"] .rj-cn-card {
        border-radius: 0;
    }
    #{{ $uid }}[data-pos="bottom"] .rj-cn-card {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    #{{ $uid }}[data-pos="top"] .rj-cn-card {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    #{{ $uid }}[data-style="card"] .rj-cn-card {
        background: {{ $bgColor }};
        color: {{ $textColor }};
        border: 1px solid rgba(15,23,42,.08);
        box-shadow: 0 -4px 40px -10px rgba(15,23,42,.18);
    }
    #{{ $uid }}[data-style="dark"] .rj-cn-card {
        background: #0f172a;
        color: #f1f5f9;
        border: 1px solid rgba(255,255,255,.08);
        box-shadow: 0 -4px 40px -10px rgba(0,0,0,.5);
    }
    #{{ $uid }}[data-style="dark"] .rj-cn-msg { color: rgba(241,245,249,.75); }
    #{{ $uid }}[data-style="dark"] .rj-cn-link { color: #a5b4fc; }
    #{{ $uid }}[data-style="dark"] .rj-cn-btn.reject,
    #{{ $uid }}[data-style="dark"] .rj-cn-btn.customize {
        background: transparent;
        color: #f1f5f9;
        border-color: rgba(255,255,255,.25);
    }
    #{{ $uid }}[data-style="dark"] .rj-cn-btn.reject:hover,
    #{{ $uid }}[data-style="dark"] .rj-cn-btn.customize:hover {
        background: rgba(255,255,255,.08);
    }
    #{{ $uid }}[data-style="glass"] .rj-cn-card {
        background: rgba(255,255,255,.7);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        color: {{ $textColor }};
        border: 1px solid rgba(255,255,255,.6);
        box-shadow: 0 -4px 40px -10px rgba(15,23,42,.18);
    }
    #{{ $uid }}[data-style="minimal"] .rj-cn-card {
        background: {{ $bgColor }};
        color: {{ $textColor }};
        border: 1px solid {{ $mutedColor }}22;
        box-shadow: none;
    }

    #{{ $uid }} .rj-cn-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: {{ $accent }}15;
        color: {{ $accent }};
    }
    #{{ $uid }} .rj-cn-icon svg { width: 22px; height: 22px; }

    #{{ $uid }} .rj-cn-body {
        flex: 1;
        min-width: 220px;
    }
    #{{ $uid }} .rj-cn-title {
        font-size: 15px;
        font-weight: 800;
        color: {{ $textColor }};
        margin: 0 0 6px;
        letter-spacing: -.01em;
    }
    #{{ $uid }}[data-style="dark"] .rj-cn-title { color: #fff; }
    #{{ $uid }} .rj-cn-msg {
        font-size: 13px;
        line-height: 1.6;
        color: {{ $mutedColor }};
        margin: 0;
    }
    #{{ $uid }} .rj-cn-link {
        color: {{ $accent }};
        font-weight: 600;
        text-decoration: underline;
        text-underline-offset: 2px;
        margin-inline-start: 4px;
    }

    #{{ $uid }} .rj-cn-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
        flex-shrink: 0;
    }
    @media (max-width: 720px) {
        #{{ $uid }} .rj-cn-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
    #{{ $uid }} .rj-cn-btn {
        padding: 10px 18px;
        border-radius: 10px;
        border: 1.5px solid transparent;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .15s ease, background .2s ease, opacity .2s ease, border-color .2s ease;
        white-space: nowrap;
        font-family: inherit;
    }
    #{{ $uid }} .rj-cn-btn:active { transform: scale(.98); }
    #{{ $uid }} .rj-cn-btn.accept {
        background: {{ $accent }};
        color: #fff;
        box-shadow: 0 8px 18px -8px {{ $accent }}80;
    }
    #{{ $uid }} .rj-cn-btn.accept:hover { opacity: .92; }
    #{{ $uid }} .rj-cn-btn.reject,
    #{{ $uid }} .rj-cn-btn.customize {
        background: transparent;
        color: {{ $textColor }};
        border-color: {{ $mutedColor }}44;
    }
    #{{ $uid }} .rj-cn-btn.reject:hover,
    #{{ $uid }} .rj-cn-btn.customize:hover {
        background: {{ $mutedColor }}12;
    }

    #{{ $uid }} .rj-cn-modal {
        position: fixed;
        inset: 0;
        z-index: 99990;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    #{{ $uid }} .rj-cn-modal.is-open { display: flex; }
    #{{ $uid }} .rj-cn-modal-back {
        position: absolute;
        inset: 0;
        background: rgba(2,6,23,.7);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }
    #{{ $uid }} .rj-cn-modal-box {
        position: relative;
        background: #fff;
        color: {{ $textColor }};
        border-radius: {{ $radiusCss }};
        max-width: 520px;
        width: 100%;
        max-height: 85vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.5);
        animation: rjCnPop .35s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes rjCnPop {
        from { opacity: 0; transform: scale(.92) translateY(10px); }
        to   { opacity: 1; transform: none; }
    }
    #{{ $uid }} .rj-cn-modal-head {
        padding: 20px 24px 14px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    #{{ $uid }} .rj-cn-modal-title {
        font-size: 17px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -.01em;
    }
    #{{ $uid }} .rj-cn-modal-close {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 0;
        background: #f1f5f9;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        flex-shrink: 0;
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-cn-modal-close:hover { background: #e2e8f0; color: #0f172a; }

    #{{ $uid }} .rj-cn-modal-body {
        padding: 18px 24px;
        overflow-y: auto;
        flex: 1;
    }
    #{{ $uid }} .rj-cn-modal-body::-webkit-scrollbar { width: 8px; }
    #{{ $uid }} .rj-cn-modal-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    #{{ $uid }} .rj-cn-cat {
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    #{{ $uid }} .rj-cn-cat:last-child { border-bottom: 0; }
    #{{ $uid }} .rj-cn-cat-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 4px;
    }
    #{{ $uid }} .rj-cn-cat-name {
        font-size: 13.5px;
        font-weight: 700;
        color: {{ $textColor }};
    }
    #{{ $uid }} .rj-cn-cat-desc {
        font-size: 12px;
        line-height: 1.5;
        color: {{ $mutedColor }};
        margin: 0;
    }

    #{{ $uid }} .rj-cn-switch {
        position: relative;
        width: 40px;
        height: 22px;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-cn-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    #{{ $uid }} .rj-cn-switch span {
        position: absolute;
        inset: 0;
        background: #cbd5e1;
        border-radius: 22px;
        cursor: pointer;
        transition: background .25s ease;
    }
    #{{ $uid }} .rj-cn-switch span::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 18px;
        height: 18px;
        background: #fff;
        border-radius: 50%;
        transition: transform .25s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 2px 4px rgba(0,0,0,.15);
    }
    #{{ $uid }} .rj-cn-switch input:checked + span {
        background: {{ $accent }};
    }
    #{{ $uid }} .rj-cn-switch input:checked + span::before {
        transform: translateX(18px);
    }
    #{{ $uid }} .rj-cn-switch input:disabled + span {
        opacity: .55;
        cursor: not-allowed;
    }

    #{{ $uid }} .rj-cn-modal-foot {
        padding: 14px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-cn-save {
        padding: 10px 20px;
        border-radius: 10px;
        background: {{ $accent }};
        color: #fff;
        border: 0;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: opacity .2s ease;
        font-family: inherit;
    }
    #{{ $uid }} .rj-cn-save:hover { opacity: .92; }

    #{{ $uid }} .rj-cn-reopen {
        position: fixed;
        z-index: 99979;
        bottom: 16px;
        inset-inline-start: 16px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: {{ $bgColor }};
        border: 1px solid {{ $mutedColor }}33;
        color: {{ $accent }};
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px -8px rgba(15,23,42,.35);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    #{{ $uid }} .rj-cn-reopen.is-visible { display: flex; }
    #{{ $uid }} .rj-cn-reopen:hover {
        transform: scale(1.08);
        box-shadow: 0 12px 24px -8px rgba(15,23,42,.4);
    }
    #{{ $uid }} .rj-cn-reopen svg { width: 18px; height: 18px; }

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
     data-pos="{{ $position }}"
     data-style="{{ $style }}"
     data-key="{{ $storageKey }}"
     data-expire-days="{{ $expireDays }}"
     data-enable-cats="{{ $enableCats ? '1' : '0' }}"
     data-scripts='@json($scriptsConfig)'>

    <div class="rj-cn-card">
        @if($showIcon)
            <div class="rj-cn-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    <circle cx="9" cy="10" r="1" fill="currentColor"/>
                    <circle cx="15" cy="10" r="1" fill="currentColor"/>
                    <circle cx="12" cy="15" r="1" fill="currentColor"/>
                    <circle cx="16" cy="15" r="1" fill="currentColor"/>
                </svg>
            </div>
        @endif

        <div class="rj-cn-body">
            @if($title !== '')
                <h3 class="rj-cn-title">{{ $title }}</h3>
            @endif
            @if($message !== '')
                <p class="rj-cn-msg">
                    {{ $message }}
                    @if($privacyUrl !== '')
                        <a href="{{ $privacyUrl }}" class="rj-cn-link">{{ $privacyLabel }}</a>
                    @endif
                </p>
            @endif
        </div>

        <div class="rj-cn-actions">
            @if($showSettings)
                <button type="button" class="rj-cn-btn customize" data-action="customize">
                    {{ $settingsLabel }}
                </button>
            @endif
            @if($showReject)
                <button type="button" class="rj-cn-btn reject" data-action="reject">
                    {{ $rejectLabel }}
                </button>
            @endif
            <button type="button" class="rj-cn-btn accept" data-action="accept">
                {{ $acceptLabel }}
            </button>
        </div>
    </div>

    <div class="rj-cn-modal" data-modal>
        <div class="rj-cn-modal-back" data-modal-back></div>
        <div class="rj-cn-modal-box" role="dialog" aria-modal="true">
            <div class="rj-cn-modal-head">
                <h4 class="rj-cn-modal-title">{{ __('Cookie Settings') }}</h4>
                <button type="button" class="rj-cn-modal-close" data-modal-back aria-label="{{ __('Close') }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="rj-cn-modal-body">
                @foreach($cats as $key => $cat)
                    <div class="rj-cn-cat" data-cat="{{ $key }}">
                        <div class="rj-cn-cat-head">
                            <span class="rj-cn-cat-name">{{ $cat['label'] }}</span>
                            <label class="rj-cn-switch">
                                <input type="checkbox" data-cat-input="{{ $key }}"
                                       @if($cat['required']) checked disabled @endif
                                       @if(!$cat['required']) checked @endif>
                                <span></span>
                            </label>
                        </div>
                        @if($cat['desc'] !== '')
                            <p class="rj-cn-cat-desc">{{ $cat['desc'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="rj-cn-modal-foot">
                <button type="button" class="rj-cn-save" data-action="save">{{ $saveLabel }}</button>
            </div>
        </div>
    </div>

    <button type="button" class="rj-cn-reopen" data-reopen aria-label="{{ __('Cookie Settings') }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            <circle cx="9" cy="10" r="1" fill="currentColor"/>
            <circle cx="15" cy="10" r="1" fill="currentColor"/>
            <circle cx="12" cy="15" r="1" fill="currentColor"/>
        </svg>
    </button>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var storageKey = root.getAttribute('data-key') || 'rj_cookie_consent';
    var expireDays = parseInt(root.getAttribute('data-expire-days'), 10) || 365;
    var scriptsConfig = {};
    try { scriptsConfig = JSON.parse(root.getAttribute('data-scripts') || '{}'); } catch (e) {}

    var modal = root.querySelector('[data-modal]');
    var reopenBtn = root.querySelector('[data-reopen]');

    var loaded = { analytics: false, marketing: false, preferences: false, necessary: false };

    /* ============================================
       SCRIPT LOADERS
       ============================================ */

    function loadGA(id) {
        if (!id || loaded.analytics) return;
        var s = document.createElement('script');
        s.async = true;
        s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id);
        document.head.appendChild(s);
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () { window.dataLayer.push(arguments); };
        window.gtag('js', new Date());
        window.gtag('config', id, { anonymize_ip: true });
    }

    function loadGTM(id) {
        if (!id) return;
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
        var s = document.createElement('script');
        s.async = true;
        s.src = 'https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(id);
        document.head.appendChild(s);
    }

    function loadFbPixel(id) {
        if (!id || loaded.marketing) return;
        !function(f,b,e,v,n,t,s){
            if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        window.fbq('init', id);
        window.fbq('track', 'PageView');
    }

    function loadHotjar(id) {
        if (!id || loaded.analytics) return;
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:parseInt(id,10),hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    }

    function injectCustom(html, marker) {
        if (!html) return;
        var temp = document.createElement('div');
        temp.innerHTML = html;
        var nodes = Array.prototype.slice.call(temp.childNodes);
        nodes.forEach(function (node) {
            if (node.tagName === 'SCRIPT') {
                var s = document.createElement('script');
                Array.from(node.attributes).forEach(function (a) {
                    s.setAttribute(a.name, a.value);
                });
                if (node.src) {
                    s.src = node.src;
                    s.async = false;
                    document.head.appendChild(s);
                } else {
                    s.text = node.textContent;
                    document.head.appendChild(s);
                }
            } else {
                document.head.appendChild(node.cloneNode(true));
            }
        });
    }

    /* ============================================
       APPLY CONSENT
       ============================================ */

    function applyConsent(cats) {
        cats = cats || {};

        if (cats.necessary && !loaded.necessary) {
            loaded.necessary = true;
            injectCustom(scriptsConfig.customNecessary || '', 'necessary');
        }

        if (cats.analytics && !loaded.analytics) {
            loaded.analytics = true;
            if (scriptsConfig.gaId) loadGA(scriptsConfig.gaId);
            if (scriptsConfig.gtmId) loadGTM(scriptsConfig.gtmId);
            if (scriptsConfig.hotjarId) loadHotjar(scriptsConfig.hotjarId);
            if (scriptsConfig.customAnalytics) injectCustom(scriptsConfig.customAnalytics, 'analytics');
        }

        if (cats.marketing && !loaded.marketing) {
            loaded.marketing = true;
            if (scriptsConfig.fbPixelId) loadFbPixel(scriptsConfig.fbPixelId);
            if (scriptsConfig.customMarketing) injectCustom(scriptsConfig.customMarketing, 'marketing');
        }
    }

    /* ============================================
       STORAGE
       ============================================ */

    function readConsent() {
        try {
            var raw = localStorage.getItem(storageKey);
            if (!raw) return null;
            var data = JSON.parse(raw);
            if (!data || !data.expires) return null;
            if (Date.now() > data.expires) {
                localStorage.removeItem(storageKey);
                return null;
            }
            return data;
        } catch (e) { return null; }
    }

    function saveConsent(cats) {
        var expires = Date.now() + expireDays * 86400000;
        var payload = {
            categories: cats,
            timestamp: Date.now(),
            expires: expires,
        };
        try {
            localStorage.setItem(storageKey, JSON.stringify(payload));
        } catch (e) {}

        try {
            document.dispatchEvent(new CustomEvent('rj:cookie-consent', { detail: payload }));
        } catch (e) {}

        applyConsent(cats);
    }

    function getAllCategories() {
        var cats = {};
        root.querySelectorAll('[data-cat-input]').forEach(function (input) {
            var key = input.getAttribute('data-cat-input');
            cats[key] = input.checked;
        });
        if (!Object.keys(cats).length) {
            cats = { necessary: true, analytics: false, marketing: false, preferences: false };
        }
        return cats;
    }

    function applyToInputs(cats) {
        if (!cats) return;
        root.querySelectorAll('[data-cat-input]').forEach(function (input) {
            var key = input.getAttribute('data-cat-input');
            if (input.disabled) return;
            if (typeof cats[key] === 'boolean') input.checked = cats[key];
        });
    }

    /* ============================================
       UI
       ============================================ */

    function showBanner() {
        root.classList.add('is-visible');
        root.classList.remove('is-hidden');
        if (reopenBtn) reopenBtn.classList.remove('is-visible');
    }

    function hideBanner() {
        root.classList.remove('is-visible');
        root.classList.add('is-hidden');
        if (reopenBtn) reopenBtn.classList.add('is-visible');
    }

    function openModal() {
        if (!modal) return;
        var consent = readConsent();
        if (consent && consent.categories) applyToInputs(consent.categories);
        modal.classList.add('is-open');
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.remove('is-open');
    }

    /* ============================================
       INIT
       ============================================ */

    injectCustom(scriptsConfig.customNecessary || '', 'necessary');
    loaded.necessary = true;

    var existing = readConsent();
    if (existing) {
        if (reopenBtn) reopenBtn.classList.add('is-visible');
        applyToInputs(existing.categories || {});
        applyConsent(existing.categories || {});
    } else {
        showBanner();
    }

    root.addEventListener('click', function (e) {
        var action = e.target.closest('[data-action]');
        if (!action) {
            if (e.target.closest('[data-modal-back]')) closeModal();
            if (e.target.closest('[data-reopen]')) {
                if (reopenBtn) reopenBtn.classList.remove('is-visible');
                if (root.classList.contains('is-hidden')) {
                    root.classList.remove('is-hidden');
                    root.classList.add('is-visible');
                }
                openModal();
            }
            return;
        }

        var type = action.getAttribute('data-action');

        if (type === 'accept') {
            saveConsent({ necessary: true, analytics: true, marketing: true, preferences: true });
            hideBanner();
            closeModal();
        } else if (type === 'reject') {
            saveConsent({ necessary: true, analytics: false, marketing: false, preferences: false });
            hideBanner();
            closeModal();
        } else if (type === 'customize') {
            if (root.classList.contains('is-hidden')) {
                root.classList.remove('is-hidden');
                root.classList.add('is-visible');
            }
            if (reopenBtn) reopenBtn.classList.remove('is-visible');
            openModal();
        } else if (type === 'save') {
            saveConsent(getAllCategories());
            hideBanner();
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
})();
</script>
