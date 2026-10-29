@php
    $loginLabel       = $settings['login_label'] ?? __('Login');
    $registerLabel    = $settings['register_label'] ?? '';
    $registerUrl      = $settings['register_url'] ?? '/register';
    $loginMode        = $settings['login_mode'] ?? 'modal';
    $showAvatar       = $settings['show_avatar'] ?? true;
    $showName         = $settings['show_name'] ?? false;
    $pulse            = $settings['pulse'] ?? true;
    $btnStyle         = $settings['btn_style'] ?? 'gradient';
    $size             = $settings['size'] ?? 'md';
    $accent           = $settings['accent'] ?? '#8b5cf6';
    $accent2          = $settings['accent2'] ?? '#ec4899';
    $radius           = $settings['radius'] ?? 'full';
    $showDivider      = $settings['show_divider'] ?? false;

    $radiusMap = ['none' => '0px', 'sm' => '6px', 'md' => '10px', 'lg' => '14px', 'full' => '9999px'];
    $radiusCss = $radiusMap[$radius] ?? '9999px';

    $sizeMap = [
        'sm' => ['pad' => '6px 14px', 'fs' => '12.5px', 'icon' => 15, 'btn' => 34, 'mbtn' => 28, 'avatar' => 34, 'mavatar' => 28],
        'md' => ['pad' => '9px 18px', 'fs' => '13.5px', 'icon' => 18, 'btn' => 42, 'mbtn' => 34, 'avatar' => 42, 'mavatar' => 34],
        'lg' => ['pad' => '12px 24px', 'fs' => '14.5px', 'icon' => 21, 'btn' => 52, 'mbtn' => 40, 'avatar' => 52, 'mavatar' => 40],
    ];
    $sz = $sizeMap[$size] ?? $sizeMap['md'];

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
@endphp

