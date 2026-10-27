@php
    $text           = $settings['text'] ?? 'CREATIVE';
    $subtitle       = $settings['subtitle'] ?? '';
    $videoUrl       = trim($settings['video_url'] ?? '');
    $poster         = $settings['poster'] ?? '';
    $fontSizeVw     = (int) ($settings['font_size'] ?? 18);
    $weight         = $settings['font_weight'] ?? '900';
    $letterSpacing  = (int) ($settings['letter_spacing'] ?? -2);
    $align          = $settings['align'] ?? 'center';
    $fallbackColor  = $settings['fallback_color'] ?? '#0f172a';
    $subtitleColor  = $settings['subtitle_color'] ?? '#64748b';
    $hoverAccent    = $settings['hover_accent'] ?? true;
    $hoverColor     = $settings['hover_color'] ?? '#8b5cf6';
    $overlay        = $settings['overlay'] ?? false;
    $overlayColor   = $settings['overlay_color'] ?? '#8b5cf6';
    $paddingY       = (int) ($settings['padding_y'] ?? 60);

    $stageWidth    = min(100, max(20, $fontSizeVw * 5));
    $textLen       = max(1, mb_strlen($text));
    $fitSize       = 1100 / ($textLen * 0.58);
    $svgFontSize   = min(220, max(80, $fitSize));
    $svgLetter     = number_format(($letterSpacing / 100) * $svgFontSize, 2, '.', '');
    $fontFamily    = "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif";

    $textX = 600;
    if ($align === 'left') $textX = 40;
    elseif ($align === 'right') $textX = 1160;
    $textAnchor = $align === 'left' ? 'start' : ($align === 'right' ? 'end' : 'middle');
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .vmt-stage {
        width: 100%;
        max-width: {{ $stageWidth }}vw;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }
    #{{ $uid }} .vmt-svg {
        width: 100%;
        height: auto;
        display: block;
        overflow: visible;
    }
    #{{ $uid }} .vmt-hover-layer {
        opacity: 0;
        transition: opacity .35s ease;
        pointer-events: none;
    }
    #{{ $uid }} .vmt-stage:hover .vmt-hover-layer {
        opacity: 1;
    }
    @media (hover: none) {
        #{{ $uid }} .vmt-hover-layer { display: none; }
    }
    #{{ $uid }} .vmt-subtitle {
        text-align: {{ $align }};
        font-size: clamp(14px, 1.4vw, 18px);
        font-weight: 500;
        color: {{ $subtitleColor }};
        margin: 20px auto 0;
        max-width: 720px;
        line-height: 1.6;
    }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .vmt-hover-layer { transition: none; }
    }
</style>

<div id="{{ $uid }}">
    <div class="vmt-stage">
        <svg class="vmt-svg"
             viewBox="0 0 1200 240"
             preserveAspectRatio="xMidYMid meet"
             xmlns="http://www.w3.org/2000/svg"
             role="img"
             aria-label="{{ $text }}">
            <defs>
                <mask id="vmt-mask-{{ $uid }}">
                    <rect width="1200" height="240" fill="black"/>
                    <text x="{{ $textX }}"
                          y="180"
                          text-anchor="{{ $textAnchor }}"
                          font-size="{{ number_format($svgFontSize, 2, '.', '') }}"
                          font-weight="{{ $weight }}"
                          letter-spacing="{{ $svgLetter }}"
                          font-family="{{ $fontFamily }}"
                          fill="white">{{ $text }}</text>
                </mask>
            </defs>

            <text x="{{ $textX }}"
                  y="180"
                  text-anchor="{{ $textAnchor }}"
                  font-size="{{ number_format($svgFontSize, 2, '.', '') }}"
                  font-weight="{{ $weight }}"
                  letter-spacing="{{ $svgLetter }}"
                  font-family="{{ $fontFamily }}"
                  fill="{{ $fallbackColor }}">{{ $text }}</text>

            @if($videoUrl !== '')
                <foreignObject x="0" y="0" width="1200" height="240" mask="url(#vmt-mask-{{ $uid }})">
                    <video xmlns="http://www.w3.org/1999/xhtml"
                           autoplay
                           muted
                           loop
                           playsinline
                           preload="metadata"
                           @if($poster !== '') poster="{{ $poster }}" @endif
                           style="width:100%;height:100%;object-fit:cover;display:block;pointer-events:none;">
                        <source src="{{ $videoUrl }}" type="video/mp4">
                    </video>
                </foreignObject>

                @if($overlay)
                    <foreignObject x="0" y="0" width="1200" height="240" mask="url(#vmt-mask-{{ $uid }})" style="pointer-events:none;">
                        <div xmlns="http://www.w3.org/1999/xhtml"
                             style="width:100%;height:100%;background:{{ $overlayColor }};opacity:.35;mix-blend-mode:overlay;"></div>
                    </foreignObject>
                @endif
            @endif

            @if($hoverAccent)
                <foreignObject x="0" y="0" width="1200" height="240" mask="url(#vmt-mask-{{ $uid }})" class="vmt-hover-layer">
                    <div xmlns="http://www.w3.org/1999/xhtml"
                         style="width:100%;height:100%;background:{{ $hoverColor }};"></div>
                </foreignObject>
            @endif
        </svg>
    </div>

    @if($subtitle !== '')
        <p class="vmt-subtitle">{{ $subtitle }}</p>
    @endif
</div>
