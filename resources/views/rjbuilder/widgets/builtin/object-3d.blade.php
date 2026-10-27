@php
    $title       = $settings['title'] ?? '';
    $subtitle    = $settings['subtitle'] ?? '';
    $modelUrl    = trim($settings['model_url'] ?? '');
    $usdzUrl     = trim($settings['usdz_url'] ?? '');
    $poster      = $settings['poster'] ?? '';
    $cameraOrbit = trim($settings['camera_orbit'] ?? '0deg 75deg 105%');
    $autoRotate  = $settings['auto_rotate'] ?? true;
    $enableZoom  = $settings['enable_zoom'] ?? true;
    $enablePan   = $settings['enable_pan'] ?? true;
    $background  = $settings['background'] ?? 'gradient';
    $accent      = $settings['accent'] ?? '#8b5cf6';
    $accent2     = $settings['accent2'] ?? '#ec4899';
    $height      = (int) ($settings['height'] ?? 480);
    $radius      = $settings['radius'] ?? 'lg';
    $paddingY    = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '12px', 'lg' => '20px', 'xl' => '28px'];
    $radiusCss = $radiusMap[$radius] ?? '20px';

    $bgCss = '';
    switch ($background) {
        case 'light':
            $bgCss = 'background: #f1f5f9;';
            break;
        case 'dark':
            $bgCss = 'background: #0f172a;';
            break;
        case 'gradient':
            $bgCss = 'background: linear-gradient(135deg, ' . $accent . ', ' . $accent2 . ');';
            break;
        case 'transparent':
        default:
            $bgCss = 'background: transparent;';
            break;
    }

    $hasModel = $modelUrl !== '';
@endphp

@once
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.5.0/model-viewer.min.js"></script>
@endonce

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-o3-inner {
        max-width: 1120px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-o3-head {
        text-align: center;
        margin-bottom: 28px;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-o3-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: {{ $accent }};
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-o3-title {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        margin: 0;
    }

    #{{ $uid }} .rj-o3-viewer {
        position: relative;
        width: 100%;
        height: {{ $height }}px;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        {!! $bgCss !!}
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.3);
    }

    #{{ $uid }} .rj-o3-viewer model-viewer {
        width: 100%;
        height: 100%;
        display: block;
        outline: 0;
        --poster-color: transparent;
        --progress-bar-color: {{ $accent }};
        --progress-mask: transparent;
        background: transparent;
    }

    #{{ $uid }} .rj-o3-hint {
        position: absolute;
        bottom: 14px;
        left: 50%;
        transform: translateX(-50%);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(15,23,42,.55);
        backdrop-filter: blur(6px);
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .02em;
        pointer-events: none;
        opacity: .9;
        transition: opacity .4s ease;
        z-index: 2;
        white-space: nowrap;
    }
    #{{ $uid }} .rj-o3-viewer:hover .rj-o3-hint {
        opacity: 0;
    }
    @media (hover: none) {
        #{{ $uid }} .rj-o3-hint { display: none; }
    }
    #{{ $uid }} .rj-o3-hint svg {
        width: 12px;
        height: 12px;
    }

    #{{ $uid }} .rj-o3-ar {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 3;
        padding: 8px 14px;
        border-radius: 10px;
        border: 0;
        background: rgba(15,23,42,.65);
        color: #fff;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(6px);
        transition: background .2s ease;
    }
    #{{ $uid }} .rj-o3-ar:hover { background: rgba(15,23,42,.85); }
    #{{ $uid }} .rj-o3-ar svg { width: 14px; height: 14px; }

    #{{ $uid }} .rj-o3-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        font-size: 14px;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-o3-inner">
        @if($title || $subtitle)
            <header class="rj-o3-head">
                @if($subtitle)
                    <p class="rj-o3-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-o3-title">{{ $title }}</h2>
                @endif
            </header>
        @endif

        @if($hasModel)
            <div class="rj-o3-viewer">
                <model-viewer
                    src="{{ $modelUrl }}"
                    @if($usdzUrl !== '') ios-src="{{ $usdzUrl }}" @endif
                    @if($poster !== '') poster="{{ $poster }}" @endif
                    alt="{{ $title ?: __('3D model') }}"
                    camera-controls
                    camera-orbit="{{ $cameraOrbit }}"
                    @if($autoRotate) auto-rotate @endif
                    @if($autoRotate) rotation-per-second="20deg" @endif
                    @if($enableZoom) disable-zoom="false" @else disable-zoom @endif
                    @if(!$enablePan) disable-pan @endif
                    shadow-intensity="1"
                    touch-action="pan-y"
                    loading="lazy">
                    @if($usdzUrl !== '')
                        <button class="rj-o3-ar" slot="ar-button">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l9 5v10l-9 5-9-5V7l9-5zM12 12l9-5M12 12l-9-5M12 12v10"/></svg>
                            <span>{{ __('View in AR') }}</span>
                        </button>
                    @endif
                </model-viewer>

                <div class="rj-o3-hint">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                    <span>{{ __('Drag to rotate') }}</span>
                </div>
            </div>
        @else
            <div class="rj-o3-empty">{{ __('Please provide a .glb or .gltf model URL.') }}</div>
        @endif
    </div>
</div>
