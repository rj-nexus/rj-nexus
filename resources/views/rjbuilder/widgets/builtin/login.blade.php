@php
    $title        = $settings['title'] ?? __('Welcome back');
    $subtitle     = $settings['subtitle'] ?? __('Sign in to your account to continue');
    $loggedTitle  = $settings['logged_title'] ?? __('Welcome');
    $showRemember = $settings['show_remember'] ?? true;
    $showForgot   = $settings['show_forgot'] ?? true;
    $showRegister = $settings['show_register'] ?? true;
    $showAdminBtn = $settings['show_admin_btn'] ?? true;
    $accent       = $settings['accent'] ?? '#8b5cf6';
    $radius       = $settings['radius'] ?? 'xl';
    $shadow       = $settings['shadow'] ?? true;

    $radiusMap = ['none' => '0px', 'md' => '10px', 'xl' => '16px', '2xl' => '22px'];
    $radiusPx  = $radiusMap[$radius] ?? '16px';

    $authUser = auth()->user();
    $initialUser = null;
    if ($authUser) {
        $parts = preg_split('/\s+/u', trim((string) $authUser->name)) ?: [''];
        $initials = count($parts) > 1
            ? mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[count($parts) - 1], 0, 1))
            : mb_strtoupper(mb_substr($parts[0], 0, 1));

        $initialUser = [
            'name'     => $authUser->name,
            'email'    => $authUser->email,
            'initials' => $initials,
            'admin'    => method_exists($authUser, 'isAdmin') ? $authUser->isAdmin() : false,
            'account'  => route('frontend.account.index', absolute: false),
            'adminUrl' => method_exists($authUser, 'isAdmin') && $authUser->isAdmin() ? route('admin.dashboard', absolute: false) : null,
        ];
    }
@endphp

