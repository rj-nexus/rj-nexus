@php
    $uid = 'features_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud  = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft  = $settings['hud_left'] ?? '[ 03 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ BENEFITS ]';

    $badge      = $settings['badge_text'] ?? '';
    $customCode = $settings['top_custom_code'] ?? '';
    $title      = $settings['title'] ?? '';
    $subtitle   = $settings['subtitle'] ?? '';
    $hue        = max(0, min(360, (int) ($settings['bh_hue'] ?? 215)));   // black hole / icon color

    $features = $settings['features'] ?? [];
    if (!is_array($features)) $features = [];
    $features = array_slice(array_values($features), 0, 9);
@endphp

<section class="rj-feat-section" id="{{ $uid }}" style="--h: {{ $hue }};">

    <div class="rj-feat-inner">

        @if($badge)
            <div class="rj-feat-badge">
                <span class="rj-feat-bars"><i></i><i></i><i></i></span>
                <span class="rj-feat-badge-t">{{ $badge }}</span>
                <span class="rj-feat-bars"><i></i><i></i><i></i></span>
            </div>
        @endif

        <div class="rj-feat-visual">
            @if($customCode)
                {!! $customCode !!}
            @else
                {{-- Pure-CSS black hole: back disk, event horizon, lensed arc, front disk --}}
                <div class="rj-bh" aria-hidden="true">
                    <span class="rj-bh-wave"></span>
                    <div class="rj-bh-disk is-back"><div class="rj-bh-spin"></div></div>
                    <div class="rj-bh-core"></div>
                    <div class="rj-bh-lens"></div>
                    <div class="rj-bh-disk is-front"><div class="rj-bh-spin"></div></div>
                </div>
            @endif
        </div>

        <div class="rj-feat-text">
            @if($title)<h2 class="rj-feat-title">{{ $title }}</h2>@endif
            @if($subtitle)<p class="rj-feat-sub">{{ $subtitle }}</p>@endif
        </div>

        @if(!empty($features))
            <div class="rj-feat-grid">
                @foreach($features as $i => $item)
                    <div class="rj-feat-card" style="--i: {{ $i }};">
                        <div class="rj-feat-icon">
                            <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                        </div>
                        <span class="rj-feat-num">[ {{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }} ]</span>
                        <h3 class="rj-feat-card-title">{{ $item['feature_title'] ?? '' }}</h3>
                        <p class="rj-feat-card-desc">{{ $item['feature_text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Line, + marks and HUD only at the bottom --}}
    @if($showHud)
        <div class="rj-feat-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-feat-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif
    <span class="rj-feat-line"><i></i><i></i></span>

    <style>
        #{{ $uid }}.rj-feat-section {
            --bh: clamp(190px, 26vw, 300px);
            position: relative; width: 100%; overflow: hidden; background: transparent; color: #fff;
            padding: 120px 24px 130px; display: flex; justify-content: center;
        }
        #{{ $uid }} .rj-feat-inner {
            position: relative; z-index: 1; max-width: var(--rj-container, 1200px); width: 100%; margin: 0 auto;
            display: flex; flex-direction: column; align-items: center;
        }

        /* Badge */
        #{{ $uid }} .rj-feat-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 36px; }
        #{{ $uid }} .rj-feat-bars { display: inline-flex; align-items: center; gap: 3px; height: 15px; }
        #{{ $uid }} .rj-feat-bars i { width: 3px; height: 100%; background: #fff; animation: rjFeatBar 1.4s ease-in-out infinite; }
        #{{ $uid }} .rj-feat-bars i:nth-child(2) { animation-delay: .18s; }
        #{{ $uid }} .rj-feat-bars i:nth-child(3) { animation-delay: .36s; }
        #{{ $uid }} .rj-feat-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-feat-badge-t {
            font: 700 12px/1.4 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .1em; text-transform: uppercase; color: #fff;
        }
        @keyframes rjFeatBar { 0%, 100% { transform: scaleY(.3); opacity: .45; } 50% { transform: scaleY(1); opacity: 1; } }

        /* ---------- Black hole ---------- */
        #{{ $uid }} .rj-feat-visual { display: flex; justify-content: center; align-items: center; width: 100%; min-height: calc(var(--bh) * 1.25); margin-bottom: 40px; }
        #{{ $uid }} .rj-bh { position: relative; width: var(--bh); aspect-ratio: 1; animation: rjBhBreath 9s ease-in-out infinite; }
        #{{ $uid }} .rj-bh::before { /* soft halo */
            content: ''; position: absolute; inset: -80%; z-index: 0;
            background: radial-gradient(closest-side, hsl(var(--h) 95% 55% / .26), hsl(var(--h) 90% 45% / .08) 55%, transparent 100%);
        }
        #{{ $uid }} .rj-bh::after, #{{ $uid }} .rj-bh-wave { /* gravitational ripples */
            content: ''; position: absolute; inset: -6%; z-index: 0; border-radius: 50%;
            border: 1px solid hsl(var(--h) 90% 75% / .4); animation: rjBhWave 7s ease-out infinite;
        }
        #{{ $uid }} .rj-bh-wave { animation-delay: 3.5s; }

        /* accretion disk (tilted plane); back half behind the hole, front half in front */
        #{{ $uid }} .rj-bh-disk {
            position: absolute; inset: -55%; border-radius: 50%;
            transform: rotateZ(-12deg) rotateX(76deg);
            -webkit-mask-image: radial-gradient(closest-side, transparent 50%, #000 58%, #000 70%, transparent 100%);
                    mask-image: radial-gradient(closest-side, transparent 50%, #000 58%, #000 70%, transparent 100%);
        }
        #{{ $uid }} .rj-bh-disk.is-back { z-index: 0; }
        #{{ $uid }} .rj-bh-disk.is-front { z-index: 3; clip-path: inset(50% 0 0 0); }
        #{{ $uid }} .rj-bh-spin {
            position: absolute; inset: 0; border-radius: 50%;
            background: conic-gradient(from 20deg,
                hsl(var(--h) 100% 96%), hsl(var(--h) 95% 70%), hsl(var(--h) 85% 45%), hsl(var(--h) 80% 20%),
                hsl(var(--h) 85% 45%), hsl(var(--h) 95% 70%), hsl(var(--h) 100% 96%));
            animation: rjBhSpin 14s linear infinite;
        }

        /* event horizon + photon ring */
        #{{ $uid }} .rj-bh-core {
            position: absolute; inset: 0; z-index: 2; border-radius: 50%; background: #000;
            box-shadow:
                0 0 0 2px hsl(var(--h) 100% 90% / .9),
                0 0 26px 4px hsl(var(--h) 100% 72% / .7),
                0 0 90px 22px hsl(var(--h) 95% 55% / .35);
        }
        /* light bent over the top of the hole */
        #{{ $uid }} .rj-bh-lens {
            position: absolute; inset: -9%; z-index: 2; border-radius: 50%; clip-path: inset(0 0 42% 0); filter: blur(1.5px);
            background: conic-gradient(from 0deg, hsl(var(--h) 100% 96%), hsl(var(--h) 90% 60%), hsl(var(--h) 100% 96%), hsl(var(--h) 90% 60%), hsl(var(--h) 100% 96%));
            -webkit-mask-image: radial-gradient(closest-side, transparent 87%, #000 92%, #000 96%, transparent 100%);
                    mask-image: radial-gradient(closest-side, transparent 87%, #000 92%, #000 96%, transparent 100%);
            animation: rjBhSpin 40s linear infinite reverse;
        }

        @keyframes rjBhSpin { to { transform: rotate(360deg); } }
        @keyframes rjBhBreath { 0%, 100% { transform: rotate(-8deg) scale(1); } 50% { transform: rotate(-8deg) scale(1.035); } }
        @keyframes rjBhWave { 0% { transform: scale(.9); opacity: .55; } 100% { transform: scale(2.1); opacity: 0; } }

        /* Text */
        #{{ $uid }} .rj-feat-text { text-align: center; max-width: 800px; margin-bottom: 72px; }
        #{{ $uid }} .rj-feat-title {
            margin: 0 0 20px; font-size: clamp(32px, 5vw, 52px); font-weight: 500; line-height: 1.12; letter-spacing: -.035em;
            background: linear-gradient(180deg, #fff 0%, hsl(var(--h) 70% 86%) 100%);
            -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 18px hsl(var(--h) 90% 60% / .28));
        }
        #{{ $uid }} .rj-feat-sub { margin: 0; font-size: clamp(16px, 1.8vw, 19px); line-height: 1.6; color: rgba(255,255,255,.68); }

        /* ---------- Cards ---------- */
        #{{ $uid }} .rj-feat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 56px 32px; width: 100%; }
        #{{ $uid }} .rj-feat-card {
            display: flex; flex-direction: column; align-items: center; text-align: center;
            transition: translate .4s cubic-bezier(.2,.8,.2,1);
        }
        #{{ $uid }} .rj-feat-card:hover { translate: 0 -6px; }
        #{{ $uid }}.rj-js .rj-feat-card { opacity: 0; transform: translateY(24px); }
        #{{ $uid }}.is-in .rj-feat-card { animation: rjFeatIn .8s cubic-bezier(.2,.8,.2,1) forwards; animation-delay: calc(var(--i) * .08s); }
        @keyframes rjFeatIn { to { opacity: 1; transform: none; } }

        #{{ $uid }} .rj-feat-icon {
            display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; margin-bottom: 22px; border-radius: 22px;
            color: hsl(var(--h) 95% 76%);
            background: linear-gradient(160deg, rgba(255,255,255,.09), rgba(255,255,255,.02));
            border: 1px solid rgba(255,255,255,.12); box-shadow: inset 0 1px 0 rgba(255,255,255,.14);
            -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px);
            transition: box-shadow .4s ease, border-color .4s ease, background .4s ease;
        }
        #{{ $uid }} .rj-feat-card:hover .rj-feat-icon {
            border-color: hsl(var(--h) 90% 70% / .55);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 0 42px hsl(var(--h) 95% 60% / .45);
            background: linear-gradient(160deg, hsl(var(--h) 90% 60% / .22), rgba(255,255,255,.03));
        }
        #{{ $uid }} .rj-feat-icon iconify-icon { display: block; font-size: 44px; }
        /* three full turns on hover */
        #{{ $uid }} .rj-feat-card:hover .rj-feat-icon iconify-icon { animation: rjIconSpin 1.5s cubic-bezier(.25,.8,.25,1) both; }
        @keyframes rjIconSpin { from { transform: rotate(0); } to { transform: rotate(1080deg); } }

        #{{ $uid }} .rj-feat-num { margin-bottom: 10px; font: 700 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; color: hsl(var(--h) 90% 78% / .8); }
        #{{ $uid }} .rj-feat-card-title { margin: 0 0 12px; font-size: 18px; font-weight: 600; color: #fff; }
        #{{ $uid }} .rj-feat-card-desc { margin: 0; max-width: 300px; font-size: 14.5px; line-height: 1.65; color: rgba(255,255,255,.62); }

        /* ---------- Bottom line + HUD ---------- */
        #{{ $uid }} .rj-feat-line { position: absolute; left: 0; right: 0; bottom: 0; height: 1px; background: rgba(255,255,255,.14); z-index: 2; }
        #{{ $uid }} .rj-feat-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-feat-line i::before, #{{ $uid }} .rj-feat-line i::after { content: ''; position: absolute; background: #fff; }
        #{{ $uid }} .rj-feat-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-feat-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-feat-line i:first-child { left: 18px; }
        #{{ $uid }} .rj-feat-line i:last-child { right: 18px; }
        #{{ $uid }} .rj-feat-hud {
            position: absolute; bottom: 22px; z-index: 3; display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .08em; color: rgba(255,255,255,.75);
        }
        #{{ $uid }} .rj-hl { left: 22px; } #{{ $uid }} .rj-hr { right: 22px; }
        #{{ $uid }} .rj-feat-hud b { display: block; width: 3px; height: 26px; background: #fff; }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-feat-grid { grid-template-columns: repeat(2, 1fr); gap: 48px 24px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-feat-section { --bh: 150px; padding: 90px 20px 110px; }
            #{{ $uid }} .rj-feat-grid { grid-template-columns: 1fr; gap: 44px; }
            #{{ $uid }} .rj-feat-bars { display: none; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;
        root.classList.add('rj-js');
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e, o) {
                if (e[0].isIntersecting) { root.classList.add('is-in'); o.disconnect(); }
            }, { threshold: 0.12 }).observe(root);
        } else {
            root.classList.add('is-in');
        }
    })();
    </script>
    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</section>
