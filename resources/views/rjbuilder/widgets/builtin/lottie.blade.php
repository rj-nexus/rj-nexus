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
    #{{ $uid }} .rj-lt-error {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        padding: 20px;
        text-align: center;
        color: #94a3b8;
        font-size: 12.5px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
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
            <div class="rj-lt-error">{{ __('No animation source provided. Please add a URL or paste JSON.') }}</div>
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

    function fail() {
        if (canvas) canvas.style.display = 'none';
        if (fallbackEl) {
            fallbackEl.classList.remove('rj-lt-hidden');
        } else {
            var err = document.createElement('div');
            err.className = 'rj-lt-error';
            err.textContent = @js(__('Animation could not be loaded.'));
            box.appendChild(err);
        }
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
                    fail();
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
                fail();
                return;
            }
        } else {
            fail();
            return;
        }

        var anim;
        try {
            anim = lottie.loadAnimation(config);
        } catch (e) {
            fail();
            return;
        }

        anim.setSpeed(speed);
        anim.setDirection(direction);

        anim.addEventListener('data_failed', fail);
        anim.addEventListener('error', fail);

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
