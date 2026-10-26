<style>
    #{{ $uid }} { display: flex; justify-content: {{ $o['justify'] }}; width: 100%; margin: 0; padding: 0; --bg: {{ $o['bg'] }}; --fg: {{ $o['fg'] }}; --hbg: {{ $o['hbg'] }}; --hfg: {{ $o['hfg'] }}; --brgb: {{ $o['brgb'] }}; --hrgb: {{ $o['hrgb'] }}; --r: {{ $o['radius'] }}; --py: {{ $o['py'] }}; --px: {{ $o['px'] }}; --fs: {{ $o['fs'] }}; --gap: {{ $o['gap'] }}; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Structure ---------- */
    #{{ $uid }} .rjb-enter { display: block; max-width: 100%; }
    #{{ $uid }}[data-full="1"] .rjb-enter { width: 100%; }

    #{{ $uid }} .rjb-wrap { position: relative; display: inline-flex; max-width: 100%; border-radius: var(--r); transform: translate3d(var(--mx, 0px), var(--my, 0px), 0); transition: transform .25s ease-out; }
    #{{ $uid }}[data-full="1"] .rjb-wrap { display: flex; width: 100%; }

    #{{ $uid }} .rjb-btn { position: relative; isolation: isolate; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; gap: var(--gap); max-width: 100%; margin: 0; padding: var(--py) var(--px); border: 2px solid transparent; border-radius: var(--r); font: inherit; font-size: var(--fs); font-weight: 700; line-height: 1.2; text-align: center; text-decoration: none !important; cursor: pointer; -webkit-tap-highlight-color: transparent; transition: background-color .3s ease, background-position .5s ease, color .3s ease, border-color .3s ease, box-shadow .3s ease, transform .3s cubic-bezier(.34, 1.56, .64, 1); }
    #{{ $uid }}[data-full="1"] .rjb-btn { width: 100%; }
    #{{ $uid }}[data-upper="1"] .rjb-btn { text-transform: uppercase; letter-spacing: .08em; }
    #{{ $uid }} .rjb-label, #{{ $uid }} .rjb-ic { position: relative; z-index: 1; }
    #{{ $uid }} .rjb-label { min-width: 0; overflow-wrap: anywhere; }

    /* ---------- Icon ---------- */
    #{{ $uid }} .rjb-ic { flex: none; display: inline-grid; place-items: center; width: 1.25em; height: 1.25em; line-height: 0; transition: transform .35s cubic-bezier(.34, 1.56, .64, 1); }
    #{{ $uid }} .rjb-ic svg, #{{ $uid }} .rjb-ic > * { display: block; width: 100%; height: 100%; max-width: 100%; max-height: 100%; }
    #{{ $uid }}[data-icon="bubble"] .rjb-ic { width: 2em; height: 2em; padding: .4em; border-radius: 50%; background: rgba(127, 127, 127, .2); background: color-mix(in srgb, currentColor 18%, transparent); }
    #{{ $uid }}[data-icon="bubble"][data-ipos="right"] .rjb-ic { margin-right: -.7em; }
    #{{ $uid }}[data-icon="bubble"][data-ipos="left"] .rjb-ic { margin-left: -.7em; }

    /* ---------- Styles ---------- */
    #{{ $uid }}[data-style="solid"] .rjb-btn { background-color: var(--bg); color: var(--fg); }
    #{{ $uid }}[data-style="outline"] .rjb-btn { background-color: transparent; color: var(--bg); border-color: var(--bg); }
    #{{ $uid }}[data-style="ghost"] .rjb-btn { background-color: transparent; color: var(--bg); }
    #{{ $uid }}[data-style="gradient"] .rjb-btn { background-image: linear-gradient(135deg, var(--bg) 0%, var(--hbg) 100%); background-size: 200% auto; background-position: left center; color: var(--fg); }
    #{{ $uid }}[data-style="soft"] .rjb-btn { background-color: rgba(var(--brgb), .14); color: var(--bg); }
    #{{ $uid }}[data-style="neo"] .rjb-btn { background-color: var(--bg); color: var(--fg); box-shadow: 0 6px 0 var(--hbg); margin-bottom: 6px; }

    /* Shadow */
    #{{ $uid }}[data-shadow="soft"]:not([data-style="ghost"]):not([data-style="neo"]) .rjb-btn { box-shadow: 0 8px 20px -8px rgba(15, 23, 42, .35); }
    #{{ $uid }}[data-shadow="strong"]:not([data-style="ghost"]):not([data-style="neo"]) .rjb-btn { box-shadow: 0 16px 34px -10px rgba(15, 23, 42, .55); }

    /* ---------- Hover colors ---------- */
    #{{ $uid }}:not([data-anim="hover-fill"])[data-style="solid"] .rjb-btn:hover { background-color: var(--hbg); color: var(--hfg); }
    #{{ $uid }}:not([data-anim="hover-fill"])[data-style="outline"] .rjb-btn:hover { background-color: var(--hbg); color: var(--hfg); border-color: var(--hbg); }
    #{{ $uid }}:not([data-anim="hover-fill"])[data-style="ghost"] .rjb-btn:hover { background-color: rgba(var(--hrgb), .12); color: var(--hbg); }
    #{{ $uid }}:not([data-anim="hover-fill"])[data-style="gradient"] .rjb-btn:hover { background-position: right center; color: var(--hfg); }
    #{{ $uid }}:not([data-anim="hover-fill"])[data-style="soft"] .rjb-btn:hover { background-color: var(--hbg); color: var(--hfg); }
    #{{ $uid }}:not([data-anim="hover-fill"])[data-style="neo"] .rjb-btn:hover { color: var(--hfg); transform: translateY(3px); box-shadow: 0 3px 0 var(--hbg); }
    #{{ $uid }}[data-style="neo"] .rjb-btn:active { transform: translateY(6px); box-shadow: 0 0 0 var(--hbg); }

    #{{ $uid }}[data-anim="hover-fill"] .rjb-btn:hover { color: var(--hfg); }
    #{{ $uid }}[data-anim="hover-fill"][data-style="outline"] .rjb-btn:hover { border-color: var(--hbg); }
    #{{ $uid }}[data-anim="hover-fill"][data-style="neo"] .rjb-btn:hover { transform: translateY(3px); box-shadow: 0 3px 0 var(--hbg); }

    /* ---------- Hover animations ---------- */
    #{{ $uid }}[data-anim="hover-lift"]:not([data-style="neo"]) .rjb-btn:hover { transform: translateY(-3px); box-shadow: 0 14px 28px -8px rgba(var(--hrgb), .55); }
    #{{ $uid }}[data-anim="hover-glow"] .rjb-btn:hover { box-shadow: 0 0 0 4px rgba(var(--hrgb), .18), 0 0 30px rgba(var(--hrgb), .6); }
    #{{ $uid }}[data-anim="hover-slide"][data-ipos="right"] .rjb-btn:hover .rjb-ic { transform: translateX(5px); }
    #{{ $uid }}[data-anim="hover-slide"][data-ipos="left"] .rjb-btn:hover .rjb-ic { transform: translateX(-5px); }

    #{{ $uid }}[data-anim="hover-fill"] .rjb-btn::before { content: ""; position: absolute; inset: -2px; z-index: 0; background: var(--hbg); transform: scaleX(0); transform-origin: left center; transition: transform .5s cubic-bezier(.2, .8, .2, 1); }
    #{{ $uid }}[data-anim="hover-fill"] .rjb-btn:hover::before, #{{ $uid }}[data-anim="hover-fill"] .rjb-btn:focus-visible::before { transform: scaleX(1); }

    #{{ $uid }}[data-anim="hover-shine"] .rjb-btn::after, #{{ $uid }}[data-idle="shimmer"] .rjb-btn::after { content: ""; position: absolute; top: 0; bottom: 0; left: -80%; z-index: 2; width: 50%; background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .45), transparent); transform: skewX(-20deg); transition: left .7s ease; pointer-events: none; }
    #{{ $uid }}[data-anim="hover-shine"] .rjb-btn:hover::after { left: 140%; }
    #{{ $uid }}[data-idle="shimmer"] .rjb-btn::after { animation: rjb-shimmer 3.4s ease-in-out infinite; }

    #{{ $uid }} .rjb-btn:active { transform: translateY(1px) scale(.985); }
    #{{ $uid }} .rjb-btn:focus-visible { outline: 3px solid rgba(var(--hrgb), .55); outline-offset: 3px; }

    /* ---------- Attention animations ---------- */
    #{{ $uid }} .rjb-ring { position: absolute; inset: 0; border-radius: var(--r); pointer-events: none; animation: rjb-ring 2.2s ease-out infinite; }
    #{{ $uid }}[data-idle="float"] .rjb-wrap { animation: rjb-float 3.2s ease-in-out infinite; }
    #{{ $uid }}[data-idle="wiggle"] .rjb-wrap { animation: rjb-wiggle 4.2s ease-in-out infinite; }

    /* ---------- Click ripple ---------- */
    #{{ $uid }} .rjb-rip { position: absolute; z-index: 0; border-radius: 50%; background: currentColor; opacity: .28; transform: scale(0); pointer-events: none; animation: rjb-rip .65s ease-out forwards; }

    /* ---------- Entrance (JS only) ---------- */
    #{{ $uid }}.rjb-js .rjb-enter { opacity: 0; }
    #{{ $uid }}.rjb-js.rjb-in .rjb-enter { animation: {{ $o['ent_anim'] }} .85s cubic-bezier(.2, .8, .2, 1) both; }

    /* ---------- Keyframes ---------- */
    @keyframes rjb-ring { 0% { box-shadow: 0 0 0 0 rgba(var(--brgb), .55); } 75%, 100% { box-shadow: 0 0 0 16px rgba(var(--brgb), 0); } }
    @keyframes rjb-float { 0%, 100% { translate: 0 0; } 50% { translate: 0 -7px; } }
    @keyframes rjb-wiggle { 0%, 86%, 100% { rotate: 0deg; } 89% { rotate: -4deg; } 92% { rotate: 4deg; } 95% { rotate: -3deg; } 98% { rotate: 2deg; } }
    @keyframes rjb-shimmer { 0%, 55% { left: -80%; } 100% { left: 140%; } }
    @keyframes rjb-rip { to { transform: scale(1); opacity: 0; } }
    @keyframes rjb-rise { from { opacity: 0; transform: translate3d(0, 26px, 0); } to { opacity: 1; transform: none; } }
    @keyframes rjb-fade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes rjb-zoom { from { opacity: 0; transform: scale(.85); } to { opacity: 1; transform: none; } }
    @keyframes rjb-blur { from { opacity: 0; filter: blur(12px); transform: translate3d(0, 10px, 0); } to { opacity: 1; filter: blur(0); transform: none; } }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; }
        #{{ $uid }}.rjb-js .rjb-enter { opacity: 1; }
        #{{ $uid }} .rjb-wrap { transform: none; }
    }
