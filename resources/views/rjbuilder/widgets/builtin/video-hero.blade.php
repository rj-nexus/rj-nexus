@php
    $c1 = $o['overlay_color'];
    $hasMedia = $v['kind'] !== 'none';
    $hasBtn1 = $c['btn_text'] !== '' && $c['btn_url'] !== '';
    $hasBtn2 = $c['btn2_text'] !== '' && $c['btn2_url'] !== '';
    $n = 0;
@endphp

<style>
    #{{ $uid }} { position: relative; width: 100%; overflow: hidden; background: #020617; isolation: isolate; container-type: size; {{ $o['height_css'] }} --rjvh-accent: {{ $o['accent'] }}; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Media ---------- */
    #{{ $uid }} .rjvh-media { position: absolute; inset: 0; z-index: 0; overflow: hidden; background: #020617; }
    #{{ $uid }} .rjvh-poster { position: absolute; inset: 0; width: 100%; height: 100%; max-width: none; object-fit: cover; display: block; }
    #{{ $uid }} .rjvh-video { position: absolute; inset: 0; width: 100%; height: 100%; max-width: none; object-fit: cover; display: block; }

    /* iframe "cover": object-fit does not work on iframes, so size a 16:9 box to cover the section */
    #{{ $uid }} .rjvh-frame { position: absolute; top: 50%; left: 50%; width: 177.78vh; min-width: 100%; height: 56.25vw; min-height: 100%; transform: translate(-50%, -50%); border: 0; pointer-events: none; animation: rjvh-frame-in 1s ease 1.2s both; }
    @supports (width: 1cqw) {
        #{{ $uid }} .rjvh-frame { width: max(100cqw, calc(100cqh * 16 / 9)); height: max(100cqh, calc(100cqw * 9 / 16)); min-width: 0; min-height: 0; }
    }
    @keyframes rjvh-frame-in { from { opacity: 0; } to { opacity: 1; } }

    /* ---------- Overlay ---------- */
    #{{ $uid }} .rjvh-overlay { position: absolute; inset: 0; z-index: 1; pointer-events: none; background: {{ $c1 }}; opacity: {{ $o['overlay_opacity'] }}; }
    #{{ $uid }}[data-overlay="gradient"] .rjvh-overlay { background: linear-gradient(to top, {{ $c1 }} 0%, {{ $c1 }} 30%, transparent 100%); opacity: {{ $o['overlay_opacity_g'] }}; }
    #{{ $uid }}[data-overlay="side"] .rjvh-overlay { opacity: {{ $o['overlay_opacity_g'] }}; }
    #{{ $uid }}[data-overlay="side"][data-align="left"] .rjvh-overlay { background: linear-gradient(90deg, {{ $c1 }} 0%, {{ $c1 }} 25%, transparent 85%); }
    #{{ $uid }}[data-overlay="side"][data-align="right"] .rjvh-overlay { background: linear-gradient(270deg, {{ $c1 }} 0%, {{ $c1 }} 25%, transparent 85%); }
    #{{ $uid }}[data-overlay="side"][data-align="center"] .rjvh-overlay { background: radial-gradient(ellipse at center, {{ $c1 }} 0%, {{ $c1 }} 30%, transparent 100%); }
    #{{ $uid }}::after { content: ""; position: absolute; left: 0; right: 0; bottom: 0; height: 160px; z-index: 1; background: linear-gradient(to top, rgba(0, 0, 0, .4), transparent); pointer-events: none; }

    /* ---------- Content ---------- */
    #{{ $uid }} .rjvh-content { position: absolute; inset: 0; z-index: 2; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; max-width: 1400px; margin: 0 auto; padding: 64px clamp(24px, 7vw, 120px) 96px; }
    #{{ $uid }}[data-align="left"] .rjvh-content { align-items: flex-start; text-align: left; }
    #{{ $uid }}[data-align="right"] .rjvh-content { align-items: flex-end; text-align: right; }
    #{{ $uid }}[data-valign="top"] .rjvh-content { justify-content: flex-start; padding-top: 96px; }
    #{{ $uid }}[data-valign="bottom"] .rjvh-content { justify-content: flex-end; }

    #{{ $uid }} .rjvh-card { display: flex; flex-direction: column; align-items: inherit; gap: 20px; width: 100%; max-width: 52rem; background: transparent; }
    #{{ $uid }}[data-content="glass"] .rjvh-card { width: auto; padding: clamp(24px, 3.5vw, 48px); border-radius: 28px; background: rgba(255, 255, 255, .08); border: 1px solid rgba(255, 255, 255, .2); -webkit-backdrop-filter: blur(18px) saturate(140%); backdrop-filter: blur(18px) saturate(140%); box-shadow: 0 20px 60px rgba(0, 0, 0, .25); }

    #{{ $uid }} .rjvh-eyebrow { display: inline-flex; align-items: center; gap: 10px; margin: 0; padding: 7px 16px; border-radius: 999px; font-size: .72rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: {{ $o['title_color'] }}; background: rgba(255, 255, 255, .1); border: 1px solid rgba(255, 255, 255, .25); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    #{{ $uid }} .rjvh-eyebrow::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: var(--rjvh-accent); box-shadow: 0 0 12px var(--rjvh-accent); }
    #{{ $uid }} .rjvh-title { margin: 0; padding: 0; background: transparent; font-size: {{ $o['title_font'] }}; font-weight: 800; line-height: 1.08; letter-spacing: -0.025em; color: {{ $o['title_color'] }}; text-shadow: 0 2px 28px rgba(0, 0, 0, .3); }
    #{{ $uid }} .rjvh-accent { color: var(--rjvh-accent); background: linear-gradient(var(--rjvh-accent), var(--rjvh-accent)) left 94% / 100% .07em no-repeat; padding-bottom: .04em; }
    #{{ $uid }} .rjvh-subtitle { margin: 0; padding: 0; max-width: 40rem; background: transparent; font-size: clamp(1rem, 1.7vw, 1.35rem); line-height: 1.65; color: {{ $o['subtitle_color'] }}; text-shadow: 0 1px 14px rgba(0, 0, 0, .3); }

    #{{ $uid }} .rjvh-actions { display: flex; flex-wrap: wrap; gap: 14px; padding: 12px 0 0; justify-content: center; background: transparent; }
    #{{ $uid }}[data-align="left"] .rjvh-actions { justify-content: flex-start; }
    #{{ $uid }}[data-align="right"] .rjvh-actions { justify-content: flex-end; }

    #{{ $uid }} .rjvh-btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 34px; border-radius: {{ $o['btn_radius'] }}; font-size: .8rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; text-decoration: none !important; line-height: 1; cursor: pointer; transition: background-color .3s ease, color .3s ease, border-color .3s ease, transform .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .rjvh-btn svg { width: 16px; height: 16px; transition: transform .3s ease; }
    #{{ $uid }} .rjvh-btn:hover svg, #{{ $uid }} .rjvh-btn:focus-visible svg { transform: translateX(5px); }
    #{{ $uid }} .rjvh-btn-primary { background-color: {{ $o['btn_bg'] }} !important; color: {{ $o['btn_text'] }} !important; border: 1.5px solid transparent; box-shadow: 0 12px 28px rgba(0, 0, 0, .3); }
    #{{ $uid }} .rjvh-btn-primary:hover, #{{ $uid }} .rjvh-btn-primary:focus-visible { background-color: {{ $o['btn_hover_bg'] }} !important; color: {{ $o['btn_hover_text'] }} !important; transform: translateY(-3px); box-shadow: 0 18px 36px rgba(0, 0, 0, .35); }
    #{{ $uid }} .rjvh-btn-ghost { background-color: rgba(255, 255, 255, .08) !important; color: {{ $o['title_color'] }} !important; border: 1.5px solid rgba(255, 255, 255, .55); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); }
    #{{ $uid }} .rjvh-btn-ghost:hover, #{{ $uid }} .rjvh-btn-ghost:focus-visible { background-color: {{ $o['title_color'] }} !important; color: {{ $o['btn_text'] }} !important; border-color: {{ $o['title_color'] }}; transform: translateY(-3px); }

    /* ---------- Text animation (CSS only) ---------- */
    #{{ $uid }} .rjvh-in { animation-name: {{ $o['text_anim'] }}; animation-duration: .95s; animation-timing-function: cubic-bezier(.2, .8, .2, 1); animation-fill-mode: both; animation-delay: calc(var(--i, 0) * 140ms + 250ms); }
    @keyframes rjvh-rise { from { opacity: 0; transform: translate3d(0, 28px, 0); } to { opacity: 1; transform: none; } }
    @keyframes rjvh-fade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes rjvh-zoom { from { opacity: 0; transform: scale(.9); } to { opacity: 1; transform: none; } }
    @keyframes rjvh-blur { from { opacity: 0; filter: blur(14px); transform: translate3d(0, 10px, 0); } to { opacity: 1; filter: blur(0); transform: none; } }

    /* ---------- Controls ---------- */
    #{{ $uid }} .rjvh-controls { position: absolute; right: 24px; bottom: 22px; z-index: 5; display: flex; gap: 10px; }
    #{{ $uid }} .rjvh-ctl { width: 42px; height: 42px; margin: 0; padding: 0; display: grid; place-items: center; border: 1px solid rgba(255, 255, 255, .3); border-radius: 999px; background: rgba(0, 0, 0, .3); color: #fff; -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px); cursor: pointer; transition: background .3s ease, transform .3s ease; }
    #{{ $uid }} .rjvh-ctl:hover { background: rgba(0, 0, 0, .65); transform: scale(1.08); }
    #{{ $uid }} .rjvh-ctl svg { width: 18px; height: 18px; }
    #{{ $uid }} .rjvh-i-play, #{{ $uid }} .rjvh-i-on { display: none; }
    #{{ $uid }}.rjvh-paused .rjvh-i-play { display: block; }
    #{{ $uid }}.rjvh-paused .rjvh-i-pause { display: none; }
    #{{ $uid }}.rjvh-unmuted .rjvh-i-on { display: block; }
    #{{ $uid }}.rjvh-unmuted .rjvh-i-off { display: none; }

    #{{ $uid }} .rjvh-hint { position: absolute; left: 50%; bottom: 26px; z-index: 5; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 10px; margin: 0; padding: 4px 8px; border: 0; background: transparent; color: rgba(255, 255, 255, .85); font-size: .7rem; font-weight: 600; letter-spacing: .3em; text-transform: uppercase; cursor: pointer; }
    #{{ $uid }} .rjvh-hint i { display: block; width: 22px; height: 36px; border: 1.5px solid rgba(255, 255, 255, .7); border-radius: 999px; position: relative; }
    #{{ $uid }} .rjvh-hint i::after { content: ""; position: absolute; top: 7px; left: 50%; width: 3px; height: 7px; margin-left: -1.5px; border-radius: 2px; background: #fff; animation: rjvh-wheel 1.8s ease-in-out infinite; }
    @keyframes rjvh-wheel { 0% { opacity: 0; transform: translateY(0); } 30% { opacity: 1; } 100% { opacity: 0; transform: translateY(12px); } }

    @media (max-width: 640px) {
        #{{ $uid }} .rjvh-content { padding: 48px 24px 88px; }
        #{{ $uid }} .rjvh-btn { padding: 14px 24px; }
        #{{ $uid }} .rjvh-controls { right: 16px; bottom: 16px; }
        #{{ $uid }} .rjvh-hint { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjvh-in { animation-duration: .01ms !important; animation-delay: 0ms !important; }
        #{{ $uid }} .rjvh-frame { animation: none; }
        #{{ $uid }} .rjvh-hint i::after { animation: none; opacity: 1; }
    }
