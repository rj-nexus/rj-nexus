@php
    $widths = ['narrow' => '48rem', 'normal' => '64rem', 'wide' => '80rem', 'full' => '100%'];
    $maxW = $widths[$opts['width']] ?? '64rem';
    $justify = ['left' => 'flex-start', 'center' => 'center', 'right' => 'flex-end'][$opts['align']] ?? 'flex-start';
@endphp

<style>
    #{{ $uid }} { --act: {{ $opts['active'] }}; --inact: {{ $opts['inactive'] }}; --txt: {{ $opts['text'] }}; --bd: #e2e8f0; width: 100%; padding: 32px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} .rjt-wrap { max-width: {{ $maxW }}; margin: 0 auto; }

    /* ---------- Nav ---------- */
    #{{ $uid }} .rjt-nav { display: flex; justify-content: {{ $justify }}; position: relative; margin-bottom: 28px; }
    #{{ $uid }} .rjt-list { position: relative; display: flex; gap: 8px; max-width: 100%; overflow-x: auto; overflow-y: hidden; scrollbar-width: none; -webkit-overflow-scrolling: touch; }
    #{{ $uid }} .rjt-list::-webkit-scrollbar { display: none; }

    #{{ $uid }} .rjt-tab { all: unset; box-sizing: border-box; position: relative; z-index: 1; flex: none; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; white-space: nowrap; font-size: .95rem; font-weight: 700; line-height: 1.2; color: var(--inact); transition: color .3s ease, background-color .3s ease, border-color .3s ease, transform .3s ease; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }} .rjt-tab:hover { color: var(--act); }
    #{{ $uid }} .rjt-tab:focus-visible { outline: 2px solid var(--act); outline-offset: 2px; }
    #{{ $uid }} .rjt-tab svg, #{{ $uid }} .rjt-tab .rjt-ico { width: 20px; height: 20px; flex: none; transition: transform .4s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .rjt-tab.is-active svg { transform: scale(1.12); }

    /* indicator */
    #{{ $uid }} .rjt-ind { position: absolute; left: 0; top: 0; z-index: 0; width: var(--w, 0px); height: var(--h, 0px); transform: translate(var(--x, 0px), var(--y, 0px)); pointer-events: none; opacity: 0; will-change: transform, width, height; }
    #{{ $uid }}.rjt-ready .rjt-ind { opacity: 1; }
    #{{ $uid }}.rjt-anim .rjt-ind { transition: transform .55s cubic-bezier(.4,0,.2,1), width .55s cubic-bezier(.4,0,.2,1), height .55s cubic-bezier(.4,0,.2,1); }

    /* progress (autoplay) */
    #{{ $uid }} .rjt-prog { position: absolute; left: 0; right: 0; bottom: -1px; height: 2px; background: color-mix(in srgb, var(--act) 18%, transparent); overflow: hidden; border-radius: 2px; }
    #{{ $uid }} .rjt-prog i { display: block; height: 100%; background: var(--act); transform: scaleX(0); transform-origin: left; }
    #{{ $uid }} .rjt-prog[hidden] { display: none; }

    /* --- underline --- */
    #{{ $uid }}[data-style="underline"] .rjt-nav { border-bottom: 1px solid var(--bd); }
    #{{ $uid }}[data-style="underline"] .rjt-list { gap: 28px; }
    #{{ $uid }}[data-style="underline"] .rjt-tab { padding: 14px 4px; }
    #{{ $uid }}[data-style="underline"] .rjt-tab.is-active { color: var(--act); }
    #{{ $uid }}[data-style="underline"] .rjt-ind { height: 3px; border-radius: 3px; background: var(--act); transform: translate(var(--x, 0px), calc(var(--y, 0px) + var(--h, 0px) - 3px)); }

    /* --- pills --- */
    #{{ $uid }}[data-style="pills"] .rjt-tab { padding: 11px 22px; border-radius: 999px; }
    #{{ $uid }}[data-style="pills"] .rjt-tab:not(.is-active):hover { background: rgba(100,116,139,.1); }
    #{{ $uid }}[data-style="pills"] .rjt-tab.is-active { color: #fff; }
    #{{ $uid }}[data-style="pills"] .rjt-ind { border-radius: 999px; background: var(--act); box-shadow: 0 10px 24px -10px var(--act); }

    /* --- segmented --- */
    #{{ $uid }}[data-style="segmented"] .rjt-list { gap: 0; padding: 5px; border-radius: 16px; background: #f1f5f9; }
    #{{ $uid }}[data-style="segmented"] .rjt-tab { padding: 10px 22px; border-radius: 11px; }
    #{{ $uid }}[data-style="segmented"] .rjt-tab.is-active { color: var(--act); }
    #{{ $uid }}[data-style="segmented"] .rjt-ind { border-radius: 11px; background: #fff; box-shadow: 0 1px 2px rgba(15,23,42,.08), 0 6px 16px -6px rgba(15,23,42,.18); }

    /* --- boxed --- */
    #{{ $uid }}[data-style="boxed"] .rjt-ind { display: none; }
    #{{ $uid }}[data-style="boxed"] .rjt-tab { padding: 11px 22px; border: 1px solid var(--bd); border-radius: 10px; background: #f8fafc; }
    #{{ $uid }}[data-style="boxed"] .rjt-tab:not(.is-active):hover { border-color: var(--act); }
    #{{ $uid }}[data-style="boxed"] .rjt-tab.is-active { color: #fff; background: var(--act); border-color: var(--act); box-shadow: 0 10px 24px -12px var(--act); }

    /* ---------- Panels ---------- */
    #{{ $uid }} .rjt-panels { min-width: 0; color: var(--txt); }
    #{{ $uid }} .rjt-pane[hidden] { display: none; }
    #{{ $uid }}.rjt-ready .rjt-pane.is-active { animation: rjt-in-f .55s cubic-bezier(.2,.8,.2,1) both; }
    #{{ $uid }}.rjt-ready[data-dir="b"] .rjt-pane.is-active { animation-name: rjt-in-b; }
    @keyframes rjt-in-f { from { opacity: 0; transform: translateX(28px); } to { opacity: 1; transform: none; } }
    @keyframes rjt-in-b { from { opacity: 0; transform: translateX(-28px); } to { opacity: 1; transform: none; } }

    #{{ $uid }}[data-card="1"] .rjt-body { padding: clamp(20px, 3.5vw, 40px); border: 1px solid var(--bd); border-radius: 24px; background: #fff; box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 18px 40px -22px rgba(15,23,42,.2); }

    /* content typography (scoped, independent of the site's reset) */
    #{{ $uid }} .rjt-body { line-height: 1.8; font-size: 1rem; overflow-wrap: anywhere; }
    #{{ $uid }} .rjt-body > :first-child { margin-top: 0; }
    #{{ $uid }} .rjt-body > :last-child { margin-bottom: 0; }
    #{{ $uid }} .rjt-body p { margin: 0 0 1em; }
    #{{ $uid }} .rjt-body h1, #{{ $uid }} .rjt-body h2, #{{ $uid }} .rjt-body h3, #{{ $uid }} .rjt-body h4 { margin: 1.4em 0 .5em; line-height: 1.25; font-weight: 800; color: #0f172a; letter-spacing: -.01em; }
    #{{ $uid }} .rjt-body h2 { font-size: 1.5rem; } #{{ $uid }} .rjt-body h3 { font-size: 1.2rem; }
    #{{ $uid }} .rjt-body ul { list-style: disc; padding-left: 1.4em; margin: 0 0 1em; }
    #{{ $uid }} .rjt-body ol { list-style: decimal; padding-left: 1.4em; margin: 0 0 1em; }
    #{{ $uid }} .rjt-body li { margin: .3em 0; }
    #{{ $uid }} .rjt-body a { color: var(--act); text-decoration: underline; text-underline-offset: 3px; }
    #{{ $uid }} .rjt-body img, #{{ $uid }} .rjt-body video, #{{ $uid }} .rjt-body iframe { max-width: 100%; height: auto; border-radius: 12px; }
    #{{ $uid }} .rjt-body table { width: 100%; border-collapse: collapse; margin: 0 0 1em; display: block; overflow-x: auto; }
    #{{ $uid }} .rjt-body th, #{{ $uid }} .rjt-body td { padding: 10px 14px; border-bottom: 1px solid var(--bd); text-align: left; }
    #{{ $uid }} .rjt-body blockquote { margin: 0 0 1em; padding: 4px 0 4px 18px; border-left: 3px solid var(--act); color: #475569; }
    #{{ $uid }} .rjt-body hr { border: 0; border-top: 1px solid var(--bd); margin: 1.6em 0; }

    /* ---------- Vertical layout (desktop only; mobile falls back to horizontal) ---------- */
    @media (min-width: 768px) {
        #{{ $uid }}[data-orient="vertical"] .rjt-wrap { display: grid; grid-template-columns: minmax(180px, 260px) minmax(0, 1fr); gap: 36px; align-items: start; }
        #{{ $uid }}[data-orient="vertical"] .rjt-nav { display: block; margin: 0; border-bottom: 0; }
        #{{ $uid }}[data-orient="vertical"] .rjt-list { flex-direction: column; gap: 6px; overflow: visible; }
        #{{ $uid }}[data-orient="vertical"] .rjt-tab { width: 100%; justify-content: flex-start; }
        #{{ $uid }}[data-orient="vertical"][data-style="underline"] .rjt-nav { border-bottom: 0; border-left: 1px solid var(--bd); }
        #{{ $uid }}[data-orient="vertical"][data-style="underline"] .rjt-list { gap: 4px; }
        #{{ $uid }}[data-orient="vertical"][data-style="underline"] .rjt-tab { padding: 12px 18px; }
        #{{ $uid }}[data-orient="vertical"][data-style="underline"] .rjt-ind { width: 3px; height: var(--h, 0px); transform: translate(calc(var(--x, 0px) - 1px), var(--y, 0px)); }
        #{{ $uid }}[data-orient="vertical"][data-style="segmented"] .rjt-list { gap: 4px; }
        #{{ $uid }}[data-orient="vertical"] .rjt-prog { top: 0; bottom: 0; left: auto; right: -1px; width: 2px; height: auto; }
        #{{ $uid }}[data-orient="vertical"] .rjt-prog i { transform-origin: top; transform: scaleY(0); }
        #{{ $uid }}[data-orient="vertical"] .rjt-pane.is-active { animation-name: rjt-in-v; }
        #{{ $uid }}[data-orient="vertical"][data-dir="b"] .rjt-pane.is-active { animation-name: rjt-in-vb; }
    }
    @keyframes rjt-in-v { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: none; } }
    @keyframes rjt-in-vb { from { opacity: 0; transform: translateY(-22px); } to { opacity: 1; transform: none; } }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 24px 12px; }
        #{{ $uid }} .rjt-nav { justify-content: flex-start; margin-bottom: 20px; }
        #{{ $uid }}[data-style="underline"] .rjt-list { gap: 20px; }
        #{{ $uid }} .rjt-tab { font-size: .9rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; }
    }
