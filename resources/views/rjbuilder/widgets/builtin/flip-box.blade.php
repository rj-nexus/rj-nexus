@php
    $allowedEffects = [
        'flip-h', 'flip-v', 'flip-diag',
        'slide-up', 'slide-down', 'slide-left', 'slide-right',
        'fade', 'zoom-in', 'zoom-out', 'rotate', 'push-up', 'push-left',
    ];
    $effect = in_array($settings['effect'] ?? 'flip-h', $allowedEffects, true) ? $settings['effect'] : 'flip-h';
    $is3d   = str_starts_with($effect, 'flip');

    $height    = max(200, min(500, (int) ($settings['height'] ?? 320)));
    $radiusCss = ['none' => '0px', 'md' => '12px', 'xl' => '20px', '2xl' => '28px'][(string) ($settings['radius'] ?? 'xl')] ?? '20px';
    $shadowOn  = !empty($settings['shadow'] ?? true);

    $hexOk = function ($v, $d) {
        $v = trim((string) $v);
        return preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $v) ? $v : $d;
    };
    $frontBg  = $hexOk($settings['front_bg'] ?? '', '#ffffff');
    $frontFg  = $hexOk($settings['front_color'] ?? '', '#0f172a');
    $backBg   = $hexOk($settings['back_bg'] ?? '', '#8b5cf6');
    $backFg   = $hexOk($settings['back_color'] ?? '', '#ffffff');

    $frontIcon = trim((string) ($settings['front_icon'] ?? ''));
    $iconUrl   = preg_match('/^[a-z0-9-]+:[a-z0-9-]+$/i', $frontIcon)
        ? 'https://api.iconify.design/' . str_replace(':', '/', $frontIcon) . '.svg?color=' . rawurlencode($frontFg)
        : '';

    $frontTitle = trim((string) ($settings['front_title'] ?? ''));
    $frontText  = trim((string) ($settings['front_text'] ?? ''));
    $backTitle  = trim((string) ($settings['back_title'] ?? ''));
    $backText   = trim((string) ($settings['back_text'] ?? ''));
    $btnLabel   = trim((string) ($settings['btn_label'] ?? ''));
    $btnStyle   = ($settings['btn_style'] ?? 'solid') === 'outline' ? 'is-outline' : 'is-solid';

    $btnUrl = trim((string) ($settings['btn_url'] ?? '#'));
    if ($btnUrl === '' || preg_match('/^\s*(javascript|data|vbscript):/i', $btnUrl)) {
        $btnUrl = '#';
    }
@endphp

