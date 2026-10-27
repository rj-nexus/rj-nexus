@php
    $style      = $settings['style'] ?? 'accent-bar';
    $quote      = $settings['quote'] ?? '';
    $author     = $settings['author'] ?? '';
    $role       = $settings['role'] ?? '';
    $avatar     = $settings['avatar'] ?? '';
    $align      = $settings['align'] ?? 'left';
    $size       = $settings['size'] ?? 'lg';
    $accent     = $settings['accent'] ?? '#8b5cf6';
    $accent2    = $settings['accent2'] ?? '#ec4899';
    $textColor  = $settings['text_color'] ?? '#0f172a';
    $showMarks  = $settings['show_marks'] ?? true;
    $animate    = $settings['animate'] ?? true;
    $paddingY   = (int) ($settings['padding_y'] ?? 40);

    $sizeMap = [
        'md' => 'clamp(16px, 1.6vw, 20px)',
        'lg' => 'clamp(20px, 2.1vw, 26px)',
        'xl' => 'clamp(24px, 2.8vw, 34px)',
    ];
    $sizeCss = $sizeMap[$size] ?? $sizeMap['lg'];
@endphp

<style>
    #{{ $uid }} {
        --bq-accent: {{ $accent }};
        --bq-accent2: {{ $accent2 }};
        --bq-text: {{ $textColor }};
        --bq-size: {{ $sizeCss }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-bq-wrap {
        max-width: 820px;
        margin: 0 auto;
        position: relative;
        text-align: {{ $align }};
    }

    #{{ $uid }} .rj-bq-quote {
        font-size: var(--bq-size);
        font-weight: 600;
        color: var(--bq-text);
        line-height: 1.45;
        letter-spacing: -.01em;
        margin: 0 0 18px;
        position: relative;
    }
    #{{ $uid }} .rj-bq-quote em,
    #{{ $uid }} .rj-bq-quote i {
        font-style: italic;
        color: var(--bq-accent);
    }
    #{{ $uid }} .rj-bq-quote strong {
        font-weight: 800;
    }

    #{{ $uid }} .rj-bq-author {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-style: normal;
    }
    #{{ $uid }} .rj-bq-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 16px;
        font-weight: 800;
    }
    #{{ $uid }} .rj-bq-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    #{{ $uid }} .rj-bq-meta {
        display: flex;
        flex-direction: column;
        text-align: left;
    }
    #{{ $uid }} .rj-bq-name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--bq-text);
    }
    #{{ $uid }} .rj-bq-role {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    #{{ $uid }} .rj-bq-mark {
        position: absolute;
        font-family: Georgia, serif;
        font-size: 120px;
        line-height: 1;
        font-weight: 900;
        color: var(--bq-accent);
        opacity: .12;
        pointer-events: none;
        user-select: none;
    }
    #{{ $uid }} .rj-bq-mark.open {
        top: -36px;
        left: -8px;
    }
    #{{ $uid }} .rj-bq-mark.close {
        bottom: -40px;
        right: -8px;
    }

    /* ---------- STYLE: Accent Bar ---------- */
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"] {
        padding-left: 22px;
        border-left: 4px solid var(--bq-accent);
    }
    #{{ $uid }} .rj-bq-wrap[data-style="accent-bar"]::before {
        content: '';
        position: absolute;
        left: -4px;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--bq-accent), var(--bq-accent2));
        border-radius: 4px;
    }

    /* ---------- STYLE: Card ---------- */
    #{{ $uid }} .rj-bq-wrap[data-style="card"] {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 34px 30px;
        box-shadow: 0 20px 40px -24px rgba(15,23,42,.2);
    }

    /* ---------- STYLE: Gradient Box ---------- */
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] {
        background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2));
        color: #fff;
        padding: 38px 34px;
        border-radius: 20px;
        box-shadow: 0 30px 60px -30px color-mix(in srgb, var(--bq-accent) 60%, transparent);
    }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-quote,
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-name {
        color: #fff;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-role {
        color: rgba(255,255,255,.75);
    }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-avatar {
        background: rgba(255,255,255,.2);
        border: 1px solid rgba(255,255,255,.3);
    }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-quote em,
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-quote i {
        color: #fff;
        text-decoration: underline;
        text-decoration-color: rgba(255,255,255,.5);
        text-underline-offset: 4px;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="gradient"] .rj-bq-mark {
        color: #fff;
        opacity: .18;
    }

    /* ---------- STYLE: Giant Quote Marks ---------- */
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] {
        padding: 30px 10px;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.open {
        position: relative;
        top: auto;
        left: auto;
        display: block;
        font-size: 90px;
        line-height: 1;
        margin-bottom: -30px;
        opacity: .9;
        background: linear-gradient(135deg, var(--bq-accent), var(--bq-accent2));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="big-marks"] .rj-bq-mark.close {
        display: none;
    }

    /* ---------- STYLE: Minimal ---------- */
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] {
        padding: 8px 0;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote {
        font-weight: 500;
        font-style: italic;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote::before {
        content: '“ ';
        color: var(--bq-accent);
        font-family: Georgia, serif;
        font-weight: 900;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-quote::after {
        content: ' ”';
        color: var(--bq-accent);
        font-family: Georgia, serif;
        font-weight: 900;
    }
    #{{ $uid }} .rj-bq-wrap[data-style="minimal"] .rj-bq-author::before {
        content: '';
        width: 28px;
        height: 1px;
        background: var(--bq-accent);
        margin-right: 8px;
    }

    /* Center alignment tweaks */
    #{{ $uid }} .rj-bq-wrap[data-align="center"] {
        text-align: center;
    }
    #{{ $uid }} .rj-bq-wrap[data-align="center"] .rj-bq-author {
        justify-content: center;
    }
    #{{ $uid }} .rj-bq-wrap[data-align="center"] .rj-bq-meta {
        text-align: left;
    }

    /* Reveal animation */
    #{{ $uid }} .rj-bq-anim {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity .9s ease, transform .9s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-bq-anim.is-visible {
        opacity: 1;
        transform: none;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-bq-anim {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-bq-wrap {{ $animate ? 'rj-bq-anim' : '' }}" data-style="{{ $style }}" data-align="{{ $align }}" data-anim>
        @if($showMarks && $style !== 'big-marks' && $style !== 'minimal')
            <span class="rj-bq-mark open" aria-hidden="true">“</span>
            <span class="rj-bq-mark close" aria-hidden="true">”</span>
        @endif

        @if($style === 'big-marks' && $showMarks)
            <span class="rj-bq-mark open" aria-hidden="true">“</span>
        @endif

        @if($quote !== '')
            <blockquote class="rj-bq-quote">{!! nl2br(e($quote)) !!}</blockquote>
        @endif

        @if($author !== '')
            <div class="rj-bq-author">
                <div class="rj-bq-avatar">
                    @if($avatar !== '')
                        <img src="{{ $avatar }}" alt="{{ $author }}" loading="lazy">
                    @else
                        {{ mb_strtoupper(mb_substr($author, 0, 1)) }}
                    @endif
                </div>
                <div class="rj-bq-meta">
                    <span class="rj-bq-name">{{ $author }}</span>
                    @if($role !== '')
                        <span class="rj-bq-role">{{ $role }}</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
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
