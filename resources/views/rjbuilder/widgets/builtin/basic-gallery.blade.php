@php
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $gap = $settings['gap'] ?? '16px';
    $radius = $settings['radius'] ?? '24px';

    $images = [];
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($settings['img_'.$i])) {
            $images[] = $settings['img_'.$i];
        }
    }
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        padding: 32px 16px;
    }
    #{{ $uid }} .rj-gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 240px;
        gap: {{ $gap }};
        width: 100%;
    }

    @media (max-width: 1024px) {
        #{{ $uid }} .rj-gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 200px;
        }
    }
    @media (max-width: 640px) {
        #{{ $uid }} .rj-gallery-grid {
            grid-template-columns: 1fr;
            grid-auto-rows: 250px;
        }
    }

    #{{ $uid }} .rj-gallery-item {
        position: relative;
        border-radius: {{ $radius }};
        overflow: hidden;
        cursor: pointer;
        background: #f1f5f9;
    }

    #{{ $uid }} .rj-gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    #{{ $uid }} .rj-gallery-item:hover img {
        transform: scale(1.08);
    }

    #{{ $uid }} .rj-gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #{{ $uid }} .rj-gallery-item:hover .rj-gallery-overlay {
        opacity: 1;
    }

    #{{ $uid }} .rj-gallery-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transform: scale(0.5);
        transition: transform 0.3s ease;
    }

    #{{ $uid }} .rj-gallery-item:hover .rj-gallery-icon {
        transform: scale(1);
    }

    #{{ $uid }} .rj-gallery-grid[data-count="1"] .rj-gallery-item { grid-column: span 4; grid-row: span 1; }

    #{{ $uid }} .rj-gallery-grid[data-count="2"] .rj-gallery-item { grid-column: span 2; grid-row: span 1; }

    #{{ $uid }} .rj-gallery-grid[data-count="3"] .rj-gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    #{{ $uid }} .rj-gallery-grid[data-count="3"] .rj-gallery-item:nth-child(2) { grid-column: span 2; grid-row: span 1; }
    #{{ $uid }} .rj-gallery-grid[data-count="3"] .rj-gallery-item:nth-child(3) { grid-column: span 2; grid-row: span 1; }

    #{{ $uid }} .rj-gallery-grid[data-count="4"] .rj-gallery-item { grid-column: span 2; grid-row: span 1; }

    #{{ $uid }} .rj-gallery-grid[data-count="5"] .rj-gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    #{{ $uid }} .rj-gallery-grid[data-count="5"] .rj-gallery-item:nth-child(2) { grid-column: span 2; grid-row: span 1; }
    #{{ $uid }} .rj-gallery-grid[data-count="5"] .rj-gallery-item:nth-child(3) { grid-column: span 1; grid-row: span 1; }
    #{{ $uid }} .rj-gallery-grid[data-count="5"] .rj-gallery-item:nth-child(4) { grid-column: span 1; grid-row: span 1; }
    #{{ $uid }} .rj-gallery-grid[data-count="5"] .rj-gallery-item:nth-child(5) { grid-column: span 4; grid-row: span 1; }

    @media (max-width: 1024px) {
        #{{ $uid }} .rj-gallery-grid[data-count] .rj-gallery-item:nth-child(n) { grid-column: span 1; grid-row: span 1; }
        #{{ $uid }} .rj-gallery-grid[data-count="1"] .rj-gallery-item { grid-column: span 2; }
        #{{ $uid }} .rj-gallery-grid[data-count="5"] .rj-gallery-item:nth-child(5) { grid-column: span 2; }
    }

    @media (max-width: 640px) {
        #{{ $uid }} .rj-gallery-grid[data-count] .rj-gallery-item:nth-child(n) { grid-column: span 1 !important; }
    }

    #{{ $uid }} .rj-lightbox {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #{{ $uid }} .rj-lightbox.is-open {
        display: flex;
        opacity: 1;
    }

    #{{ $uid }} .rj-lightbox img {
        max-width: 100%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    #{{ $uid }} .rj-lightbox.is-open img {
        transform: scale(1);
    }

    #{{ $uid }} .rj-lightbox-close {
        position: absolute;
        top: 24px;
        right: 24px;
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        transition: color 0.2s ease;
    }

    #{{ $uid }} .rj-lightbox-close:hover {
        color: #ffffff;
    }
</style>

<div id="{{ $uid }}">
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
        <div class="rj-gallery-grid" data-count="{{ count($images) }}">
            @foreach($images as $img)
                <div class="rj-gallery-item" onclick="openLightbox_{{ str_replace('-', '_', $uid) }}('{{ $img }}')">
                    <img src="{{ $img }}" alt="Gallery Image">
                    <div class="rj-gallery-overlay">
                        <div class="rj-gallery-icon">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
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

    <div class="rj-lightbox" onclick="closeLightbox_{{ str_replace('-', '_', $uid) }}()">
        <button class="rj-lightbox-close" onclick="closeLightbox_{{ str_replace('-', '_', $uid) }}()">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img class="rj-lightbox-img" src="" alt="Fullscreen" onclick="event.stopPropagation()">
    </div>
</div>

<script>
(function() {
    function openLightbox_{{ str_replace('-', '_', $uid) }}(src) {
        const root = document.getElementById('{{ $uid }}');
        const lb = root.querySelector('.rj-lightbox');
        const img = lb.querySelector('.rj-lightbox-img');

        img.src = src;
        lb.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox_{{ str_replace('-', '_', $uid) }}() {
        const root = document.getElementById('{{ $uid }}');
        const lb = root.querySelector('.rj-lightbox');

        lb.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    window.openLightbox_{{ str_replace('-', '_', $uid) }} = openLightbox_{{ str_replace('-', '_', $uid) }};
    window.closeLightbox_{{ str_replace('-', '_', $uid) }} = closeLightbox_{{ str_replace('-', '_', $uid) }};

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox_{{ str_replace('-', '_', $uid) }}();
    });
})();
</script>
