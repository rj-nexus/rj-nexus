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

    #{{ $uid }} .rj-nl-pg-wrap {
        --pg-body: {{ $isDark ? '#e2e8f0' : '#94a3b8' }};
        --pg-wing: {{ $isDark ? '#b4c2d6' : '#64748b' }};
        --pg-sheen: {{ $isDark ? '#c4b5fd' : 'var(--nl-a)' }};
        --face: 1;
        --hr: 0;
        --px: 1.4;
        --py: 0;
        position: relative;
        width: {{ $isInline || $isStrip ? '78px' : '104px' }};
        margin: {{ $align === 'left' ? '0 0 20px' : '0 auto 20px' }};
        color: var(--pg-body);
        cursor: pointer;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-nl-pg { display: block; }
    #{{ $uid }} .rj-nl-pg-flip {
        display: block;
        transform: scaleX(var(--face));
        transition: transform .35s cubic-bezier(.4, 0, .2, 1);
    }
    #{{ $uid }} .rj-nl-pg-svg {
        display: block;
        width: 100%;
        height: auto;
        overflow: visible;
        transform-origin: 50% 100%;
        animation: rjNlBreathe 3.6s ease-in-out infinite;
    }
    #{{ $uid }} .pg-body { fill: var(--pg-body); }
    #{{ $uid }} .pg-wing { fill: var(--pg-wing); }
    #{{ $uid }} .pg-sheen { fill: var(--pg-sheen); opacity: .85; }
    #{{ $uid }} .pg-beak { fill: #f59e0b; }
    #{{ $uid }} .pg-feet { fill: none; stroke: #fb7185; stroke-width: 3; stroke-linecap: round; }
    #{{ $uid }} .pg-cere { fill: #fff; }
    #{{ $uid }} .pg-iris { fill: #f97316; }
    #{{ $uid }} .pg-pupil {
        fill: #0f172a;
        transform: translate(calc(var(--px) * 1px), calc(var(--py) * 1px));
        transition: transform .12s ease-out;
    }
    #{{ $uid }} .pg-head {
        transform-box: view-box;
        transform-origin: 82px 46px;
        transform: rotate(calc(var(--hr) * 1deg));
        transition: transform .18s ease-out;
    }
    #{{ $uid }} .pg-eye {
        transform-box: fill-box;
        transform-origin: 50% 50%;
        animation: rjNlBlink 5.5s infinite;
    }
    #{{ $uid }} .pg-wing-g {
        transform-box: view-box;
        transform-origin: 64px 52px;
    }
    #{{ $uid }} .pg-tail {
        transform-box: view-box;
        transform-origin: 32px 58px;
    }

    #{{ $uid }} .rj-nl-feather {
        position: absolute;
        top: 44%;
        left: var(--fl);
        width: 12px;
        height: 6px;
        color: var(--pg-body);
        opacity: 0;
        pointer-events: none;
    }
    #{{ $uid }} .rj-nl-feather:nth-of-type(1) { --fl: 30%; --fx: -26px; animation-delay: 0s; }
    #{{ $uid }} .rj-nl-feather:nth-of-type(2) { --fl: 46%; --fx: 6px;   animation-delay: .15s; }
    #{{ $uid }} .rj-nl-feather:nth-of-type(3) { --fl: 60%; --fx: 32px;  animation-delay: .3s; }
    #{{ $uid }} .rj-nl-feather svg { display: block; width: 100%; height: 100%; }

    #{{ $uid }} .rj-nl-pg-wrap[data-state="open"] .pg-tail { animation: rjNlWag .5s ease-in-out infinite alternate; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="valid"] .rj-nl-pg { animation: rjNlHop .8s ease-out; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="valid"] .pg-wing-g { animation: rjNlFlap .22s ease-in-out 4; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="sending"] .rj-nl-pg { animation: rjNlHover .5s ease-in-out infinite; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="sending"] .pg-wing-g { animation: rjNlFlap .16s ease-in-out infinite; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="error"] .rj-nl-pg { animation: rjNlShake .5s; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="sent"] .rj-nl-pg { animation: rjNlFlyOff 1.2s cubic-bezier(.5, 0, .8, .5) forwards; }
    #{{ $uid }} .rj-nl-pg-wrap[data-state="sent"] .pg-wing-g { animation: rjNlFlap .14s ease-in-out infinite; }
    #{{ $uid }} .rj-nl-pg-wrap.is-ruffle .rj-nl-pg { animation: rjNlRuffle .6s ease; }
    #{{ $uid }} .rj-nl-pg-wrap.is-ruffle .pg-wing-g { animation: rjNlFlap .12s ease-in-out 5; }
    #{{ $uid }} .rj-nl-pg-wrap.is-ruffle .rj-nl-feather,
    #{{ $uid }} .rj-nl-pg-wrap[data-state="sent"] .rj-nl-feather { animation: rjNlFeather 1.4s ease-out forwards; }

    @keyframes rjNlBreathe { 50% { transform: scale(1, 1.025); } }
    @keyframes rjNlBlink { 0%, 92%, 100% { transform: scaleY(1); } 96% { transform: scaleY(.1); } }
    @keyframes rjNlWag { from { transform: rotate(-9deg); } to { transform: rotate(9deg); } }
    @keyframes rjNlFlap { 0%, 100% { transform: rotate(0); } 50% { transform: rotate(42deg); } }
    @keyframes rjNlHop {
        0%, 100% { transform: translateY(0); }
        35%      { transform: translateY(-14px); }
        60%      { transform: translateY(0); }
        78%      { transform: translateY(-5px); }
    }
    @keyframes rjNlHover { 50% { transform: translateY(-7px); } }
    @keyframes rjNlShake {
        20%, 60% { transform: translateX(-5px) rotate(-4deg); }
        40%, 80% { transform: translateX(5px) rotate(4deg); }
    }
    @keyframes rjNlRuffle {
        20% { transform: scale(1.08, .94) rotate(-3deg); }
        40% { transform: scale(.96, 1.06) rotate(3deg); }
        60% { transform: scale(1.04, .98) rotate(-2deg); }
    }
    @keyframes rjNlFlyOff {
        0%   { opacity: 1; transform: translate(0, 0) scale(1); }
        18%  { opacity: 1; transform: translate(-4px, 6px) scale(1.04, .92); }
        100% { opacity: 0; transform: translate(220px, -170px) scale(.7) rotate(-14deg); }
    }
    @keyframes rjNlFeather {
        0%   { opacity: 0; transform: translate(0, 0) rotate(0); }
        15%  { opacity: 1; }
        100% { opacity: 0; transform: translate(var(--fx), 58px) rotate(160deg); }
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
                    <div class="rj-nl-pg-wrap" data-env data-state="idle" aria-hidden="true">
                        <div class="rj-nl-pg">
                            <div class="rj-nl-pg-flip">
                                <svg class="rj-nl-pg-svg" viewBox="0 0 120 100" fill="none">
                                    <g class="pg-tail"><path class="pg-wing" d="M30 56 4 50 7 62 4 73 32 70Z"/></g>
                                    <path class="pg-feet" d="M48 80V91M43 93H53M62 80V91M57 93H67"/>
                                    <ellipse class="pg-body" cx="54" cy="62" rx="32" ry="20"/>
                                    <ellipse cx="66" cy="70" rx="16" ry="9" fill="#fff" opacity=".22"/>
                                    <g class="pg-wing-g">
                                        <path class="pg-wing" d="M64 52C50 46 30 52 20 68C34 77 56 73 70 62Z"/>
                                        <path d="M30 66C40 68 52 66 62 60" stroke="#000" stroke-width="1.5" stroke-linecap="round" opacity=".12"/>
                                    </g>
                                    <ellipse class="pg-body" cx="80" cy="47" rx="12" ry="15"/>
                                    <ellipse class="pg-sheen" cx="78" cy="50" rx="8" ry="9"/>
                                    <g class="pg-head">
                                        <circle class="pg-body" cx="90" cy="34" r="12"/>
                                        <path class="pg-beak" d="M101 31 115 36 101 41Z"/>
                                        <circle class="pg-cere" cx="102" cy="32.5" r="2"/>
                                        <g class="pg-eye">
                                            <circle class="pg-iris" cx="94" cy="31" r="4.6"/>
                                            <circle class="pg-pupil" cx="94" cy="31" r="2.4"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <span class="rj-nl-feather"><svg viewBox="0 0 16 8"><path d="M0 4C4 0 11 0 16 4C11 8 4 8 0 4Z" fill="currentColor"/></svg></span>
                        <span class="rj-nl-feather"><svg viewBox="0 0 16 8"><path d="M0 4C4 0 11 0 16 4C11 8 4 8 0 4Z" fill="currentColor"/></svg></span>
                        <span class="rj-nl-feather"><svg viewBox="0 0 16 8"><path d="M0 4C4 0 11 0 16 4C11 8 4 8 0 4Z" fill="currentColor"/></svg></span>
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

    var pointer = null, frame = 0, face = 1, ruffling = false;

    function setVars(hr, px, py) {
        envEl.style.setProperty('--hr', hr.toFixed(1));
        envEl.style.setProperty('--px', px.toFixed(2));
        envEl.style.setProperty('--py', py.toFixed(2));
    }

    function look() {
        if (!envEl) return;
        var s = envEl.dataset.state;

        if (s === 'open') return setVars(26, 1.2, 1.6);
        if (s === 'valid') return setVars(-10, 1.4, -.8);
        if (s === 'error') return setVars(22, 0, 1.8);
        if (s === 'sending' || s === 'sent') return setVars(-6, 1.5, -.5);
        if (!pointer) return setVars(0, 1.4, .2);

        var r = envEl.getBoundingClientRect();
        var mid = r.left + r.width / 2;
        if (pointer.x < mid - 14) face = -1;
        else if (pointer.x > mid + 14) face = 1;
        envEl.style.setProperty('--face', face);

        var cx = r.left + r.width * (face === 1 ? .75 : .25);
        var cy = r.top + r.height * .36;
        var dx = Math.abs(pointer.x - cx);
        var dy = pointer.y - cy;
        var ang = Math.atan2(dy, Math.max(dx, 1));
        var deg = Math.max(-30, Math.min(38, ang * 180 / Math.PI));
        var rad = deg * Math.PI / 180;

        setVars(deg, Math.cos(rad) * 1.6, Math.sin(rad) * 1.6);
    }

    function env(s) {
        if (!envEl) return;
        envEl.dataset.state = s;
        look();
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

    if (envEl) {
        document.addEventListener('pointermove', function (e) {
            pointer = { x: e.clientX, y: e.clientY };
            if (!frame) frame = requestAnimationFrame(function () { frame = 0; look(); });
        });

        envEl.addEventListener('click', function () {
            var s = envEl.dataset.state;
            if (ruffling || s === 'sending' || s === 'sent') return;
            ruffling = true;
            envEl.classList.remove('is-ruffle');
            void envEl.offsetWidth;
            envEl.classList.add('is-ruffle');
            setTimeout(function () {
                envEl.classList.remove('is-ruffle');
                ruffling = false;
            }, 1500);
        });
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
                    }, envEl ? 1100 : 0);
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

    look();
})();
</script>
