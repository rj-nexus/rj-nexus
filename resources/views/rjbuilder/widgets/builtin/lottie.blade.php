@php
    $sourceType = $settings['source_type'] ?? 'url';
    $url        = trim($settings['url'] ?? '');
    $jsonData   = trim($settings['json_data'] ?? '');
    $fallback   = $settings['fallback'] ?? '';
    $trigger    = $settings['trigger'] ?? 'autoplay';
    $loop       = $settings['loop'] ?? true;
    $speed      = (int) ($settings['speed'] ?? 100);
    $direction  = (int) ($settings['direction'] ?? 1);
    $size       = $settings['size'] ?? 'md';
    $align      = $settings['align'] ?? 'center';
    $paddingY   = (int) ($settings['padding_y'] ?? 40);

    $sizeMap = [
        'sm'   => '200px',
        'md'   => '320px',
        'lg'   => '480px',
        'xl'   => '640px',
        'full' => '100%',
    ];
    $boxSize = $sizeMap[$size] ?? '320px';

    $hasSource = ($sourceType === 'url' && $url !== '') || ($sourceType === 'json' && $jsonData !== '');
@endphp

@once
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js" defer></script>
@endonce

<style>
    #{{ $uid }} {
        width: 100%;
        padding: {{ $paddingY }}px 16px;
        display: flex;
        justify-content: {{ $align === 'left' ? 'flex-start' : ($align === 'right' ? 'flex-end' : 'center') }};
    }
    #{{ $uid }} .rj-lt-box {
        width: {{ $boxSize }};
        max-width: 100%;
        min-height: 120px;
        position: relative;
        @if($trigger === 'click' || $trigger === 'hover') cursor: pointer; @endif
    }
    #{{ $uid }} .rj-lt-canvas {
        width: 100%;
        height: 100%;
        display: block;
    }
    #{{ $uid }} .rj-lt-fallback {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }
    #{{ $uid }} .rj-lt-fallback.rj-lt-hidden { display: none; }

    #{{ $uid }} .rj-lt-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: {{ $size === 'sm' ? '200px' : ($size === 'full' ? '240px' : '320px') }};
        padding: 24px;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 1.5px dashed #cbd5e1;
        border-radius: 16px;
        gap: 12px;
        color: #64748b;
    }
    #{{ $uid }} .rj-lt-placeholder-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: rgba(139,92,246,.12);
        color: #8b5cf6;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #{{ $uid }} .rj-lt-placeholder-icon svg {
        width: 28px;
        height: 28px;
    }
    #{{ $uid }} .rj-lt-placeholder-title {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        margin: 0;
    }
    #{{ $uid }} .rj-lt-placeholder-text {
        font-size: 12.5px;
        line-height: 1.55;
        color: #64748b;
        margin: 0;
        max-width: 260px;
    }
    #{{ $uid }} .rj-lt-placeholder-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 700;
        color: #8b5cf6;
        text-decoration: none;
        padding: 7px 14px;
        border-radius: 8px;
        background: rgba(139,92,246,.1);
        transition: background .2s ease;
        margin-top: 4px;
    }
    #{{ $uid }} .rj-lt-placeholder-link:hover {
        background: rgba(139,92,246,.2);
    }
    #{{ $uid }} .rj-lt-placeholder-link svg {
        width: 12px;
        height: 12px;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} * {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}">
    <div class="rj-lt-box"
         data-trigger="{{ $trigger }}"
         data-loop="{{ $loop ? '1' : '0' }}"
         data-speed="{{ $speed / 100 }}"
         data-direction="{{ $direction }}"
         data-source-type="{{ $sourceType }}"
         data-url="{{ $sourceType === 'url' ? $url : '' }}"
         data-json="{{ $sourceType === 'json' ? $jsonData : '' }}"
         data-fallback="{{ $fallback }}"
         role="img"
         aria-label="{{ __('Lottie animation') }}">

        @if(!$hasSource)
            <div class="rj-lt-placeholder">
                <div class="rj-lt-placeholder-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 12v3M3 12h3m12 0h3M5.6 5.6l2.1 2.1m8.6 8.6l2.1 2.1M5.6 18.4l2.1-2.1m8.6-8.6l2.1-2.1"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                </div>
                <p class="rj-lt-placeholder-title">{{ __('No animation yet') }}</p>
                <p class="rj-lt-placeholder-text">{{ __('Add a Lottie .json URL in the widget settings, or paste JSON directly.') }}</p>
                <a href="https://lottiefiles.com/free-animations" target="_blank" rel="noopener noreferrer" class="rj-lt-placeholder-link">
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>{{ __('Browse free animations') }}</span>
                </a>
            </div>
        @else
            <div class="rj-lt-canvas" data-canvas></div>
            @if($fallback !== '')
                <img class="rj-lt-fallback rj-lt-hidden" src="{{ $fallback }}" alt="" data-fallback-img>
            @endif
        @endif
    </div>
