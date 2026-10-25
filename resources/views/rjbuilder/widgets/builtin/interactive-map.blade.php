@php
    $lat = $settings['latitude'] ?? '40.4093';
    $lng = $settings['longitude'] ?? '49.8671';
    $zoom = (int)($settings['zoom'] ?? 13);
    $style = $settings['map_style'] ?? 'light';
    $height = $settings['height'] ?? 'h-[500px]';

    $markerIcon = $settings['marker_icon'] ?? 'ph:map-pin';
    $markerColor = $settings['marker_color'] ?? '#8b5cf6';

    $popupTitle = $settings['popup_title'] ?? '';
    $popupText = $settings['popup_text'] ?? '';
@endphp

<style>
    /* Xəritənin kənarlarını yumrulaşdırırıq */
    #{{ $uid }} {
        border-radius: 16px;
        z-index: 1;
    }

    /* Leaflet-in öz kontrol düymələrini gizlədirik ki, dizaynı pozmasın */
    #{{ $uid }} .leaflet-control-zoom {
        display: none !important;
    }

    /* Popup (Bubble) Dizaynı */
    #{{ $uid }} .leaflet-popup-content-wrapper {
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        padding: 0;
        overflow: hidden;
        background: #ffffff;
    }
    #{{ $uid }} .leaflet-popup-content {
        margin: 0;
        width: 260px !important;
        font-family: inherit;
    }
    #{{ $uid }} .leaflet-popup-tip-container {
        display: none; /* Oxu gizlədirik, baloncuk kimi görünsün */
    }

    /* Markerin yanında baloncuk effekti üçün xüsusi stil */
    #{{ $uid }} .custom-map-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }
    #{{ $uid }} .custom-map-marker:hover {
        transform: scale(1.1);
    }
</style>

<!-- Leaflet CSS (Əgər yüklənməyibsə) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div id="{{ $uid }}" class="w-full {{ $height }} relative bg-slate-100 rounded-2xl overflow-hidden shadow-sm border border-slate-200"></div>

<script>
(function() {
    function initMap_{{ str_replace('-', '_', $uid) }}() {
        const mapContainer = document.getElementById('{{ $uid }}');
        if (!mapContainer || mapContainer.dataset.initialized) return;
        mapContainer.dataset.initialized = 'true';

        // Leaflet JS-in yükləndiyinə əmin olaq
        if (typeof L === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
            script.onload = () => createMap();
            document.head.appendChild(script);
        } else {
            createMap();
        }

        function createMap() {
            const lat = {{ $lat }};
            const lng = {{ $lng }};
            const zoom = {{ $zoom }};
            const style = '{{ $style }}';
            const markerColor = '{{ $markerColor }}';

            // Xəritəni yarat
            const map = L.map(mapContainer, {
                center: [lat, lng],
                zoom: zoom,
                scrollWheelZoom: false,
                zoomControl: false
            });

            // Rəng və stilinə görə Tile Layer seçimi
            let tileUrl = 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png';
            if (style === 'dark') {
                tileUrl = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
            } else if (style === 'streets') {
                tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            }

            L.tileLayer(tileUrl, {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);

            // Xüsusi Marker İkonu (SVG)
            const iconSvg = `{!! rj_icon($markerIcon, 'w-8 h-8') !!}`;

            const customIcon = L.divIcon({
                html: `<div style="color: ${markerColor}; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.3)); width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">${iconSvg}</div>`,
                className: 'custom-map-marker',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -35]
            });

            // Marker əlavə et
            const marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

            // Popup (Baloncuk) HTML
            const hasPopup = '{{ addslashes($popupTitle) }}' !== '' || '{{ addslashes($popupText) }}' !== '';

            if (hasPopup) {
                const popupHtml = `
                    <div class="p-5">
                        <h4 class="text-base font-bold text-slate-900 mb-1">{{ addslashes($popupTitle) }}</h4>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ addslashes($popupText) }}</p>
                    </div>
                `;

                marker.bindPopup(popupHtml, {
                    closeButton: false,
                    offset: [0, 0],
                    className: 'custom-popup'
                });

                // Builder daxilində dərhal açıq olsun deyə
                setTimeout(() => { marker.openPopup(); }, 500);
            }

            // Builder paneli açılanda xəritənin ölçüsünü yenilə
            if ('ResizeObserver' in window) {
                const observer = new ResizeObserver(() => {
                    map.invalidateSize();
                });
                observer.observe(mapContainer);
            }
        }
    }

    // Builder daxilində JS-in işləməsi üçün
    initMap_{{ str_replace('-', '_', $uid) }}();
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMap_{{ str_replace('-', '_', $uid) }});
    }
})();
</script>
