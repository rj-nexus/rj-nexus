<style>
    #{{ $uid }} {
        width: 100%;
        padding: 80px 24px;
        background: transparent;
        font-family: var(--rj-font-body);
    }

    #{{ $uid }} .rj-stats-container {
        max-width: var(--rj-container);
        margin: 0 auto;
    }

    #{{ $uid }} .rj-stats-title {
        text-align: center;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 800;
        color: var(--rj-text);
        margin: 0 0 48px 0;
        letter-spacing: -0.02em;
    }

    #{{ $uid }} .rj-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }

    #{{ $uid }} .rj-stat-card {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 24px;
        border-radius: var(--rj-radius-lg);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    #{{ $uid }}[data-style="glass"] .rj-stat-card {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
    }

    #{{ $uid }}[data-style="glass"] .rj-stat-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.4);
    }

    #{{ $uid }}[data-style="minimal"] .rj-stat-card {
        padding: 20px;
        border: none;
        background: transparent;
    }

    #{{ $uid }} .rj-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(139, 92, 246, 0.1);
        color: var(--rj-primary);
        margin-bottom: 20px;
    }

    #{{ $uid }} .rj-stat-icon svg {
        width: 24px;
        height: 24px;
    }

    #{{ $uid }} .rj-stat-value {
        font-size: clamp(36px, 5vw, 48px);
        font-weight: 800;
        line-height: 1.1;
        margin: 0 0 8px 0;
        background: linear-gradient(135deg, #ffffff 0%, #a78bfa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.03em;
    }

    #{{ $uid }} .rj-stat-label {
        font-size: 15px;
        font-weight: 500;
        color: var(--rj-muted);
        margin: 0;
    }

    @media (max-width: 768px) {
        #{{ $uid }} {
            padding: 56px 20px;
        }
        #{{ $uid }} .rj-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        #{{ $uid }} .rj-stat-card {
            padding: 24px 16px;
        }
        #{{ $uid }} .rj-stat-value {
            font-size: 32px;
        }
    }

    @media (max-width: 480px) {
        #{{ $uid }} .rj-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div id="{{ $uid }}" data-style="{{ $settings['style'] ?? 'glass' }}">
    <div class="rj-stats-container">
        @if(!empty($settings['title']))
            <h2 class="rj-stats-title">{{ $settings['title'] }}</h2>
        @endif

        <div class="rj-stats-grid">
            @foreach($settings['stats'] ?? [] as $stat)
                <div class="rj-stat-card">
                    @if(!empty($stat['icon']))
                        <div class="rj-stat-icon">
                            {!! rj_icon($stat['icon']) !!}
                        </div>
                    @endif

                    <div class="rj-stat-value" data-target="{{ $stat['value'] ?? '0' }}">
                        0
                    </div>
                    <p class="rj-stat-label">{{ $stat['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    (function() {
        var root = document.getElementById('{{ $uid }}');
        if (!root) return;

        var values = root.querySelectorAll('.rj-stat-value');
        var animated = false;

        function animateValue(obj, start, end, duration, suffix) {
            var startTimestamp = null;
            
            function step(timestamp) {
                if (!startTimestamp) startTimestamp = timestamp;
                var progress = Math.min((timestamp - startTimestamp) / duration, 1);
                
                // Easing function (easeOutQuart)
                var easeOut = 1 - Math.pow(1 - progress, 4);
                var current = Math.floor(easeOut * (end - start) + start);
                
                obj.innerHTML = current.toLocaleString() + suffix;
                
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            }
            window.requestAnimationFrame(step);
        }

        var observer = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting && !animated) {
                animated = true;
                
                values.forEach(function(el) {
                    var targetStr = el.getAttribute('data-target');
                    
                    // Rəqəmi və hərfləri/simvolları ayırırıq (məsələn: 10K+ -> 10 və K+)
                    var numMatch = targetStr.match(/[\d.]+/);
                    if (!numMatch) {
                        el.innerHTML = targetStr;
                        return;
                    }
                    
                    var targetNum = parseFloat(numMatch[0]);
                    var suffix = targetStr.replace(numMatch[0], '');
                    var isDecimal = targetStr.indexOf('.') !== -1;
                    
                    if (isDecimal) {
                        // Ondalıq ədədlər üçün (məsələn: 99.9%)
                        var startTimestamp = null;
                        function stepDecimal(timestamp) {
                            if (!startTimestamp) startTimestamp = timestamp;
                            var progress = Math.min((timestamp - startTimestamp) / 2000, 1);
                            var easeOut = 1 - Math.pow(1 - progress, 4);
                            var current = (easeOut * targetNum).toFixed(1);
                            el.innerHTML = current + suffix;
                            if (progress < 1) window.requestAnimationFrame(stepDecimal);
                        }
                        window.requestAnimationFrame(stepDecimal);
                    } else {
                        // Tam ədədlər üçün
                        animateValue(el, 0, targetNum, 2000, suffix);
                    }
                });
                
                observer.disconnect();
            }
        }, { threshold: 0.5 });

        observer.observe(root);
    })();
</script>