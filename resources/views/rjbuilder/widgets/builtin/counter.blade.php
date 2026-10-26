@php
    $cols = max(1, min(6, (int) ($settings['columns'] ?? 3)));
    $mdCols = min(2, $cols);

    $style = (string) ($settings['style'] ?? 'light');
    if (!in_array($style, ['light', 'dark', 'transparent'], true)) {
        $style = 'light';
    }

    $accent = (string) ($settings['accent_color'] ?? '');
    if (!preg_match('/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/i', $accent)) {
        $accent = '#8b5cf6';
    }

    $hex = ltrim($accent, '#');
    if (strlen($hex) === 3) {
        $hex = preg_replace('/(.)/', '$1$1', $hex);
    }
    $rgb = hexdec(substr($hex, 0, 2)) . ',' . hexdec(substr($hex, 2, 2)) . ',' . hexdec(substr($hex, 4, 2));

    $duration = max(600, min(8000, (int) ($settings['duration'] ?? 2000)));
@endphp

<style>
    @property --rjc-fill { syntax: '<number>'; inherits: false; initial-value: 0; }

    #{{ $uid }} { position: relative; isolation: isolate; overflow: hidden; width: 100%; padding: clamp(28px, 4vw, 48px) 0; --acc: {{ $accent }}; --rgb: {{ $rgb }}; --dur: {{ $duration }}ms; --fg: #0f172a; --muted: #64748b; --cbg: rgba(255, 255, 255, .72); --cbc: rgba(15, 23, 42, .08); --csh: 0 1px 2px rgba(15, 23, 42, .04), 0 18px 36px -22px rgba(15, 23, 42, .2); --sbg: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%); background: var(--sbg); }
    #{{ $uid }}[data-style="dark"] { --fg: #ffffff; --muted: #94a3b8; --cbg: rgba(255, 255, 255, .04); --cbc: rgba(255, 255, 255, .1); --csh: 0 18px 36px -22px rgba(0, 0, 0, .6); --sbg: radial-gradient(1100px 380px at 50% -12%, rgba(var(--rgb), .24), transparent 62%), #020617; }
    #{{ $uid }}[data-style="transparent"] { --sbg: transparent; --cbg: rgba(255, 255, 255, .55); }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    /* ---------- Background ---------- */
    #{{ $uid }} .rjc-bg { position: absolute; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
    #{{ $uid }}[data-style="transparent"] .rjc-bg { display: none; }
    #{{ $uid }} .rjc-pattern { position: absolute; inset: 0; background-image: radial-gradient(rgba(var(--rgb), .2) 1px, transparent 1.3px); background-size: 24px 24px; -webkit-mask-image: radial-gradient(ellipse at center, #000 15%, transparent 72%); mask-image: radial-gradient(ellipse at center, #000 15%, transparent 72%); }
    #{{ $uid }} .rjc-blob { position: absolute; border-radius: 50%; filter: blur(70px); }
    #{{ $uid }} .rjc-b1 { width: 340px; height: 340px; left: -110px; top: -130px; background: rgba(var(--rgb), .34); opacity: .55; animation: rjc-drift 16s ease-in-out infinite alternate; }
    #{{ $uid }} .rjc-b2 { width: 300px; height: 300px; right: -90px; bottom: -130px; background: rgba(var(--rgb), .26); opacity: .55; animation: rjc-drift 20s ease-in-out -6s infinite alternate-reverse; }
    #{{ $uid }}[data-style="dark"] .rjc-blob { opacity: .4; }

    /* ---------- Grid ---------- */
    #{{ $uid }} .rjc-wrap { position: relative; z-index: 1; width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 clamp(12px, 4vw, 32px); }
    #{{ $uid }} .rjc-grid { --cols: {{ $mdCols }}; --gap: 12px; display: flex; flex-wrap: wrap; justify-content: center; gap: var(--gap); }
    #{{ $uid }} .rjc-card { flex: 0 0 calc((100% - (var(--cols) - 1) * var(--gap)) / var(--cols)); min-width: 0; }
    @media (min-width: 768px) { #{{ $uid }} .rjc-grid { --cols: {{ $mdCols }}; --gap: 16px; } }
    @media (min-width: 1024px) { #{{ $uid }} .rjc-grid { --cols: {{ $cols }}; --gap: 18px; } }

    /* ---------- Card ---------- */
    #{{ $uid }} .rjc-inner { position: relative; height: 100%; display: flex; flex-direction: column; align-items: center; padding: 20px 14px 18px; overflow: hidden; text-align: center; border-radius: 20px; background: var(--cbg); border: 1px solid var(--cbc); box-shadow: var(--csh); -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px); transform: perspective(900px) rotateX(var(--rx, 0deg)) rotateY(var(--ry, 0deg)); transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease; will-change: transform; }
    #{{ $uid }} .rjc-inner:hover { border-color: rgba(var(--rgb), .35); box-shadow: var(--csh), 0 16px 40px -18px rgba(var(--rgb), .45); }
    #{{ $uid }} .rjc-inner::before { content: ""; position: absolute; inset: 0; background: radial-gradient(280px circle at var(--mx, 50%) var(--my, 0%), rgba(var(--rgb), .16), transparent 65%); opacity: 0; transition: opacity .35s ease; pointer-events: none; }
    #{{ $uid }} .rjc-inner::after { content: ""; position: absolute; inset: 0; padding: 1.5px; border-radius: inherit; background: radial-gradient(200px circle at var(--mx, 50%) var(--my, 0%), rgba(var(--rgb), .95), transparent 70%); -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0); opacity: 0; transition: opacity .35s ease; pointer-events: none; }
    #{{ $uid }} .rjc-inner:hover::before, #{{ $uid }} .rjc-inner:hover::after { opacity: 1; }
    #{{ $uid }} .rjc-inner > * { position: relative; z-index: 1; }
    #{{ $uid }} .rjc-inner > .rjc-ghost { position: absolute; z-index: 0; }

    #{{ $uid }} .rjc-ghost { top: 4px; right: 12px; font-size: 3.4rem; font-weight: 900; line-height: 1; letter-spacing: -.05em; color: transparent; -webkit-text-stroke: 1.3px rgba(var(--rgb), .22); pointer-events: none; user-select: none; transition: transform .5s cubic-bezier(.2, .8, .2, 1), -webkit-text-stroke-color .35s ease; }
    #{{ $uid }} .rjc-inner:hover .rjc-ghost { transform: translateY(-4px) scale(1.08); -webkit-text-stroke-color: rgba(var(--rgb), .5); }

    /* ---------- Icon + charging ring ---------- */
    #{{ $uid }} .rjc-ring { position: relative; width: 58px; height: 58px; margin-bottom: 10px; display: grid; place-items: center; border-radius: 50%; animation: rjc-float 4.5s ease-in-out infinite; animation-delay: calc(var(--i, 0) * -.8s); }
    #{{ $uid }} .rjc-ring::before { content: ""; position: absolute; inset: 0; border-radius: 50%; --rjc-fill: 100; background: conic-gradient(var(--acc) calc(var(--rjc-fill) * 1%), rgba(var(--rgb), .14) 0); -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 3px), #000 calc(100% - 2px)); mask: radial-gradient(farthest-side, transparent calc(100% - 3px), #000 calc(100% - 2px)); }
    #{{ $uid }} .rjc-icon { position: relative; width: 42px; height: 42px; display: grid; place-items: center; border-radius: 50%; color: var(--acc); background: rgba(var(--rgb), .12); transition: transform .45s cubic-bezier(.34, 1.56, .64, 1), background-color .3s ease; }
    #{{ $uid }} .rjc-icon svg { width: 22px; height: 22px; display: block; }
    #{{ $uid }} .rjc-inner:hover .rjc-icon { transform: scale(1.12) rotate(-6deg); background: rgba(var(--rgb), .2); }

    /* ---------- Number (odometer) ---------- */
    #{{ $uid }} .rjc-value { display: flex; align-items: flex-end; justify-content: center; gap: 2px; margin: 0; color: var(--fg); font-size: clamp(1.9rem, 4.2vw, 3rem); font-weight: 800; line-height: 1.1; letter-spacing: -.03em; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .rjc-num { display: inline-flex; align-items: flex-start; height: 1.1em; line-height: 1.1; overflow: hidden; }
    #{{ $uid }} .rjc-d { display: inline-block; height: 1.1em; overflow: hidden; vertical-align: top; }
    #{{ $uid }} .rjc-strip { display: block; will-change: transform; }
    #{{ $uid }} .rjc-strip i { display: block; height: 1.1em; line-height: 1.1; font-style: normal; }
    #{{ $uid }} .rjc-c { display: inline-block; height: 1.1em; line-height: 1.1; }
    #{{ $uid }} .rjc-suffix { display: inline-block; margin: 0 0 .126em 2px; font-size: .62em; font-weight: 800; line-height: 1.1; color: var(--acc); }

    #{{ $uid }} .rjc-bar { display: block; width: 28px; height: 3px; margin: 8px auto 8px; border-radius: 3px; background: var(--acc); }
    #{{ $uid }} .rjc-label { margin: 0; color: var(--muted); font-size: .7rem; font-weight: 700; line-height: 1.35; letter-spacing: .16em; text-transform: uppercase; }

    /* ---------- Reveal (only when JS is running) ---------- */
    #{{ $uid }}.rjc-js .rjc-card { opacity: 0; transform: translate3d(0, 32px, 0) scale(.95); }
    #{{ $uid }}.rjc-js.rjc-in .rjc-card { opacity: 1; transform: none; transition: opacity .8s ease, transform .9s cubic-bezier(.2, .8, .2, 1); transition-delay: calc(var(--i, 0) * 120ms); }

    #{{ $uid }}.rjc-js .rjc-bar { width: 0; }
    #{{ $uid }}.rjc-js.rjc-in .rjc-bar { width: 28px; transition: width .8s cubic-bezier(.2, .8, .2, 1); transition-delay: calc(var(--i, 0) * 120ms + 600ms); }

    #{{ $uid }}.rjc-js .rjc-ring::before { --rjc-fill: 0; }
    #{{ $uid }}.rjc-js.rjc-in .rjc-ring::before { animation: rjc-fill var(--dur) cubic-bezier(.16, 1, .3, 1) forwards; animation-delay: calc(var(--i, 0) * 120ms + 300ms); }

    /* ---------- Finish effects ---------- */
    #{{ $uid }} .rjc-card.rjc-done .rjc-ring::after { content: ""; position: absolute; inset: -3px; border: 2px solid var(--acc); border-radius: 50%; animation: rjc-burst .9s ease-out forwards; pointer-events: none; }
    #{{ $uid }} .rjc-card.rjc-done .rjc-suffix { animation: rjc-pop .65s cubic-bezier(.34, 1.56, .64, 1); }
    #{{ $uid }} .rjc-card.rjc-done .rjc-value { animation: rjc-glow 1.2s ease-out; }

    /* ---------- Keyframes ---------- */
    @keyframes rjc-drift { to { transform: translate3d(60px, 40px, 0) scale(1.15); } }
    @keyframes rjc-float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
    @keyframes rjc-fill { to { --rjc-fill: 100; } }
    @keyframes rjc-burst { from { opacity: .9; transform: scale(.92); } to { opacity: 0; transform: scale(1.4); } }
    @keyframes rjc-pop { 0% { transform: scale(1); } 40% { transform: scale(1.55) rotate(-8deg); } 100% { transform: scale(1); } }
    @keyframes rjc-glow { 0%, 100% { text-shadow: 0 0 0 rgba(var(--rgb), 0); } 45% { text-shadow: 0 0 32px rgba(var(--rgb), .6); } }

    @media (max-width: 640px) {
        #{{ $uid }} .rjc-inner { padding: 16px 10px 14px; border-radius: 16px; }
        #{{ $uid }} .rjc-ring { width: 48px; height: 48px; margin-bottom: 8px; }
        #{{ $uid }} .rjc-icon { width: 34px; height: 34px; }
        #{{ $uid }} .rjc-icon svg { width: 18px; height: 18px; }
        #{{ $uid }} .rjc-ghost { font-size: 2.6rem; right: 8px; }
        #{{ $uid }} .rjc-bar { margin: 6px auto; }
        #{{ $uid }} .rjc-label { font-size: .62rem; letter-spacing: .12em; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition: none !important; }
        #{{ $uid }}.rjc-js .rjc-card { opacity: 1; transform: none; }
        #{{ $uid }}.rjc-js .rjc-bar { width: 28px; }
        #{{ $uid }}.rjc-js .rjc-ring::before { --rjc-fill: 100; }
        #{{ $uid }} .rjc-inner { transform: none; }
    }
</style>

<section id="{{ $uid }}" class="rjc" data-style="{{ $style }}" data-duration="{{ $duration }}">
    <div class="rjc-bg" aria-hidden="true">
        <span class="rjc-pattern"></span>
        <span class="rjc-blob rjc-b1"></span>
        <span class="rjc-blob rjc-b2"></span>
    </div>

    <div class="rjc-wrap">
        <div class="rjc-grid">
            @foreach(($items ?? []) as $item)
                @php
                    $numRaw = (string) ($item['number'] ?? '0');
                    $clean = preg_replace('/[^0-9.]/', '', $numRaw);
                    if ($clean === '' || $clean === '.') {
                        $clean = '0';
                    }
                    $dec = str_contains($clean, '.') ? strlen(substr($clean, strrpos($clean, '.') + 1)) : 0;
                    $fallback = str_contains($numRaw, ',') ? number_format((float) $clean, $dec) : $clean;
                @endphp

                <div class="rjc-card" style="--i: {{ $loop->index }};">
                    <div class="rjc-inner">
                        <span class="rjc-ghost" aria-hidden="true">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                        @if(!empty($item['icon']))
                            <div class="rjc-ring">
                                <div class="rjc-icon">
                                    {!! rj_icon($item['icon'], 'w-8 h-8') !!}
                                </div>
                            </div>
                        @endif

                        <div class="rjc-value">
                            <span class="rjc-num" data-target="{{ $numRaw }}">{{ $fallback }}</span>
                            @if(!empty($item['suffix']))
                                <span class="rjc-suffix">{{ $item['suffix'] }}</span>
                            @endif
                        </div>

                        <span class="rjc-bar" aria-hidden="true"></span>

                        @if(!empty($item['label']))
                            <p class="rjc-label">{{ $item['label'] }}</p>
                        @endif
                    </div>
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

    var duration = parseInt(root.getAttribute('data-duration'), 10) || 2000;
    var reduce = !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    var hoverOk = !reduce && !!(window.matchMedia && window.matchMedia('(hover: hover)').matches);
    var LH = 1.1;

    var cards = Array.prototype.slice.call(root.querySelectorAll('.rjc-card'));

    function format(el) {
        var raw = el.getAttribute('data-target') || '';
        var clean = raw.replace(/[^0-9.]/g, '');
        var dot = clean.indexOf('.');
        var dec = dot > -1 ? clean.length - dot - 1 : 0;
        var n = parseFloat(clean);
        var s;

        if (isNaN(n) || !isFinite(n) || n >= 1e15) {
            s = clean || '0';
        } else {
            s = n.toFixed(Math.min(dec, 6));
            if (raw.indexOf(',') > -1) {
                var parts = s.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                s = parts.join('.');
            }
        }
        return s;
    }

    // Build odometer columns for every number
    var counters = cards.map(function (card) {
        var el = card.querySelector('.rjc-num');
        if (!el) { return { card: card, cols: [] }; }

        var text = format(el);
        el.setAttribute('role', 'img');
        el.setAttribute('aria-label', text);

        if (reduce) {
            el.textContent = text;
            return { card: card, cols: [] };
        }

        el.textContent = '';
        var cols = [];

        text.split('').forEach(function (ch) {
            if (/\d/.test(ch)) {
                var d = document.createElement('span');
                d.className = 'rjc-d';
                d.setAttribute('aria-hidden', 'true');

                var strip = document.createElement('span');
                strip.className = 'rjc-strip';
                for (var k = 0; k < 30; k++) {
                    var i = document.createElement('i');
                    i.textContent = String(k % 10);
                    strip.appendChild(i);
                }

                d.appendChild(strip);
                el.appendChild(d);
                cols.push({ strip: strip, digit: parseInt(ch, 10) });
            } else {
                var c = document.createElement('span');
                c.className = 'rjc-c';
                c.setAttribute('aria-hidden', 'true');
                c.textContent = ch;
                el.appendChild(c);
            }
        });

        return { card: card, cols: cols };
    });

    function roll(cols, baseDelay) {
        var D = cols.length;
        var longest = 0;

        cols.forEach(function (c, k) {
            var ms = duration * (0.72 + 0.28 * (D > 1 ? (D - 1 - k) / (D - 1) : 1));
            var delay = baseDelay + k * 70;
            var y = (-((20 + c.digit) * LH)).toFixed(2);

            c.strip.style.transition = 'transform ' + Math.round(ms) + 'ms cubic-bezier(.16, 1, .3, 1) ' + delay + 'ms';
            c.strip.style.transform = 'translate3d(0,' + y + 'em,0)';

            longest = Math.max(longest, ms + delay);
        });

        return longest;
    }

    function start() {
        root.classList.add('rjc-in');

        counters.forEach(function (item, i) {
            var base = i * 120 + 300;
            var longest = item.cols.length ? roll(item.cols, base) : base + 400;

            setTimeout(function () {
                item.card.classList.add('rjc-done');
            }, longest);
        });
    }

    // Spotlight + tilt
    if (hoverOk) {
        cards.forEach(function (card) {
            var inner = card.querySelector('.rjc-inner');
            if (!inner) { return; }

            var raf = 0;
            var x = 0, y = 0, w = 1, h = 1;

            inner.addEventListener('pointermove', function (e) {
                if (e.pointerType !== 'mouse') { return; }
                var r = inner.getBoundingClientRect();
                x = e.clientX - r.left;
                y = e.clientY - r.top;
                w = r.width || 1;
                h = r.height || 1;

                if (!raf) {
                    raf = requestAnimationFrame(function () {
                        raf = 0;
                        inner.style.setProperty('--mx', x.toFixed(0) + 'px');
                        inner.style.setProperty('--my', y.toFixed(0) + 'px');
                        inner.style.setProperty('--ry', ((x / w - 0.5) * 9).toFixed(2) + 'deg');
                        inner.style.setProperty('--rx', ((0.5 - y / h) * 9).toFixed(2) + 'deg');
                    });
                }
            });

            inner.addEventListener('pointerleave', function () {
                if (raf) { cancelAnimationFrame(raf); raf = 0; }
                inner.style.setProperty('--rx', '0deg');
                inner.style.setProperty('--ry', '0deg');
            });
        });
    }

    root.classList.add('rjc-js');
    void root.offsetWidth;

    if (reduce || !('IntersectionObserver' in window)) {
        root.classList.add('rjc-in');
        cards.forEach(function (c) { c.classList.add('rjc-done'); });
        return;
    }

    var io = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) {
            io.disconnect();
            start();
        }
    }, { threshold: 0.25 });
    io.observe(root);
})();
</script>
