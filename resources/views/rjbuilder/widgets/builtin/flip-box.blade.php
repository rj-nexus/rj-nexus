@php
    $effect     = $settings['effect'] ?? 'flip-h';
    $height     = (int) ($settings['height'] ?? 320);
    $radius     = $settings['radius'] ?? 'xl';
    $shadow     = $settings['shadow'] ?? true;
    $frontBg    = $settings['front_bg'] ?? '#ffffff';
    $frontColor = $settings['front_color'] ?? '#0f172a';
    $backBg     = $settings['back_bg'] ?? '#8b5cf6';
    $backColor  = $settings['back_color'] ?? '#ffffff';
    $frontIcon  = $settings['front_icon'] ?? '';
    $frontTitle = $settings['front_title'] ?? '';
    $frontText  = $settings['front_text'] ?? '';
    $backTitle  = $settings['back_title'] ?? '';
    $backText   = $settings['back_text'] ?? '';
    $btnLabel   = $settings['btn_label'] ?? '';
    $btnUrl     = $settings['btn_url'] ?? '#';
    $btnStyle   = $settings['btn_style'] ?? 'solid';

    $radiusMap = ['none' => '0px', 'md' => '12px', 'xl' => '20px', '2xl' => '28px'];
    $radiusCss = $radiusMap[$radius] ?? '20px';

    $iconUrl = '';
    if ($frontIcon !== '') {
        $iconUrl = 'https://api.iconify.design/' . str_replace(':', '/', $frontIcon) . '.svg?color=%23' . ltrim($frontColor, '#');
    }

    $is3d = in_array($effect, ['flip-h', 'flip-v', 'flip-diag'], true);
@endphp

@once
<style>
    @keyframes rjFbSpin { to { transform: rotate(360deg); } }
</style>
@endonce

