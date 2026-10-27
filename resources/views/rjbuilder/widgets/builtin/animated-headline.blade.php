@php
    $before         = trim($settings['text_before'] ?? '');
    $highlight      = $settings['text_highlight'] ?? __('Amazing');
    $after          = trim($settings['text_after'] ?? '');
    $tag            = $settings['tag'] ?? 'h2';
    $effect         = $settings['effect'] ?? 'underline';
    $underlineStyle = $settings['underline_style'] ?? 'pen';
    $direction      = $settings['direction'] ?? 'left';
    $align          = $settings['align'] ?? 'center';
    $size           = $settings['size'] ?? 'xl';
    $weight         = $settings['weight'] ?? '800';
    $color          = $settings['color'] ?? '#0f172a';
    $accent         = $settings['accent'] ?? '#8b5cf6';
    $hoverChange    = $settings['hover_change'] ?? true;
    $hoverColor     = $settings['hover_color'] ?? '#ec4899';
    $animate        = $settings['animate'] ?? true;
    $paddingY       = (int) ($settings['padding_y'] ?? 40);

    $sizeMap = [
        'lg'  => 'clamp(22px, 2.2vw, 32px)',
        'xl'  => 'clamp(28px, 3.4vw, 48px)',
        '2xl' => 'clamp(36px, 4.4vw, 64px)',
        '3xl' => 'clamp(44px, 5.4vw, 80px)',
    ];
    $sizeCss = $sizeMap[$size] ?? $sizeMap['xl'];

    if (!in_array($tag, ['h1', 'h2', 'h3', 'h4', 'div'], true)) {
        $tag = 'h2';
    }

    $paths = [];
    switch ($underlineStyle) {
        case 'pen':
            $paths = [['d' => 'M 3 12 C 30 8, 60 14, 90 10 S 150 8, 197 11', 'w' => 2.5, 'dash' => '', 'opacity' => 1]];
            break;
        case 'brush':
            $paths = [['d' => 'M 3 11 C 40 5, 80 16, 120 9 S 180 7, 197 11', 'w' => 6, 'dash' => '', 'opacity' => 0.9]];
            break;
        case 'wave':
            $paths = [['d' => 'M 3 10 Q 15 2, 27 10 T 51 10 T 75 10 T 99 10 T 123 10 T 147 10 T 171 10 T 195 10', 'w' => 2.5, 'dash' => '', 'opacity' => 1]];
            break;
        case 'plain':
            $paths = [['d' => 'M 3 10 L 197 10', 'w' => 3, 'dash' => '', 'opacity' => 1]];
            break;
        case 'double':
            $paths = [
                ['d' => 'M 3 6 L 197 6', 'w' => 2, 'dash' => '', 'opacity' => 1],
                ['d' => 'M 3 14 L 197 14', 'w' => 2, 'dash' => '', 'opacity' => 1],
            ];
            break;
        case 'dashed':
        default:
            $paths = [['d' => 'M 3 10 L 197 10', 'w' => 3, 'dash' => '8 6', 'opacity' => 1]];
            break;
    }

    $circlePath = 'M 100 6 C 38 4, 8 22, 6 50 C 5 76, 40 94, 98 96 C 160 94, 194 74, 194 52 C 193 26, 158 6, 100 6 Z';

    $revealClass = '';
    if ($animate) {
        if ($direction === 'right') $revealClass = 'rj-ah-rev-r';
        elseif ($direction === 'both') $revealClass = 'rj-ah-rev-b';
        else $revealClass = 'rj-ah-rev-l';
    } else {
        $revealClass = 'rj-ah-rev-none';
    }

    $hasBefore = $before !== '';
    $hasAfter  = $after !== '';
@endphp