</div>

@if($hasSource)
<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;
    var box = root.querySelector('.rj-lt-box');
    if (!box) return;

    var canvas    = box.querySelector('[data-canvas]');
    var fallbackEl = box.querySelector('[data-fallback-img]');
    var trigger   = box.getAttribute('data-trigger');
    var loop      = box.getAttribute('data-loop') === '1';
    var speed     = parseFloat(box.getAttribute('data-speed')) || 1;
    var direction = parseInt(box.getAttribute('data-direction'), 10) === -1 ? -1 : 1;
    var srcType   = box.getAttribute('data-source-type');
    var url       = box.getAttribute('data-url') || '';
    var jsonStr   = box.getAttribute('data-json') || '';

    var placeholderShown = false;

    function showFallbackNotice() {
        if (placeholderShown) return;
        placeholderShown = true;

        if (canvas) canvas.style.display = 'none';

        if (fallbackEl) {
            fallbackEl.classList.remove('rj-lt-hidden');
            return;
        }

        var ph = document.createElement('div');
        ph.className = 'rj-lt-placeholder';
        ph.innerHTML =
            '<div class="rj-lt-placeholder-icon">' +
                '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
                '</svg>' +
            '</div>' +
            '<p class="rj-lt-placeholder-title">' + @js(__('Animation could not load')) + '</p>' +
            '<p class="rj-lt-placeholder-text">' + @js(__('The Lottie JSON URL may be invalid or blocked. Try another .json file from LottieFiles.')) + '</p>' +
            '<a href="https://lottiefiles.com/free-animations" target="_blank" rel="noopener noreferrer" class="rj-lt-placeholder-link">' +
                '<svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>' +
                '<span>' + @js(__('Browse LottieFiles')) + '</span>' +
            '</a>';
        box.appendChild(ph);
    }

    function boot() {
        if (typeof lottie === 'undefined') {
            var tries = 0;
            var timer = setInterval(function () {
                tries++;
                if (typeof lottie !== 'undefined') {
                    clearInterval(timer);
                    init();
                } else if (tries > 60) {
                    clearInterval(timer);
                    showFallbackNotice();
                }
            }, 100);
            return;
        }
        init();
    }

    function init() {
        var config = {
            container: canvas,
            renderer: 'svg',
            loop: loop,
            autoplay: false,
            path: undefined,
            animationData: undefined
        };

        if (srcType === 'url' && url) {
            config.path = url;
        } else if (srcType === 'json' && jsonStr) {
            try {
                config.animationData = JSON.parse(jsonStr);
            } catch (e) {
                showFallbackNotice();
                return;
            }
        } else {
            showFallbackNotice();
            return;
        }

        var anim;
        try {
            anim = lottie.loadAnimation(config);
        } catch (e) {
            showFallbackNotice();
            return;
        }

        anim.setSpeed(speed);
        anim.setDirection(direction);

        anim.addEventListener('data_failed', showFallbackNotice);
        anim.addEventListener('error', showFallbackNotice);

        if (trigger === 'autoplay') {
            anim.play();
        } else if (trigger === 'hover') {
            box.addEventListener('mouseenter', function () { anim.play(); });
            box.addEventListener('mouseleave', function () { anim.pause(); });
            box.addEventListener('focus', function () { anim.play(); });
            box.addEventListener('blur', function () { anim.pause(); });
            box.setAttribute('tabindex', '0');
        } else if (trigger === 'scroll') {
            if (typeof IntersectionObserver === 'undefined') {
                anim.play();
            } else {
                var played = false;
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting && !played) {
                            played = true;
                            anim.play();
                            io.unobserve(box);
                        }
                    });
                }, { threshold: 0.2 });
                io.observe(box);
            }
        } else if (trigger === 'click') {
            var playing = false;
            box.addEventListener('click', function () {
                if (playing) { anim.pause(); } else { anim.play(); }
                playing = !playing;
            });
            box.setAttribute('tabindex', '0');
            box.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    box.click();
                }
            });
        }
    }

    boot();
})();
</script>
@endif
