@php
    $columns = $settings['columns'] ?? '3';
    $style = $settings['style'] ?? 'light';
    $accentColor = $settings['accent_color'] ?? '#8b5cf6';

    $cardClass = '';
    $titleClass = 'text-xl font-bold mb-2';
    $textClass = 'text-sm leading-relaxed';
    $borderClass = '';
    $arrowColor = '';

    if ($style === 'dark') {
        $cardClass = 'bg-slate-900 text-white';
        $borderClass = 'border border-slate-800 hover:border-slate-700';
        $titleClass .= ' text-white';
        $textClass .= ' text-slate-400';
        $arrowColor = 'text-slate-500';
    } elseif ($style === 'bordered') {
        $cardClass = 'bg-transparent';
        $borderClass = 'border-2 border-slate-200 hover:border-slate-300';
        $titleClass .= ' text-slate-900';
        $textClass .= ' text-slate-500';
        $arrowColor = 'text-slate-400';
    } else {
        $cardClass = 'bg-white shadow-sm hover:shadow-md';
        $borderClass = 'border border-slate-100';
        $titleClass .= ' text-slate-900';
        $textClass .= ' text-slate-500';
        $arrowColor = 'text-slate-400';
    }
@endphp

<style>
    #{{ $uid }} .rj-tcard-content {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-tcard-content > div {
        overflow: hidden;
    }
    #{{ $uid }} .rj-tcard.is-expanded .rj-tcard-content {
        grid-template-rows: 1fr;
    }
    #{{ $uid }} .rj-tcard-arrow {
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-tcard.is-expanded .rj-tcard-arrow {
        transform: rotate(180deg);
        color: {{ $accentColor }};
    }
    #{{ $uid }} .rj-tcard:hover .rj-tcard-icon-box {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px {{ $accentColor }}40;
    }
</style>

<div id="{{ $uid }}" class="w-full py-8">
    <div class="grid grid-cols-1 md:grid-cols-{{ $columns }} gap-6">
        @foreach($cards as $index => $card)
            <div class="rj-tcard {{ $cardClass }} {{ $borderClass }} rounded-2xl p-6 md:p-8 cursor-pointer transition-all duration-300 group">

                <div class="flex items-start justify-between mb-6">
                    @if(!empty($card['icon']))
                        <div class="rj-tcard-icon-box w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300" style="background-color: {{ $accentColor }}15; color: {{ $accentColor }};">
                            {!! rj_icon($card['icon'], 'w-6 h-6') !!}
                        </div>
                    @else
                        <div></div>
                    @endif

                    <div class="rj-tcard-arrow {{ $arrowColor }} mt-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <h3 class="{{ $titleClass }}">{{ $card['title'] }}</h3>

                @if(!empty($card['excerpt']))
                    <p class="{{ $textClass }} mt-2">{{ $card['excerpt'] }}</p>
                @endif

                <div class="rj-tcard-content">
                    <div>
                        <div class="pt-5 mt-5 border-t {{ $style === 'dark' ? 'border-slate-800' : 'border-slate-100' }}">
                            <p class="{{ $textClass }}">{!! nl2br(e($card['content'])) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
(function() {
    function initToggleCards_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const cards = root.querySelectorAll('.rj-tcard');

        cards.forEach(card => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('a')) return; // Don't toggle if clicking a link inside

                // Optional: close other cards (uncomment below to enable accordion-like behavior)
                // cards.forEach(c => { if (c !== card) c.classList.remove('is-expanded'); });

                card.classList.toggle('is-expanded');
            });
        });
    }

    initToggleCards_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initToggleCards_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
