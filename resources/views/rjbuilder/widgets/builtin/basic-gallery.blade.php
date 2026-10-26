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

<div id="{{ $uid }}" style="width: 100%; padding: 24px 0;">
    @if($title || $subtitle)
        <div style="text-align: center; margin-bottom: 32px;">
            @if($subtitle)
                <p style="font-size: 12px; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">{{ $subtitle }}</p>
            @endif
            @if($title)
                <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">{{ $title }}</h2>
            @endif
        </div>
    @endif

    @if(!empty($images))
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: {{ $gap }}; width: 100%;">
            @foreach($images as $index => $img)
                @php
                    $style = "position: relative; overflow: hidden; border-radius: {$radius}; background: #f1f5f9; cursor: pointer;";

                    $count = count($images);
                    if ($count === 1) {
                        $style .= " grid-column: span 4; aspect-ratio: 21 / 9;";
                    } elseif ($count === 2) {
                        $style .= " grid-column: span 2; aspect-ratio: 4 / 3;";
                    } elseif ($count === 3) {
                        if ($index === 0) $style .= " grid-column: span 2; grid-row: span 2; height: 100%; min-height: 400px;";
                        else $style .= " grid-column: span 2; aspect-ratio: 16 / 9;";
                    } elseif ($count === 4) {
                        $style .= " grid-column: span 2; aspect-ratio: 4 / 3;";
                    } else {
                        if ($index === 0) $style .= " grid-column: span 2; grid-row: span 2; height: 100%; min-height: 400px;";
                        elseif ($index === 1 || $index === 2) $style .= " grid-column: span 2; aspect-ratio: 16 / 9;";
                        elseif ($index === 3) $style .= " grid-column: span 2; aspect-ratio: 16 / 9;";
                        elseif ($index === 4) $style .= " grid-column: span 2; aspect-ratio: 16 / 9;";
                    }
                @endphp

                <div style="{{ $style }}" onclick="openLightbox_{{ str_replace('-', '_', $uid) }}('{{ $img }}')" class="rj-gallery-item">
                    <img src="{{ $img }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'" alt="Gallery Image">

                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; color: white;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="padding: 40px; text-align: center; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; color: #64748b;">
            {{ __('Please select at least one image for the gallery.') }}
        </div>
    @endif

    <div id="{{ $uid }}-lightbox" style="position: fixed; inset: 0; z-index: 99999; background: rgba(0,0,0,0.9); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; padding: 24px; opacity: 0; transition: opacity 0.3s ease;" onclick="closeLightbox_{{ str_replace('-', '_', $uid) }}()">
        <button style="position: absolute; top: 24px; right: 24px; background: none; border: none; color: rgba(255,255,255,0.7); cursor: pointer; padding: 8px;" onclick="closeLightbox_{{ str_replace('-', '_', $uid) }}()">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="{{ $uid }}-lightbox-img" src="" style="max-width: 100%; max-height: 90vh; object-fit: contain; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);" onclick="event.stopPropagation()" alt="Fullscreen">
    </div>
</div>

<script>
(function() {
    function openLightbox_{{ str_replace('-', '_', $uid) }}(src) {
        const lb = document.getElementById('{{ $uid }}-lightbox');
        const img = document.getElementById('{{ $uid }}-lightbox-img');
        img.src = src;
        lb.style.display = 'flex';
        setTimeout(() => { lb.style.opacity = '1'; }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox_{{ str_replace('-', '_', $uid) }}() {
        const lb = document.getElementById('{{ $uid }}-lightbox');
        lb.style.opacity = '0';
        setTimeout(() => { lb.style.display = 'none'; }, 300);
        document.body.style.overflow = '';
    }

    window.openLightbox_{{ str_replace('-', '_', $uid) }} = openLightbox_{{ str_replace('-', '_', $uid) }};
    window.closeLightbox_{{ str_replace('-', '_', $uid) }} = closeLightbox_{{ str_replace('-', '_', $uid) }};
})();
</script>

<style>
    @media (max-width: 768px) {
        #{{ $uid }} > div:nth-child(2) {
            grid-template-columns: 1fr !important;
        }
        #{{ $uid }} > div:nth-child(2) > div {
            grid-column: span 1 !important;
            grid-row: span 1 !important;
            aspect-ratio: 4 / 3 !important;
            min-height: auto !important;
        }
    }
</style>
