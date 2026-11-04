@php
    $uid = 'steps_' . substr(md5(uniqid('', true)), 0, 8);

    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    // GitHub raw/blob -> jsDelivr (correct MIME + CDN). Format: gh/{user}/{repo}@{branch}/{path}
    $toCdn = function (string $url): string {
        if (preg_match('#^https?://raw\.githubusercontent\.com/([^/]+)/([^/]+)/([^/]+)/(.+)$#i', $url, $m)
            || preg_match('#^https?://github\.com/([^/]+)/([^/]+)/(?:blob|raw)/([^/]+)/(.+)$#i', $url, $m)) {
            return "https://cdn.jsdelivr.net/gh/{$m[1]}/{$m[2]}@{$m[3]}/{$m[4]}";
        }
        return $url;
    };

    $bgArc = $toCdn($resolve($settings['bg_image_url'] ?? '', $settings['bg_image'] ?? '')
        ?: 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/gradient-planet.webp');

    $showHud  = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft  = $settings['hud_left'] ?? '[ 04 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ HOW TO USE ]';
    $badge    = $settings['badge_text'] ?? '';
    $title    = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $steps = $settings['steps'] ?? [];
    if (!is_array($steps)) $steps = [];
    $steps = array_slice(array_values($steps), 0, 9);

    // One layout, one hue per step: only colors change
    $hues    = [217, 265, 190, 330, 160, 30, 290, 100, 350];
    $hueList = array_slice($hues, 0, max(1, count($steps)));
    $titles  = array_map(fn($s) => (string) ($s['step_title'] ?? ''), $steps);
    $total   = str_pad((string) count($steps), 2, '0', STR_PAD_LEFT);
@endphp

<section class="rj-steps-section" id="{{ $uid }}">

    <div class="rj-steps-bg-arc" aria-hidden="true">
        <img src="{{ $bgArc }}" alt="" onerror="this.style.display='none'">
    </div>

    <div class="rj-steps-inner">

        @if($badge || $title || $subtitle)
            <div class="rj-steps-header">
                @if($badge)
                    <div class="rj-steps-badge">
                        <span class="rj-steps-bars"><i></i><i></i><i></i></span>
                        <span class="rj-steps-badge-t">{{ $badge }}</span>
                        <span class="rj-steps-bars"><i></i><i></i><i></i></span>
                    </div>
                @endif
                @if($title)<h2 class="rj-steps-title">{{ $title }}</h2>@endif
                @if($subtitle)<p class="rj-steps-sub">{{ $subtitle }}</p>@endif
            </div>
        @endif

        <div class="rj-steps-split">

            {{-- LEFT: pinned holographic stage --}}
            <div class="rj-steps-visual">
                <div class="rj-steps-sticky">
                    <div class="rj-stage">
                        <span class="rj-st-c tl"></span><span class="rj-st-c tr"></span>
                        <span class="rj-st-c bl"></span><span class="rj-st-c br"></span>
                        <div class="rj-st-glow"></div>
                        <div class="rj-st-ring"></div>
                        <div class="rj-st-ring r2"></div>

                        <div class="rj-st-imgs">
                            @foreach($steps as $index => $step)
                                @php
                                    $img = $resolve($step['step_image_url'] ?? '', $step['step_image'] ?? '');
                                    if (empty($img)) $img = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/step' . ($index + 1) . '.png';
                                @endphp
                                <img src="{{ $toCdn($img) }}" alt="{{ $step['step_title'] ?? '' }}"
                                     class="rj-step-img {{ $index === 0 ? 'is-active' : '' }}" data-step="{{ $index }}" loading="lazy">
                            @endforeach
                        </div>

                        <div class="rj-st-lines"></div>
                        <div class="rj-st-scan"></div>
                        <div class="rj-st-tag">
                            <span class="rj-st-count">[ 01 / {{ $total }} ]</span>
                            <span class="rj-st-name">{{ $titles[0] ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: steps --}}
            <div class="rj-steps-content">
                <div class="rj-steps-list">
                    @foreach($steps as $index => $step)
                        <div class="rj-step-item {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
                            <div class="rj-step-marker"><span class="rj-step-dot"></span></div>
                            <div class="rj-step-body">
                                <span class="rj-step-num">STEP {{ $step['step_num'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="rj-step-title">{{ $step['step_title'] ?? '' }}</h3>
                                <p class="rj-step-text">{{ $step['step_text'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Line, + marks and HUD only at the bottom --}}
    @if($showHud)
        <div class="rj-steps-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-steps-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif
    <span class="rj-steps-line"><i></i><i></i></span>

    <style>
        @property --rj-h { syntax: '<number>'; inherits: true; initial-value: 217; }

        #{{ $uid }}.rj-steps-section {
            --rj-h: {{ $hueList[0] }};
            --sh: min(540px, 70vh);
            position: relative; width: 100%; background: transparent; color: #fff;
            padding: 120px 24px 140px;
            overflow: visible; overflow-x: clip;   /* clip (not hidden) so position: sticky keeps working */
            transition: --rj-h .9s ease;
        }

        /* Background arc */
        #{{ $uid }} .rj-steps-bg-arc { position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 1400px; height: 80vh; pointer-events: none; z-index: 0; }
        #{{ $uid }} .rj-steps-bg-arc img {
            width: 100%; height: 100%; object-fit: cover; object-position: top center; opacity: .5;
            -webkit-mask-image: linear-gradient(to bottom, #000 40%, transparent 100%); mask-image: linear-gradient(to bottom, #000 40%, transparent 100%);
        }

        #{{ $uid }} .rj-steps-inner { position: relative; z-index: 1; max-width: 1100px; width: 100%; margin: 0 auto; }

        /* Header */
        #{{ $uid }} .rj-steps-header { text-align: center; margin-bottom: 90px; }
        #{{ $uid }} .rj-steps-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-steps-bars { display: inline-flex; align-items: center; gap: 3px; height: 15px; }
        #{{ $uid }} .rj-steps-bars i { width: 3px; height: 100%; background: #fff; animation: rjStBar 1.4s ease-in-out infinite; }
        #{{ $uid }} .rj-steps-bars i:nth-child(2) { animation-delay: .18s; }
        #{{ $uid }} .rj-steps-bars i:nth-child(3) { animation-delay: .36s; }
        #{{ $uid }} .rj-steps-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjStBar { 0%, 100% { transform: scaleY(.3); opacity: .45; } 50% { transform: scaleY(1); opacity: 1; } }
        #{{ $uid }} .rj-steps-badge-t { font: 700 12px/1.4 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .1em; text-transform: uppercase; color: #fff; }
        #{{ $uid }} .rj-steps-title {
            margin: 0 0 20px; font-size: clamp(32px, 5vw, 56px); font-weight: 500; line-height: 1.1; letter-spacing: -.035em;
            background: linear-gradient(180deg, #fff, hsl(var(--rj-h) 70% 86%)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 18px hsl(var(--rj-h) 90% 60% / .28));
        }
        #{{ $uid }} .rj-steps-sub { margin: 0 auto; max-width: 600px; font-size: clamp(16px, 1.8vw, 18px); line-height: 1.6; color: rgba(255,255,255,.68); }

        /* Split: align-items MUST be stretch so the left column is as tall as the list (room for sticky to travel) */
        #{{ $uid }} .rj-steps-split { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: stretch; }
        #{{ $uid }} .rj-steps-visual { position: relative; }
        #{{ $uid }} .rj-steps-sticky {
            position: sticky; top: max(96px, calc(50vh - var(--sh) / 2));
            height: var(--sh); display: flex; align-items: center; justify-content: center;
        }

        /* ---------- Holographic stage ---------- */
        #{{ $uid }} .rj-stage {
            position: relative; width: 100%; max-width: 470px; height: 100%; border-radius: 22px; overflow: hidden;
            background: radial-gradient(ellipse at 50% 35%, hsl(var(--rj-h) 80% 50% / .16), transparent 70%), linear-gradient(160deg, rgba(255,255,255,.06), rgba(255,255,255,.015));
            border: 1px solid rgba(255,255,255,.1); box-shadow: inset 0 1px 0 rgba(255,255,255,.14), 0 30px 80px rgba(0,0,0,.45), 0 0 60px hsl(var(--rj-h) 90% 55% / .12);
            -webkit-backdrop-filter: blur(14px) saturate(150%); backdrop-filter: blur(14px) saturate(150%);
        }
        #{{ $uid }} .rj-st-c { position: absolute; width: 18px; height: 18px; border: 0 solid hsl(var(--rj-h) 90% 78%); z-index: 4; }
        #{{ $uid }} .rj-st-c.tl { top: 12px; left: 12px; border-top-width: 2px; border-left-width: 2px; }
        #{{ $uid }} .rj-st-c.tr { top: 12px; right: 12px; border-top-width: 2px; border-right-width: 2px; }
        #{{ $uid }} .rj-st-c.bl { bottom: 12px; left: 12px; border-bottom-width: 2px; border-left-width: 2px; }
        #{{ $uid }} .rj-st-c.br { bottom: 12px; right: 12px; border-bottom-width: 2px; border-right-width: 2px; }

        #{{ $uid }} .rj-st-glow { position: absolute; inset: 15% 10%; background: radial-gradient(closest-side, hsl(var(--rj-h) 95% 60% / .35), transparent); filter: blur(30px); }
        #{{ $uid }} .rj-st-ring {
            position: absolute; inset: 6% -14%; border-radius: 50%; border: 1px dashed hsl(var(--rj-h) 85% 72% / .35);
            transform: rotateX(68deg) rotateZ(0); animation: rjStRing 22s linear infinite;
        }
        #{{ $uid }} .rj-st-ring.r2 { inset: 16% -4%; border-style: solid; border-color: hsl(var(--rj-h) 85% 72% / .22); animation-duration: 15s; animation-direction: reverse; }
        @keyframes rjStRing { to { transform: rotateX(68deg) rotateZ(360deg); } }

        #{{ $uid }} .rj-st-imgs { position: absolute; inset: 34px 34px 68px; z-index: 2; }
        #{{ $uid }} .rj-step-img {
            position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain;
            opacity: 0; transform: translateY(26px) scale(.94); filter: blur(14px) drop-shadow(0 20px 40px rgba(0,0,0,.6));
            clip-path: inset(0 0 100% 0);
            transition: opacity .6s ease, transform .9s cubic-bezier(.2,.8,.2,1), filter .9s ease, clip-path .9s cubic-bezier(.65,0,.25,1);
        }
        #{{ $uid }} .rj-step-img.is-active {
            opacity: 1; transform: none; filter: blur(0) drop-shadow(0 20px 40px rgba(0,0,0,.6)); clip-path: inset(0 0 0 0);
        }

        /* scanlines + sweeping scan beam on every step change */
        #{{ $uid }} .rj-st-lines { position: absolute; inset: 0; z-index: 3; pointer-events: none; background: repeating-linear-gradient(0deg, rgba(255,255,255,.035) 0 1px, transparent 1px 4px); }
        #{{ $uid }} .rj-st-scan {
            position: absolute; left: 0; right: 0; top: 0; height: 2px; z-index: 3; opacity: 0; pointer-events: none;
            background: linear-gradient(90deg, transparent, hsl(var(--rj-h) 100% 85%), transparent); box-shadow: 0 0 24px 6px hsl(var(--rj-h) 95% 65% / .6);
        }
        #{{ $uid }} .rj-stage.is-switching .rj-st-scan { animation: rjStScan .95s cubic-bezier(.65,0,.25,1); }
        @keyframes rjStScan { 0% { top: 0; opacity: 1; } 90% { opacity: 1; } 100% { top: 100%; opacity: 0; } }

        #{{ $uid }} .rj-st-tag {
            position: absolute; left: 22px; right: 22px; bottom: 20px; z-index: 4; display: flex; justify-content: space-between; gap: 14px;
            font: 700 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.8);
        }
        #{{ $uid }} .rj-st-count { color: hsl(var(--rj-h) 90% 78%); flex: none; }
        #{{ $uid }} .rj-st-name { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* ---------- Steps list ---------- */
        #{{ $uid }} .rj-steps-content { padding: 40px 0; }
        #{{ $uid }} .rj-steps-list { --p: 0; position: relative; display: flex; flex-direction: column; gap: 140px; }
        #{{ $uid }} .rj-steps-list::before, #{{ $uid }} .rj-steps-list::after { content: ''; position: absolute; top: 10px; bottom: 10px; left: 11px; width: 2px; border-radius: 2px; }
        #{{ $uid }} .rj-steps-list::before { background: rgba(255,255,255,.12); }
        #{{ $uid }} .rj-steps-list::after { /* fills as you scroll */
            background: linear-gradient(to bottom, hsl(var(--rj-h) 90% 70%), hsl(var(--rj-h) 90% 60%)); box-shadow: 0 0 14px hsl(var(--rj-h) 95% 60% / .7);
            transform: scaleY(var(--p)); transform-origin: top;
        }

        #{{ $uid }} .rj-step-item { position: relative; display: flex; gap: 24px; opacity: .32; cursor: pointer; transition: opacity .5s ease, translate .5s cubic-bezier(.2,.8,.2,1); }
        #{{ $uid }} .rj-step-item.is-active { opacity: 1; translate: 6px 0; }
        #{{ $uid }} .rj-step-marker { position: relative; z-index: 1; width: 24px; height: 24px; flex: none; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: var(--rj-bg, #0a0a0f); }
        #{{ $uid }} .rj-step-dot {
            width: 8px; height: 8px; border-radius: 50%; background: hsl(var(--rj-h) 90% 65%); box-shadow: 0 0 12px hsl(var(--rj-h) 95% 60% / .9);
            transform: scale(.5); transition: transform .4s;
        }
        #{{ $uid }} .rj-step-item.is-active .rj-step-dot { transform: scale(1.6); }
        #{{ $uid }} .rj-step-body { flex: 1; }
        #{{ $uid }} .rj-step-num { display: block; margin-bottom: 8px; font: 700 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; color: hsl(var(--rj-h) 90% 74%); }
        #{{ $uid }} .rj-step-title { margin: 0 0 12px; font-size: 26px; font-weight: 600; letter-spacing: -.02em; color: #fff; }
        #{{ $uid }} .rj-step-item.is-active .rj-step-title { text-shadow: 0 0 24px hsl(var(--rj-h) 95% 60% / .4); }
        #{{ $uid }} .rj-step-text { margin: 0; font-size: 15.5px; line-height: 1.65; color: rgba(255,255,255,.66); }

        /* ---------- Bottom line + HUD ---------- */
        #{{ $uid }} .rj-steps-line { position: absolute; left: 0; right: 0; bottom: 0; height: 1px; background: rgba(255,255,255,.14); z-index: 2; }
        #{{ $uid }} .rj-steps-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-steps-line i::before, #{{ $uid }} .rj-steps-line i::after { content: ''; position: absolute; background: #fff; }
        #{{ $uid }} .rj-steps-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-steps-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-steps-line i:first-child { left: 18px; }
        #{{ $uid }} .rj-steps-line i:last-child { right: 18px; }
        #{{ $uid }} .rj-steps-hud {
            position: absolute; bottom: 22px; z-index: 3; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.75);
        }
        #{{ $uid }} .rj-hl { left: 22px; } #{{ $uid }} .rj-hr { right: 22px; }
        #{{ $uid }} .rj-steps-hud b { display: block; width: 3px; height: 26px; background: #fff; }

        /* ---------- Mobile: stage stays pinned at the top, steps scroll beneath it ---------- */
        @media (max-width: 968px) {
            #{{ $uid }}.rj-steps-section { --sh: min(280px, 36vh); }
            #{{ $uid }} .rj-steps-split { grid-template-columns: 1fr; gap: 28px; }
            #{{ $uid }} .rj-steps-visual { display: contents; }   /* so sticky travels the whole split, not just its own cell */
            #{{ $uid }} .rj-steps-sticky { top: 80px; z-index: 5; }
            #{{ $uid }} .rj-stage { max-width: 100%; background-color: rgba(4,7,14,.82); }
            #{{ $uid }} .rj-steps-content { padding: 8px 0 0; }
            #{{ $uid }} .rj-steps-list { gap: 90px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-steps-section { padding: 90px 20px 110px; }
            #{{ $uid }} .rj-steps-bars { display: none; }
            #{{ $uid }} .rj-steps-header { margin-bottom: 56px; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        // 1) Why the image used to scroll away: an ancestor (e.g. main { overflow-x: hidden }) becomes the
        //    sticky scroll container. Switch non-scrolling overflow:hidden ancestors to overflow:clip.
        for (var p = root.parentElement; p && p !== document.documentElement; p = p.parentElement) {
            var cs = getComputedStyle(p);
            if (/hidden|auto|scroll/.test(cs.overflowX + cs.overflowY) && p.scrollHeight <= p.clientHeight + 1) {
                p.style.setProperty('overflow', 'clip');
            }
        }

        var items = Array.prototype.slice.call(root.querySelectorAll('.rj-step-item'));
        var imgs = root.querySelectorAll('.rj-step-img');
        var list = root.querySelector('.rj-steps-list');
        var stage = root.querySelector('.rj-stage');
        var count = root.querySelector('.rj-st-count');
        var name = root.querySelector('.rj-st-name');
        var hues = @js($hueList);
        var titles = @js($titles);
        var cur = -1, ticking = false;

        function pad(n) { return (n < 10 ? '0' : '') + n; }

        function setActive(i) {
            cur = i;
            items.forEach(function (el, k) { el.classList.toggle('is-active', k === i); });
            imgs.forEach(function (im, k) { im.classList.toggle('is-active', k === i); });
            root.style.setProperty('--rj-h', hues[i % hues.length]);        // colors morph per step
            count.textContent = '[ ' + pad(i + 1) + ' / ' + pad(items.length) + ' ]';
            name.textContent = titles[i] || '';
            stage.classList.remove('is-switching'); void stage.offsetWidth; stage.classList.add('is-switching');
        }

        function update() {
            ticking = false;
            var mid = window.innerHeight * 0.5, best = 1e9, idx = 0;
            items.forEach(function (el, i) {
                var r = el.getBoundingClientRect();
                var d = Math.abs(r.top + r.height / 2 - mid);
                if (d < best) { best = d; idx = i; }
            });
            if (idx !== cur) setActive(idx);
            var lr = list.getBoundingClientRect();
            list.style.setProperty('--p', Math.max(0, Math.min(1, (mid - lr.top) / lr.height)).toFixed(4));
        }
        function onScroll() { if (!ticking) { ticking = true; requestAnimationFrame(update); } }

        items.forEach(function (el) {
            el.addEventListener('click', function () { el.scrollIntoView({ behavior: 'smooth', block: 'center' }); });
        });

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        update();
    })();
    </script>
</section>
