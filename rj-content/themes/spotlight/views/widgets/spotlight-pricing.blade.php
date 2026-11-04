@php
    $uid = 'pricing_' . substr(md5(uniqid('', true)), 0, 8);

    $showHud = filter_var($settings['show_hud'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $hudLeft = $settings['hud_left'] ?? '[ 06 / 09 ]';
    $hudRight = $settings['hud_right'] ?? '[ PRICING ]';
    $badge = $settings['badge_text'] ?? '';
    $title = $settings['title'] ?? '';

    $plans = $settings['plans'] ?? [];
    if (!is_array($plans)) $plans = [];
    $plans = array_slice(array_values($plans), 0, 3);
@endphp

<section class="rj-price-section" id="{{ $uid }}">

    @if($showHud)
        <span class="rj-price-line rj-line-top"><i></i><i></i></span>
        <span class="rj-price-line rj-line-bottom"><i></i><i></i></span>
        <div class="rj-price-hud rj-hl"><b></b>{{ $hudLeft }}</div>
        <div class="rj-price-hud rj-hr">{{ $hudRight }}<b></b></div>
    @endif

    <div class="rj-price-inner">

        <div class="rj-price-header">
            @if($badge)
                <div class="rj-price-badge">
                    <span class="rj-price-bars"><i></i><i></i><i></i></span>
                    <span class="rj-price-badge-t">{{ $badge }}</span>
                    <span class="rj-price-bars"><i></i><i></i><i></i></span>
                </div>
            @endif
            @if($title)
                <h2 class="rj-price-title">{{ $title }}</h2>
            @endif
        </div>

        @if(!empty($plans))
            <div class="rj-price-grid">
                @foreach($plans as $index => $plan)
                    @php
                        $isPopular = filter_var($plan['is_popular'] ?? false, FILTER_VALIDATE_BOOLEAN);
                        $features = preg_split('/\r\n|\r|\n/', (string) ($plan['features'] ?? ''));
                        $features = array_filter(array_map('trim', $features));
                    @endphp

                    <div class="rj-price-card {{ $isPopular ? 'is-popular' : '' }}" style="--i: {{ $index }};">
                        @if($isPopular)
                            <div class="rj-popular-bg">
                                <div class="rj-popular-orb"></div>
                                <div class="rj-popular-glow"></div>
                            </div>
                        @endif

                        <div class="rj-price-card-inner">
                            <h3 class="rj-plan-name">{{ $plan['plan_name'] ?? '' }}</h3>

                            <div class="rj-plan-price-wrap">
                                <span class="rj-plan-price">{{ $plan['price'] ?? '' }}</span>
                                <span class="rj-plan-period">{{ $plan['period'] ?? '' }}</span>
                            </div>

                            <p class="rj-plan-desc">{{ $plan['description'] ?? '' }}</p>

                            <a href="{{ $plan['button_url'] ?? '#' }}" class="rj-plan-btn {{ $isPopular ? 'btn-primary' : 'btn-secondary' }}">
                                {{ $plan['button_text'] ?? '' }}
                            </a>

                            <div class="rj-plan-features-title">{{ __('What\'s Included') }}</div>
                            <ul class="rj-plan-features">
                                @foreach($features as $fIndex => $feature)
                                    <li style="--fi: {{ $fIndex }};">
                                        <svg class="rj-check" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-price-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 140px 24px 120px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* HUD və Xətlər */
        #{{ $uid }} .rj-price-line {
            position: absolute; left: 0; right: 0; height: 1px;
            background: rgba(255, 255, 255, 0.14); z-index: 2;
        }
        #{{ $uid }} .rj-line-top { top: 60px; }
        #{{ $uid }} .rj-line-bottom { bottom: 60px; }

        #{{ $uid }} .rj-price-line i { position: absolute; top: -6px; width: 13px; height: 13px; }
        #{{ $uid }} .rj-price-line i::before, #{{ $uid }} .rj-price-line i::after { content: ""; position: absolute; background: #fff; }
        #{{ $uid }} .rj-price-line i::before { left: 0; right: 0; top: 6px; height: 1px; }
        #{{ $uid }} .rj-price-line i::after { top: 0; bottom: 0; left: 6px; width: 1px; }
        #{{ $uid }} .rj-price-line i:first-child { left: 24px; }
        #{{ $uid }} .rj-price-line i:last-child { right: 24px; }

        #{{ $uid }} .rj-price-hud {
            position: absolute; top: 20px; z-index: 3;
            display: flex; align-items: center; gap: 14px;
            font: 700 12px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            letter-spacing: 0.08em; color: rgba(255, 255, 255, 0.85);
        }
        #{{ $uid }} .rj-hl { left: 24px; }
        #{{ $uid }} .rj-hr { right: 24px; }
        #{{ $uid }} .rj-price-hud b { display: block; width: 3px; height: 30px; background: #fff; }

        /* Inner */
        #{{ $uid }} .rj-price-inner {
            position: relative; z-index: 1;
            max-width: 1100px; width: 100%; margin: 0 auto;
        }

        #{{ $uid }} .rj-price-header {
            text-align: center; margin-bottom: 64px;
        }
        #{{ $uid }} .rj-price-badge { display: inline-flex; align-items: center; gap: 14px; margin-bottom: 24px; }
        #{{ $uid }} .rj-price-bars { display: inline-flex; gap: 3px; height: 12px; align-items: center; }
        #{{ $uid }} .rj-price-bars i { width: 2px; height: 100%; background: var(--rj-muted); opacity: 0.5; animation: rjPriceBar 1.5s ease-in-out infinite alternate; }
        #{{ $uid }} .rj-price-bars i:nth-child(2) { animation-delay: 0.2s; }
        #{{ $uid }} .rj-price-bars i:nth-child(3) { animation-delay: 0.4s; }
        #{{ $uid }} .rj-price-bars:last-child { flex-direction: row-reverse; }
        @keyframes rjPriceBar { 0% { transform: scaleY(0.3); opacity: 0.2; } 100% { transform: scaleY(1); opacity: 0.8; } }
        #{{ $uid }} .rj-price-badge-t { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; color: var(--rj-muted); text-transform: uppercase; }

        #{{ $uid }} .rj-price-title { font-size: clamp(32px, 5vw, 48px); font-weight: 600; line-height: 1.1; letter-spacing: -0.03em; color: #fff; margin: 0; }

        /* Grid */
        #{{ $uid }} .rj-price-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            align-items: center;
        }

        /* Card Base */
        #{{ $uid }} .rj-price-card {
            position: relative;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: transform 0.3s ease, border-color 0.3s ease;
            opacity: 0; transform: translateY(20px);
            animation: rjPriceIn 0.6s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }
        @keyframes rjPriceIn { to { opacity: 1; transform: none; } }

        #{{ $uid }} .rj-price-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.15);
        }

        #{{ $uid }} .rj-price-card-inner {
            position: relative;
            z-index: 2;
            padding: 40px 32px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Popular Card */
        #{{ $uid }} .rj-price-card.is-popular {
            border-color: rgba(59, 130, 246, 0.3);
            background: linear-gradient(180deg, rgba(20, 25, 35, 0.8) 0%, rgba(10, 10, 15, 0.9) 100%);
            box-shadow: 0 24px 64px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(59, 130, 246, 0.1) inset;
            transform: scale(1.02);
        }
        #{{ $uid }} .rj-price-card.is-popular:hover {
            transform: scale(1.02) translateY(-4px);
            border-color: rgba(59, 130, 246, 0.6);
        }

        /* Popular BG Effects */
        #{{ $uid }} .rj-popular-bg {
            position: absolute; inset: 0; border-radius: inherit; overflow: hidden; z-index: 0; pointer-events: none;
        }
        #{{ $uid }} .rj-popular-orb {
            position: absolute; top: -20px; right: -20px; width: 150px; height: 150px;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.8), rgba(59,130,246,0.2) 40%, transparent 70%);
            filter: blur(20px); opacity: 0.5;
            animation: rjOrbFloat 6s ease-in-out infinite alternate;
        }
        #{{ $uid }} .rj-popular-glow {
            position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%);
            width: 80%; height: 100px;
            background: radial-gradient(ellipse at bottom, rgba(59, 130, 246, 0.3) 0%, transparent 70%);
            filter: blur(30px);
        }
        @keyframes rjOrbFloat { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(-10px, 10px) scale(1.1); } }

        /* Content */
        #{{ $uid }} .rj-plan-name {
            font-size: 16px; font-weight: 500; color: var(--rj-muted); margin: 0 0 16px;
        }
        #{{ $uid }} .rj-price-card.is-popular .rj-plan-name { color: #fff; }

        #{{ $uid }} .rj-plan-price-wrap {
            display: flex; align-items: baseline; gap: 8px; margin-bottom: 16px;
        }
        #{{ $uid }} .rj-plan-price { font-size: 48px; font-weight: 600; color: #fff; line-height: 1; letter-spacing: -0.04em; }
        #{{ $uid }} .rj-plan-period { font-size: 14px; color: var(--rj-muted); }

        #{{ $uid }} .rj-plan-desc {
            font-size: 14px; line-height: 1.5; color: rgba(255,255,255,0.6); margin: 0 0 32px; flex: 1;
        }

        /* Button */
        #{{ $uid }} .rj-plan-btn {
            display: flex; align-items: center; justify-content: center;
            width: 100%; padding: 14px; border-radius: 8px;
            font-size: 14px; font-weight: 600; text-decoration: none;
            transition: all 0.25s ease; margin-bottom: 40px;
        }
        #{{ $uid }} .rj-plan-btn.btn-secondary {
            background: rgba(255, 255, 255, 0.05); color: #fff; border: 1px solid rgba(255, 255, 255, 0.1);
        }
        #{{ $uid }} .rj-plan-btn.btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);
        }
        #{{ $uid }} .rj-plan-btn.btn-primary {
            background: #3b82f6; color: #fff; border: 1px solid #3b82f6;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
        }
        #{{ $uid }} .rj-plan-btn.btn-primary:hover {
            background: #2563eb; border-color: #2563eb; box-shadow: 0 6px 24px rgba(59, 130, 246, 0.6);
        }

        /* Features */
        #{{ $uid }} .rj-plan-features-title {
            font-size: 13px; font-weight: 500; color: #fff; margin-bottom: 16px;
            padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        #{{ $uid }} .rj-plan-features {
            list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;
        }
        #{{ $uid }} .rj-plan-features li {
            display: flex; align-items: flex-start; gap: 10px;
            font-size: 14px; color: rgba(255,255,255,0.7);
            opacity: 0; transform: translateX(-10px);
            animation: rjFeatureIn 0.4s ease forwards;
            animation-delay: calc(0.3s + var(--i) * 0.1s + var(--fi) * 0.05s);
        }
        @keyframes rjFeatureIn { to { opacity: 1; transform: none; } }

        #{{ $uid }} .rj-check {
            width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px;
            color: var(--rj-muted);
        }
        #{{ $uid }} .rj-price-card.is-popular .rj-check { color: #3b82f6; }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-price-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }
            #{{ $uid }} .rj-price-card.is-popular {
                transform: none;
            }
            #{{ $uid }} .rj-price-card.is-popular:hover {
                transform: translateY(-4px);
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-price-section { padding: 100px 20px 80px; }
            #{{ $uid }} .rj-price-bars { display: none; }
            #{{ $uid }} .rj-line-top { top: 40px; }
            #{{ $uid }} .rj-line-bottom { bottom: 40px; }
            #{{ $uid }} .rj-price-hud { top: 10px; }
        }
    </style>
</section>
