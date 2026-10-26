@php
    $auto = $o['behavior'] === 'autoplay';
@endphp

<style>
    @keyframes rjv-ring-{{ $uid }} {
        0% { transform: scale(1); opacity: .55; }
        100% { transform: scale(1.9); opacity: 0; }
    }

    #{{ $uid }} { width: 100%; padding: 8px 0; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .rjv-frame { position: relative; width: 100%; max-width: {{ $o['max_width'] }}; max-width: {{ $o['max_width_sv'] }}; margin: 0 auto; aspect-ratio: {{ $o['aspect'] }}; border-radius: {{ $o['radius'] }}; overflow: hidden; isolation: isolate; background: #0b1020; box-shadow: 0 2px 4px rgba(15,23,42,.06), 0 28px 60px -28px rgba(15,23,42,.45); transition: box-shadow .5s ease, transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjv-frame:hover { transform: translateY(-3px); box-shadow: 0 2px 4px rgba(15,23,42,.06), 0 40px 70px -28px rgba(15,23,42,.55); }

    #{{ $uid }} .rjv-media { position: absolute; inset: 0; z-index: 1; opacity: 0; pointer-events: none; transition: opacity .5s ease; }
    #{{ $uid }}.is-playing .rjv-media { opacity: 1; pointer-events: auto; }
    #{{ $uid }} .rjv-media iframe, #{{ $uid }} .rjv-media video { display: block; width: 100%; height: 100%; max-width: none; border: 0; object-fit: cover; background: #000; }

    #{{ $uid }} .rjv-facade { all: unset; box-sizing: border-box; position: absolute; inset: 0; z-index: 2; display: block; cursor: pointer; overflow: hidden; transition: opacity .5s ease, visibility 0s linear 0s; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }}.is-playing .rjv-facade { opacity: 0; visibility: hidden; pointer-events: none; transition: opacity .5s ease, visibility 0s linear .5s; }
    #{{ $uid }} .rjv-facade:focus-visible { outline: 3px solid {{ $o['play_bg'] }}; outline-offset: -6px; }

    #{{ $uid }} .rjv-poster { position: absolute; inset: 0; display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; transition: transform 1s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjv-facade:hover .rjv-poster { transform: scale(1.06); }
    #{{ $uid }} .rjv-empty { position: absolute; inset: 0; background: radial-gradient(circle at 30% 20%, rgba(139,92,246,.35), transparent 60%), #111827; }

    #{{ $uid }} .rjv-shade { position: absolute; inset: 0; background: linear-gradient(to top, rgba(2,6,23,.65), rgba(2,6,23,.1) 55%, rgba(2,6,23,.25)); transition: opacity .5s ease; }
    #{{ $uid }} .rjv-facade:hover .rjv-shade { opacity: .75; }

    #{{ $uid }} .rjv-play { position: absolute; top: 50%; left: 50%; width: 84px; height: 84px; margin: -42px 0 0 -42px; display: grid; place-items: center; border-radius: 50%; background: {{ $o['play_bg'] }}; color: {{ $o['play_color'] }}; box-shadow: 0 18px 40px -10px {{ $o['play_bg'] }}; transition: transform .5s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rjv-play::before, #{{ $uid }} .rjv-play::after { content: ""; position: absolute; inset: 0; border-radius: 50%; border: 2px solid {{ $o['play_bg'] }}; opacity: 0; animation: rjv-ring-{{ $uid }} 2.4s ease-out infinite; }
    #{{ $uid }} .rjv-play::after { animation-delay: 1.2s; }
    #{{ $uid }} .rjv-facade:hover .rjv-play { transform: scale(1.12); }
    #{{ $uid }} .rjv-play svg { display: block; width: 32px; height: 32px; margin-left: 4px; max-width: none; }

    #{{ $uid }} .rjv-cap { position: absolute; left: 0; right: 0; bottom: 0; padding: 22px 26px; color: #fff; font-size: clamp(1rem, 2vw, 1.3rem); font-weight: 700; line-height: 1.3; letter-spacing: -.01em; text-shadow: 0 2px 14px rgba(0,0,0,.5); transform: translateY(6px); transition: transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjv-facade:hover .rjv-cap { transform: none; }

    @media (max-width: 639px) {
        #{{ $uid }} .rjv-play { width: 68px; height: 68px; margin: -34px 0 0 -34px; }
        #{{ $uid }} .rjv-play svg { width: 26px; height: 26px; }
        #{{ $uid }} .rjv-cap { padding: 16px 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
    }