@once
<style>
    @keyframes rjAhRevealL { from { clip-path: inset(0 100% 0 0); } to { clip-path: inset(0 0 0 0); } }
    @keyframes rjAhRevealR { from { clip-path: inset(0 0 0 100%); } to { clip-path: inset(0 0 0 0); } }
    @keyframes rjAhRevealB { from { clip-path: inset(0 50% 0 50%); } to { clip-path: inset(0 0 0 0); } }
    @keyframes rjAhFade    { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
    @keyframes rjAhBlink   { 0%, 49% { opacity: 1; } 50%, 100% { opacity: 0; } }
    @keyframes rjAhBgSweepL { from { transform: scaleX(0); transform-origin: left; } to { transform: scaleX(1); transform-origin: left; } }
    @keyframes rjAhBgSweepR { from { transform: scaleX(0); transform-origin: right; } to { transform: scaleX(1); transform-origin: right; } }
    @keyframes rjAhBgSweepB { from { transform: scaleX(0); transform-origin: center; } to { transform: scaleX(1); transform-origin: center; } }
</style>
@endonce

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        text-align: {{ $align }};
    }
    #{{ $uid }} .rj-ah-text {
        --ah-color: {{ $color }};
        --ah-accent: {{ $accent }};
        --ah-hover: {{ $hoverColor }};
        --ah-size: {{ $sizeCss }};
        --ah-weight: {{ $weight }};
        margin: 0;
        font-size: var(--ah-size);
        font-weight: var(--ah-weight);
        color: var(--ah-color);
        line-height: 1.15;
        letter-spacing: -.02em;
        display: inline-block;
        text-align: inherit;
    }
    #{{ $uid }} .rj-ah-text.rj-ah-align-left  { display: block; text-align: left; }
    #{{ $uid }} .rj-ah-text.rj-ah-align-right { display: block; text-align: right; }
    #{{ $uid }} .rj-ah-text.rj-ah-align-center { display: block; text-align: center; }

    #{{ $uid }} .rj-ah-word-part { display: inline; }

    #{{ $uid }} .rj-ah-word {
        position: relative;
        display: inline-block;
        padding: 0 .06em;
    }

    #{{ $uid }} .rj-ah-highlight {
        position: relative;
        display: inline-block;
        color: var(--ah-accent);
        transition: color .3s ease;
        z-index: 2;
    }
    #{{ $uid }} .rj-ah-hover-on:hover .rj-ah-highlight {
        color: var(--ah-hover);
    }

    #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before {
        content: '';
        position: absolute;
        left: -4px;
        right: -4px;
        top: 12%;
        bottom: 8%;
        background: color-mix(in srgb, currentColor 22%, transparent);
        border-radius: 4px;
        z-index: -1;
        transform-origin: center;
    }
    @if($animate)
    #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before.rj-ah-rev-l { animation: rjAhBgSweepL 1s cubic-bezier(.2,.8,.2,1) .3s both; }
    #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before.rj-ah-rev-r { animation: rjAhBgSweepR 1s cubic-bezier(.2,.8,.2,1) .3s both; }
    #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before.rj-ah-rev-b { animation: rjAhBgSweepB 1s cubic-bezier(.2,.8,.2,1) .3s both; }
    #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before { transform: scaleX(0); }
    @endif

    #{{ $uid }} .rj-ah-svg-wrap {
        position: absolute;
        pointer-events: none;
        z-index: 1;
    }
    #{{ $uid }} .rj-ah-word[data-effect="underline"] .rj-ah-svg-wrap,
    #{{ $uid }} .rj-ah-word[data-effect="circle"] .rj-ah-svg-wrap {
        display: block;
    }
    #{{ $uid }} .rj-ah-word[data-effect="underline"] .rj-ah-svg-wrap {
        left: -2%;
        right: -2%;
        bottom: -.16em;
        height: .5em;
    }
    #{{ $uid }} .rj-ah-word[data-effect="circle"] .rj-ah-svg-wrap {
        left: -8%;
        right: -8%;
        top: -.22em;
        bottom: -.24em;
    }
    #{{ $uid }} .rj-ah-svg-wrap svg {
        width: 100%;
        height: 100%;
        display: block;
        overflow: visible;
    }
    #{{ $uid }} .rj-ah-svg-wrap path {
        fill: none;
        stroke: var(--ah-accent);
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: stroke .3s ease;
    }
    #{{ $uid }} .rj-ah-hover-on:hover .rj-ah-svg-wrap path {
        stroke: var(--ah-hover);
    }

    #{{ $uid }} .rj-ah-svg-wrap.rj-ah-rev-l svg { animation: rjAhRevealL 1.3s cubic-bezier(.2,.8,.2,1) .35s both; }
    #{{ $uid }} .rj-ah-svg-wrap.rj-ah-rev-r svg { animation: rjAhRevealR 1.3s cubic-bezier(.2,.8,.2,1) .35s both; }
    #{{ $uid }} .rj-ah-svg-wrap.rj-ah-rev-b svg { animation: rjAhRevealB 1.3s cubic-bezier(.2,.8,.2,1) .35s both; }
    #{{ $uid }} .rj-ah-svg-wrap.rj-ah-rev-none svg { clip-path: none; }

    #{{ $uid }} .rj-ah-typed-wrap {
        display: inline-block;
        color: var(--ah-accent);
        transition: color .3s ease;
    }
    #{{ $uid }} .rj-ah-hover-on:hover .rj-ah-typed-wrap { color: var(--ah-hover); }
    #{{ $uid }} .rj-ah-cursor {
        display: inline-block;
        width: .06em;
        height: 1em;
        margin-left: .04em;
        vertical-align: -.12em;
        background: currentColor;
        animation: rjAhBlink 1s steps(1) infinite;
    }

    #{{ $uid }} .rj-ah-no-anim,
    #{{ $uid }} .rj-ah-no-anim * {
        animation: none !important;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-ah-svg-wrap svg,
        #{{ $uid }} .rj-ah-cursor,
        #{{ $uid }} .rj-ah-word[data-effect="highlight"] .rj-ah-highlight::before {
            animation: none !important;
            clip-path: none !important;
            transform: none !important;
            opacity: 1 !important;
        }
    }
