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

    $auto   = (int) ($settings['autoplay'] ?? 6);   // seconds per step, 0 = off
    $autoOn = $auto > 0;
    $dur    = max(3, $auto);

    $steps = $settings['steps'] ?? [];
    if (!is_array($steps)) $steps = [];
    $steps = array_slice(array_values($steps), 0, 9);

    // One layout, one hue per step: only colors change
    $hues    = [195, 265, 217, 330, 160, 30, 290, 100, 350];
    $hueList = array_slice($hues, 0, max(1, count($steps)));
@endphp

<section class="rj-steps-section" id="{{ $uid }}" style="--dur: {{ $dur }}s;">

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

            {{-- LEFT: images swap in place --}}
            <div class="rj-steps-visual">
                <div class="rj-steps-visual-glow"></div>
                @foreach($steps as $index => $step)
                    @php
                        $img = $resolve($step['step_image_url'] ?? '', $step['step_image'] ?? '');
                        if (empty($img)) $img = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/step' . ($index + 1) . '.png';
                    @endphp
                    <img src="{{ $toCdn($img) }}" alt="{{ $step['step_title'] ?? '' }}"
                         class="rj-step-img {{ $index === 0 ? 'is-active' : '' }}" data-step="{{ $index }}">
                @endforeach
            </div>

            {{-- RIGHT: steps swap in place (active one opens, others collapse) --}}
            <div class="rj-steps-list">
                @foreach($steps as $index => $step)
                    <div class="rj-step-item {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
                        <button type="button" class="rj-step-head" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                            <span class="rj-step-marker"><span class="rj-step-dot"></span></span>
                            <span class="rj-step-headtext">
                                <span class="rj-step-num">STEP {{ $step['step_num'] ?? str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="rj-step-title">{{ $step['step_title'] ?? '' }}</span>
                            </span>
                        </button>
                        <div class="rj-step-collapse">
                            <div class="rj-step-body">
                                <p class="rj-step-text">{{ $step['step_text'] ?? '' }}</p>
                                @if($autoOn && count($steps) > 1)
                                    <span class="rj-step-bar"><i></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
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
        @property --rj-h { syntax: '<number>'; inherits: true; initial-value: 195; }

        #{{ $uid }}.rj-steps-section {
            --rj-h: {{ $hueList[0] }};
            --sh: min(480px, 62vh);
            position: relative; width: 100%; background: transparent; color: #fff;
            padding: 120px 24px 150px; overflow: hidden;
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
        #{{ $uid }} .rj-steps-header { text-align: center; margin-bottom: 70px; }
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

        /* Split: nothing is sticky anymore, so it cannot break */
        #{{ $uid }} .rj-steps-split { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }

        /* ---------- Images (plain, swap with a directional slide) ---------- */
        #{{ $uid }} .rj-steps-visual { --dir: 1; position: relative; height: var(--sh); display: flex; align-items: center; justify-content: center; }
        #{{ $uid }} .rj-steps-visual-glow {
            position: absolute; inset: 0; z-index: 0; pointer-events: none; filter: blur(40px);
            background: radial-gradient(circle at center, hsl(var(--rj-h) 90% 55% / .24) 0%, transparent 60%);
        }
        #{{ $uid }} .rj-step-img {
            position: absolute; inset: 0; margin: auto; z-index: 1; width: 100%; height: 100%; max-width: 440px; object-fit: contain;
            opacity: 0; visibility: hidden;
            transform: translateX(calc(var(--dir) * 70px)) scale(.92);
            filter: blur(10px) drop-shadow(0 20px 40px rgba(0,0,0,.6));
            transition: opacity .6s ease, transform .8s cubic-bezier(.2,.8,.2,1), filter .8s ease, visibility 0s linear .8s;
        }
        #{{ $uid }} .rj-step-img.is-out { transform: translateX(calc(var(--dir) * -70px)) scale(.92); }   /* leaves to the opposite side */
        #{{ $uid }} .rj-step-img.is-active {
            opacity: 1; visibility: visible; transform: none; filter: blur(0) drop-shadow(0 20px 40px rgba(0,0,0,.6)); transition-delay: 0s;
        }

        /* ---------- Steps ---------- */
        #{{ $uid }} .rj-steps-list { display: flex; flex-direction: column; gap: 14px; }
        #{{ $uid }} .rj-step-item { position: relative; }
        #{{ $uid }} .rj-step-item:not(:last-child)::before { /* connector to the next dot */
            content: ''; position: absolute; left: 11px; top: 40px; bottom: -14px; width: 2px; border-radius: 2px;
            background: rgba(255,255,255,.12); transition: background .6s ease, box-shadow .6s ease;
        }
        #{{ $uid }} .rj-step-item.is-done::before { background: hsl(var(--rj-h) 90% 65%); box-shadow: 0 0 12px hsl(var(--rj-h) 95% 60% / .6); }

        #{{ $uid }} .rj-step-head {
            display: flex; align-items: center; gap: 24px; width: 100%; min-height: 52px; padding: 0; margin: 0;
            background: none; border: 0; color: inherit; font: inherit; text-align: left; cursor: pointer;
        }
        #{{ $uid }} .rj-step-head:focus-visible { outline: 2px solid hsl(var(--rj-h) 90% 65%); outline-offset: 4px; border-radius: 8px; }
        #{{ $uid }} .rj-step-marker { position: relative; z-index: 1; width: 24px; height: 24px; flex: none; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: var(--rj-bg, #0a0a0f); }
        #{{ $uid }} .rj-step-dot {
            width: 8px; height: 8px; border-radius: 50%; background: hsl(var(--rj-h) 90% 65%); box-shadow: 0 0 12px hsl(var(--rj-h) 95% 60% / .9);
            transform: scale(.55); opacity: .55; transition: transform .4s, opacity .4s;
        }
        #{{ $uid }} .rj-step-item.is-active .rj-step-dot { transform: scale(1.7); opacity: 1; }
        #{{ $uid }} .rj-step-headtext { display: flex; flex-direction: column; gap: 8px; opacity: .42; transition: opacity .5s ease; }
        #{{ $uid }} .rj-step-head:hover .rj-step-headtext { opacity: .75; }
        #{{ $uid }} .rj-step-item.is-active .rj-step-headtext { opacity: 1; }
        #{{ $uid }} .rj-step-num { font: 700 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; color: hsl(var(--rj-h) 90% 74%); }
        #{{ $uid }} .rj-step-title { font-size: 26px; font-weight: 600; line-height: 1.15; letter-spacing: -.02em; color: #fff; }
        #{{ $uid }} .rj-step-item.is-active .rj-step-title { text-shadow: 0 0 24px hsl(var(--rj-h) 95% 60% / .4); animation: rjStIn .8s cubic-bezier(.2,.8,.2,1) both; }

        /* the text opens/closes smoothly (grid-rows trick) */
        #{{ $uid }} .rj-step-collapse { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .65s cubic-bezier(.2,.8,.2,1); }
        #{{ $uid }} .rj-step-item.is-active .rj-step-collapse { grid-template-rows: 1fr; }
        #{{ $uid }} .rj-step-body { min-height: 0; overflow: hidden; padding-left: 48px; }
        #{{ $uid }} .rj-step-text { margin: 12px 0 0; font-size: 15.5px; line-height: 1.65; color: rgba(255,255,255,.68); opacity: 0; }
        #{{ $uid }} .rj-step-item.is-active .rj-step-text { animation: rjStIn .9s cubic-bezier(.2,.8,.2,1) .15s both; }
        @keyframes rjStIn { from { opacity: 0; transform: translateY(14px); filter: blur(8px); } to { opacity: 1; transform: none; filter: blur(0); } }

        /* autoplay progress: when it ends, the next step takes over */
        #{{ $uid }} .rj-step-bar { display: block; height: 2px; margin: 18px 0 4px; border-radius: 2px; background: rgba(255,255,255,.1); overflow: hidden; }
        #{{ $uid }} .rj-step-bar i { display: block; height: 100%; width: 100%; transform: scaleX(0); transform-origin: left; background: hsl(var(--rj-h) 90% 68%); box-shadow: 0 0 10px hsl(var(--rj-h) 95% 60% / .8); }
        #{{ $uid }} .rj-step-item.is-active .rj-step-bar i { animation: rjStFill var(--dur) linear forwards; }
        #{{ $uid }}.is-paused .rj-step-bar i { animation-play-state: paused; }
        @keyframes rjStFill { to { transform: scaleX(1); } }

        /* Bottom line + HUD */
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

        @media (max-width: 968px) {
            #{{ $uid }}.rj-steps-section { --sh: min(300px, 40vh); }
            #{{ $uid }} .rj-steps-split { grid-template-columns: 1fr; gap: 36px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-steps-section { padding: 90px 20px 120px; }
            #{{ $uid }} .rj-steps-bars { display: none; }
            #{{ $uid }} .rj-steps-header { margin-bottom: 44px; }
            #{{ $uid }} .rj-step-title { font-size: 22px; }
            #{{ $uid }} .rj-step-body { padding-left: 0; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var items = Array.prototype.slice.call(root.querySelectorAll('.rj-step-item'));
        var imgs = Array.prototype.slice.call(root.querySelectorAll('.rj-step-img'));
        var visual = root.querySelector('.rj-steps-visual');
        var hues = @js($hueList);
        var n = items.length, cur = 0, inView = false, hover = false;

        function setPaused() { root.classList.toggle('is-paused', !inView || hover || document.hidden); }

        function go(i, dir) {
            if (i === cur || i < 0 || i >= n) return;
            var old = cur; cur = i;
            visual.style.setProperty('--dir', dir);

            imgs[old].classList.remove('is-active');
            imgs[old].classList.add('is-out');
            setTimeout(function () { if (old !== cur) imgs[old].classList.remove('is-out'); }, 900);
            imgs[i].classList.remove('is-out');
            imgs[i].classList.add('is-active');

            items.forEach(function (el, k) {
                el.classList.toggle('is-active', k === i);
                el.classList.toggle('is-done', k < i);
                el.querySelector('.rj-step-head').setAttribute('aria-expanded', k === i ? 'true' : 'false');
            });
            root.style.setProperty('--rj-h', hues[i % hues.length]);   // colors morph per step
        }

        items.forEach(function (el, i) {
            el.querySelector('.rj-step-head').addEventListener('click', function () { go(i, i > cur ? 1 : -1); });
            var bar = el.querySelector('.rj-step-bar i');
            if (bar) bar.addEventListener('animationend', function (e) {
                if (e.animationName === 'rjStFill' && el.classList.contains('is-active')) go((cur + 1) % n, cur + 1 >= n ? -1 : 1);
            });
        });

        // Pause the progress while off-screen, hovered or in a background tab
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e) { inView = e[0].isIntersecting; setPaused(); }, { threshold: 0.35 }).observe(root);
        } else { inView = true; }
        root.querySelector('.rj-steps-split').addEventListener('mouseenter', function () { hover = true; setPaused(); });
        root.querySelector('.rj-steps-split').addEventListener('mouseleave', function () { hover = false; setPaused(); });
        document.addEventListener('visibilitychange', setPaused);
        setPaused();
    })();
    </script>
</section>
