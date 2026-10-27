@php
    $subtitle     = $settings['subtitle'] ?? '';
    $title        = $settings['title'] ?? __('How it works');
    $desc         = $settings['desc'] ?? '';
    $layout       = $settings['layout'] ?? 'horizontal';
    $numberStyle  = $settings['number_style'] ?? 'circle';
    $connector    = $settings['connector'] ?? 'line';
    $accent       = $settings['accent'] ?? '#8b5cf6';
    $accent2      = $settings['accent2'] ?? '#ec4899';
    $textColor    = $settings['text_color'] ?? '#0f172a';
    $mutedColor   = $settings['muted_color'] ?? '#64748b';
    $align        = $settings['align'] ?? 'center';
    $animate      = $settings['animate'] ?? true;
    $paddingY     = (int) ($settings['padding_y'] ?? 60);

    $steps = [];
    if (!empty($settings['steps']) && is_array($settings['steps'])) {
        foreach ($settings['steps'] as $i => $row) {
            if (!is_array($row)) continue;
            if (empty($row['title']) && empty($row['desc'])) continue;
            $steps[] = [
                'n'     => $i + 1,
                'title' => $row['title'] ?? '',
                'desc'  => $row['desc'] ?? '',
                'icon'  => $row['icon'] ?? '',
                'image' => $row['image'] ?? '',
                'link'  => $row['link'] ?? '',
            ];
        }
    }

    $iconUrl = function (string $name): string {
        if ($name === '') return '';
        return 'https://api.iconify.design/' . str_replace(':', '/', $name) . '.svg?color=%23ffffff';
    };
@endphp

