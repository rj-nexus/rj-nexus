@php
    $layout          = $settings['layout'] ?? 'card';
    $title           = $settings['title'] ?? '';
    $subtitle        = $settings['subtitle'] ?? '';
    $desc            = $settings['desc'] ?? '';
    $showName        = $settings['show_name'] ?? false;
    $namePlaceholder = $settings['name_placeholder'] ?? __('Your name');
    $emailPlaceholder= $settings['email_placeholder'] ?? __('Enter your email address');
    $btnLabel        = $settings['btn_label'] ?? __('Subscribe');
    $privacyText     = $settings['privacy_text'] ?? '';
    $privacyRequired = $settings['privacy_required'] ?? true;
    $privacyUrl      = trim($settings['privacy_url'] ?? '');
    $successMessage  = $settings['success_message'] ?? __('Thanks! You are now subscribed.');
    $showIcon        = $settings['show_icon'] ?? true;
    $showCount       = $settings['show_count'] ?? false;
    $countLabel      = $settings['count_label'] ?? __('Join :n subscribers');
    $styleType       = $settings['style'] ?? 'gradient';
    $accent          = $settings['accent'] ?? '#8b5cf6';
    $accent2         = $settings['accent2'] ?? '#ec4899';
    $textColor       = $settings['text_color'] ?? '#0f172a';
    $radius          = $settings['radius'] ?? 'xl';
    $showShapes      = $settings['show_shapes'] ?? true;
    $align           = $settings['align'] ?? 'center';
    $paddingY        = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'lg' => '20px', 'xl' => '28px', '2xl' => '36px'];
    $radiusCss = $radiusMap[$radius] ?? '28px';

    $isDark = in_array($styleType, ['gradient', 'dark'], true);
    $finalText = $isDark ? '#ffffff' : $textColor;
    $finalMuted = $isDark ? 'rgba(255,255,255,.78)' : '#64748b';

    $subscriberCount = 0;
    if ($showCount) {
        try {
            $subscriberCount = \App\Models\NewsletterSubscriber::active()->count();
        } catch (\Throwable $e) {}
    }

    $countText = $subscriberCount > 0
        ? str_replace(':n', number_format($subscriberCount), $countLabel)
        : '';

    $isInline = $layout === 'inline';
    $isStrip  = $layout === 'strip';

    $alignCss = $align === 'left' ? 'left' : 'center';
@endphp

