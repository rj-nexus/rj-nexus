@php
<<<<<<< HEAD
    $mainTitle = $settings['main_title'] ?? '';
    $items = $settings['items'] ?? [];
    $uid = 'ag_' . substr(md5(uniqid('', true)), 0, 8);
@endphp

<section class="rj-ag-section" id="{{ $uid }}">
    <div class="rj-ag-bg" aria-hidden="true">
        <div class="rj-ag-stars"></div>
        <div class="rj-ag-streak"></div>
        <div class="rj-ag-glow"></div>
        <div class="rj-ag-ring"></div>
        <div class="rj-ag-line"></div>
    </div>

    <div class="rj-ag-inner">
        @if($mainTitle)
            <h2 class="rj-ag-title">{{ $mainTitle }}</h2>
        @endif

        <div class="rj-ag-grid">
            @foreach($items as $item)
                <div class="rj-ag-card" style="--i: {{ $loop->index }}">
                    <div class="rj-ag-icon-wrap">
                        <i class="rj-ag-c tl"></i><i class="rj-ag-c tr"></i>
                        <i class="rj-ag-c bl"></i><i class="rj-ag-c br"></i>
                        <div class="rj-ag-icon-inner">
                            @if(function_exists('rj_icon'))
                                {!! rj_icon($item['icon'] ?? 'ph:star') !!}
                            @else
                                <iconify-icon icon="{{ $item['icon'] ?? 'ph:star' }}"></iconify-icon>
                            @endif
                        </div>
                    </div>

                    <h3 class="rj-ag-card-title">{{ $item['title'] ?? '' }}</h3>
                    <p class="rj-ag-card-desc">{{ $item['desc'] ?? '' }}</p>

                    @if(!empty($item['btn_text']) && !empty($item['btn_url']))
                        <a href="{{ $item['btn_url'] }}" class="rj-ag-btn"><span>{{ $item['btn_text'] }}</span></a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-ag-section {
            position: relative;
            width: 100%;
            overflow: hidden;
            contain: paint;
            container-type: inline-size;
            background: transparent;
            isolation: isolate;
        }

        /* ---------- BACKGROUND ---------- */
        #{{ $uid }} .rj-ag-bg {
            position: absolute;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        #{{ $uid }} .rj-ag-stars {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 8% 22%, rgba(255,255,255,.8), transparent),
                radial-gradient(1px 1px at 18% 70%, rgba(255,255,255,.5), transparent),
                radial-gradient(1.5px 1.5px at 27% 12%, rgba(255,255,255,.7), transparent),
                radial-gradient(1px 1px at 38% 55%, rgba(255,255,255,.5), transparent),
                radial-gradient(1px 1px at 52% 18%, rgba(255,255,255,.6), transparent),
                radial-gradient(1.5px 1.5px at 63% 82%, rgba(255,255,255,.6), transparent),
                radial-gradient(1px 1px at 74% 40%, rgba(255,255,255,.5), transparent),
                radial-gradient(1px 1px at 86% 15%, rgba(255,255,255,.8), transparent),
                radial-gradient(1.5px 1.5px at 93% 64%, rgba(255,255,255,.6), transparent),
                radial-gradient(1px 1px at 46% 90%, rgba(255,255,255,.4), transparent);
            animation: rjAgTwinkle 5s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-ag-streak {
            position: absolute;
            left: -20%;
            top: 38%;
            width: 140%;
            height: 34%;
            transform: rotate(-12deg);
            border-radius: 50%;
            filter: blur(44px);
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(96,165,250,.12) 25%,
                rgba(191,219,254,.32) 55%,
                rgba(96,165,250,.14) 80%,
                transparent 100%);
            animation: rjAgDrift 14s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-ag-glow {
            position: absolute;
            inset: -20% -10% auto -10%;
            height: 120%;
            background: radial-gradient(ellipse at 50% 45%, rgba(59,130,246,.16) 0%, transparent 60%);
            animation: rjAgPulse 8s ease-in-out infinite alternate;
        }

        #{{ $uid }} .rj-ag-ring {
            position: absolute;
            width: min(1000px, 120cqw);
            aspect-ratio: 1;
            right: -22cqw;
            top: -22%;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: inset 0 0 90px rgba(59,130,246,.06), 0 0 70px rgba(59,130,246,.10);
        }

        #{{ $uid }} .rj-ag-ring::before {
            content: '';
            position: absolute;
            inset: -1px;
            padding: 1px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent 0deg, rgba(147,197,253,.95) 60deg, transparent 130deg, transparent 360deg);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
            animation: rjAgSpin 12s linear infinite;
        }

        #{{ $uid }} .rj-ag-line {
            position: absolute;
            left: 0; right: 0;
            top: 24px;
            height: 1px;
            background: linear-gradient(90deg, rgba(255,255,255,.05), rgba(255,255,255,.18) 15%, rgba(255,255,255,.18) 85%, rgba(255,255,255,.05));
        }

        #{{ $uid }} .rj-ag-line::before,
        #{{ $uid }} .rj-ag-line::after {
            content: '';
            position: absolute;
            top: -6px;
            width: 13px;
            height: 13px;
            background:
                linear-gradient(#fff,#fff) center / 100% 1px no-repeat,
                linear-gradient(#fff,#fff) center / 1px 100% no-repeat;
            opacity: .85;
        }
        #{{ $uid }} .rj-ag-line::before { left: 8px; }
        #{{ $uid }} .rj-ag-line::after  { right: 8px; }

        /* ---------- CONTENT ---------- */
        #{{ $uid }} .rj-ag-inner {
            position: relative;
            z-index: 1;
            box-sizing: border-box;
            max-width: var(--rj-container, 1200px);
            width: 100%;
            margin: 0 auto;
            padding: 64px 24px 72px;
        }

        #{{ $uid }} .rj-ag-title {
            font-size: clamp(34px, 9cqw, 64px);
            font-weight: 500;
            text-align: center;
            margin: 0 auto 56px;
            letter-spacing: -0.035em;
            line-height: 1.1;
            max-width: 760px;
            background: linear-gradient(180deg, #fff 30%, rgba(255,255,255,.7));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-wrap: balance;
            overflow-wrap: anywhere;
        }

        #{{ $uid }} .rj-ag-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
            align-items: stretch;
        }

        /* ---------- CARD (şəffaf) ---------- */
        #{{ $uid }} .rj-ag-card {
            position: relative;
            min-width: 0;
