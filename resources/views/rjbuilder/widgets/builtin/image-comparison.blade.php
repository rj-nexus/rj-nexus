@php
    $vertical = $o['orientation'] === 'vertical';
@endphp

<style>
    #{{ $uid }} { margin: 0; padding: 0; width: 100%; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Stage ---------- */
    #{{ $uid }} .rjic-stage { position: relative; width: 100%; {{ $o['height_css'] }} overflow: hidden; border-radius: {{ $o['radius'] }}; background: #0f172a; isolation: isolate; user-select: none; -webkit-user-select: none; -webkit-tap-highlight-color: transparent; touch-action: {{ $vertical ? 'pan-x' : 'pan-y' }}; cursor: {{ $vertical ? 'ns-resize' : 'ew-resize' }}; @if($o['shadow']) box-shadow: 0 20px 50px -12px rgba(15, 23, 42, .35); @endif --n: {{ $o['start'] }}; --p: calc(var(--n) * 1%); --sc: {{ $o['color'] }}; --fg: {{ $o['fg'] }}; --hs: {{ $o['handle_px'] }}px; --lw: {{ $o['line_px'] }}px; }

    #{{ $uid }} .rjic-img { position: absolute; inset: 0; width: 100%; height: 100%; max-width: none; object-fit: cover; display: block; pointer-events: none; -webkit-user-drag: none; user-select: none; }
    #{{ $uid }} .rjic-after { z-index: 0; }
    #{{ $uid }} .rjic-before { z-index: 1; clip-path: inset(0 calc(100% - var(--p)) 0 0); will-change: clip-path; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-before { clip-path: inset(0 0 calc(100% - var(--p)) 0); }

    /* ---------- Line ---------- */
    #{{ $uid }} .rjic-line { position: absolute; z-index: 3; top: 0; bottom: 0; left: var(--p); width: var(--lw); transform: translateX(-50%); background: var(--sc); box-shadow: 0 0 10px rgba(0, 0, 0, .35); pointer-events: none; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-line { top: var(--p); bottom: auto; left: 0; right: 0; width: auto; height: var(--lw); transform: translateY(-50%); }

    /* ---------- Handle ---------- */
    #{{ $uid }} .rjic-handle { position: absolute; z-index: 5; top: 50%; left: var(--p); width: var(--hs); height: var(--hs); transform: translate(-50%, -50%); display: grid; place-items: center; border-radius: 50%; background: var(--sc); color: var(--fg); box-shadow: 0 6px 18px rgba(0, 0, 0, .35); cursor: grab; outline: 0; transition: transform .3s cubic-bezier(.34, 1.56, .64, 1), box-shadow .25s ease; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-handle { top: var(--p); left: 50%; }
    #{{ $uid }} .rjic-handle svg { width: 56%; height: 56%; display: block; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-handle svg { transform: rotate(90deg); }
    #{{ $uid }} .rjic-handle:hover { transform: translate(-50%, -50%) scale(1.08); }
    #{{ $uid }} .rjic-stage.rjic-drag .rjic-handle { cursor: grabbing; transform: translate(-50%, -50%) scale(1.14); box-shadow: 0 10px 26px rgba(0, 0, 0, .45); }
    #{{ $uid }} .rjic-handle:focus-visible { box-shadow: 0 0 0 3px #fff, 0 0 0 6px #3b82f6, 0 6px 18px rgba(0, 0, 0, .35); }

    #{{ $uid }} .rjic-stage[data-handle="pill"] .rjic-handle { width: calc(var(--hs) * .62); height: calc(var(--hs) * 1.35); border-radius: 999px; }
    #{{ $uid }} .rjic-stage[data-handle="pill"][data-orient="vertical"] .rjic-handle { width: calc(var(--hs) * 1.35); height: calc(var(--hs) * .62); }
    #{{ $uid }} .rjic-stage[data-handle="pill"] .rjic-handle svg { width: 74%; height: auto; }
    #{{ $uid }} .rjic-stage[data-handle="dot"] .rjic-handle { width: calc(var(--hs) * .5); height: calc(var(--hs) * .5); }
    #{{ $uid }} .rjic-stage[data-handle="dot"] .rjic-handle svg { display: none; }

    #{{ $uid }} .rjic-handle::after { content: ""; position: absolute; inset: -6px; border: 2px solid var(--sc); border-radius: inherit; opacity: 0; pointer-events: none; animation: rjic-pulse 2.2s ease-out infinite; }
    #{{ $uid }} .rjic-stage.rjic-touched .rjic-handle::after { animation: none; }

    /* ---------- Labels ---------- */
    #{{ $uid }} .rjic-label { position: absolute; z-index: 4; margin: 0; padding: 8px 14px; border: 0; border-radius: 999px; background: rgba(0, 0, 0, .55); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); color: #fff; font-family: inherit; font-size: .72rem; font-weight: 700; line-height: 1; letter-spacing: .12em; text-transform: uppercase; white-space: nowrap; cursor: pointer; transition: background-color .2s ease, transform .25s ease; }
    #{{ $uid }} .rjic-label:hover { background: rgba(0, 0, 0, .8); transform: translateY(-2px); }
    #{{ $uid }} .rjic-label:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }

    #{{ $uid }} .rjic-lb { left: 16px; opacity: clamp(0, calc((var(--n) - 10) / 12), 1); }
    #{{ $uid }} .rjic-la { right: 16px; opacity: clamp(0, calc((90 - var(--n)) / 12), 1); }
    #{{ $uid }} .rjic-stage[data-lpos="top"] .rjic-label { top: 16px; }
    #{{ $uid }} .rjic-stage[data-lpos="bottom"] .rjic-label { bottom: 16px; }

    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-la { right: auto; left: 16px; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-lb { top: 16px; bottom: auto; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-la { bottom: 16px; top: auto; }

    #{{ $uid }} .rjic-stage.rjic-hide-b .rjic-lb, #{{ $uid }} .rjic-stage.rjic-hide-a .rjic-la { pointer-events: none; }

    /* ---------- Hint ---------- */
    #{{ $uid }} .rjic-hint { position: absolute; z-index: 4; top: calc(50% + var(--hs) / 2 + 14px); left: var(--p); transform: translateX(-50%); display: flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 999px; background: rgba(0, 0, 0, .6); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); color: #fff; font-size: .7rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; white-space: nowrap; pointer-events: none; transition: opacity .4s ease, visibility .4s ease; animation: rjic-hint 2.2s ease-in-out infinite; }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-hint { top: calc(var(--p) + var(--hs) / 2 + 14px); left: 50%; }
    #{{ $uid }} .rjic-hint svg { width: 14px; height: 14px; display: block; }
    #{{ $uid }} .rjic-stage.rjic-touched .rjic-hint { opacity: 0; visibility: hidden; animation: none; }

    #{{ $uid }} .rjic-caption { margin: 12px 0 0; padding: 0; text-align: center; font-size: .875rem; line-height: 1.5; opacity: .7; }

    @keyframes rjic-pulse { 0% { opacity: .7; transform: scale(.9); } 100% { opacity: 0; transform: scale(1.5); } }
    @keyframes rjic-hint { 0%, 100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-4px); } }
    #{{ $uid }} .rjic-stage[data-orient="vertical"] .rjic-hint { animation-name: rjic-hint-v; }
    @keyframes rjic-hint-v { 0%, 100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-4px); } }

    @media (max-width: 640px) {
        #{{ $uid }} .rjic-label { padding: 7px 11px; font-size: .65rem; }
        #{{ $uid }} .rjic-lb { left: 10px; }
        #{{ $uid }} .rjic-la { right: 10px; }
        #{{ $uid }} .rjic-stage[data-lpos="top"] .rjic-label { top: 10px; }
        #{{ $uid }} .rjic-stage[data-lpos="bottom"] .rjic-label { bottom: 10px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} .rjic-handle, #{{ $uid }} .rjic-label { transition: none; }
        #{{ $uid }} .rjic-handle::after, #{{ $uid }} .rjic-hint { animation: none; }
    }
