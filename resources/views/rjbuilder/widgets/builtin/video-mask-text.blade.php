@php
    $text      = trim((string) ($settings['text'] ?? 'CREATIVE'));
    $text      = $text !== '' ? $text : 'CREATIVE';
    $subtitle  = trim((string) ($settings['subtitle'] ?? ''));
    $videoUrl  = trim((string) ($settings['video_url'] ?? ''));
    $poster    = trim((string) ($settings['poster'] ?? ''));
    $weight    = in_array((string) ($settings['font_weight'] ?? '900'), ['700', '800', '900'], true)
                    ? (string) $settings['font_weight'] : '900';
    $align     = in_array($settings['align'] ?? 'center', ['left', 'center', 'right'], true)
                    ? $settings['align'] : 'center';
    $hoverOn   = !empty($settings['hover_accent'] ?? true);
    $overlayOn = !empty($settings['overlay'] ?? false);
    $paddingY  = max(0, min(200, (int) ($settings['padding_y'] ?? 60)));

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $fallbackColor = $hexOk($settings['fallback_color'] ?? '', '#0f172a');
    $hoverColor    = $hexOk($settings['hover_color'] ?? '', '#8b5cf6');
    $overlayColor  = $hexOk($settings['overlay_color'] ?? '', '#8b5cf6');
    $subtitleColor = $hexOk($settings['subtitle_color'] ?? '', '#64748b');

    // Text is rendered as an SVG mask. viewBox 1200x240, text fitted to fixed width.
    $x      = match ($align) { 'left' => 40, 'right' => 1160, default => 600 };
    $anchor = match ($align) { 'left' => 'start', 'right' => 'end', default => 'middle' };
    $safe   = htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $svg    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 240">'
            . '<text x="' . $x . '" y="185" text-anchor="' . $anchor . '"'
            . ' font-family="Arial Black, Helvetica Neue, Arial, sans-serif"'
            . ' font-weight="' . $weight . '" font-size="200"'
            . ' textLength="1120" lengthAdjust="spacingAndGlyphs" fill="#000">'
            . $safe . '</text></svg>';
    $maskUrl = 'data:image/svg+xml;base64,' . base64_encode($svg);
@endphp

<style>
    #{{ $uid }} {
        --vmt-mask: url("{{ $maskUrl }}");
        --vmt-fallback: {{ $fallbackColor }};
        --vmt-hover: {{ $hoverColor }};
        --vmt-overlay: {{ $overlayColor }};
        box-sizing: border-box;
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .vmt-stage {
        position: relative;
        width: 100%;
        max-width: 1200px;
        aspect-ratio: 1200 / 240;
        margin: 0 auto;
        overflow: hidden;
    }

    #{{ $uid }} .vmt-layer {
        position: absolute;
        inset: 0;
        -webkit-mask: var(--vmt-mask) center / 100% 100% no-repeat;
        mask: var(--vmt-mask) center / 100% 100% no-repeat;
    }

    /* Fallback: visible only when the video is not loaded */
    #{{ $uid }} .vmt-base {
        z-index: 0;
        background: var(--vmt-fallback);
    }

    /* Video (and optional tint) inside the text mask */
    #{{ $uid }} .vmt-media {
        z-index: 1;
        overflow: hidden;
    }
    #{{ $uid }} .vmt-video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        pointer-events: none;
    }
    #{{ $uid }} .vmt-tint {
        position: absolute;
        inset: 0;
        background: var(--vmt-overlay);
        opacity: .35;
        mix-blend-mode: overlay;
        pointer-events: none;
    }

    /* Hover color fill */
    #{{ $uid }} .vmt-hover {
        z-index: 2;
        background: var(--vmt-hover);
        opacity: 0;
        transition: opacity .35s ease;
        pointer-events: none;
    }
    @media (hover: hover) {
        #{{ $uid }} .vmt-stage:hover .vmt-hover { opacity: 1; }
    }

    /* Screen-reader heading, visually hidden */
    #{{ $uid }} .vmt-sr {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0 0 0 0);
        white-space: nowrap;
        margin: -1px;
        padding: 0;
        border: 0;
    }

    #{{ $uid }} .vmt-subtitle {
        margin: 20px auto 0;
        max-width: 720px;
        text-align: {{ $align }};
        font-size: clamp(14px, 1.4vw, 18px);
        font-weight: 500;
        line-height: 1.6;
        color: {{ $subtitleColor }};
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .vmt-hover { transition: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="vmt-stage">
        <h2 class="vmt-sr">{{ $text }}</h2>

        <div class="vmt-layer vmt-base" aria-hidden="true"></div>

        @if($videoUrl !== '')
            <div class="vmt-layer vmt-media" aria-hidden="true">
                <video class="vmt-video"
                       autoplay
                       muted
                       loop
                       playsinline
                       preload="auto"
                       @if($poster !== '') poster="{{ $poster }}" @endif>
                    <source src="{{ $videoUrl }}">
                </video>
                @if($overlayOn)
                    <span class="vmt-tint"></span>
                @endif
            </div>
        @endif

        @if($hoverOn)
            <div class="vmt-layer vmt-hover" aria-hidden="true"></div>
        @endif
    </div>

    @if($subtitle !== '')
        <p class="vmt-subtitle">{{ $subtitle }}</p>
    @endif
</div>

@if($videoUrl !== '')
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var video = root.querySelector('video');
    if (!video) return;

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce) {
        video.pause();
        return;
    }
    var p = video.play();
    if (p && p.catch) p.catch(function () {});
})();
</script>
@endif