<style>
    #{{ $uid }} {
        --nl-a: {{ $accent }};
        --nl-b: {{ $accent2 }};
        --nl-text: {{ $finalText }};
        --nl-muted: {{ $finalMuted }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-nl-wrap {
        max-width: 1120px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
        border-radius: {{ $radiusCss }};
        padding: {{ $isInline || $isStrip ? '26px 32px' : '48px 40px' }};
        text-align: {{ $alignCss }};
        isolation: isolate;
    }
    @media (max-width: 720px) {
        #{{ $uid }} .rj-nl-wrap { padding: {{ $isInline || $isStrip ? '20px' : '32px 22px' }}; }
    }

    #{{ $uid }}[data-style="gradient"] .rj-nl-wrap {
        background: linear-gradient(125deg, var(--nl-a), var(--nl-b));
        color: #fff;
        box-shadow: 0 30px 60px -30px color-mix(in srgb, var(--nl-a) 55%, transparent);
    }
    #{{ $uid }}[data-style="solid"] .rj-nl-wrap {
        background: var(--nl-a);
        color: #fff;
        box-shadow: 0 24px 48px -24px color-mix(in srgb, var(--nl-a) 55%, transparent);
    }
    #{{ $uid }}[data-style="solid"] .rj-nl-sub,
    #{{ $uid }}[data-style="solid"] .rj-nl-desc { color: rgba(255,255,255,.85); }
    #{{ $uid }}[data-style="dark"] .rj-nl-wrap {
        background: #0f172a;
        color: #fff;
        box-shadow: 0 30px 60px -30px rgba(0,0,0,.5);
    }
    #{{ $uid }}[data-style="light"] .rj-nl-wrap {
        background: #fff;
        color: var(--nl-text);
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.15);
    }
    #{{ $uid }}[data-style="glass"] .rj-nl-wrap {
        background: rgba(255,255,255,.6);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,.7);
        color: var(--nl-text);
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.2);
    }

    #{{ $uid }} .rj-nl-shapes {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
        border-radius: inherit;
    }
    #{{ $uid }} .rj-nl-shape {
        position: absolute;
        border-radius: 50%;
        opacity: .3;
        filter: blur(48px);
        animation: rjNlFloat 14s ease-in-out infinite;
    }
    #{{ $uid }} .rj-nl-shape.s1 {
        width: 260px; height: 260px;
        background: rgba(255,255,255,.35);
        top: -80px; left: -60px;
    }
    #{{ $uid }} .rj-nl-shape.s2 {
        width: 200px; height: 200px;
        background: rgba(255,255,255,.22);
        bottom: -60px; right: -40px;
        animation-delay: -4s;
    }
    @keyframes rjNlFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(20px, -25px) scale(1.08); }
    }

    #{{ $uid }} .rj-nl-inner {
        position: relative;
        z-index: 1;
        max-width: 620px;
        margin: 0 auto;
    }
    #{{ $uid }}[data-align="left"] .rj-nl-inner {
        margin: 0;
    }
    #{{ $uid }}[data-align="left"] .rj-nl-head {
        text-align: left;
    }
    #{{ $uid }}[data-align="center"] .rj-nl-head {
        text-align: center;
    }

    #{{ $uid }} .rj-nl-env {
        --env: {{ $isDark ? '#ffffff' : 'var(--nl-a)' }};
        --env-in: {{ $isDark ? 'rgba(255,255,255,.5)' : 'color-mix(in srgb, var(--nl-a) 50%, #fff)' }};
        position: relative;
        width: 76px;
        height: 56px;
        margin: {{ $align === 'left' ? '0 0 26px' : '0 auto 26px' }};
        perspective: 420px;
        color: var(--env);
    }
    #{{ $uid }} .rj-nl-env > * { position: absolute; }
    #{{ $uid }} .rj-nl-env-back {
        inset: 0;
        border-radius: 8px;
        background: var(--env-in);
    }
    #{{ $uid }} .rj-nl-env-letter {
        z-index: 1;
        left: 10%;
        right: 10%;
        top: 8%;
        height: 80%;
        display: grid;
        align-content: start;
        gap: 5px;
        padding: 8px 7px;
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 4px 10px -4px rgba(15, 23, 42, .35);
        transition: transform .5s cubic-bezier(.34, 1.56, .64, 1), opacity .3s;
    }
    #{{ $uid }} .rj-nl-env-letter i {
        display: block;
        height: 3px;
        border-radius: 2px;
        background: var(--nl-a);
        opacity: .5;
    }
    #{{ $uid }} .rj-nl-env-letter i:nth-child(2) { width: 70%; }
    #{{ $uid }} .rj-nl-env-letter i:nth-child(3) { width: 45%; }
    #{{ $uid }} .rj-nl-env-front {
        z-index: 2;
        inset: 0;
        border-radius: 8px;
        background: var(--env);
        clip-path: polygon(0 0, 50% 55%, 100% 0, 100% 100%, 0 100%);
    }
    #{{ $uid }} .rj-nl-env-flap {
        z-index: 3;
        left: 0;
        right: 0;
        top: 0;
        height: 55%;
        background: color-mix(in srgb, var(--env) 82%, #000);
        clip-path: polygon(0 0, 100% 0, 50% 100%);
        transform-origin: 50% 0;
        transition: transform .45s ease;
    }
    #{{ $uid }} .rj-nl-env-plane {
        z-index: 4;
        left: 26px;
        top: 14px;
        width: 26px;
        height: 26px;
        opacity: 0;
        rotate: 45deg;
    }

    #{{ $uid }} .rj-nl-env[data-state="open"] .rj-nl-env-flap,
    #{{ $uid }} .rj-nl-env[data-state="valid"] .rj-nl-env-flap { transform: rotateX(180deg); z-index: 0; }
    #{{ $uid }} .rj-nl-env[data-state="open"] .rj-nl-env-letter { transform: translateY(-14px); }
    #{{ $uid }} .rj-nl-env[data-state="valid"] .rj-nl-env-letter { transform: translateY(-26px) rotate(-3deg); }
    #{{ $uid }} .rj-nl-env[data-state="sending"] { animation: rjNlBob .6s ease-in-out infinite; }
    #{{ $uid }} .rj-nl-env[data-state="error"] { animation: rjNlShake .5s; }
    #{{ $uid }} .rj-nl-env[data-state="sent"] .rj-nl-env-letter { opacity: 0; transform: translateY(0); }
    #{{ $uid }} .rj-nl-env[data-state="sent"] .rj-nl-env-plane { animation: rjNlFly 1.1s cubic-bezier(.5, 0, .9, .6) forwards; }

    @keyframes rjNlBob { 50% { transform: translateY(-5px) scale(1.04); } }
    @keyframes rjNlShake { 20%, 60% { transform: translateX(-5px) rotate(-4deg); } 40%, 80% { transform: translateX(5px) rotate(4deg); } }
    @keyframes rjNlFly {
        0%   { opacity: 0; transform: translate(0, 0) scale(.6); }
        15%  { opacity: 1; }
        100% { opacity: 0; transform: translate(190px, -150px) scale(1.2); }
    }

    #{{ $uid }} .rj-nl-title {
        font-size: clamp(22px, 2.8vw, 32px);
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1.2;
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-nl-sub {
        font-size: 14px;
        font-weight: 600;
        color: var(--nl-muted);
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-nl-desc {
        font-size: 14px;
        line-height: 1.65;
        color: var(--nl-muted);
        margin: 0 0 22px;
    }
    #{{ $uid }} .rj-nl-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        background: {{ $isDark ? 'rgba(255,255,255,.15)' : 'color-mix(in srgb, var(--nl-a) 10%, transparent)' }};
        color: var(--nl-muted);
        font-size: 11.5px;
        font-weight: 700;
        margin: 0 0 14px;
    }
    #{{ $uid }} .rj-nl-count::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: {{ $isDark ? '#fff' : 'var(--nl-a)' }};
    }

    #{{ $uid }} .rj-nl-form {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    #{{ $uid }}[data-layout="inline"] .rj-nl-form,
    #{{ $uid }}[data-layout="strip"] .rj-nl-form {
        flex-wrap: nowrap;
        max-width: 560px;
        margin: 0 auto;
    }
    #{{ $uid }}[data-align="left"][data-layout="inline"] .rj-nl-form,
    #{{ $uid }}[data-align="left"][data-layout="strip"] .rj-nl-form {
        margin: 0;
    }

    #{{ $uid }} .rj-nl-field {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    #{{ $uid }}[data-layout="inline"] .rj-nl-field,
    #{{ $uid }}[data-layout="strip"] .rj-nl-field {
        min-width: 0;
    }
    #{{ $uid }} .rj-nl-input {
        width: 100%;
        padding: 13px 16px;
        font-size: 14px;
        border-radius: 12px;
        border: 1.5px solid transparent;
        background: {{ $isDark ? 'rgba(255,255,255,.16)' : '#fff' }};
        color: {{ $isDark ? '#fff' : '#0f172a' }};
        outline: 0;
        transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        font-family: inherit;
    }
    #{{ $uid }} .rj-nl-input::placeholder {
        color: {{ $isDark ? 'rgba(255,255,255,.55)' : '#94a3b8' }};
    }
    #{{ $uid }} .rj-nl-input:focus {
        border-color: {{ $isDark ? 'rgba(255,255,255,.5)' : 'var(--nl-a)' }};
        box-shadow: 0 0 0 3px {{ $isDark ? 'rgba(255,255,255,.15)' : 'color-mix(in srgb, var(--nl-a) 25%, transparent)' }};
    }
    #{{ $uid }}[data-style="light"] .rj-nl-input,
    #{{ $uid }}[data-style="glass"] .rj-nl-input {
        background: #fff;
        color: #0f172a;
        border-color: #e5e7eb;
    }
    #{{ $uid }}[data-style="light"] .rj-nl-input:focus,
    #{{ $uid }}[data-style="glass"] .rj-nl-input:focus {
        border-color: var(--nl-a);
    }

    #{{ $uid }} .rj-nl-btn {
        padding: 13px 26px;
        border-radius: 12px;
        border: 0;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: opacity .2s ease, transform .15s ease, box-shadow .2s ease;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    #{{ $uid }} .rj-nl-btn:active { transform: scale(.98); }
    #{{ $uid }} .rj-nl-btn:disabled { opacity: .6; cursor: wait; }
    #{{ $uid }}[data-style="gradient"] .rj-nl-btn,
    #{{ $uid }}[data-style="solid"] .rj-nl-btn,
    #{{ $uid }}[data-style="dark"] .rj-nl-btn {
        background: #fff;
        color: var(--nl-a);
        box-shadow: 0 8px 20px -10px rgba(0,0,0,.35);
    }
    #{{ $uid }}[data-style="gradient"] .rj-nl-btn:hover,
    #{{ $uid }}[data-style="solid"] .rj-nl-btn:hover,
    #{{ $uid }}[data-style="dark"] .rj-nl-btn:hover {
        box-shadow: 0 12px 24px -10px rgba(0,0,0,.4);
    }
    #{{ $uid }}[data-style="light"] .rj-nl-btn,
    #{{ $uid }}[data-style="glass"] .rj-nl-btn {
        background: var(--nl-a);
        color: #fff;
        box-shadow: 0 10px 24px -10px color-mix(in srgb, var(--nl-a) 55%, transparent);
    }
    #{{ $uid }}[data-style="light"] .rj-nl-btn:hover,
    #{{ $uid }}[data-style="glass"] .rj-nl-btn:hover {
        opacity: .92;
    }

    #{{ $uid }} .rj-nl-btn-spin {
        width: 14px;
        height: 14px;
        animation: rjNlSpin .8s linear infinite;
    }
    @keyframes rjNlSpin { to { transform: rotate(360deg); } }

    #{{ $uid }} .rj-nl-privacy {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: 14px;
        font-size: 11.5px;
        line-height: 1.5;
        color: var(--nl-muted);
        text-align: left;
        max-width: 100%;
    }
    #{{ $uid }}[data-layout="inline"] .rj-nl-privacy,
    #{{ $uid }}[data-layout="strip"] .rj-nl-privacy {
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }}[data-align="left"][data-layout="inline"] .rj-nl-privacy,
    #{{ $uid }}[data-align="left"][data-layout="strip"] .rj-nl-privacy {
        margin-left: 0;
    }
    #{{ $uid }} .rj-nl-privacy input[type="checkbox"] {
        width: 15px;
        height: 15px;
        margin-top: 1px;
        accent-color: {{ $isDark ? '#fff' : 'var(--nl-a)' }};
        flex-shrink: 0;
        cursor: pointer;
    }
    #{{ $uid }} .rj-nl-privacy a {
        color: {{ $isDark ? '#fff' : 'var(--nl-a)' }};
        text-decoration: underline;
        font-weight: 600;
    }

    #{{ $uid }} .rj-nl-msg {
        display: none;
        margin-top: 12px;
        padding: 11px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
    }
    #{{ $uid }} .rj-nl-msg.is-error {
        display: block;
        background: {{ $isDark ? 'rgba(239,68,68,.2)' : '#fef2f2' }};
        color: {{ $isDark ? '#fecaca' : '#b91c1c' }};
        border: 1px solid {{ $isDark ? 'rgba(239,68,68,.3)' : '#fecaca' }};
    }
    #{{ $uid }} .rj-nl-msg.is-success {
        display: block;
        background: {{ $isDark ? 'rgba(34,197,94,.2)' : '#f0fdf4' }};
        color: {{ $isDark ? '#bbf7d0' : '#15803d' }};
        border: 1px solid {{ $isDark ? 'rgba(34,197,94,.3)' : '#bbf7d0' }};
    }

    #{{ $uid }} .rj-nl-success {
        display: none;
        text-align: center;
        padding: 12px 0;
    }
    #{{ $uid }} .rj-nl-success.is-on { display: block; }
    #{{ $uid }} .rj-nl-success-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: {{ $isDark ? 'rgba(255,255,255,.2)' : '#dcfce7' }};
        color: {{ $isDark ? '#fff' : '#16a34a' }};
        animation: rjNlPop .5s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes rjNlPop {
        from { transform: scale(.5); opacity: 0; }
        to   { transform: none; opacity: 1; }
    }
    #{{ $uid }} .rj-nl-success-title {
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 6px;
        color: var(--nl-text);
    }
    #{{ $uid }} .rj-nl-success-desc {
        font-size: 13px;
        color: var(--nl-muted);
        margin: 0;
    }

    @media (max-width: 560px) {
        #{{ $uid }}[data-layout="inline"] .rj-nl-form,
        #{{ $uid }}[data-layout="strip"] .rj-nl-form {
            flex-wrap: wrap;
        }
        #{{ $uid }} .rj-nl-btn {
            width: 100%;
            justify-content: center;
        }
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

