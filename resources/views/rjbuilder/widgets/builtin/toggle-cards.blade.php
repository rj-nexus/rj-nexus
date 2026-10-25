@php
    $flip = $opts['mode'] === 'flip';
@endphp

<style>
    #{{ $uid }} { --c: {{ $opts['accent'] }}; --card: #fff; --t: #0f172a; --m: #64748b; --bd: #e2e8f0; --bw: 1px; --sh: 0 1px 2px rgba(15,23,42,.04), 0 14px 34px -18px rgba(15,23,42,.22); width: 100%; padding: 48px 16px; }
    #{{ $uid }}[data-style="bordered"] { --card: transparent; --bd: #cbd5e1; --bw: 2px; --sh: none; }
    #{{ $uid }}[data-style="dark"] { --card: #0f172a; --t: #fff; --m: #94a3b8; --bd: rgba(255,255,255,.1); --sh: 0 20px 50px -24px rgba(2,6,23,.8); }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} .rjc-wrap { max-width: 1200px; margin: 0 auto; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjc-head-wrap { margin-bottom: 40px; text-align: center; }
    #{{ $uid }} .rjc-sec-title { margin: 0; padding: 0; font-size: clamp(1.9rem, 4.2vw, 2.8rem); font-weight: 800; line-height: 1.12; letter-spacing: -.03em; color: #0f172a; }
    #{{ $uid }} .rjc-sec-title::after { content: ""; display: block; width: 56px; height: 4px; margin: 18px auto 0; border-radius: 4px; background: var(--c); }
    #{{ $uid }} .rjc-sec-sub { margin: 16px auto 0; max-width: 36rem; color: #64748b; line-height: 1.7; font-size: 1.05rem; }

    /* ---------- Grid ---------- */
    #{{ $uid }} .rjc-grid { display: grid; gap: 24px; align-items: start; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    #{{ $uid }}[data-cols="2"] .rjc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    #{{ $uid }}[data-cols="4"] .rjc-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    #{{ $uid }}[data-mode="flip"] .rjc-grid { align-items: stretch; }
    @media (max-width: 1023px) {
        #{{ $uid }}[data-cols="3"] .rjc-grid, #{{ $uid }}[data-cols="4"] .rjc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 639px) {
        #{{ $uid }} { padding: 32px 12px; }
        #{{ $uid }} .rjc-grid, #{{ $uid }}[data-cols] .rjc-grid { grid-template-columns: minmax(0, 1fr); gap: 16px; }
    }

    /* ---------- Card ---------- */
    #{{ $uid }} .rjc-card { position: relative; perspective: 1400px; transition: transform .45s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjc-card:hover { transform: translateY(-4px); }

    #{{ $uid }} .rjc-flip { position: relative; height: 100%; }
    #{{ $uid }}[data-mode="flip"] .rjc-flip { display: grid; transform-style: preserve-3d; transition: transform .85s cubic-bezier(.4,.2,.2,1); }
    #{{ $uid }}[data-mode="flip"] .rjc-card.is-open .rjc-flip { transform: rotateY(180deg); }

    #{{ $uid }} .rjc-face { position: relative; overflow: hidden; border-radius: 24px; background: var(--card); border: var(--bw) solid var(--bd); box-shadow: var(--sh); color: var(--t); transition: background .5s ease, box-shadow .4s ease, border-color .4s ease; }
    #{{ $uid }}[data-mode="flip"] .rjc-face { grid-area: 1 / 1; min-height: 250px; -webkit-backface-visibility: hidden; backface-visibility: hidden; }
    #{{ $uid }}[data-mode="flip"] .rjc-front { display: flex; flex-direction: column; }
    #{{ $uid }} .rjc-card:hover .rjc-face { border-color: var(--c); border-color: color-mix(in srgb, var(--c) 45%, var(--bd)); }

    /* cursor spotlight */
    #{{ $uid }} .rjc-glow { position: absolute; inset: 0; z-index: 0; pointer-events: none; opacity: 0; transition: opacity .4s ease; background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 50%), color-mix(in srgb, var(--c) 16%, transparent), transparent 65%); }
    #{{ $uid }} .rjc-card:hover .rjc-glow { opacity: 1; }

    /* big number watermark */
    #{{ $uid }} .rjc-num { position: absolute; right: 20px; bottom: -20px; z-index: 0; font-size: 5.5rem; font-weight: 900; line-height: 1; font-variant-numeric: tabular-nums; color: var(--c); opacity: .07; pointer-events: none; user-select: none; transition: transform .6s cubic-bezier(.2,.8,.2,1), opacity .4s ease; }
    #{{ $uid }} .rjc-card:hover .rjc-num { opacity: .13; transform: translateY(-8px); }

    /* ---------- Head button ---------- */
    #{{ $uid }} .rjc-h { position: relative; z-index: 1; margin: 0; padding: 0; font: inherit; }
    #{{ $uid }}[data-mode="flip"] .rjc-h { flex: 1; display: flex; }
    #{{ $uid }} .rjc-head { all: unset; box-sizing: border-box; display: block; width: 100%; padding: 28px; cursor: pointer; -webkit-tap-highlight-color: transparent; }
    #{{ $uid }} .rjc-head:focus-visible { outline: 2px solid var(--c); outline-offset: -4px; border-radius: 24px; }
    #{{ $uid }} .rjc-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }

    #{{ $uid }} .rjc-ico { display: grid; place-items: center; width: 52px; height: 52px; border-radius: 16px; color: var(--c); background: rgba(128,128,128,.12); background: color-mix(in srgb, var(--c) 12%, transparent); transition: transform .5s cubic-bezier(.34,1.56,.64,1), background .35s ease, color .35s ease, box-shadow .35s ease; }
    #{{ $uid }} .rjc-ico svg { width: 26px; height: 26px; }
    #{{ $uid }} .rjc-card:hover .rjc-ico { transform: translateY(-2px) rotate(-6deg) scale(1.06); }
    #{{ $uid }}[data-mode="expand"] .rjc-card.is-open .rjc-ico { background: var(--c); color: #fff; box-shadow: 0 12px 24px -10px var(--c); }

    #{{ $uid }} .rjc-arrow { display: grid; place-items: center; width: 38px; height: 38px; margin-left: auto; border-radius: 50%; border: 1px solid var(--bd); color: var(--m); transition: transform .5s cubic-bezier(.34,1.56,.64,1), background .35s ease, color .35s ease, border-color .35s ease; }
    #{{ $uid }} .rjc-arrow svg { width: 18px; height: 18px; transition: transform .6s cubic-bezier(.4,.2,.2,1); }
    #{{ $uid }}[data-mode="expand"] .rjc-card.is-open .rjc-arrow { transform: rotate(180deg); background: var(--c); border-color: var(--c); color: #fff; }
    #{{ $uid }}[data-mode="flip"] .rjc-card:hover .rjc-arrow svg { transform: rotate(180deg); }
    #{{ $uid }}[data-mode="flip"] .rjc-card:hover .rjc-arrow { border-color: var(--c); color: var(--c); }

    #{{ $uid }} .rjc-title { display: block; font-size: 1.2rem; font-weight: 800; line-height: 1.3; letter-spacing: -.01em; color: var(--t); }
    #{{ $uid }} .rjc-excerpt { display: block; margin-top: 8px; font-size: .95rem; line-height: 1.6; color: var(--m); }

    /* ---------- Expand panel ---------- */
    #{{ $uid }} .rjc-panel { position: relative; z-index: 1; display: grid; grid-template-rows: 0fr; transition: grid-template-rows .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjc-card.is-open .rjc-panel { grid-template-rows: 1fr; }
    #{{ $uid }} .rjc-pin { min-height: 0; overflow: hidden; visibility: hidden; transition: visibility 0s linear .5s; }
    #{{ $uid }} .rjc-card.is-open .rjc-pin { visibility: visible; transition-delay: 0s; }
    #{{ $uid }} .rjc-body { margin: 0 28px; padding: 22px 0 28px; border-top: 1px solid var(--bd); color: var(--m); font-size: .95rem; line-height: 1.75; opacity: 0; transform: translateY(-10px); transition: opacity .3s ease, transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjc-card.is-open .rjc-body { opacity: 1; transform: none; transition-delay: .12s; }

    /* ---------- CTA ---------- */
    #{{ $uid }} .rjc-cta { --cta-bg: var(--c); --cta-fg: #fff; display: inline-flex; align-items: center; gap: 8px; margin-top: 18px; padding: 11px 20px; border-radius: 999px; background: var(--cta-bg); color: var(--cta-fg) !important; font-size: .85rem; font-weight: 700; line-height: 1; text-decoration: none !important; box-shadow: 0 10px 22px -12px var(--c); transition: transform .3s ease, box-shadow .3s ease; }
    #{{ $uid }} .rjc-cta svg { width: 15px; height: 15px; transition: transform .3s ease; }
    #{{ $uid }} .rjc-cta:hover { transform: translateY(-2px); box-shadow: 0 16px 28px -12px var(--c); }
    #{{ $uid }} .rjc-cta:hover svg { transform: translateX(4px); }

    /* ---------- Back face (flip) ---------- */
    #{{ $uid }} .rjc-back { display: flex; flex-direction: column; padding: 28px; transform: rotateY(180deg); border-color: transparent; --t: #fff; --m: rgba(255,255,255,.9); --bd: rgba(255,255,255,.25); background: var(--c); background: linear-gradient(135deg, var(--c), color-mix(in srgb, var(--c) 55%, #7c3aed)); }
    #{{ $uid }} .rjc-back .rjc-ico, #{{ $uid }} .rjc-back .rjc-back-btn { background: rgba(255,255,255,.2); color: #fff; }
    #{{ $uid }} .rjc-back .rjc-cta { --cta-bg: #fff; --cta-fg: var(--c); box-shadow: 0 12px 24px -12px rgba(0,0,0,.4); }
    #{{ $uid }} .rjc-back .rjc-body { margin: 0; padding: 0; border: 0; opacity: 1; transform: none; flex: 1; }
    #{{ $uid }} .rjc-back .rjc-title { margin-bottom: 10px; }
    #{{ $uid }} .rjc-back-btn { all: unset; box-sizing: border-box; display: grid; place-items: center; width: 38px; height: 38px; border-radius: 50%; cursor: pointer; transition: transform .5s ease, background .3s ease; }
    #{{ $uid }} .rjc-back-btn:hover { transform: rotate(-180deg); background: rgba(255,255,255,.32); }
    #{{ $uid }} .rjc-back-btn:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }
    #{{ $uid }} .rjc-back-btn svg { width: 18px; height: 18px; }
    #{{ $uid }} .rjc-back .rjc-top { margin-bottom: 18px; }

    /* ---------- Gradient style (expand mode) ---------- */
    #{{ $uid }}[data-style="gradient"][data-mode="expand"] .rjc-card.is-open .rjc-face { --t: #fff; --m: rgba(255,255,255,.9); --bd: transparent; border-color: transparent; background: var(--c); background: linear-gradient(135deg, var(--c), color-mix(in srgb, var(--c) 55%, #7c3aed)); box-shadow: 0 26px 50px -22px var(--c); }
    #{{ $uid }}[data-style="gradient"][data-mode="expand"] .rjc-card.is-open .rjc-ico, #{{ $uid }}[data-style="gradient"][data-mode="expand"] .rjc-card.is-open .rjc-arrow { background: rgba(255,255,255,.22); color: #fff; border-color: transparent; box-shadow: none; }
    #{{ $uid }}[data-style="gradient"][data-mode="expand"] .rjc-card.is-open .rjc-body { border-top-color: rgba(255,255,255,.28); }
    #{{ $uid }}[data-style="gradient"][data-mode="expand"] .rjc-card.is-open .rjc-cta { --cta-bg: #fff; --cta-fg: var(--c); }
    #{{ $uid }}[data-style="gradient"][data-mode="expand"] .rjc-card.is-open .rjc-num { color: #fff; opacity: .14; }

    /* ---------- Reveal on scroll ---------- */
    #{{ $uid }}.rjc-ready:not(.rjc-in) .rjc-card { opacity: 0; }
    #{{ $uid }}.rjc-in .rjc-card { animation: rjc-rise .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--i, 0) * 80ms + 80ms); }
    @keyframes rjc-rise { from { opacity: 0; transform: translateY(32px) scale(.96); } }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }}.rjc-ready:not(.rjc-in) .rjc-card { opacity: 1; }
    }
