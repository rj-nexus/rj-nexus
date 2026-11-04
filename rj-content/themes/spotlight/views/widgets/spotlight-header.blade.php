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
    $logoImage = $settings['logo_image'] ?? '';
    $logoText = $settings['logo_text'] ?? 'RJ CMS';

    $ctaText = $settings['cta_text'] ?? '';
    $ctaUrl = $settings['cta_url'] ?? '#';

    $showLang = $settings['show_language'] ?? true;
    $showLogin = $settings['show_login'] ?? true;
    $loginLabel = $settings['login_label'] ?? __('Login');

    $accent = 'var(--rj-primary)';
    $accent2 = 'var(--rj-secondary)';

    $authUser = auth()->user();
    $initialUser = null;
    if ($authUser) {
        $name = trim((string) $authUser->name);
        $parts = preg_split('/\s+/u', $name) ?: [];
        $initials = count($parts) > 1
            ? mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[count($parts) - 1], 0, 1))
            : mb_strtoupper(mb_substr($parts[0] ?? '?', 0, 1));

        $initialUser = [
            'name'     => $authUser->name,
            'initials' => $initials,
            'account'  => route('frontend.account.index', absolute: false),
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
            @if($logoImage)
                <img src="{{ $logoImage }}" alt="{{ $logoText }}">
            @else
                <svg class="rj-glass-logo-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>{{ $logoText }}</span>
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
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg>
                            <span>{{ $loginLabel }}</span>
                        </button>
                    </div>
                    <div data-logged-in @if(!$initialUser) style="display:none;" @endif>
                        <a href="{{ $initialUser['account'] ?? '#' }}" class="rj-glass-user-link" data-user-link title="{{ $initialUser['name'] ?? '' }}">
                            <span class="rj-glass-avatar" data-user-avatar>{{ $initialUser['initials'] ?? '' }}</span>
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
                <a href="{{ $ctaUrl }}" class="rj-glass-cta">{{ $ctaText }}</a>
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
        position: sticky; top: 0; left: 0; width: 100%; z-index: 1000;
        background: rgba(10, 10, 15, 0.6);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }
    .rj-glass-header-inner {
        max-width: var(--rj-container); margin: 0 auto; padding: 16px 24px;
        display: flex; align-items: center; justify-content: space-between; gap: 24px;
    }
    .rj-glass-logo { display: flex; align-items: center; gap: 10px; font-size: 22px; font-weight: 800; color: #fff; text-decoration: none; letter-spacing: -0.02em; }
    .rj-glass-logo-icon { width: 32px; height: 32px; color: var(--rj-primary); }
    .rj-glass-logo img { max-height: 36px; width: auto; }
    .rj-glass-nav { display: flex; align-items: center; gap: 4px; }
    .rj-glass-nav-item { position: relative; }
    .rj-glass-nav-link { display: inline-flex; align-items: center; gap: 6px; padding: 10px 16px; border-radius: 8px; font-size: 14px; font-weight: 500; color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: all 0.2s; }
    .rj-glass-nav-link:hover { color: #fff; background: rgba(255, 255, 255, 0.08); }
    .rj-glass-chevron { width: 14px; height: 14px; opacity: 0.5; transition: transform 0.2s; }
    .rj-glass-nav-item:hover .rj-glass-chevron { transform: rotate(180deg); }

    .rj-glass-dropdown {
        position: absolute; top: 100%; left: 0; min-width: 180px; padding: 8px;
        background: rgba(20, 20, 28, 0.95); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        opacity: 0; visibility: hidden; transform: translateY(10px);
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.3, 1); z-index: 10;
    }
    .rj-glass-nav-item:hover .rj-glass-dropdown, .rj-glass-dropdown.is-open { opacity: 1; visibility: visible; transform: translateY(0); }
    .rj-dropdown-right { left: auto; right: 0; }
    .rj-glass-dropdown-link { display: flex; align-items: center; gap: 10px; padding: 10px 14px; font-size: 14px; color: rgba(255, 255, 255, 0.7); text-decoration: none; border-radius: 6px; transition: all 0.15s; }
    .rj-glass-dropdown-link:hover, .rj-glass-dropdown-link.active { color: #fff; background: rgba(255, 255, 255, 0.1); }
    .rj-glass-dropdown-link.active { color: var(--rj-primary); font-weight: 600; }

    .rj-glass-flag { width: 20px; height: 20px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: #1e293b; box-shadow: 0 0 0 1px rgba(255,255,255,0.1); }
    .rj-glass-flag img { width: 100%; height: 100%; object-fit: cover; }
    .rj-glass-flag.is-badge b { color: #fff; font-size: 9px; font-weight: 800; text-shadow: 0 1px 2px rgba(0,0,0,.18); }

    .rj-glass-actions { display: flex; align-items: center; gap: 12px; }
    .rj-glass-lang-btn, .rj-glass-login-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px;
        background: transparent; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px;
        color: rgba(255, 255, 255, 0.8); font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .rj-glass-lang-btn:hover, .rj-glass-login-btn:hover { background: rgba(255, 255, 255, 0.08); color: #fff; }
    .rj-glass-login-btn svg { width: 16px; height: 16px; }

    .rj-glass-user-link { display: inline-flex; text-decoration: none; }
    .rj-glass-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #fff; font-size: 15px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px -4px color-mix(in srgb, var(--rj-primary) 55%, transparent); transition: transform .2s; }
    .rj-glass-user-link:hover .rj-glass-avatar { transform: scale(1.05); }

    .rj-glass-cta { display: inline-flex; align-items: center; padding: 10px 22px; background: #fff; color: #000; font-size: 14px; font-weight: 600; text-decoration: none; border-radius: 8px; transition: all 0.2s; }
    .rj-glass-cta:hover { background: var(--rj-primary); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 20px color-mix(in srgb, var(--rj-primary) 40%, transparent); }

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
    .rj-glass-submit { width: 100%; padding: 12px; border-radius: 10px; background: linear-gradient(135deg, var(--rj-primary), var(--rj-secondary)); color: #0a0a0f; border: 0; font-size: 14px; font-weight: 700; cursor: pointer; transition: opacity .2s; font-family: inherit; }
    .rj-glass-submit:hover { opacity: .9; }

    @media (max-width: 968px) {
        .rj-glass-nav { display: none; }
        .rj-glass-nav-item { width: 100%; }
        .rj-glass-nav-link { width: 100%; justify-content: space-between; padding: 12px 16px; }
        .rj-glass-dropdown { position: static; opacity: 1; visibility: visible; transform: none; box-shadow: none; background: transparent; border: none; padding: 0 0 0 16px; display: none; }
        .rj-glass-dropdown.is-open { display: block; }
        .rj-glass-mobile-toggle { display: block; }
        .rj-glass-header.rj-mobile-open { height: 100vh; overflow-y: auto; background: rgba(10, 10, 15, 0.98); }
        .rj-glass-header.rj-mobile-open .rj-glass-header-inner { flex-wrap: wrap; align-items: flex-start; }
        .rj-glass-header.rj-mobile-open .rj-glass-nav { display: flex; flex-direction: column; width: 100%; order: 3; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; }
        .rj-glass-header.rj-mobile-open .rj-glass-actions { margin-left: auto; }
        .rj-glass-header.rj-mobile-open .rj-icon-menu { display: none; }
        .rj-glass-header.rj-mobile-open .rj-icon-close { display: block; }
    }
</style>

<script>
(function () {
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
