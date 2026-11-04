@php
    $uid = 'steps_' . substr(md5(uniqid('', true)), 0, 8);

    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    $mainVisual = $resolve($settings['main_visual_url'] ?? '', $settings['main_visual'] ?? '');
    if (empty($mainVisual)) {
        $mainVisual = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/gradient-planet.webp';
    }

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 04 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ HOW TO USE ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $steps = $settings['steps'] ?? [];
    if (!is_array($steps)) $steps = [];
    $steps = array_slice(array_values($steps), 0, 9);
@endphp

<section class="rj-steps-section" id="{{ $uid }}">

    @if($showHud)
        <span class="rj-steps-line rj-line-top"><i></i><i></i></span>
        <span class="rj-steps-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-steps-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-steps-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-steps-inner">
        <div class="rj-steps-split">

            <div class="rj-steps-visual">
                <div class="rj-steps-glow"></div>
                <img src="{{ $mainVisual }}" alt="{{ $title }}" class="rj-steps-main-img" loading="lazy">
            </div>

            <div class="rj-steps-content">
                @if($badge)
                    <div class="rj-steps-badge">
                        <span class="rj-steps-bars"><i></i><i></i><i></i></span>
                        <span class="rj-steps-badge-t">{{ $badge }}</span>
                        <span class="rj-steps-bars"><i></i><i></i><i></i></span>
                    </div>
                @endif

                @if($title)
                    <h2 class="rj-steps-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-steps-sub">{{ $subtitle }}</p>
                @endif

                <div class="rj-steps-list">
                    @foreach($steps as $index => $step)
                        @php
                            $img = $resolve($step['step_image_url'] ?? '', $step['step_image'] ?? '');
                        @endphp
                        <div class="rj-step-item" style="--i: {{ $index }};">
                            <div class="rj-step-marker">
                                <span class="rj-step-dot"></span>
                            </div>
                            <div class="rj-step-body">
                                <span class="rj-step-num">STEP {{ $step['step_num'] ?? '' }}</span>
                                <h3 class="rj-step-title">{{ $step['step_title'] ?? '' }}</h3>
                                <p class="rj-step-text">{{ $step['step_text'] ?? '' }}</p>
                                @if($img)
                                    <div class="rj-step-image">
                                        <img src="{{ $img }}" alt="{{ $step['step_title'] ?? '' }}" loading="lazy">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <style>
        #{{ $uid }}.rj-steps-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 140px 24px 120px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* Glass Lines */
        #{{ $uid }} .rj-steps-line {
            position: absolute; left: 0; right: 0; height: 1px;
            background: rgba(255, 255, 255, 0.14); z-index: 2;
        }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }

        #{{ $uid }} .rj-steps-line i {
            position: absolute; top: -6px; width: 13px; height: 13px;
        }
        #{{ $uid }} .rj-steps-line i::before,
        #{{ $uid }} .rj-steps-line i::after {
            content: ""; position: absolute; background: #fff;
        }
        #{{ $uid }} .rj-steps-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-steps-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-steps-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-steps-line i:last-child { right: 24px; }

        #{{ $uid }} .rj-steps-hud {
            position: absolute; top: 20px; z-index: 3;
            display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: 0.08em; color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-steps-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* Split Layout */
        #{{ $uid }} .rj-steps-inner {
            position: relative; z-index: 1;
            max-width: 1200px; width: 100%; margin: 0 auto;
        }
        #{{ $uid }} .rj-steps-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        /* Left Visual */
        #{{ $uid }} .rj-steps-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }
        #{{ $uid }} .rj-steps-glow {
            position: absolute; width: 80%; height: 80%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.35) 0%, transparent 70%);
            filter: blur(60px); pointer-events: none; z-index: 0;
        }
        #{{ $uid }} .rj-steps-main-img {
            position: relative; z-index: 1;
            width: 100%; max-width: 450px; height: auto;
            filter: drop-shadow(0 0 40px rgba(59, 130, 246, 0.2));
            animation: rjStepsFloat 6s ease-in-out infinite;
        }
        @keyframes rjStepsFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Right Content */
        #{{ $uid }} .rj-steps-content {
            display: flex; flex-direction: column;
        }

        #{{ $uid }} .rj-steps-badge {
            display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px;
        }
        #{{ $uid }} .rj-steps-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-steps-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjStepBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-steps-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-steps-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-steps-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjStepBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-steps-badge-t {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px; font-weight: 700; letter-spacing: 0.15em;
            color: var(--rj-muted); text-transform: uppercase;
        }

        #{{ $uid }} .rj-steps-title {
            font-size: clamp(28px, 4vw, 42px); font-weight: 600; line-height: 1.15;
            letter-spacing: -0.03em; color: #fff; margin: 0 0 16px;
        }
        #{{ $uid }} .rj-steps-sub {
            font-size: 16px; line-height: 1.6; color: var(--rj-muted); margin: 0 0 48px;
        }

        /* Steps List */
        #{{ $uid }} .rj-steps-list {
            position: relative; display: flex; flex-direction: column; gap: 40px;
        }
        #{{ $uid }} .rj-steps-list::before {
            content: ''; position: absolute; top: 10px; bottom: 10px; left: 11px; width: 2px;
            background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.15) 20%, rgba(255,255,255,0.15) 80%, transparent);
        }

        #{{ $uid }} .rj-step-item {
            position: relative; display: flex; gap: 24px;
            opacity: 0; transform: translateY(20px);
            animation: rjStepIn 0.6s ease forwards;
            animation-delay: calc(var(--i) * 0.2s + 0.3s);
        }
        @keyframes rjStepIn { to { opacity: 1; transform: none; } }

        #{{ $uid }} .rj-step-marker {
            position: relative; z-index: 1;
            width: 24px; height: 24px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            background: #0a0a0f; border-radius: 50%;
        }
        #{{ $uid }} .rj-step-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #3b82f6;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.8);
            transition: transform 0.3s;
        }
        #{{ $uid }} .rj-step-item:hover .rj-step-dot {
            transform: scale(1.5);
        }

        #{{ $uid }} .rj-step-body {
            flex: 1;
        }
        #{{ $uid }} .rj-step-num {
            display: block; font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px; font-weight: 700; letter-spacing: 0.1em;
            color: #3b82f6; margin-bottom: 8px;
        }
        #{{ $uid }} .rj-step-title {
            font-size: 20px; font-weight: 600; color: #fff; margin: 0 0 8px;
        }
        #{{ $uid }} .rj-step-text {
            font-size: 14px; line-height: 1.6; color: var(--rj-muted); margin: 0;
        }
        #{{ $uid }} .rj-step-image {
            margin-top: 16px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }
        #{{ $uid }} .rj-step-image img {
            width: 100%; height: auto; display: block;
        }

        /* Responsive */
        @media (max-width: 968px) {
            #{{ $uid }} .rj-steps-split {
                grid-template-columns: 1fr;
                gap: 48px;
            }
            #{{ $uid }} .rj-steps-visual {
                min-height: 300px;
            }
            #{{ $uid }} .rj-steps-main-img {
                max-width: 300px;
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-steps-section { padding: 100px 20px 80px; }
            #{{ $uid }} .rj-steps-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-steps-hud { top: 10px; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        // Scroll-triggered animation for steps
        var items = root.querySelectorAll('.rj-step-item');
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });

            items.forEach(function (item) {
                item.style.animationPlayState = 'paused';
                observer.observe(item);
            });
        } else {
            items.forEach(function (item) { item.style.opacity = '1'; item.style.transform = 'none'; });
        }
    })();
    </script>
</section>
