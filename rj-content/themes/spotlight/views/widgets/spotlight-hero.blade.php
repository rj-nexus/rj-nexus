@php
    $uid = 'hero_' . substr(md5(uniqid('', true)), 0, 8);

    // ---- Media resolver -------------------------------------------------
    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    $bgVideo = $resolve($settings['bg_video_url'] ?? '', $settings['bg_video'] ?? '')
        ?: 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    $bgImage = $resolve($settings['bg_image_url'] ?? '', $settings['bg_image'] ?? '');

    // ---- Settings -------------------------------------------------------
    $pingPong = filter_var($settings['ping_pong'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $showHud  = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);

    $overlayColor = $settings['overlay_color'] ?? '#05070d';
    $overlay      = max(0, min(100, (int) ($settings['overlay_opacity'] ?? 45)));

    // Video color grading (this is what actually recolors the video)
    $tintColor   = $settings['tint_color'] ?? '';            // e.g. #1d4ed8
    $tintOpacity = max(0, min(100, (int) ($settings['tint_opacity'] ?? 60)));
    $tintBlend   = $settings['tint_blend'] ?? 'color';       // color | hue | multiply | overlay | soft-light
    $hueRotate   = (int) ($settings['hue_rotate'] ?? 0);     // degrees
    $saturate    = (int) ($settings['saturate'] ?? 100);     // %
    $brightness  = (int) ($settings['brightness'] ?? 100);   // %
    $contrast    = (int) ($settings['contrast'] ?? 100);     // %

    $mediaFilter = "hue-rotate({$hueRotate}deg) saturate({$saturate}%) brightness({$brightness}%) contrast({$contrast}%)";

    $badge    = $settings['badge_text'] ?? '';
    $title    = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $hudLeft  = $settings['hud_left'] ?? '[ 01 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ HERO ]';

    $btn1Text = $settings['primary_btn_text'] ?? '';
    $btn1Url  = $settings['primary_btn_url'] ?? '#';
    $btn2Text = $settings['secondary_btn_text'] ?? '';
    $btn2Url  = $settings['secondary_btn_url'] ?? '#';
@endphp

<section class="rj-cine-hero" id="{{ $uid }}">
    <div class="rj-cine-bg">
        @if($bgVideo)
            <video id="{{ $uid }}_video" src="{{ $bgVideo }}" autoplay loop muted playsinline preload="auto"
                   class="rj-cine-media" style="filter: {{ $mediaFilter }};"
                   @if($bgImage) poster="{{ $bgImage }}" @endif
                   data-ping-pong="{{ $pingPong ? 'true' : 'false' }}"></video>
        @elseif($bgImage)
            <img src="{{ $bgImage }}" alt="{{ $title }}" class="rj-cine-media" style="filter: {{ $mediaFilter }};">
        @else
            <div class="rj-cine-media rj-cine-fallback"></div>
        @endif

        @if($tintColor)
            <div class="rj-cine-tint" style="background: {{ $tintColor }}; mix-blend-mode: {{ $tintBlend }}; opacity: {{ $tintOpacity / 100 }};"></div>
        @endif

        <div class="rj-cine-overlay" style="background-color: {{ $overlayColor }}; opacity: {{ $overlay / 100 }};"></div>
        <div class="rj-cine-vignette"></div>
        <div class="rj-cine-dots"></div>
    </div>

    {{-- Fine grid lines + corner marks --}}
    <div class="rj-cine-grid-lines" aria-hidden="true">
        <span class="rj-cine-line-h rj-line-top"><i></i><i></i></span>
        <span class="rj-cine-line-h rj-line-bottom"><i></i><i></i></span>
    </div>

    @if($showHud)
        <div class="rj-cine-hud rj-hud-left" aria-hidden="true"><span class="rj-hud-bar"></span>{{ $hudLeft }}</div>
        <div class="rj-cine-hud rj-hud-right" aria-hidden="true">{{ $hudRight }}<span class="rj-hud-bar"></span></div>
    @endif

    <div class="rj-cine-content">
        @if($badge)
            <div class="rj-cine-badge-wrap">
                <span class="rj-cine-bars"><i></i><i></i><i></i></span>
                <span class="rj-cine-badge-text">{{ $badge }}</span>
                <span class="rj-cine-bars"><i></i><i></i><i></i></span>
            </div>
        @endif

        @if($title)
            <h1 class="rj-cine-title">{{ $title }}</h1>
        @endif

        @if($subtitle)
            <p class="rj-cine-subtitle">{{ $subtitle }}</p>
        @endif

        @if($btn1Text || $btn2Text)
            <div class="rj-cine-actions">
                @if($btn1Text)
                    <a href="{{ $btn1Url }}" class="rj-cine-btn rj-cine-btn-primary">
                        {{ $btn1Text }}
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @endif
                @if($btn2Text)
                    <a href="{{ $btn2Url }}" class="rj-cine-btn rj-cine-btn-secondary">{{ $btn2Text }}</a>
                @endif
            </div>
        @endif
    </div>

    <div class="rj-cine-scroll" aria-hidden="true">
        <span class="rj-cine-scroll-text">SCROLL</span>
        <span class="rj-cine-scroll-line"></span>
    </div>

    <script>
    (function () {
        var video = document.getElementById(@js($uid) + '_video');
        if (!video) return;

        // Respect reduced motion
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            video.removeAttribute('autoplay');
            video.pause();
            return;
        }

        // Pause when off-screen (saves CPU/GPU)
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { var p = video.play(); if (p) p.catch(function () {}); }
                    else video.pause();
                });
            }, { threshold: 0.05 }).observe(video);
        }

        if (video.getAttribute('data-ping-pong') !== 'true') return;

        // Ping-pong (reverse playback via seeking; heavier, off by default)
        video.removeAttribute('loop');
        var reversing = false, last = 0;

        function step(ts) {
            if (!reversing) return;
            if (!last) last = ts;
            var d = (ts - last) / 1000; last = ts;
            if (video.currentTime - d > 0.05) {
                video.currentTime -= d;
                requestAnimationFrame(step);
            } else {
                video.currentTime = 0; reversing = false; video.play();
            }
        }
        video.addEventListener('ended', function () {
            if (reversing) return;
            reversing = true; video.pause(); last = 0;
            requestAnimationFrame(step);
        });
    })();
    </script>

    <style>
        #{{ $uid }}.rj-cine-hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--rj-bg, #05070d);
            overflow: hidden;
            isolation: isolate;
        }
        #{{ $uid }} .rj-cine-bg { position: absolute; inset: 0; z-index: 0; isolation: isolate; }
        #{{ $uid }} .rj-cine-media {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover; object-position: center;
            transform: translateZ(0);
        }
        #{{ $uid }} .rj-cine-fallback {
            background: radial-gradient(circle at 50% 40%, color-mix(in srgb, var(--rj-primary, #3b82f6) 25%, var(--rj-bg, #05070d)) 0%, var(--rj-bg, #05070d) 70%);
        }
        #{{ $uid }} .rj-cine-tint,
        #{{ $uid }} .rj-cine-overlay { position: absolute; inset: 0; pointer-events: none; }
        #{{ $uid }} .rj-cine-vignette {
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse at center, transparent 45%, rgba(0,0,0,.55) 100%),
                linear-gradient(to bottom, rgba(0,0,0,.55) 0%, transparent 22%, transparent 70%, rgba(0,0,0,.65) 100%);
        }
        #{{ $uid }} .rj-cine-dots {
            position: absolute; inset: 0; pointer-events: none; opacity: .35;
            background-image: radial-gradient(rgba(255,255,255,.18) 1px, transparent 1px);
            background-size: 4px 4px;
            mix-blend-mode: overlay;
        }

        /* Grid lines */
        #{{ $uid }} .rj-cine-grid-lines { position: absolute; inset: 0; z-index: 1; pointer-events: none; }
        #{{ $uid }} .rj-cine-line-h {
            position: absolute; left: 0; right: 0; height: 1px;
            background: rgba(255,255,255,.12);
        }
        #{{ $uid }} .rj-line-top { top: 190px; }
        #{{ $uid }} .rj-line-bottom { bottom: 120px; }
        #{{ $uid }} .rj-cine-line-h i {
            position: absolute; top: -5px; width: 11px; height: 11px;
        }
        #{{ $uid }} .rj-cine-line-h i::before,
        #{{ $uid }} .rj-cine-line-h i::after { content: ""; position: absolute; background: rgba(255,255,255,.85); }
        #{{ $uid }} .rj-cine-line-h i::before { left: 0; right: 0; top: 5px; height: 1px; }
        #{{ $uid }} .rj-cine-line-h i::after  { top: 0; bottom: 0; left: 5px; width: 1px; }
        #{{ $uid }} .rj-cine-line-h i:first-child { left: 16px; }
        #{{ $uid }} .rj-cine-line-h i:last-child  { right: 16px; }

        /* HUD */
        #{{ $uid }} .rj-cine-hud {
            position: absolute; top: 20px; z-index: 2;
            display: flex; align-items: center; gap: 14px;
            font: 600 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .08em; color: rgba(255,255,255,.85);
        }
        #{{ $uid }} .rj-hud-left { left: 24px; }
        #{{ $uid }} .rj-hud-right { right: 24px; }
        #{{ $uid }} .rj-hud-bar { display: block; width: 2px; height: 28px; background: #fff; }

        /* Content */
        #{{ $uid }} .rj-cine-content {
            position: relative; z-index: 2;
            text-align: center; max-width: 1080px;
            padding: 140px 24px 120px;
            display: flex; flex-direction: column; align-items: center;
        }
        #{{ $uid }} .rj-cine-badge-wrap {
            display: inline-flex; align-items: center; gap: 14px; margin-bottom: 36px;
            animation: rjCineIn .9s cubic-bezier(.2,.8,.2,1) .05s both;
        }
        #{{ $uid }} .rj-cine-bars { display: inline-flex; gap: 3px; height: 14px; }
        #{{ $uid }} .rj-cine-bars i { display: block; width: 2px; background: rgba(255,255,255,.9); }
        #{{ $uid }} .rj-cine-bars i:nth-child(3) { opacity: .4; }
        #{{ $uid }} .rj-cine-badge-wrap .rj-cine-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-cine-badge-text {
            font: 600 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.92);
        }
        #{{ $uid }} .rj-cine-title {
            font-size: clamp(44px, 7vw, 92px);
            line-height: 1.04; font-weight: 500; letter-spacing: -.04em;
            margin: 0 0 24px; text-wrap: balance;
            background: linear-gradient(180deg, #fff 0%, rgba(255,255,255,.82) 100%);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: rjCineIn 1s cubic-bezier(.2,.8,.2,1) .15s both;
        }
        #{{ $uid }} .rj-cine-subtitle {
            font-size: clamp(16px, 1.8vw, 20px); line-height: 1.6;
            color: rgba(255,255,255,.72); margin: 0 0 44px; max-width: 680px; text-wrap: pretty;
            animation: rjCineIn 1s cubic-bezier(.2,.8,.2,1) .28s both;
        }
        #{{ $uid }} .rj-cine-actions {
            display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap;
            animation: rjCineIn 1s cubic-bezier(.2,.8,.2,1) .4s both;
        }
        #{{ $uid }} .rj-cine-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            padding: 15px 30px; font-size: 15px; font-weight: 500; text-decoration: none;
            border-radius: 10px; transition: transform .25s, background .25s, border-color .25s, box-shadow .25s;
        }
        #{{ $uid }} .rj-cine-btn svg { width: 18px; height: 18px; transition: transform .25s; }
        #{{ $uid }} .rj-cine-btn-primary { background: #fff; color: #000; border: 1px solid #fff; }
        #{{ $uid }} .rj-cine-btn-primary:hover {
            background: var(--rj-primary, #3b82f6); border-color: var(--rj-primary, #3b82f6); color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 28px color-mix(in srgb, var(--rj-primary, #3b82f6) 45%, transparent);
        }
        #{{ $uid }} .rj-cine-btn-primary:hover svg { transform: translateX(4px); }
        #{{ $uid }} .rj-cine-btn-secondary {
            background: rgba(255,255,255,.06); color: #fff;
            border: 1px solid rgba(255,255,255,.18); backdrop-filter: blur(12px);
        }
        #{{ $uid }} .rj-cine-btn-secondary:hover {
            background: rgba(255,255,255,.14); border-color: rgba(255,255,255,.35); transform: translateY(-2px);
        }

        #{{ $uid }} .rj-cine-scroll {
            position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%); z-index: 2;
            display: flex; flex-direction: column; align-items: center; gap: 10px; opacity: .55;
        }
        #{{ $uid }} .rj-cine-scroll-text {
            font: 700 10px/1 ui-monospace, Menlo, Consolas, monospace; letter-spacing: .2em; color: #fff;
        }
        #{{ $uid }} .rj-cine-scroll-line {
            display: block; width: 1px; height: 36px;
            background: linear-gradient(to bottom, #fff, transparent);
            animation: rjCineScroll 2s infinite;
        }

        @keyframes rjCineIn {
            from { opacity: 0; transform: translateY(24px); filter: blur(8px); }
            to   { opacity: 1; transform: none; filter: blur(0); }
        }
        @keyframes rjCineScroll {
            0%   { transform: scaleY(0); transform-origin: top; }
            50%  { transform: scaleY(1); transform-origin: top; }
            50.1%{ transform: scaleY(1); transform-origin: bottom; }
            100% { transform: scaleY(0); transform-origin: bottom; }
        }

        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} * { animation: none !important; }
        }
        @media (max-width: 768px) {
            #{{ $uid }} .rj-line-top { top: 110px; }
            #{{ $uid }} .rj-line-bottom { bottom: 80px; }
            #{{ $uid }} .rj-cine-content { padding: 120px 20px 100px; }
            #{{ $uid }} .rj-cine-actions { flex-direction: column; width: 100%; }
            #{{ $uid }} .rj-cine-btn { width: 100%; }
            #{{ $uid }} .rj-cine-scroll { display: none; }
        }
    </style>
</section>
