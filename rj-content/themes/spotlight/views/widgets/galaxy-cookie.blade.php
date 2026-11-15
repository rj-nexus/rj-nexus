<style>
    #{{ $uid }} {
        position: fixed;
        z-index: 99999;
        max-width: 420px;
        width: calc(100% - 32px);
        bottom: 24px;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.6s ease;
    }
    #{{ $uid }}.rj-gc-hidden {
        transform: translateY(150%);
        opacity: 0;
        pointer-events: none;
    }
    #{{ $uid }}[data-position="bottom-right"] { right: 24px; }
    #{{ $uid }}[data-position="bottom-left"] { left: 24px; }
    #{{ $uid }}[data-position="bottom-center"] { left: 50%; transform: translateX(-50%); }
    #{{ $uid }}[data-position="bottom-center"].rj-gc-hidden { transform: translateX(-50%) translateY(150%); }

    #{{ $uid }} .rj-gc-card {
        position: relative;
        background: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 20px;
        padding: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px -12px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);
    }

    #{{ $uid }} .rj-gc-stars {
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(1px 1px at 20px 30px, #ffffff, rgba(0,0,0,0)),
            radial-gradient(1px 1px at 40px 70px, #ffffff, rgba(0,0,0,0)),
            radial-gradient(1px 1px at 50px 160px, #ffffff, rgba(0,0,0,0)),
            radial-gradient(1px 1px at 90px 40px, #ffffff, rgba(0,0,0,0)),
            radial-gradient(1.5px 1.5px at 130px 80px, #a78bfa, rgba(0,0,0,0)),
            radial-gradient(1px 1px at 160px 120px, #ffffff, rgba(0,0,0,0));
        background-repeat: repeat;
        background-size: 200px 200px;
        opacity: 0.4;
        pointer-events: none;
        animation: rjGcTwinkle 4s linear infinite;
    }

    @keyframes rjGcTwinkle {
        0%, 100% { opacity: 0.4; }
        50% { opacity: 0.7; }
    }

    #{{ $uid }} .rj-gc-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.15), transparent 60%);
        pointer-events: none;
        animation: rjGcPulse 6s ease-in-out infinite alternate;
    }

    @keyframes rjGcPulse {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(1.1); opacity: 0.8; }
    }

    #{{ $uid }} .rj-gc-content {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    #{{ $uid }} .rj-gc-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(236, 72, 153, 0.2));
        border: 1px solid rgba(139, 92, 246, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a78bfa;
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
    }

    #{{ $uid }} .rj-gc-text h4 {
        color: #f8fafc;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 6px 0;
        letter-spacing: -0.01em;
    }

    #{{ $uid }} .rj-gc-text p {
        color: #94a3b8;
        font-size: 13px;
        line-height: 1.5;
        margin: 0;
    }

    #{{ $uid }} .rj-gc-actions {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 12px;
    }

    #{{ $uid }} .rj-gc-btn {
        flex: 1;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        text-align: center;
        border: none;
        font-family: inherit;
    }

    #{{ $uid }} .rj-gc-btn-accept {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        color: #ffffff;
        box-shadow: 0 8px 20px -6px rgba(139, 92, 246, 0.6);
    }

    #{{ $uid }} .rj-gc-btn-accept:hover {
        box-shadow: 0 12px 24px -6px rgba(139, 92, 246, 0.8);
        transform: translateY(-1px);
    }

    #{{ $uid }} .rj-gc-btn-decline {
        background: transparent;
        color: #94a3b8;
        border: 1px solid rgba(148, 163, 184, 0.3);
    }

    #{{ $uid }} .rj-gc-btn-decline:hover {
        color: #f8fafc;
        border-color: rgba(148, 163, 184, 0.6);
        background: rgba(148, 163, 184, 0.1);
    }

    @media (max-width: 480px) {
        #{{ $uid }} { bottom: 16px; width: calc(100% - 32px); left: 16px !important; right: 16px !important; transform: none !important; }
        #{{ $uid }}.rj-gc-hidden { transform: translateY(150%) !important; }
        #{{ $uid }} .rj-gc-actions { flex-direction: column-reverse; }
    }
</style>

<div id="{{ $uid }}" class="rj-gc-hidden" data-position="{{ $settings['position'] ?? 'bottom-right' }}">
    <div class="rj-gc-card">
        <div class="rj-gc-stars"></div>
        <div class="rj-gc-glow"></div>
        
        <div class="rj-gc-content">
            <div class="rj-gc-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
                </svg>
            </div>
            <div class="rj-gc-text">
                <h4>{{ $settings['title'] ?? __('We value your privacy') }}</h4>
                <p>{{ $settings['message'] ?? __('We use cookies to enhance your browsing experience and analyze our traffic.') }}</p>
            </div>
        </div>

        <div class="rj-gc-actions">
            <button type="button" class="rj-gc-btn rj-gc-btn-decline" data-action="decline">
                {{ $settings['decline_text'] ?? __('Decline') }}
            </button>
            <button type="button" class="rj-gc-btn rj-gc-btn-accept" data-action="accept">
                {{ $settings['accept_text'] ?? __('Accept All') }}
            </button>
        </div>
    </div>
</div>

<script>
    (function() {
        var root = document.getElementById('{{ $uid }}');
        if (!root) return;

        var consent = localStorage.getItem('rj_cookie_consent');

        if (!consent) {
            setTimeout(function() {
                root.classList.remove('rj-gc-hidden');
            }, 1500);
        }

        function handleConsent(action) {
            localStorage.setItem('rj_cookie_consent', action);
            localStorage.setItem('rj_cookie_consent_date', new Date().toISOString());
            
            root.classList.add('rj-gc-hidden');
            
            setTimeout(function() {
                root.remove();
            }, 600);
        }

        root.querySelectorAll('.rj-gc-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                handleConsent(this.getAttribute('data-action'));
            });
        });
    })();
</script>