=======
    $uid = 'act_' . substr(md5(uniqid('', true)), 0, 8);

    $mainTitle = $settings['main_title'] ?? '';
    $items = $settings['items'] ?? [];
    if (!is_array($items)) $items = [];
    $items = array_slice(array_values($items), 0, 4);
@endphp

<section class="rj-act-section" id="{{ $uid }}">
    <div class="rj-act-inner">

        @if($mainTitle)
            <h2 class="rj-act-main-title">{{ $mainTitle }}</h2>
        @endif

        @if(!empty($items))
            <div class="rj-act-grid" style="--cols: {{ count($items) }};">
                @foreach($items as $item)
                    <div class="rj-act-card">
                        <div class="rj-act-icon-wrap">
                            <iconify-icon icon="{{ $item['icon'] ?? 'ph:star' }}"></iconify-icon>
                        </div>
                        <h3 class="rj-act-title">{{ $item['title'] ?? '' }}</h3>
                        <p class="rj-act-desc">{{ $item['desc'] ?? '' }}</p>
                        @if(!empty($item['btn_text']))
                            <a href="{{ $item['btn_url'] ?? '#' }}" class="rj-act-btn">{{ $item['btn_text'] }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-act-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 100px 24px;
        }

        #{{ $uid }} .rj-act-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Başlıq */
        #{{ $uid }} .rj-act-main-title {
            font-size: clamp(40px, 6vw, 72px);
            line-height: 1.1;
            font-weight: 500;
            letter-spacing: -0.03em;
            color: #fff;
            margin: 0 0 80px;
            text-align: center;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        /* Grid */
        #{{ $uid }} .rj-act-grid {
            display: grid;
            grid-template-columns: repeat(var(--cols, 3), 1fr);
            gap: 48px;
            width: 100%;
        }

        /* Kart */
        #{{ $uid }} .rj-act-card {
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
<<<<<<< HEAD
            padding: 24px 16px;
            background: transparent;
            border: 0;
            transition: transform .45s cubic-bezier(.2,.8,.2,1);
        }

        #{{ $uid }} .rj-ag-card:hover { transform: translateY(-6px); }

        /* ---------- ICON (glass qutu) ---------- */
        #{{ $uid }} .rj-ag-icon-wrap {
            position: relative;
            width: 88px;
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 26px;
            border: 1px solid rgba(255,255,255,.14);
            background: linear-gradient(160deg, rgba(255,255,255,.08), rgba(255,255,255,.02));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.1);
            animation: rjAgFloat 5s ease-in-out infinite;
            animation-delay: calc(var(--i, 0) * -1.2s);
            transition: border-color .3s, box-shadow .3s;
        }

        #{{ $uid }} .rj-ag-c {
            position: absolute;
            width: 5px;
            height: 5px;
            background: #fff;
            transition: background .3s, transform .3s, box-shadow .3s;
        }
        #{{ $uid }} .rj-ag-c.tl { top: -3px;    left: -3px; }
        #{{ $uid }} .rj-ag-c.tr { top: -3px;    right: -3px; }
        #{{ $uid }} .rj-ag-c.bl { bottom: -3px; left: -3px; }
        #{{ $uid }} .rj-ag-c.br { bottom: -3px; right: -3px; }

        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-wrap {
            border-color: rgba(96,165,250,.8);
            box-shadow: 0 0 36px rgba(59,130,246,.35), inset 0 0 22px rgba(59,130,246,.12);
        }
        #{{ $uid }} .rj-ag-card:hover .rj-ag-c {
            background: #60a5fa;
            transform: scale(1.4);
            box-shadow: 0 0 10px #60a5fa;
        }

        /* sabit ölçü: fırlanma düz mərkəzdən olsun */
        #{{ $uid }} .rj-ag-icon-inner {
            width: 38px;
            height: 38px;
            color: #6d8cff;
            filter: drop-shadow(0 0 10px rgba(99,102,241,.6));
            display: flex;
            align-items: center;
            justify-content: center;
            transform-origin: 50% 50%;
            will-change: transform;
            transition: color .3s, filter .3s;
        }

        #{{ $uid }} .rj-ag-icon-inner svg,
        #{{ $uid }} .rj-ag-icon-inner iconify-icon {
            width: 38px;
            height: 38px;
            display: block;
            stroke-width: 1.2;
            transform-origin: 50% 50%;
        }

        /* hover-də 3 dəfə tam fırlanır */
        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-inner {
            color: #93c5fd;
            filter: drop-shadow(0 0 16px rgba(96,165,250,.9));
            animation: rjAgSpin3 1.5s cubic-bezier(.45,.05,.25,1) 1 both !important;
        }

        /* ---------- TEXT ---------- */
        #{{ $uid }} .rj-ag-card-title {
            font-size: 22px;
            font-weight: 500;
            color: #fff;
            margin: 0 0 12px;
            letter-spacing: -0.01em;
        }

        #{{ $uid }} .rj-ag-card-desc {
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255,255,255,.66);
            margin: 0 0 28px;
            max-width: 290px;
            overflow-wrap: anywhere;
        }

        /* ---------- GLASS BUTTON ---------- */
        #{{ $uid }} .rj-ag-btn {
            position: relative;
            overflow: hidden;
            margin-top: auto;
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 240px;
            padding: 15px 28px;
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(255,255,255,.1), rgba(255,255,255,.02));
            border: 1px solid rgba(255,255,255,.14);
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            backdrop-filter: blur(14px) saturate(140%);
            -webkit-backdrop-filter: blur(14px) saturate(140%);
            box-shadow: 0 10px 30px -15px rgba(0,0,0,.6), inset 0 1px 0 rgba(255,255,255,.14);
            transition: transform .3s, border-color .3s, box-shadow .3s, background .3s;
        }

        #{{ $uid }} .rj-ag-btn span { position: relative; z-index: 1; }

        #{{ $uid }} .rj-ag-btn::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            left: -70%;
            width: 50%;
            background: linear-gradient(100deg, transparent, rgba(255,255,255,.35), transparent);
            transform: skewX(-20deg);
            transition: left .7s ease;
        }

        #{{ $uid }} .rj-ag-btn:hover {
            background: linear-gradient(180deg, rgba(96,165,250,.24), rgba(59,130,246,.06));
            border-color: rgba(96,165,250,.8);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -10px rgba(59,130,246,.6), inset 0 1px 0 rgba(255,255,255,.2);
        }
        #{{ $uid }} .rj-ag-btn:hover::before { left: 130%; }

        /* ---------- KEYFRAMES ---------- */
        @keyframes rjAgTwinkle { from { opacity: .45; } to { opacity: .95; } }
        @keyframes rjAgPulse   { from { opacity: .65; transform: scale(1); } to { opacity: 1; transform: scale(1.06); } }
        @keyframes rjAgDrift   { from { transform: rotate(-12deg) translateX(-4%); } to { transform: rotate(-9deg) translateX(4%); } }
        @keyframes rjAgSpin    { to { transform: rotate(360deg); } }
        @keyframes rjAgFloat   { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes rjAgSpin3   {
            0%   { transform: rotate(0deg) scale(1); }
            50%  { transform: rotate(540deg) scale(1.25); }
            100% { transform: rotate(1080deg) scale(1); }
        }

        /* ---------- RESPONSIVE (blokun eninə görə) ---------- */
        @container (max-width: 860px) {
            #{{ $uid }} .rj-ag-inner { padding: 56px 20px 56px; }
            #{{ $uid }} .rj-ag-grid { grid-template-columns: 1fr; gap: 20px; }
            #{{ $uid }} .rj-ag-title { margin-bottom: 40px; }
            #{{ $uid }} .rj-ag-ring { right: -40cqw; width: 150cqw; }
        }

        /* yalnız fon animasiyaları söndürülür, ikon fırlanması işləyir */
        @media (prefers-reduced-motion: reduce) {
            #{{ $uid }} .rj-ag-stars,
            #{{ $uid }} .rj-ag-streak,
            #{{ $uid }} .rj-ag-glow,
            #{{ $uid }} .rj-ag-ring::before,
            #{{ $uid }} .rj-ag-icon-wrap { animation: none !important; }
        }
    </style>
=======
        }

        /* İkon və Künc Nöqtələri */
        #{{ $uid }} .rj-act-icon-wrap {
            position: relative;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        /* Künclərdəki nöqtələr */
        #{{ $uid }} .rj-act-icon-wrap::before,
        #{{ $uid }} .rj-act-icon-wrap::after {
            content: '';
            position: absolute;
            width: 4px; height: 4px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(255,255,255,0.8);
        }
        #{{ $uid }} .rj-act-icon-wrap::before { top: -2px; left: -2px; }
        #{{ $uid }} .rj-act-icon-wrap::after { bottom: -2px; right: -2px; }

        #{{ $uid }} .rj-act-card:hover .rj-act-icon-wrap {
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(59, 130, 246, 0.05);
        }

        /* İkonun özü */
        #{{ $uid }} .rj-act-icon-wrap iconify-icon {
            font-size: 32px;
            color: #3b82f6;
            stroke-width: 1.5;
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.5));
            transition: transform 0.3s ease;
        }
        #{{ $uid }} .rj-act-card:hover .rj-act-icon-wrap iconify-icon {
            transform: scale(1.1);
        }

        /* Mətnlər */
        #{{ $uid }} .rj-act-title {
            font-size: 24px;
            font-weight: 500;
            color: #fff;
            margin: 0 0 16px;
            letter-spacing: -0.01em;
        }

        #{{ $uid }} .rj-act-desc {
            font-size: 16px;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.7);
            margin: 0 0 32px;
            max-width: 280px;
            flex: 1;
        }

        /* Düymə */
        #{{ $uid }} .rj-act-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 32px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease;
            min-width: 160px;
        }
        #{{ $uid }} .rj-act-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            color: #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        }

        /* Mobil Uyğunluq */
        @media (max-width: 968px) {
            #{{ $uid }} .rj-act-grid {
                grid-template-columns: 1fr;
                gap: 64px;
            }
            #{{ $uid }} .rj-act-desc {
                max-width: 100%;
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-act-section { padding: 60px 20px; }
            #{{ $uid }} .rj-act-main-title { margin-bottom: 56px; }
        }
    </style>

    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
</section>