</style>

<figure id="{{ $uid }}" class="rjic">
    <div class="rjic-stage"
         data-orient="{{ $o['orientation'] }}"
         data-handle="{{ $o['handle_style'] }}"
         data-lpos="{{ $o['label_pos'] }}"
         data-start="{{ $o['start'] }}"
         data-interaction="{{ $o['interaction'] }}"
         data-intro="{{ $o['intro'] ? 1 : 0 }}"
         data-lb="{{ $c['before_label'] }}"
         data-la="{{ $c['after_label'] }}">

        <img class="rjic-img rjic-after" src="{{ $c['after'] }}" alt="{{ $c['after_label'] }}" draggable="false" decoding="async">
        <img class="rjic-img rjic-before" src="{{ $c['before'] }}" alt="{{ $c['before_label'] }}" draggable="false" decoding="async">

        @if ($o['labels'])
            <button type="button" class="rjic-label rjic-lb" data-go="100">{{ $c['before_label'] }}</button>
            <button type="button" class="rjic-label rjic-la" data-go="0">{{ $c['after_label'] }}</button>
        @endif

        <div class="rjic-line" aria-hidden="true"></div>

        <div class="rjic-handle"
             role="slider"
             tabindex="0"
             aria-label="{{ __('Image comparison slider') }}"
             aria-orientation="{{ $o['orientation'] }}"
             aria-valuemin="0"
             aria-valuemax="100"
             aria-valuenow="{{ $o['start'] }}">
            <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l-4 3 4 3M16 9l4 3-4 3"/></svg>
        </div>

        @if ($o['hint'])
            <div class="rjic-hint" aria-hidden="true">
                <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/></svg>
                <span>{{ __('Drag to compare') }}</span>
                <svg fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
            </div>
        @endif
    </div>

    @if ($c['caption'] !== '')
        <figcaption class="rjic-caption">{{ $c['caption'] }}</figcaption>
    @endif
