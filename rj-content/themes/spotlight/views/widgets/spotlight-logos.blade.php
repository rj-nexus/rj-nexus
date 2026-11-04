@php
    $uid = 'logos_' . substr(md5(uniqid('', true)), 0, 8);
    $title = $settings['title_text'] ?? '';

    $logos = [];
    for ($i = 1; $i <= 6; $i++) {
        $url = $settings['logo_' . $i] ?? '';
        if (!empty($url)) {
            $logos[] = $url;
        }
    }
@endphp

<section class="rj-logos-section" id="{{ $uid }}">
    <div class="rj-logos-lines-top"></div>

    <div class="rj-logos-inner">
        @if($title)
            <div class="rj-logos-badge">
                <span class="rj-logos-badge-text">{{ $title }}</span>
            </div>
        @endif

        @if(!empty($logos))
            <div class="rj-logos-grid">
                @foreach($logos as $index => $logo)
                    <div class="rj-logo-item" style="--i: {{ $index }};">
                        <img src="{{ $logo }}" alt="Trusted Partner" loading="lazy">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="rj-logos-lines-bottom"></div>

    <style>
        #{{ $uid }}.rj-logos-section {
            position: relative;
            width: 100%;
            background: var(--rj-bg);
            padding: 60px 24px 80px;
            overflow: hidden;
            border-bottom: 1px solid var(--rj-border);
        }

        /* Background subtle glow */
        #{{ $uid }}::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 100%;
            background: radial-gradient(ellipse at center, color-mix(in srgb, var(--rj-primary) 5%, transparent) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        #{{ $uid }} .rj-logos-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 48px;
        }

        /* Top / Bottom Lines */
        #{{ $uid }} .rj-logos-lines-top,
        #{{ $uid }} .rj-logos-lines-bottom {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: var(--rj-container);
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--rj-border) 15%, var(--rj-border) 85%, transparent);
        }
        #{{ $uid }} .rj-logos-lines-top { top: 0; }
        #{{ $uid }} .rj-logos-lines-bottom { bottom: 0; }

        /* Text Badge */
        #{{ $uid }} .rj-logos-badge {
            display: inline-block;
            padding: 6px 16px;
            background: color-mix(in srgb, var(--rj-primary) 10%, transparent);
            border-radius: 4px;
        }
        #{{ $uid }} .rj-logos-badge-text {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--rj-primary);
        }

        /* Logo Grid */
        #{{ $uid }} .rj-logos-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 60px 80px;
            width: 100%;
        }

        #{{ $uid }} .rj-logo-item {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: rjLogoFadeIn 0.8s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }

        #{{ $uid }} .rj-logo-item img {
            height: 28px;
            max-width: 140px;
            width: auto;
            object-fit: contain;
            filter: grayscale(100%) opacity(0.4) brightness(2);
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Hover Effect */
        #{{ $uid }} .rj-logo-item:hover img {
            filter: grayscale(0%) opacity(1) brightness(1);
            transform: scale(1.05);
        }

        /* Mobile Adjustments */
        @media (max-width: 968px) {
            #{{ $uid }} .rj-logos-grid {
                gap: 40px 50px;
            }
            #{{ $uid }} .rj-logo-item img {
                height: 24px;
                max-width: 110px;
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-logos-section {
                padding: 40px 20px 60px;
            }
            #{{ $uid }} .rj-logos-inner {
                gap: 32px;
            }
            #{{ $uid }} .rj-logos-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 32px 20px;
                justify-items: center;
            }
            #{{ $uid }} .rj-logo-item img {
                height: 20px;
                max-width: 90px;
            }
        }

        @keyframes rjLogoFadeIn {
            0% {
                opacity: 0;
                transform: translateY(15px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</section>
