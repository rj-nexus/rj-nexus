@php
    $bool    = fn ($k, $d = true) => filter_var($settings[$k] ?? $d, FILTER_VALIDATE_BOOLEAN);
    $routeOr = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name, absolute: false) : null;

    $accent   = preg_match('/^#[0-9a-f]{3,8}$/i', (string) ($settings['accent'] ?? '')) ? $settings['accent'] : '#8b5cf6';
    $radiusPx = ['none' => '0px', 'md' => '12px', 'xl' => '20px', '2xl' => '28px'][$settings['radius'] ?? 'xl'] ?? '20px';
    $side     = ($settings['stage_side'] ?? 'right') === 'left' ? 'left' : 'right';
    $title    = $settings['title'] ?? __('Welcome back');
    $subtitle = $settings['subtitle'] ?? __('Sign in to your account to continue');
    $loggedTitle  = $settings['logged_title'] ?? __('Welcome');
    $showRemember = $bool('show_remember');
    $showAdminBtn = $bool('show_admin_btn');
    $showBubble   = $bool('show_bubble');
    $forgotUrl    = $bool('show_forgot') ? $routeOr('password.request') : null;
    $registerUrl  = $bool('show_register') ? $routeOr('register') : null;

    $authUser    = auth()->user();
    $initialUser = null;
    if ($authUser) {
        $parts   = preg_split('/\s+/u', trim((string) $authUser->name), -1, PREG_SPLIT_NO_EMPTY) ?: ['?'];
        $isAdmin = method_exists($authUser, 'isAdmin') && $authUser->isAdmin();
        $initialUser = [
            'name'     => (string) $authUser->name,
            'email'    => (string) $authUser->email,
            'initials' => mb_strtoupper(mb_substr($parts[0], 0, 1) . (count($parts) > 1 ? mb_substr($parts[count($parts) - 1], 0, 1) : '')),
            'admin'    => $isAdmin,
            'account'  => $routeOr('frontend.account.index'),
            'adminUrl' => $isAdmin ? $routeOr('admin.dashboard') : null,
        ];
    }

    $texts = [
        'idle'      => __('Hi there!'),
        'email'     => __('I see you!'),
        'password'  => __('I won’t peek!'),
        'peek'      => __('Okay, just a tiny peek...'),
        'wait'      => __('Checking...'),
        'error'     => __('Oops, try again'),
        'success'   => __('Welcome back, :name!'),
        'fill'      => __('Please fill in all fields.'),
        'failed'    => __('Login failed.'),
        'expired'   => __('Session expired. Please reload the page.'),
        'network'   => __('Network error. Please try again.'),
        'signIn'    => __('Sign In'),
        'signingIn' => __('Signing in...'),
    ];

    $urls = [
        'login'  => route('rj.widget.login', absolute: false),
        'logout' => route('rj.widget.logout', absolute: false),
        'csrf'   => csrf_token(),
    ];
@endphp

