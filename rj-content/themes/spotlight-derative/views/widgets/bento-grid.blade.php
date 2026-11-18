<style>
    #{{ $uid }} {
        width: 100%;
        padding: 96px 24px;
        background: transparent;
        font-family: var(--rj-font-body);
    }

    #{{ $uid }} .rj-bento-header {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 56px;
    }

    #{{ $uid }} .rj-bento-title {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        color: var(--rj-text);
        line-height: 1.15;
        margin: 0 0 16px 0;
        letter-spacing: -0.02em;
    }

    #{{ $uid }} .rj-bento-subtitle {
        font-size: 16px;
        line-height: 1.6;
        color: var(--rj-muted);
        margin: 0;
    }

    #{{ $uid }} .rj-bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: minmax(220px, auto);
        gap: 20px;
        max-width: var(--rj-container);
        margin: 0 auto;
    }

    #{{ $uid }} .rj-bento-item {
        position: relative;
        border-radius: var(--rj-radius-lg);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 28px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
    }

    #{{ $uid }} .rj-bento-item:hover {
        transform: translateY(-4px);
    }

    #{{ $uid }} .rj-bento-item.size-1x1 { grid-column: span 1; grid-row: span 1; }
    #{{ $uid }} .rj-bento-item.size-2x1 { grid-column: span 2; grid-row: span 1; }
    #{{ $uid }} .rj-bento-item.size-1x2 { grid-column: span 1; grid-row: span 2; }
    #{{ $uid }} .rj-bento-item.size-2x2 { grid-column: span 2; grid-row: span 2; }

    #{{ $uid }} .rj-bento-item.style-glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }
    #{{ $uid }} .rj-bento-item.style-glass:hover {
        border-color: rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.05);
    }

    #{{ $uid }} .rj-bento-item.style-solid {
        background: var(--rj-surface);
        border: 1px solid var(--rj-border);
    }
    #{{ $uid }} .rj-bento-item.style-solid:hover {
        border-color: rgba(167, 139, 250, 0.4);
    }

    #{{ $uid }} .rj-bento-item.style-gradient {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(236, 72, 153, 0.05));
        border: 1px solid rgba(139, 92, 246, 0.25);
    }
    #{{ $uid }} .rj-bento-item.style-gradient:hover {
        border-color: rgba(139, 92, 246, 0.5);
        box-shadow: 0 0 30px -10px rgba(139, 92, 246, 0.4);
    }

    #{{ $uid }} .rj-bento-bg {
        position: absolute;
        inset: 0;
        z-index: 0;
    }
    #{{ $uid }} .rj-bento-bg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.4;
        transition: opacity 0.4s ease, transform 0.6s ease;
    }
    #{{ $uid }} .rj-bento-item:hover .rj-bento-bg img {
        opacity: 0.6;
        transform: scale(1.05);
    }
    #{{ $uid }} .rj-bento-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10, 10, 15, 0.95) 0%, rgba(10, 10, 15, 0.4) 50%, transparent 100%);
        z-index: 1;
    }

    #{{ $uid }} .rj-bento-content {
        position: relative;
        z-index: 2;
    }

    #{{ $uid }} .rj-bento-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--rj-primary);
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    #{{ $uid }} .rj-bento-icon svg {
        width: 24px;
        height: 24px;
    }

    #{{ $uid }} .rj-bento-item-title {
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 8px 0;
        line-height: 1.3;
        letter-spacing: -0.01em;
    }

    #{{ $uid }} .rj-bento-desc {
        font-size: 14px;
        line-height: 1.5;
        color: #94a3b8;
        margin: 0;
    }

    @media (max-width: 1024px) {
        #{{ $uid }} .rj-bento-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: minmax(200px, auto);
        }
        #{{ $uid }} .rj-bento-item.size-2x2 { grid-column: span 2; grid-row: span 1; }
        #{{ $uid }} .rj-bento-item.size-1x2 { grid-column: span 1; grid-row: span 1; }
    }

    @media (max-width: 640px) {
        #{{ $uid }} {
            padding: 64px 20px;
        }
        #{{ $uid }} .rj-bento-grid {
            grid-template-columns: 1fr;
            grid-auto-rows: minmax(200px, auto);
        }
        #{{ $uid }} .rj-bento-item.size-2x1,
        #{{ $uid }} .rj-bento-item.size-1x2,
        #{{ $uid }} .rj-bento-item.size-2x2 {
            grid-column: span 1;
            grid-row: span 1;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-bento-header">
        @if(!empty($settings['title']))
            <h2 class="rj-bento-title">{{ $settings['title'] }}</h2>
        @endif
        @if(!empty($settings['subtitle']))
            <p class="rj-bento-subtitle">{{ $settings['subtitle'] }}</p>
        @endif
    </div>

    <div class="rj-bento-grid">
        @foreach($settings['items'] ?? [] as $item)
            @php
                $size = $item['size'] ?? '1x1';
                $style = $item['style'] ?? 'glass';
                $hasImage = !empty($item['image']);
            @endphp
            
            <div class="rj-bento-item size-{{ $size }} style-{{ $style }}">
                @if($hasImage)
                    <div class="rj-bento-bg">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] ?? '' }}" loading="lazy">
                        <div class="rj-bento-overlay"></div>
                    </div>
                @endif

                <div class="rj-bento-content">
                    @if(!empty($item['icon']))
                        <div class="rj-bento-icon">
                            {!! rj_icon($item['icon']) !!}
                        </div>
                    @endif

                    @if(!empty($item['title']))
                        <h3 class="rj-bento-item-title">{{ $item['title'] }}</h3>
                    @endif

                    @if(!empty($item['description']))
                        <p class="rj-bento-desc">{{ $item['description'] }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>