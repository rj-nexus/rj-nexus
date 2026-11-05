@php
    $mainTitle = $settings['main_title'] ?? '';
    $items = $settings['items'] ?? [];
    $uid = 'ag_' . substr(md5(uniqid('', true)), 0, 8);
@endphp

<section class="rj-ag-section" id="{{ $uid }}">
    <div class="rj-ag-bg" aria-hidden="true">
        <div class="rj-ag-glow"></div>
        <div class="rj-ag-ring"></div>
    </div>

    <div class="rj-ag-inner">
        @if($mainTitle)
            <h2 class="rj-ag-title">{{ $mainTitle }}</h2>
        @endif

        <div class="rj-ag-grid">
            @foreach($items as $item)
                <div class="rj-ag-card">
                    <div class="rj-ag-icon-wrap">
                        <div class="rj-ag-icon-inner">
                            <iconify-icon icon="{{ $item['icon'] ?? 'ph:star' }}"></iconify-icon>
                        </div>
                    </div>

                    <h3 class="rj-ag-card-title">{{ $item['title'] ?? '' }}</h3>
                    <p class="rj-ag-card-desc">{{ $item['desc'] ?? '' }}</p>

                    @if(!empty($item['btn_text']) && !empty($item['btn_url']))
                        <a href="{{ $item['btn_url'] }}" class="rj-ag-btn">{{ $item['btn_text'] }}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-ag-section {
            position: relative;
            padding: 120px 24px 100px;
            overflow: hidden;
            background: transparent;
            isolation: isolate;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #{{ $uid }} .rj-ag-bg {
            position: absolute;
            inset: 0;
            z-index: -1;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        #{{ $uid }} .rj-ag-glow {
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.08) 0%, transparent 60%);
            top: -20%;
        }

        #{{ $uid }} .rj-ag-ring {
            position: absolute;
            width: 1200px;
            height: 1200px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                inset 0 0 100px rgba(255, 255, 255, 0.05),
                0 0 80px rgba(255, 255, 255, 0.1);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -40%);
        }

        #{{ $uid }} .rj-ag-ring::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            background: conic-gradient(from 180deg at 50% 50%, transparent 0deg, transparent 90deg, rgba(255,255,255,0.4) 180deg, transparent 270deg, transparent 360deg);
            -webkit-mask: radial-gradient(circle, transparent 59%, #000 60%, #000 61%, transparent 62%);
            mask: radial-gradient(circle, transparent 59%, #000 60%, #000 61%, transparent 62%);
        }

        #{{ $uid }} .rj-ag-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            width: 100%;
            margin: 0 auto;
        }

        #{{ $uid }} .rj-ag-title {
            font-size: clamp(36px, 5vw, 64px);
            font-weight: 500;
            color: #fff;
            text-align: center;
            margin: 0 auto 80px;
            letter-spacing: -0.03em;
            line-height: 1.1;
            max-width: 800px;
        }

        #{{ $uid }} .rj-ag-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            align-items: start;
        }

        #{{ $uid }} .rj-ag-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background: transparent;
            padding: 20px;
        }

        #{{ $uid }} .rj-ag-icon-wrap {
            position: relative;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
        }

        #{{ $uid }} .rj-ag-icon-wrap::before,
        #{{ $uid }} .rj-ag-icon-wrap::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all .3s;
        }

        #{{ $uid }} .rj-ag-icon-wrap::before { top: 0; left: 0; border-right: 0; border-bottom: 0; }
        #{{ $uid }} .rj-ag-icon-wrap::after { bottom: 0; right: 0; border-left: 0; border-top: 0; }

        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-wrap::before,
        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-wrap::after {
            border-color: var(--rj-primary);
            width: 100%;
            height: 100%;
        }

        #{{ $uid }} .rj-ag-icon-inner {
            font-size: 32px;
            color: var(--rj-primary);
            filter: drop-shadow(0 0 12px color-mix(in srgb, var(--rj-primary) 50%, transparent));
            transition: transform .3s;
        }

        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-inner {
            transform: scale(1.1);
        }

        #{{ $uid }} .rj-ag-card-title {
            font-size: 22px;
            font-weight: 500;
            color: #fff;
            margin: 0 0 16px;
            letter-spacing: -0.01em;
        }

        #{{ $uid }} .rj-ag-card-desc {
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.7);
            margin: 0 0 32px;
            max-width: 280px;
        }

        #{{ $uid }} .rj-ag-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 32px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all .25s;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            min-width: 180px;
        }

        #{{ $uid }} .rj-ag-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 968px) {
            #{{ $uid }}.rj-ag-section { padding: 80px 24px; }
            #{{ $uid }} .rj-ag-grid { grid-template-columns: 1fr; gap: 64px; }
            #{{ $uid }} .rj-ag-title { margin-bottom: 60px; }
        }
    </style>
</section>
