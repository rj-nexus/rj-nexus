@php
    $layout = $settings['layout'] ?? 'vertical';
    $style = $settings['style'] ?? 'modern';
    $showPercent = $settings['show_percent'] ?? true;
    $height = $settings['height'] ?? 'h-3';

    $wrapperClass = $layout === 'grid-2' ? 'grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8' : 'space-y-8';

    $trackClass = 'w-full bg-slate-200 overflow-hidden relative';
    $fillClass = 'h-full transition-all duration-1000 ease-out origin-left';

    if ($style === 'modern') {
        $trackClass .= ' rounded-full';
        $fillClass .= ' rounded-full';
    } elseif ($style === 'minimal') {
        $trackClass .= ' rounded-none';
        $fillClass .= ' rounded-none';
    } elseif ($style === 'thick') {
        $trackClass .= ' rounded-lg shadow-inner';
        $fillClass .= ' rounded-lg';
    }
@endphp

<style>
    #{{ $uid }} .rj-progress-fill {
        width: 0%;
    }
</style>

<div id="{{ $uid }}" class="w-full py-8">
    <div class="{{ $wrapperClass }}">
        @foreach($items as $item)
            <div class="rj-progress-item group">
                <div class="flex justify-between items-end mb-2">
                    <span class="text-sm md:text-base font-bold text-slate-700 group-hover:text-slate-900 transition-colors">{{ $item['label'] }}</span>
                    @if($showPercent)
                        <span class="text-sm font-bold" style="color: {{ $item['color'] }};">{{ $item['value'] }}%</span>
                    @endif
                </div>
                <div class="{{ $trackClass }} {{ $height }}">
                    <div class="{{ $fillClass }} rj-progress-fill"
                         data-target="{{ $item['value'] }}"
                         style="background-color: {{ $item['color'] }};">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
(function() {
    function initProgress_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const fills = root.querySelectorAll('.rj-progress-fill');

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = el.dataset.target;

                    setTimeout(() => {
                        el.style.width = target + '%';
                    }, 100);

                    obs.unobserve(el);
                }
            });
        }, { threshold: 0.1 });

        fills.forEach(fill => {
            observer.observe(fill);
        });
    }

    initProgress_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProgress_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
