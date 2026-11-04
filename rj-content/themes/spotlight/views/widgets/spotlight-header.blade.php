@php
    $uid = 'sh_' . substr(md5(uniqid('', true)), 0, 8);

    $menuId = $settings['menu_id'] ?? '';
    $allMenus = function_exists('rj_menu_tree') ? rj_menu_tree() : [];
    $menuItems = [];

    if (!empty($menuId) && isset($allMenus[$menuId])) {
        $menuItems = $allMenus[$menuId]['items'] ?? [];
    }

    if (empty($menuItems)) {
        foreach ($allMenus as $menu) {
            if (in_array(strtolower($menu['location'] ?? ''), ['header', 'main', 'primary'])) {
                $menuItems = $menu['items'];
                break;
            }
        }
    }

    if (empty($menuItems) && !empty($allMenus)) {
        $menuItems = reset($allMenus)['items'] ?? [];
    }

    $currentLocale = app()->getLocale();
    $locales = function_exists('rj_frontend_locales') ? rj_frontend_locales() : ['en'];

    $logoImage = trim((string) ($settings['logo_image'] ?? ''));
    $logoText = trim((string) ($settings['logo_text'] ?? ''));
    $defaultLogo = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/rj%20cms.png';

    $ctaText = $settings['cta_text'] ?? '';
    $ctaUrl = $settings['cta_url'] ?? '#';

    $showLang = $settings['show_language'] ?? true;
    $showLogin = $settings['show_login'] ?? true;
    $loginLabel = $settings['login_label'] ?? __('Login');

    $authUser = auth()->user();
    $initialUser = null;
    if ($authUser) {
        $name = trim((string) $authUser->name);
        $parts = preg_split('/\s+/u', $name) ?: [];

        $initialUser = [
            'name'    => $authUser->name,
            'first'   => $parts[0] ?? $name,
            'account' => route('frontend.account.index', absolute: false),
        ];
    }

    $getLocaleRedirect = function (string $targetLoc) {
        if (isset($post) && $post instanceof \App\Models\Post) {
            $slug = $post->localizedSlug($targetLoc);
            if ($slug) {
                return $post->type === 'page' ? '/' . $targetLoc . '/' . $slug : '/' . $targetLoc . '/blog/' . $slug;
            }
        }
        $currentPath = request()->path();
        $currentLoc = app()->getLocale();
        if ($currentPath === $currentLoc || $currentPath === $currentLoc . '/') return '/' . $targetLoc;
        if (str_starts_with($currentPath, $currentLoc . '/')) $currentPath = substr($currentPath, strlen($currentLoc) + 1);
        return '/' . $targetLoc . '/' . ltrim($currentPath, '/');
    };

    $getFlag = function (string $code): string {
        if (function_exists('rj_lang_flag_url')) {
            $url = rj_lang_flag_url($code);
            if ($url) return '<img src="' . e($url) . '" alt="">';
        }
        $label = $code === 'en' ? 'GB' : strtoupper(mb_substr($code, 0, 2));
        return '<b>' . e($label) . '</b>';
    };

    $flagAttrs = function (string $code): string {
        $hasImg = function_exists('rj_lang_flag_url') && rj_lang_flag_url($code);
        if ($hasImg) return 'class="rj-glass-flag"';
        $h  = crc32($code) % 360;
        $h2 = ($h + 50) % 360;
        return 'class="rj-glass-flag is-badge" style="background:linear-gradient(135deg,hsl(' . $h . ' 75% 62%),hsl(' . $h2 . ' 72% 48%));"';
    };
@endphp

