@php
    $title    = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $images = [];
    if (!empty($settings['images']) && is_array($settings['images'])) {
        foreach ($settings['images'] as $row) {
            $images[] = is_array($row) ? ($row['image'] ?? '') : $row;
        }
    } else {
        for ($i = 1; $i <= 20; $i++) {
            if (!empty($settings['img_' . $i])) {
                $images[] = $settings['img_' . $i];
            }
        }
    }
    $images = array_values(array_filter($images));
    $n = count($images);

    $accents = ['#6366f1', '#ec4899', '#14b8a6', '#f59e0b', '#8b5cf6', '#0ea5e9'];

    $S = 100;
    $R = (int) ceil($n / 3);

    $V = [];
    for ($r = 0; $r <= $R; $r++) {
        for ($c = 0; $c <= 3; $c++) {
            $jx = ((($r * 7 + $c * 13) % 5) - 2) * 6;
            $jy = ((($r * 11 + $c * 5) % 5) - 2) * 6;
            $V[$r][$c] = [
                $c * $S + (($c == 0 || $c == 3) ? 0 : $jx),
                $r * $S + (($r == 0 || $r == $R) ? 0 : $jy),
            ];
        }
    }

    $hb = [];
    $vb = [];
    for ($r = 0; $r <= $R; $r++) {
        for ($c = 0; $c < 3; $c++) {
            if ($r == 0 || $r == $R) {
                $hb[$r][$c] = [0, 0];
            } else {
                $k  = ($r * 5 + $c * 3) % 4;
                $s  = (($r + $c) % 2) ? 1 : -1;
                $b1 = $s * (20 + $k * 4);
                $hb[$r][$c] = [$b1, $b1 * (($k % 3 == 0) ? -0.6 : 0.9)];
            }
        }
    }
    for ($r = 0; $r < $R; $r++) {
        for ($c = 0; $c <= 3; $c++) {
            if ($c == 0 || $c == 3) {
                $vb[$r][$c] = [0, 0];
            } else {
                $k  = ($r * 3 + $c * 7 + 1) % 4;
                $s  = (($r + $c) % 2) ? -1 : 1;
                $b1 = $s * (20 + $k * 4);
                $vb[$r][$c] = [$b1, $b1 * (($k % 2 == 0) ? -0.6 : 0.9)];
            }
        }
    }

    $f = function ($p) { return sprintf('%.2F %.2F', $p[0], $p[1]); };

    $seg = function ($P, $Q, $b, $rev) use ($f) {
        $dx = $Q[0] - $P[0];
        $dy = $Q[1] - $P[1];
        $len = sqrt($dx * $dx + $dy * $dy) ?: 1;
        $nx = -$dy / $len;
        $ny = $dx / $len;
        $c1 = [$P[0] + $dx * .33 + $nx * $b[0], $P[1] + $dy * .33 + $ny * $b[0]];
        $c2 = [$P[0] + $dx * .67 + $nx * $b[1], $P[1] + $dy * .67 + $ny * $b[1]];
        return $rev
            ? 'C ' . $f($c2) . ', ' . $f($c1) . ', ' . $f($P) . ' '
            : 'C ' . $f($c1) . ', ' . $f($c2) . ', ' . $f($Q) . ' ';
    };

    $cells = [];
    $idx = 0;
    for ($r = 0; $r < $R; $r++) {
        $k = min(3, $n - $r * 3);
        $groups = $k == 3 ? [[0, 1], [1, 2], [2, 3]] : ($k == 2 ? [[0, 2], [2, 3]] : [[0, 3]]);
        foreach ($groups as $g) {
            [$a, $b] = $g;
            $d = 'M ' . $f($V[$r][$a]) . ' ';
            for ($c = $a; $c < $b; $c++) {
                $d .= $seg($V[$r][$c], $V[$r][$c + 1], $hb[$r][$c], false);
            }
            $d .= $seg($V[$r][$b], $V[$r + 1][$b], $vb[$r][$b], false);
            for ($c = $b - 1; $c >= $a; $c--) {
                $d .= $seg($V[$r + 1][$c], $V[$r + 1][$c + 1], $hb[$r + 1][$c], true);
            }
            $d .= $seg($V[$r][$a], $V[$r + 1][$a], $vb[$r][$a], true);
            $d .= 'Z';

            $cells[] = [
                'd' => $d,
                'x' => $a * $S - 40,
                'y' => $r * $S - 40,
                'w' => ($b - $a) * $S + 80,
                'h' => $S + 80,
                'img' => $images[$idx],
            ];
            $idx++;
        }
    }
    $VH = $R * $S;
