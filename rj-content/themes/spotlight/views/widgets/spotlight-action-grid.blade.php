@php
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
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
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
</section>
