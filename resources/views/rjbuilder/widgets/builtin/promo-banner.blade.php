@php
    $layout       = $settings['layout'] ?? 'split';
    $badge        = trim((string) ($settings['badge'] ?? ''));
    $title        = trim((string) ($settings['title'] ?? ''));
    $highlight    = trim((string) ($settings['highlight'] ?? ''));
    $desc         = trim((string) ($settings['desc'] ?? ''));
    $btnLabel     = trim((string) ($settings['btn_label'] ?? ''));
    $btnUrl       = $settings['btn_url'] ?? '#';
    $image        = $settings['image'] ?? '';
    $countdown    = $settings['countdown'] ?? false;
    $countdownEnd = trim((string) ($settings['countdown_end'] ?? ''));
    $coupon       = trim((string) ($settings['coupon'] ?? ''));
    $couponHint   = trim((string) ($settings['coupon_hint'] ?? ''));
    $bgStyle      = $settings['bg_style'] ?? 'gradient';
    $bgImage      = $settings['bg_image'] ?? '';
    $accent       = $settings['accent'] ?? '#8b5cf6';
    $accent2      = $settings['accent2'] ?? '#ec4899';
    $radius       = $settings['radius'] ?? 'xl';
    $showShapes   = $settings['show_shapes'] ?? true;
    $animate      = $settings['animate'] ?? true;
    $paddingY     = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '14px', 'xl' => '22px', '2xl' => '32px'];
    $radiusCss = $radiusMap[$radius] ?? '22px';

    $titleHtml = e($title);
    if ($highlight !== '' && $title !== '') {
        $titleHtml = str_replace(
            e($highlight),
            '<span class="rj-pb-hl">' . e($highlight) . '</span>',
            $titleHtml
        );
    }

    $isRibbon = $layout === 'ribbon';
    $isSplit  = $layout === 'split';
    $isDark   = in_array($bgStyle, ['gradient', 'dark', 'image'], true);

    $countdownTs = 0;
    if ($countdownEnd !== '') {
        $ts = strtotime($countdownEnd);
        if ($ts !== false) $countdownTs = $ts * 1000;
    }
@endphp

