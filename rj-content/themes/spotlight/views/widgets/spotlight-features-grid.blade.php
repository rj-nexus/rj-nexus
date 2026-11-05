@php
    $uid = 'fg_' . substr(md5(uniqid('', true)), 0, 8);

    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $features = $settings['features'] ?? [];
    if (!is_array($features)) $features = [];
    $features = array_slice(array_values($features), 0, 6);
@endphp

<section class="rj-fg-section" id="{{ $uid }}">
    <div class="rj-fg-inner">

        {{-- Başlıq Hissəsi --}}
        @if($title || $subtitle)
            <div class="rj-fg-header">
                @if($title)
                    <h2 class="rj-fg-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-fg-sub">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        {{-- Xüsusiyyətlər Gridi --}}
        @if(!empty($features))
            <div class="rj-fg-grid">
                @foreach($features as $index => $item)
                    <div class="rj-fg-card" style="--i: {{ $index }};">
                        @if(!empty($item['icon']))
                            <div class="rj-fg-icon">
                                <iconify-icon icon="{{ $item['icon'] }}"></iconify-icon>
                            </div>
                        @endif
                        <h3 class="rj-fg-card-title">{{ $item['title'] ?? '' }}</h3>
                        <p class="rj-fg-card-text">{{ $item['text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-fg-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 100px 24px;
        }

        #{{ $uid }} .rj-fg-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        /* Başlıq */
        #{{ $uid }} .rj-fg-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 64px;
        }

        #{{ $uid }} .rj-fg-title {
            font-size: clamp(32px, 4.5vw, 48px);
            font-weight: 500;
            line-height: 1.15;
            letter-spacing: -0.03em;
            color: #fff;
            margin: 0 0 20px;
        }

        #{{ $uid }} .rj-fg-sub {
            font-size: clamp(16px, 2vw, 18px);
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
        }

        /* Grid */
        #{{ $uid }} .rj-fg-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 48px 32px;
        }

        /* Kart */
        #{{ $uid }} .rj-fg-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: rjFgIn 0.6s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }

        @keyframes rjFgIn {
            to { opacity: 1; transform: none; }
        }

        /* İkon */
        #{{ $uid }} .rj-fg-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 20px;
            color: #3b82f6; /* Mavi rəng */
        }

        #{{ $uid }} .rj-fg-icon iconify-icon {
            font-size: 32px;
            stroke-width: 1.5;
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.4));
        }

        /* Mətn */
        #{{ $uid }} .rj-fg-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 12px;
            letter-spacing: -0.01em;
        }

        #{{ $uid }} .rj-fg-card-text {
            font-size: 14px;
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
            max-width: 280px;
        }

        /* Mobil Uyğunluq */
        @media (max-width: 968px) {
            #{{ $uid }} .rj-fg-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px 24px;
            }
        }

        @media (max-width: 640px) {
            #{{ $uid }}.rj-fg-section {
                padding: 60px 20px;
            }
            #{{ $uid }} .rj-fg-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            #{{ $uid }} .rj-fg-card-text {
                max-width: 100%;
            }
        }
    </style>

    <script type="module" src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</section>
