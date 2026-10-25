@php
    $beforeImage = $settings['before_image'];
    $afterImage = $settings['after_image'];
    $beforeLabel = $settings['before_label'] ?? __('Before');
    $afterLabel = $settings['after_label'] ?? __('After');
    $height = $settings['height'] ?? 'aspect-video';
    $sliderColor = $settings['slider_color'] ?? '#ffffff';
    $showLabels = $settings['show_labels'] ?? true;
@endphp

<style>
    #{{ $uid }} .rj-comp-handle {
        width: 40px;
        height: 40px;
        background-color: {{ $sliderColor }};
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: ew-resize;
        z-index: 20;
        color: #111827;
    }
    #{{ $uid }} .rj-comp-line {
        width: 2px;
        height: 100%;
        background-color: {{ $sliderColor }};
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        box-shadow: 0 0 4px rgba(0,0,0,0.2);
    }
    #{{ $uid }} .rj-comp-after {
        clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);
        will-change: clip-path;
    }
    #{{ $uid }} .rj-comp-label {
        position: absolute;
        bottom: 16px;
        padding: 6px 14px;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-radius: 999px;
        z-index: 5;
        pointer-events: none;
    }
</style>

<div id="{{ $uid }}" class="relative w-full {{ $height }} rounded-2xl overflow-hidden select-none cursor-ew-resize shadow-xl group bg-slate-900">

    <!-- Before Image (Base) -->
    <img src="{{ $beforeImage }}" class="absolute inset-0 w-full h-full object-cover pointer-events-none" alt="{{ $beforeLabel }}">

    <!-- After Image (Clipped) -->
    <img src="{{ $afterImage }}" class="rj-comp-after absolute inset-0 w-full h-full object-cover pointer-events-none" alt="{{ $afterLabel }}">

    <!-- Labels -->
    @if($showLabels)
        <div class="rj-comp-label left-4">{{ $beforeLabel }}</div>
        <div class="rj-comp-label right-4">{{ $afterLabel }}</div>
    @endif

    <!-- Slider Line & Handle -->
    <div class="rj-comp-line"></div>
    <div class="rj-comp-handle">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l-4 3 4 3M16 9l4 3-4 3"/>
        </svg>
    </div>
</div>

<script>
(function() {
    function initImageComparison_{{ str_replace('-', '_', $uid) }}() {
        const container = document.getElementById('{{ $uid }}');
        if (!container || container.dataset.initialized) return;
        container.dataset.initialized = 'true';

        const afterImage = container.querySelector('.rj-comp-after');
        const line = container.querySelector('.rj-comp-line');
        const handle = container.querySelector('.rj-comp-handle');

        let isDragging = false;

        function setSliderPosition(x) {
            const rect = container.getBoundingClientRect();
            let position = ((x - rect.left) / rect.width) * 100;

            if (position < 0) position = 0;
            if (position > 100) position = 100;

            // Update clip-path for the after image
            afterImage.style.clipPath = `polygon(0 0, ${position}% 0, ${position}% 100%, 0 100%)`;

            // Update line and handle position
            line.style.left = `${position}%`;
            handle.style.left = `${position}%`;
        }

        // Mouse events
        container.addEventListener('mousedown', (e) => {
            isDragging = true;
            setSliderPosition(e.clientX);
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            setSliderPosition(e.clientX);
        });

        window.addEventListener('mouseup', () => {
            isDragging = false;
        });

        // Touch events for mobile
        container.addEventListener('touchstart', (e) => {
            isDragging = true;
            setSliderPosition(e.touches[0].clientX);
        }, { passive: true });

        window.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            setSliderPosition(e.touches[0].clientX);
        }, { passive: true });

        window.addEventListener('touchend', () => {
            isDragging = false;
        });
    }

    initImageComparison_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initImageComparison_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
