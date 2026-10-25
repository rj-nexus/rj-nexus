@php
    $columns = $settings['columns'] ?? '3';
    $style = $settings['style'] ?? 'light';
    $accentColor = $settings['accent_color'] ?? '#8b5cf6';
    $duration = (int)($settings['duration'] ?? 2000);

    $bgClass = '';
    $textClass = 'text-slate-500';
    $numClass = 'text-slate-900';

    if ($style === 'dark') {
        $bgClass = 'bg-slate-900';
        $textClass = 'text-slate-400';
        $numClass = 'text-white';
    } elseif ($style === 'transparent') {
        $bgClass = 'bg-transparent';
    } else {
        $bgClass = 'bg-slate-50';
    }
@endphp

<style>
    #{{ $uid }} .rj-counter-num {
        font-variant-numeric: tabular-nums;
        letter-spacing: -0.02em;
    }
    #{{ $uid }} .rj-counter-icon {
        color: {{ $accentColor }};
        background-color: {{ $accentColor }}15;
        transition: transform 0.3s ease;
    }
    #{{ $uid }} .rj-counter-item:hover .rj-counter-icon {
        transform: translateY(-4px) scale(1.05);
    }
</style>

<section id="{{ $uid }}" class="w-full py-16 {{ $bgClass }}" data-duration="{{ $duration }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $columns }} gap-8 md:gap-12">
            @foreach($items as $item)
                <div class="rj-counter-item flex flex-col items-center text-center">
                    @if(!empty($item['icon']))
                        <div class="rj-counter-icon w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                            {!! rj_icon($item['icon'], 'w-8 h-8') !!}
                        </div>
                    @endif

                    <div class="flex items-baseline justify-center mb-2">
                        <span class="rj-counter-num {{ $numClass }} text-5xl md:text-6xl font-extrabold"
                              data-target="{{ $item['number'] }}">0</span>
                        @if(!empty($item['suffix']))
                            <span class="rj-counter-num {{ $numClass }} text-4xl md:text-5xl font-extrabold" style="color: {{ $accentColor }};">{{ $item['suffix'] }}</span>
                        @endif
                    </div>

                    @if(!empty($item['label']))
                        <p class="{{ $textClass }} text-sm md:text-base font-semibold uppercase tracking-widest mt-2">{{ $item['label'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
(function() {
    function initCounters_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const duration = parseInt(root.dataset.duration) || 2000;
        const counters = root.querySelectorAll('.rj-counter-num[data-target]');

        const animateValue = (el, target, duration) => {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                // Ease-out quad function for a smooth deceleration at the end
                const easeOutProgress = progress * (2 - progress);
                const current = Math.floor(easeOutProgress * target);

                el.innerText = current;

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    el.innerText = target; // Ensure exact target at the end
                }
            };
            window.requestAnimationFrame(step);
        };

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const targetStr = el.getAttribute('data-target').replace(/[^0-9.]/g, '');
                    const targetNum = parseFloat(targetStr) || 0;

                    animateValue(el, targetNum, duration);
                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.1 });

        counters.forEach(counter => {
            // If in Builder canvas, trigger immediately after a tiny delay
            // otherwise the observer will handle it on scroll
            observer.observe(counter);
        });
    }

    initCounters_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCounters_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