<style>
    #{{ $uid }} {
        --hlb-accent: {{ $accent }};
        --hlb-accent2: {{ $accent2 }};
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    #{{ $uid }} [data-logged-out],
    #{{ $uid }} [data-logged-in] {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    #{{ $uid }} .rj-hlb-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: {{ $sz['pad'] }};
        border-radius: {{ $radiusCss }};
        font-size: {{ $sz['fs'] }};
        font-weight: 700;
        border: 1.5px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: transform .15s ease, opacity .2s ease, background .2s ease, border-color .2s ease, box-shadow .2s ease;
        white-space: nowrap;
        font-family: inherit;
        line-height: 1;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-hlb-btn:active { transform: scale(.94); }

    #{{ $uid }} .rj-hlb-btn.login {
        position: relative;
        overflow: hidden;
        justify-content: center;
        width: {{ $sz['btn'] }}px;
        height: {{ $sz['btn'] }}px;
        padding: 0;
        gap: 0;
    }
    #{{ $uid }} .rj-hlb-btn.login svg {
        position: relative;
        z-index: 1;
        width: {{ $sz['icon'] }}px;
        height: {{ $sz['icon'] }}px;
        flex-shrink: 0;
    }

    #{{ $uid }}[data-style="gradient"] .rj-hlb-btn.login {
        background: linear-gradient(135deg, var(--hlb-accent), var(--hlb-accent2));
        color: #fff;
        box-shadow: 0 6px 16px -8px color-mix(in srgb, var(--hlb-accent) 65%, transparent);
    }
    #{{ $uid }}[data-style="solid"] .rj-hlb-btn.login {
        background: var(--hlb-accent);
        color: #fff;
    }
    #{{ $uid }}[data-style="outline"] .rj-hlb-btn.login {
        background: transparent;
        color: var(--hlb-accent);
        border-color: var(--hlb-accent);
    }
    #{{ $uid }}[data-style="ghost"] .rj-hlb-btn.login {
        background: color-mix(in srgb, var(--hlb-accent) 10%, transparent);
        color: var(--hlb-accent);
        border-color: transparent;
    }
    #{{ $uid }}[data-style="dark"] .rj-hlb-btn.login {
        background: #0f172a;
        color: #fff;
    }

    @if($pulse)
    #{{ $uid }} .rj-hlb-btn.login::after,
    #{{ $uid }} .rj-hlb-avatar::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: -70%;
        width: 45%;
        background: linear-gradient(100deg, transparent, rgba(255,255,255,.55), transparent);
        transform: skewX(-20deg);
        animation: rjHlbShine 3.4s ease-in-out infinite;
        pointer-events: none;
    }
    #{{ $uid }}[data-style="outline"] .rj-hlb-btn.login::after,
    #{{ $uid }}[data-style="ghost"] .rj-hlb-btn.login::after {
        background: linear-gradient(100deg, transparent, color-mix(in srgb, var(--hlb-accent) 28%, transparent), transparent);
    }
    #{{ $uid }} .rj-hlb-btn.login svg {
        animation: rjHlbNudge 3.4s ease-in-out infinite;
    }
    @keyframes rjHlbShine {
        0%, 55% { left: -70%; }
        100% { left: 140%; }
    }
    @keyframes rjHlbNudge {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-1.5px); }
    }
    @endif

    #{{ $uid }} .rj-hlb-btn.register {
        background: transparent;
        color: var(--hlb-accent);
        border-color: color-mix(in srgb, var(--hlb-accent) 35%, transparent);
    }

    #{{ $uid }} .rj-hlb-divider {
        width: 1px;
        height: 18px;
        background: rgba(15,23,42,.15);
        margin: 0 4px;
    }

    #{{ $uid }} .rj-hlb-user-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        transition: transform .2s ease;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-hlb-user-link:hover { transform: scale(1.05); }
    #{{ $uid }} .rj-hlb-user-link:active { transform: scale(.94); }

    #{{ $uid }} .rj-hlb-avatar {
        position: relative;
        overflow: hidden;
        width: {{ $sz['avatar'] }}px;
        height: {{ $sz['avatar'] }}px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--hlb-accent), var(--hlb-accent2));
        color: #fff;
        font-size: {{ $sz['avatar'] * 0.4 }}px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        letter-spacing: .02em;
        box-shadow: 0 4px 12px -4px color-mix(in srgb, var(--hlb-accent) 55%, transparent);
    }

    #{{ $uid }} .rj-hlb-uname {
        font-size: {{ $sz['fs'] }};
        font-weight: 700;
        color: inherit;
        white-space: nowrap;
    }

    #{{ $uid }} .rj-hlb-modal {
        position: fixed;
        inset: 0;
        z-index: 99990;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    #{{ $uid }} .rj-hlb-modal.is-open { display: flex; }
    #{{ $uid }} .rj-hlb-modal-back {
        position: absolute;
        inset: 0;
        background: rgba(2,6,23,.72);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }
    #{{ $uid }} .rj-hlb-modal-box {
        position: relative;
        background: #fff;
        border-radius: 20px;
        padding: 32px 28px 26px;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.5);
        animation: rjHlbPop .35s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes rjHlbPop {
        from { opacity: 0; transform: scale(.92) translateY(10px); }
        to   { opacity: 1; transform: none; }
    }
    #{{ $uid }} .rj-hlb-modal-close {
        position: absolute;
        top: 14px;
        right: 14px;
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
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-hlb-modal-close:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    #{{ $uid }} .rj-hlb-modal-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
        letter-spacing: -.02em;
        text-align: center;
    }
    #{{ $uid }} .rj-hlb-modal-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 22px;
        text-align: center;
    }
    #{{ $uid }} .rj-hlb-field { margin-bottom: 14px; }
    #{{ $uid }} .rj-hlb-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    #{{ $uid }} .rj-hlb-input {
        width: 100%;
        padding: 11px 14px;
        font-size: 14px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        background: #fff;
        color: #0f172a;
        outline: 0;
        transition: border-color .2s ease, box-shadow .2s ease;
        font-family: inherit;
        box-sizing: border-box;
    }
    #{{ $uid }} .rj-hlb-input:focus {
        border-color: var(--hlb-accent);
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--hlb-accent) 20%, transparent);
    }
    #{{ $uid }} .rj-hlb-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 6px 0 18px;
        font-size: 12px;
    }
    #{{ $uid }} .rj-hlb-check {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #475569;
        cursor: pointer;
    }
    #{{ $uid }} .rj-hlb-check input {
        accent-color: var(--hlb-accent);
        width: 14px;
        height: 14px;
    }
    #{{ $uid }} .rj-hlb-forgot {
        color: var(--hlb-accent);
        font-weight: 600;
        text-decoration: none;
    }
    #{{ $uid }} .rj-hlb-forgot:hover { text-decoration: underline; }
    #{{ $uid }} .rj-hlb-submit {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--hlb-accent), var(--hlb-accent2));
        color: #fff;
        border: 0;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: opacity .2s ease;
        font-family: inherit;
    }
    #{{ $uid }} .rj-hlb-submit:hover { opacity: .92; }
    #{{ $uid }} .rj-hlb-submit:disabled { opacity: .6; cursor: wait; }
    #{{ $uid }} .rj-hlb-spin {
        width: 14px;
        height: 14px;
        animation: rjHlbSpin .8s linear infinite;
    }
    @keyframes rjHlbSpin { to { transform: rotate(360deg); } }

    #{{ $uid }} .rj-hlb-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 12.5px;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
    }

    #{{ $uid }} .rj-hlb-modal-foot {
        text-align: center;
        margin-top: 16px;
        font-size: 12px;
        color: #64748b;
    }
    #{{ $uid }} .rj-hlb-modal-foot a {
        color: var(--hlb-accent);
        font-weight: 700;
        text-decoration: none;
    }
    #{{ $uid }} .rj-hlb-modal-foot a:hover { text-decoration: underline; }

    @media (max-width: 640px) {
        #{{ $uid }} { gap: 6px; }
        #{{ $uid }} .rj-hlb-btn.login {
            width: {{ $sz['mbtn'] }}px;
            height: {{ $sz['mbtn'] }}px;
        }
        #{{ $uid }} .rj-hlb-btn.login svg {
            width: {{ round($sz['icon'] * 0.85) }}px;
            height: {{ round($sz['icon'] * 0.85) }}px;
        }
        #{{ $uid }} .rj-hlb-btn.register,
        #{{ $uid }} .rj-hlb-divider,
        #{{ $uid }} .rj-hlb-uname {
            display: none;
        }
        #{{ $uid }} .rj-hlb-avatar {
            width: {{ $sz['mavatar'] }}px;
            height: {{ $sz['mavatar'] }}px;
            font-size: {{ round($sz['mavatar'] * 0.4) }}px;
        }
        #{{ $uid }} .rj-hlb-modal { padding: 14px; }
        #{{ $uid }} .rj-hlb-modal-box { padding: 24px 20px 20px; border-radius: 18px; }
        #{{ $uid }} .rj-hlb-modal-title { font-size: 20px; }
        #{{ $uid }} .rj-hlb-modal-sub { margin-bottom: 16px; }
        #{{ $uid }} .rj-hlb-input { font-size: 16px; padding: 10px 12px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}" data-style="{{ $btnStyle }}" data-mode="{{ $loginMode }}" data-initial-user='@json($initialUser)'>

    <div data-logged-out @if($initialUser) style="display:none;" @endif>
        @if($registerLabel !== '' && $registerUrl !== '')
            <a href="{{ $registerUrl }}" class="rj-hlb-btn register">
                {{ $registerLabel }}
            </a>
            @if($showDivider)
                <span class="rj-hlb-divider"></span>
            @endif
        @endif

        <button type="button" class="rj-hlb-btn login" data-login-btn aria-label="{{ $loginLabel }}" title="{{ $loginLabel }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21v-1a8 8 0 0116 0v1"/>
            </svg>
        </button>
    </div>

    <div data-logged-in @if(!$initialUser) style="display:none;" @endif>
        <a href="{{ $initialUser['account'] ?? '#' }}" class="rj-hlb-user-link" data-user-link title="{{ $initialUser['name'] ?? '' }}">
            @if($showAvatar)
                <span class="rj-hlb-avatar" data-user-avatar>{{ $initialUser['initials'] ?? '' }}</span>
            @endif
            @if($showName)
                <span class="rj-hlb-uname" data-user-name>{{ $initialUser['name'] ?? '' }}</span>
            @endif
        </a>
    </div>

    @if($loginMode === 'modal')
        <div class="rj-hlb-modal" data-login-modal>
            <div class="rj-hlb-modal-back" data-modal-close></div>
            <div class="rj-hlb-modal-box" role="dialog" aria-modal="true">
                <button type="button" class="rj-hlb-modal-close" data-modal-close aria-label="{{ __('Close') }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <h3 class="rj-hlb-modal-title">{{ __('Welcome back') }}</h3>
                <p class="rj-hlb-modal-sub">{{ __('Sign in to your account') }}</p>

                <div class="rj-hlb-error" data-login-error style="display:none;"></div>

                <form data-login-form>
                    <div class="rj-hlb-field">
                        <label class="rj-hlb-label" for="{{ $uid }}-email">{{ __('Email') }}</label>
                        <input type="email" id="{{ $uid }}-email" class="rj-hlb-input" name="email" autocomplete="username" required data-login-email>
                    </div>
                    <div class="rj-hlb-field">
                        <label class="rj-hlb-label" for="{{ $uid }}-password">{{ __('Password') }}</label>
                        <input type="password" id="{{ $uid }}-password" class="rj-hlb-input" name="password" autocomplete="current-password" required data-login-password>
                    </div>

                    <div class="rj-hlb-row">
                        <label class="rj-hlb-check">
                            <input type="checkbox" data-login-remember>
                            <span>{{ __('Remember me') }}</span>
                        </label>
                        @if(\Illuminate\Support\Facades\Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="rj-hlb-forgot">{{ __('Forgot?') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="rj-hlb-submit" data-login-submit>
                        <svg class="rj-hlb-spin" data-login-spinner style="display:none;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                        <span data-login-btn-text>{{ __('Sign In') }}</span>
                    </button>
                </form>

                @if($registerLabel !== '' && $registerUrl !== '')
                    <p class="rj-hlb-modal-foot">
                        {{ __("Don't have an account?") }}
                        <a href="{{ $registerUrl }}">{{ __('Sign up') }}</a>
                    </p>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var mode = root.getAttribute('data-mode') || 'modal';
    var initialUser = null;
    try { initialUser = JSON.parse(root.getAttribute('data-initial-user') || 'null'); } catch (e) {}

    var loggedOutEl = root.querySelector('[data-logged-out]');
    var loggedInEl  = root.querySelector('[data-logged-in]');
    var loginBtn    = root.querySelector('[data-login-btn]');
    var userLink    = root.querySelector('[data-user-link]');
    var modal       = root.querySelector('[data-login-modal]');
    var loginForm   = root.querySelector('[data-login-form]');
    var errorEl     = root.querySelector('[data-login-error]');
    var submitBtn   = root.querySelector('[data-login-submit]');
    var spinner     = root.querySelector('[data-login-spinner]');

    var userAvatar  = root.querySelector('[data-user-avatar]');
    var userName    = root.querySelector('[data-user-name]');

    function setUser(user) {
        if (user) {
            if (loggedOutEl) loggedOutEl.style.display = 'none';
            if (loggedInEl)  loggedInEl.style.display = '';

            if (userAvatar) userAvatar.textContent = user.initials || '?';
            if (userName)   userName.textContent   = user.name || '';
            if (userLink) {
                userLink.href = user.account || '/account';
                userLink.title = user.name || '';
            }
        } else {
            if (loggedOutEl) loggedOutEl.style.display = '';
            if (loggedInEl)  loggedInEl.style.display = 'none';
        }
    }

    function openLoginModal() {
        if (!modal) return;
        if (errorEl) errorEl.style.display = 'none';
        modal.classList.add('is-open');
        var firstInput = modal.querySelector('input[type="email"]');
        if (firstInput) setTimeout(function () { firstInput.focus(); }, 100);
    }
    function closeLoginModal() {
        if (!modal) return;
        modal.classList.remove('is-open');
    }

    if (loginBtn) {
        loginBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (mode === 'redirect') {
                window.location.href = @js(route('login', absolute: false));
            } else {
                openLoginModal();
            }
        });
    }

    if (modal) {
        modal.querySelectorAll('[data-modal-close]').forEach(function (el) {
            el.addEventListener('click', closeLoginModal);
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('is-open')) {
            closeLoginModal();
        }
    });

    function setLoading(on) {
        if (submitBtn) submitBtn.disabled = on;
        if (spinner) spinner.style.display = on ? 'inline-block' : 'none';
    }

    function showError(msg) {
        if (!errorEl) return;
        errorEl.textContent = msg;
        errorEl.style.display = 'block';
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            var emailEl = root.querySelector('[data-login-email]');
            var passEl  = root.querySelector('[data-login-password]');
            var remEl   = root.querySelector('[data-login-remember]');

            var email = emailEl ? emailEl.value.trim() : '';
            var pass  = passEl ? passEl.value : '';
            var rem   = remEl && remEl.checked ? 1 : 0;

            if (!email || !pass) {
                showError(@js(__('Please fill in all fields.')));
                return;
            }

            if (errorEl) errorEl.style.display = 'none';
            setLoading(true);

            try {
                var res = await fetch(@js(route('rj.widget.login', absolute: false)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': @js(csrf_token())
                    },
                    body: JSON.stringify({ email: email, password: pass, remember: rem })
                });

                var data = await res.json();

                if (res.ok && data.ok) {
                    setUser(data.user);
                    closeLoginModal();
                    if (loginForm) loginForm.reset();

                    if (data.user && data.user.account) {
                        window.location.href = data.user.account;
                    }
                } else {
                    showError(data.message || @js(__('Login failed.')));
                }
            } catch (err) {
                showError(@js(__('Network error. Please try again.')));
            } finally {
                setLoading(false);
            }
        });
    }

    if (initialUser) setUser(initialUser);
})();
</script>
