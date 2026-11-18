@php
    $uid = 'map_' . substr(md5(uniqid('', true)), 0, 8);
    $title = $settings['title'] ?? '';
    $address = $settings['address'] ?? '';
    $lat = $settings['lat'] ?? '40.4093';
    $lng = $settings['lng'] ?? '49.8671';
    $zoom = (int) ($settings['zoom'] ?? 14);
    $height = (int) ($settings['height'] ?? 450);
    $icon = $settings['marker_icon'] ?? 'ph:map-pin-fill';
    $color = $settings['marker_color'] ?? '#3b82f6';
@endphp

<section class="rj-map-section">
    <div class="rj-map-inner">
        @if($title)
            <h2 class="rj-map-title">{{ $title }}</h2>
        @endif

        <div class="rj-map-wrapper" style="height: {{ $height }}px;">
            <div id="{{ $uid }}" class="rj-map-canvas"></div>
        </div>
    </div>

    <style>
        .rj-map-section {
            position: relative;
            z-index: 1;
            padding: 80px 24px;
            background: transparent;
        }
        .rj-map-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }
        .rj-map-title {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 600;
            color: #fff;
            text-align: center;
            margin: 0 0 40px;
            letter-spacing: -0.02em;
        }
        .rj-map-wrapper {
            position: relative;
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--rj-border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .rj-map-canvas {
            width: 100%;
            height: 100%;
            background: #1a1a1a;
        }

        /* OSM xəritəsini dark moda gətirmək üçün CSS filter */
        .rj-map-canvas .leaflet-tile-pane {
            filter: invert(1) hue-rotate(180deg) brightness(0.85) contrast(1.1);
        }

        /* Leaflet Dark Mode Xüsusi Düzəlişlər */
        .leaflet-container {
            background: #111 !important;
            font-family: inherit !important;
        }
        .leaflet-popup-content-wrapper {
            background: var(--rj-surface) !important;
            color: #fff !important;
            border-radius: 12px !important;
            border: 1px solid var(--rj-border);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5) !important;
        }
        .leaflet-popup-tip {
            background: var(--rj-surface) !important;
            border: 1px solid var(--rj-border);
        }
        .leaflet-popup-content {
            margin: 14px 18px !important;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 500;
        }
        .leaflet-container a.leaflet-popup-close-button {
            color: var(--rj-muted) !important;
            padding: 8px 8px 0 0 !important;
        }
        .leaflet-control-zoom a {
            background: var(--rj-surface) !important;
            color: #fff !important;
            border-color: var(--rj-border) !important;
        }
        .leaflet-control-zoom a:hover {
            background: var(--rj-bg) !important;
        }

        /* Xüsusi Marker */
        .rj-custom-marker {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .rj-custom-marker svg {
            width: 100%;
            height: 100%;
            stroke-width: 1.2;
        }

        @media (max-width: 768px) {
            .rj-map-section { padding: 48px 20px; }
        }
    </style>

    <script>
        (function() {
            if (window.rjMapLoaded_{{ $uid }}) return;
            window.rjMapLoaded_{{ $uid }} = true;

            function initMap() {
                var mapEl = document.getElementById('{{ $uid }}');
                if (!mapEl) return;

                var map = L.map(mapEl, {
                    zoomControl: true,
                    scrollWheelZoom: false
                }).setView([{{ $lat }}, {{ $lng }}], {{ $zoom }});

                // OpenStreetMap standart tile-ları (API açarı tələb etmir)
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 19
                }).addTo(map);

                var customIcon = L.divIcon({
                    className: 'rj-custom-marker',
                    html: `<div style="color: {{ $color }}; filter: drop-shadow(0 0 10px {{ $color }}aa); width: 38px; height: 38px;">
                               {!! rj_icon($icon) !!}
                           </div>`,
                    iconSize: [38, 38],
                    iconAnchor: [19, 38],
                    popupAnchor: [0, -34]
                });

                var marker = L.marker([{{ $lat }}, {{ $lng }}], { icon: customIcon }).addTo(map);

                @if($address)
                    marker.bindPopup('<div style="text-align:center;">{{ addslashes($address) }}</div>').openPopup();
                @endif

                map.on('click', function() {
                    map.scrollWheelZoom.enable();
                });
                map.on('mouseout', function() {
                    map.scrollWheelZoom.disable();
                });
            }

            if (typeof L === 'undefined') {
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                document.head.appendChild(link);

                var script = document.createElement('script');
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                script.onload = initMap;
                document.head.appendChild(script);
            } else {
                initMap();
            }
        })();
    </script>
</section>