<style>
    #{{ $uid }} {
        --st-accent: {{ $accent }};
        --st-accent2: {{ $accent2 }};
        --st-text: {{ $textColor }};
        --st-muted: {{ $mutedColor }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-st-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-st-head {
        text-align: center;
        margin-bottom: 48px;
        max-width: 680px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-st-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--st-accent);
        margin: 0 0 10px;
    }
    #{{ $uid }} .rj-st-title {
        font-size: 30px;
        font-weight: 800;
        color: var(--st-text);
        letter-spacing: -.02em;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-st-title { font-size: 42px; }
    }
    #{{ $uid }} .rj-st-desc {
        font-size: 14px;
        color: var(--st-muted);
        line-height: 1.7;
        margin: 12px 0 0;
    }

    /* ============================================
       NUMBER / ICON BADGE
       ============================================ */
    #{{ $uid }} .rj-st-num {
        position: relative;
        width: 64px;
        height: 64px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 800;
        z-index: 2;
    }
    #{{ $uid }} .rj-st-num-inner {
        width: 100%;
        height: 100%;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: transform .35s ease;
    }
    #{{ $uid }} .rj-st-num img {
        width: 55%;
        height: 55%;
        object-fit: contain;
        display: block;
    }
    #{{ $uid }} .rj-st-num .rj-st-num-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: inherit;
    }

    #{{ $uid }}[data-num="circle"] .rj-st-num-inner {
        background: linear-gradient(135deg, var(--st-accent), var(--st-accent2));
        color: #fff;
        box-shadow: 0 8px 20px -8px color-mix(in srgb, var(--st-accent) 60%, transparent);
    }
    #{{ $uid }}[data-num="outline"] .rj-st-num-inner {
        background: #fff;
        color: var(--st-accent);
        border: 2.5px solid var(--st-accent);
    }
    #{{ $uid }}[data-num="square"] .rj-st-num-inner {
        border-radius: 16px;
        background: linear-gradient(135deg, var(--st-accent), var(--st-accent2));
        color: #fff;
        box-shadow: 0 8px 20px -8px color-mix(in srgb, var(--st-accent) 60%, transparent);
    }
    #{{ $uid }}[data-num="gradient"] .rj-st-num-inner {
        background: linear-gradient(135deg, var(--st-accent), var(--st-accent2));
        color: #fff;
        box-shadow: 0 8px 20px -8px color-mix(in srgb, var(--st-accent) 60%, transparent);
        animation: rjStGlow 3s ease-in-out infinite;
    }
    @keyframes rjStGlow {
        0%, 100% { box-shadow: 0 8px 20px -8px color-mix(in srgb, var(--st-accent) 60%, transparent); }
        50%      { box-shadow: 0 12px 32px -6px color-mix(in srgb, var(--st-accent) 80%, transparent); }
    }
    #{{ $uid }}[data-num="icon"] .rj-st-num-inner {
        background: transparent;
        box-shadow: none;
    }
    #{{ $uid }}[data-num="icon"] .rj-st-num-inner img {
        width: 64px;
        height: 64px;
        object-fit: contain;
    }
    #{{ $uid }}[data-num="icon"] .rj-st-num-inner:has(img) {
        background: transparent;
    }

    /* ============================================
       STEP ITEM
       ============================================ */
    #{{ $uid }} .rj-st-item {
        position: relative;
        flex: 1;
    }
    #{{ $uid }} .rj-st-step-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--st-text);
        margin: 0 0 6px;
        line-height: 1.3;
        letter-spacing: -.01em;
    }
    #{{ $uid }} .rj-st-step-desc {
        font-size: 13px;
        color: var(--st-muted);
        line-height: 1.6;
        margin: 0;
    }
    #{{ $uid }} .rj-st-step-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 700;
        color: var(--st-accent);
        text-decoration: none;
        margin-top: 10px;
    }
    #{{ $uid }} .rj-st-step-link:hover { text-decoration: underline; }

    #{{ $uid }} .rj-st-item:hover .rj-st-num-inner {
        transform: scale(1.06);
    }

    /* ============================================
       HORIZONTAL
       ============================================ */
    #{{ $uid }} .rj-st-h {
        display: flex;
        gap: 0;
        align-items: flex-start;
    }
    #{{ $uid }} .rj-st-h .rj-st-item {
        text-align: {{ $align }};
        display: flex;
        flex-direction: column;
        align-items: {{ $align === 'left' ? 'flex-start' : 'center' }};
        padding: 0 8px;
    }
    #{{ $uid }} .rj-st-h .rj-st-num {
        margin-bottom: 18px;
    }
    #{{ $uid }} .rj-st-h .rj-st-body {
        text-align: {{ $align }};
    }

    #{{ $uid }} .rj-st-h .rj-st-connector {
        position: relative;
        flex: 0 0 auto;
        height: 2px;
        width: 60px;
        margin-top: 31px;
        align-self: flex-start;
    }
    #{{ $uid }} .rj-st-h .rj-st-connector::before {
        content: '';
        position: absolute;
        inset: 0;
        top: 50%;
        transform: translateY(-50%);
        border-top: 2px solid;
        border-color: color-mix(in srgb, var(--st-accent) 35%, transparent);
    }
    #{{ $uid }}[data-connector="dashed"] .rj-st-connector::before {
        border-top-style: dashed;
    }
    #{{ $uid }}[data-connector="dotted"] .rj-st-connector::before {
        border-top-style: dotted;
        border-top-width: 3px;
    }
    #{{ $uid }}[data-connector="arrow"] .rj-st-connector::after {
        content: '';
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 8px solid color-mix(in srgb, var(--st-accent) 45%, transparent);
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
    }
    #{{ $uid }}[data-connector="none"] .rj-st-connector::before {
        display: none;
    }

    @media (max-width: 760px) {
        #{{ $uid }} .rj-st-h {
            flex-direction: column;
            gap: 12px;
            align-items: stretch;
        }
        #{{ $uid }} .rj-st-h .rj-st-item {
            flex-direction: row;
            text-align: left;
            align-items: flex-start;
            gap: 16px;
            padding: 0;
        }
        #{{ $uid }} .rj-st-h .rj-st-num {
            margin-bottom: 0;
        }
        #{{ $uid }} .rj-st-h .rj-st-body {
            text-align: left;
            padding-top: 6px;
        }
        #{{ $uid }} .rj-st-h .rj-st-connector {
            position: absolute;
            left: 31px;
            top: 64px;
            bottom: -12px;
            width: 2px;
            height: auto;
            margin: 0;
        }
        #{{ $uid }} .rj-st-h .rj-st-connector::before {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            border-top: 0;
            border-left: 2px solid color-mix(in srgb, var(--st-accent) 35%, transparent);
            width: 0;
            height: 100%;
            right: auto;
            bottom: 0;
        }
        #{{ $uid }}[data-connector="dashed"] .rj-st-h .rj-st-connector::before {
            border-left-style: dashed;
            border-top-style: none;
        }
        #{{ $uid }}[data-connector="dotted"] .rj-st-h .rj-st-connector::before {
            border-left-style: dotted;
            border-top-style: none;
            border-left-width: 3px;
        }
        #{{ $uid }}[data-connector="arrow"] .rj-st-h .rj-st-connector::after {
            display: none;
        }
    }

    /* ============================================
       VERTICAL
       ============================================ */
    #{{ $uid }} .rj-st-v {
        display: flex;
        flex-direction: column;
        gap: 0;
        max-width: 640px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-st-v .rj-st-item {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        padding-bottom: 40px;
    }
    #{{ $uid }} .rj-st-v .rj-st-item:last-child {
        padding-bottom: 0;
    }
    #{{ $uid }} .rj-st-v .rj-st-body {
        padding-top: 6px;
        flex: 1;
        min-width: 0;
    }
    #{{ $uid }} .rj-st-v .rj-st-connector {
        position: absolute;
        left: 31px;
        top: 64px;
        bottom: 0;
        width: 2px;
    }
    #{{ $uid }} .rj-st-v .rj-st-connector::before {
        content: '';
        position: absolute;
        inset: 0;
        border-left: 2px solid color-mix(in srgb, var(--st-accent) 35%, transparent);
    }
    #{{ $uid }}[data-connector="dashed"] .rj-st-v .rj-st-connector::before {
        border-left-style: dashed;
    }
    #{{ $uid }}[data-connector="dotted"] .rj-st-v .rj-st-connector::before {
        border-left-style: dotted;
        border-left-width: 3px;
    }
    #{{ $uid }}[data-connector="arrow"] .rj-st-v .rj-st-connector::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-top: 8px solid color-mix(in srgb, var(--st-accent) 45%, transparent);
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
    }
    #{{ $uid }}[data-connector="none"] .rj-st-v .rj-st-connector::before {
        display: none;
    }

    /* ============================================
       ALTERNATING
       ============================================ */
    #{{ $uid }} .rj-st-a {
        display: flex;
        flex-direction: column;
        gap: 0;
        position: relative;
    }
    #{{ $uid }} .rj-st-a::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        background: color-mix(in srgb, var(--st-accent) 25%, transparent);
        z-index: 0;
    }
    #{{ $uid }}[data-connector="dashed"] .rj-st-a::before {
        background: repeating-linear-gradient(180deg, color-mix(in srgb, var(--st-accent) 35%, transparent) 0 8px, transparent 8px 16px);
    }
    #{{ $uid }}[data-connector="dotted"] .rj-st-a::before {
        background: repeating-linear-gradient(180deg, color-mix(in srgb, var(--st-accent) 35%, transparent) 0 3px, transparent 3px 9px);
    }
    #{{ $uid }}[data-connector="none"] .rj-st-a::before {
        display: none;
    }

    #{{ $uid }} .rj-st-a .rj-st-item {
        display: flex;
        align-items: center;
        min-height: 130px;
        padding-bottom: 24px;
    }
    #{{ $uid }} .rj-st-a .rj-st-item:last-child {
        padding-bottom: 0;
    }
    #{{ $uid }} .rj-st-a .rj-st-item > .rj-st-body {
        flex: 1;
        max-width: calc(50% - 60px);
    }
    #{{ $uid }} .rj-st-a .rj-st-item:nth-child(odd) {
        flex-direction: row-reverse;
        text-align: right;
    }
    #{{ $uid }} .rj-st-a .rj-st-item:nth-child(odd) > .rj-st-body {
        padding-right: 40px;
    }
    #{{ $uid }} .rj-st-a .rj-st-item:nth-child(even) {
        flex-direction: row;
        text-align: left;
    }
    #{{ $uid }} .rj-st-a .rj-st-item:nth-child(even) > .rj-st-body {
        padding-left: 40px;
    }
    #{{ $uid }} .rj-st-a .rj-st-item > .rj-st-num {
        position: relative;
        z-index: 2;
        margin: 0 auto;
    }

    @media (max-width: 760px) {
        #{{ $uid }} .rj-st-a::before {
            left: 31px;
            transform: none;
        }
        #{{ $uid }} .rj-st-a .rj-st-item,
        #{{ $uid }} .rj-st-a .rj-st-item:nth-child(odd),
        #{{ $uid }} .rj-st-a .rj-st-item:nth-child(even) {
            flex-direction: row;
            text-align: left;
            padding-bottom: 24px;
        }
        #{{ $uid }} .rj-st-a .rj-st-item > .rj-st-body,
        #{{ $uid }} .rj-st-a .rj-st-item:nth-child(odd) > .rj-st-body,
        #{{ $uid }} .rj-st-a .rj-st-item:nth-child(even) > .rj-st-body {
            max-width: none;
            padding: 6px 0 0 16px;
        }
        #{{ $uid }} .rj-st-a .rj-st-item > .rj-st-num {
            margin: 0;
        }
    }

    /* ============================================
       ANIMATION
       ============================================ */
    @if($animate)
    #{{ $uid }} .rj-st-anim {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1);
    }
    #{{ $uid }} .rj-st-anim.is-visible {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }} .rj-st-h .rj-st-item.rj-st-anim,
    #{{ $uid }} .rj-st-a .rj-st-item.rj-st-anim {
        transition-delay: var(--d, 0s);
    }
    @endif

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
        #{{ $uid }} .rj-st-anim { opacity: 1; transform: none; }
    }