<header class="rj-glass-header" id="rj-header">
    <div class="rj-glass-header-inner">

        <a href="{{ url('/' . $currentLocale) }}" class="rj-glass-logo">
            @if($logoImage !== '')
                <img src="{{ $logoImage }}" alt="{{ $logoText !== '' ? $logoText : 'Logo' }}">
            @elseif($logoText !== '')
                <span>{{ $logoText }}</span>
            @else
                <img src="{{ $defaultLogo }}" alt="RJ CMS">
            @endif
        </a>

        <nav class="rj-glass-nav">
            @foreach($menuItems as $item)
                <div class="rj-glass-nav-item">
                    <a href="{{ $item['url'] ?? '#' }}" target="{{ $item['target'] ?? '_self' }}" class="rj-glass-nav-link">
                        {{ $item['label'] ?? '' }}
                        @if(!empty($item['children']))
                            <svg class="rj-glass-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        @endif
                    </a>
                    @if(!empty($item['children']))
                        <div class="rj-glass-dropdown">
                            @foreach($item['children'] as $child)
                                <a href="{{ $child['url'] ?? '#' }}" target="{{ $child['target'] ?? '_self' }}" class="rj-glass-dropdown-link">
                                    {{ $child['label'] ?? '' }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <div class="rj-glass-actions">
            @if($showLang && count($locales) > 1)
                <div class="rj-glass-nav-item" id="{{ $uid }}_lang">
                    <button type="button" class="rj-glass-lang-btn" data-toggle>
                        <span {!! $flagAttrs($currentLocale) !!}>{!! $getFlag($currentLocale) !!}</span>
                        <span>{{ strtoupper($currentLocale) }}</span>
                        <svg class="rj-glass-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="rj-glass-dropdown rj-dropdown-right" data-menu>
                        @foreach($locales as $loc)
                            <a href="{{ route('rj.widget.locale', ['locale' => $loc, 'redirect' => $getLocaleRedirect($loc)]) }}" class="rj-glass-dropdown-link {{ $loc === $currentLocale ? 'active' : '' }}">
                                <span {!! $flagAttrs($loc) !!}>{!! $getFlag($loc) !!}</span>
                                <span>{{ function_exists('rj_lang_name') ? rj_lang_name($loc) : strtoupper($loc) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($showLogin)
                <div id="{{ $uid }}_login" class="rj-glass-login-wrap">
                    <div data-logged-out @if($initialUser) style="display:none;" @endif>
                        <button type="button" class="rj-glass-login-btn" data-login-btn>
                            <span class="rj-glass-login-ico">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 3h3a3 3 0 013 3v12a3 3 0 01-3 3h-3"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/></svg>
                            </span>
                            <span class="rj-glass-login-label">{{ $loginLabel }}</span>
                        </button>
                    </div>
                    <div data-logged-in @if(!$initialUser) style="display:none;" @endif>
                        <a href="{{ $initialUser['account'] ?? '#' }}" class="rj-glass-account" data-user-link title="{{ $initialUser['name'] ?? '' }}">
                            <span class="rj-glass-account-ico">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                                <i class="rj-glass-online"></i>
                            </span>
                            <span class="rj-glass-account-text">
                                <small>{{ __('Account') }}</small>
                                <b data-user-name>{{ $initialUser['first'] ?? '' }}</b>
                            </span>
                        </a>
                    </div>

                    <div class="rj-glass-modal" data-login-modal>
                        <div class="rj-glass-modal-back" data-modal-close></div>
                        <div class="rj-glass-modal-box">
                            <button type="button" class="rj-glass-modal-close" data-modal-close>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            <h3 class="rj-glass-modal-title">{{ __('Welcome back') }}</h3>
                            <div class="rj-glass-modal-err" data-login-error style="display:none;"></div>
                            <form data-login-form>
                                <div class="rj-glass-field">
                                    <input type="email" name="email" class="rj-glass-input" placeholder="{{ __('Email') }}" required data-login-email>
                                </div>
                                <div class="rj-glass-field">
                                    <input type="password" name="password" class="rj-glass-input" placeholder="{{ __('Password') }}" required data-login-password>
                                </div>
                                <button type="submit" class="rj-glass-submit" data-login-submit>
                                    <span data-login-btn-text>{{ __('Sign In') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if($ctaText)
                <a href="{{ $ctaUrl }}" class="rj-glass-cta">
                    <span>{{ $ctaText }}</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
                </a>
            @endif

            <button class="rj-glass-mobile-toggle" onclick="document.getElementById('rj-header').classList.toggle('rj-mobile-open')">
                <svg class="rj-icon-menu" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg class="rj-icon-close" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

    </div>
</header>

<style>
    .rj-glass-header {
        --rjg-text: rgba(255, 255, 255, 0.78);
        --rjg-text-hover: #fff;
        --rjg-hover-bg: rgba(255, 255, 255, 0.09);
        --rjg-line: rgba(255, 255, 255, 0.14);
        --rjg-panel: rgba(12, 14, 22, 0.96);
        position: sticky; top: 0; left: 0; width: 100%; z-index: 1000;
        background: linear-gradient(180deg, rgba(5, 7, 12, 0.55) 0%, rgba(5, 7, 12, 0) 100%);
        border-bottom: 1px solid transparent;
        transition: background 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease, backdrop-filter 0.35s ease;
    }
    .rj-glass-header.is-stuck {
        background: rgba(7, 9, 15, 0.82);
        backdrop-filter: blur(20px) saturate(140%); -webkit-backdrop-filter: blur(20px) saturate(140%);
        border-bottom-color: rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 30px -12px rgba(0, 0, 0, 0.7);
    }
    .rj-glass-header-inner {
        max-width: var(--rj-container); margin: 0 auto; padding: 16px 24px;
        display: flex; align-items: center; justify-content: space-between; gap: 24px;
        transition: padding 0.3s ease;
    }
    .rj-glass-header.is-stuck .rj-glass-header-inner { padding-top: 12px; padding-bottom: 12px; }

    .rj-glass-logo { display: flex; align-items: center; gap: 10px; font-size: 22px; font-weight: 800; color: #fff; text-decoration: none; letter-spacing: -0.02em; }
    .rj-glass-logo img { max-height: 36px; width: auto; transition: max-height 0.3s ease; }
    .rj-glass-header.is-stuck .rj-glass-logo img { max-height: 32px; }

    .rj-glass-nav { display: flex; align-items: center; gap: 4px; }
    .rj-glass-nav-item { position: relative; }
    .rj-glass-nav-link {
        display: inline-flex; align-items: center; gap: 6px; padding: 10px 16px; border-radius: 10px;
        font-size: 14px; font-weight: 500; color: var(--rjg-text); text-decoration: none;
        background: transparent; transition: color 0.2s, background 0.2s;
    }
    .rj-glass-nav-link:hover, .rj-glass-nav-item:hover > .rj-glass-nav-link { color: var(--rjg-text-hover); background: var(--rjg-hover-bg); }
    .rj-glass-chevron { width: 14px; height: 14px; opacity: 0.6; transition: transform 0.2s; }
    .rj-glass-nav-item:hover .rj-glass-chevron { transform: rotate(180deg); }

    .rj-glass-dropdown {
        position: absolute; top: 100%; left: 0; min-width: 190px; padding: 8px; margin-top: 8px;
        background: var(--rjg-panel); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--rjg-line); border-radius: 14px;
        box-shadow: 0 18px 50px -10px rgba(0, 0, 0, 0.7);
        opacity: 0; visibility: hidden; transform: translateY(8px);
        transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.2, 0.9, 0.3, 1), visibility 0.2s; z-index: 10;
    }
    .rj-glass-dropdown::before { content: ""; position: absolute; left: 0; right: 0; top: -10px; height: 10px; }
    .rj-glass-nav-item:hover .rj-glass-dropdown, .rj-glass-dropdown.is-open { opacity: 1; visibility: visible; transform: translateY(0); }
    .rj-dropdown-right { left: auto; right: 0; }
    .rj-glass-dropdown-link { display: flex; align-items: center; gap: 10px; padding: 10px 14px; font-size: 14px; color: var(--rjg-text); text-decoration: none; border-radius: 8px; transition: color 0.15s, background 0.15s; }
    .rj-glass-dropdown-link:hover, .rj-glass-dropdown-link.active { color: #fff; background: var(--rjg-hover-bg); }
    .rj-glass-dropdown-link.active { color: var(--rj-primary); font-weight: 600; }

    .rj-glass-flag { width: 20px; height: 20px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: #1e293b; box-shadow: 0 0 0 1px rgba(255,255,255,0.12); }
    .rj-glass-flag img { width: 100%; height: 100%; object-fit: cover; }
    .rj-glass-flag.is-badge b { color: #fff; font-size: 9px; font-weight: 800; text-shadow: 0 1px 2px rgba(0,0,0,.18); }

    .rj-glass-actions { display: flex; align-items: center; gap: 12px; }
    .rj-glass-lang-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px;
        background: rgba(255, 255, 255, 0.04); border: 1px solid var(--rjg-line); border-radius: 10px;
        color: rgba(255, 255, 255, 0.88); font-size: 13px; font-weight: 600; cursor: pointer;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .rj-glass-lang-btn:hover { background: rgba(255, 255, 255, 0.1); color: #fff; border-color: rgba(255, 255, 255, 0.28); }

    .rj-glass-login-btn {
        position: relative; display: inline-flex; align-items: center; gap: 10px; padding: 5px 16px 5px 5px;
        border: 1px solid transparent; border-radius: 999px; cursor: pointer;
        background:
            linear-gradient(rgba(14, 17, 27, 0.92), rgba(14, 17, 27, 0.92)) padding-box,
            linear-gradient(135deg, color-mix(in srgb, var(--rj-primary) 85%, #fff), var(--rj-secondary)) border-box;
        color: #fff; font-size: 13px; font-weight: 600; font-family: inherit;
        box-shadow: 0 6px 20px -10px color-mix(in srgb, var(--rj-primary) 80%, transparent);
        transition: transform 0.2s, box-shadow 0.25s, filter 0.2s;
    }
    .rj-glass-login-btn:hover { transform: translateY(-1px); filter: brightness(1.12); box-shadow: 0 10px 28px -8px color-mix(in srgb, var(--rj-primary) 90%, transparent); }
    .rj-glass-login-ico {
        width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff;
        transition: transform 0.25s ease;
    }
    .rj-glass-login-ico svg { width: 15px; height: 15px; }
    .rj-glass-login-btn:hover .rj-glass-login-ico { transform: translateX(2px) scale(1.06); }

    .rj-glass-account {
        display: inline-flex; align-items: center; gap: 10px; padding: 5px 16px 5px 5px; text-decoration: none;
        border: 1px solid var(--rjg-line); border-radius: 999px; background: rgba(255, 255, 255, 0.05);
        transition: transform 0.2s, background 0.2s, border-color 0.2s, box-shadow 0.25s;
    }
    .rj-glass-account:hover { transform: translateY(-1px); background: rgba(255, 255, 255, 0.1); border-color: color-mix(in srgb, var(--rj-primary) 60%, transparent); box-shadow: 0 10px 26px -10px color-mix(in srgb, var(--rj-primary) 70%, transparent); }
    .rj-glass-account-ico {
        position: relative; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff;
    }
    .rj-glass-account-ico svg { width: 15px; height: 15px; }
    .rj-glass-online { position: absolute; right: -1px; bottom: -1px; width: 10px; height: 10px; border-radius: 50%; background: #22c55e; border: 2px solid #0b0d14; box-shadow: 0 0 8px rgba(34, 197, 94, 0.8); }
    .rj-glass-account-text { display: flex; flex-direction: column; line-height: 1.15; }
    .rj-glass-account-text small { font-size: 10px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: rgba(255, 255, 255, 0.5); }
    .rj-glass-account-text b { font-size: 13px; font-weight: 700; color: #fff; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .rj-glass-cta {
        position: relative; overflow: hidden; display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px;
        background: linear-gradient(135deg, var(--rj-primary), color-mix(in srgb, var(--rj-primary) 70%, var(--rj-secondary)));
        color: #fff; font-size: 14px; font-weight: 600; text-decoration: none;
        border-radius: 10px; border: 1px solid color-mix(in srgb, var(--rj-primary) 60%, #fff);
        box-shadow: 0 8px 26px -8px color-mix(in srgb, var(--rj-primary) 75%, transparent), inset 0 1px 0 rgba(255, 255, 255, 0.25);
        transition: transform 0.2s, box-shadow 0.25s, filter 0.2s;
    }
    .rj-glass-cta::after {
        content: ""; position: absolute; top: 0; left: -80%; width: 50%; height: 100%;
        background: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.35), transparent);
        transform: skewX(-20deg); transition: left 0.6s ease;
    }
    .rj-glass-cta:hover { transform: translateY(-2px); filter: brightness(1.1); box-shadow: 0 14px 34px -8px color-mix(in srgb, var(--rj-primary) 85%, transparent), inset 0 1px 0 rgba(255, 255, 255, 0.3); }
    .rj-glass-cta:hover::after { left: 130%; }
    .rj-glass-cta svg { width: 16px; height: 16px; transition: transform 0.2s; }
    .rj-glass-cta:hover svg { transform: translateX(3px); }

    .rj-glass-mobile-toggle { display: none; background: transparent; border: none; color: #fff; cursor: pointer; padding: 8px; }
    .rj-glass-mobile-toggle svg { width: 24px; height: 24px; }
    .rj-icon-close { display: none; }

    .rj-glass-modal { position: fixed; inset: 0; z-index: 9999; display: none; align-items: center; justify-content: center; padding: 20px; }
    .rj-glass-modal.is-open { display: flex; }
    .rj-glass-modal-back { position: absolute; inset: 0; background: rgba(2,6,23,.72); backdrop-filter: blur(6px); }
    .rj-glass-modal-box { position: relative; background: var(--rj-surface); border: 1px solid var(--rj-border); border-radius: 20px; padding: 32px 28px 26px; max-width: 400px; width: 100%; box-shadow: 0 40px 80px -20px rgba(0,0,0,.5); animation: rjGlassPop .35s cubic-bezier(.34,1.56,.64,1) both; }
    @keyframes rjGlassPop { from { opacity: 0; transform: scale(.92) translateY(10px); } to { opacity: 1; transform: none; } }
    .rj-glass-modal-close { position: absolute; top: 14px; right: 14px; width: 30px; height: 30px; border-radius: 8px; border: 0; background: rgba(255,255,255,0.05); color: var(--rj-muted); cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0; transition: background .2s; }
    .rj-glass-modal-close:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .rj-glass-modal-title { font-size: 22px; font-weight: 800; color: var(--rj-text); margin: 0 0 20px; text-align: center; }
    .rj-glass-modal-err { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2); color: #fca5a5; font-size: 13px; padding: 10px; border-radius: 8px; margin-bottom: 14px; }
    .rj-glass-field { margin-bottom: 14px; }
    .rj-glass-input { width: 100%; padding: 12px 14px; font-size: 14px; border-radius: 10px; border: 1px solid var(--rj-border); background: var(--rj-bg); color: var(--rj-text); outline: 0; transition: border-color .2s; font-family: inherit; box-sizing: border-box; }
    .rj-glass-input:focus { border-color: var(--rj-primary); box-shadow: 0 0 0 3px color-mix(in srgb, var(--rj-primary) 20%, transparent); }
    .rj-glass-submit { width: 100%; padding: 12px; border-radius: 10px; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; border: 0; font-size: 14px; font-weight: 700; cursor: pointer; transition: opacity .2s; font-family: inherit; }
    .rj-glass-submit:hover { opacity: .9; }

    @media (max-width: 1100px) {
        .rj-glass-account-text, .rj-glass-login-label { display: none; }
        .rj-glass-account, .rj-glass-login-btn { padding: 5px; }
    }

    @media (max-width: 968px) {
        .rj-glass-nav { display: none; }
        .rj-glass-nav-item { width: 100%; }
        .rj-glass-nav-link { width: 100%; justify-content: space-between; padding: 12px 16px; }
        .rj-glass-dropdown { position: static; opacity: 1; visibility: visible; transform: none; box-shadow: none; background: transparent; border: none; padding: 0 0 0 16px; margin-top: 0; display: none; backdrop-filter: none; -webkit-backdrop-filter: none; }
        .rj-glass-dropdown::before { display: none; }
        .rj-glass-dropdown.is-open { display: block; }
        .rj-glass-mobile-toggle { display: block; }
        .rj-glass-cta span { display: none; }
        .rj-glass-cta { padding: 11px 13px; }
        .rj-glass-header.rj-mobile-open { height: 100vh; overflow-y: auto; background: rgba(7, 9, 15, 0.98); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .rj-glass-header.rj-mobile-open .rj-glass-header-inner { flex-wrap: wrap; align-items: flex-start; }
        .rj-glass-header.rj-mobile-open .rj-glass-nav { display: flex; flex-direction: column; width: 100%; order: 3; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; }
        .rj-glass-header.rj-mobile-open .rj-glass-actions { margin-left: auto; }
        .rj-glass-header.rj-mobile-open .rj-icon-menu { display: none; }
        .rj-glass-header.rj-mobile-open .rj-icon-close { display: block; }
    }
</style>

<script>
(function () {
    var header = document.getElementById('rj-header');
    if (header) {
        var ticking = false;
        var update = function () {
            header.classList.toggle('is-stuck', (window.pageYOffset || document.documentElement.scrollTop) > 24);
            ticking = false;
        };
        window.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();
    }

    var root = document.getElementById(@js($uid) + '_lang');
    if (root) {
        var toggleBtn = root.querySelector('[data-toggle]');
        var menu = root.querySelector('[data-menu]');
        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function (e) { e.stopPropagation(); menu.classList.toggle('is-open'); toggleBtn.classList.toggle('is-open'); });
            document.addEventListener('click', function (e) { if (!root.contains(e.target)) menu.classList.remove('is-open'); });
        }
    }

    var loginRoot = document.getElementById(@js($uid) + '_login');
    if (loginRoot) {
        var modal = loginRoot.querySelector('[data-login-modal]');
        var loginBtn = loginRoot.querySelector('[data-login-btn]');
        var closeBtns = loginRoot.querySelectorAll('[data-modal-close]');
        var form = loginRoot.querySelector('[data-login-form]');
        var errorEl = loginRoot.querySelector('[data-login-error]');
        var submitBtn = loginRoot.querySelector('[data-login-submit]');
        var initialUser = @json($initialUser);

        function openModal() { if (modal) { modal.classList.add('is-open'); var email = modal.querySelector('[data-login-email]'); if(email) setTimeout(() => email.focus(), 100); } }
        function closeModal() { if (modal) modal.classList.remove('is-open'); }

        if (loginBtn) loginBtn.addEventListener('click', function (e) { e.preventDefault(); openModal(); });
        closeBtns.forEach(function (btn) { btn.addEventListener('click', closeModal); });

        if (form) {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                var email = form.querySelector('[data-login-email]').value;
                var pass = form.querySelector('[data-login-password]').value;
                if (!email || !pass) return;
                if (errorEl) errorEl.style.display = 'none';
                if (submitBtn) submitBtn.disabled = true;

                try {
                    var res = await fetch(@js(route('rj.widget.login', absolute: false)), {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': @js(csrf_token()) },
                        body: JSON.stringify({ email: email, password: pass, remember: 1 })
                    });
                    var data = await res.json();
                    if (res.ok && data.ok) {
                        if (data.user && data.user.account) window.location.href = data.user.account;
                        else window.location.reload();
                    } else {
                        if (errorEl) { errorEl.textContent = data.message || @js(__('Login failed.')); errorEl.style.display = 'block'; }
                    }
                } catch (err) {
                    if (errorEl) { errorEl.textContent = @js(__('Network error.')); errorEl.style.display = 'block'; }
                } finally {
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        }
    }
})();
</script>
