<style>
    #{{ $uid }} {
        width: 100%;
        padding: 96px 24px;
        background: transparent;
        font-family: var(--rj-font-body);
    }

    #{{ $uid }} .rj-ct-header {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 56px;
    }

    #{{ $uid }} .rj-ct-title {
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        color: var(--rj-text);
        line-height: 1.15;
        margin: 0 0 16px 0;
        letter-spacing: -0.02em;
    }

    #{{ $uid }} .rj-ct-subtitle {
        font-size: 16px;
        line-height: 1.6;
        color: var(--rj-muted);
        margin: 0;
    }

    #{{ $uid }} .rj-ct-wrapper {
        max-width: var(--rj-container);
        margin: 0 auto;
        overflow-x: auto;
        padding-bottom: 24px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
    }

    #{{ $uid }} .rj-ct-grid {
        display: grid;
        grid-template-columns: minmax(200px, 1.5fr) repeat(3, minmax(180px, 1fr));
        gap: 12px;
        min-width: 800px;
    }

    #{{ $uid }} .rj-ct-cell {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: var(--rj-radius);
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s;
    }

    #{{ $uid }} .rj-ct-cell.rj-ct-feature-name {
        justify-content: flex-start;
        text-align: left;
        background: transparent;
        border-color: transparent;
        font-weight: 500;
        color: var(--rj-text);
    }

    /* Header Row Styles */
    #{{ $uid }} .rj-ct-plan-header {
        flex-direction: column;
        gap: 8px;
        padding: 32px 20px;
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.08);
    }

    #{{ $uid }} .rj-ct-plan-name {
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--rj-muted);
    }

    #{{ $uid }} .rj-ct-plan-price {
        font-size: 32px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
    }

    #{{ $uid }} .rj-ct-btn {
        display: inline-block;
        margin-top: 16px;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.2s;
        width: 100%;
    }

    #{{ $uid }} .rj-ct-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Popular Plan Highlight */
    #{{ $uid }} .rj-ct-popular {
        position: relative;
        background: rgba(139, 92, 246, 0.05);
        border-color: rgba(139, 92, 246, 0.3);
        box-shadow: 0 0 30px -10px rgba(139, 92, 246, 0.2);
    }

    #{{ $uid }} .rj-ct-popular-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 4px 12px;
        border-radius: 999px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }

    #{{ $uid }} .rj-ct-popular .rj-ct-btn {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        border: none;
        box-shadow: 0 8px 20px -6px rgba(139, 92, 246, 0.6);
    }

    #{{ $uid }} .rj-ct-popular .rj-ct-btn:hover {
        box-shadow: 0 12px 24px -6px rgba(139, 92, 246, 0.8);
        transform: translateY(-1px);
    }

    /* Icons */
    #{{ $uid }} .rj-ct-icon {
        width: 24px;
        height: 24px;
    }
    #{{ $uid }} .rj-ct-check {
        color: #10b981;
    }
    #{{ $uid }} .rj-ct-cross {
        color: #475569;
    }

    @media (max-width: 768px) {
        #{{ $uid }} {
            padding: 64px 20px;
        }
        #{{ $uid }} .rj-ct-grid {
            gap: 8px;
        }
        #{{ $uid }} .rj-ct-cell {
            padding: 16px;
        }
        #{{ $uid }} .rj-ct-feature-name {
            font-size: 14px;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-ct-header">
        @if(!empty($settings['title']))
            <h2 class="rj-ct-title">{{ $settings['title'] }}</h2>
        @endif
        @if(!empty($settings['subtitle']))
            <p class="rj-ct-subtitle">{{ $settings['subtitle'] }}</p>
        @endif
    </div>

    <div class="rj-ct-wrapper">
        <div class="rj-ct-grid">
            
            <!-- Header Row -->
            <div class="rj-ct-cell" style="background: transparent; border: none;"></div>
            
            @foreach($settings['plans'] ?? [] as $index => $plan)
                <div class="rj-ct-cell rj-ct-plan-header {{ !empty($plan['is_popular']) ? 'rj-ct-popular' : '' }}">
                    @if(!empty($plan['is_popular']))
                        <div class="rj-ct-popular-badge">{{ __('Popular') }}</div>
                    @endif
                    <div class="rj-ct-plan-name">{{ $plan['name'] ?? '' }}</div>
                    <div class="rj-ct-plan-price">{{ $plan['price'] ?? '' }}</div>
                    @if(!empty($plan['button_text']))
                        <a href="{{ $plan['button_url'] ?? '#' }}" class="rj-ct-btn">
                            {{ $plan['button_text'] }}
                        </a>
                    @endif
                </div>
            @endforeach

            <!-- Features Rows -->
            @foreach($settings['features'] ?? [] as $feature)
                <div class="rj-ct-cell rj-ct-feature-name">
                    {{ $feature['name'] ?? '' }}
                </div>

                @php
                    // Xüsusiyyətlərin sütunlarla (p1, p2, p3) uyğunlaşdırılması
                    $keys = ['p1', 'p2', 'p3'];
                @endphp

                @foreach($keys as $index => $key)
                    @if(isset($settings['plans'][$index]))
                        <div class="rj-ct-cell {{ !empty($settings['plans'][$index]['is_popular']) ? 'rj-ct-popular' : '' }}">
                            @if(!empty($feature[$key]))
                                <svg class="rj-ct-icon rj-ct-check" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="rj-ct-icon rj-ct-cross" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endforeach

        </div>
    </div>
</div>