</style>

<section id="{{ $uid }}"
         data-style="{{ $opts['style'] }}"
         data-orient="{{ $opts['orient'] }}"
         data-card="{{ $opts['card'] ? '1' : '0' }}"
         data-hash="{{ $opts['hash'] ? '1' : '0' }}"
         data-auto="{{ $opts['autoplay'] }}"
         data-default="{{ $opts['default'] }}"
         data-dir="f">
    <div class="rjt-wrap">

        <div class="rjt-nav">
            <div class="rjt-list" role="tablist" aria-orientation="{{ $opts['orient'] }}">
                <span class="rjt-ind" aria-hidden="true"></span>

                @foreach ($tabs as $i => $tab)
                    <button type="button"
                            class="rjt-tab"
                            role="tab"
                            id="{{ $uid }}-t{{ $i }}"
                            aria-controls="{{ $uid }}-p{{ $i }}"
                            aria-selected="false"
                            tabindex="-1"
                            data-slug="{{ $tab['slug'] }}">
                        @if (!empty($tab['icon']) && function_exists('rj_icon'))
                            {!! rj_icon($tab['icon'], 'rjt-ico w-5 h-5') !!}
                        @endif
                        <span>{{ $tab['title'] }}</span>
                    </button>
                @endforeach
            </div>

            @if ($opts['autoplay'] > 0)
                <div class="rjt-prog" aria-hidden="true"><i></i></div>
            @endif
        </div>

        <div class="rjt-panels">
            @foreach ($tabs as $i => $tab)
                <div class="rjt-pane"
                     role="tabpanel"
                     id="{{ $uid }}-p{{ $i }}"
                     aria-labelledby="{{ $uid }}-t{{ $i }}"
                     tabindex="0"
                     hidden>
                    <div class="rjt-body">{!! $tab['content'] !!}</div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var list = root.querySelector('.rjt-list');
    var ind = root.querySelector('.rjt-ind');
    var prog = root.querySelector('.rjt-prog');
    var bar = prog ? prog.firstElementChild : null;
    var tabs = [].slice.call(root.querySelectorAll('.rjt-tab'));
    var panes = [].slice.call(root.querySelectorAll('.rjt-pane'));

    var useHash = root.dataset.hash === '1';
    var autoSec = parseInt(root.dataset.auto, 10) || 0;
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var cur = -1;

    function place() {
        var t = tabs[cur];
        if (!t || !list || !t.offsetWidth) { return; }
        list.style.setProperty('--x', t.offsetLeft + 'px');
        list.style.setProperty('--y', t.offsetTop + 'px');
        list.style.setProperty('--w', t.offsetWidth + 'px');
        list.style.setProperty('--h', t.offsetHeight + 'px');
    }

    function keepVisible() {
        var t = tabs[cur];
        if (!t || !list || list.scrollWidth <= list.clientWidth + 1) { return; }
        list.scrollTo({
            left: t.offsetLeft - (list.clientWidth - t.offsetWidth) / 2,
            behavior: reduce ? 'auto' : 'smooth'
        });
    }

    function activate(i, opts) {
        opts = opts || {};
        if (i === cur || i < 0 || i >= tabs.length) { return; }

        root.dataset.dir = (cur === -1 || i > cur) ? 'f' : 'b';
        cur = i;

        tabs.forEach(function (t, k) {
            var on = k === i;
            t.classList.toggle('is-active', on);
            t.setAttribute('aria-selected', on ? 'true' : 'false');
            t.setAttribute('tabindex', on ? '0' : '-1');
        });
        panes.forEach(function (p, k) {
            var on = k === i;
            p.classList.toggle('is-active', on);
            p.hidden = !on;
        });

        place();
        keepVisible();
        progress = 0;
        if (bar) { bar.style.transform = ''; }

        if (useHash && !opts.silent && !opts.auto && window.history && history.replaceState) {
            history.replaceState(null, '', '#' + tabs[i].dataset.slug);
        }
    }

    function fromHash() {
        if (!useHash || !location.hash) { return -1; }
        var h = decodeURIComponent(location.hash.slice(1));
        for (var k = 0; k < tabs.length; k++) {
            if (tabs[k].dataset.slug === h) { return k; }
        }
        return -1;
    }

    // ---------- Autoplay ----------
    var progress = 0, lastTs = 0, hovered = false, inView = true, stopped = !autoSec || reduce, raf = 0;

    function stopAuto() {
        stopped = true;
        if (raf) { cancelAnimationFrame(raf); raf = 0; }
        if (prog) { prog.hidden = true; }
    }

    function tick(ts) {
        if (stopped) { return; }
        if (lastTs && !hovered && inView && !document.hidden) {
            progress += (ts - lastTs) / (autoSec * 1000);
            if (progress >= 1) {
                activate((cur + 1) % tabs.length, { auto: true });
            } else if (bar) {
                var vertical = getComputedStyle(bar).transformOrigin.indexOf('0px 0px') === 0 && prog.offsetHeight > prog.offsetWidth;
                bar.style.transform = (vertical ? 'scaleY(' : 'scaleX(') + progress + ')';
            }
        }
        lastTs = ts;
        raf = requestAnimationFrame(tick);
    }

    // ---------- Events ----------
    tabs.forEach(function (t, k) {
        t.addEventListener('click', function () {
            stopAuto();
            activate(k);
        });

        t.addEventListener('keydown', function (e) {
            var key = e.key, n = -1, last = tabs.length - 1;
            if (key === 'ArrowRight' || key === 'ArrowDown') { n = k === last ? 0 : k + 1; }
            else if (key === 'ArrowLeft' || key === 'ArrowUp') { n = k === 0 ? last : k - 1; }
            else if (key === 'Home') { n = 0; }
            else if (key === 'End') { n = last; }
            if (n < 0) { return; }
            e.preventDefault();
            stopAuto();
            tabs[n].focus();
            activate(n);
        });
    });

    root.addEventListener('mouseenter', function () { hovered = true; });
    root.addEventListener('mouseleave', function () { hovered = false; });
    root.addEventListener('focusin', function () { hovered = true; });
    root.addEventListener('focusout', function () { hovered = false; });

    if (useHash) {
        window.addEventListener('hashchange', function () {
            var k = fromHash();
            if (k > -1) { stopAuto(); activate(k, { silent: true }); }
        });
    }

    if ('ResizeObserver' in window && list) { new ResizeObserver(place).observe(list); }
    window.addEventListener('resize', place);
    if (document.fonts && document.fonts.ready) { document.fonts.ready.then(place); }

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (entries) { inView = entries[0].isIntersecting; }, { threshold: 0.2 }).observe(root);
    }

    // ---------- Init ----------
    var start = fromHash();
    if (start < 0) { start = parseInt(root.dataset.default, 10) || 0; }
    activate(Math.min(start, tabs.length - 1), { silent: true });

    // enable animations only after the first layout so nothing slides on load
    requestAnimationFrame(function () {
        place();
        root.classList.add('rjt-ready');
        requestAnimationFrame(function () { root.classList.add('rjt-anim'); });
    });

    if (!stopped && tabs.length > 1) {
        raf = requestAnimationFrame(tick);
    } else if (prog) {
        prog.hidden = true;
    }
})();
</script>