</style>

<div id="{{ $uid }}">
    <{{ $tag }} class="rj-ah-text rj-ah-align-{{ $align }} {{ $hoverChange ? 'rj-ah-hover-on' : '' }}">
        @if($hasBefore)
            <span class="rj-ah-word-part">{{ $before }}</span>
        @endif
        @if($hasBefore || $hasAfter) <span> </span> @endif

        <span class="rj-ah-word" data-effect="{{ $effect }}">
            @if($effect === 'typing')
                <span class="rj-ah-typed-wrap">
                    <span class="rj-ah-typed" data-text="{{ $highlight }}" data-animate="{{ $animate ? '1' : '0' }}">{{ $animate ? '' : $highlight }}</span><span class="rj-ah-cursor"></span>
                </span>
            @else
                <span class="rj-ah-highlight {{ $effect === 'highlight' ? $revealClass : '' }}">
                    {{ $highlight }}
                </span>
                @if($effect === 'underline')
                    <span class="rj-ah-svg-wrap {{ $revealClass }}" aria-hidden="true">
                        <svg viewBox="0 0 200 20" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            @foreach($paths as $p)
                                <path d="{{ $p['d'] }}"
                                      stroke-width="{{ $p['w'] }}"
                                      opacity="{{ $p['opacity'] }}"
                                      @if(!empty($p['dash'])) stroke-dasharray="{{ $p['dash'] }}" @endif />
                            @endforeach
                        </svg>
                    </span>
                @elseif($effect === 'circle')
                    <span class="rj-ah-svg-wrap {{ $revealClass }}" aria-hidden="true">
                        <svg viewBox="0 0 200 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="{{ $circlePath }}" stroke-width="3"/>
                        </svg>
                    </span>
                @endif
            @endif
        </span>

        @if($hasBefore || $hasAfter) <span> </span> @endif
        @if($hasAfter)
            <span class="rj-ah-word-part">{{ $after }}</span>
        @endif
    </{{ $tag }}>
</div>

@if($effect === 'typing')
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var el = root.querySelector('.rj-ah-typed');
    if (!el) return;
    var full = el.getAttribute('data-text') || '';
    var animate = el.getAttribute('data-animate') === '1';
    if (!animate) { el.textContent = full; return; }
    var i = 0;
    var delay = 500;
    setTimeout(function () {
        var t = setInterval(function () {
            el.textContent = full.slice(0, ++i);
            if (i >= full.length) clearInterval(t);
        }, 70);
    }, delay);
})();
</script>
@endif