<style>
    #{{ $uid }} {
        --fb-front-bg: {{ $frontBg }};
        --fb-front-fg: {{ $frontColor }};
        --fb-back-bg: {{ $backBg }};
        --fb-back-fg: {{ $backColor }};
        width: 100%;
        padding: 24px 12px;
    }
    #{{ $uid }} .rj-fb {
        position: relative;
        width: 100%;
        height: {{ $height }}px;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        @if($shadow)
        box-shadow: 0 18px 40px -20px rgba(15,23,42,.35);
        @endif
        @if($is3d)
        perspective: 1200px;
        @endif
    }

    #{{ $uid }} .rj-fb-face {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 32px 26px;
        border-radius: {{ $radiusCss }};
        box-sizing: border-box;
    }

    #{{ $uid }} .rj-fb-front {
        background: var(--fb-front-bg);
        color: var(--fb-front-fg);
        z-index: 2;
    }
    #{{ $uid }} .rj-fb-back {
        background: var(--fb-back-bg);
        color: var(--fb-back-fg);
        z-index: 1;
    }

    #{{ $uid }} .rj-fb-icon {
        width: 56px;
        height: 56px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: color-mix(in srgb, var(--fb-front-fg) 8%, transparent);
    }
    #{{ $uid }} .rj-fb-icon img {
        width: 30px;
        height: 30px;
        object-fit: contain;
        display: block;
    }
    #{{ $uid }} .rj-fb-title {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -.01em;
        margin: 0 0 8px;
        line-height: 1.3;
    }
    #{{ $uid }} .rj-fb-text {
        font-size: 13.5px;
        line-height: 1.6;
        margin: 0;
        opacity: .8;
        max-width: 280px;
    }

    #{{ $uid }} .rj-fb-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 20px;
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .15s ease, background .25s ease, color .25s ease;
    }
    #{{ $uid }} .rj-fb-btn:active { transform: scale(.97); }
    #{{ $uid }} .rj-fb-btn.is-solid {
        background: #fff;
        color: var(--fb-back-bg);
    }
    #{{ $uid }} .rj-fb-btn.is-solid:hover {
        background: rgba(255,255,255,.9);
    }
    #{{ $uid }} .rj-fb-btn.is-outline {
        background: transparent;
        color: var(--fb-back-fg);
        border: 1.5px solid var(--fb-back-fg);
    }
    #{{ $uid }} .rj-fb-btn.is-outline:hover {
        background: var(--fb-back-fg);
        color: var(--fb-back-bg);
    }

    /* -------- 3D FLIP HORIZONTAL -------- */
    #{{ $uid }}[data-effect="flip-h"] .rj-fb { transform-style: preserve-3d; transition: transform .8s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }}[data-effect="flip-h"] .rj-fb:hover { transform: rotateY(180deg); }
    #{{ $uid }}[data-effect="flip-h"] .rj-fb-front { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
    #{{ $uid }}[data-effect="flip-h"] .rj-fb-back  { backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(180deg); }

    /* -------- 3D FLIP VERTICAL -------- */
    #{{ $uid }}[data-effect="flip-v"] .rj-fb { transform-style: preserve-3d; transition: transform .8s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }}[data-effect="flip-v"] .rj-fb:hover { transform: rotateX(180deg); }
    #{{ $uid }}[data-effect="flip-v"] .rj-fb-front { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
    #{{ $uid }}[data-effect="flip-v"] .rj-fb-back  { backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateX(180deg); }

    /* -------- 3D FLIP DIAGONAL -------- */
    #{{ $uid }}[data-effect="flip-diag"] .rj-fb { transform-style: preserve-3d; transition: transform .9s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }}[data-effect="flip-diag"] .rj-fb:hover { transform: rotate3d(1, 1, 0, 180deg); }
    #{{ $uid }}[data-effect="flip-diag"] .rj-fb-front { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
    #{{ $uid }}[data-effect="flip-diag"] .rj-fb-back  { backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotate3d(1, 1, 0, 180deg); }

    /* -------- SLIDE UP -------- */
    #{{ $uid }}[data-effect="slide-up"] .rj-fb-back {
        transform: translateY(100%);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="slide-up"] .rj-fb:hover .rj-fb-back { transform: translateY(0); }

    /* -------- SLIDE DOWN -------- */
    #{{ $uid }}[data-effect="slide-down"] .rj-fb-back {
        transform: translateY(-100%);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="slide-down"] .rj-fb:hover .rj-fb-back { transform: translateY(0); }

    /* -------- SLIDE LEFT -------- */
    #{{ $uid }}[data-effect="slide-left"] .rj-fb-back {
        transform: translateX(100%);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="slide-left"] .rj-fb:hover .rj-fb-back { transform: translateX(0); }

    /* -------- SLIDE RIGHT -------- */
    #{{ $uid }}[data-effect="slide-right"] .rj-fb-back {
        transform: translateX(-100%);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="slide-right"] .rj-fb:hover .rj-fb-back { transform: translateX(0); }

    /* -------- FADE -------- */
    #{{ $uid }}[data-effect="fade"] .rj-fb-back {
        opacity: 0;
        transition: opacity .5s ease;
    }
    #{{ $uid }}[data-effect="fade"] .rj-fb:hover .rj-fb-back { opacity: 1; }

    /* -------- ZOOM IN -------- */
    #{{ $uid }}[data-effect="zoom-in"] .rj-fb-back {
        opacity: 0;
        transform: scale(.7);
        transition: opacity .5s ease, transform .6s cubic-bezier(.34,1.3,.64,1);
    }
    #{{ $uid }}[data-effect="zoom-in"] .rj-fb:hover .rj-fb-back { opacity: 1; transform: scale(1); }

    /* -------- ZOOM OUT -------- */
    #{{ $uid }}[data-effect="zoom-out"] .rj-fb-back {
        opacity: 0;
        transform: scale(1.3);
        transition: opacity .5s ease, transform .6s cubic-bezier(.34,1.3,.64,1);
    }
    #{{ $uid }}[data-effect="zoom-out"] .rj-fb:hover .rj-fb-back { opacity: 1; transform: scale(1); }

    /* -------- ROTATE -------- */
    #{{ $uid }}[data-effect="rotate"] .rj-fb-back {
        opacity: 0;
        transform: rotate(-18deg) scale(.85);
        transition: opacity .5s ease, transform .6s cubic-bezier(.34,1.3,.64,1);
    }
    #{{ $uid }}[data-effect="rotate"] .rj-fb:hover .rj-fb-back { opacity: 1; transform: rotate(0) scale(1); }

    /* -------- PUSH UP -------- */
    #{{ $uid }}[data-effect="push-up"] .rj-fb-front {
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="push-up"] .rj-fb-back {
        transform: translateY(100%);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="push-up"] .rj-fb:hover .rj-fb-front { transform: translateY(-100%); }
    #{{ $uid }}[data-effect="push-up"] .rj-fb:hover .rj-fb-back  { transform: translateY(0); }

    /* -------- PUSH LEFT -------- */
    #{{ $uid }}[data-effect="push-left"] .rj-fb-front {
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="push-left"] .rj-fb-back {
        transform: translateX(100%);
        transition: transform .6s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }}[data-effect="push-left"] .rj-fb:hover .rj-fb-front { transform: translateX(-100%); }
    #{{ $uid }}[data-effect="push-left"] .rj-fb:hover .rj-fb-back  { transform: translateX(0); }

    /* -------- TOUCH: tap to flip on mobile for 3D -------- */
    @media (hover: none) {
        #{{ $uid }}[data-effect="flip-h"] .rj-fb.is-tapped { transform: rotateY(180deg); }
        #{{ $uid }}[data-effect="flip-v"] .rj-fb.is-tapped { transform: rotateX(180deg); }
        #{{ $uid }}[data-effect="flip-diag"] .rj-fb.is-tapped { transform: rotate3d(1, 1, 0, 180deg); }
        #{{ $uid }}[data-effect="slide-up"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="slide-down"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="slide-left"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="slide-right"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="push-up"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="push-left"] .rj-fb.is-tapped .rj-fb-back { transform: none; }
        #{{ $uid }}[data-effect="push-up"] .rj-fb.is-tapped .rj-fb-front { transform: translateY(-100%); }
        #{{ $uid }}[data-effect="push-left"] .rj-fb.is-tapped .rj-fb-front { transform: translateX(-100%); }
        #{{ $uid }}[data-effect="fade"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="zoom-in"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="zoom-out"] .rj-fb.is-tapped .rj-fb-back,
        #{{ $uid }}[data-effect="rotate"] .rj-fb.is-tapped .rj-fb-back { opacity: 1; transform: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition-duration: .01ms !important;
        }
    }
