@php
    $style = $settings['style'] ?? 'bordered';
    $title = $settings['title'] ?? '';

    $wrapperClass = 'w-full max-w-3xl mx-auto px-4 py-12';
    $itemClass = '';
    $btnClass = '';
    $qClass = '';
    $aClass = '';
    $iconClass = '';

    if ($style === 'clean') {
        $itemClass = 'bg-white rounded-2xl shadow-sm border border-slate-200 mb-3 overflow-hidden transition-all duration-300 hover:shadow-md';
        $btnClass = 'w-full px-6 py-5 text-left flex items-center justify-between focus:outline-none';
        $qClass = 'text-base md:text-lg font-bold text-slate-900';
        $aClass = 'px-6 pb-5 text-slate-600 leading-relaxed text-sm md:text-base';
        $iconClass = 'text-slate-400 group-hover:text-slate-900 transition-colors';
    } elseif ($style === 'dark') {
        $itemClass = 'bg-slate-900 rounded-2xl border border-slate-800 mb-3 overflow-hidden transition-all duration-300 hover:border-slate-700';
        $btnClass = 'w-full px-6 py-5 text-left flex items-center justify-between focus:outline-none';
        $qClass = 'text-base md:text-lg font-bold text-white';
        $aClass = 'px-6 pb-5 text-slate-400 leading-relaxed text-sm md:text-base';
        $iconClass = 'text-slate-500 group-hover:text-white transition-colors';
    } else {
        $itemClass = 'border-b border-slate-200 last:border-0';
        $btnClass = 'w-full py-5 text-left flex items-center justify-between focus:outline-none group';
        $qClass = 'text-base md:text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors';
        $aClass = 'pb-5 text-slate-600 leading-relaxed text-sm md:text-base';
        $iconClass = 'text-slate-400 group-hover:text-indigo-600 transition-colors';
    }
@endphp

<style>
    #{{ $uid }} .rj-acc-content {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-acc-content > div {
        overflow: hidden;
    }
    #{{ $uid }} .rj-acc-item.is-open .rj-acc-content {
        grid-template-rows: 1fr;
    }
    #{{ $uid }} .rj-acc-icon {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #{{ $uid }} .rj-acc-item.is-open .rj-acc-icon {
        transform: rotate(180deg);
    }
</style>

<div id="{{ $uid }}" class="{{ $wrapperClass }}">

    @if($title)
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 text-center mb-10 tracking-tight">
            {{ $title }}
        </h2>
    @endif

    <div class="w-full">
        @foreach($items as $index => $item)
            <div class="rj-acc-item {{ $itemClass }}">
                <button type="button" class="{{ $btnClass }} rj-acc-btn group">
                    <span class="{{ $qClass }}">{{ $item['question'] }}</span>
                    <span class="rj-acc-icon {{ $iconClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </span>
                </button>

                <div class="rj-acc-content">
                    <div>
                        <div class="{{ $aClass }}">
                            {!! nl2br(e($item['answer'])) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
(function() {
    function initAccordion_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        if (!root || root.dataset.initialized) return;
        root.dataset.initialized = 'true';

        const items = root.querySelectorAll('.rj-acc-item');

        items.forEach(item => {
            const btn = item.querySelector('.rj-acc-btn');
            if (!btn) return;

            btn.addEventListener('click', () => {
                const isOpen = item.classList.contains('is-open');

                items.forEach(i => i.classList.remove('is-open'));

                if (!isOpen) {
                    item.classList.add('is-open');
                }
            });
        });
    }

    initAccordion_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAccordion_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
