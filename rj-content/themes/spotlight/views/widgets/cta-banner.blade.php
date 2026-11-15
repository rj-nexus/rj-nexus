<style>
    #{{ $uid }} {
        width: 100%;
        padding: 96px 24px;
        background: transparent;
        font-family: var(--rj-font-body);
    }

    #{{ $uid }} .rj-cta-wrap {
        max-width: var(--rj-container);
        margin: 0 auto;
        position: relative;
        border-radius: var(--rj-radius-lg);
        overflow: hidden;
        text-align: center;
        padding: 72px 32px;
        border: 1px solid var(--rj-border);
    }

    #{{ $uid }}[data-style="dark"] .rj-cta-wrap {
        background: var(--rj-surface);
    }

    #{{ $uid }}[data-style="glass"] .rj-cta-wrap {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-color: rgba(255, 255, 255, 0.1);
        box-shadow: 0 24px 64px -12px rgba(0, 0, 0, 0.4);
    }

    #{{ $uid }}[data-style="gradient"] .rj-cta-wrap {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #4c1d95 100%);
        border-color: rgba(139, 92, 246, 0.3);
    }

    #{{ $uid }} .rj-cta-glow {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: 
            radial-gradient(ellipse 60% 60% at 50% 100%, rgba(139, 92, 246, 0.3), transparent 70%),
            radial-gradient(circle at 80% 20%, rgba(236, 72, 153, 0.15), transparent 50%);
        z-index: 0;
    }

    #{{ $uid }}[data-style="dark"] .rj-cta-glow,
    #{{ $uid }}[data-style="glass"] .rj-cta-glow {
        display: none;
    }

    #{{ $uid }} .rj-cta-grid {
        position: absolute;
        inset: 0;
        background-image: 
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
        mask-image: radial-gradient(ellipse 50% 50% at 50% 50%, #000 20%, transparent 80%);
        -webkit-mask-image: radial-gradient(ellipse 50% 50% at 50% 50%, #000 20%, transparent 80%);
        z-index: 0;
        pointer-events: none;
    }

    #{{ $uid }} .rj-cta-content {
        position: relative;
        z-index: 1;
        max-width: 680px;
        margin: 0 auto;
    }

    #{{ $uid }} .rj-cta-title {
        font-size: clamp(32px, 5vw, 48px);
        font-weight: 800;
        color: #ffffff;
        line-height: 1.15;
        margin: 0 0 20px 0;
        letter-spacing: -0.025em;
    }

    #{{ $uid }} .rj-cta-subtitle {
        font-size: clamp(16px, 2vw, 18px);
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
        margin: 0 0 40px 0;
    }

    #{{ $uid }} .rj-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 36px;
        border-radius: var(--rj-radius);
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 12px 32px -8px rgba(139, 92, 246, 0.6);
    }

    #{{ $uid }} .rj-cta-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 40px -8px rgba(139, 92, 246, 0.8);
        color: #ffffff;
    }

    #{{ $uid }} .rj-cta-btn svg {
        width: 18px;
        height: 18px;
        transition: transform 0.3s ease;
    }

    #{{ $uid }} .rj-cta-btn:hover svg {
        transform: translateX(4px);
    }

    @media (max-width: 768px) {
        #{{ $uid }} {
            padding: 64px 20px;
        }
        #{{ $uid }} .rj-cta-wrap {
            padding: 56px 24px;
        }
        #{{ $uid }} .rj-cta-btn {
            width: 100%;
        }
    }
</style>

<div id="{{ $uid }}" data-style="{{ $settings['style'] ?? 'gradient' }}">
    <div class="rj-cta-wrap">
        <div class="rj-cta-glow"></div>
        <div class="rj-cta-grid"></div>
        
        <div class="rj-cta-content">
            @if(!empty($settings['title']))
                <h2 class="rj-cta-title">{{ $settings['title'] }}</h2>
            @endif

            @if(!empty($settings['subtitle']))
                <p class="rj-cta-subtitle">{{ $settings['subtitle'] }}</p>
            @endif

            @if(!empty($settings['button_text']))
                <a href="{{ $settings['button_url'] ?? '#' }}" class="rj-cta-btn">
                    {{ $settings['button_text'] }}
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>