@php
    $uid = 'nl_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 09 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ NEWSLETTER ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? 'Join the RJ Nexus newsletter.';
    $subtitle = $settings['subtitle'] ?? '';
    $btnText = $settings['btn_text'] ?? 'Subscribe Now';
    $privacyText = $settings['privacy_text'] ?? '';
    $privacyRequired = filter_var($settings['privacy_required'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $glowColor = !empty($settings['glow_color']) ? $settings['glow_color'] : '#3b82f6';
@endphp

<section class="rj-nl-section" id="{{ $uid }}">

    <div class="rj-nl-bg-glow" style="--glow: {{ $glowColor }};"></div>

    @if($showHud)
        <span class="rj-nl-line rj-line-top"><i></i><i></i></span>
        <span class="rj-nl-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-nl-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-nl-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-nl-inner">
        <div class="rj-nl-card">

            <div class="rj-nl-card-glow" style="--glow: {{ $glowColor }};"></div>

            <div class="rj-nl-content">
                @if($badge)
                    <div class="rj-nl-badge">
                        <span class="rj-nl-bars"><i></i><i></i><i></i></span>
                        <span class="rj-nl-badge-t">{{ $badge }}</span>
                        <span class="rj-nl-bars"><i></i><i></i><i></i></span>
                    </div>
                @endif

                @if($title)
                    <h2 class="rj-nl-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-nl-sub">{{ $subtitle }}</p>
                @endif

                <form class="rj-nl-form" data-form>
                    <div class="rj-nl-input-wrap">
                        <input type="email" class="rj-nl-input" placeholder="Enter your email address" required data-email>
                        <div class="rj-nl-input-glow" style="--glow: {{ $glowColor }};"></div>
                    </div>

                    <button type="submit" class="rj-nl-btn" data-btn>
                        <span class="rj-nl-btn-text" data-btn-text>{{ $btnText }}</span>
                        <span class="rj-nl-btn-loader" data-spinner style="display:none;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"/></svg>
                        </span>
                    </button>
                </form>

                @if($privacyText)
                    <label class="rj-nl-privacy">
                        <input type="checkbox" data-privacy @if($privacyRequired) required @endif>
                        <span>{{ $privacyText }}</span>
                    </label>
                @endif

                <div class="rj-nl-msg" data-msg style="display:none;"></div>

                <div class="rj-nl-success" data-success style="display:none;">
                    <div class="rj-nl-success-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3>You're on the list!</h3>
                    <p>Thanks for subscribing. Keep an eye on your inbox.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-nl-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 140px 24px 120px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        #{{ $uid }} .rj-nl-bg-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, color-mix(in srgb, var(--glow) 15%, transparent) 0%, transparent 60%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        /* HUD və Xətlər */
        #{{ $uid }} .rj-nl-line { position: absolute; left: 0; right: 0; height: 1px; background: rgba(255, 255, 255, 0.14); z-index: 2; }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }
        #{{ $uid }} .rj-nl-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-nl-line i::before, #{{ $uid }} .rj-nl-line i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-nl-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-nl-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-nl-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-nl-line i:last-child { right: 24px; }

        #{{ $uid }} .rj-nl-hud {
            position: absolute; top: 20px; z-index: 3; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: 0.08em; color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-nl-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* Inner & Card */
        #{{ $uid }} .rj-nl-inner {
            position: relative; z-index: 1;
            max-width: 700px; width: 100%; margin: 0 auto;
        }

        #{{ $uid }} .rj-nl-card {
            position: relative;
            background: linear-gradient(180deg, rgba(20, 20, 28, 0.85) 0%, rgba(10, 10, 15, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 56px 48px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 24px 64px -12px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255,255,255,0.05) inset;
            overflow: hidden;
        }

        #{{ $uid }} .rj-nl-card-glow {
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 100%;
            background: radial-gradient(ellipse at center, color-mix(in srgb, var(--glow) 20%, transparent) 0%, transparent 60%);
            filter: blur(40px);
            pointer-events: none;
            z-index: 0;
        }

        #{{ $uid }} .rj-nl-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        /* Badge */
        #{{ $uid }} .rj-nl-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-nl-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-nl-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjNlBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-nl-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-nl-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-nl-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjNlBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-nl-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: var(--rj-muted); text-transform: uppercase; }

        /* Text */
        #{{ $uid }} .rj-nl-title { font-size: clamp(28px, 4vw, 40px); font-weight: 600; line-height: 1.15; letter-spacing: -0.03em; color: #fff; margin: 0 0 16px; }
        #{{ $uid }} .rj-nl-sub { font-size: 15px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 40px; max-width: 500px; margin-left: auto; margin-right: auto; }

        /* Form */
        #{{ $uid }} .rj-nl-form {
            display: flex;
            gap: 12px;
            max-width: 500px;
            margin: 0 auto 20px;
        }

        #{{ $uid }} .rj-nl-input-wrap {
            position: relative;
            flex: 1;
        }

        #{{ $uid }} .rj-nl-input {
            width: 100%;
            padding: 16px 20px;
            font-size: 15px;
            font-family: inherit;
            color: #fff;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
        }
        #{{ $uid }} .rj-nl-input::placeholder { color: rgba(255, 255, 255, 0.3); }

        #{{ $uid }} .rj-nl-input-glow {
            position: absolute;
            inset: -1px;
            border-radius: 12px;
            background: var(--glow);
            opacity: 0;
            filter: blur(8px);
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        #{{ $uid }} .rj-nl-input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.3);
        }
        #{{ $uid }} .rj-nl-input:focus + .rj-nl-input-glow {
            opacity: 0.4;
        }

        /* Button */
        #{{ $uid }} .rj-nl-btn {
            position: relative;
            padding: 16px 32px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            color: #fff;
            background: linear-gradient(135deg, var(--glow), color-mix(in srgb, var(--glow) 60%, #fff));
            border: none;
            border-radius: 12px;
            cursor: pointer;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px color-mix(in srgb, var(--glow) 40%, transparent);
        }

        #{{ $uid }} .rj-nl-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px color-mix(in srgb, var(--glow) 60%, transparent);
        }
        #{{ $uid }} .rj-nl-btn:active { transform: scale(0.98); }

        #{{ $uid }} .rj-nl-btn-loader svg { width: 18px; height: 18px; animation: rjNlSpin 1s linear infinite; }
        @keyframes rjNlSpin { 100% { transform: rotate(360deg); } }

        /* Privacy & Messages */
        #{{ $uid }} .rj-nl-privacy {
            display: inline-flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12px;
            color: var(--rj-muted);
            cursor: pointer;
            text-align: left;
            max-width: 450px;
        }
        #{{ $uid }} .rj-nl-privacy input { margin-top: 2px; accent-color: var(--glow); cursor: pointer; }

        #{{ $uid }} .rj-nl-msg {
            margin-top: 16px;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
        }
        #{{ $uid }} .rj-nl-msg.is-err { background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); }
        #{{ $uid }} .rj-nl-msg.is-ok { background: rgba(16, 185, 129, 0.1); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3); }

        /* Success State */
        #{{ $uid }} .rj-nl-success { animation: rjNlFadeIn 0.5s ease forwards; }
        @keyframes rjNlFadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

        #{{ $uid }} .rj-nl-success-icon {
            width: 64px; height: 64px; margin: 0 auto 20px;
            background: color-mix(in srgb, var(--glow) 20%, transparent);
            border: 1px solid color-mix(in srgb, var(--glow) 40%, transparent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--glow);
            box-shadow: 0 0 20px color-mix(in srgb, var(--glow) 30%, transparent);
        }
        #{{ $uid }} .rj-nl-success-icon svg { width: 32px; height: 32px; }
        #{{ $uid }} .rj-nl-success h3 { font-size: 24px; color: #fff; margin: 0 0 8px; }
        #{{ $uid }} .rj-nl-success p { font-size: 15px; color: var(--rj-muted); margin: 0; }

        @media (max-width: 640px) {
            #{{ $uid }}.rj-nl-section { padding: 100px 20px 80px; }
            #{{ $uid }} .rj-nl-card { padding: 40px 24px; border-radius: 16px; }
            #{{ $uid }} .rj-nl-form { flex-direction: column; }
            #{{ $uid }} .rj-nl-btn { width: 100%; }
            #{{ $uid }} .rj-nl-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-nl-hud { top: 10px; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var form = root.querySelector('[data-form]');
        var emailInput = root.querySelector('[data-email]');
        var btn = root.querySelector('[data-btn]');
        var btnText = root.querySelector('[data-btn-text]');
        var spinner = root.querySelector('[data-spinner]');
        var msg = root.querySelector('[data-msg]');
        var privacy = root.querySelector('[data-privacy]');
        var success = root.querySelector('[data-success]');
        var content = root.querySelector('.rj-nl-content');

        var privacyRequired = {{ $privacyRequired ? 'true' : 'false' }};

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                msg.style.display = 'none';

                var email = emailInput.value.trim();
                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    msg.className = 'rj-nl-msg is-err';
                    msg.textContent = 'Please enter a valid email address.';
                    msg.style.display = 'block';
                    return;
                }

                if (privacyRequired && privacy && !privacy.checked) {
                    msg.className = 'rj-nl-msg is-err';
                    msg.textContent = 'Please accept the privacy policy.';
                    msg.style.display = 'block';
                    return;
                }

                // Loading state
                btn.disabled = true;
                btnText.style.display = 'none';
                spinner.style.display = 'inline-block';

                try {
                    var res = await fetch(@js(route('rj.widget.newsletter', absolute: false)), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': @js(csrf_token())
                        },
                        body: JSON.stringify({ email: email })
                    });

                    var data = await res.json();

                    if (res.ok && data.ok) {
                        // Uğurlu olduqda formu gizlət, success mesajını göstər
                        form.style.display = 'none';
                        if (privacy) privacy.parentElement.style.display = 'none';
                        success.style.display = 'block';
                    } else {
                        msg.className = 'rj-nl-msg is-err';
                        msg.textContent = data.message || 'Subscription failed. Please try again.';
                        msg.style.display = 'block';
                        btn.disabled = false;
                        btnText.style.display = 'inline';
                        spinner.style.display = 'none';
                    }
                } catch (err) {
                    msg.className = 'rj-nl-msg is-err';
                    msg.textContent = 'Network error. Please try again.';
                    msg.style.display = 'block';
                    btn.disabled = false;
                    btnText.style.display = 'inline';
                    spinner.style.display = 'none';
                }
            });
        }
    })();
    </script>
</section>
