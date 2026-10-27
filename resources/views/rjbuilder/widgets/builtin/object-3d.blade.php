@php
    $title       = trim((string) ($settings['title'] ?? ''));
    $subtitle    = trim((string) ($settings['subtitle'] ?? ''));
    $modelUrl    = trim((string) ($settings['model_url'] ?? ''));
    $usdzUrl     = trim((string) ($settings['usdz_url'] ?? ''));
    $poster      = trim((string) ($settings['poster'] ?? ''));
    $cameraOrbit = trim((string) ($settings['camera_orbit'] ?? '0deg 75deg 105%'));
    $autoRotate  = !empty($settings['auto_rotate'] ?? true);
    $enableZoom  = !empty($settings['enable_zoom'] ?? true);
    $enablePan   = !empty($settings['enable_pan'] ?? true);
    $background  = in_array($settings['background'] ?? 'gradient', ['light', 'dark', 'gradient', 'transparent'], true)
                        ? $settings['background'] : 'gradient';
    $height      = max(240, min(900, (int) ($settings['height'] ?? 480)));
    $radius      = in_array($settings['radius'] ?? 'lg', ['none', 'md', 'lg', 'xl'], true) ? $settings['radius'] : 'lg';
    $paddingY    = max(0, min(240, (int) ($settings['padding_y'] ?? 60)));

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $accent  = $hexOk($settings['accent'] ?? '', '#8b5cf6');
    $accent2 = $hexOk($settings['accent2'] ?? '', '#ec4899');

    $radiusCss = ['none' => '0px', 'md' => '12px', 'lg' => '20px', 'xl' => '28px'][$radius];

    $bgCss = match ($background) {
        'light'    => '#f1f5f9',
        'dark'     => '#0f172a',
        'gradient' => "linear-gradient(135deg, {$accent}, {$accent2})",
        default    => 'transparent',
    };

    $hasModel = $modelUrl !== '' && preg_match('#^https?://#i', $modelUrl);
    $hasUsdz  = $usdzUrl !== '' && preg_match('#^https?://#i', $usdzUrl);
@endphp

@once
<script type="module" src="https://cdn.jsdelivr.net/npm/@google/model-viewer@3.5.0/dist/model-viewer.min.js"></script>
@endonce