</style>

<section id="{{ $uid }}"
         data-style="{{ $opts['style'] }}"
         data-mode="{{ $opts['mode'] }}"
         data-cols="{{ $opts['cols'] }}"
         data-single="{{ $opts['single'] ? '1' : '0' }}"
         data-first="{{ $opts['first'] ? '1' : '0' }}">
    <div class="rjc-wrap">

        @if ($opts['title'] !== '' || $opts['subtitle'] !== '')
            <div class="rjc-head-wrap">
                @if ($opts['title'] !== '')
                    <h2 class="rjc-sec-title">{{ $opts['title'] }}</h2>
                @endif
                @if ($opts['subtitle'] !== '')
                    <p class="rjc-sec-sub">{{ $opts['subtitle'] }}</p>
                @endif
            </div>
        @endif

        <div class="rjc-grid">
            @foreach ($cards as $card)
                @php
                    $n = $loop->iteration;
                    $hasIcon = !empty($card['icon']) && function_exists('rj_icon');
                    $targetId = $uid . ($flip ? '-back' : '-panel') . $n;
                @endphp

                <article class="rjc-card" style="--i: {{ min($loop->index, 11) }};@if(!empty($card['color'])) --c: {{ $card['color'] }};@endif">
                    <div class="rjc-flip">

                        {{-- FRONT --}}
                        <div class="rjc-face rjc-front">
                            <span class="rjc-glow" aria-hidden="true"></span>
                            @if ($opts['numbers'])
                                <span class="rjc-num" aria-hidden="true">{{ sprintf('%02d', $n) }}</span>
                            @endif

                            <h3 class="rjc-h">
                                <button type="button" class="rjc-head" id="{{ $uid }}-h{{ $n }}" aria-expanded="false" aria-controls="{{ $targetId }}">
                                    <span class="rjc-top">
                                        @if ($hasIcon)
                                            <span class="rjc-ico" aria-hidden="true">{!! rj_icon($card['icon'], 'w-6 h-6') !!}</span>
                                        @endif
                                        <span class="rjc-arrow" aria-hidden="true">
                                            @if ($flip)
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                                            @else
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 9l-7 7-7-7"/></svg>
                                            @endif
                                        </span>
                                    </span>
                                    <span class="rjc-title">{{ $card['title'] }}</span>
                                    @if (!empty($card['excerpt']))
                                        <span class="rjc-excerpt">{{ $card['excerpt'] }}</span>
                                    @endif
                                </button>
                            </h3>

                            @unless ($flip)
                                <div class="rjc-panel" id="{{ $targetId }}" role="region" aria-labelledby="{{ $uid }}-h{{ $n }}">
                                    <div class="rjc-pin">
                                        <div class="rjc-body">
                                            @if ($card['text'] !== '')
                                                <div>{!! nl2br(e($card['text'])) !!}</div>
                                            @endif
                                            @if (!empty($card['cta']))
                                                <a class="rjc-cta" href="{{ $card['cta']['url'] }}">
                                                    <span>{{ $card['cta']['label'] }}</span>
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6l6 6-6 6"/></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endunless
                        </div>

                        {{-- BACK (flip mode) --}}
                        @if ($flip)
                            <div class="rjc-face rjc-back" id="{{ $targetId }}" role="region" aria-labelledby="{{ $uid }}-h{{ $n }}">
                                <span class="rjc-glow" aria-hidden="true"></span>
                                <div class="rjc-top" style="position: relative; z-index: 1;">
                                    @if ($hasIcon)
                                        <span class="rjc-ico" aria-hidden="true">{!! rj_icon($card['icon'], 'w-6 h-6') !!}</span>
                                    @endif
                                    <button type="button" class="rjc-back-btn" aria-label="{{ __('Flip back') }}" style="margin-left: auto;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                                    </button>
                                </div>
                                <div style="position: relative; z-index: 1; display: flex; flex-direction: column; flex: 1;">
                                    <span class="rjc-title">{{ $card['title'] }}</span>
                                    <div class="rjc-body">
                                        @if ($card['text'] !== '')
                                            <div>{!! nl2br(e($card['text'])) !!}</div>
                                        @endif
                                    </div>
                                    @if (!empty($card['cta']))
                                        <div>
                                            <a class="rjc-cta" href="{{ $card['cta']['url'] }}">
                                                <span>{{ $card['cta']['label'] }}</span>
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6l6 6-6 6"/></svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var flip = root.dataset.mode === 'flip';
    var single = root.dataset.single === '1';
    var cards = [].slice.call(root.querySelectorAll('.rjc-card'));
    var canHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;

    function setOpen(card, open, focusMove) {
        var head = card.querySelector('.rjc-head');
        card.classList.toggle('is-open', open);
        if (head) { head.setAttribute('aria-expanded', open ? 'true' : 'false'); }

        if (flip) {
            var front = card.querySelector('.rjc-front');
            var back = card.querySelector('.rjc-back');
            if (front) { front.inert = open; }
            if (back) { back.inert = !open; }

            if (focusMove) {
                var target = open ? card.querySelector('.rjc-back-btn') : head;
                if (target) { target.focus({ preventScroll: true }); }
            }
        }
    }

    cards.forEach(function (card) {
        var head = card.querySelector('.rjc-head');
        var backBtn = card.querySelector('.rjc-back-btn');

        setOpen(card, false, false);

        if (head) {
            head.addEventListener('click', function () {
                var open = !card.classList.contains('is-open');
                if (open && single) {
                    cards.forEach(function (o) { if (o !== card && o.classList.contains('is-open')) { setOpen(o, false, false); } });
                }
                setOpen(card, open, true);
            });
        }

        if (backBtn) {
            backBtn.addEventListener('click', function () { setOpen(card, false, true); });
        }

        if (canHover) {
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                card.style.setProperty('--my', (e.clientY - r.top) + 'px');
            });
        }
    });

    root.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') { return; }
        var card = e.target.closest ? e.target.closest('.rjc-card') : null;
        if (card && card.classList.contains('is-open')) { setOpen(card, false, true); }
    });

    if (root.dataset.first === '1' && cards[0]) { setOpen(cards[0], true, false); }

    // Reveal on scroll
    root.classList.add('rjc-ready');
    function show() { root.classList.add('rjc-in'); }
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) { show(); io.disconnect(); }
        }, { threshold: 0.1 });
        io.observe(root);
    } else {
        show();
    }
})();
</script>