</style>

<div id="{{ $uid }}"
     class="{{ $auto ? 'is-playing' : '' }}"
     data-behavior="{{ $o['behavior'] }}"
     data-kind="{{ $o['kind'] }}"
     data-src="{{ $o['src'] }}"
     data-mute="{{ $o['mute'] ? 1 : 0 }}"
     data-loop="{{ $o['loop'] ? 1 : 0 }}"
     data-controls="{{ $o['controls'] ? 1 : 0 }}">
    <div class="rjv-frame">

        @unless ($auto)
            <button type="button" class="rjv-facade" aria-label="{{ __('Play video') }}">
                @if ($o['poster'] !== '')
                    <img class="rjv-poster" src="{{ $o['poster'] }}" alt="" loading="lazy" decoding="async" @if ($o['poster_fallback'] !== '') data-fallback="{{ $o['poster_fallback'] }}" @endif>
                @else
                    <span class="rjv-empty"></span>
                @endif
                <span class="rjv-shade"></span>
                <span class="rjv-play" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                </span>
                @if ($o['caption'] !== '')
                    <span class="rjv-cap">{{ $o['caption'] }}</span>
                @endif
            </button>
        @endunless

        <div class="rjv-media">
            @if ($auto)
                @if ($o['kind'] === 'file')
                    <video src="{{ $o['src'] }}" autoplay muted playsinline @if ($o['loop']) loop @endif @if ($o['controls']) controls @endif></video>
                @else
                    <iframe src="{{ $o['src'] }}" title="{{ __('Video') }}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                @endif
            @endif
        </div>

    </div>
</div>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var facade = root.querySelector('.rjv-facade');
    var media = root.querySelector('.rjv-media');
    var poster = root.querySelector('.rjv-poster');
    var behavior = root.dataset.behavior;
    var kind = root.dataset.kind;
    var src = root.dataset.src;
    var mute = root.dataset.mute === '1';
    var loop = root.dataset.loop === '1';
    var controls = root.dataset.controls === '1';
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;

    if (poster && poster.dataset.fallback) {
        var swapped = false;
        var swap = function () {
            if (swapped) { return; }
            swapped = true;
            poster.src = poster.dataset.fallback;
        };
        poster.addEventListener('error', swap);
        poster.addEventListener('load', function () {
            if (poster.naturalWidth && poster.naturalWidth <= 120) { swap(); }
        });
    }

    if (behavior === 'autoplay') {
        var autoVideo = media.querySelector('video');
        if (autoVideo && 'IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    var p = autoVideo.play();
                    if (p && p.catch) { p.catch(function () {}); }
                } else {
                    autoVideo.pause();
                }
            }, { threshold: 0.25 }).observe(root);
        }
        return;
    }

    function build() {
        if (media.firstElementChild) { return; }

        if (kind === 'file') {
            var v = document.createElement('video');
            v.src = src;
            v.autoplay = true;
            v.muted = mute;
            v.loop = loop;
            v.controls = controls;
            v.playsInline = true;
            v.setAttribute('playsinline', '');
            media.appendChild(v);
        } else {
            var f = document.createElement('iframe');
            f.src = src;
            f.title = 'Video';
            f.allow = 'autoplay; fullscreen; picture-in-picture';
            f.setAttribute('allowfullscreen', '');
            media.appendChild(f);
        }
    }

    function play() {
        build();
        root.classList.add('is-playing');

        var v = media.querySelector('video');
        if (v) {
            var p = v.play();
            if (p && p.catch) { p.catch(function () {}); }
        }
    }

    function stop() {
        root.classList.remove('is-playing');

        var v = media.querySelector('video');
        if (v) {
            v.pause();
        } else {
            media.innerHTML = '';
        }
    }

    if (facade) { facade.addEventListener('click', play); }

    if (behavior === 'hover' && canHover) {
        root.addEventListener('mouseenter', play);
        root.addEventListener('mouseleave', stop);
    }
})();
</script>
