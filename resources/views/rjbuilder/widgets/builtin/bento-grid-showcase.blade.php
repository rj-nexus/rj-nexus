<style>
    @property --bn-ang { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

    #{{ $uid }} { --soft: #12162e; --sfg: #fff; --smut: rgba(255,255,255,.62); --sline: rgba(255,255,255,.1); --head: #fff; --headm: rgba(255,255,255,.66);
        position: relative; width: 100%; max-width: 1200px; margin: 0 auto; padding: clamp(8px, 2vw, 16px); box-sizing: border-box; font-family: inherit; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }}[data-theme="light"] { --soft: #f5f5f7; --sfg: #1d1d1f; --smut: #6e6e73; --sline: rgba(0,0,0,.06); --head: #0f172a; --headm: #64748b; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }} .bn-head { margin-bottom: clamp(18px, 3.5vw, 32px); max-width: 720px; }
    #{{ $uid }}[data-align="center"] .bn-head { margin-left: auto; margin-right: auto; text-align: center; }
    #{{ $uid }} .bn-h { margin: 0; color: var(--head); font-size: clamp(1.6rem, 5vw, 2.8rem); font-weight: 800; letter-spacing: -.03em; line-height: 1.1; }
    #{{ $uid }} .bn-sub { margin: 12px 0 0; color: var(--headm); font-size: clamp(.95rem, 2vw, 1.1rem); line-height: 1.5; }

    #{{ $uid }} .bn-grid { display: grid; grid-template-columns: repeat(var(--cols), minmax(0, 1fr)); grid-auto-rows: minmax(var(--row), auto); grid-auto-flow: row dense; gap: var(--gap); }
    #{{ $uid }} .bn-card { display: block; min-width: 0; color: inherit; text-decoration: none; outline: none; }
    #{{ $uid }} .s-2x1 { grid-column: span 2; }
    #{{ $uid }} .s-1x2 { grid-row: span 2; }
    #{{ $uid }} .s-2x2 { grid-column: span 2; grid-row: span 2; }

    #{{ $uid }}.is-ready[data-anim="1"] .bn-card { opacity: 0; transform: translateY(34px) scale(.94); filter: blur(8px); transition: opacity .8s cubic-bezier(.2,.9,.2,1) var(--d), transform .8s cubic-bezier(.2,.9,.2,1) var(--d), filter .8s ease var(--d); }
    #{{ $uid }}.is-ready[data-anim="1"] .bn-card.in { opacity: 1; transform: none; filter: none; }

    #{{ $uid }} .bn-face { --cbg: var(--soft); --cfg: var(--sfg); --cmut: var(--smut); --cline: var(--sline); --spot: color-mix(in srgb, var(--acc) 20%, transparent); --blob: color-mix(in srgb, var(--acc) 55%, transparent); --bo: .5;
        position: relative; display: flex; flex-direction: column; height: 100%; padding: clamp(16px, 2.4vw, 26px); border-radius: var(--rad); overflow: hidden; isolation: isolate;
        background: var(--cbg); color: var(--cfg); border: 1px solid var(--cline); box-shadow: 0 1px 2px rgba(0,0,0,.06);
        transition: transform .55s cubic-bezier(.2,.9,.2,1), box-shadow .4s ease, border-color .4s ease; will-change: transform; }
    #{{ $uid }} .bn-face.moving { transition: transform .12s ease-out, box-shadow .4s ease, border-color .4s ease; }
    #{{ $uid }} .bn-face.v-dark { --cbg: #0b0d1f; --cfg: #fff; --cmut: rgba(255,255,255,.64); --cline: rgba(255,255,255,.1); --spot: rgba(255,255,255,.14); --blob: color-mix(in srgb, var(--acc2) 55%, transparent); }
    #{{ $uid }} .bn-face.v-light { --cbg: #fff; --cfg: #0f172a; --cmut: #64748b; --cline: rgba(15,23,42,.08); }
    #{{ $uid }} .bn-face.v-accent { --cbg: linear-gradient(145deg, var(--acc), color-mix(in srgb, var(--acc) 50%, var(--acc2))); --cfg: #fff; --cmut: rgba(255,255,255,.84); --cline: rgba(255,255,255,.22); --spot: rgba(255,255,255,.26); --blob: rgba(255,255,255,.55); --bo: .4; }
    #{{ $uid }} .bn-face.v-gradient { --cbg: linear-gradient(125deg, var(--acc), var(--acc2), #22d3ee, var(--acc)); --cfg: #fff; --cmut: rgba(255,255,255,.88); --cline: rgba(255,255,255,.22); --spot: rgba(255,255,255,.26); --blob: rgba(255,255,255,.55); --bo: .4; background-size: 300% 300%; animation: bn-shift 14s ease infinite; }

    #{{ $uid }} .bn-face::before { content: ''; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: 0; transition: opacity .35s ease; background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 50%), var(--spot), transparent 46%); }
    #{{ $uid }}[data-spot="1"] .bn-card:hover .bn-face::before { opacity: 1; }
    #{{ $uid }} .bn-face::after { content: ''; position: absolute; inset: 0; border-radius: inherit; padding: 1.5px; pointer-events: none; opacity: 0; transition: opacity .4s ease;
        background: conic-gradient(from var(--bn-ang), transparent 0 62%, var(--acc2), var(--acc), transparent);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0); animation: bn-ang 4s linear infinite; }
    #{{ $uid }} .bn-card:hover .bn-face::after, #{{ $uid }} .bn-card:focus-visible .bn-face::after { opacity: 1; }
    #{{ $uid }} .bn-card:hover .bn-face { box-shadow: 0 30px 60px -28px color-mix(in srgb, var(--acc) 60%, rgba(0,0,0,.6)); }
    #{{ $uid }}[data-tilt="0"] .bn-card:hover .bn-face { transform: translateY(-4px); }
    #{{ $uid }} .bn-card:focus-visible .bn-face { box-shadow: 0 0 0 3px var(--acc); }

    #{{ $uid }} .bn-blob { position: absolute; z-index: -1; right: -16%; bottom: -34%; width: 64%; aspect-ratio: 1; border-radius: 50%; pointer-events: none; opacity: var(--bo); filter: blur(34px); background: radial-gradient(circle, var(--blob), transparent 70%); animation: bn-drift 9s ease-in-out infinite alternate; }
    #{{ $uid }} .bn-card:nth-child(even) .bn-blob { right: auto; left: -18%; top: -34%; bottom: auto; animation-duration: 12s; }

    #{{ $uid }} .bn-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    #{{ $uid }} .bn-left { display: flex; align-items: center; gap: 10px; min-width: 0; flex-wrap: wrap; }
    #{{ $uid }} .bn-ico { position: relative; display: grid; place-items: center; width: 46px; height: 46px; border-radius: 15px; flex: none; background: color-mix(in srgb, var(--cfg) 9%, transparent); border: 1px solid var(--cline); animation: bn-float 5s ease-in-out infinite alternate; }
    #{{ $uid }} .bn-ico::after { content: ''; position: absolute; inset: -1px; border-radius: inherit; border: 1px solid var(--cfg); opacity: 0; animation: bn-ring 3.6s ease-out infinite; }
    #{{ $uid }} .bn-ico svg { width: 24px; height: 24px; }
    #{{ $uid }} .bn-badge { padding: 4px 11px; border-radius: 99px; font-size: .7rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; background: color-mix(in srgb, var(--cfg) 12%, transparent); border: 1px solid var(--cline); }
    #{{ $uid }} .bn-arrow { display: grid; place-items: center; flex: none; width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--cline); background: color-mix(in srgb, var(--cfg) 6%, transparent); transition: transform .45s cubic-bezier(.34,1.56,.64,1), background .3s ease, color .3s ease, border-color .3s ease; }
    #{{ $uid }} .bn-arrow svg { width: 16px; height: 16px; transition: transform .45s cubic-bezier(.34,1.56,.64,1); }
    #{{ $uid }} .bn-card:hover .bn-arrow, #{{ $uid }} .bn-card:focus-visible .bn-arrow { background: var(--cfg); color: var(--cbgsolid, #0b0d1f); border-color: var(--cfg); transform: translate(3px, -3px) scale(1.08); }
    #{{ $uid }} .bn-card:hover .bn-arrow svg { transform: rotate(45deg); }
    #{{ $uid }} .bn-face.v-soft .bn-arrow, #{{ $uid }} .bn-face.v-light .bn-arrow { --cbgsolid: var(--bg-contrast, #fff); }
    #{{ $uid }}[data-theme="dark"] .bn-face.v-soft { --bg-contrast: #12162e; }
    #{{ $uid }}[data-theme="light"] .bn-face.v-soft { --bg-contrast: #f5f5f7; }
    #{{ $uid }} .bn-face.v-light { --bg-contrast: #fff; }
    #{{ $uid }} .bn-face.v-accent .bn-arrow, #{{ $uid }} .bn-face.v-gradient .bn-arrow { --cbgsolid: var(--acc); }

    #{{ $uid }} .bn-bot { margin-top: auto; padding-top: 18px; min-width: 0; }
    #{{ $uid }} .bn-num { max-width: 100%; white-space: nowrap; font-weight: 800; letter-spacing: -.035em; line-height: 1; font-variant-numeric: tabular-nums; background: linear-gradient(135deg, var(--cfg), color-mix(in srgb, var(--cfg) 62%, var(--acc2))); -webkit-background-clip: text; background-clip: text; color: transparent; }
    #{{ $uid }} .s-1x1 .bn-num { font-size: clamp(2.1rem, 4.2vw, 3.1rem); }
    #{{ $uid }} .s-2x1 .bn-num, #{{ $uid }} .s-1x2 .bn-num { font-size: clamp(2.6rem, 5.4vw, 4rem); }
    #{{ $uid }} .s-2x2 .bn-num { font-size: clamp(3.4rem, 8vw, 6.4rem); }
    #{{ $uid }} .bn-t { margin: 10px 0 0; font-size: 1.05rem; font-weight: 700; line-height: 1.3; }
    #{{ $uid }} .bn-num + .bn-t { margin-top: 10px; }
    #{{ $uid }} .bn-t:first-child { margin-top: 0; font-size: clamp(1.25rem, 2.6vw, 1.7rem); letter-spacing: -.02em; }
    #{{ $uid }} .s-2x2 .bn-t { font-size: clamp(1.15rem, 2.4vw, 1.6rem); }
    #{{ $uid }} .bn-p { margin: 6px 0 0; color: var(--cmut); font-size: .92rem; line-height: 1.5; }

    @keyframes bn-shift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
    @keyframes bn-ang { to { --bn-ang: 360deg; } }
    @keyframes bn-drift { from { transform: translate(0, 0) scale(1); } to { transform: translate(-26px, -20px) scale(1.2); } }
    @keyframes bn-float { from { transform: translateY(0) rotate(-2deg); } to { transform: translateY(-6px) rotate(2deg); } }
    @keyframes bn-ring { 0% { opacity: .55; transform: scale(1); } 70%, 100% { opacity: 0; transform: scale(1.5); } }

    #{{ $uid }}[data-anim="0"] *, #{{ $uid }}[data-anim="0"] *::before, #{{ $uid }}[data-anim="0"] *::after { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01s !important; transition-delay: 0s !important; }
    }
    @media (max-width: 960px) {
        #{{ $uid }} .bn-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .bn-face { padding: 16px; }
        #{{ $uid }} .bn-ico { width: 40px; height: 40px; border-radius: 13px; }
        #{{ $uid }} .bn-ico svg { width: 21px; height: 21px; }
        #{{ $uid }} .bn-arrow { width: 34px; height: 34px; }
        #{{ $uid }} .s-1x1 .bn-num { font-size: clamp(1.8rem, 9vw, 2.4rem); }
        #{{ $uid }} .s-2x1 .bn-num, #{{ $uid }} .s-1x2 .bn-num { font-size: clamp(2.2rem, 11vw, 3rem); }
        #{{ $uid }} .s-2x2 .bn-num { font-size: clamp(2.8rem, 15vw, 4.2rem); }
        #{{ $uid }} .bn-p { font-size: .86rem; }
    }
    @media (max-width: 440px) {
        #{{ $uid }} .bn-grid { grid-template-columns: minmax(0, 1fr); }
        #{{ $uid }} .s-2x1, #{{ $uid }} .s-2x2 { grid-column: span 1; }
        #{{ $uid }} .s-1x2, #{{ $uid }} .s-2x2 { grid-row: span 1; }
        #{{ $uid }} .s-1x1 .bn-num { font-size: clamp(2.2rem, 13vw, 3rem); }
    }
