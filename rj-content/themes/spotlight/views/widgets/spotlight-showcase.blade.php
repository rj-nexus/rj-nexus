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
            <div class="rj-showcase-divider">
                <span></span>
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
            <div class="rj-showcase-shine"></div>
        </div>
    @endif

    <style>
        #{{ $uid }}.rj-showcase-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 100px 24px 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        /* İşıq effekti mərkəzdən yuxarı doğru */
        #{{ $uid }} .rj-showcase-glow {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 60%;
            background: radial-gradient(ellipse at center, var(--glow-color) 0%, transparent 60%);
            filter: blur(100px);
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

        /* Badge ve animasiyali xetler */
        #{{ $uid }} .rj-showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 16px;
        }

        #{{ $uid }} .rj-showcase-bars {
            display: inline-flex;
            gap: 4px;
            height: 14px;
            align-items: center;
        }

        #{{ $uid }} .rj-showcase-bars i {
            display: block;
            width: 2px;
            height: 100%;
            background: var(--rj-muted);
            opacity: 0.5;
            transform-origin: center;
            animation: rjBarPulse 1.5s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-showcase-bars i:nth-child(1) { animation-delay: 0s; }
        #{{ $uid }} .rj-showcase-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-showcase-bars i:nth-child(3) { animation-delay: 0.4s; }

        #{{ $uid }} .rj-showcase-bars:last-child {
            flex-direction: row-reverse;
        }

        @keyframes rjBarPulse {
            0% { transform: scaleY(0.3); opacity: 0.2; }
            100% { transform: scaleY(1); opacity: 0.8; }
        }

        #{{ $uid }} .rj-showcase-badge-text {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: var(--rj-muted);
            text-transform: uppercase;
        }

        /* İncə ayırıcı xətt */
        #{{ $uid }} .rj-showcase-divider {
            width: 100%;
            max-width: 400px;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 28px 0 32px;
            position: relative;
            overflow: hidden;
        }

        #{{ $uid }} .rj-showcase-divider span {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--rj-primary), transparent);
            animation: rjDividerLight 4s infinite linear;
        }

        @keyframes rjDividerLight {
            0% { left: -100%; }
            100% { left: 100%; }
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

        /* Şəkil və üzərindən keçən parlaq xətt */
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
            transform: scale(1.03);
        }

        #{{ $uid }} .rj-showcase-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.25), transparent);
            transform: skewX(-25deg);
            pointer-events: none;
            z-index: 2;
        }

        #{{ $uid }} .rj-showcase-image-wrap:hover .rj-showcase-shine {
            animation: rjImageShine 1.5s ease-out;
        }

        @keyframes rjImageShine {
            0% { left: -100%; }
            100% { left: 200%; }
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
            #{{ $uid }} .rj-showcase-divider {
                max-width: 100%;
                margin: 20px 0;
            }
            #{{ $uid }} .rj-showcase-image-wrap {
                border-radius: 12px;
            }
        }
    </style>
</section>
