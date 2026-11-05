@php
    $mainTitle = $settings['main_title'] ?? '';
    $items = $settings['items'] ?? [];
@endphp

<section class="rj-ag-section">
    <div class="rj-ag-inner">
        @if($mainTitle)
            <h2 class="rj-ag-title">{{ $mainTitle }}</h2>
        @endif

        <div class="rj-ag-grid">
            @foreach($items as $item)
                <div class="rj-ag-card">
                    <div class="rj-ag-icon">
                        <iconify-icon icon="{{ $item['icon'] ?? 'ph:star' }}"></iconify-icon>
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
        .rj-ag-section {
            position: relative;
            z-index: 1;
            padding: 80px 24px;
            background: transparent;
        }
        .rj-ag-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }
        .rj-ag-title {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 600;
            color: #fff;
            text-align: center;
            margin: 0 0 48px;
            letter-spacing: -0.02em;
        }
        .rj-ag-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .rj-ag-card {
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: 24px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transition: border-color .2s, transform .2s;
        }
        .rj-ag-card:hover {
            border-color: var(--rj-primary);
            transform: translateY(-4px);
        }
        .rj-ag-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: color-mix(in srgb, var(--rj-primary) 15%, transparent);
            color: var(--rj-primary);
            font-size: 24px;
            margin-bottom: 24px;
        }
        .rj-ag-card-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 12px;
        }
        .rj-ag-card-desc {
            font-size: 15px;
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0 0 24px;
            flex-grow: 1;
        }
        .rj-ag-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 24px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }
        .rj-ag-btn:hover {
            background: var(--rj-primary);
            border-color: var(--rj-primary);
            color: #000;
        }
        @media (max-width: 968px) {
            .rj-ag-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .rj-ag-grid { grid-template-columns: 1fr; }
            .rj-ag-section { padding: 48px 20px; }
        }
    </style>
</section>
