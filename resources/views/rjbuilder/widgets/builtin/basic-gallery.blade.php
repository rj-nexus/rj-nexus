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
    $total  = count($images);

    $accents = ['#6366f1', '#ec4899', '#14b8a6', '#f59e0b', '#8b5cf6', '#0ea5e9'];

    // ---- Yapboz parçası path generatoru ----
    $D = 0.2;            // çıxıntının dərinliyi (xana ölçüsünə nisbətən)
    $E = 1 + 2 * $D;     // genişlənmiş qutu ölçüsü

    $buildEdge = function ($x0, $y0, $ex, $ey, $s) use ($D, $E) {
        $f = function ($x, $y) use ($D, $E) {
            return sprintf('%.4F %.4F', $x / $E, $y / $E);
        };
        if ($s === 0) {
            return 'L ' . $f($x0 + $ex, $y0 + $ey) . ' ';
        }
        $nx = $ey;
        $ny = -$ex;
        $p = function ($u, $v) use ($x0, $y0, $ex, $ey, $nx, $ny, $s, $D, $f) {
            return $f($x0 + $u * $ex + $s * $v * $D * $nx, $y0 + $u * $ey + $s * $v * $D * $ny);
        };
        return 'L ' . $p(0.38, 0) . ' '
            . 'C ' . $p(0.40, 0.30) . ', ' . $p(0.30, 0.45) . ', ' . $p(0.30, 0.70) . ' '
            . 'C ' . $p(0.30, 1.00) . ', ' . $p(0.42, 1.00) . ', ' . $p(0.50, 1.00) . ' '
            . 'C ' . $p(0.58, 1.00) . ', ' . $p(0.70, 1.00) . ', ' . $p(0.70, 0.70) . ' '
            . 'C ' . $p(0.70, 0.45) . ', ' . $p(0.60, 0.30) . ', ' . $p(0.62, 0) . ' '
            . 'L ' . $p(1, 0) . ' ';
    };

    $hSign = function ($r, $c) { return (($r + $c) % 2 === 0) ? 1 : -1; };
    $vSign = function ($r, $c) { return (($r + $c) % 2 === 0) ? 1 : -1; };

    $paths = [];
    foreach ($images as $i => $img) {
        $r = intdiv($i, 3);
        $c = $i % 3;

        $top    = $r > 0 ? -$vSign($r - 1, $c) : 0;
        $right  = ($c < 2 && $i + 1 < $total) ? $hSign($r, $c) : 0;
        $bottom = ($i + 3 < $total) ? $vSign($r, $c) : 0;
        $left   = $c > 0 ? -$hSign($r, $c - 1) : 0;

        $d = 'M ' . sprintf('%.4F %.4F', $D / $E, $D / $E) . ' ';
        $d .= $buildEdge($D,     $D,     1,  0, $top);
        $d .= $buildEdge(1 + $D, $D,     0,  1, $right);
        $d .= $buildEdge(1 + $D, 1 + $D, -1, 0, $bottom);
        $d .= $buildEdge($D,     1 + $D, 0, -1, $left);
        $d .= 'Z';
        $paths[$i] = $d;
    }
@endphp

