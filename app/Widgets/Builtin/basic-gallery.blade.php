@php
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $gap = $settings['gap'] ?? 'gap-4';
    $radius = $settings['radius'] ?? 'rounded-2xl';

    $images = [];
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($settings['img_'.$i])) {
            $images[] = $settings['img_'.$i];
        }
    }
@endphp

<style>
    #{{ $uid }} .rj-bento-item img {
        transition: transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    #{{ $uid }} .rj-bento-item:hover img {
        transform: scale(1.08);
    }
    #{{ $uid }} .rj-bento-overlay {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    #{{ $uid }} .rj-bento-item:hover .rj-bento-overlay {
        opacity: 1;
    }
    #{{ $uid }} .rj-lightbox {
        transition: opacity 0.3s ease;
    }
    #{{ $uid }} .rj-lightbox img {
        transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        transform: scale(0.95);
    }
    #{{ $uid }} .rj-lightbox.is-open img {
        transform: scale(1);
    }
</style>

<div id="{{ $uid }}" class="w-full py-8">
    @if($title || $subtitle)
        <div class="text-center mb-10">
            @if($subtitle)
                <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-3">{{ $subtitle }}</p>
            @endif
            @if($title)
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $title }}</h2>
            @endif
        </div>
    @endif

    @if(!empty($images))
        <div class="grid grid-cols-2 md:grid-cols-4 auto-rows-[150px] md:auto-rows-[220px] {{ $gap }}">
            @foreach($images as $index => $img)
                @php
                    $gridClass = '';
                    if (count($images) === 1) {
                        $gridClass = 'col-span-2 md:col-span-4 row-span-2';
                    } elseif (count($images) === 2) {
                        $gridClass = 'col-span-2 md:col-span-2 row-span-2';
                    } elseif (count($images) === 3) {
                        $gridClass = $index === 0 ? 'col-span-2 row-span-2' : 'col-span-1 row-span-1';
                    } elseif (count($images) === 4) {
                        $gridClass = 'col-span-1 md:col-span-2 row-span-2';
                    } else {
                        if ($index === 0) $gridClass = 'col-span-2 row-span-2';
                        elseif ($index === 1 || $index === 2) $gridClass = 'col-span-1 row-span-1';
                        elseif ($index === 3) $gridClass = 'col-span-2 row-span-1';
                        elseif ($index === 4) $gridClass = 'col-span-2 md:col-span-4 row-span-2 md:row-span-1';
                    }
                @endphp

                <div class="rj-bento-item group relative overflow-hidden {{ $radius }} bg-slate-100 cursor-pointer {{ $gridClass }}" onclick="openLightbox_{{ str_replace('-', '_', $uid) }}('{{ $img }}')">
                    <img src="{{ $img }}" class="w-full h-full object-cover" alt="Gallery Image">

                    <div class="rj-bento-overlay absolute inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">
                        <div class="w-12 h-12 rounded-full bg-white/20 text-white flex items-center justify-center transform scale-50 group-hover:scale-100 transition-transform duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-10 text-center bg-slate-50 border border-slate-200 border-dashed rounded-2xl text-slate-500">
            {{ __('Please select at least one image for the gallery.') }}
        </div>
    @endif

    <!-- Lightbox Overlay -->
    <div class="rj-lightbox fixed inset-0 z-[9999] bg-black/90 hidden items-center justify-center p-4 backdrop-blur-md opacity-0" onclick="closeLightbox_{{ str_replace('-', '_', $uid) }}()">
        <button class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors" onclick="closeLightbox_{{ str_replace('-', '_', $uid) }}()">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img class="rj-lightbox-img max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" src="" alt="Fullscreen Image" onclick="event.stopPropagation()">
    </div>
</div>

<script>
(function() {
    function openLightbox_{{ str_replace('-', '_', $uid) }}(src) {
        const root = document.getElementById('{{ $uid }}');
        const lb = root.querySelector('.rj-lightbox');
        const img = lb.querySelector('.rj-lightbox-img');

        img.src = src;
        lb.classList.remove('hidden');
        lb.style.display = 'flex';

        // Trigger reflow for transition
        void lb.offsetWidth;

        lb.classList.add('is-open');
        lb.style.opacity = '1';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        const lb = root.querySelector('.rj-lightbox');

        lb.classList.remove('is-open');
        lb.style.opacity = '0';

        setTimeout(() => {
            lb.style.display = 'none';
            lb.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    // Expose to global scope for the inline onclick handlers
    window.openLightbox_{{ str_replace('-', '_', $uid) }} = openLightbox_{{ str_replace('-', '_', $uid) }};
    window.closeLightbox_{{ str_replace('-', '_', $uid) }} = closeLightbox_{{ str_replace('-', '_', $uid) }};

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox_{{ str_replace('-', '_', $uid) }}();
    });
})();
</script>
