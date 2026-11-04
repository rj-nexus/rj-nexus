@php
    $uid = 'showcase_' . substr(md5(uniqid('', true)), 0, 8);

    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    $bgImage = $resolve($settings['image_url'] ?? '', $settings['image'] ?? '');

    // Əgər şəkil təyin edilməyibsə, default demo şəklini istifadə et
    if (empty($bgImage)) {
        $bgImage = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/demo_photo1.png';
    }

    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $glowColor = !empty($settings['glow_color']) ? $settings['glow_color'] : '#3f6fbe';
    $glowOpacity = max(0, min(100, (int) ($settings['glow_opacity'] ?? 50))) / 100;
@endphp

<section class="rj-showcase-section" id="{{ $uid }}">

    <div class="rj-showcase-glow" style="--glow-color: {{ $glowColor }}; opacity: {{ $glowOpacity }};"></div>

    <div class="rj-showcase-content">
        @if($badge)
            <div class="rj-showcase-badge">
                <span class="rj-showcase-bars"><i></i><i></i><i></i></span>
                <span class="rj-showcase-badge-text">{{ $badge }}</span>
                <span class="rj-showcase-bars"><i></i><i></i><i></i></span>
            </div>
        @endif

        @if($title)
            <h2 class="rj-showcase-title">{{ $title }}</h2>
        @endif

        @if($subtitle)
            <p class="rj-showcase-subtitle">{{ $subtitle }}</p>
        @endif
    </div>

    @if($bgImage)
        <div class="rj-showcase-image-wrap">
            <img src="{{ $bgImage }}" alt="{{ $title }}" class="rj-showcase-img" loading="lazy">
            <div class="rj-showcase-glass">
                <span class="rj-showcase-glass-text">View Demo</span>
            </div>
        </div>
    @endif

    <style>
        #{{ $uid }}.rj-showcase-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 100px 24px 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        /* Upward Glow Effect */
        #{{ $uid }} .rj-showcase-glow {
            position: absolute;
            bottom: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 70%;
            background: radial-gradient(ellipse at bottom, var(--glow-color) 0%, transparent 70%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        #{{ $uid }} .rj-showcase-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
            margin: 0 auto 56px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #{{ $uid }} .rj-showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }
        #{{ $uid }} .rj-showcase-bars {
            display: inline-flex;
            gap: 3px;
            height: 12px;
        }
        #{{ $uid }} .rj-showcase-bars i {
            width: 2px;
            background: var(--rj-muted);
            opacity: 0.5;
        }
        #{{ $uid }} .rj-showcase-badge-text {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: var(--rj-muted);
            text-transform: uppercase;
        }

        #{{ $uid }} .rj-showcase-title {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin: 0 0 20px;
            background: linear-gradient(180deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        #{{ $uid }} .rj-showcase-subtitle {
            font-size: clamp(16px, 2vw, 18px);
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
            max-width: 640px;
        }

        /* Image Wrapper & Glass Hover */
        #{{ $uid }} .rj-showcase-image-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 24px 64px -12px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255,255,255,0.05) inset;
            overflow: hidden;
            cursor: pointer;
            background: var(--rj-surface);
        }

        #{{ $uid }} .rj-showcase-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        #{{ $uid }} .rj-showcase-image-wrap:hover .rj-showcase-img {
            transform: scale(1.02);
        }

        /* Glass Overlay */
        #{{ $uid }} .rj-showcase-glass {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
            opacity: 0;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: inherit;
        }

        #{{ $uid }} .rj-showcase-image-wrap:hover .rj-showcase-glass {
            opacity: 1;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        #{{ $uid }} .rj-showcase-glass-text {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            padding: 12px 24px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            backdrop-filter: blur(12px);
            transform: translateY(10px);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        #{{ $uid }} .rj-showcase-image-wrap:hover .rj-showcase-glass-text {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            #{{ $uid }}.rj-showcase-section {
                padding: 60px 20px 40px;
            }
            #{{ $uid }} .rj-showcase-content {
                margin-bottom: 40px;
            }
            #{{ $uid }} .rj-showcase-bars {
                display: none;
            }
            #{{ $uid }} .rj-showcase-image-wrap {
                border-radius: 12px;
            }
        }
    </style>
</section>