@once
<style>
    @keyframes rjBgSnap {
        0%   { opacity: 0; transform: translate(var(--fx), var(--fy)) rotate(var(--fr)) scale(.55); }
        65%  { opacity: 1; transform: translate(0, 0) rotate(0deg) scale(1.06); }
        100% { opacity: 1; transform: none; }
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
        container-type: inline-size;
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

    /* 3 sütunlu grid, parçalar bir-birinə kilidlənir (boşluq yoxdur) */
    #{{ $uid }} .rj-bg-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        width: min(100%, 900px);
        margin: 0 auto;
    }

    #{{ $uid }} .rj-bg-item {
        position: relative;
        aspect-ratio: 1 / 1;
        margin: 0;
        min-width: 0;
        cursor: pointer;
        outline: none;
        z-index: 1;
        filter: drop-shadow(0 0 1px rgba(15,23,42,.55));
        transition: transform .5s cubic-bezier(.34,1.5,.64,1), filter .4s ease;
        animation: rjBgSnap .9s cubic-bezier(.34,1.3,.64,1) var(--d, 0s) backwards;
    }

    /* şəkil xanadan hər tərəfə 20% böyükdür ki, çıxıntılar sığsın */
    #{{ $uid }} .rj-bg-shape {
        position: absolute;
        inset: -20%;
        overflow: hidden;
        background: #e2e8f0;
    }
    #{{ $uid }} .rj-bg-shape img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .9s cubic-bezier(.2,.8,.2,1);
    }

    #{{ $uid }} .rj-bg-shade {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,23,42,.55), rgba(15,23,42,0) 60%);
        opacity: 0;
        transition: opacity .4s ease;
    }

    #{{ $uid }} .rj-bg-zoom {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 48px;
        height: 48px;
        margin: -24px 0 0 -24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        color: #fff;
        background: rgba(255,255,255,.22);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,.45);
        opacity: 0;
        transform: scale(.4) rotate(-90deg);
        transition: opacity .35s ease, transform .55s cubic-bezier(.34,1.56,.64,1);
    }

    #{{ $uid }} .rj-bg-item:hover,
    #{{ $uid }} .rj-bg-item:focus-visible {
        z-index: 5;
        transform: translateY(-8px) scale(1.07) rotate(-1.2deg);
        filter: drop-shadow(0 0 1px var(--a)) drop-shadow(0 18px 18px var(--a));
    }
    #{{ $uid }} .rj-bg-item:hover img,
    #{{ $uid }} .rj-bg-item:focus-visible img { transform: scale(1.12); }
    #{{ $uid }} .rj-bg-item:hover .rj-bg-shade,
    #{{ $uid }} .rj-bg-item:focus-visible .rj-bg-shade { opacity: 1; }
    #{{ $uid }} .rj-bg-item:hover .rj-bg-zoom,
    #{{ $uid }} .rj-bg-item:focus-visible .rj-bg-zoom {
        opacity: 1;
        transform: scale(1) rotate(0deg);
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

    /* Lightbox */
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
        #{{ $uid }} .rj-bg-item:hover,
        #{{ $uid }} .rj-bg-item:focus-visible { transform: scale(1.05); }
        #{{ $uid }} .rj-bg-zoom { display: none; }
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
        {{-- Yapboz parçalarının clip-path təriflərı --}}
        <svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
            <defs>
                @foreach($paths as $i => $d)
                    <clipPath id="{{ $uid }}-c{{ $i }}" clipPathUnits="objectBoundingBox">
                        <path d="{{ $d }}"/>
                    </clipPath>
                @endforeach
            </defs>
        </svg>

        <div class="rj-bg-grid">
            @foreach($images as $i => $img)
                @php
                    $accent = $accents[$i % count($accents)];
                    $fx = ((($i * 37) % 5) - 2) * 70;
                    $fy = ((($i * 53) % 5) - 2) * 70 - 60;
                    $fr = ((($i * 29) % 7) - 3) * 12;
                @endphp
                <figure class="rj-bg-item"
                        style="--a: {{ $accent }}; --d: {{ number_format($i * 0.1, 2, '.', '') }}s; --fx: {{ $fx }}px; --fy: {{ $fy }}px; --fr: {{ $fr }}deg;"
                        data-src="{{ $img }}"
                        tabindex="0"
                        role="button"
                        aria-label="{{ __('Open image') }} {{ $i + 1 }}">
                    <div class="rj-bg-shape" style="clip-path: url(#{{ $uid }}-c{{ $i }}); -webkit-clip-path: url(#{{ $uid }}-c{{ $i }});">
                        <img src="{{ $img }}" alt="" loading="lazy">
                        <span class="rj-bg-shade"></span>
                        <span class="rj-bg-zoom">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </span>
                    </div>
                </figure>
            @endforeach
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
        el.addEventListener('click', function () { open(i); });
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                open(i);
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