<style>
    #{{ $uid }} {
        --o3-accent: {{ $accent }};
        --o3-accent2: {{ $accent2 }};
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .o3-inner { max-width: 1120px; margin: 0 auto; }

    #{{ $uid }} .o3-head {
        max-width: 640px;
        margin: 0 auto 28px;
        text-align: center;
    }
    #{{ $uid }} .o3-sub {
        margin: 0 0 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--o3-accent);
    }
    #{{ $uid }} .o3-title {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.02em;
        color: #0f172a;
    }
    @media (min-width: 768px) { #{{ $uid }} .o3-title { font-size: 38px; } }

    #{{ $uid }} .o3-viewer {
        position: relative;
        width: 100%;
        height: {{ $height }}px;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        background: {{ $bgCss }};
        box-shadow: 0 30px 60px -30px rgba(15, 23, 42, .45);
        isolation: isolate;
    }

    #{{ $uid }} model-viewer {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        display: block;
        outline: 0;
        background: transparent;
        --poster-color: transparent;
        --progress-bar-color: var(--o3-accent);
        --progress-bar-height: 3px;
        --progress-mask: transparent;
        opacity: 0;
        transform: scale(.97);
        transition: opacity .8s ease, transform .9s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} model-viewer.is-ready {
        opacity: 1;
        transform: none;
    }

    #{{ $uid }} .o3-glow {
        position: absolute;
        width: 320px;
        height: 320px;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        background: radial-gradient(circle, color-mix(in srgb, var(--o3-accent) 35%, transparent), transparent 70%);
        filter: blur(20px);
        pointer-events: none;
        animation: o3Breathe 6s ease-in-out infinite;
        z-index: 0;
    }
    @keyframes o3Breathe {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: .6; }
        50%      { transform: translate(-50%, -50%) scale(1.15); opacity: 1; }
    }

    #{{ $uid }} .o3-hint {
        position: absolute;
        bottom: 14px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .6);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        pointer-events: none;
        transition: opacity .4s ease;
    }
    #{{ $uid }} .o3-hint svg { width: 12px; height: 12px; }
    #{{ $uid }} .o3-viewer.is-touched .o3-hint,
    #{{ $uid }} .o3-viewer:hover .o3-hint { opacity: 0; }
    @media (hover: none) { #{{ $uid }} .o3-hint { display: none; } }

    #{{ $uid }} .o3-ar {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 4;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border: 0;
        border-radius: 10px;
        background: rgba(15, 23, 42, .7);
        color: #fff;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        backdrop-filter: blur(6px);
        transition: background .2s ease, transform .2s ease;
    }
    #{{ $uid }} .o3-ar:hover { background: rgba(15, 23, 42, .9); transform: translateY(-1px); }
    #{{ $uid }} .o3-ar svg { width: 14px; height: 14px; }

    #{{ $uid }} .o3-status {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        pointer-events: none;
        transition: opacity .5s ease;
    }
    #{{ $uid }} .o3-status.is-hidden { opacity: 0; }
    #{{ $uid }} .o3-spinner {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 3px solid rgba(100, 116, 139, .25);
        border-top-color: var(--o3-accent);
        animation: o3Spin .9s linear infinite;
    }
    @keyframes o3Spin { to { transform: rotate(360deg); } }

    #{{ $uid }} .o3-error {
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
        #{{ $uid }} model-viewer { opacity: 1; transform: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="o3-inner">
        @if($title !== '' || $subtitle !== '')
            <header class="o3-head">
                @if($subtitle !== '')
                    <p class="o3-sub">{{ $subtitle }}</p>
                @endif
                @if($title !== '')
                    <h2 class="o3-title">{{ $title }}</h2>
                @endif
            </header>
        @endif

        @if($hasModel)
            <div class="o3-viewer" data-state="loading">
                @if($background !== 'transparent')
                    <span class="o3-glow" aria-hidden="true"></span>
                @endif

                <model-viewer
                    src="{{ $modelUrl }}"
                    @if($hasUsdz) ios-src="{{ $usdzUrl }}" @endif
                    @if($poster !== '') poster="{{ $poster }}" @endif
                    alt="{{ $title !== '' ? $title : __('3D model') }}"
                    camera-controls
                    camera-orbit="{{ $cameraOrbit }}"
                    environment-image="neutral"
                    exposure="1"
                    shadow-intensity="1"
                    shadow-softness="0.8"
                    interaction-prompt="none"
                    touch-action="pan-y"
                    @if($autoRotate) auto-rotate rotation-per-second="20deg" @endif
                    @if(!$enableZoom) disable-zoom @endif
                    @if(!$enablePan) disable-pan @endif
                    loading="lazy">
                    @if($hasUsdz)
                        <button class="o3-ar" slot="ar-button" type="button">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l9 5v10l-9 5-9-5V7l9-5zM12 12l9-5M12 12l-9-5M12 12v10"/></svg>
                            <span>{{ __('View in AR') }}</span>
                        </button>
                    @endif
                </model-viewer>

                <div class="o3-status" aria-live="polite">
                    <span class="o3-spinner"></span>
                    <span>{{ __('Loading 3D model…') }}</span>
                </div>

                <div class="o3-error o3-status" hidden style="background:#f8fafc;border:1px dashed #cbd5e1;">
                    {{ __('The 3D model could not be loaded.') }}
                </div>

                <div class="o3-hint">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                    <span>{{ __('Drag to rotate') }}</span>
                </div>
            </div>
        @else
            <div class="o3-error">{{ __('Please provide a .glb or .gltf model URL.') }}</div>
        @endif
    </div>
</div>

@if($hasModel)
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var viewer = root.querySelector('model-viewer');
    var box = root.querySelector('.o3-viewer');
    var status = root.querySelector('.o3-status');
    var errorBox = root.querySelector('.o3-error');
    if (!viewer || !box) return;

    viewer.addEventListener('load', function () {
        viewer.classList.add('is-ready');
        if (status) status.classList.add('is-hidden');
        box.setAttribute('data-state', 'ready');
    });

    viewer.addEventListener('error', function () {
        box.setAttribute('data-state', 'error');
        if (status) status.hidden = true;
        if (errorBox) errorBox.hidden = false;
    });

    // Hide the hint permanently after the first real interaction
    viewer.addEventListener('camera-change', function (e) {
        if (e.detail && e.detail.source === 'user-interaction') {
            box.classList.add('is-touched');
        }
    });
})();
</script>
@endif
