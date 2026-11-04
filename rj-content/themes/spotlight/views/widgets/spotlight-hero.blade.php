@php
    $videoUrl = $settings['bg_video_url'] ?? '';
    $videoMedia = $settings['bg_video'] ?? '';

    $bgVideo = '';
    if (!empty($videoUrl)) {
        $bgVideo = $videoUrl;
    } elseif (!empty($videoMedia)) {
        if (\Illuminate\Support\Str::startsWith($videoMedia, ['http://', 'https://'])) {
            $bgVideo = $videoMedia;
        } elseif (\Illuminate\Support\Str::startsWith($videoMedia, ['media/', '/media/'])) {
            $bgVideo = asset(ltrim($videoMedia, '/'));
        } else {
            $bgVideo = \Illuminate\Support\Facades\Storage::url($videoMedia);
        }
    } else {
        $bgVideo = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/video/background.mp4';
    }

    $imageUrl = $settings['bg_image_url'] ?? '';
    $imageMedia = $settings['bg_image'] ?? '';

    $bgImage = '';
    if (!empty($imageUrl)) {
        $bgImage = $imageUrl;
    } elseif (!empty($imageMedia)) {
        if (\Illuminate\Support\Str::startsWith($imageMedia, ['http://', 'https://'])) {
            $bgImage = $imageMedia;
        } elseif (\Illuminate\Support\Str::startsWith($imageMedia, ['media/', '/media/'])) {
            $bgImage = asset(ltrim($imageMedia, '/'));
        } else {
            $bgImage = \Illuminate\Support\Facades\Storage::url($imageMedia);
        }
    }

    $overlay = (int) ($settings['overlay_opacity'] ?? 60);
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $btn1Text = $settings['primary_btn_text'] ?? '';
    $btn1Url = $settings['primary_btn_url'] ?? '#';
    $btn2Text = $settings['secondary_btn_text'] ?? '';
    $btn2Url = $settings['secondary_btn_url'] ?? '#';
@endphp

<section class="rj-cine-hero">

    <div class="rj-cine-bg">
        @if($bgVideo)
            <video src="{{ $bgVideo }}" autoplay loop muted playsinline class="rj-cine-media" @if($bgImage) poster="{{ $bgImage }}" @endif></video>
        @elseif($bgImage)
            <img src="{{ $bgImage }}" alt="{{ $title }}" class="rj-cine-media">
        @else
            <div class="rj-cine-media rj-cine-fallback"></div>
        @endif
        <div class="rj-cine-overlay" style="opacity: {{ $overlay / 100 }};"></div>
    </div>

    <div class="rj-cine-grid-lines">
        <div class="rj-cine-line-v rj-line-left"></div>
        <div class="rj-cine-line-v rj-line-right"></div>
        <div class="rj-cine-line-h rj-line-top"></div>
        <div class="rj-cine-line-h rj-line-bottom"></div>
    </div>

    <div class="rj-cine-content">
        @if($badge)
            <div class="rj-cine-badge-wrap">
                <span class="rj-cine-badge-line"></span>
                <span class="rj-cine-badge-text">{{ $badge }}</span>
                <span class="rj-cine-badge-line"></span>
            </div>
        @endif

        @if($title)
            <h1 class="rj-cine-title">
                {{ $title }}
            </h1>
        @endif

        @if($subtitle)
            <p class="rj-cine-subtitle">
                {{ $subtitle }}
            </p>
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
                    <a href="{{ $btn2Url }}" class="rj-cine-btn rj-cine-btn-secondary">
                        {{ $btn2Text }}
                    </a>
                @endif
            </div>
        @endif
    </div>

    <div class="rj-cine-scroll">
        <span class="rj-cine-scroll-text">SCROLL</span>
        <span class="rj-cine-scroll-line"></span>
    </div>

    <style>
        .rj-cine-hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--rj-bg);
            overflow: hidden;
        }
        .rj-cine-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .rj-cine-media {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .rj-cine-fallback {
            background: radial-gradient(circle at 50% 50%, color-mix(in srgb, var(--rj-primary) 15%, var(--rj-bg)) 0%, var(--rj-bg) 100%);
        }
        .rj-cine-overlay {
            position: absolute;
            inset: 0;
            background: #000;
            transition: opacity 0.3s;
        }
        .rj-cine-grid-lines {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 0 24px;
        }
        .rj-cine-line-v {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1px;
            background: rgba(255, 255, 255, 0.08);
        }
        .rj-line-left { left: 24px; }
        .rj-line-right { right: 24px; }
        .rj-cine-line-h {
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
        }
        .rj-line-top { top: 96px; }
        .rj-line-bottom { bottom: 96px; }

        .rj-cine-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 960px;
            padding: 120px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: rjCineFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .rj-cine-badge-wrap {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
            animation: rjCineFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.1s forwards;
            opacity: 0;
        }
        .rj-cine-badge-line {
            display: block;
            width: 40px;
            height: 1px;
            background: rgba(255, 255, 255, 0.4);
        }
        .rj-cine-badge-text {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
        }

        .rj-cine-title {
            font-size: clamp(48px, 7vw, 96px);
            line-height: 1.05;
            font-weight: 600;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin: 0 0 24px;
            text-wrap: balance;
            animation: rjCineFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.2s forwards;
            opacity: 0;
        }

        .rj-cine-subtitle {
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.7);
            margin: 0 0 48px;
            max-width: 680px;
            text-wrap: pretty;
            animation: rjCineFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.3s forwards;
            opacity: 0;
        }

        .rj-cine-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            animation: rjCineFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) 0.4s forwards;
            opacity: 0;
        }

        .rj-cine-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.25s ease;
        }
        .rj-cine-btn svg {
            width: 18px;
            height: 18px;
            transition: transform 0.25s;
        }

        .rj-cine-btn-primary {
            background: #ffffff;
            color: #000000;
            border: 1px solid #ffffff;
        }
        .rj-cine-btn-primary:hover {
            background: var(--rj-primary);
            border-color: var(--rj-primary);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px color-mix(in srgb, var(--rj-primary) 40%, transparent);
        }
        .rj-cine-btn-primary:hover svg {
            transform: translateX(4px);
        }

        .rj-cine-btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
        .rj-cine-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .rj-cine-scroll {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            opacity: 0.5;
        }
        .rj-cine-scroll-text {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.2em;
            color: #ffffff;
        }
        .rj-cine-scroll-line {
            display: block;
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, #ffffff, transparent);
            animation: rjCineScrollLine 2s infinite;
        }

        @keyframes rjCineFadeUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rjCineScrollLine {
            0% { transform: scaleY(0); transform-origin: top; }
            50% { transform: scaleY(1); transform-origin: top; }
            50.1% { transform: scaleY(1); transform-origin: bottom; }
            100% { transform: scaleY(0); transform-origin: bottom; }
        }

        @media (max-width: 768px) {
            .rj-cine-content {
                padding: 100px 20px;
            }
            .rj-cine-line-v { display: none; }
            .rj-cine-line-h { left: 20px; right: 20px; }
            .rj-cine-actions {
                flex-direction: column;
                width: 100%;
            }
            .rj-cine-btn {
                width: 100%;
            }
            .rj-cine-scroll {
                display: none;
            }
        }
    </style>
</section>
