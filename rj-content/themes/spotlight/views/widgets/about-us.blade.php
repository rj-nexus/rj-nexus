<style>
    #{{ $uid }} {
        width: 100%;
        padding: 80px 24px;
        background: transparent;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    #{{ $uid }} .rj-au-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 64px;
        flex-wrap: wrap;
    }

    #{{ $uid }} .rj-au-text {
        flex: 1;
        min-width: 300px;
        order: {{ ($settings['image_position'] ?? 'right') === 'left' ? 2 : 1 }};
    }

    #{{ $uid }} .rj-au-image-wrap {
        flex: 1;
        min-width: 300px;
        order: {{ ($settings['image_position'] ?? 'right') === 'left' ? 1 : 2 }};
        position: relative;
    }

    #{{ $uid }} .rj-au-title {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        margin: 0 0 24px 0;
        letter-spacing: -0.02em;
    }

    #{{ $uid }} .rj-au-content {
        font-size: 16px;
        line-height: 1.7;
        color: #4b5563;
        margin: 0 0 32px 0;
    }

    #{{ $uid }} .rj-au-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: 12px;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 10px 24px -8px rgba(124, 58, 237, 0.5);
    }

    #{{ $uid }} .rj-au-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 32px -8px rgba(124, 58, 237, 0.6);
        color: #ffffff;
    }

    #{{ $uid }} .rj-au-img {
        width: 100%;
        height: auto;
        border-radius: 24px;
        box-shadow: 0 24px 64px -16px rgba(15, 23, 42, 0.25);
        display: block;
        object-fit: cover;
        aspect-ratio: 4/3;
    }

    #{{ $uid }} .rj-au-img-placeholder {
        width: 100%;
        aspect-ratio: 4/3;
        border-radius: 24px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        border: 2px dashed #cbd5e1;
    }

    @media (max-width: 768px) {
        #{{ $uid }} {
            padding: 48px 20px;
        }
        #{{ $uid }} .rj-au-container {
            gap: 40px;
        }
        #{{ $uid }} .rj-au-text {
            order: 2 !important; /* Mobil görünüşdə həmişə yazı aşağıda olsun */
        }
        #{{ $uid }} .rj-au-image-wrap {
            order: 1 !important;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-au-container">
        
        <div class="rj-au-text">
            @if(!empty($settings['title']))
                <h2 class="rj-au-title">{{ $settings['title'] }}</h2>
            @endif

            @if(!empty($settings['content']))
                <div class="rj-au-content">
                    {!! nl2br(e($settings['content'])) !!}
                </div>
            @endif

            @if(!empty($settings['button_text']))
                <a href="{{ $settings['button_url'] ?? '#' }}" class="rj-au-btn">
                    {{ $settings['button_text'] }}
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>

        <div class="rj-au-image-wrap">
            @if(!empty($settings['image']))
                <img src="{{ $settings['image'] }}" alt="{{ $settings['title'] ?? 'About Us' }}" class="rj-au-img">
            @else
                <div class="rj-au-img-placeholder">
                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </div>

    </div>
</div>