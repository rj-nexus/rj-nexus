@php
    $uid = 'steps_' . substr(md5(uniqid('', true)), 0, 8);

    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    $bgArc = $settings['bg_image_url'] ?? 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/gradient-planet.webp';

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

    <div class="rj-steps-bg-arc">
        <img src="{{ $bgArc }}" alt="Background Arc" aria-hidden="true">
    </div>

    @if($showHud)
        <span class="rj-steps-line rj-line-top"><i></i><i></i></span>
        <span class="rj-steps-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-steps-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-steps-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

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
                @if($title)
                    <h2 class="rj-steps-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-steps-sub">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        <div class="rj-steps-split">

            {{-- Sol tərəf: Sticky wrapper --}}
            <div class="rj-steps-visual">
                <div class="rj-steps-sticky">
                    <div class="rj-steps-visual-glow"></div>
                    @foreach($steps as $index => $step)
                        @php
                            $img = $resolve($step['step_image_url'] ?? '', $step['step_image'] ?? '');
                            if(empty($img)) $img = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/step' . ($index + 1) . '.png';
                        @endphp
                        <img src="{{ $img }}" alt="{{ $step['step_title'] ?? '' }}" class="rj-step-img {{ $index === 0 ? 'is-active' : '' }}" data-step="{{ $index }}" loading="lazy">
                    @endforeach
                </div>
            </div>

            {{-- Sağ tərəf: Mətnlər --}}
            <div class="rj-steps-content">
                <div class="rj-steps-list">
                    @foreach($steps as $index => $step)
                        <div class="rj-step-item {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}">
                            <div class="rj-step-marker">
                                <span class="rj-step-dot"></span>
                            </div>
                            <div class="rj-step-body">
                                <span class="rj-step-num">STEP {{ $step['step_num'] ?? '' }}</span>
                                <h3 class="rj-step-title">{{ $step['step_title'] ?? '' }}</h3>
                                <p class="rj-step-text">{{ $step['step_text'] ?? '' }}</p>
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
            /* overflow-x: clip; - Bunu sildik, çünki bəzən sticky-ni bloklayır */
            overflow: visible;
        }

        /* Planet (Arc) */
        #{{ $uid }} .rj-steps-bg-arc {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%; max-width: 1400px;
            height: 80vh;
            pointer-events: none; z-index: 0;
        }
        #{{ $uid }} .rj-steps-bg-arc img {
            width: 100%; height: 100%; object-fit: cover; object-position: top center;
            opacity: 0.5;
            mask-image: linear-gradient(to bottom, #000 40%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, #000 40%, transparent 100%);
        }

        /* HUD və Xətlər */
        #{{ $uid }} .rj-steps-line {
            position: absolute; left: 0; right: 0; height: 1px;
            background: rgba(255, 255, 255, 0.14); z-index: 2;
        }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }

        #{{ $uid }} .rj-steps-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-steps-line i::before, #{{ $uid }} .rj-steps-line i::after { content: ""; position: absolute; background: #fff; }
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

        #{{ $uid }} .rj-steps-inner {
            position: relative; z-index: 1;
            max-width: 1100px; width: 100%; margin: 0 auto;
        }

        #{{ $uid }} .rj-steps-header { text-align: center; margin-bottom: 80px; }
        #{{ $uid }} .rj-steps-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-steps-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-steps-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjStepBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-steps-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-steps-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-steps-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjStepBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-steps-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: var(--rj-muted); text-transform: uppercase; }

        #{{ $uid }} .rj-steps-title { font-size: clamp(32px, 5vw, 56px); font-weight: 600; line-height: 1.1; letter-spacing: -0.03em; color: #fff; margin: 0 0 20px; }
        #{{ $uid }} .rj-steps-sub { font-size: clamp(16px, 2vw, 18px); line-height: 1.6; color: var(--rj-muted); margin: 0; max-width: 600px; margin: 0 auto; }

        /* Split Layout */
        #{{ $uid }} .rj-steps-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: stretch; /* Vacibdir! Sol tərəfin sağ tərəfin boyu uzanması üçün */
        }

        /* Sol tərəf */
        #{{ $uid }} .rj-steps-visual {
            position: relative;
            /* Height vermirik ki, sağ tərəf boyu uzansın */
        }

        #{{ $uid }} .rj-steps-sticky {
            position: sticky;
            top: 140px; /* Ekranın yuxarısından məsafə */
            height: 500px; /* Şəkillər üçün ayrılmış sahə */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #{{ $uid }} .rj-steps-visual-glow {
            position: absolute; width: 100%; height: 100%;
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.2) 0%, transparent 60%);
            filter: blur(40px); pointer-events: none; z-index: 0;
        }

        #{{ $uid }} .rj-step-img {
            position: absolute;
            width: 100%; max-width: 400px;
            max-height: 100%;
            object-fit: contain;
            opacity: 0; visibility: hidden;
            transform: scale(0.9) translateY(20px);
            transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.6));
            z-index: 1;
        }
        #{{ $uid }} .rj-step-img.is-active {
            opacity: 1; visibility: visible;
            transform: scale(1) translateY(0);
        }

        /* Sağ tərəf */
        #{{ $uid }} .rj-steps-content {
            padding-top: 40px;
            padding-bottom: 40px;
        }
        #{{ $uid }} .rj-steps-list {
            position: relative; display: flex; flex-direction: column; gap: 120px; /* Məsafəni çox etdik ki, scroll yaransın */
        }
        #{{ $uid }} .rj-steps-list::before {
            content: ''; position: absolute; top: 10px; bottom: 10px; left: 11px; width: 2px;
            background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.15) 20%, rgba(255,255,255,0.15) 80%, transparent);
        }

        #{{ $uid }} .rj-step-item {
            position: relative; display: flex; gap: 24px;
            opacity: 0.3; transition: opacity 0.4s ease;
        }
        #{{ $uid }} .rj-step-item.is-active {
            opacity: 1;
        }

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
            transform: scale(0.5); transition: transform 0.4s;
        }
        #{{ $uid }} .rj-step-item.is-active .rj-step-dot {
            transform: scale(1.5);
        }

        #{{ $uid }} .rj-step-body { flex: 1; }
        #{{ $uid }} .rj-step-num {
            display: block; font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px; font-weight: 700; letter-spacing: 0.1em;
            color: #3b82f6; margin-bottom: 8px;
        }
        #{{ $uid }} .rj-step-title {
            font-size: 24px; font-weight: 600; color: #fff; margin: 0 0 12px;
        }
        #{{ $uid }} .rj-step-text {
            font-size: 15px; line-height: 1.6; color: var(--rj-muted); margin: 0;
        }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-steps-split {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            #{{ $uid }} .rj-steps-sticky {
                position: relative; top: 0; height: 350px;
            }
            #{{ $uid }} .rj-steps-content {
                padding-top: 0;
            }
            #{{ $uid }} .rj-steps-list {
                gap: 60px;
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-steps-section { padding: 100px 20px 80px; }
            #{{ $uid }} .rj-steps-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-steps-hud { top: 10px; }
            #{{ $uid }} .rj-steps-sticky { height: 250px; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var items = root.querySelectorAll('.rj-step-item');
        var images = root.querySelectorAll('.rj-step-img');

        if ('IntersectionObserver' in window && items.length > 0) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var index = entry.target.getAttribute('data-index');

                        items.forEach(function (el) { el.classList.remove('is-active'); });
                        entry.target.classList.add('is-active');

                        images.forEach(function (img) { img.classList.remove('is-active'); });
                        var activeImg = root.querySelector('.rj-step-img[data-step="' + index + '"]');
                        if (activeImg) activeImg.classList.add('is-active');
                    }
                });
            }, { rootMargin: '-20% 0px -40% 0px', threshold: 0 });

            items.forEach(function (item) { observer.observe(item); });
        } else {
            items.forEach(function (el) { el.classList.add('is-active'); el.style.opacity = '1'; });
            images.forEach(function (img) { img.classList.add('is-active'); img.style.opacity = '1'; img.style.position = 'relative'; img.style.marginBottom = '20px'; });
        }
    })();
    </script>
</section>
