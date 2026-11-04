@php
    $uid = 'nl_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $showBottomLine = filter_var($settings['show_bottom_line'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 09 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ NEWSLETTER ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? 'Join the RJ Nexus newsletter.';
    $subtitle = $settings['subtitle'] ?? '';
    $btnText = $settings['btn_text'] ?? 'Subscribe Now';
    $privacyText = $settings['privacy_text'] ?? '';
    $privacyRequired = filter_var($settings['privacy_required'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $glowColor = !empty($settings['glow_color']) ? $settings['glow_color'] : '#3b82f6';
    $okTitle = $settings['success_title'] ?? "You're on the list!";
    $okText = $settings['success_text'] ?? 'Thanks for subscribing. Keep an eye on your inbox.';
@endphp

<section class="rj-nl-section" id="{{ $uid }}" style="--glow: {{ $glowColor }};">

    {{-- Neutral soft light behind the glass. Fades out on every side, never cut. --}}
    <div class="rj-nl-bg" aria-hidden="true"></div>

    @if($showHud)
        <span class="rj-nl-line rj-line-top"><i></i><i></i></span>
        @if($showBottomLine)<span class="rj-nl-line rj-line-bottom"><i></i><i></i></span>@endif
        <div class="rj-nl-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-nl-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-nl-inner">
        <div class="rj-nl-card" data-card>

            <div class="rj-nl-content" data-content>
                @if($badge)
                    <div class="rj-nl-badge" data-sink>
                        <span class="rj-nl-bars"><i></i><i></i><i></i></span>
                        <span class="rj-nl-badge-t">{{ $badge }}</span>
                        <span class="rj-nl-bars"><i></i><i></i><i></i></span>
                    </div>
                @endif

                @if($title)<h2 class="rj-nl-title" data-sink>{{ $title }}</h2>@endif
                @if($subtitle)<p class="rj-nl-sub" data-sink>{{ $subtitle }}</p>@endif

                <form class="rj-nl-form" data-form novalidate>
                    <div class="rj-nl-input-wrap" data-sink>
                        <input type="email" class="rj-nl-input" placeholder="Enter your email address" aria-label="Email address" autocomplete="email" required data-email>
                    </div>

                    <button type="submit" class="rj-nl-btn" data-btn>
                        {{-- the black hole --}}
                        <span class="rj-nl-hole" data-hole aria-hidden="true">
                            <i class="rj-nl-halo"></i>
                            <i class="rj-nl-ring rj-nl-ring-w"></i>
                            <i class="rj-nl-ring rj-nl-ring-c"></i>
                            <i class="rj-nl-core"></i>
                        </span>
                        <span class="rj-nl-btn-text" data-sink data-btn-text>{{ $btnText }}</span>
                    </button>
                </form>

                @if($privacyText)
                    <label class="rj-nl-privacy" data-sink>
                        <input type="checkbox" data-privacy @if($privacyRequired) required @endif>
                        <span>{{ $privacyText }}</span>
                    </label>
                @endif

                <div class="rj-nl-msg" data-msg role="alert" style="display:none;"></div>

                <div class="rj-nl-success" data-success role="status" aria-live="polite">
                    <div class="rj-nl-success-icon">
                        <svg class="rj-nl-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.2 4.2L19 7"/></svg>
                    </div>
                    <h3>{{ $okTitle }}</h3>
                    <p>{{ $okText }}</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-nl-section {
            position: relative; width: 100%; background: transparent;
            padding: 140px 24px 120px; display: flex; justify-content: center;
            overflow-x: clip; overflow-y: visible;
        }

        /* ===== Neutral light ===== */
        #{{ $uid }} .rj-nl-bg {
            position: absolute; left: 0; right: 0; top: -200px; bottom: -200px; z-index: 0; pointer-events: none;
            background: radial-gradient(ellipse 50% 36% at 50% 52%, rgba(255,255,255,.075), rgba(255,255,255,0) 72%);
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, #000 28%, #000 72%, transparent 100%);
                    mask-image: linear-gradient(180deg, transparent 0%, #000 28%, #000 72%, transparent 100%);
        }

        /* ===== HUD ===== */
        #{{ $uid }} .rj-nl-line { position: absolute; left: 0; right: 0; height: 1px; background: rgba(255,255,255,.14); z-index: 2; }
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
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; } #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-nl-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* ===== Glass card ===== */
        #{{ $uid }} .rj-nl-inner {
            position: relative; z-index: 1; max-width: 700px; width: 100%; margin: 0 auto;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        #{{ $uid }} .rj-nl-card {
            position: relative; overflow: hidden; isolation: isolate;   /* everything, including the swallow effect, stays inside the card */
            border-radius: 32px; padding: 60px 48px;
            background: linear-gradient(180deg, rgba(255,255,255,.09) 0%, rgba(255,255,255,.05) 100%);
            -webkit-backdrop-filter: blur(30px) saturate(180%); backdrop-filter: blur(30px) saturate(180%);
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.24);
        }
        #{{ $uid }} .rj-nl-card::before {
            content: ""; position: absolute; left: 0; right: 0; top: 0; height: 180px; z-index: 0; pointer-events: none;
            background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,0));
        }
        #{{ $uid }}.rj-ready .rj-nl-card { opacity: 0; transform: translateY(18px); transition: opacity .9s cubic-bezier(.32,.72,0,1), transform .9s cubic-bezier(.32,.72,0,1); }
        #{{ $uid }}.rj-ready.rj-in .rj-nl-card { opacity: 1; transform: none; }

        #{{ $uid }} .rj-nl-content { position: relative; z-index: 1; text-align: center; }

        /* ===== Badge / text ===== */
        #{{ $uid }} .rj-nl-badge {
            display: inline-flex; align-items: center; gap: 12px; margin-bottom: 24px; padding: 8px 16px; border-radius: 999px;
            background: rgba(255,255,255,.06); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.14);
        }
        #{{ $uid }} .rj-nl-bars { display: inline-flex; gap: 3px; height: 10px; align-items: center; }
        #{{ $uid }} .rj-nl-bars i { width: 2px; height: 100%; background: rgba(255,255,255,.55); }
        #{{ $uid }} .rj-nl-bars i:nth-child(2) { height: 60%; }
        #{{ $uid }} .rj-nl-bars i:nth-child(3) { height: 30%; }
        #{{ $uid }} .rj-nl-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-nl-badge-t { font: 600 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.78); }
        #{{ $uid }} .rj-nl-title { margin: 0 0 16px; font-size: clamp(30px, 4.4vw, 46px); font-weight: 600; line-height: 1.1; letter-spacing: -.04em; color: #fff; }
        #{{ $uid }} .rj-nl-sub { margin: 0 auto 38px; max-width: 480px; font-size: 16px; line-height: 1.6; color: rgba(255,255,255,.6); }

        /* ===== Form ===== */
        #{{ $uid }} .rj-nl-form { display: flex; gap: 12px; max-width: 520px; margin: 0 auto 22px; }
        #{{ $uid }} .rj-nl-input-wrap { flex: 1; min-width: 0; }
        #{{ $uid }} .rj-nl-input {
            width: 100%; height: 54px; padding: 0 20px; border: 0; outline: 0; border-radius: 16px;
            font: inherit; font-size: 16px; color: #fff;
            background: rgba(255,255,255,.06);
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.18), inset 0 1px 0 rgba(255,255,255,.1);
            transition: background .3s ease, box-shadow .3s ease;
        }
        #{{ $uid }} .rj-nl-input::placeholder { color: rgba(255,255,255,.34); }
        #{{ $uid }} .rj-nl-input:focus { background: rgba(255,255,255,.09); box-shadow: inset 0 0 0 1px rgba(255,255,255,.42), inset 0 1px 0 rgba(255,255,255,.16); }

        /* ===== Button ===== */
        #{{ $uid }} .rj-nl-btn {
            position: relative; flex: none; height: 54px; padding: 0 28px 0 22px; border: 0; border-radius: 16px; cursor: pointer; overflow: hidden;
            display: inline-flex; align-items: center; justify-content: center; gap: 12px;
            font: inherit; font-size: 16px; font-weight: 600; letter-spacing: -.01em; color: #fff; white-space: nowrap;
            background: linear-gradient(180deg, rgba(255,255,255,.2), rgba(255,255,255,.1));
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.3), inset 0 1px 0 rgba(255,255,255,.38);
            transition: background .3s ease, transform .25s cubic-bezier(.32,.72,0,1);
            -webkit-tap-highlight-color: transparent;
        }
        #{{ $uid }} .rj-nl-btn:hover { background: linear-gradient(180deg, rgba(255,255,255,.26), rgba(255,255,255,.14)); }
        #{{ $uid }} .rj-nl-btn:active { transform: scale(.97); }
        #{{ $uid }} .rj-nl-btn:disabled { cursor: progress; }
        #{{ $uid }} .rj-nl-btn:focus-visible { outline: 2px solid rgba(255,255,255,.7); outline-offset: 3px; }

        /* ===== The black hole ===== */
        #{{ $uid }} .rj-nl-hole { position: relative; flex: none; width: 26px; height: 26px; transition: transform .6s cubic-bezier(.32,.72,0,1); }
        #{{ $uid }} .rj-nl-btn:hover .rj-nl-hole { transform: scale(1.12); }
        #{{ $uid }} .rj-nl-hole i { position: absolute; display: block; border-radius: 50%; }
        #{{ $uid }} .rj-nl-ring {
            inset: 0; will-change: transform; animation: rjNlSpin 3.4s linear infinite;
            -webkit-mask: radial-gradient(circle, transparent 34%, #000 40%, #000 66%, transparent 72%);
                    mask: radial-gradient(circle, transparent 34%, #000 40%, #000 66%, transparent 72%);
            transition: opacity .5s ease;
        }
        #{{ $uid }} .rj-nl-ring-w {
            background: conic-gradient(from 0deg, rgba(255,255,255,1) 0deg, rgba(255,255,255,.14) 105deg, rgba(255,255,255,.8) 200deg, rgba(255,255,255,.08) 290deg, rgba(255,255,255,1) 360deg);
        }
        #{{ $uid }} .rj-nl-ring-c {
            opacity: 0;
            background: conic-gradient(from 0deg, var(--glow) 0deg, color-mix(in srgb, var(--glow) 28%, #fff) 70deg, rgba(0,0,0,0) 150deg, var(--glow) 230deg, color-mix(in srgb, var(--glow) 45%, #fff) 310deg, var(--glow) 360deg);
        }
        #{{ $uid }} .rj-nl-core { inset: 32%; background: #000; box-shadow: 0 0 0 1px rgba(255,255,255,.16); }
        #{{ $uid }} .rj-nl-halo {
            inset: -22%; opacity: 0; transition: opacity .5s ease;
            background: radial-gradient(circle, color-mix(in srgb, var(--glow) 60%, transparent) 0%, rgba(0,0,0,0) 66%);
        }
        @keyframes rjNlSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* sending: the hole turns colored and spins fast */
        #{{ $uid }} .rj-nl-btn.is-live .rj-nl-ring { animation-duration: .65s; }
        #{{ $uid }} .rj-nl-btn.is-live .rj-nl-ring-w { opacity: 0; }
        #{{ $uid }} .rj-nl-btn.is-live .rj-nl-ring-c { opacity: 1; }
        #{{ $uid }} .rj-nl-btn.is-live .rj-nl-halo { opacity: 1; }
        #{{ $uid }}.rj-idle .rj-nl-ring { animation-play-state: paused; }

        /* ===== Privacy ===== */
        #{{ $uid }} .rj-nl-privacy {
            display: flex; align-items: flex-start; justify-content: center; gap: 10px; max-width: 470px; margin: 0 auto;
            font-size: 13px; line-height: 1.5; color: rgba(255,255,255,.5); cursor: pointer; text-align: left;
        }
        #{{ $uid }} .rj-nl-privacy input {
            -webkit-appearance: none; appearance: none; flex: none; width: 18px; height: 18px; margin: 1px 0 0; border-radius: 6px; cursor: pointer;
            background: rgba(255,255,255,.07); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.3);
            transition: background .25s ease, box-shadow .25s ease;
        }
        #{{ $uid }} .rj-nl-privacy input:checked {
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='3.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 12.5l4.2 4.2L19 7'/%3E%3C/svg%3E") center / 12px no-repeat;
            box-shadow: none;
        }
        #{{ $uid }} .rj-nl-privacy input:focus-visible { outline: 2px solid rgba(255,255,255,.6); outline-offset: 2px; }

        /* ===== Messages ===== */
        #{{ $uid }} .rj-nl-msg { max-width: 520px; margin: 18px auto 0; padding: 12px 16px; border-radius: 14px; font-size: 14px; font-weight: 500; line-height: 1.4; }
        #{{ $uid }} .rj-nl-msg.is-err { color: #ffb4ab; background: rgba(255,69,58,.12); box-shadow: inset 0 0 0 .5px rgba(255,120,110,.4); }

        /* ===== Success (revealed after the swallow) ===== */
        #{{ $uid }} .rj-nl-success {
            position: absolute; inset: 0; display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; opacity: 0;
        }
        #{{ $uid }} .rj-nl-success.is-on { display: flex; }
        #{{ $uid }} .rj-nl-success-icon {
            width: 68px; height: 68px; margin: 0 auto 22px; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff;
            background: color-mix(in srgb, var(--glow) 22%, rgba(255,255,255,.06));
            box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--glow) 60%, rgba(255,255,255,.3)), inset 0 1px 0 rgba(255,255,255,.3);
        }
        #{{ $uid }} .rj-nl-check { width: 30px; height: 30px; }
        #{{ $uid }} .rj-nl-check path { stroke-dasharray: 26; stroke-dashoffset: 26; }
        #{{ $uid }} .rj-nl-success.is-on .rj-nl-check path { animation: rjNlDraw .55s .35s cubic-bezier(.32,.72,0,1) forwards; }
        @keyframes rjNlDraw { to { stroke-dashoffset: 0; } }
        #{{ $uid }} .rj-nl-success h3 { margin: 0 0 8px; font-size: 26px; font-weight: 600; letter-spacing: -.03em; color: #fff; }
        #{{ $uid }} .rj-nl-success p { margin: 0; font-size: 16px; color: rgba(255,255,255,.62); }

        /* shockwave when the hole collapses (sized and moved by JS, clipped by the card) */
        #{{ $uid }} .rj-nl-shock {
            position: absolute; z-index: 2; width: 40px; height: 40px; margin: -20px 0 0 -20px; border-radius: 50%; pointer-events: none;
            border: 2px solid color-mix(in srgb, var(--glow) 70%, #fff);
            background: radial-gradient(circle, color-mix(in srgb, var(--glow) 35%, transparent), rgba(0,0,0,0) 70%);
        }

        /* ===== Mobile / motion ===== */
        @media (max-width: 640px) {
            #{{ $uid }}.rj-nl-section { padding: 100px 16px 80px; }
            #{{ $uid }} .rj-nl-card { padding: 40px 22px; border-radius: 26px; }
            #{{ $uid }} .rj-nl-form { flex-direction: column; }
            #{{ $uid }} .rj-nl-btn { width: 100%; }
            #{{ $uid }} .rj-nl-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-nl-hud { top: 10px; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} .rj-nl-ring { animation: none !important; }
            #{{ $uid }} .rj-nl-card, #{{ $uid }} .rj-nl-hole { transition: none !important; }
            #{{ $uid }}.rj-ready .rj-nl-card { opacity: 1; transform: none; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var card = root.querySelector('[data-card]');
        var content = root.querySelector('[data-content]');
        var form = root.querySelector('[data-form]');
        var emailInput = root.querySelector('[data-email]');
        var btn = root.querySelector('[data-btn]');
        var hole = root.querySelector('[data-hole]');
        var msg = root.querySelector('[data-msg]');
        var privacy = root.querySelector('[data-privacy]');
        var success = root.querySelector('[data-success]');
        var privacyRequired = {{ $privacyRequired ? 'true' : 'false' }};
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* calm one-time entrance + pause the hole spin while off-screen */
        root.classList.add('rj-ready');
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e) {
                if (e[0].isIntersecting) root.classList.add('rj-in');
                root.classList.toggle('rj-idle', !e[0].isIntersecting);
            }, { threshold: 0.1 }).observe(card);
        } else { root.classList.add('rj-in'); }

        function showError(text) {
            msg.className = 'rj-nl-msg is-err';
            msg.textContent = text;
            msg.style.display = 'block';
        }
        function setBusy(on) {
            btn.disabled = on;
            emailInput.disabled = on;
            if (privacy) privacy.disabled = on;
            btn.classList.toggle('is-live', on);
            btn.setAttribute('aria-busy', on ? 'true' : 'false');
        }
        function wait(ms) { return new Promise(function (r) { setTimeout(r, ms); }); }

        /* ---- the black hole swallows everything, then the success message appears ---- */
        async function swallow() {
            var sinks = Array.prototype.slice.call(root.querySelectorAll('[data-sink]'))
                .filter(function (el) { return el.getClientRects().length > 0; });

            if (reduce || !content.animate) {
                sinks.forEach(function (el) { el.style.transition = 'opacity .4s'; el.style.opacity = '0'; });
                btn.style.transition = 'opacity .4s'; btn.style.opacity = '0';
                await wait(450);
                showSuccess();
                return;
            }

            content.style.minHeight = content.offsetHeight + 'px';

            var hr = hole.getBoundingClientRect();
            var hx = hr.left + hr.width / 2, hy = hr.top + hr.height / 2;

            var info = sinks.map(function (el) {
                var r = el.getBoundingClientRect();
                var dx = hx - (r.left + r.width / 2), dy = hy - (r.top + r.height / 2);
                return { el: el, dx: dx, dy: dy, d: Math.hypot(dx, dy) };
            }).sort(function (a, b) { return a.d - b.d; });   // nearest is pulled in first

            var STEP = 110, DUR = 950;
            var anims = info.map(function (o, i) {
                var len = o.d || 1, nx = -o.dy / len, ny = o.dx / len;
                var swirl = Math.min(70, len * 0.22) * (i % 2 ? 1 : -1);
                var rot = (i % 2 ? 1 : -1) * (150 + i * 35);
                return o.el.animate([
                    { transform: 'translate(0px,0px) rotate(0deg) scale(1)', opacity: 1, filter: 'blur(0px)', offset: 0 },
                    { transform: 'translate(' + (o.dx * 0.55 + nx * swirl) + 'px,' + (o.dy * 0.55 + ny * swirl) + 'px) rotate(' + (rot * 0.5) + 'deg) scale(.55)', opacity: .9, filter: 'blur(1.5px)', offset: 0.6 },
                    { transform: 'translate(' + o.dx + 'px,' + o.dy + 'px) rotate(' + rot + 'deg) scale(.02)', opacity: 0, filter: 'blur(6px)', offset: 1 }
                ], { duration: DUR, delay: i * STEP, easing: 'cubic-bezier(.55,.05,.85,.4)', fill: 'both' });
            });

            // the hole feeds: it grows while everything falls in
            var total = DUR + Math.max(0, info.length - 1) * STEP;
            var feed = hole.animate([{ transform: 'scale(1)' }, { transform: 'scale(1.9)' }], { duration: total, easing: 'ease-in', fill: 'forwards' });

            await Promise.all(anims.map(function (a) { return a.finished; }).concat([feed.finished])).catch(function () {});

            // the button (with the hole) collapses into its own center
            var br = btn.getBoundingClientRect();
            btn.style.transformOrigin = (hx - br.left) + 'px ' + (hy - br.top) + 'px';
            var collapse = btn.animate([
                { transform: 'scale(1)', opacity: 1 },
                { transform: 'scale(.03)', opacity: 0 }
            ], { duration: 520, easing: 'cubic-bezier(.6,0,.9,.5)', fill: 'forwards' });
            await collapse.finished.catch(function () {});

            // shockwave from where the hole was (clipped by the card)
            var cr = card.getBoundingClientRect();
            var shock = document.createElement('span');
            shock.className = 'rj-nl-shock';
            shock.style.left = (hx - cr.left) + 'px';
            shock.style.top = (hy - cr.top) + 'px';
            card.appendChild(shock);
            var big = Math.max(cr.width, cr.height) * 1.6 / 40;
            shock.animate([
                { transform: 'scale(.2)', opacity: .9 },
                { transform: 'scale(' + big + ')', opacity: 0 }
            ], { duration: 1100, easing: 'cubic-bezier(.2,.7,.2,1)', fill: 'forwards' }).finished
                .then(function () { shock.remove(); }).catch(function () { shock.remove(); });

            await wait(260);
            showSuccess();
        }

        function showSuccess() {
            success.classList.add('is-on');
            if (success.animate && !reduce) {
                success.animate([
                    { opacity: 0, transform: 'scale(.92)', filter: 'blur(8px)' },
                    { opacity: 1, transform: 'scale(1)', filter: 'blur(0px)' }
                ], { duration: 800, easing: 'cubic-bezier(.32,.72,0,1)', fill: 'forwards' });
            } else {
                success.style.opacity = '1';
            }
        }

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            msg.style.display = 'none';

            var email = emailInput.value.trim();
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('Please enter a valid email address.');
                return;
            }
            if (privacyRequired && privacy && !privacy.checked) {
                showError('Please accept the privacy policy.');
                return;
            }

            setBusy(true);   // the black hole turns colored and spins fast
            var started = Date.now();

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

                var data = {};
                try { data = await res.json(); } catch (_) {}

                if (res.ok && data.ok) {
                    // let the colored spin be seen for a moment, then swallow everything
                    await wait(Math.max(0, 900 - (Date.now() - started)));
                    await swallow();
                } else {
                    showError(data.message || 'Subscription failed. Please try again.');
                    setBusy(false);
                }
            } catch (err) {
                showError('Network error. Please try again.');
                setBusy(false);
            }
        });
    })();
    </script>
</section>
