@php
    $uid = $uid ?? ('vs_' . substr(md5(uniqid('', true)), 0, 8));

    $title     = $settings['title'] ?? '';
    $subtitle  = $settings['subtitle'] ?? '';
    $badge     = $settings['badge_text'] ?? '';
    $videoUrl  = $settings['video_url'] ?? '';
    $cover     = $settings['cover_image'] ?? '';
    $playLabel = $settings['play_label'] ?? 'Watch the video';
    $accent    = !empty($settings['accent_color']) ? $settings['accent_color'] : '#8b5cf6';
    $siteUrl   = function_exists('rj_get_option') ? rj_get_option('site_url', 'rjnexus.org') : 'rjnexus.org';
@endphp

<section class="rj-vs" id="{{ $uid }}" style="--ac: {{ $accent }};">

    {{-- Spiral galaxy behind the frame. Every edge fades out, nothing is clipped. --}}
    <div class="rj-vs-galaxy" aria-hidden="true">
        <div class="rj-vs-tilt">
            <span class="rj-vs-spiral"></span>
            <span class="rj-vs-core"></span>
        </div>
    </div>

    <div class="rj-vs-inner">

        @if($badge || $title || $subtitle)
            <header class="rj-vs-header">
                @if($badge)
                    <div class="rj-vs-badge">
                        <span class="rj-vs-bars"><i></i><i></i><i></i></span>
                        <span class="rj-vs-badge-t">{{ $badge }}</span>
                        <span class="rj-vs-bars"><i></i><i></i><i></i></span>
                    </div>
                @endif
                @if($title)<h2 class="rj-vs-title">{{ $title }}</h2>@endif
                @if($subtitle)<p class="rj-vs-sub">{{ $subtitle }}</p>@endif
            </header>
        @endif

        <div class="rj-vs-frame">

            <div class="rj-vs-bar">
                <span class="rj-vs-dots"><i></i><i></i><i></i></span>
                <span class="rj-vs-url">https://{{ $siteUrl }}</span>
                <span class="rj-vs-dots rj-vs-dots-end"><i></i></span>
            </div>

            <div class="rj-vs-stage" data-stage data-video-url="{{ $videoUrl }}">
                <div class="rj-vs-neb"></div>
                @if($cover)
                    <img class="rj-vs-img" src="{{ $cover }}" alt="" loading="lazy" decoding="async">
                @endif

                <div class="rj-vs-stars rj-vs-stars-far"></div>
                <div class="rj-vs-stars rj-vs-stars-near"></div>
                <span class="rj-vs-shoot s1"></span>
                <span class="rj-vs-shoot s2"></span>

                <div class="rj-vs-vig"></div>
                <div class="rj-vs-corners"><i></i><i></i><i></i><i></i></div>
                <div class="rj-vs-spot" data-spot></div>

                <button type="button" class="rj-vs-play" data-play aria-label="{{ $playLabel }}">
                    <span class="rj-vs-orbits" aria-hidden="true">
                        <span class="rj-vs-tilt-a"><i class="rj-o rj-o1"></i></span>
                        <span class="rj-vs-tilt-b"><i class="rj-o rj-o2"></i></span>
                    </span>
                    <span class="rj-vs-ripple"></span>
                    <span class="rj-vs-ripple r2"></span>
                    <span class="rj-vs-disc">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5.2v13.6a.6.6 0 00.9.5l11-6.8a.6.6 0 000-1l-11-6.8a.6.6 0 00-.9.5z"/></svg>
                    </span>
                </button>
                @if($playLabel)<span class="rj-vs-label" aria-hidden="true">{{ $playLabel }}</span>@endif
            </div>
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-vs {
            position: relative; width: 100%; background: transparent; color: #fff;
            padding: 120px 24px 120px;
            overflow-x: clip; overflow-y: visible;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        #{{ $uid }} .rj-vs-inner { position: relative; z-index: 1; max-width: 1040px; margin: 0 auto; }

        /* ===== Galaxy ===== */
        #{{ $uid }} .rj-vs-galaxy {
            position: absolute; left: 50%; top: 64%; width: min(1300px, 140vw); translate: -50% -50%;
            pointer-events: none; z-index: 0; opacity: 0; transition: opacity 2s ease;
        }
        #{{ $uid }}.is-in .rj-vs-galaxy { opacity: 1; }
        #{{ $uid }} .rj-vs-tilt { position: relative; transform: perspective(1000px) rotateX(64deg); }
        #{{ $uid }} .rj-vs-spiral {
            display: block; width: 100%; aspect-ratio: 1 / 1; border-radius: 50%;
            background: conic-gradient(from 0deg,
                rgba(0,0,0,0) 0deg,
                color-mix(in srgb, var(--ac) 46%, transparent) 40deg,
                rgba(99,102,241,0) 85deg,
                rgba(59,130,246,.34) 130deg,
                rgba(0,0,0,0) 175deg,
                color-mix(in srgb, var(--ac) 46%, transparent) 220deg,
                rgba(0,0,0,0) 265deg,
                rgba(236,72,153,.2) 310deg,
                rgba(0,0,0,0) 360deg);
            -webkit-mask-image: radial-gradient(circle, #000 0%, rgba(0,0,0,.85) 26%, rgba(0,0,0,.35) 50%, transparent 70%);
                    mask-image: radial-gradient(circle, #000 0%, rgba(0,0,0,.85) 26%, rgba(0,0,0,.35) 50%, transparent 70%);
            will-change: transform; animation: rjVsGal 150s linear infinite;
        }
        #{{ $uid }} .rj-vs-core {
            position: absolute; left: 50%; top: 50%; width: 26%; aspect-ratio: 1 / 1; translate: -50% -50%; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,244,255,.6) 0%, color-mix(in srgb, var(--ac) 40%, transparent) 36%, rgba(0,0,0,0) 70%);
        }
        @keyframes rjVsGal { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* ===== Header ===== */
        #{{ $uid }} .rj-vs-header { display: flex; flex-direction: column; align-items: center; text-align: center; max-width: 660px; margin: 0 auto 56px; }
        #{{ $uid }} .rj-vs-badge {
            display: inline-flex; align-items: center; gap: 12px; margin-bottom: 24px; padding: 8px 16px; border-radius: 999px;
            background: rgba(255,255,255,.06); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.16), inset 0 1px 0 rgba(255,255,255,.14);
            -webkit-backdrop-filter: blur(20px) saturate(180%); backdrop-filter: blur(20px) saturate(180%);
        }
        #{{ $uid }} .rj-vs-bars { display: inline-flex; gap: 3px; height: 10px; align-items: center; }
        #{{ $uid }} .rj-vs-bars i { width: 2px; height: 100%; background: rgba(255,255,255,.55); }
        #{{ $uid }} .rj-vs-bars i:nth-child(2) { height: 60%; }
        #{{ $uid }} .rj-vs-bars i:nth-child(3) { height: 30%; }
        #{{ $uid }} .rj-vs-bars:last-child { flex-direction: row-reverse; }
        #{{ $uid }} .rj-vs-badge-t { font: 600 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.78); }
        #{{ $uid }} .rj-vs-title {
            margin: 0 0 16px; font-size: clamp(32px, 5vw, 54px); font-weight: 600; line-height: 1.08; letter-spacing: -.04em; color: #fff;
            background: linear-gradient(180deg, #fff 35%, rgba(205,200,255,.8)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
        }
        #{{ $uid }} .rj-vs-sub { margin: 0; font-size: clamp(16px, 1.8vw, 18px); line-height: 1.6; color: rgba(255,255,255,.6); }

        /* ===== Frame (a window into space) ===== */
        #{{ $uid }} .rj-vs-frame {
            position: relative; overflow: hidden; isolation: isolate; border-radius: 28px; background: #05060d;
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.2), inset 0 1px 0 rgba(255,255,255,.26);
            opacity: 0; transform: translateY(22px) scale(.985);
            transition: opacity 1s cubic-bezier(.32,.72,0,1), transform 1s cubic-bezier(.32,.72,0,1);
        }
        #{{ $uid }}.is-in .rj-vs-frame { opacity: 1; transform: none; }
        #{{ $uid }} .rj-vs-frame::after { /* hairline above the content */
            content: ""; position: absolute; inset: 0; z-index: 6; border-radius: inherit; pointer-events: none;
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.2), inset 0 1px 0 rgba(255,255,255,.26);
        }

        #{{ $uid }} .rj-vs-bar {
            position: relative; z-index: 5; height: 44px; padding: 0 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: linear-gradient(180deg, rgba(255,255,255,.09), rgba(255,255,255,.04));
            box-shadow: inset 0 -.5px 0 rgba(255,255,255,.12);
        }
        #{{ $uid }} .rj-vs-dots { display: inline-flex; gap: 7px; width: 54px; }
        #{{ $uid }} .rj-vs-dots i { width: 9px; height: 9px; border-radius: 50%; background: rgba(255,255,255,.28); }
        #{{ $uid }} .rj-vs-dots-end { justify-content: flex-end; }
        #{{ $uid }} .rj-vs-url {
            flex: 1; max-width: 360px; height: 26px; display: flex; align-items: center; justify-content: center; border-radius: 999px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
            font: 500 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .02em; color: rgba(255,255,255,.55);
            background: rgba(0,0,0,.28); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.1);
        }

        /* ===== Stage ===== */
        #{{ $uid }} .rj-vs-stage { position: relative; width: 100%; aspect-ratio: 16 / 9; overflow: hidden; cursor: pointer; --mx: 0; --my: 0; }
        #{{ $uid }} .rj-vs-neb {
            position: absolute; inset: -8%; z-index: 0;
            background:
                radial-gradient(ellipse 50% 60% at 24% 34%, color-mix(in srgb, var(--ac) 42%, transparent), transparent 70%),
                radial-gradient(ellipse 46% 56% at 78% 64%, rgba(59,130,246,.3), transparent 70%),
                radial-gradient(ellipse 30% 40% at 56% 18%, rgba(236,72,153,.16), transparent 70%),
                #05060d;
            translate: calc(var(--mx) * -6px) calc(var(--my) * -5px); transition: translate .6s ease-out;
        }
        #{{ $uid }} .rj-vs-img {
            position: absolute; inset: 0; z-index: 1; width: 100%; height: 100%; object-fit: cover; opacity: .82;
            transition: transform 1.2s cubic-bezier(.16,1,.3,1), opacity .6s ease;
        }
        #{{ $uid }} .rj-vs-stage:hover .rj-vs-img { transform: scale(1.035); opacity: .92; }

        /* stars: tiled gradients, two depths (cheap, no extra elements) */
        #{{ $uid }} .rj-vs-stars { position: absolute; inset: -24px; z-index: 2; pointer-events: none; transition: translate .6s ease-out; }
        #{{ $uid }} .rj-vs-stars-far {
            background-image:
                radial-gradient(1px 1px at 14px 22px, rgba(255,255,255,.85), transparent),
                radial-gradient(1px 1px at 78px 120px, rgba(255,255,255,.6), transparent),
                radial-gradient(1px 1px at 142px 52px, rgba(255,255,255,.75), transparent),
                radial-gradient(1px 1px at 190px 160px, rgba(255,255,255,.55), transparent),
                radial-gradient(1px 1px at 46px 176px, rgba(255,255,255,.7), transparent),
                radial-gradient(1px 1px at 214px 94px, rgba(255,255,255,.6), transparent);
            background-size: 233px 197px;
            translate: calc(var(--mx) * -10px) calc(var(--my) * -8px);
            animation: rjVsTw 6s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-vs-stars-near {
            background-image:
                radial-gradient(1.6px 1.6px at 60px 40px, rgba(255,255,255,.95), transparent),
                radial-gradient(1.4px 1.4px at 210px 130px, rgba(220,210,255,.9), transparent),
                radial-gradient(1.8px 1.8px at 120px 230px, rgba(255,255,255,.9), transparent),
                radial-gradient(1.4px 1.4px at 290px 250px, rgba(255,235,255,.85), transparent);
            background-size: 331px 283px;
            translate: calc(var(--mx) * -22px) calc(var(--my) * -16px);
            animation: rjVsTw 9s ease-in-out 1.5s infinite alternate;
        }
        @keyframes rjVsTw { from { opacity: .45; } to { opacity: 1; } }

        /* shooting stars (rare, clipped by the stage) */
        #{{ $uid }} .rj-vs-shoot {
            position: absolute; z-index: 2; top: 16%; left: -12%; width: 130px; height: 1.5px; opacity: 0; pointer-events: none;
            background: linear-gradient(90deg, rgba(255,255,255,0), #fff);
            animation: rjVsShoot 11s linear infinite;
        }
        #{{ $uid }} .rj-vs-shoot.s2 { top: 52%; animation-delay: 5.5s; animation-duration: 13s; }
        @keyframes rjVsShoot {
            0%   { transform: translate3d(0, 0, 0) rotate(18deg); opacity: 0; }
            2%   { opacity: 1; }
            9%   { transform: translate3d(620px, 200px, 0) rotate(18deg); opacity: 0; }
            100% { transform: translate3d(620px, 200px, 0) rotate(18deg); opacity: 0; }
        }

        #{{ $uid }} .rj-vs-vig {
            position: absolute; inset: 0; z-index: 3; pointer-events: none;
            background:
                radial-gradient(ellipse at 50% 50%, rgba(0,0,0,0) 52%, rgba(0,0,0,.6) 100%),
                linear-gradient(180deg, rgba(0,0,0,.22), rgba(0,0,0,0) 28%, rgba(0,0,0,0) 68%, rgba(0,0,0,.42));
        }
        #{{ $uid }} .rj-vs-corners { position: absolute; inset: 16px; z-index: 4; pointer-events: none; }
        #{{ $uid }} .rj-vs-corners i { position: absolute; width: 18px; height: 18px; border: 0 solid rgba(255,255,255,.55); }
        #{{ $uid }} .rj-vs-corners i:nth-child(1) { top: 0; left: 0; border-width: 1px 0 0 1px; }
        #{{ $uid }} .rj-vs-corners i:nth-child(2) { top: 0; right: 0; border-width: 1px 1px 0 0; }
        #{{ $uid }} .rj-vs-corners i:nth-child(3) { bottom: 0; left: 0; border-width: 0 0 1px 1px; }
        #{{ $uid }} .rj-vs-corners i:nth-child(4) { bottom: 0; right: 0; border-width: 0 1px 1px 0; }

        /* cursor light: a fixed-size glow moved with transform (no repaint) */
        #{{ $uid }} .rj-vs-spot {
            position: absolute; left: 0; top: 0; z-index: 3; width: 460px; height: 460px; border-radius: 50%; pointer-events: none; opacity: 0; transition: opacity .5s ease;
            translate: calc(var(--sx, 50%) - 230px) calc(var(--sy, 50%) - 230px); will-change: translate;
            background: radial-gradient(circle, color-mix(in srgb, var(--ac) 30%, transparent), rgba(0,0,0,0) 65%);
        }
        #{{ $uid }} .rj-vs-stage:hover .rj-vs-spot { opacity: 1; }

        /* ===== Play button with orbiting planets ===== */
        #{{ $uid }} .rj-vs-play {
            position: absolute; z-index: 5; left: 50%; top: 50%; width: 92px; height: 92px; margin: -58px 0 0 -46px; padding: 0; border: 0; background: none; cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        #{{ $uid }} .rj-vs-play:focus-visible { outline: 2px solid rgba(255,255,255,.8); outline-offset: 10px; border-radius: 50%; }
        #{{ $uid }} .rj-vs-orbits { position: absolute; inset: -68px; pointer-events: none; transition: transform .8s cubic-bezier(.32,.72,0,1); }
        #{{ $uid }} .rj-vs-play:hover .rj-vs-orbits { transform: scale(1.12); }
        #{{ $uid }} .rj-vs-tilt-a, #{{ $uid }} .rj-vs-tilt-b { position: absolute; inset: 0; }
        #{{ $uid }} .rj-vs-tilt-a { transform: perspective(700px) rotateX(70deg) rotateZ(-16deg); }
        #{{ $uid }} .rj-vs-tilt-b { inset: 16px; transform: perspective(700px) rotateX(74deg) rotateZ(40deg); }
        #{{ $uid }} .rj-o { position: absolute; inset: 0; border-radius: 50%; border: 1px solid rgba(255,255,255,.22); will-change: transform; }
        #{{ $uid }} .rj-o::after { content: ""; position: absolute; top: -4px; left: 50%; width: 8px; height: 8px; margin-left: -4px; border-radius: 50%; background: #fff; box-shadow: 0 0 10px 2px rgba(255,255,255,.7); }
        #{{ $uid }} .rj-o1 { animation: rjVsRot 16s linear infinite; }
        #{{ $uid }} .rj-o2 { border-color: color-mix(in srgb, var(--ac) 55%, rgba(255,255,255,.2)); animation: rjVsRot 24s linear infinite reverse; }
        #{{ $uid }} .rj-o2::after { top: -3px; width: 6px; height: 6px; margin-left: -3px; background: color-mix(in srgb, var(--ac) 40%, #fff); box-shadow: 0 0 10px 2px color-mix(in srgb, var(--ac) 80%, transparent); }
        @keyframes rjVsRot { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        #{{ $uid }} .rj-vs-ripple { position: absolute; inset: 0; border-radius: 50%; border: 1px solid rgba(255,255,255,.4); opacity: 0; animation: rjVsRip 3.4s cubic-bezier(.2,.6,.3,1) infinite; pointer-events: none; }
        #{{ $uid }} .rj-vs-ripple.r2 { animation-delay: 1.7s; }
        @keyframes rjVsRip { 0% { transform: scale(1); opacity: .6; } 100% { transform: scale(2.3); opacity: 0; } }

        #{{ $uid }} .rj-vs-disc {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff;
            background: rgba(255,255,255,.12);
            -webkit-backdrop-filter: blur(14px) saturate(170%); backdrop-filter: blur(14px) saturate(170%);
            box-shadow: inset 0 0 0 .5px rgba(255,255,255,.34), inset 0 1px 0 rgba(255,255,255,.46);
            transition: transform .6s cubic-bezier(.32,.72,0,1), background .4s ease;
        }
        #{{ $uid }} .rj-vs-disc svg { width: 32px; height: 32px; margin-left: 4px; }
        #{{ $uid }} .rj-vs-play:hover .rj-vs-disc { transform: scale(1.08); background: color-mix(in srgb, var(--ac) 50%, rgba(255,255,255,.1)); }
        #{{ $uid }} .rj-vs-play:active .rj-vs-disc { transform: scale(.96); }

        #{{ $uid }} .rj-vs-label {
            position: absolute; z-index: 5; left: 0; right: 0; top: calc(50% + 66px); text-align: center; pointer-events: none;
            font: 600 11px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; letter-spacing: .18em; text-transform: uppercase; color: rgba(255,255,255,.72);
        }

        #{{ $uid }}.rj-idle *, #{{ $uid }}.rj-idle *::before, #{{ $uid }}.rj-idle *::after { animation-play-state: paused !important; }

        /* ===== Lightbox: warp jump ===== */
        #{{ $uid }}-lightbox {
            position: fixed; inset: 0; z-index: 999999; display: flex; align-items: center; justify-content: center; overflow: hidden;
            background: rgba(3,4,10,.86);
            -webkit-backdrop-filter: blur(18px) saturate(140%); backdrop-filter: blur(18px) saturate(140%);
            opacity: 0; visibility: hidden; transition: opacity .4s ease, visibility 0s linear .4s;
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Text", "Inter", "Segoe UI", system-ui, sans-serif;
        }
        #{{ $uid }}-lightbox.is-open { opacity: 1; visibility: visible; transition: opacity .4s ease; }
        #{{ $uid }}-lightbox .rj-vs-warp {
            position: absolute; left: 50%; top: 50%; width: 150vmax; height: 150vmax; margin: -75vmax 0 0 -75vmax; border-radius: 50%; pointer-events: none; opacity: 0;
            background: repeating-conic-gradient(from 0deg, rgba(255,255,255,.85) 0deg .35deg, rgba(255,255,255,0) .35deg 2.6deg);
            -webkit-mask-image: radial-gradient(circle, transparent 6%, #000 14%, #000 40%, transparent 62%);
                    mask-image: radial-gradient(circle, transparent 6%, #000 14%, #000 40%, transparent 62%);
        }
        #{{ $uid }}-lightbox .rj-vs-wrap {
            position: relative; z-index: 2; width: min(92vw, 1180px, calc(86vh * 16 / 9)); aspect-ratio: 16 / 9; border-radius: 22px; overflow: hidden; background: #000;
            box-shadow: 0 0 0 .5px rgba(255,255,255,.22);
            opacity: 0; transform: scale(.9); transition: opacity .5s ease, transform .8s cubic-bezier(.32,.72,0,1);
        }
        #{{ $uid }}-lightbox.is-open .rj-vs-wrap { opacity: 1; transform: none; transition-delay: .3s; }
        #{{ $uid }}-lightbox .rj-vs-wrap iframe, #{{ $uid }}-lightbox .rj-vs-wrap video { width: 100%; height: 100%; border: 0; display: block; }
        #{{ $uid }}-lightbox .rj-vs-close {
            position: absolute; z-index: 3; top: 24px; right: 24px; width: 46px; height: 46px; display: flex; align-items: center; justify-content: center; border: 0; border-radius: 50%; cursor: pointer; color: #fff;
            background: rgba(255,255,255,.1); box-shadow: inset 0 0 0 .5px rgba(255,255,255,.3), inset 0 1px 0 rgba(255,255,255,.3);
            transition: background .25s ease, transform .4s cubic-bezier(.32,.72,0,1);
        }
        #{{ $uid }}-lightbox .rj-vs-close:hover { background: rgba(255,255,255,.2); transform: rotate(90deg); }
        #{{ $uid }}-lightbox .rj-vs-close:focus-visible { outline: 2px solid rgba(255,255,255,.8); outline-offset: 3px; }

        @media (max-width: 768px) {
            #{{ $uid }}.rj-vs { padding: 80px 16px 80px; }
            #{{ $uid }} .rj-vs-bars { display: none; }
            #{{ $uid }} .rj-vs-frame { border-radius: 22px; }
            #{{ $uid }} .rj-vs-bar { height: 38px; padding: 0 14px; }
            #{{ $uid }} .rj-vs-play { width: 68px; height: 68px; margin: -44px 0 0 -34px; }
            #{{ $uid }} .rj-vs-orbits { inset: -48px; }
            #{{ $uid }} .rj-vs-disc svg { width: 24px; height: 24px; }
            #{{ $uid }} .rj-vs-label { top: calc(50% + 48px); font-size: 10px; }
            #{{ $uid }} .rj-vs-corners { inset: 10px; }
            #{{ $uid }}-lightbox .rj-vs-close { top: 14px; right: 14px; }
        }
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after,
            #{{ $uid }}-lightbox, #{{ $uid }}-lightbox * { animation: none !important; transition-duration: .01s !important; }
            #{{ $uid }} .rj-vs-frame { opacity: 1; transform: none; }
            #{{ $uid }} .rj-vs-galaxy { opacity: 1; }
        }
    </style>

    <div id="{{ $uid }}-lightbox" role="dialog" aria-modal="true" aria-label="Video" data-lightbox>
        <div class="rj-vs-warp" data-warp></div>
        <button type="button" class="rj-vs-close" data-close aria-label="Close">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
        <div class="rj-vs-wrap" data-wrap></div>
    </div>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        var lightbox = document.getElementById(@js($uid . '-lightbox'));
        if (!root || !lightbox) return;

        var stage = root.querySelector('[data-stage]');
        var spot = root.querySelector('[data-spot]');
        var playBtn = root.querySelector('[data-play]');
        var closeBtn = lightbox.querySelector('[data-close]');
        var wrap = lightbox.querySelector('[data-wrap]');
        var warp = lightbox.querySelector('[data-warp]');
        var videoUrl = stage.getAttribute('data-video-url') || '';
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var lastFocus = null, clearTimer = null;

        // fixed overlays break inside transformed ancestors, so the lightbox lives on <body>
        document.body.appendChild(lightbox);

        /* entrance once + pause infinite animations while off-screen */
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (e) {
                if (e[0].isIntersecting) root.classList.add('is-in');
                root.classList.toggle('rj-idle', !e[0].isIntersecting);
            }, { threshold: 0.08 }).observe(root);
        } else { root.classList.add('is-in'); }

        /* parallax + cursor light, one update per frame */
        var px = 0, py = 0, queued = false;
        function frame() {
            queued = false;
            var r = stage.getBoundingClientRect();
            var x = px - r.left, y = py - r.top;
            stage.style.setProperty('--mx', ((x / r.width - 0.5) * 2).toFixed(3));
            stage.style.setProperty('--my', ((y / r.height - 0.5) * 2).toFixed(3));
            spot.style.setProperty('--sx', x.toFixed(1) + 'px');
            spot.style.setProperty('--sy', y.toFixed(1) + 'px');
        }
        if (window.matchMedia && window.matchMedia('(hover: hover)').matches && !reduce) {
            stage.addEventListener('pointermove', function (e) {
                px = e.clientX; py = e.clientY;
                if (!queued) { queued = true; requestAnimationFrame(frame); }
            });
            stage.addEventListener('pointerleave', function () {
                stage.style.setProperty('--mx', '0');
                stage.style.setProperty('--my', '0');
            });
        }

        /* video url -> embeddable source */
        function embed(url) {
            url = (url || '').trim();
            if (!url) return null;
            if (!/^(https?:)?\/\//i.test(url) && url.charAt(0) !== '/') return null;   // no javascript: or other schemes
            var m = url.match(/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([\w-]{6,})/i);
            if (m) return { type: 'iframe', src: 'https://www.youtube.com/embed/' + m[1] + '?autoplay=1&rel=0' };
            m = url.match(/vimeo\.com\/(?:video\/)?(\d+)/i);
            if (m) return { type: 'iframe', src: 'https://player.vimeo.com/video/' + m[1] + '?autoplay=1' };
            if (/\.(mp4|webm|ogg)(\?|#|$)/i.test(url)) return { type: 'video', src: url };
            return { type: 'iframe', src: url };
        }

        function openLightbox() {
            var e = embed(videoUrl);
            if (!e) return;
            clearTimeout(clearTimer);
            lastFocus = document.activeElement;
            wrap.innerHTML = '';

            var el;
            if (e.type === 'video') {
                el = document.createElement('video');
                el.src = e.src; el.controls = true; el.autoplay = true; el.playsInline = true;
            } else {
                el = document.createElement('iframe');
                el.src = e.src;
                el.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
                el.setAttribute('allowfullscreen', '');
            }
            wrap.appendChild(el);

            lightbox.classList.add('is-open');
            document.body.style.overflow = 'hidden';

            // warp jump: light streaks rush outward from the centre
            if (!reduce && warp.animate) {
                warp.animate([
                    { transform: 'scale(.06)', opacity: 0, offset: 0 },
                    { opacity: .9, offset: .35 },
                    { transform: 'scale(1)', opacity: 0, offset: 1 }
                ], { duration: 950, easing: 'cubic-bezier(.4,0,.2,1)' });
            }
            closeBtn.focus({ preventScroll: true });
        }

        function closeLightbox() {
            if (!lightbox.classList.contains('is-open')) return;
            lightbox.classList.remove('is-open');
            document.body.style.overflow = '';
            clearTimer = setTimeout(function () { wrap.innerHTML = ''; }, 450);   // stops playback after the fade
            if (lastFocus && lastFocus.focus) lastFocus.focus({ preventScroll: true });
        }

        stage.addEventListener('click', openLightbox);
        closeBtn.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', function (e) { if (e.target === lightbox) closeLightbox(); });
        document.addEventListener('keydown', function (e) {
            if (!lightbox.classList.contains('is-open')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'Tab') { e.preventDefault(); closeBtn.focus(); }
        });
    })();
    </script>
</section>