@once
<style>
    @keyframes rjLgFade { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
</style>
@endonce

<style>
    #{{ $uid }} {
        --rj-accent: {{ $accent }};
        position: relative;
        width: 100%;
        padding: 40px 16px;
    }
    #{{ $uid }} .rj-lg-card {
        max-width: 420px;
        margin: 0 auto;
        background: #fff;
        border-radius: {{ $radiusPx }};
        padding: 32px 28px;
        border: 1px solid #e5e7eb;
        @if($shadow) box-shadow: 0 24px 48px -24px rgba(15,23,42,.25); @endif
    }
    #{{ $uid }} .rj-lg-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
        letter-spacing: -.01em;
    }
    #{{ $uid }} .rj-lg-sub {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 22px;
    }
    #{{ $uid }} .rj-lg-field { margin-bottom: 14px; }
    #{{ $uid }} .rj-lg-lbl {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    #{{ $uid }} .rj-lg-in {
        width: 100%;
        padding: 11px 14px;
        font-size: 14px;
        color: #0f172a;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        outline: 0;
        transition: border-color .2s ease, box-shadow .2s ease;
        box-sizing: border-box;
    }
    #{{ $uid }} .rj-lg-in:focus {
        border-color: var(--rj-accent);
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--rj-accent) 25%, transparent);
    }
    #{{ $uid }} .rj-lg-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin: 4px 0 16px;
        font-size: 12px;
    }
    #{{ $uid }} .rj-lg-check {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #475569;
        cursor: pointer;
    }
    #{{ $uid }} .rj-lg-check input {
        accent-color: var(--rj-accent);
        width: 14px;
        height: 14px;
    }
    #{{ $uid }} .rj-lg-link {
        color: var(--rj-accent);
        font-weight: 600;
        text-decoration: none;
    }
    #{{ $uid }} .rj-lg-link:hover { text-decoration: underline; }

    #{{ $uid }} .rj-lg-submit {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        background: var(--rj-accent);
        border: 0;
        border-radius: 10px;
        cursor: pointer;
        transition: opacity .2s ease, transform .15s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    #{{ $uid }} .rj-lg-submit:hover { opacity: .92; }
    #{{ $uid }} .rj-lg-submit:active { transform: scale(.98); }
    #{{ $uid }} .rj-lg-submit:disabled { opacity: .6; cursor: wait; }
    #{{ $uid }} .rj-lg-spin {
        width: 14px; height: 14px;
        animation: rjLgSpin .8s linear infinite;
    }
    @keyframes rjLgSpin { to { transform: rotate(360deg); } }

    #{{ $uid }} .rj-lg-err {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 12.5px;
        padding: 10px 12px;
        border-radius: 10px;
        margin-bottom: 14px;
        animation: rjLgFade .25s ease;
    }

    #{{ $uid }} .rj-lg-foot {
        text-align: center;
        margin-top: 18px;
        font-size: 12.5px;
        color: #64748b;
    }

    #{{ $uid }} .rj-lg-user {
        text-align: center;
        animation: rjLgFade .3s ease;
    }
    #{{ $uid }} .rj-lg-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--rj-accent);
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 10px 24px -8px color-mix(in srgb, var(--rj-accent) 60%, transparent);
    }
    #{{ $uid }} .rj-lg-uname {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px;
    }
    #{{ $uid }} .rj-lg-email {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 20px;
        word-break: break-all;
    }
    #{{ $uid }} .rj-lg-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    #{{ $uid }} .rj-lg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #334155;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
    }
    #{{ $uid }} .rj-lg-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    #{{ $uid }} .rj-lg-btn.primary {
        background: var(--rj-accent);
        border-color: var(--rj-accent);
        color: #fff;
    }
    #{{ $uid }} .rj-lg-btn.primary:hover { opacity: .92; background: var(--rj-accent); }
    #{{ $uid }} .rj-lg-btn.ghost {
        background: transparent;
        border: 0;
        color: #94a3b8;
    }
    #{{ $uid }} .rj-lg-btn.ghost:hover { color: #dc2626; background: #fef2f2; }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}" x-data="rjLogin_{{$uid}}()">
    <div class="rj-lg-card">

        <!-- x-show istifadə edirik ki, state dəyişəndə dərhal reaksiya versin -->
        <div x-show="!user" x-transition.opacity>
            <form @submit.prevent="submit" novalidate>
                <h2 class="rj-lg-title" x-text="title"></h2>
                <p class="rj-lg-sub" x-text="subtitle"></p>

                <div x-show="error" x-cloak class="rj-lg-err" x-text="error"></div>

                <div class="rj-lg-field">
                    <label class="rj-lg-lbl" for="{{ $uid }}-email">{{ __('Email address') }}</label>
                    <input id="{{ $uid }}-email" type="email" class="rj-lg-in"
                           x-model="email" autocomplete="username" required>
                </div>

                <div class="rj-lg-field">
                    <label class="rj-lg-lbl" for="{{ $uid }}-password">{{ __('Password') }}</label>
                    <input id="{{ $uid }}-password" type="password" class="rj-lg-in"
                           x-model="password" autocomplete="current-password" required>
                </div>

                <div class="rj-lg-row">
                    @if($showRemember)
                        <label class="rj-lg-check">
                            <input type="checkbox" x-model="remember">
                            <span>{{ __('Remember me') }}</span>
                        </label>
                    @endif
                    @if($showForgot && \Illuminate\Support\Facades\Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="rj-lg-link">{{ __('Forgot password?') }}</a>
                    @endif
                </div>

                <button type="submit" class="rj-lg-submit" :disabled="loading">
                    <svg x-show="loading" class="rj-lg-spin" style="display: none;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                    <span x-text="loading ? texts.signingIn : texts.signIn"></span>
                </button>

                @if($showRegister && \Illuminate\Support\Facades\Route::has('register'))
                    <p class="rj-lg-foot">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}" class="rj-lg-link">{{ __('Create one now') }}</a>
                    </p>
                @endif
            </form>
        </div>

        <div x-show="user" style="display: none;" x-transition.opacity>
            <div class="rj-lg-user">
                <h2 class="rj-lg-title" x-text="loggedTitle"></h2>
                <div class="rj-lg-avatar" x-text="user ? user.initials : ''"></div>
                <p class="rj-lg-uname" x-text="user ? user.name : ''"></p>
                <p class="rj-lg-email" x-text="user ? user.email : ''"></p>

                <div class="rj-lg-actions">
                    @if($showAdminBtn)
                        <div x-show="user && user.admin && user.adminUrl">
                            <a :href="user ? user.adminUrl : '#'" class="rj-lg-btn primary">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                                <span>{{ __('Go to Admin') }}</span>
                            </a>
                        </div>
                    @endif

                    <a :href="user ? user.account : '#'" class="rj-lg-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-1a8 8 0 0116 0v1"/></svg>
                        <span>{{ __('My Account') }}</span>
                    </a>

                    <button type="button" class="rj-lg-btn ghost" @click="logout" :disabled="loading">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>{{ __('Sign out') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window['rjLogin_{{$uid}}'] = function() {
    return {
        user: @js($initialUser),
        title: @js($title),
        subtitle: @js($subtitle),
        loggedTitle: @js($loggedTitle),
        email: '',
        password: '',
        remember: false,
        loading: false,
        error: '',
        texts: {
            signingIn: @js(__('Signing in...')),
            signIn: @js(__('Sign In')),
            fillFields: @js(__('Please fill in all fields.')),
            loginFailed: @js(__('Login failed.'))
        },

        async submit() {
            this.error = '';
            if (!this.email || !this.password) {
                this.error = this.texts.fillFields;
                return;
            }
            this.loading = true;

            try {
                const res = await fetch(@js(route('rj.widget.login', absolute: false)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': @js(csrf_token())
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password,
                        remember: this.remember ? 1 : 0
                    })
                });

                let data;
                try {
                    data = await res.json();
                } catch (e) {
                    throw new Error('Server xətası (JSON gözlənilirdi, HTML gəldi). Status: ' + res.status);
                }

                if (res.ok && data.ok) {
                    this.user = data.user;
                    this.password = '';
                } else {
                    this.error = data.message || this.texts.loginFailed;
                }
            } catch (err) {
                // Hər hansı xəta olsa (419, 500, Network) ekranda göstər
                console.error(err);
                this.error = 'Xəta: ' + err.message;
            } finally {
                // Nə olursa olsun, düyməni mütləq dayandır!
                this.loading = false;
            }
        },

        async logout() {
            this.loading = true;
            try {
                await fetch(@js(route('rj.widget.logout', absolute: false)), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': @js(csrf_token())
                    }
                });
                this.user = null;
                this.email = '';
                this.password = '';
                this.remember = false;
                this.error = '';
            } catch (err) {
                console.error(err);
            } finally {
                this.loading = false;
            }
        }
    };
};
</script>
