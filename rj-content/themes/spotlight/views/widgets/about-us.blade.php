@php
    $imgLeft = ($settings['image_position'] ?? 'right') === 'left';
@endphp

<style>
    @property --rj-au-a {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    #{{ $uid }} {
        width: 100%;
        padding: clamp(28px, 4vw, 56px) 20px;
        background: transparent;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        box-sizing: border-box;
    }

    #{{ $uid }} *,
    #{{ $uid }} *::before,
    #{{ $uid }} *::after {
        box-sizing: border-box;
    }

    #{{ $uid }} .rj-au-card {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        padding: clamp(22px, 3.6vw, 40px);
        border-radius: 28px;
        background: linear-gradient(155deg, rgba(24, 18, 58, 0.58), rgba(8, 6, 24, 0.4));
        -webkit-backdrop-filter: blur(16px) saturate(140%);
        backdrop-filter: blur(16px) saturate(140%);
        box-shadow: 0 30px 80px -30px rgba(0, 0, 0, 0.85), inset 0 1px 0 rgba(255, 255, 255, 0.07);
        isolation: isolate;
        animation: rj-au-in 0.9s cubic-bezier(0.2, 0.8, 0.2, 1) both;
    }

    @supports (animation-timeline: view()) {
        #{{ $uid }} .rj-au-card {
            animation: rj-au-in linear both;
            animation-timeline: view();
            animation-range: entry 0% entry 45%;
        }
    }

    #{{ $uid }} .rj-au-card::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 1px;
        background: conic-gradient(from var(--rj-au-a), rgba(255, 255, 255, 0.08) 0 55%, #a78bfa 72%, #ec4899 86%, rgba(255, 255, 255, 0.08) 100%);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        mask-composite: exclude;
        pointer-events: none;
        animation: rj-au-spin 9s linear infinite;
        z-index: 3;
    }

    #{{ $uid }} .rj-au-bg {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }

    #{{ $uid }} .rj-au-bg::before {
        content: "";
        position: absolute;
        width: 60%;
        aspect-ratio: 1;
        left: -12%;
        top: -30%;
        background: radial-gradient(circle, rgba(124, 58, 237, 0.34), transparent 68%);
        filter: blur(20px);
    }

    #{{ $uid }} .rj-au-bg::after {
        content: "";
        position: absolute;
        width: 55%;
        aspect-ratio: 1;
        right: -10%;
        bottom: -35%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.26), transparent 68%);
        filter: blur(20px);
    }

    #{{ $uid }} .rj-au-stars {
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(1.5px 1.5px at 12% 22%, #fff, transparent),
            radial-gradient(1px 1px at 28% 78%, #c4b5fd, transparent),
            radial-gradient(1.5px 1.5px at 46% 14%, #fff, transparent),
            radial-gradient(1px 1px at 63% 66%, #f9a8d4, transparent),
            radial-gradient(1.5px 1.5px at 78% 30%, #fff, transparent),
            radial-gradient(1px 1px at 90% 82%, #93c5fd, transparent),
            radial-gradient(1px 1px at 8% 60%, #fff, transparent),
            radial-gradient(1.5px 1.5px at 55% 90%, #fff, transparent);
        animation: rj-au-twinkle 5s ease-in-out infinite alternate;
    }

    #{{ $uid }} .rj-au-grid {
        position: relative;
        z-index: 2;
        display: grid;
        align-items: stretch;
        gap: clamp(22px, 3.4vw, 44px);
        grid-template-columns: minmax(0, 1.15fr) minmax(0, 0.85fr);
        grid-template-areas: "text media";
    }

    #{{ $uid }} .rj-au-grid.is-left {
        grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.15fr);
        grid-template-areas: "media text";
    }

    #{{ $uid }} .rj-au-text {
        grid-area: text;
        align-self: center;
        min-width: 0;
    }

    #{{ $uid }} .rj-au-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 14px 0;
        padding: 6px 13px;
        border-radius: 999px;
        border: 1px solid rgba(167, 139, 250, 0.35);
        background: rgba(124, 58, 237, 0.16);
        color: #ddd6fe;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    #{{ $uid }} .rj-au-badge i {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ec4899;
        box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7);
        animation: rj-au-pulse 2s ease-out infinite;
    }

    #{{ $uid }} .rj-au-title {
        margin: 0;
        font-size: clamp(26px, 3.6vw, 40px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -0.02em;
        background: linear-gradient(90deg, #ffffff, #e9d5ff 35%, #f9a8d4 65%, #ffffff);
        background-size: 220% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        animation: rj-au-text 9s linear infinite;
        filter: drop-shadow(0 0 22px rgba(167, 139, 250, 0.35));
    }

    #{{ $uid }} .rj-au-title::after {
        content: "";
        display: block;
        width: 56px;
        height: 3px;
        margin-top: 14px;
        border-radius: 3px;
        background: linear-gradient(90deg, #7c3aed, #ec4899);
        box-shadow: 0 0 14px rgba(236, 72, 153, 0.7);
    }

    #{{ $uid }} .rj-au-content {
        margin: 16px 0 0 0;
        max-width: 60ch;
        font-size: 16px;
        line-height: 1.7;
        color: rgba(226, 232, 240, 0.82);
    }

    #{{ $uid }} .rj-au-btn {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 24px;
        padding: 13px 26px;
        border-radius: 14px;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 12px 30px -10px rgba(168, 85, 247, 0.75);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    #{{ $uid }} .rj-au-btn::after {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;
        width: 60%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s ease;
    }

    #{{ $uid }} .rj-au-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px -10px rgba(236, 72, 153, 0.8);
        color: #ffffff;
    }

    #{{ $uid }} .rj-au-btn:hover::after {
        left: 160%;
    }

    #{{ $uid }} .rj-au-btn svg {
        transition: transform 0.25s ease;
    }

    #{{ $uid }} .rj-au-btn:hover svg {
        transform: translateX(4px);
    }

    #{{ $uid }} .rj-au-media-wrap {
        grid-area: media;
        position: relative;
        min-width: 0;
        min-height: 230px;
        animation: rj-au-float 7s ease-in-out infinite;
    }

    #{{ $uid }} .rj-au-aura {
        position: absolute;
        inset: -6px;
        border-radius: 28px;
        background: linear-gradient(135deg, #7c3aed, #ec4899 55%, #38bdf8);
        filter: blur(22px) hue-rotate(0deg);
        opacity: 0.34;
        animation: rj-au-hue 14s linear infinite;
        pointer-events: none;
    }

    #{{ $uid }} .rj-au-media {
        position: absolute;
        inset: 0;
        overflow: hidden;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(10, 8, 30, 0.6);
        box-shadow: 0 24px 60px -24px rgba(124, 58, 237, 0.7);
    }

    #{{ $uid }} .rj-au-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.9s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    #{{ $uid }} .rj-au-media:hover .rj-au-img {
        transform: scale(1.05);
    }

    #{{ $uid }} .rj-au-veil {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(124, 58, 237, 0.12), transparent 40%, rgba(5, 4, 15, 0.55));
        pointer-events: none;
    }

    #{{ $uid }} .rj-au-orbit {
        position: absolute;
        left: 50%;
        top: 50%;
        height: 86%;
        aspect-ratio: 1;
        border-radius: 50%;
        border: 1px dashed rgba(221, 214, 254, 0.35);
        transform: translate(-50%, -50%);
        animation: rj-au-orbit 28s linear infinite;
        pointer-events: none;
    }

    #{{ $uid }} .rj-au-orbit::before {
        content: "";
        position: absolute;
        left: 50%;
        top: -4px;
        width: 8px;
        height: 8px;
        margin-left: -4px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 12px 3px rgba(236, 72, 153, 0.9);
    }

    #{{ $uid }} .rj-au-corner {
        position: absolute;
        width: 22px;
        height: 22px;
        border: 2px solid rgba(196, 181, 253, 0.9);
        pointer-events: none;
    }

    #{{ $uid }} .rj-au-corner.tl {
        top: 12px;
        left: 12px;
        border-right: 0;
        border-bottom: 0;
        border-top-left-radius: 8px;
    }

    #{{ $uid }} .rj-au-corner.br {
        right: 12px;
        bottom: 12px;
        border-left: 0;
        border-top: 0;
        border-bottom-right-radius: 8px;
    }

    #{{ $uid }} .rj-au-empty {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c4b5fd;
    }

    #{{ $uid }} .rj-au-empty svg {
        width: 120px;
        height: 120px;
        filter: drop-shadow(0 0 24px rgba(167, 139, 250, 0.7));
        animation: rj-au-float 6s ease-in-out infinite;
    }

    @keyframes rj-au-in {
        from { opacity: 0; transform: translateY(32px) scale(0.98); }
        to { opacity: 1; transform: none; }
    }

    @keyframes rj-au-spin {
        to { --rj-au-a: 360deg; }
    }

    @keyframes rj-au-hue {
        to { filter: blur(22px) hue-rotate(360deg); }
    }

    @keyframes rj-au-orbit {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    @keyframes rj-au-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    @keyframes rj-au-twinkle {
        from { opacity: 0.35; }
        to { opacity: 0.95; }
    }

    @keyframes rj-au-text {
        to { background-position: -220% 0; }
    }

    @keyframes rj-au-pulse {
        0% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.7); }
        100% { box-shadow: 0 0 0 10px rgba(236, 72, 153, 0); }
    }

    @media (max-width: 820px) {
        #{{ $uid }} .rj-au-card {
            border-radius: 22px;
        }
        #{{ $uid }} .rj-au-grid,
        #{{ $uid }} .rj-au-grid.is-left {
            grid-template-columns: minmax(0, 1fr);
            grid-template-areas: "media" "text";
        }
        #{{ $uid }} .rj-au-media-wrap {
            min-height: 0;
            aspect-ratio: 16 / 10;
        }
        #{{ $uid }} .rj-au-content {
            font-size: 15px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-au-card,
        #{{ $uid }} .rj-au-card::before,
        #{{ $uid }} .rj-au-stars,
        #{{ $uid }} .rj-au-title,
        #{{ $uid }} .rj-au-badge i,
        #{{ $uid }} .rj-au-media-wrap,
        #{{ $uid }} .rj-au-aura,
        #{{ $uid }} .rj-au-orbit,
        #{{ $uid }} .rj-au-empty svg {
            animation: none;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-au-card">
        <div class="rj-au-bg"><div class="rj-au-stars"></div></div>

        <div class="rj-au-grid {{ $imgLeft ? 'is-left' : '' }}">
            <div class="rj-au-text">
                @if(!empty($settings['badge']))
                    <div class="rj-au-badge"><i></i>{{ $settings['badge'] }}</div>
                @endif

                @if(!empty($settings['title']))
                    <h2 class="rj-au-title">{{ $settings['title'] }}</h2>
                @endif

                @if(!empty($settings['content']))
                    <div class="rj-au-content">{!! nl2br(e($settings['content'])) !!}</div>
                @endif

                @if(!empty($settings['button_text']))
                    <a href="{{ $settings['button_url'] ?? '#' }}" class="rj-au-btn">
                        {{ $settings['button_text'] }}
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>

            <div class="rj-au-media-wrap">
                <div class="rj-au-aura"></div>
                <div class="rj-au-media">
                    @if(!empty($settings['image']))
                        <img src="{{ $settings['image'] }}" alt="{{ $settings['title'] ?? 'About Us' }}" class="rj-au-img" loading="lazy" decoding="async">
                        <div class="rj-au-veil"></div>
                    @else
                        <div class="rj-au-empty">
                            <svg viewBox="0 0 120 120" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <circle cx="60" cy="60" r="26" fill="rgba(124,58,237,0.35)"/>
                                <ellipse cx="60" cy="62" rx="52" ry="14" transform="rotate(-18 60 62)"/>
                                <circle cx="104" cy="44" r="3" fill="currentColor"/>
                            </svg>
                        </div>
                    @endif
                    <div class="rj-au-orbit"></div>
                    <span class="rj-au-corner tl"></span>
                    <span class="rj-au-corner br"></span>
                </div>
            </div>
        </div>
    </div>
</div>