</style>

<section id="{{ $uid }}" class="bn" data-theme="{{ $o['theme'] }}" data-align="{{ $o['align'] }}" data-anim="{{ $o['animate'] ? '1' : '0' }}" data-tilt="{{ $o['tilt'] ? '1' : '0' }}" data-spot="{{ $o['spotlight'] ? '1' : '0' }}"
    style="--acc: {{ $o['accent'] }}; --acc2: {{ $o['accent2'] }}; --cols: {{ $o['columns'] }}; --gap: {{ $o['gap'] }}px; --rad: {{ $o['radius'] }}px; --row: {{ $o['row'] }}px;">

    @if ($o['title'] !== '' || $o['subtitle'] !== '')
        <header class="bn-head">
            @if ($o['title'] !== '')<h2 class="bn-h">{{ $o['title'] }}</h2>@endif
            @if ($o['subtitle'] !== '')<p class="bn-sub">{{ $o['subtitle'] }}</p>@endif
        </header>
    @endif

    <div class="bn-grid">
        @foreach ($cards as $c)
            <{{ $c['tag'] }} class="bn-card s-{{ $c['size'] }}" style="--d: {{ $c['delay'] }}ms"
                @if ($c['url'] !== '') href="{{ $c['url'] }}" @if ($c['new_tab']) target="_blank" rel="noopener noreferrer" @endif @endif>
                <div class="bn-face v-{{ $c['style'] }}">
                    <span class="bn-blob" aria-hidden="true"></span>

                    @if ($c['icon'] !== '' || $c['badge'] !== '' || $c['arrow'])
                        <div class="bn-top">
                            <div class="bn-left">
                                @if ($c['icon'] !== '')<span class="bn-ico">{!! $c['icon'] !!}</span>@endif
                                @if ($c['badge'] !== '')<span class="bn-badge">{{ $c['badge'] }}</span>@endif
                            </div>
                            @if ($c['arrow'])
                                <span class="bn-arrow" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M8 7h9v9"/></svg>
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="bn-bot">
                        @if ($c['num'] !== null)
                            <div class="bn-num"
                                @if ($c['num']['count']) data-count="{{ $c['num']['to'] }}" data-dec="{{ $c['num']['dec'] }}" data-sep="{{ $c['num']['sep'] ? 1 : 0 }}" data-pre="{{ $c['num']['pre'] }}" data-suf="{{ $c['num']['suf'] }}" @endif>{{ $c['num']['text'] }}</div>
                        @endif
                        @if ($c['title'] !== '')<h3 class="bn-t">{{ $c['title'] }}</h3>@endif
                        @if ($c['text'] !== '')<p class="bn-p">{{ $c['text'] }}</p>@endif
                    </div>
                </div>
            </{{ $c['tag'] }}>
        @endforeach
    </div>