<style>
    #{{ $uid }} {
        --pb-a: {{ $accent }};
        --pb-b: {{ $accent2 }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-pb-wrap {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        border-radius: {{ $radiusCss }};
        overflow: hidden;
        padding: {{ $isRibbon ? '20px 28px' : '48px 40px' }};
        isolation: isolate;
    }
    @media (max-width: 720px) {
        #{{ $uid }} .rj-pb-wrap { padding: {{ $isRibbon ? '18px 20px' : '36px 22px' }}; }
    }

    #{{ $uid }}[data-bg="gradient"] .rj-pb-wrap {
        background: linear-gradient(125deg, var(--pb-a), var(--pb-b));
        color: #fff;
        box-shadow: 0 30px 60px -30px color-mix(in srgb, var(--pb-a) 55%, transparent);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-wrap {
        background: #fff;
        color: #0f172a;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 48px -24px rgba(15,23,42,.15);
    }
    #{{ $uid }}[data-bg="dark"] .rj-pb-wrap {
        background: #0f172a;
        color: #fff;
        box-shadow: 0 30px 60px -30px rgba(0,0,0,.6);
    }
    #{{ $uid }}[data-bg="image"] .rj-pb-wrap {
        color: #fff;
        background-color: #0f172a;
    }
    @if($bgImage !== '')
    #{{ $uid }}[data-bg="image"] .rj-pb-wrap {
        background-image: linear-gradient(120deg, rgba(15,23,42,.78), rgba(15,23,42,.55)), url('{{ $bgImage }}');
        background-size: cover;
        background-position: center;
    }
    @endif

    /* ---------- SHAPES ---------- */
    #{{ $uid }} .rj-pb-shapes {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
        border-radius: inherit;
    }
    #{{ $uid }} .rj-pb-shape {
        position: absolute;
        border-radius: 50%;
        opacity: .3;
        filter: blur(48px);
        animation: rjPbFloat 14s ease-in-out infinite;
    }
    #{{ $uid }} .rj-pb-shape.s1 {
        width: 280px; height: 280px;
        background: rgba(255,255,255,.35);
        top: -80px; left: -60px;
    }
    #{{ $uid }} .rj-pb-shape.s2 {
        width: 220px; height: 220px;
        background: rgba(255,255,255,.22);
        bottom: -70px; right: -50px;
        animation-delay: -4s;
    }
    #{{ $uid }} .rj-pb-shape.s3 {
        width: 160px; height: 160px;
        background: rgba(255,255,255,.28);
        top: 30%; right: 25%;
        animation-delay: -8s;
    }
    @keyframes rjPbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(25px, -30px) scale(1.08); }
    }

    /* ---------- LAYOUT ---------- */
    #{{ $uid }} .rj-pb-inner {
        position: relative;
        z-index: 1;
    }
    #{{ $uid }} .rj-pb-split {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 40px;
        align-items: center;
    }
    @media (max-width: 860px) {
        #{{ $uid }} .rj-pb-split { grid-template-columns: 1fr; gap: 24px; text-align: center; }
        #{{ $uid }} .rj-pb-split .rj-pb-actions,
        #{{ $uid }} .rj-pb-split .rj-pb-coupon-row { justify-content: center; }
    }
    #{{ $uid }} .rj-pb-centered {
        text-align: center;
        max-width: 760px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-pb-ribbon {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        justify-content: center;
        text-align: center;
    }
    @media (min-width: 860px) {
        #{{ $uid }} .rj-pb-ribbon {
            justify-content: space-between;
            text-align: left;
        }
    }

    /* ---------- BADGE ---------- */
    #{{ $uid }} .rj-pb-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 13px;
        border-radius: 999px;
        background: color-mix(in srgb, var(--pb-a) 12%, transparent);
        color: var(--pb-a);
        border: 1px solid color-mix(in srgb, var(--pb-a) 25%, transparent);
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-badge,
    #{{ $uid }}[data-bg="dark"] .rj-pb-badge,
    #{{ $uid }}[data-bg="image"] .rj-pb-badge {
        background: rgba(255,255,255,.18);
        border-color: rgba(255,255,255,.3);
        color: #fff;
    }
    #{{ $uid }} .rj-pb-badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
        animation: rjPbPulse 1.6s ease-in-out infinite;
    }
    @keyframes rjPbPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%      { opacity: .35; transform: scale(1.5); }
    }

    /* ---------- TITLE ---------- */
    #{{ $uid }} .rj-pb-title {
        font-size: clamp(22px, 3.4vw, 38px);
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1.15;
        margin: 0 0 12px;
    }
    #{{ $uid }} .rj-pb-hl {
        display: inline-block;
        background: linear-gradient(90deg, var(--pb-a), var(--pb-b));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        font-weight: 900;
        padding: 0 .04em;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-hl,
    #{{ $uid }}[data-bg="dark"] .rj-pb-hl,
    #{{ $uid }}[data-bg="image"] .rj-pb-hl {
        background: linear-gradient(90deg, #fff, rgba(255,255,255,.72));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #{{ $uid }} .rj-pb-desc {
        font-size: 14.5px;
        line-height: 1.7;
        margin: 0 0 22px;
        opacity: .85;
        max-width: 560px;
    }
    #{{ $uid }} .rj-pb-centered .rj-pb-desc { margin-left: auto; margin-right: auto; }

    /* ---------- COUNTDOWN ---------- */
    #{{ $uid }} .rj-pb-countdown {
        display: flex;
        gap: 8px;
        margin: 0 0 22px;
    }
    #{{ $uid }} .rj-pb-split .rj-pb-countdown,
    #{{ $uid }} .rj-pb-centered .rj-pb-countdown { justify-content: flex-start; }
    #{{ $uid }} .rj-pb-centered .rj-pb-countdown { justify-content: center; }
    @media (max-width: 860px) {
        #{{ $uid }} .rj-pb-split .rj-pb-countdown { justify-content: center; }
    }
    #{{ $uid }} .rj-pb-cd-item {
        min-width: 62px;
        padding: 10px 8px 8px;
        border-radius: 10px;
        background: rgba(15,23,42,.06);
        border: 1px solid rgba(15,23,42,.08);
        text-align: center;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-cd-item,
    #{{ $uid }}[data-bg="dark"] .rj-pb-cd-item,
    #{{ $uid }}[data-bg="image"] .rj-pb-cd-item {
        background: rgba(255,255,255,.16);
        border-color: rgba(255,255,255,.24);
        backdrop-filter: blur(6px);
    }
    #{{ $uid }} .rj-pb-cd-num {
        font-size: 22px;
        font-weight: 800;
        font-variant-numeric: tabular-nums;
        line-height: 1;
        display: block;
    }
    #{{ $uid }} .rj-pb-cd-lbl {
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        opacity: .7;
        margin-top: 4px;
        display: block;
    }

    /* ---------- COUPON ---------- */
    #{{ $uid }} .rj-pb-coupon-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin: 0 0 20px;
    }
    #{{ $uid }} .rj-pb-coupon {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        border: 2px dashed currentColor;
        background: transparent;
        font-family: ui-monospace, 'SF Mono', Menlo, Consolas, monospace;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: .1em;
        cursor: pointer;
        transition: transform .2s ease, background .25s ease;
        color: inherit;
    }
    #{{ $uid }} .rj-pb-coupon:hover {
        transform: translateY(-1px);
        background: rgba(255,255,255,.1);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-coupon:hover {
        background: color-mix(in srgb, var(--pb-a) 8%, transparent);
    }
    #{{ $uid }} .rj-pb-coupon-icon {
        width: 16px;
        height: 16px;
        opacity: .7;
    }
    #{{ $uid }} .rj-pb-coupon-hint {
        font-size: 11.5px;
        opacity: .7;
        font-weight: 500;
    }
    #{{ $uid }} .rj-pb-copied {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 700;
        color: #10b981;
        opacity: 0;
        transition: opacity .25s ease;
    }
    #{{ $uid }} .rj-pb-copied.is-on { opacity: 1; }

    /* ---------- ACTIONS ---------- */
    #{{ $uid }} .rj-pb-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    #{{ $uid }} .rj-pb-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 26px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: 1.5px solid transparent;
        transition: transform .2s ease, background .25s ease, box-shadow .25s ease;
    }
    #{{ $uid }} .rj-pb-btn:hover { transform: translateY(-2px); }
    #{{ $uid }} .rj-pb-btn:active { transform: scale(.98); }
    #{{ $uid }} .rj-pb-btn {
        background: #0f172a;
        color: #fff;
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-btn {
        background: var(--pb-a);
        color: #fff;
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-btn,
    #{{ $uid }}[data-bg="dark"] .rj-pb-btn,
    #{{ $uid }}[data-bg="image"] .rj-pb-btn {
        background: #fff;
        color: #0f172a;
        box-shadow: 0 14px 28px -12px rgba(0,0,0,.35);
    }
    #{{ $uid }} .rj-pb-btn:hover {
        background: color-mix(in srgb, #0f172a 88%, #fff);
    }
    #{{ $uid }}[data-bg="solid"] .rj-pb-btn:hover {
        background: color-mix(in srgb, var(--pb-a) 88%, #000);
    }
    #{{ $uid }}[data-bg="gradient"] .rj-pb-btn:hover,
    #{{ $uid }}[data-bg="dark"] .rj-pb-btn:hover,
    #{{ $uid }}[data-bg="image"] .rj-pb-btn:hover {
        background: rgba(255,255,255,.9);
    }

    /* ---------- IMAGE ---------- */
    #{{ $uid }} .rj-pb-media {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        box-shadow: 0 24px 48px -20px rgba(0,0,0,.4);
        animation: rjPbFloaty 6s ease-in-out infinite;
    }
    @keyframes rjPbFloaty {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }
    #{{ $uid }} .rj-pb-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ---------- RIBBON ---------- */
    #{{ $uid }} .rj-pb-ribbon-text {
        font-size: clamp(16px, 2vw, 22px);
        font-weight: 800;
        letter-spacing: -.01em;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    #{{ $uid }} .rj-pb-ribbon-coupon {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 8px;
        border: 2px dashed currentColor;
        font-family: ui-monospace, 'SF Mono', Menlo, Consolas, monospace;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .08em;
        cursor: pointer;
    }
    #{{ $uid }} .rj-pb-ribbon .rj-pb-actions { gap: 10px; }
    #{{ $uid }} .rj-pb-ribbon .rj-pb-btn { padding: 10px 20px; font-size: 13px; }

    /* ---------- REVEAL ---------- */
    #{{ $uid }} .rj-pb-anim {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity .85s ease, transform .85s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-pb-anim.is-visible {
        opacity: 1;
        transform: none;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rj-pb-shape,
        #{{ $uid }} .rj-pb-media,
        #{{ $uid }} .rj-pb-badge::before {
            animation: none !important;
        }
        #{{ $uid }} .rj-pb-anim {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bgStyle }}" data-layout="{{ $layout }}">
    <div class="rj-pb-wrap">
        @if($showShapes)
            <div class="rj-pb-shapes" aria-hidden="true">
                <span class="rj-pb-shape s1"></span>
                <span class="rj-pb-shape s2"></span>
                <span class="rj-pb-shape s3"></span>
            </div>
        @endif

        <div class="rj-pb-inner {{ $animate ? 'rj-pb-anim' : '' }}" data-anim>
            @if($isRibbon)
                <div class="rj-pb-ribbon">
                    <div>
                        @if($badge !== '')
                            <span class="rj-pb-badge">{{ $badge }}</span>
                        @endif
                        @if($title !== '')
                            <p class="rj-pb-ribbon-text">
                                <span>{!! $titleHtml !!}</span>
                                @if($coupon !== '')
                                    <button type="button" class="rj-pb-ribbon-coupon" data-coupon="{{ $coupon }}">
                                        <svg class="rj-pb-coupon-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <span data-coupon-text>{{ $coupon }}</span>
                                    </button>
                                @endif
                            </p>
                        @endif
                    </div>
                    @if($btnLabel !== '')
                        <div class="rj-pb-actions">
                            <a href="{{ $btnUrl }}" class="rj-pb-btn">
                                <span>{{ $btnLabel }}</span>
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            @elseif($isSplit)
                <div class="rj-pb-split">
                    <div>
                        @if($badge !== '')
                            <span class="rj-pb-badge">{{ $badge }}</span>
                        @endif
                        @if($title !== '')
                            <h2 class="rj-pb-title">{!! $titleHtml !!}</h2>
                        @endif
                        @if($desc !== '')
                            <p class="rj-pb-desc">{{ $desc }}</p>
                        @endif

                        @if($countdown && $countdownTs > 0)
                            <div class="rj-pb-countdown" data-countdown="{{ $countdownTs }}">
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-d>00</span><span class="rj-pb-cd-lbl">{{ __('Days') }}</span></div>
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-h>00</span><span class="rj-pb-cd-lbl">{{ __('Hours') }}</span></div>
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-m>00</span><span class="rj-pb-cd-lbl">{{ __('Mins') }}</span></div>
                                <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-s>00</span><span class="rj-pb-cd-lbl">{{ __('Secs') }}</span></div>
                            </div>
                        @endif

                        @if($coupon !== '')
                            <div class="rj-pb-coupon-row">
                                <button type="button" class="rj-pb-coupon" data-coupon="{{ $coupon }}">
                                    <svg class="rj-pb-coupon-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                    <span data-coupon-text>{{ $coupon }}</span>
                                </button>
                                @if($couponHint !== '')
                                    <span class="rj-pb-coupon-hint">{{ $couponHint }}</span>
                                @endif
                                <span class="rj-pb-copied" data-copied>
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ __('Copied') }}</span>
                                </span>
                            </div>
                        @endif

                        @if($btnLabel !== '')
                            <div class="rj-pb-actions">
                                <a href="{{ $btnUrl }}" class="rj-pb-btn">
                                    <span>{{ $btnLabel }}</span>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($image !== '')
                        <div class="rj-pb-media">
                            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
                        </div>
                    @endif
                </div>
            @else
                <div class="rj-pb-centered">
                    @if($badge !== '')
                        <span class="rj-pb-badge">{{ $badge }}</span>
                    @endif
                    @if($title !== '')
                        <h2 class="rj-pb-title">{!! $titleHtml !!}</h2>
                    @endif
                    @if($desc !== '')
                        <p class="rj-pb-desc">{{ $desc }}</p>
                    @endif

                    @if($countdown && $countdownTs > 0)
                        <div class="rj-pb-countdown" data-countdown="{{ $countdownTs }}">
                            <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-d>00</span><span class="rj-pb-cd-lbl">{{ __('Days') }}</span></div>
                            <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-h>00</span><span class="rj-pb-cd-lbl">{{ __('Hours') }}</span></div>
                            <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-m>00</span><span class="rj-pb-cd-lbl">{{ __('Mins') }}</span></div>
                            <div class="rj-pb-cd-item"><span class="rj-pb-cd-num" data-s>00</span><span class="rj-pb-cd-lbl">{{ __('Secs') }}</span></div>
                        </div>
                    @endif

                    @if($coupon !== '')
                        <div class="rj-pb-coupon-row" style="justify-content:center;">
                            <button type="button" class="rj-pb-coupon" data-coupon="{{ $coupon }}">
                                <svg class="rj-pb-coupon-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span data-coupon-text>{{ $coupon }}</span>
                            </button>
                            @if($couponHint !== '')
                                <span class="rj-pb-coupon-hint">{{ $couponHint }}</span>
                            @endif
                            <span class="rj-pb-copied" data-copied>
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span>{{ __('Copied') }}</span>
                            </span>
                        </div>
                    @endif

                    @if($btnLabel !== '')
                        <div class="rj-pb-actions" style="justify-content:center;">
                            <a href="{{ $btnUrl }}" class="rj-pb-btn">
                                <span>{{ $btnLabel }}</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var cdEl = root.querySelector('[data-countdown]');
    if (cdEl) {
        var endTs = parseInt(cdEl.getAttribute('data-countdown'), 10);
        var dEl = cdEl.querySelector('[data-d]');
        var hEl = cdEl.querySelector('[data-h]');
        var mEl = cdEl.querySelector('[data-m]');
        var sEl = cdEl.querySelector('[data-s]');

        function pad(n) { return n < 10 ? '0' + n : '' + n; }

        function tick() {
            var diff = Math.max(0, endTs - Date.now());
            var sec = Math.floor(diff / 1000);
            var d = Math.floor(sec / 86400);
            var h = Math.floor((sec % 86400) / 3600);
            var m = Math.floor((sec % 3600) / 60);
            var s = sec % 60;
            if (dEl) dEl.textContent = pad(d);
            if (hEl) hEl.textContent = pad(h);
            if (mEl) mEl.textContent = pad(m);
            if (sEl) sEl.textContent = pad(s);
        }
        tick();
        setInterval(tick, 1000);
    }

    var couponBtns = root.querySelectorAll('[data-coupon]');
    var copied = root.querySelector('[data-copied]');

    couponBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var code = btn.getAttribute('data-coupon') || '';
            if (!code) return;

            var done = function () {
                if (copied) {
                    copied.classList.add('is-on');
                    setTimeout(function () { copied.classList.remove('is-on'); }, 1800);
                }
                var orig = btn.getAttribute('data-orig') || '';
                if (!orig) {
                    btn.setAttribute('data-orig', btn.innerHTML);
                }
                var txtEl = btn.querySelector('[data-coupon-text]');
                if (txtEl) {
                    var prev = txtEl.textContent;
                    txtEl.textContent = @js(__('Copied!'));
                    setTimeout(function () { txtEl.textContent = prev; }, 1600);
                }
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(code).then(done).catch(function () {});
            } else {
                var ta = document.createElement('textarea');
                ta.value = code;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
        });
    });

    var anim = root.querySelector('[data-anim]');
    if (anim) {
        if (typeof IntersectionObserver === 'undefined') {
            anim.classList.add('is-visible');
        } else {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        anim.classList.add('is-visible');
                        io.unobserve(anim);
                    }
                });
            }, { threshold: 0.15 });
            io.observe(anim);
        }
    }
})();
</script>