<div id="{{ $uid }}" data-layout="{{ $layout }}" data-style="{{ $styleType }}" data-align="{{ $align }}">
    <div class="rj-nl-wrap">
        @if($showShapes && !$isStrip && !$isInline)
            <div class="rj-nl-shapes" aria-hidden="true">
                <span class="rj-nl-shape s1"></span>
                <span class="rj-nl-shape s2"></span>
            </div>
        @endif

        <div class="rj-nl-inner">
            <div data-form-area>
                @if($showIcon)
                    <div class="rj-nl-env" data-env data-state="idle" aria-hidden="true">
                        <div class="rj-nl-env-back"></div>
                        <div class="rj-nl-env-letter"><i></i><i></i><i></i></div>
                        <div class="rj-nl-env-front"></div>
                        <div class="rj-nl-env-flap"></div>
                        <svg class="rj-nl-env-plane" viewBox="0 0 24 24" fill="currentColor"><path d="M2.5 11.2 21 3.5c.8-.3 1.5.4 1.2 1.2l-7.7 18.5c-.4.9-1.6.9-2 0l-2.4-6.2a1 1 0 0 0-.6-.6l-6.2-2.4c-.9-.4-.9-1.6 0-2Z"/></svg>
                    </div>
                @endif

                @if($title || $subtitle || $desc || ($showCount && $countText))
                    <div class="rj-nl-head">
                        @if($title !== '')
                            <h2 class="rj-nl-title">{{ $title }}</h2>
                        @endif
                        @if($subtitle !== '')
                            <p class="rj-nl-sub">{{ $subtitle }}</p>
                        @endif
                        @if($desc !== '')
                            <p class="rj-nl-desc">{{ $desc }}</p>
                        @endif
                        @if($showCount && $countText !== '')
                            <span class="rj-nl-count">{{ $countText }}</span>
                        @endif
                    </div>
                @endif

                <form class="rj-nl-form" data-form novalidate>
                    @if($showName)
                        <div class="rj-nl-field" style="flex:0 0 auto; min-width:{{ $isInline || $isStrip ? '140px' : '200px' }};">
                            <input type="text" class="rj-nl-input" name="name" placeholder="{{ $namePlaceholder }}" autocomplete="name" data-name>
                        </div>
                    @endif

                    <div class="rj-nl-field">
                        <input type="email" class="rj-nl-input" name="email" placeholder="{{ $emailPlaceholder }}" autocomplete="email" required data-email>
                    </div>

                    <button type="submit" class="rj-nl-btn" data-submit>
                        <svg class="rj-nl-btn-spin" data-spinner style="display:none;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                        <span data-btn-text>{{ $btnLabel }}</span>
                    </button>
                </form>

                @if($privacyText !== '')
                    <label class="rj-nl-privacy">
                        <input type="checkbox" data-privacy @if($privacyRequired) required @endif>
                        <span>
                            {{ $privacyText }}
                            @if($privacyUrl !== '')
                                <a href="{{ $privacyUrl }}" target="_blank" rel="noopener noreferrer">{{ __('Privacy policy') }}</a>
                            @endif
                        </span>
                    </label>
                @endif

                <div class="rj-nl-msg" data-msg></div>
            </div>

            <div class="rj-nl-success" data-success>
                <div class="rj-nl-success-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="rj-nl-success-title">{{ $successMessage }}</h3>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var formEl    = root.querySelector('[data-form]');
    var emailEl   = root.querySelector('[data-email]');
    var nameEl    = root.querySelector('[data-name]');
    var privacyEl = root.querySelector('[data-privacy]');
    var submitBtn = root.querySelector('[data-submit]');
    var btnText   = root.querySelector('[data-btn-text]');
    var spinner   = root.querySelector('[data-spinner]');
    var msgEl     = root.querySelector('[data-msg]');
    var formArea  = root.querySelector('[data-form-area]');
    var successEl = root.querySelector('[data-success]');
    var envEl     = root.querySelector('[data-env]');

    var privacyRequired = {{ $privacyRequired ? 'true' : 'false' }};
    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function env(s) {
        if (envEl) envEl.dataset.state = s;
    }

    function envRest() {
        var a = document.activeElement;
        if (emailRe.test(emailEl ? emailEl.value.trim() : '')) return env('valid');
        env(a === emailEl || a === nameEl ? 'open' : 'idle');
    }

    function envError() {
        env('error');
        setTimeout(envRest, 900);
    }

    function showMsg(type, text) {
        if (!msgEl) return;
        msgEl.className = 'rj-nl-msg is-' + type;
        msgEl.textContent = text;
    }

    function clearMsg() {
        if (!msgEl) return;
        msgEl.className = 'rj-nl-msg';
        msgEl.textContent = '';
    }

    function setLoading(on) {
        if (submitBtn) submitBtn.disabled = on;
        if (spinner) spinner.style.display = on ? 'inline-block' : 'none';
    }

    [emailEl, nameEl].forEach(function (el) {
        if (!el) return;
        el.addEventListener('focus', envRest);
        el.addEventListener('blur', function () { setTimeout(envRest, 0); });
        el.addEventListener('input', envRest);
    });

    if (formEl) {
        formEl.addEventListener('submit', async function (e) {
            e.preventDefault();
            clearMsg();

            var email = emailEl ? emailEl.value.trim() : '';
            var name  = nameEl ? nameEl.value.trim() : '';

            if (!email || !emailRe.test(email)) {
                showMsg('error', @js(__('Please enter a valid email address.')));
                envError();
                return;
            }

            if (privacyRequired && privacyEl && !privacyEl.checked) {
                showMsg('error', @js(__('Please accept the privacy policy to continue.')));
                envError();
                return;
            }

            setLoading(true);
            env('sending');

            try {
                var res = await fetch(@js(route('rj.widget.newsletter', absolute: false)), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': @js(csrf_token())
                    },
                    body: JSON.stringify({ email: email, name: name || null })
                });

                var data = await res.json();

                if (res.ok && data.ok) {
                    env('sent');
                    setTimeout(function () {
                        if (formArea) formArea.style.display = 'none';
                        if (successEl) {
                            successEl.classList.add('is-on');
                            var descEl = successEl.querySelector('.rj-nl-success-desc');
                            if (!descEl) {
                                descEl = document.createElement('p');
                                descEl.className = 'rj-nl-success-desc';
                                successEl.appendChild(descEl);
                            }
                            descEl.textContent = data.message || @js($successMessage);
                        }
                    }, envEl ? 1000 : 0);
                } else {
                    showMsg('error', data.message || @js(__('Subscription failed. Please try again.')));
                    setLoading(false);
                    envError();
                }
            } catch (err) {
                showMsg('error', @js(__('Network error. Please try again.')));
                setLoading(false);
                envError();
            }
        });
    }
})();
</script>