</style>

<div id="{{ $uid }}"
     class="rjb"
     data-style="{{ $o['style'] }}"
     data-anim="{{ $o['anim'] }}"
     data-idle="{{ $o['idle'] }}"
     data-shadow="{{ $o['shadow'] }}"
     data-icon="{{ $o['icon_style'] }}"
     data-ipos="{{ $o['icon_pos'] }}"
     data-upper="{{ $o['upper'] ? 1 : 0 }}"
     data-full="{{ $o['full'] ? 1 : 0 }}">
    <span class="rjb-enter">
        <span class="rjb-wrap">
            @if ($o['idle'] === 'pulse')
                <span class="rjb-ring" aria-hidden="true"></span>
            @endif

            <a class="rjb-btn"
               href="{{ $o['url'] }}"
               @if ($o['blank']) target="_blank" rel="noopener noreferrer" @endif
               @if ($o['aria'] !== '') aria-label="{{ $o['aria'] }}" @endif>

                @if ($o['icon_html'] !== '' && $o['icon_pos'] === 'left')
                    <span class="rjb-ic" aria-hidden="true">{!! $o['icon_html'] !!}</span>
                @endif

                @if ($o['text'] !== '')
                    <span class="rjb-label">{{ $o['text'] }}</span>
                @endif

                @if ($o['icon_html'] !== '' && $o['icon_pos'] === 'right')
                    <span class="rjb-ic" aria-hidden="true">{!! $o['icon_html'] !!}</span>
                @endif
            </a>
        </span>
    </span>