</style>

<div id="{{ $uid }}"
     data-layout="{{ $layout }}"
     data-num="{{ $numberStyle }}"
     data-connector="{{ $connector }}"
     data-animate="{{ $animate ? '1' : '0' }}">

    <div class="rj-st-inner">
        @if($title || $subtitle || $desc)
            <header class="rj-st-head">
                @if($subtitle)
                    <p class="rj-st-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-st-title">{{ $title }}</h2>
                @endif
                @if($desc)
                    <p class="rj-st-desc">{{ $desc }}</p>
                @endif
            </header>
        @endif

        @if(!empty($steps))
            @if($layout === 'vertical')
                <div class="rj-st-v">
                    @foreach($steps as $i => $step)
                        <div class="rj-st-item {{ $animate ? 'rj-st-anim' : '' }}" style="--d: {{ number_format($i * 0.08, 2, '.', '') }}s;">
                            @if($i < count($steps) - 1)
                                <span class="rj-st-connector" aria-hidden="true"></span>
                            @endif
                            <div class="rj-st-num">
                                <div class="rj-st-num-inner">
                                    @if($numberStyle === 'icon' && $step['icon'] !== '')
                                        <img src="{{ $iconUrl($step['icon']) }}" alt="" loading="lazy">
                                    @elseif($step['image'] !== '')
                                        <img src="{{ $step['image'] }}" alt="" class="rj-st-num-img" loading="lazy">
                                    @else
                                        {{ $step['n'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="rj-st-body">
                                @if($step['title'] !== '')
                                    <h3 class="rj-st-step-title">{{ $step['title'] }}</h3>
                                @endif
                                @if($step['desc'] !== '')
                                    <p class="rj-st-step-desc">{{ $step['desc'] }}</p>
                                @endif
                                @if($step['link'] !== '')
                                    <a href="{{ $step['link'] }}" class="rj-st-step-link">
                                        <span>{{ __('Learn more') }}</span>
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($layout === 'alternating')
                <div class="rj-st-a">
                    @foreach($steps as $i => $step)
                        <div class="rj-st-item {{ $animate ? 'rj-st-anim' : '' }}" style="--d: {{ number_format($i * 0.08, 2, '.', '') }}s;">
                            <div class="rj-st-num">
                                <div class="rj-st-num-inner">
                                    @if($numberStyle === 'icon' && $step['icon'] !== '')
                                        <img src="{{ $iconUrl($step['icon']) }}" alt="" loading="lazy">
                                    @elseif($step['image'] !== '')
                                        <img src="{{ $step['image'] }}" alt="" class="rj-st-num-img" loading="lazy">
                                    @else
                                        {{ $step['n'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="rj-st-body">
                                @if($step['title'] !== '')
                                    <h3 class="rj-st-step-title">{{ $step['title'] }}</h3>
                                @endif
                                @if($step['desc'] !== '')
                                    <p class="rj-st-step-desc">{{ $step['desc'] }}</p>
                                @endif
                                @if($step['link'] !== '')
                                    <a href="{{ $step['link'] }}" class="rj-st-step-link">
                                        <span>{{ __('Learn more') }}</span>
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rj-st-h">
                    @foreach($steps as $i => $step)
                        <div class="rj-st-item {{ $animate ? 'rj-st-anim' : '' }}" style="--d: {{ number_format($i * 0.08, 2, '.', '') }}s;">
                            <div class="rj-st-num">
                                <div class="rj-st-num-inner">
                                    @if($numberStyle === 'icon' && $step['icon'] !== '')
                                        <img src="{{ $iconUrl($step['icon']) }}" alt="" loading="lazy">
                                    @elseif($step['image'] !== '')
                                        <img src="{{ $step['image'] }}" alt="" class="rj-st-num-img" loading="lazy">
                                    @else
                                        {{ $step['n'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="rj-st-body">
                                @if($step['title'] !== '')
                                    <h3 class="rj-st-step-title">{{ $step['title'] }}</h3>
                                @endif
                                @if($step['desc'] !== '')
                                    <p class="rj-st-step-desc">{{ $step['desc'] }}</p>
                                @endif
                                @if($step['link'] !== '')
                                    <a href="{{ $step['link'] }}" class="rj-st-step-link">
                                        <span>{{ __('Learn more') }}</span>
                                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if($i < count($steps) - 1)
                            <div class="rj-st-connector" aria-hidden="true"></div>
                        @endif
                    @endforeach
                </div>
            @endif
        @else
            <div style="max-width: 480px; margin: 0 auto; padding: 40px 24px; text-align: center; color: var(--st-muted); background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px; font-size: 14px;">
                {{ __('Please add at least one step.') }}
            </div>
        @endif
    </div>
</div>

@if($animate)
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var els = root.querySelectorAll('.rj-st-anim');
    if (!els.length) return;

    if (typeof IntersectionObserver === 'undefined') {
        els.forEach(function (el) { el.classList.add('is-visible'); });
        return;
    }

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    els.forEach(function (el) { io.observe(el); });
})();
</script>
@endif
