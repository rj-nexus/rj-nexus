@php
    $uid = 'features_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 03 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ BENEFITS ]';

    $badge = $settings['badge_text'] ?? '';
    $customCode = $settings['top_custom_code'] ?? '';

    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $features = $settings['features'] ?? [];
    if (!is_array($features)) $features = [];
    $features = array_slice(array_values($features), 0, 9);
@endphp

<section class="rj-feat-section" id="{{ $uid }}">

    @if($showHud)
        <span class="rj-feat-line rj-line-top"><i></i><i></i></span>
        <span class="rj-feat-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-feat-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-feat-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

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
                <!-- Standart 3D abstract görünüş -->
                <div class="rj-default-orb">
                    <div class="rj-orb-ring rj-orb-r1"></div>
                    <div class="rj-orb-ring rj-orb-r2"></div>
                    <div class="rj-orb-core"></div>
                </div>
            @endif
        </div>

        <div class="rj-feat-text">
            @if($title)
                <h2 class="rj-feat-title">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <p class="rj-feat-sub">{{ $subtitle }}</p>
            @endif
        </div>

        @if(!empty($features))
            <div class="rj-feat-grid">
                @foreach($features as $i => $item)
                    <div class="rj-feat-card" style="--i: {{ $i }};">
                        <div class="rj-feat-icon">
                            <iconify-icon icon="{{ $item['icon'] ?? 'ph:sparkle' }}"></iconify-icon>
                        </div>
                        <h3 class="rj-feat-card-title">{{ $item['feature_title'] ?? '' }}</h3>
                        <p class="rj-feat-card-desc">{{ $item['feature_text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-feat-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 140px 24px 100px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* HUD və Xətlər */
        #{{ $uid }} .rj-feat-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.14);
            z-index: 2;
        }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }

        #{{ $uid }} .rj-feat-line i {
            position: absolute;
            top: -6px;
            width: 13px;
            height: 13px;
        }
        #{{ $uid }} .rj-feat-line i::before,
        #{{ $uid }} .rj-feat-line i::after {
            content: "";
            position: absolute;
            background: #fff;
        }
        #{{ $uid }} .rj-feat-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-feat-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-feat-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-feat-line i:last-child { right: 24px; }

        #{{ $uid }} .rj-feat-hud {
            position: absolute;
            top: 20px;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-feat-hud b {
            display: block;
            width: 3px;
            height: 30px;
            background: #fff;
        }

        /* Inner */
        #{{ $uid }} .rj-feat-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Badge */
        #{{ $uid }} .rj-feat-badge {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 48px;
        }
        #{{ $uid }} .rj-feat-bars { display: inline-flex; gap: 3px; height: 14px; align-items: center; }
        #{{ $uid }} .rj-feat-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; transform-origin: center; animation: rjFeatBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-feat-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-feat-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-feat-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjFeatBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-feat-badge-t {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: var(--rj-muted);
            text-transform: uppercase;
        }

        /* Default 3D Orb Visual (Custom Code yoxdursa) */
        #{{ $uid }} .rj-feat-visual {
            margin-bottom: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
            width: 100%;
        }
        #{{ $uid }} .rj-default-orb {
            position: relative;
            width: 160px;
            height: 160px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #{{ $uid }} .rj-orb-core {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #fff, #3f6fbe 60%, #000 100%);
            box-shadow: 0 0 40px rgba(63, 111, 190, 0.6);
            animation: rjFloat 4s ease-in-out infinite;
        }
        #{{ $uid }} .rj-orb-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1) inset;
        }
        #{{ $uid }} .rj-orb-r1 { width: 160px; height: 160px; animation: rjSpin 10s linear infinite; }
        #{{ $uid }} .rj-orb-r2 { width: 220px; height: 220px; border-style: dashed; animation: rjSpin 15s linear infinite reverse; }
        @keyframes rjFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes rjSpin { 0% { transform: rotateX(70deg) rotateZ(0deg); } 100% { transform: rotateX(70deg) rotateZ(360deg); } }

        /* Text */
        #{{ $uid }} .rj-feat-text {
            text-align: center;
            max-width: 800px;
            margin-bottom: 64px;
        }
        #{{ $uid }} .rj-feat-title {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 600;
            line-height: 1.15;
            letter-spacing: -0.03em;
            color: #fff;
            margin: 0 0 20px;
        }
        #{{ $uid }} .rj-feat-sub {
            font-size: clamp(16px, 2vw, 18px);
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
        }

        /* Grid */
        #{{ $uid }} .rj-feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 48px 32px;
            width: 100%;
        }
        #{{ $uid }} .rj-feat-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: rjFeatIn 0.6s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }
        #{{ $uid }} .rj-feat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 20px;
            color: #4f8cff;
        }
        #{{ $uid }} .rj-feat-icon iconify-icon {
            font-size: 32px;
            stroke-width: 1.5;
        }
        #{{ $uid }} .rj-feat-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 12px;
        }
        #{{ $uid }} .rj-feat-card-desc {
            font-size: 14px;
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
            max-width: 280px;
        }
        @keyframes rjFeatIn { to { opacity: 1; transform: none; } }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-feat-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px 24px;
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-feat-section { padding: 100px 20px 80px; }
            #{{ $uid }} .rj-feat-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            #{{ $uid }} .rj-feat-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-feat-hud { top: 10px; }
        }
    </style>

    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</section>