</div>

@if ($o['needs_js'])
<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var btn = root.querySelector('.rjb-btn');
    var wrap = root.querySelector('.rjb-wrap');
    var reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    var canHover = !!(window.matchMedia && window.matchMedia('(hover: hover)').matches);

    @if ($o['ripple'])
    if (!reduce && btn) {
        btn.addEventListener('pointerdown', function (e) {
            var r = btn.getBoundingClientRect();
            var d = Math.max(r.width, r.height) * 2;
            var s = document.createElement('span');
            s.className = 'rjb-rip';
            s.style.width = d + 'px';
            s.style.height = d + 'px';
            s.style.left = (e.clientX - r.left - d / 2) + 'px';
            s.style.top = (e.clientY - r.top - d / 2) + 'px';
            btn.appendChild(s);
            s.addEventListener('animationend', function () {
                if (s.parentNode) { s.parentNode.removeChild(s); }
            });
        });
    }
    @endif

    @if ($o['anim'] === 'hover-magnetic')
    if (!reduce && canHover && wrap) {
        wrap.addEventListener('pointermove', function (e) {
            if (e.pointerType !== 'mouse') { return; }
            var r = wrap.getBoundingClientRect();
            var x = (e.clientX - (r.left + r.width / 2)) * 0.22;
            var y = (e.clientY - (r.top + r.height / 2)) * 0.3;
            x = Math.max(-12, Math.min(12, x));
            y = Math.max(-8, Math.min(8, y));
            wrap.style.setProperty('--mx', x.toFixed(1) + 'px');
            wrap.style.setProperty('--my', y.toFixed(1) + 'px');
        });
        wrap.addEventListener('pointerleave', function () {
            wrap.style.setProperty('--mx', '0px');
            wrap.style.setProperty('--my', '0px');
        });
    }
    @endif

    @if ($o['entrance'] !== 'none')
    if (!reduce) {
        root.classList.add('rjb-js');
        void root.offsetWidth;

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    io.disconnect();
                    root.classList.add('rjb-in');
                }
            }, { threshold: 0.3 });
            io.observe(root);
        } else {
            root.classList.add('rjb-in');
        }
    }
    @endif
})();
</script>
@endif