</style>

<section id="{{ $uid }}"
         data-kind="{{ $v['kind'] }}"
         data-align="{{ $o['align'] }}"
         data-valign="{{ $o['valign'] }}"
         data-overlay="{{ $o['overlay_style'] }}"
         data-content="{{ $o['content_style'] }}"
         @if($c['title'] !== '') aria-label="{{ $c['title'] }}" @endif>

    <div class="rjvh-media" aria-hidden="true">
        @if ($o['fallback'] !== '')
            <img class="rjvh-poster" src="{{ $o['fallback'] }}" alt="" decoding="async">
        @endif

        @if ($v['kind'] === 'file')
            <video class="rjvh-video" autoplay muted loop playsinline preload="auto" @if($o['fallback'] !== '') poster="{{ $o['fallback'] }}" @endif>
                <source src="{{ $v['url'] }}" @if($v['mime'] !== '') type="{{ $v['mime'] }}" @endif>
            </video>
        @elseif ($v['kind'] === 'youtube' || $v['kind'] === 'vimeo')
            <iframe class="rjvh-frame" src="{{ $v['url'] }}" title="{{ $c['title'] !== '' ? $c['title'] : 'Video' }}" loading="lazy" tabindex="-1" allow="autoplay; fullscreen; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        @endif
    </div>

    <div class="rjvh-overlay"></div>

    <div class="rjvh-content">
        <div class="rjvh-card">
            @if ($c['eyebrow'] !== '')
                <span class="rjvh-eyebrow rjvh-in" style="--i: {{ $n++ }};">{{ $c['eyebrow'] }}</span>
            @endif

            @if ($c['title_html'] !== '')
                <h1 class="rjvh-title rjvh-in" style="--i: {{ $n++ }};">{!! $c['title_html'] !!}</h1>
            @endif

            @if ($c['subtitle'] !== '')
                <p class="rjvh-subtitle rjvh-in" style="--i: {{ $n++ }};">{!! nl2br(e($c['subtitle'])) !!}</p>
            @endif

            @if ($hasBtn1 || $hasBtn2)
                <div class="rjvh-actions rjvh-in" style="--i: {{ $n++ }};">
                    @if ($hasBtn1)
                        <a href="{{ $c['btn_url'] }}" class="rjvh-btn rjvh-btn-primary" @if($o['btn_new_tab']) target="_blank" rel="noopener noreferrer" @endif>
                            <span>{{ $c['btn_text'] }}</span>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                        </a>
                    @endif
                    @if ($hasBtn2)
                        <a href="{{ $c['btn2_url'] }}" class="rjvh-btn rjvh-btn-ghost" @if($o['btn_new_tab']) target="_blank" rel="noopener noreferrer" @endif>
                            <span>{{ $c['btn2_text'] }}</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if ($hasMedia && $o['show_controls'])
        <div class="rjvh-controls">
            <button type="button" class="rjvh-ctl rjvh-play" aria-label="{{ __('Pause / play video') }}">
                <svg class="rjvh-i-pause" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
                <svg class="rjvh-i-play" viewBox="0 0 24 24" fill="currentColor"><path d="M7 4l13 8-13 8z"/></svg>
            </button>
            @if ($v['kind'] === 'file' || $v['kind'] === 'youtube')
                <button type="button" class="rjvh-ctl rjvh-sound" aria-label="{{ __('Mute / unmute video') }}">
                    <svg class="rjvh-i-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"/><path d="M23 9l-6 6M17 9l6 6"/></svg>
                    <svg class="rjvh-i-on" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5L6 9H2v6h4l5 4V5z"/><path d="M15.5 8.5a5 5 0 010 7M19 5a10 10 0 010 14"/></svg>
                </button>
            @endif
        </div>
    @endif

    @if ($o['show_hint'])
        <button type="button" class="rjvh-hint" aria-label="{{ __('Scroll down') }}"><i></i><span>{{ __('Scroll') }}</span></button>
    @endif
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var kind = root.getAttribute('data-kind');
    var video = root.querySelector('.rjvh-video');
    var frame = root.querySelector('.rjvh-frame');
    var btnPlay = root.querySelector('.rjvh-play');
    var btnSound = root.querySelector('.rjvh-sound');
    var hint = root.querySelector('.rjvh-hint');
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var state = { user: reduce, offscreen: false, hidden: false };
    var muted = true;
    var io = null;

    function post(msg) {
        if (!frame || !frame.contentWindow) { return; }
        try { frame.contentWindow.postMessage(typeof msg === 'string' ? msg : JSON.stringify(msg), '*'); } catch (e) {}
    }

    function command(play) {
        if (video) {
            if (play) {
                var p = video.play();
                if (p && p.catch) { p.catch(function () {}); }
            } else {
                video.pause();
            }
        } else if (frame) {
            if (kind === 'youtube') {
                post({ event: 'command', func: play ? 'playVideo' : 'pauseVideo', args: [] });
            } else {
                post({ method: play ? 'play' : 'pause' });
            }
        }
    }

    function shouldPlay() { return !state.user && !state.offscreen && !state.hidden; }

    function sync() {
        command(shouldPlay());
        root.classList.toggle('rjvh-paused', state.user);
    }

    if (btnPlay) {
        btnPlay.addEventListener('click', function () {
            state.user = !state.user;
            sync();
        });
    }

    if (btnSound) {
        btnSound.addEventListener('click', function () {
            muted = !muted;
            if (video) {
                video.muted = muted;
                if (!muted && shouldPlay()) { command(true); }
            } else if (kind === 'youtube') {
                post({ event: 'command', func: muted ? 'mute' : 'unMute', args: [] });
                if (!muted && shouldPlay()) { command(true); }
            }
            root.classList.toggle('rjvh-unmuted', !muted);
        });
    }

    if (hint) {
        hint.addEventListener('click', function () {
            var y = root.getBoundingClientRect().bottom + window.pageYOffset;
            window.scrollTo({ top: y, behavior: reduce ? 'auto' : 'smooth' });
        });
    }

    // Reduced motion: keep the video paused (poster / first frame stays visible)
    if (reduce) {
        if (video) {
            video.removeAttribute('autoplay');
            video.pause();
        }
        if (frame) {
            frame.addEventListener('load', function () {
                setTimeout(function () { command(false); }, 900);
            });
        }
        root.classList.add('rjvh-paused');
    }

    // Pause when the tab is hidden or the hero scrolls out of view
    function onVisibility() {
        if (!root.isConnected) {
            document.removeEventListener('visibilitychange', onVisibility);
            if (io) { io.disconnect(); }
            return;
        }
        state.hidden = document.hidden;
        if (!reduce) { sync(); }
    }
    document.addEventListener('visibilitychange', onVisibility);

    if ('IntersectionObserver' in window) {
        io = new IntersectionObserver(function (entries) {
            state.offscreen = !entries[0].isIntersecting;
            if (!reduce) { sync(); }
        }, { threshold: 0.15 });
        io.observe(root);
    }
})();
</script>