<style>
    #{{ $uid }} {
        --accent: {{ $accent }};
        --r: {{ $radiusPx }};
        --ink: #0f172a;
        --muted: #64748b;
        --line: #e2e8f0;
        padding: 40px 16px;

        [hidden] { display: none !important; }
        &[data-side="left"] .lg-stage { order: -1; }

        .lg-card { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); max-width: 1040px; margin: 0 auto; overflow: hidden; border: 1px solid var(--line); border-radius: var(--r); background: #fff; color: var(--ink); box-shadow: {{ ($bool('shadow')) ? '0 40px 80px -36px rgba(15, 23, 42, .35)' : 'none' }}; }

        .lg-main { display: flex; flex-direction: column; justify-content: center; padding: clamp(28px, 5vw, 56px); }
        .lg-title { margin: 0 0 8px; font-size: clamp(26px, 3vw, 34px); font-weight: 800; letter-spacing: -.02em; line-height: 1.15; }
        .lg-sub { margin: 0 0 26px; font-size: 14px; line-height: 1.6; color: var(--muted); }

        .lg-err { margin-bottom: 16px; padding: 11px 14px; border: 1px solid #fecaca; border-radius: 12px; background: #fef2f2; color: #b91c1c; font-size: 13px; animation: rj-lg-fade .3s ease; }

        .lg-f { margin-bottom: 16px;
            label { display: block; margin-bottom: 7px; font-size: 12.5px; font-weight: 600; color: #334155; }
        }
        .lg-w { position: relative;
            & > svg { position: absolute; top: 50%; left: 14px; width: 18px; height: 18px; translate: 0 -50%; color: #94a3b8; pointer-events: none; transition: color .2s; }
            input { box-sizing: border-box; width: 100%; padding: 13px 14px 13px 44px; border: 1.5px solid var(--line); border-radius: 12px; background: #f8fafc; color: var(--ink); font: inherit; font-size: 14.5px; outline: 0; transition: .2s;
                &:focus { border-color: var(--accent); background: #fff; box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent) 16%, transparent); }
            }
            &:focus-within > svg { color: var(--accent); }
            &.has-eye input { padding-right: 48px; }
        }
        .lg-eye { position: absolute; top: 50%; right: 8px; display: grid; place-items: center; width: 34px; height: 34px; padding: 0; translate: 0 -50%; border: 0; border-radius: 10px; background: transparent; color: #94a3b8; cursor: pointer; transition: .2s;
            &:hover { background: color-mix(in srgb, var(--accent) 10%, transparent); color: var(--accent); }
            svg { width: 18px; height: 18px; }
            .off { display: none; }
            &.is-on .on { display: none; }
            &.is-on .off { display: block; }
        }

        .lg-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin: 2px 0 20px; font-size: 13px; }
        .lg-check { display: inline-flex; align-items: center; gap: 8px; color: #475569; cursor: pointer;
            input { width: 15px; height: 15px; accent-color: var(--accent); }
        }
        .lg-link { color: var(--accent); font-weight: 600; text-decoration: none;
            &:hover { text-decoration: underline; }
        }

        .lg-submit { position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; border: 0; border-radius: 12px; background: linear-gradient(135deg, var(--accent), color-mix(in srgb, var(--accent) 70%, #0f172a)); color: #fff; font: inherit; font-size: 14.5px; font-weight: 700; cursor: pointer; box-shadow: 0 16px 28px -14px var(--accent); transition: transform .15s, filter .2s;
            &:hover { filter: brightness(1.07); }
            &:active { transform: scale(.985); }
            &:disabled { cursor: wait; }
            &::after { content: ""; position: absolute; top: 0; bottom: 0; left: -60%; width: 40%; background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .4), transparent); transform: skewX(-20deg); animation: rj-lg-shine 3.6s ease-in-out infinite; }
            svg { width: 16px; height: 16px; transition: translate .2s; }
            &:hover svg { translate: 3px 0; }
            &.is-loading svg { display: none; }
            &.is-loading::before { content: ""; width: 16px; height: 16px; border: 2px solid rgba(255, 255, 255, .4); border-top-color: #fff; border-radius: 50%; animation: rj-lg-spin .7s linear infinite; }
        }
        .lg-foot { margin: 20px 0 0; text-align: center; font-size: 13px; color: var(--muted); }

        .lg-out { text-align: center; animation: rj-lg-fade .4s ease;
            h2 { margin: 0 0 22px; font-size: 13px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: var(--accent); }
            h3 { margin: 0 0 4px; font-size: 24px; font-weight: 800; letter-spacing: -.02em; }
            p { margin: 0; font-size: 14px; color: var(--muted); word-break: break-all; }
        }
        .lg-av { position: relative; display: grid; place-items: center; width: 92px; height: 92px; margin: 0 auto 20px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), color-mix(in srgb, var(--accent) 60%, #0f172a)); color: #fff; font-size: 30px; font-weight: 800; box-shadow: 0 18px 34px -14px var(--accent);
            &::before { content: ""; position: absolute; inset: -8px; border: 2px dashed color-mix(in srgb, var(--accent) 55%, transparent); border-radius: 50%; animation: rj-lg-spin 14s linear infinite; }
        }
        .lg-act { display: grid; gap: 10px; margin-top: 26px; }
        .lg-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 16px; border: 1.5px solid var(--line); border-radius: 12px; background: #fff; color: #334155; font: inherit; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; transition: .2s;
            svg { width: 16px; height: 16px; }
            &:hover { border-color: var(--accent); color: var(--accent); }
            &.is-primary { border-color: var(--accent); background: var(--accent); color: #fff;
                &:hover { filter: brightness(1.08); color: #fff; }
            }
            &.is-ghost { border-color: transparent; color: #94a3b8;
                &:hover { background: #fef2f2; color: #dc2626; }
            }
        }

        .lg-stage { position: relative; container-type: inline-size; overflow: hidden; aspect-ratio: 1 / 1.02; background: radial-gradient(circle at 18% 12%, rgba(255, 255, 255, .75), transparent 42%), linear-gradient(160deg, color-mix(in srgb, var(--accent) 12%, #fff), color-mix(in srgb, var(--accent) 34%, #fff)); }
        .lg-orb { position: absolute; border-radius: 50%; background: color-mix(in srgb, var(--accent) 20%, transparent); animation: rj-lg-drift 12s ease-in-out infinite alternate;
            &:nth-child(1) { top: -8cqw; right: -10cqw; width: 44cqw; height: 44cqw; }
            &:nth-child(2) { bottom: 22cqw; left: -12cqw; width: 30cqw; height: 30cqw; animation-delay: -5s; }
        }

        .lg-bubble { position: absolute; top: clamp(16px, 6cqw, 40px); left: 50%; z-index: 6; max-width: 86%; padding: 10px 18px; translate: -50% 0; border-radius: 999px; background: #fff; color: var(--ink); font-size: 13.5px; font-weight: 700; white-space: nowrap; box-shadow: 0 14px 28px -14px rgba(15, 23, 42, .4);
            &.is-pop { animation: rj-lg-pop .4s cubic-bezier(.34, 1.56, .64, 1); }
            &::after { content: ""; position: absolute; bottom: -5px; left: 50%; width: 12px; height: 12px; translate: -50% 0; rotate: 45deg; border-radius: 2px; background: #fff; }
        }

        .lg-spark i { position: absolute; bottom: 30cqw; left: var(--x); z-index: 5; width: 4cqw; height: 4cqw; background: #fbbf24; clip-path: polygon(50% 0, 61% 39%, 100% 50%, 61% 61%, 50% 100%, 39% 61%, 0 50%, 39% 39%); opacity: 0; }
        &[data-state="success"] .lg-spark i { animation: rj-lg-rise 2.4s ease-out infinite var(--d); }

        .lg-cast { position: absolute; inset: auto 0 0; height: 66cqw; transform-origin: 50% 100%; }

        .c { position: absolute; bottom: 0; transform-origin: 50% 100%; transform: skewX(calc(var(--lx, 0) * -1.8deg)); transition: transform .35s ease-out; animation: rj-lg-breathe 4s ease-in-out infinite var(--d);
            .eyes { position: absolute; top: var(--et); left: 50%; display: flex; gap: var(--eg); translate: -50% 0; }
            .eye { display: block; transition: transform .25s; animation: rj-lg-blink 5.5s infinite var(--d); }
            .eye.w { display: grid; place-items: center; width: var(--es, 6cqw); height: var(--es, 6cqw); border-radius: 50%; background: #fff;
                i { width: 46%; height: 46%; border-radius: 50%; background: #0f172a; translate: calc(var(--lx, 0) * 1.1cqw) calc(var(--ly, 0) * 1.1cqw); transition: translate .12s; }
            }
            .eye.d { width: 2.6cqw; height: 3.6cqw; border-radius: 50%; background: #0f172a; translate: calc(var(--lx, 0) * 1.4cqw) calc(var(--ly, 0) * 1cqw); transition: transform .25s, translate .12s; }
            .m { position: absolute; top: var(--mt); left: 50%; width: var(--mw, 6cqw); height: calc(var(--mh, 0) * 1cqw); translate: -50% 0; border: .55cqw solid var(--mc, #0f172a); border-top: 0; border-radius: 0 0 6cqw 6cqw; transition: height .3s, rotate .3s; }
        }
        .c-p { z-index: 1; left: 17cqw; width: 31cqw; height: 62cqw; border-radius: 3.5cqw 3.5cqw 0 0; background: var(--accent); --et: 9cqw; --eg: 4.5cqw; --es: 6.5cqw; --mt: 21cqw; --mw: 7cqw; --mc: rgba(255, 255, 255, .85); }
        .c-b { z-index: 2; left: 46cqw; width: 21cqw; height: 46cqw; border-radius: 3cqw 3cqw 0 0; background: #1f2937; --et: 8cqw; --eg: 3.5cqw; --es: 5.5cqw; --mt: 17cqw; --mw: 5cqw; --mc: rgba(255, 255, 255, .85); }
        .c-o { z-index: 3; left: 3cqw; width: 41cqw; height: 31cqw; border-radius: 20.5cqw 20.5cqw 0 0; background: #fb923c; --et: 13cqw; --eg: 9cqw; --mt: 20cqw; --mw: 7cqw; }
        .c-y { z-index: 4; left: 62cqw; width: 25cqw; height: 37cqw; border-radius: 12.5cqw 12.5cqw 0 0; background: #facc15; --et: 10cqw; --eg: 5.5cqw; --mt: 19cqw; --mw: 6cqw; }

        &[data-state="password"] .eye, &[data-state="peek"] .eye { transform: scaleY(.08); }
        &[data-state="peek"] :is(.c-p, .c-b) .eye:last-child { transform: none; }
        &[data-state="success"] .eye { transform: scaleY(.55); }
        &[data-state="success"] .c { --mh: 3; animation: rj-lg-breathe 4s ease-in-out infinite var(--d), rj-lg-jump .9s ease-in-out infinite var(--d); }
        &[data-state="error"] .c { --mh: 2; animation: rj-lg-breathe 4s ease-in-out infinite var(--d), rj-lg-shake .5s; }
        &[data-state="error"] .m { rotate: 180deg; }

        @media (max-width: 760px) {
            .lg-card { grid-template-columns: 1fr; }
            .lg-stage { order: -1; aspect-ratio: 4 / 3; }
            .lg-cast { scale: .78; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    }

    @keyframes rj-lg-breathe { 50% { scale: 1 1.025; } }
    @keyframes rj-lg-blink { 0%, 93%, 100% { scale: 1 1; } 96% { scale: 1 .1; } }
    @keyframes rj-lg-jump { 0%, 100% { translate: 0 0; } 40% { translate: 0 -4cqw; } }
    @keyframes rj-lg-shake { 20%, 60% { rotate: -3deg; } 40%, 80% { rotate: 3deg; } }
    @keyframes rj-lg-rise { 0% { opacity: 0; translate: 0 0; scale: .3; } 20% { opacity: 1; } 100% { opacity: 0; translate: 0 -26cqw; scale: 1; rotate: 90deg; } }
    @keyframes rj-lg-pop { from { opacity: 0; scale: .8; } }
    @keyframes rj-lg-drift { to { translate: 4cqw 3cqw; } }
    @keyframes rj-lg-spin { to { rotate: 360deg; } }
    @keyframes rj-lg-fade { from { opacity: 0; translate: 0 8px; } }
    @keyframes rj-lg-shine { 0%, 55% { left: -60%; } 100% { left: 130%; } }
</style>

<div id="{{ $uid }}" data-state="idle" data-side="{{ $side }}">
    <div class="lg-card">
        <section class="lg-main">
            <div class="lg-in">
                <h2 class="lg-title">{{ $title }}</h2>
                <p class="lg-sub">{{ $subtitle }}</p>

                <div class="lg-err" role="alert" hidden></div>

                <form novalidate>
                    <div class="lg-f">
                        <label for="{{ $uid }}-e">{{ __('Email address') }}</label>
                        <div class="lg-w">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m3.5 7 8.5 6 8.5-6"/></svg>
                            <input id="{{ $uid }}-e" data-email type="email" placeholder="you@example.com" autocomplete="username" required>
                        </div>
                    </div>

                    <div class="lg-f">
                        <label for="{{ $uid }}-p">{{ __('Password') }}</label>
                        <div class="lg-w has-eye">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="10" width="16" height="10" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            <input id="{{ $uid }}-p" data-pass type="password" placeholder="••••••••" autocomplete="current-password" required>
                            <button type="button" class="lg-eye" data-toggle aria-label="{{ __('Show password') }}">
                                <svg class="on" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18M9.9 9.9a3 3 0 0 0 4.2 4.2M10.6 6.1A9.6 9.6 0 0 1 12 6c6.4 0 10 6 10 6a17 17 0 0 1-3.2 3.9M6.6 6.7A16.6 16.6 0 0 0 2 12s3.6 6 10 6c1.5 0 2.9-.3 4.1-.8"/></svg>
                            </button>
                        </div>
                    </div>

                    @if($showRemember || $forgotUrl)
                        <div class="lg-row">
                            @if($showRemember)
                                <label class="lg-check"><input type="checkbox" data-remember><span>{{ __('Remember me') }}</span></label>
                            @else
                                <span></span>
                            @endif
                            @if($forgotUrl)<a class="lg-link" href="{{ $forgotUrl }}">{{ __('Forgot password?') }}</a>@endif
                        </div>
                    @endif

                    <button type="submit" class="lg-submit">
                        <span data-label>{{ __('Sign In') }}</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>

                    @if($registerUrl)
                        <p class="lg-foot">{{ __('Don’t have an account?') }} <a class="lg-link" href="{{ $registerUrl }}">{{ __('Create one now') }}</a></p>
                    @endif
                </form>
            </div>

            <div class="lg-out" hidden>
                <h2>{{ $loggedTitle }}</h2>
                <div class="lg-av" data-ini></div>
                <h3 data-name></h3>
                <p data-mail></p>

                <div class="lg-act">
                    @if($showAdminBtn)
                        <a class="lg-btn is-primary" data-admin href="#" hidden>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                            <span>{{ __('Go to Admin') }}</span>
                        </a>
                    @endif
                    <a class="lg-btn" data-account href="#" hidden>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0 1 16 0v1"/></svg>
                        <span>{{ __('My Account') }}</span>
                    </a>
                    <button type="button" class="lg-btn is-ghost" data-logout>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 16l4-4-4-4M21 12H7M13 16v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/></svg>
                        <span>{{ __('Sign out') }}</span>
                    </button>
                </div>
            </div>
        </section>

        <aside class="lg-stage" aria-hidden="true">
            <span class="lg-orb"></span><span class="lg-orb"></span>
            @if($showBubble)<p class="lg-bubble"></p>@endif

            <div class="lg-spark">
                <i style="--x:14%;--d:0s"></i><i style="--x:30%;--d:.5s"></i><i style="--x:46%;--d:1.1s"></i>
                <i style="--x:62%;--d:.3s"></i><i style="--x:78%;--d:.9s"></i><i style="--x:90%;--d:1.5s"></i>
            </div>

            <div class="lg-cast">
                <div class="c c-p" style="--d:0s">
                    <div class="eyes"><span class="eye w"><i></i></span><span class="eye w"><i></i></span></div>
                    <span class="m"></span>
                </div>
                <div class="c c-b" style="--d:.4s">
                    <div class="eyes"><span class="eye w"><i></i></span><span class="eye w"><i></i></span></div>
                    <span class="m"></span>
                </div>
                <div class="c c-o" style="--d:.8s">
                    <div class="eyes"><span class="eye d"></span><span class="eye d"></span></div>
                    <span class="m"></span>
                </div>
                <div class="c c-y" style="--d:1.2s">
                    <div class="eyes"><span class="eye d"></span><span class="eye d"></span></div>
                    <span class="m"></span>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var T    = @js($texts);
    var urls = @js($urls);
    var user = @js($initialUser);

    var $       = function (s) { return root.querySelector(s); };
    var form    = $('form');
    var email   = $('[data-email]');
    var pass    = $('[data-pass]');
    var toggle  = $('[data-toggle]');
    var remember = $('[data-remember]');
    var errBox  = $('.lg-err');
    var submit  = $('.lg-submit');
    var label   = $('[data-label]');
    var bubble  = $('.lg-bubble');
    var panelIn = $('.lg-in');
    var panelOut = $('.lg-out');
    var chars   = root.querySelectorAll('.c');
    var narrow  = window.matchMedia('(max-width: 760px)');

    var busy = false, flash = '', pointer = null, frame = 0;

    function token() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m && m.content ? m.content : urls.csrf;
    }

    function initials(n) {
        var p = String(n || '').trim().split(/\s+/);
        return ((p[0] || '?').charAt(0) + (p.length > 1 ? p[p.length - 1].charAt(0) : '')).toUpperCase();
    }

    function firstError(e) {
        var k = Object.keys(e || {})[0];
        return k && e[k] && e[k][0];
    }

    function current() {
        if (flash) return flash;
        if (user) return 'success';
        if (busy) return 'wait';
        var a = document.activeElement;
        if (a === pass || a === toggle) return pass.type === 'text' ? 'peek' : 'password';
        if (a === email) return 'email';
        return 'idle';
    }

    function say(s) {
        if (!bubble) return;
        var first = user ? String(user.name || '').split(' ')[0] : '';
        bubble.textContent = (T[s] || '').replace(':name', first);
        bubble.classList.remove('is-pop');
        void bubble.offsetWidth;
        bubble.classList.add('is-pop');
    }

    function look() {
        var s = root.dataset.state, fixed = null;
        if (s === 'email' || s === 'password' || s === 'peek' || s === 'wait') {
            fixed = narrow.matches ? [0, 1] : [root.dataset.side === 'left' ? 1 : -1, .45];
        }
        chars.forEach(function (c) {
            var x = 0, y = 0;
            if (fixed) {
                x = fixed[0]; y = fixed[1];
            } else if (pointer) {
                var r = c.getBoundingClientRect();
                var dx = pointer.x - (r.left + r.width / 2);
                var dy = pointer.y - (r.top + r.height * .2);
                var d = Math.hypot(dx, dy) || 1;
                var k = Math.min(1, d / 160);
                x = dx / d * k; y = dy / d * k;
            }
            c.style.setProperty('--lx', x.toFixed(3));
            c.style.setProperty('--ly', y.toFixed(3));
        });
    }

    function sync(force) {
        var s = current();
        if (force || root.dataset.state !== s) {
            root.dataset.state = s;
            say(s);
        }
        look();
    }

    function showPanel() {
        panelIn.hidden = !!user;
        panelOut.hidden = !user;
        if (!user) return;
        $('[data-name]').textContent = user.name || '';
        $('[data-mail]').textContent = user.email || '';
        $('[data-ini]').textContent = user.initials || initials(user.name);
        var a = $('[data-admin]'), c = $('[data-account]');
        if (a) { a.hidden = !(user.admin && user.adminUrl); if (!a.hidden) a.href = user.adminUrl; }
        c.hidden = !user.account;
        if (!c.hidden) c.href = user.account;
    }

    function fail(msg) {
        errBox.textContent = msg;
        errBox.hidden = false;
        errBox.style.animation = 'none';
        void errBox.offsetWidth;
        errBox.style.animation = '';
        flash = 'error';
        setTimeout(function () { flash = ''; sync(); }, 1400);
        sync();
    }

    function headers(json) {
        var h = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token() };
        if (json) h['Content-Type'] = 'application/json';
        return h;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (busy) return;
        errBox.hidden = true;

        if (!email.value.trim() || !pass.value) return fail(T.fill);

        busy = true;
        submit.disabled = true;
        submit.classList.add('is-loading');
        label.textContent = T.signingIn;
        sync();

        fetch(urls.login, {
            method: 'POST',
            credentials: 'same-origin',
            headers: headers(true),
            body: JSON.stringify({ email: email.value.trim(), password: pass.value, remember: remember && remember.checked ? 1 : 0 })
        })
            .then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (data) { return { res: res, data: data }; });
            })
            .then(function (o) {
                if (o.res.ok && o.data.ok) {
                    user = o.data.user;
                    pass.value = '';
                    pass.type = 'password';
                    toggle.classList.remove('is-on');
                    return;
                }
                fail(o.data.message || firstError(o.data.errors) || (o.res.status === 419 ? T.expired : T.failed));
            })
            .catch(function () { fail(T.network); })
            .then(function () {
                busy = false;
                submit.disabled = false;
                submit.classList.remove('is-loading');
                label.textContent = T.signIn;
                showPanel();
                sync();
            });
    });

    $('[data-logout]').addEventListener('click', function () {
        if (busy) return;
        busy = true;
        sync();
        fetch(urls.logout, { method: 'POST', credentials: 'same-origin', headers: headers(false) })
            .then(function (res) {
                if (res.ok) { user = null; email.value = ''; pass.value = ''; errBox.hidden = true; }
            })
            .catch(function () {})
            .then(function () { busy = false; showPanel(); sync(); });
    });

    toggle.addEventListener('mousedown', function (e) { e.preventDefault(); });
    toggle.addEventListener('click', function () {
        var show = pass.type === 'password';
        pass.type = show ? 'text' : 'password';
        toggle.classList.toggle('is-on', show);
        pass.focus();
        sync();
    });

    [email, pass].forEach(function (el) {
        ['focus', 'blur'].forEach(function (ev) {
            el.addEventListener(ev, function () { setTimeout(sync, 0); });
        });
    });

    function track(e) {
        pointer = { x: e.clientX, y: e.clientY };
        if (!frame) frame = requestAnimationFrame(function () { frame = 0; look(); });
    }
    document.addEventListener('pointermove', track);
    document.addEventListener('pointerdown', track);
    if (narrow.addEventListener) narrow.addEventListener('change', look);

    showPanel();
    sync(true);
})();
</script>