</figure>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var stage = root.querySelector('.rjic-stage');
    var handle = root.querySelector('.rjic-handle');
    var labels = Array.prototype.slice.call(root.querySelectorAll('.rjic-label'));

    var vertical = stage.getAttribute('data-orient') === 'vertical';
    var hoverMode = stage.getAttribute('data-interaction') === 'hover';
    var introOn = stage.getAttribute('data-intro') === '1';
    var start = parseFloat(stage.getAttribute('data-start')) || 0;
    var lb = stage.getAttribute('data-lb') || '';
    var la = stage.getAttribute('data-la') || '';
    var reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

    var value = start;
    var dragging = false;
    var touched = false;
    var tw = null;
    var looping = false;
    var lastAria = -1;

    function clamp(v) { return Math.max(0, Math.min(100, v)); }

    function render(v) {
        value = clamp(v);
        stage.style.setProperty('--n', value.toFixed(2));

        var r = Math.round(value);
        if (r !== lastAria) {
            lastAria = r;
            handle.setAttribute('aria-valuenow', String(r));
            handle.setAttribute('aria-valuetext', lb + ' ' + r + '% / ' + la + ' ' + (100 - r) + '%');
            stage.classList.toggle('rjic-hide-b', r < 8);
            stage.classList.toggle('rjic-hide-a', r > 92);
        }
    }

    // ---------- Tween ----------
    function tick(now) {
        looping = false;
        if (!tw) { return; }

        var t = Math.min(1, (now - tw.t0) / tw.ms);
        var e = 1 - Math.pow(1 - t, 3);
        render(tw.from + (tw.to - tw.from) * e);

        if (t < 1) {
            looping = true;
            requestAnimationFrame(tick);
        } else {
            var done = tw.done;
            tw = null;
            if (done) { done(); }
        }
    }

    function animateTo(to, ms, done) {
        if (reduce || ms <= 0) {
            tw = null;
            render(to);
            if (done) { done(); }
            return;
        }
        tw = { from: value, to: clamp(to), ms: ms, t0: performance.now(), done: done };
        if (!looping) {
            looping = true;
            requestAnimationFrame(tick);
        }
    }

    function touch() {
        tw = null;
        if (!touched) {
            touched = true;
            stage.classList.add('rjic-touched');
        }
    }

    function posFrom(e) {
        var r = stage.getBoundingClientRect();
        var v = vertical ? (e.clientY - r.top) / r.height : (e.clientX - r.left) / r.width;
        return clamp(v * 100);
    }

    // ---------- Pointer ----------
    stage.addEventListener('pointerdown', function (e) {
        if (e.pointerType === 'mouse' && e.button !== 0) { return; }
        if (e.target.closest && e.target.closest('.rjic-label')) { return; }

        touch();
        dragging = true;
        stage.classList.add('rjic-drag');
        try { stage.setPointerCapture(e.pointerId); } catch (err) {}

        animateTo(posFrom(e), 220);
        try { handle.focus({ preventScroll: true }); } catch (err) {}
    });

    stage.addEventListener('pointermove', function (e) {
        if (dragging) {
            tw = null;
            render(posFrom(e));
        } else if (hoverMode && e.pointerType === 'mouse') {
            touch();
            render(posFrom(e));
        }
    });

    function endDrag() {
        dragging = false;
        stage.classList.remove('rjic-drag');
    }

    stage.addEventListener('pointerup', endDrag);
    stage.addEventListener('pointercancel', endDrag);
    stage.addEventListener('lostpointercapture', endDrag);
    stage.addEventListener('dragstart', function (e) { e.preventDefault(); });

    // ---------- Labels ----------
    labels.forEach(function (btn) {
        btn.addEventListener('pointerdown', function (e) { e.stopPropagation(); });
        btn.addEventListener('click', function () {
            touch();
            animateTo(parseFloat(btn.getAttribute('data-go')) || 0, 600);
        });
    });

    // ---------- Keyboard ----------
    handle.addEventListener('keydown', function (e) {
        var step = e.shiftKey ? 10 : 2;
        var next = null;

        switch (e.key) {
            case 'ArrowLeft':
            case 'ArrowUp': next = value - step; break;
            case 'ArrowRight':
            case 'ArrowDown': next = value + step; break;
            case 'PageUp': next = value + 10; break;
            case 'PageDown': next = value - 10; break;
            case 'Home': next = 0; break;
            case 'End': next = 100; break;
            default: return;
        }

        e.preventDefault();
        touch();
        animateTo(next, 140);
    });

    // ---------- Intro sweep ----------
    function runIntro() {
        if (!introOn || reduce || touched) { return; }

        var seq = [Math.max(8, start - 22), Math.min(92, start + 22), start];
        var i = 0;

        (function step() {
            if (touched || i >= seq.length) { return; }
            animateTo(seq[i++], 750, step);
        })();
    }

    if (introOn && !reduce && 'IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                io.disconnect();
                setTimeout(runIntro, 350);
            }
        }, { threshold: 0.45 });
        io.observe(stage);
    }

    render(start);
})();
</script>
