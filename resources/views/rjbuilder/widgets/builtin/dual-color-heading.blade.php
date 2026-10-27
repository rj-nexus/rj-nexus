@php
    $before       = trim($settings['before'] ?? '');
    $after        = trim($settings['after'] ?? '');
    $tag          = $settings['tag'] ?? 'h2';
    $style        = $settings['style'] ?? 'solid';
    $layoutMode   = $settings['layout'] ?? 'inline';
    $size         = $settings['size'] ?? 'xl';
    $weight       = $settings['weight'] ?? '800';
    $align        = $settings['align'] ?? 'center';
    $colorBefore  = $settings['color_before'] ?? '#0f172a';
    $colorAfter   = $settings['color_after'] ?? '#8b5cf6';
    $gradientEnd  = $settings['gradient_end'] ?? '#ec4899';
    $highlightBg  = $settings['highlight_bg'] ?? '#fef3c7';
    $animate      = $settings['animate'] ?? true;
    $paddingY     = (int) ($settings['padding_y'] ?? 40);

    if (!in_array($tag, ['h1', 'h2', 'h3', 'h4', 'div'], true)) {
        $tag = 'h2';
    }

    $sizeMap = [
        'lg'  => 'clamp(20px, 2.2vw, 30px)',
        'xl'  => 'clamp(26px, 3vw, 42px)',
        '2xl' => 'clamp(32px, 4vw, 56px)',
        '3xl' => 'clamp(40px, 5vw, 72px)',
        '4xl' => 'clamp(48px, 6.5vw, 96px)',
    ];
    $sizeCss = $sizeMap[$size] ?? $sizeMap['xl'];
@endphp

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        text-align: {{ $align }};
    }
    #{{ $uid }} .rj-dch {
        --dch-c1: {{ $colorBefore }};
        --dch-c2: {{ $colorAfter }};
        --dch-c3: {{ $gradientEnd }};
        --dch-bg: {{ $highlightBg }};
        --dch-size: {{ $sizeCss }};
        --dch-weight: {{ $weight }};
        margin: 0;
        font-size: var(--dch-size);
        font-weight: var(--dch-weight);
        line-height: 1.12;
        letter-spacing: -.02em;
        color: var(--dch-c1);
    }
    #{{ $uid }} .rj-dch[data-layout="stacked"] {
        display: inline-flex;
        flex-direction: column;
        gap: .06em;
    }
    #{{ $uid }} .rj-dch-part {
        display: inline;
    }
    #{{ $uid }} .rj-dch[data-layout="stacked"] .rj-dch-part {
        display: block;
    }
    #{{ $uid }} .rj-dch-accent {
        position: relative;
        display: inline;
    }

    /* ---------- SOLID ---------- */
    #{{ $uid }} .rj-dch[data-style="solid"] .rj-dch-accent {
        color: var(--dch-c2);
    }

    /* ---------- GRADIENT ---------- */
    #{{ $uid }} .rj-dch[data-style="gradient"] .rj-dch-part {
        background: linear-gradient(90deg, var(--dch-c1), var(--dch-c2), var(--dch-c3));
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }

    /* ---------- OUTLINE ---------- */
    #{{ $uid }} .rj-dch[data-style="outline"] .rj-dch-accent {
        color: transparent;
        -webkit-text-stroke: 2px var(--dch-c2);
        text-stroke: 2px var(--dch-c2);
        paint-order: stroke fill;
    }
    @media (max-width: 640px) {
        #{{ $uid }} .rj-dch[data-style="outline"] .rj-dch-accent {
            -webkit-text-stroke: 1.5px var(--dch-c2);
        }
    }

    /* ---------- HIGHLIGHT ---------- */
    #{{ $uid }} .rj-dch[data-style="highlight"] .rj-dch-accent {
        display: inline-block;
        padding: 0 .18em;
        color: var(--dch-c1);
        background: linear-gradient(180deg, transparent 55%, var(--dch-bg) 55%, var(--dch-bg) 92%, transparent 92%);
        background-repeat: no-repeat;
        background-size: 0% 100%;
        background-position: left center;
        transition: background-size .9s cubic-bezier(.2,.8,.2,1) .25s;
    }
    #{{ $uid }} .rj-dch.is-visible[data-style="highlight"] .rj-dch-accent {
        background-size: 100% 100%;
    }
    #{{ $uid }} .rj-dch[data-style="highlight"]:not(.is-visible) .rj-dch-accent {
        background-size: 0% 100%;
    }
    @if(!$animate)
    #{{ $uid }} .rj-dch[data-style="highlight"] .rj-dch-accent {
        background-size: 100% 100%;
    }
    @endif

    /* ---------- UNDERLINE ---------- */
    #{{ $uid }} .rj-dch[data-style="underline"] .rj-dch-accent {
        display: inline-block;
        color: var(--dch-c2);
        position: relative;
    }
    #{{ $uid }} .rj-dch[data-style="underline"] .rj-dch-accent::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: -.06em;
        height: .12em;
        border-radius: 3px;
        background: linear-gradient(90deg, var(--dch-c2), var(--dch-c3));
        transform: scaleX(0);
        transform-origin: left center;
        transition: transform .8s cubic-bezier(.2,.8,.2,1) .25s;
    }
    #{{ $uid }} .rj-dch.is-visible[data-style="underline"] .rj-dch-accent::after {
        transform: scaleX(1);
    }
    #{{ $uid }} .rj-dch[data-style="underline"]:not(.is-visible) .rj-dch-accent::after {
        transform: scaleX(0);
    }
    @if(!$animate)
    #{{ $uid }} .rj-dch[data-style="underline"] .rj-dch-accent::after {
        transform: scaleX(1);
    }
    @endif

    /* ---------- ANIMATION ---------- */
    #{{ $uid }} .rj-dch-anim {
        opacity: 0;
        transform: translateY(16px);
        transition: opacity .8s ease, transform .8s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-dch-anim.is-visible {
        opacity: 1;
        transform: none;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-dch-anim {
            opacity: 1;
            transform: none;
            transition: none;
        }
        #{{ $uid }} .rj-dch[data-style="highlight"] .rj-dch-accent { background-size: 100% 100%; }
        #{{ $uid }} .rj-dch[data-style="underline"] .rj-dch-accent::after { transform: scaleX(1); }
    }
</style>

<div id="{{ $uid }}">
    <{{ $tag }} class="rj-dch {{ $animate ? 'rj-dch-anim' : '' }}"
            data-style="{{ $style }}"
            data-layout="{{ $layoutMode }}"
            data-anim>
        @if($before !== '')
            <span class="rj-dch-part">{{ $before }}</span>
        @endif
        @if($before !== '' && $after !== '' && $layoutMode === 'inline')
            <span> </span>
        @endif
        @if($after !== '')
            <span class="rj-dch-part rj-dch-accent">{{ $after }}</span>
        @endif
    </{{ $tag }}>
</div>

@if($animate)
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var el = root.querySelector('[data-anim]');
    if (!el) return;
    if (typeof IntersectionObserver === 'undefined') {
        el.classList.add('is-visible');
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                el.classList.add('is-visible');
                io.unobserve(el);
            }
        });
    }, { threshold: 0.15 });
    io.observe(el);
})();
</script>
@endif
