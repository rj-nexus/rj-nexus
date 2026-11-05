@php
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
                <div class="rj-ag-card">
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
                        <a href="{{ $item['btn_url'] }}" class="rj-ag-btn">{{ $item['btn_text'] }}</a>
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

        /* ---------- BACKGROUND (bloku aşmır) ---------- */
        #{{ $uid }} .rj-ag-bg {
            position: absolute;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        /* ulduzlar */
        #{{ $uid }} .rj-ag-stars {
            position: absolute;
            inset: 0;
            opacity: .7;
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
        }

        /* qalaktika zolağı */
        #{{ $uid }} .rj-ag-streak {
            position: absolute;
            left: -20%;
            top: 42%;
            width: 140%;
            height: 34%;
            transform: rotate(-12deg);
            border-radius: 50%;
            filter: blur(44px);
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(96,165,250,.12) 25%,
                rgba(191,219,254,.30) 55%,
                rgba(96,165,250,.14) 80%,
                transparent 100%);
        }

        #{{ $uid }} .rj-ag-glow {
            position: absolute;
            inset: -20% -10% auto -10%;
            height: 120%;
            background: radial-gradient(ellipse at 50% 45%, rgba(59,130,246,.14) 0%, transparent 60%);
        }

        /* nazik dairə qövsü — sağda yarı görünür */
        #{{ $uid }} .rj-ag-ring {
            position: absolute;
            width: min(1000px, 120cqw);
            aspect-ratio: 1;
            right: -22cqw;
            top: -12%;
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
            background: conic-gradient(from 200deg, transparent 0deg, rgba(147,197,253,.9) 70deg, transparent 140deg, transparent 360deg);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
        }

        /* "+" işarəli üfüqi xətt */
        #{{ $uid }} .rj-ag-line {
            position: absolute;
            left: 0; right: 0;
            top: 90px;
            height: 1px;
            background: linear-gradient(90deg, rgba(255,255,255,.05), rgba(255,255,255,.16) 15%, rgba(255,255,255,.16) 85%, rgba(255,255,255,.05));
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
            padding: 150px 24px 100px;
        }

        #{{ $uid }} .rj-ag-title {
            font-size: clamp(34px, 9cqw, 64px);
            font-weight: 500;
            text-align: center;
            margin: 0 auto 90px;
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
            gap: 32px;
            align-items: stretch;
        }

        #{{ $uid }} .rj-ag-card {
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 8px;
        }

        /* ikon qutusu: çərçivə + 4 künc nöqtəsi */
        #{{ $uid }} .rj-ag-icon-wrap {
            position: relative;
            width: 88px;
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.02);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: border-color .3s, box-shadow .3s;
        }

        #{{ $uid }} .rj-ag-c {
            position: absolute;
            width: 5px;
            height: 5px;
            background: #fff;
            transition: background .3s, transform .3s;
        }
        #{{ $uid }} .rj-ag-c.tl { top: -3px;    left: -3px; }
        #{{ $uid }} .rj-ag-c.tr { top: -3px;    right: -3px; }
        #{{ $uid }} .rj-ag-c.bl { bottom: -3px; left: -3px; }
        #{{ $uid }} .rj-ag-c.br { bottom: -3px; right: -3px; }

        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-wrap {
            border-color: rgba(59,130,246,.7);
            box-shadow: 0 0 30px rgba(59,130,246,.25), inset 0 0 20px rgba(59,130,246,.08);
        }
        #{{ $uid }} .rj-ag-card:hover .rj-ag-c { background: #3b82f6; transform: scale(1.3); }

        #{{ $uid }} .rj-ag-icon-inner {
            color: #6d8cff;
            filter: drop-shadow(0 0 10px rgba(99,102,241,.55));
            transition: transform .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #{{ $uid }} .rj-ag-icon-inner svg,
        #{{ $uid }} .rj-ag-icon-inner iconify-icon {
            width: 38px;
            height: 38px;
            stroke-width: 1.2;
        }

        #{{ $uid }} .rj-ag-card:hover .rj-ag-icon-inner { transform: scale(1.1); }

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
            color: rgba(255,255,255,.62);
            margin: 0 0 32px;
            max-width: 290px;
            overflow-wrap: anywhere;
        }

        /* düymə həmişə kartın altında, eyni xətdə */
        #{{ $uid }} .rj-ag-btn {
            margin-top: auto;
            box-sizing: border-box;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 260px;
            padding: 16px 28px;
            border-radius: 12px;
            background: rgba(10,10,16,.75);
            border: 1px solid rgba(255,255,255,.08);
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all .25s;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #{{ $uid }} .rj-ag-btn:hover {
            background: rgba(59,130,246,.12);
            border-color: #3b82f6;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px -10px rgba(59,130,246,.5);
        }

        /* blokun öz eninə görə (ekrana yox) */
        @container (max-width: 860px) {
            #{{ $uid }} .rj-ag-inner { padding: 120px 20px 70px; }
            #{{ $uid }} .rj-ag-grid { grid-template-columns: 1fr; gap: 56px; }
            #{{ $uid }} .rj-ag-title { margin-bottom: 56px; }
            #{{ $uid }} .rj-ag-line { top: 70px; }
            #{{ $uid }} .rj-ag-ring { right: -40cqw; width: 150cqw; }
        }
    </style>
</section>
