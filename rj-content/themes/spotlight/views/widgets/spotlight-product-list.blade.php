@php
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $products = $settings['products'] ?? [];
    $uid = 'pl_' . substr(md5(uniqid('', true)), 0, 8);
@endphp

<section class="rj-pl-section" id="{{ $uid }}">
    <div class="rj-pl-inner">
        
        @if($title || $subtitle)
            <div class="rj-pl-header">
                @if($title)
                    <h2 class="rj-pl-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-pl-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        @if(!empty($products))
            <div class="rj-pl-grid">
                @foreach($products as $item)
                    <div class="rj-pl-card">
                        <div class="rj-pl-image-wrap">
                            @if(!empty($item['image']))
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] ?? '' }}" loading="lazy">
                            @else
                                <div class="rj-pl-placeholder">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                </div>
                            @endif
                            
                            @if(!empty($item['price']))
                                <div class="rj-pl-price-badge">{{ $item['price'] }}</div>
                            @endif
                        </div>

                        <div class="rj-pl-content">
                            <h3 class="rj-pl-item-title">{{ $item['title'] ?? '' }}</h3>
                            <p class="rj-pl-desc">{{ $item['desc'] ?? '' }}</p>
                            
                            @if(!empty($item['btn_text']) && !empty($item['btn_url']))
                                <a href="{{ $item['btn_url'] }}" class="rj-pl-btn">
                                    <span>{{ $item['btn_text'] }}</span>
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-pl-section {
            position: relative;
            padding: 100px 24px;
            background: transparent;
            z-index: 1;
        }

        #{{ $uid }} .rj-pl-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        #{{ $uid }} .rj-pl-header {
            text-align: center;
            margin-bottom: 64px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        #{{ $uid }} .rj-pl-title {
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 500;
            color: #fff;
            margin: 0 0 16px;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        #{{ $uid }} .rj-pl-subtitle {
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }

        #{{ $uid }} .rj-pl-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 32px;
        }

        #{{ $uid }} .rj-pl-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #{{ $uid }} .rj-pl-card:hover {
            transform: translateY(-6px);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 20px 40px -20px rgba(59, 130, 246, 0.4);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
        }

        #{{ $uid }} .rj-pl-image-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            background: rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        #{{ $uid }} .rj-pl-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        #{{ $uid }} .rj-pl-card:hover .rj-pl-image-wrap img {
            transform: scale(1.05);
        }

        #{{ $uid }} .rj-pl-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.1);
        }

        #{{ $uid }} .rj-pl-placeholder svg {
            width: 48px;
            height: 48px;
        }

        #{{ $uid }} .rj-pl-price-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(10, 10, 15, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
            z-index: 2;
        }

        #{{ $uid }} .rj-pl-content {
            padding: 28px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        #{{ $uid }} .rj-pl-item-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 12px;
            line-height: 1.3;
        }

        #{{ $uid }} .rj-pl-desc {
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.5);
            margin: 0 0 24px;
            flex: 1;
        }

        #{{ $uid }} .rj-pl-btn {
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 14px 20px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        #{{ $uid }} .rj-pl-btn svg {
            width: 18px;
            height: 18px;
            transition: transform 0.2s ease;
        }

        #{{ $uid }} .rj-pl-btn:hover {
            background: #3b82f6;
            border-color: #3b82f6;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
        }

        #{{ $uid }} .rj-pl-btn:hover svg {
            transform: translateX(4px);
        }

        @media (max-width: 768px) {
            #{{ $uid }}.rj-pl-section {
                padding: 64px 20px;
            }
            #{{ $uid }} .rj-pl-header {
                margin-bottom: 40px;
            }
            #{{ $uid }} .rj-pl-content {
                padding: 20px;
            }
        }
    </style>
</section>