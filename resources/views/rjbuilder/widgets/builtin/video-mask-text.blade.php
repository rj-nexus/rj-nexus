@php
    $text          = $settings['text'] ?? 'CREATIVE';
    $subtitle      = $settings['subtitle'] ?? '';
    $videoUrl      = trim($settings['video_url'] ?? '');
    $poster        = $settings['poster'] ?? '';
    $fontSizeVw    = max(6, min(30, (int) ($settings['font_size'] ?? 18)));
    $weight        = in_array($settings['font_weight'] ?? '900', ['700', '800', '900'], true) ? $settings['font_weight'] : '900';
    $letterSpacing = max(-10, min(40, (int) ($settings['letter_spacing'] ?? -2)));
    $align         = in_array($settings['align'] ?? 'center', ['left', 'center', 'right'], true) ? $settings['align'] : 'center';
    $fallbackColor = $settings['fallback_color'] ?? '#0f172a';
    $subtitleColor = $settings['subtitle_color'] ?? '#64748b';
    $hoverAccent   = !empty($settings['hover_accent'] ?? true);
    $hoverColor    = $settings['hover_color'] ?? '#8b5cf6';
    $overlay       = !empty($settings['overlay'] ?? false);
    $overlayColor  = $settings['overlay_color'] ?? '#8b5cf6';
    $paddingY      = max(0, min(200, (int) ($settings['padding_y'] ?? 60)));

    $justify = match($align) { 'left' => 'flex-start', 'right' => 'flex-end', default => 'center' };
    $textAlign = $align;
    $fontSizeCss = 'clamp(64px, ' . $fontSizeVw . 'vw, 420px)';
@endphp

<style>
    #{{ $uid }} {
        --vmt-fallback: {{ $fallbackColor }};
        --vmt-hover: {{ $hoverColor }};
        --vmt-overlay: {{ $overlayColor }};
        width: 100%;
        box-sizing: border-box;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .vmt-stage {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: {{ $justify }};
        overflow: hidden;
        isolation: isolate;
    }

    #{{ $uid }} .vmt-video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        pointer-events: none;
        background: var(--vmt-fallback);
    }

    #{{ $uid }} .vmt-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        background: var(--vmt-overlay);
        opacity: .35;
        mix-blend-mode: overlay;
        pointer-events: none;
    }

    /* The text itself is the mask: video shows through the glyphs */
    #{{ $uid }} .vmt-text {
        position: relative;
        z-index: 2;
        margin: 0;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        font-size: {{ $fontSizeCss }};
        font-weight: {{ $weight }};
        line-height: .95;
        letter-spacing: {{ $letterSpacing / 100 }}em;
        text-align: {{ $textAlign }};
        white-space: nowrap;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        background-color: var(--vmt-fallback);
        transition: background-color .35s ease, filter .35s ease;
    }

    @if($videoUrl !== '')
        #{{ $uid }} .vmt-text {
            color: transparent;
            background-color: transparent;
            background-image: none;
        }
        #{{ $uid }} .vmt-text::before {
            content: attr(data-text);
            position: absolute;
            inset: 0;
            z-index: -1;
        }
    @endif

    #{{ $uid }} .vmt-hover {
        position: absolute;
        inset: 0;
        z-index: 3;
        background: var(--vmt-hover);
        opacity: 0;
        transition: opacity .35s ease;
        pointer-events: none;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    #{{ $uid }} .vmt-stage:hover .vmt-hover { opacity: {{ $hoverAccent ? 1 : 0 }}; }

    #{{ $uid }} .vmt-subtitle {
        margin: 20px auto 0;
        max-width: 720px;
        text-align: {{ $textAlign }};
        font-size: clamp(14px, 1.4vw, 18px);
        font-weight: 500;
        line-height: 1.6;
        color: {{ $subtitleColor }};
    }

    @media (hover: none) {
        #{{ $uid }} .vmt-hover { display: none; }
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .vmt-hover, #{{ $uid }} .vmt-text { transition: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="vmt-stage">
        @if($videoUrl !== '')
            <video class="vmt-video"
                   autoplay muted loop playsinline preload="auto"
                   @if($poster !== '') poster="{{ $poster }}" @endif>
                <source src="{{ $videoUrl }}">
            </video>
            @if($overlay)
                <span class="vmt-overlay" aria-hidden="true"></span>
            @endif
        @endif

        <h2 class="vmt-text" data-text="{{ $text }}" aria-label="{{ $text }}">{{ $text }}</h2>

        @if($hoverAccent)
            <span class="vmt-hover" aria-hidden="true">{{ $text }}</span>
        @endif
    </div>

    @if($subtitle !== '')
        <p class="vmt-subtitle">{{ $subtitle }}</p>
    @endif
</div>