</section>

<script>
(function () {
    var UID = '{{ $uid }}';
    var root = document.getElementById(UID);
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var noAnim = root.dataset.anim !== '1' || reduce;
    var fine = window.matchMedia && matchMedia('(hover: hover) and (pointer: fine)').matches;
    var tilt = root.dataset.tilt === '1' && fine && !noAnim;
    var spot = root.dataset.spot === '1' && fine;
    var cards = [].slice.call(root.querySelectorAll('.bn-card'));

    function fmt(v, dec, sep) {
        return sep ? v.toLocaleString('en-US', { minimumFractionDigits: dec, maximumFractionDigits: dec }) : v.toFixed(dec);
    }
    function setNum(n, v) {
        n.textContent = (n.dataset.pre || '') + fmt(v, parseInt(n.dataset.dec, 10) || 0, n.dataset.sep === '1') + (n.dataset.suf || '');
    }
    function nums(card) { return [].slice.call(card.querySelectorAll('[data-count]')); }

    function count(n) {
        var to = parseFloat(n.dataset.count);
        if (noAnim) { setNum(n, to); return; }
        var t0 = performance.now(), dur = 1700;
        (function step(now) {
            var t = Math.min(1, (now - t0) / dur), e = t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
            setNum(n, to * e);
            if (t < 1) { requestAnimationFrame(step); }
        })(t0);
    }

    function show(c) {
        if (c.classList.contains('in')) { return; }
        c.classList.add('in');
        var d = parseInt(c.style.getPropertyValue('--d'), 10) || 0;
        nums(c).forEach(function (n) { setTimeout(function () { count(n); }, noAnim ? 0 : d + 260); });
    }

    if (!noAnim) {
        cards.forEach(function (c) { nums(c).forEach(function (n) { setNum(n, 0); }); });
    }
    root.classList.add('is-ready');

    if (noAnim || !('IntersectionObserver' in window)) {
        cards.forEach(show);
    } else {
        var io = new IntersectionObserver(function (es) {
            es.forEach(function (en) {
                if (en.isIntersecting) { show(en.target); io.unobserve(en.target); }
            });
        }, { threshold: 0.18, rootMargin: '0px 0px -6% 0px' });
        cards.forEach(function (c) { io.observe(c); });
    }

    if (tilt || spot) {
        cards.forEach(function (c) {
            var f = c.querySelector('.bn-face'), raf = 0;

            c.addEventListener('pointerenter', function (e) {
                if (e.pointerType === 'touch') { return; }
                f.classList.add('moving');
            });
            c.addEventListener('pointermove', function (e) {
                if (e.pointerType === 'touch') { return; }
                var r = c.getBoundingClientRect(), x = e.clientX - r.left, y = e.clientY - r.top;
                if (raf) { cancelAnimationFrame(raf); }
                raf = requestAnimationFrame(function () {
                    if (spot) {
                        f.style.setProperty('--mx', x.toFixed(1) + 'px');
                        f.style.setProperty('--my', y.toFixed(1) + 'px');
                    }
                    if (tilt) {
                        var px = x / r.width - 0.5, py = y / r.height - 0.5;
                        f.style.transform = 'perspective(900px) rotateX(' + (-py * 9).toFixed(2) + 'deg) rotateY(' + (px * 11).toFixed(2) + 'deg) translateY(-3px) scale(1.015)';
                    }
                });
            });
            c.addEventListener('pointerleave', function () {
                if (raf) { cancelAnimationFrame(raf); raf = 0; }
                f.classList.remove('moving');
                f.style.transform = '';
            });
        });
    }
})();
</script>