<style>
    #{{ $uid }} {
        --fb-front-bg: {{ $frontBg }};
        --fb-front-fg: {{ $frontFg }};
        --fb-back-bg: {{ $backBg }};
        --fb-back-fg: {{ $backFg }};
        box-sizing: border-box;
        width: 100%;
        padding: 24px 12px;
    }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* Card container: no overflow:hidden here, it would flatten the 3D */
    #{{ $uid }} .rj-fb {
        position: relative;
        width: 100%;
        height: {{ $height }}px;
        perspective: 1400px;
        border-radius: {{ $radiusCss }};
        cursor: pointer;
        outline: none;
        -webkit-tap-highlight-color: transparent;
    }
    #{{ $uid }} .rj-fb:focus-visible {
        outline: 3px solid var(--fb-back-bg);
        outline-offset: 4px;
    }

    #{{ $uid }} .rj-fb-inner {
        position: absolute;
        inset: 0;
        transform-style: preserve-3d;
        transition: transform .8s cubic-bezier(.2,.8,.2,1);
    }

    #{{ $uid }} .rj-fb-face {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 32px 28px;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        transition: transform .75s cubic-bezier(.2,.8,.2,1), opacity .5s ease;
        @if($shadowOn)
        box-shadow: 0 20px 44px -22px rgba(15, 23, 42, .4);
        @endif
    }
    #{{ $uid }} .rj-fb-front {
        background: var(--fb-front-bg);
        color: var(--fb-front-fg);
        border: 1px solid rgba(15, 23, 42, .06);
        z-index: 1;
    }
    #{{ $uid }} .rj-fb-back {
        background: linear-gradient(145deg, var(--fb-back-bg), color-mix(in srgb, var(--fb-back-bg) 70%, #000));
        color: var(--fb-back-fg);
        z-index: 2;
        pointer-events: none;
    }
    #{{ $uid }} .rj-fb.is-flipped .rj-fb-back { pointer-events: auto; }

    /* Decorative shapes */
    #{{ $uid }} .rj-fb-deco {
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        pointer-events: none;
    }
    #{{ $uid }} .rj-fb-front .rj-fb-deco {
        top: -80px;
        right: -70px;
        background: radial-gradient(circle, color-mix(in srgb, var(--fb-front-fg) 12%, transparent), transparent 70%);
    }
    #{{ $uid }} .rj-fb-back .rj-fb-deco {
        bottom: -90px;
        left: -60px;
        border: 1.5px solid rgba(255, 255, 255, .22);
        box-shadow: 0 0 0 26px rgba(255, 255, 255, .05), 0 0 0 52px rgba(255, 255, 255, .03);
    }

    #{{ $uid }} .rj-fb-icon {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        margin-bottom: 18px;
        border-radius: 18px;
        background: color-mix(in srgb, var(--fb-front-fg) 8%, transparent);
    }
    #{{ $uid }} .rj-fb-icon img {
        width: 30px;
        height: 30px;
        object-fit: contain;
        display: block;
    }
    #{{ $uid }} .rj-fb-title {
        position: relative;
        margin: 0 0 10px;
        font-size: 21px;
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -.015em;
    }
    #{{ $uid }} .rj-fb-text {
        position: relative;
        margin: 0;
        max-width: 280px;
        font-size: 14px;
        line-height: 1.6;
        opacity: .82;
    }

    /* Front hint: different wording for mouse and touch */
    #{{ $uid }} .rj-fb-hint {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        white-space: nowrap;
        background: color-mix(in srgb, var(--fb-front-fg) 8%, transparent);
        color: var(--fb-front-fg);
        opacity: .75;
    }
    #{{ $uid }} .rj-fb-hint-touch { display: none; }
    @media (hover: none) {
        #{{ $uid }} .rj-fb-hint-hover { display: none; }
        #{{ $uid }} .rj-fb-hint-touch { display: inline; }
    }

    #{{ $uid }} .rj-fb-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 22px;
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s ease, background .25s ease, color .25s ease;
    }
    #{{ $uid }} .rj-fb-btn:active { transform: scale(.97); }
    #{{ $uid }} .rj-fb-btn svg { width: 12px; height: 12px; transition: transform .3s ease; }
    #{{ $uid }} .rj-fb-btn:hover svg { transform: translateX(3px); }
    #{{ $uid }} .rj-fb-btn.is-solid {
        background: #fff;
        color: var(--fb-back-bg);
    }
    #{{ $uid }} .rj-fb-btn.is-solid:hover { background: rgba(255, 255, 255, .9); }
    #{{ $uid }} .rj-fb-btn.is-outline {
        background: transparent;
        color: var(--fb-back-fg);
        border: 1.5px solid var(--fb-back-fg);
    }
    #{{ $uid }} .rj-fb-btn.is-outline:hover {
        background: var(--fb-back-fg);
        color: var(--fb-back-bg);
    }

    /* ---------- 3D FLIPS (rotate the whole inner container) ---------- */
    #{{ $uid }}[data-effect^="flip"] .rj-fb-inner { transition: transform .8s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }}[data-effect^="flip"] .rj-fb-face { backface-visibility: hidden; -webkit-backface-visibility: hidden; }

    #{{ $uid }}[data-effect="flip-h"] .rj-fb-back { transform: rotateY(180deg); }
    #{{ $uid }}[data-effect="flip-h"] .rj-fb.is-flipped .rj-fb-inner { transform: rotateY(180deg); }

    #{{ $uid }}[data-effect="flip-v"] .rj-fb-back { transform: rotateX(180deg); }
    #{{ $uid }}[data-effect="flip-v"] .rj-fb.is-flipped .rj-fb-inner { transform: rotateX(180deg); }

    #{{ $uid }}[data-effect="flip-diag"] .rj-fb-back { transform: rotate3d(1, 1, 0, 180deg); }
    #{{ $uid }}[data-effect="flip-diag"] .rj-fb.is-flipped .rj-fb-inner { transform: rotate3d(1, 1, 0, 180deg); }

    /* ---------- SLIDES (back face slides over the front) ---------- */
    #{{ $uid }}[data-effect="slide-up"] .rj-fb-back { transform: translateY(100%); }
    #{{ $uid }}[data-effect="slide-up"] .rj-fb.is-flipped .rj-fb-back { transform: translateY(0); }

    #{{ $uid }}[data-effect="slide-down"] .rj-fb-back { transform: translateY(-100%); }
    #{{ $uid }}[data-effect="slide-down"] .rj-fb.is-flipped .rj-fb-back { transform: translateY(0); }

    #{{ $uid }}[data-effect="slide-left"] .rj-fb-back { transform: translateX(100%); }
    #{{ $uid }}[data-effect="slide-left"] .rj-fb.is-flipped .rj-fb-back { transform: translateX(0); }

    #{{ $uid }}[data-effect="slide-right"] .rj-fb-back { transform: translateX(-100%); }
    #{{ $uid }}[data-effect="slide-right"] .rj-fb.is-flipped .rj-fb-back { transform: translateX(0); }

    /* ---------- FADE / ZOOM / ROTATE ---------- */
    #{{ $uid }}[data-effect="fade"] .rj-fb-back { opacity: 0; }
    #{{ $uid }}[data-effect="fade"] .rj-fb.is-flipped .rj-fb-back { opacity: 1; }

    #{{ $uid }}[data-effect="zoom-in"] .rj-fb-back { opacity: 0; transform: scale(.6); }
    #{{ $uid }}[data-effect="zoom-in"] .rj-fb.is-flipped .rj-fb-back { opacity: 1; transform: scale(1); }

    #{{ $uid }}[data-effect="zoom-out"] .rj-fb-back { opacity: 0; transform: scale(1.35); }
    #{{ $uid }}[data-effect="zoom-out"] .rj-fb.is-flipped .rj-fb-back { opacity: 1; transform: scale(1); }

    #{{ $uid }}[data-effect="rotate"] .rj-fb-back { opacity: 0; transform: rotate(-20deg) scale(.85); }
    #{{ $uid }}[data-effect="rotate"] .rj-fb.is-flipped .rj-fb-back { opacity: 1; transform: rotate(0) scale(1); }

    /* ---------- PUSH (front is pushed out, back comes in) ---------- */
    #{{ $uid }}[data-effect="push-up"] .rj-fb-back { transform: translateY(100%); }
    #{{ $uid }}[data-effect="push-up"] .rj-fb.is-flipped .rj-fb-back { transform: translateY(0); }
    #{{ $uid }}[data-effect="push-up"] .rj-fb.is-flipped .rj-fb-front { transform: translateY(-100%); }

    #{{ $uid }}[data-effect="push-left"] .rj-fb-back { transform: translateX(100%); }
    #{{ $uid }}[data-effect="push-left"] .rj-fb.is-flipped .rj-fb-back { transform: translateX(0); }
    #{{ $uid }}[data-effect="push-left"] .rj-fb.is-flipped .rj-fb-front { transform: translateX(-100%); }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            transition-duration: .01ms !important;
            animation: none !important;
        }
    }