</style>

<div id="{{ $uid }}" data-effect="{{ $effect }}">
    <div class="rj-fb" tabindex="0">
        <div class="rj-fb-face rj-fb-front">
            @if($iconUrl !== '')
                <div class="rj-fb-icon">
                    <img src="{{ $iconUrl }}" alt="" loading="lazy">
                </div>
            @endif
            @if($frontTitle !== '')
                <h3 class="rj-fb-title">{{ $frontTitle }}</h3>
            @endif
            @if($frontText !== '')
                <p class="rj-fb-text">{{ $frontText }}</p>
            @endif
        </div>

        <div class="rj-fb-face rj-fb-back">
            @if($backTitle !== '')
                <h3 class="rj-fb-title">{{ $backTitle }}</h3>
            @endif
            @if($backText !== '')
                <p class="rj-fb-text">{{ $backText }}</p>
            @endif
            @if($btnLabel !== '')
                <a href="{{ $btnUrl }}" class="rj-fb-btn {{ $btnStyle === 'outline' ? 'is-outline' : 'is-solid' }}">
                    <span>{{ $btnLabel }}</span>
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var box = root.querySelector('.rj-fb');
    if (!box) return;

    box.addEventListener('click', function (e) {
        if (e.target.closest('a')) return;
        if (window.matchMedia('(hover: none)').matches) {
            box.classList.toggle('is-tapped');
        }
    });

    box.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            if (e.target.closest('a')) return;
            e.preventDefault();
            box.classList.toggle('is-tapped');
        }
    });
})();
</script>