@endphp

@once
<style>
    @keyframes rjBgRise {
        from { opacity: 0; transform: scale(.85); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjBgFade {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes rjBgSwap {
        from { opacity: 0; transform: scale(.94); }
        to   { opacity: 1; transform: scale(1); }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        position: relative;
        width: 100%;
        padding: 40px 16px;
        overflow: hidden;
    }

    #{{ $uid }} .rj-bg-head {
        text-align: center;
        margin-bottom: 44px;
    }
    #{{ $uid }} .rj-bg-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #6366f1;
        margin: 0 0 10px;
        animation: rjBgFade .8s ease backwards;
    }
    #{{ $uid }} .rj-bg-title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
        margin: 0;
        animation: rjBgFade .8s .1s ease backwards;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-bg-title { font-size: 44px; }
    }

    #{{ $uid }} .rj-bg-wrap {
        width: min(100%, 1100px);
        margin: 0 auto;
        border-radius: 32px;
        overflow: hidden;
        background: #e2e8f0;
        box-shadow: 0 30px 60px -25px rgba(15,23,42,.5);
    }
    #{{ $uid }} .rj-bg-svg {
        display: block;
        width: 100%;
        height: auto;
    }

    #{{ $uid }} .rj-bg-item {
        cursor: pointer;
        outline: none;
        transform-box: fill-box;
        transform-origin: center;
        transition: transform .6s cubic-bezier(.34,1.4,.64,1), filter .4s ease;
        animation: rjBgRise .9s cubic-bezier(.34,1.3,.64,1) var(--d, 0s) backwards;
    }
    #{{ $uid }} .rj-bg-item image {
        transition: opacity .4s ease;
    }
    #{{ $uid }} .rj-bg-edge {
        fill: none;
        stroke: rgba(255,255,255,.85);
        stroke-width: 1;
        stroke-linejoin: round;
        transition: stroke .4s ease, stroke-width .4s ease;
        pointer-events: none;
    }
    #{{ $uid }} .rj-bg-item:hover,
    #{{ $uid }} .rj-bg-item:focus-visible {
        transform: scale(1.05);
        filter: drop-shadow(0 14px 16px rgba(15,23,42,.45));
    }
    #{{ $uid }} .rj-bg-item:hover .rj-bg-edge,
    #{{ $uid }} .rj-bg-item:focus-visible .rj-bg-edge {
        stroke: var(--a);
        stroke-width: 2.2;
    }

    #{{ $uid }} .rj-bg-empty {
        max-width: 640px;
        margin: 0 auto;
        padding: 40px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 24px;
    }

    #{{ $uid }} .rj-bg-lb {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 32px;
        background: rgba(2,6,23,.92);
        backdrop-filter: blur(10px);
    }
    #{{ $uid }} .rj-bg-lb.is-open {
        display: flex;
        animation: rjBgFade .35s ease both;
    }
    #{{ $uid }} .rj-bg-lb-img {
        max-width: 100%;
        max-height: 88vh;
        object-fit: contain;
        border-radius: 28px;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.7);
    }
    #{{ $uid }} .rj-bg-lb-img.is-swap {
        animation: rjBgSwap .45s cubic-bezier(.2,.8,.2,1) both;
    }
    #{{ $uid }} .rj-bg-btn {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 999px;
        color: #fff;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        cursor: pointer;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1), background .3s ease;
    }
    #{{ $uid }} .rj-bg-btn:hover {
        background: rgba(255,255,255,.25);
        transform: scale(1.1);
    }
    #{{ $uid }} .rj-bg-close { top: 24px; right: 24px; }
    #{{ $uid }} .rj-bg-prev  { left: 24px; top: 50%; margin-top: -26px; }
    #{{ $uid }} .rj-bg-next  { right: 24px; top: 50%; margin-top: -26px; }
    #{{ $uid }} .rj-bg-count {
        position: absolute;
        left: 50%;
        bottom: 24px;
        transform: translateX(-50%);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1em;
        color: rgba(255,255,255,.7);
    }

    @media (max-width: 640px) {
        #{{ $uid }} { padding: 28px 10px; }
        #{{ $uid }} .rj-bg-wrap { border-radius: 20px; }
        #{{ $uid }} .rj-bg-prev  { left: 10px; }
        #{{ $uid }} .rj-bg-next  { right: 10px; }
        #{{ $uid }} .rj-bg-close { top: 12px; right: 12px; }
        #{{ $uid }} .rj-bg-lb    { padding: 16px; }
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }},
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}">
    @if($title || $subtitle)
        <header class="rj-bg-head">
            @if($subtitle)
                <p class="rj-bg-sub">{{ $subtitle }}</p>
            @endif
            @if($title)
                <h2 class="rj-bg-title">{{ $title }}</h2>
            @endif
        </header>
    @endif

    @if(!empty($images))
        <div class="rj-bg-wrap">
            <svg class="rj-bg-svg" viewBox="0 0 300 {{ $VH }}" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    @foreach($cells as $i => $cell)
                        <clipPath id="{{ $uid }}-c{{ $i }}">
                            <path d="{{ $cell['d'] }}"/>
                        </clipPath>
                    @endforeach
                </defs>
                @foreach($cells as $i => $cell)
                    <g class="rj-bg-item"
                       style="--a: {{ $accents[$i % count($accents)] }}; --d: {{ number_format($i * 0.1, 2, '.', '') }}s;"
                       data-src="{{ $cell['img'] }}"
                       data-index="{{ $i }}"
                       tabindex="0"
                       role="button"
                       aria-label="{{ __('Open image') }} {{ $i + 1 }}">
                        <g clip-path="url(#{{ $uid }}-c{{ $i }})">
                            <image href="{{ $cell['img'] }}"
                                   x="{{ $cell['x'] }}" y="{{ $cell['y'] }}"
                                   width="{{ $cell['w'] }}" height="{{ $cell['h'] }}"
                                   preserveAspectRatio="xMidYMid slice"/>
                        </g>
                        <path class="rj-bg-edge" d="{{ $cell['d'] }}"/>
                    </g>
                @endforeach
            </svg>
        </div>
    @else
        <div class="rj-bg-empty">{{ __('Please select at least one image for the gallery.') }}</div>
    @endif

    <div class="rj-bg-lb" role="dialog" aria-modal="true">
        <button type="button" class="rj-bg-btn rj-bg-close" data-close aria-label="{{ __('Close') }}">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button type="button" class="rj-bg-btn rj-bg-prev" data-prev aria-label="{{ __('Previous') }}">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
        </button>
        <img class="rj-bg-lb-img" src="" alt="">
        <button type="button" class="rj-bg-btn rj-bg-next" data-next aria-label="{{ __('Next') }}">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
        </button>
        <span class="rj-bg-count"></span>
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@json($uid));
    if (!root) return;

    var lb    = root.querySelector('.rj-bg-lb');
    var img   = lb ? lb.querySelector('.rj-bg-lb-img') : null;
    var count = lb ? lb.querySelector('.rj-bg-count') : null;
    if (!lb || !img) return;

    var items = Array.prototype.slice.call(root.querySelectorAll('.rj-bg-item'));
    var srcs  = items.map(function (el) { return el.getAttribute('data-src'); });
    var current = 0;
    var startX  = null;

    function show(i) {
        current = (i + srcs.length) % srcs.length;
        img.classList.remove('is-swap');
        void img.offsetWidth;
        img.src = srcs[current];
        img.classList.add('is-swap');
        if (count) count.textContent = (current + 1) + ' / ' + srcs.length;
    }

    function open(i) {
        show(i);
        lb.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lb.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    items.forEach(function (el, i) {
        el.addEventListener('pointerenter', function () {
            if (el.parentNode && el.parentNode.lastElementChild !== el) {
                el.parentNode.appendChild(el);
            }
        });
        el.addEventListener('click', function () { open(i); });
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                open(i);
            }
        });
        el.addEventListener('focus', function () {
            if (el.parentNode && el.parentNode.lastElementChild !== el) {
                el.parentNode.appendChild(el);
                el.focus({ preventScroll: true });
            }
        });
    });

    lb.addEventListener('click', function (e) {
        if (e.target === lb || e.target.closest('[data-close]')) close();
    });

    var prev = lb.querySelector('[data-prev]');
    var next = lb.querySelector('[data-next]');
    if (prev) prev.addEventListener('click', function (e) { e.stopPropagation(); show(current - 1); });
    if (next) next.addEventListener('click', function (e) { e.stopPropagation(); show(current + 1); });

    img.addEventListener('click', function (e) { e.stopPropagation(); });

    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('is-open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });

    lb.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
    }, { passive: true });

    lb.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 50) {
            if (dx < 0) show(current + 1); else show(current - 1);
        }
        startX = null;
    }, { passive: true });
})();
</script>