</style>

<div id="{{ $uid }}" data-effect="{{ $effect }}">
    <div class="rj-fb" tabindex="0" role="button" aria-expanded="false"
         aria-label="{{ $frontTitle !== '' ? $frontTitle : __('Flip card') }}">
        <div class="rj-fb-inner">

            <div class="rj-fb-face rj-fb-front">
                <span class="rj-fb-deco" aria-hidden="true"></span>

                @if($iconUrl !== '')
                    <span class="rj-fb-icon">
                        <img src="{{ $iconUrl }}" alt="" loading="lazy">
                    </span>
                @endif

                @if($frontTitle !== '')
                    <h3 class="rj-fb-title">{{ $frontTitle }}</h3>
                @endif

                @if($frontText !== '')
                    <p class="rj-fb-text">{{ $frontText }}</p>
                @endif

                <span class="rj-fb-hint" aria-hidden="true">
                    <span class="rj-fb-hint-hover">{{ __('Hover to reveal') }}</span>
                    <span class="rj-fb-hint-touch">{{ __('Tap to reveal') }}</span>
                </span>
            </div>

            <div class="rj-fb-face rj-fb-back">
                <span class="rj-fb-deco" aria-hidden="true"></span>

                @if($backTitle !== '')
                    <h3 class="rj-fb-title">{{ $backTitle }}</h3>
                @endif

                @if($backText !== '')
                    <p class="rj-fb-text">{{ $backText }}</p>
                @endif

                @if($btnLabel !== '')
                    <a href="{{ $btnUrl }}" class="rj-fb-btn {{ $btnStyle }}">
                        <span>{{ $btnLabel }}</span>
                        <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var card = root.querySelector('.rj-fb');
    if (!card) return;

    var lastPointer = 'mouse';

    function setFlipped(on) {
        card.classList.toggle('is-flipped', on);
        card.setAttribute('aria-expanded', on ? 'true' : 'false');
    }

    card.addEventListener('pointerdown', function (e) {
        lastPointer = e.pointerType || 'mouse';
    });

    // Mouse: hover reveals the back
    card.addEventListener('pointerenter', function (e) {
        if (e.pointerType === 'mouse') setFlipped(true);
    });
    card.addEventListener('pointerleave', function (e) {
        if (e.pointerType === 'mouse') setFlipped(false);
    });

    // Touch and pen: tap toggles the back
    card.addEventListener('click', function (e) {
        if (e.target.closest('a')) return;
        if (lastPointer !== 'mouse') {
            setFlipped(!card.classList.contains('is-flipped'));
        }
    });

    // Keyboard: Enter / Space toggles, Escape closes
    card.addEventListener('keydown', function (e) {
        if (e.target.closest && e.target.closest('a')) return;
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            setFlipped(!card.classList.contains('is-flipped'));
        } else if (e.key === 'Escape') {
            setFlipped(false);
        }
    });

    // Tapping outside closes the back on touch devices
    document.addEventListener('click', function (e) {
        if (!root.contains(e.target)) setFlipped(false);
    });
})();
</script>
