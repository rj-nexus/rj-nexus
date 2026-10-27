@php
    $pick = fn ($v, $allowed, $d) => in_array($v, $allowed, true) ? $v : $d;
    $s    = fn ($k) => trim((string) ($settings[$k] ?? ''));
    $url  = fn ($v) => (trim((string) $v) === '' || preg_match('/^\s*(javascript|data|vbscript):/i', (string) $v)) ? '#' : trim((string) $v);
    $hex  = function ($v, $d) {
        $v = trim((string) $v);
        if (!preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $v)) return $d;
        return strlen($v) === 4 ? '#' . $v[1] . $v[1] . $v[2] . $v[2] . $v[3] . $v[3] : $v;
    };

    $layout  = $pick($settings['layout'] ?? 'split', ['split', 'centered', 'ribbon'], 'split');
    $bg      = $pick($settings['bg_style'] ?? 'gradient', ['gradient', 'solid', 'dark', 'image'], 'gradient');
    $radius  = ['none' => '0px', 'md' => '14px', 'xl' => '22px', '2xl' => '32px'][$pick($settings['radius'] ?? 'xl', ['none', 'md', 'xl', '2xl'], 'xl')];
    $acc     = $hex($settings['accent'] ?? '', '#8b5cf6');
    $acc2    = $hex($settings['accent2'] ?? '', '#ec4899');
    $pad     = max(0, min(240, (int) ($settings['padding_y'] ?? 60)));
    $animate = !empty($settings['animate'] ?? true);
    $shapes  = !empty($settings['show_shapes'] ?? true);

    $badge = $s('badge');
    $title = $s('title');
    $desc  = $s('desc');
    $label = $s('btn_label');
    $href  = $url($settings['btn_url'] ?? '#');
    $image = $s('image') !== '' ? $url($s('image')) : '';
    $code  = $s('coupon');
    $hint  = $s('coupon_hint');

    $bgImage = $s('bg_image');
    if ($bgImage !== '' && (!preg_match('/^(https?:)?\/\/|^\//i', $bgImage) || preg_match('/[\'"()\\\\\s<>]/', $bgImage))) $bgImage = '';

    $titleHtml = e($title);
    if ($s('highlight') !== '' && $title !== '') {
        $titleHtml = str_replace(e($s('highlight')), '<span class="pb-hl">' . e($s('highlight')) . '</span>', $titleHtml);
    }

    $endTs = 0;
    if (!empty($settings['countdown'] ?? false) && $s('countdown_end') !== '') {
        $t = strtotime($s('countdown_end'));
        if ($t !== false) $endTs = $t * 1000;
    }

    $palette = [$acc, $acc2, '#ffffff', '#fde047'];
    $couponBtn = fn ($cls) => '<button type="button" class="' . $cls . '" data-coupon="' . e($code) . '" data-text>' . e($code) . '</button>';
    $isSplit = $layout === 'split';
@endphp

<style>
    #{{ $uid }} { --a: {{ $acc }}; --b: {{ $acc2 }}; width: 100%; padding: {{ $pad }}px 16px; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }

    #{{ $uid }}[data-bg="gradient"] { --bg: linear-gradient(125deg, var(--a), var(--b)); }
    #{{ $uid }}[data-bg="dark"],
    #{{ $uid }}[data-bg="image"] { --bg: #0f172a; }
    #{{ $uid }}[data-bg="gradient"],
    #{{ $uid }}[data-bg="dark"],
    #{{ $uid }}[data-bg="image"] {
        --fg: #fff; --soft: rgba(255,255,255,.16); --line: rgba(255,255,255,.28);
        --btn: #fff; --btn-fg: #0f172a; --hl: linear-gradient(90deg, #fff, rgba(255,255,255,.6), #fff);
    }
    #{{ $uid }}[data-bg="solid"] {
        --bg: #fff; --fg: #0f172a; --soft: rgba(15,23,42,.06); --line: #e5e7eb;
        --btn: var(--a); --btn-fg: #fff; --hl: linear-gradient(90deg, var(--a), var(--b), var(--a));
    }

    #{{ $uid }} .pb-wrap {
        position: relative;
        max-width: 1120px;
        margin: 0 auto;
        padding: {{ $layout === 'ribbon' ? '20px 28px' : '52px 44px' }};
        border-radius: {{ $radius }};
        border: 1px solid var(--line);
        background: var(--bg);
        color: var(--fg);
        overflow: hidden;
        isolation: isolate;
        box-shadow: 0 30px 60px -34px rgba(0,0,0,.4);
    }
    @if($bgImage !== '')
    #{{ $uid }}[data-bg="image"] .pb-wrap {
        background-image: linear-gradient(120deg, rgba(15,23,42,.8), rgba(15,23,42,.55)), url('{{ $bgImage }}');
        background-size: cover;
        background-position: center;
    }
    @endif
    @media (max-width: 720px) { #{{ $uid }} .pb-wrap { padding: {{ $layout === 'ribbon' ? '18px 20px' : '38px 22px' }}; } }

    #{{ $uid }} .pb-shapes { position: absolute; inset: 0; z-index: -1; pointer-events: none; }
    #{{ $uid }} .pb-shapes i { position: absolute; border-radius: 50%; background: #fff; opacity: .3; filter: blur(50px); }
    #{{ $uid }} .pb-shapes i:first-child { width: 260px; height: 260px; top: -80px; left: -60px; }
    #{{ $uid }} .pb-shapes i:last-child { width: 200px; height: 200px; bottom: -70px; right: -50px; }

    #{{ $uid }} .pb-waves {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: {{ $layout === 'ribbon' ? '38px' : '86px' }};
        z-index: -1;
        overflow: hidden;
        pointer-events: none;
        color: #fff;
    }
    #{{ $uid }}[data-bg="solid"] .pb-waves { color: var(--a); }
    #{{ $uid }} .pb-waves div { position: absolute; left: 0; bottom: 0; display: flex; width: 200%; }
    #{{ $uid }} .pb-waves svg { display: block; width: 50%; height: 100%; fill: currentColor; }
    #{{ $uid }} .pb-waves div:nth-child(1) { height: 100%; opacity: .14; }
    #{{ $uid }} .pb-waves div:nth-child(2) { height: 76%; opacity: .2; }
    #{{ $uid }} .pb-waves div:nth-child(3) { height: 54%; opacity: .3; }

    #{{ $uid }} .pb-split { display: grid; grid-template-columns: 1.2fr 1fr; gap: 44px; align-items: center; }
    #{{ $uid }} .pb-centered { max-width: 760px; margin: 0 auto; text-align: center; }
    #{{ $uid }} .pb-ribbon { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 18px; }
    @media (max-width: 860px) {
        #{{ $uid }} .pb-split { grid-template-columns: 1fr; gap: 28px; text-align: center; }
        #{{ $uid }} .pb-ribbon { justify-content: center; text-align: center; }
    }
    #{{ $uid }} .pb-split .pb-row,
    #{{ $uid }} .pb-centered .pb-row { display: flex; flex-wrap: wrap; gap: 10px; margin: 0 0 22px; }
    #{{ $uid }} .pb-centered .pb-row { justify-content: center; }
    @media (max-width: 860px) { #{{ $uid }} .pb-split .pb-row { justify-content: center; } }
    #{{ $uid }} .pb-desc { max-width: 56ch; margin: 0 0 24px; font-size: 15.5px; line-height: 1.7; opacity: .85; }
    #{{ $uid }} .pb-centered .pb-desc { margin-left: auto; margin-right: auto; }
    @media (max-width: 860px) { #{{ $uid }} .pb-split .pb-desc { margin-left: auto; margin-right: auto; } }

    #{{ $uid }} .pb-badge {
        display: inline-block;
        margin-bottom: 16px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        line-height: 1;
        background: var(--soft);
        border: 1px solid var(--line);
    }
    #{{ $uid }} .pb-title { margin: 0 0 14px; font-size: clamp(26px, 4.2vw, 48px); font-weight: 800; line-height: 1.1; letter-spacing: -.035em; text-wrap: balance; }
    #{{ $uid }} .pb-ribbon .pb-title { font-size: clamp(17px, 2.2vw, 24px); margin: 0; display: inline-flex; flex-wrap: wrap; align-items: center; gap: 12px; letter-spacing: -.02em; }

    #{{ $uid }} .pb-w { display: inline-block; overflow: hidden; vertical-align: top; padding: 0 .04em .1em; margin: 0 -.04em -.1em; }
    #{{ $uid }} .pb-wi { display: inline-block; padding-bottom: .08em; transform-origin: 0 100%; }
    #{{ $uid }} .pb-hl { font-weight: 900; color: var(--a); }
    #{{ $uid }} .pb-hl .pb-wi {
        background: var(--hl) 0 50% / 250% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #{{ $uid }} .pb-cd { display: flex; gap: 8px; }
    #{{ $uid }} .pb-centered .pb-cd { justify-content: center; }
    @media (max-width: 860px) { #{{ $uid }} .pb-split .pb-cd { justify-content: center; } }
    #{{ $uid }} .pb-cd div { min-width: 66px; padding: 11px 8px 9px; border-radius: 12px; text-align: center; background: var(--soft); border: 1px solid var(--line); }
    #{{ $uid }} .pb-num { position: relative; display: block; height: 1.1em; overflow: hidden; font-size: 24px; font-weight: 800; line-height: 1.1; font-variant-numeric: tabular-nums; }
    #{{ $uid }} .pb-num span { position: absolute; inset: 0; text-align: center; }
    #{{ $uid }} .pb-num .is-start { transform: translateY(100%); opacity: 0; }
    #{{ $uid }} .pb-num .is-out { transform: translateY(-100%); opacity: 0; }
    #{{ $uid }} .pb-cd small { display: block; margin-top: 5px; font-size: 11px; font-weight: 600; opacity: .7; }

    #{{ $uid }} .pb-coupon,
    #{{ $uid }} .pb-rcoupon {
        padding: 11px 16px;
        border: 2px dashed currentColor;
        border-radius: 10px;
        background: none;
        color: inherit;
        font: 800 14px/1 ui-monospace, Menlo, Consolas, monospace;
        letter-spacing: .1em;
        cursor: pointer;
    }
    #{{ $uid }} .pb-rcoupon { padding: 7px 13px; font-size: 13px; }
    #{{ $uid }} .pb-hint { align-self: center; font-size: 12.5px; opacity: .75; }

    #{{ $uid }} .pb-btn {
        display: inline-block;
        padding: 14px 28px;
        border-radius: 999px;
        background: var(--btn);
        color: var(--btn-fg);
        font-size: 14.5px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    #{{ $uid }} .pb-btn:hover { transform: translateY(-2px); box-shadow: 0 16px 30px -14px rgba(0,0,0,.5); }
    #{{ $uid }} .pb-coupon:focus-visible,
    #{{ $uid }} .pb-rcoupon:focus-visible,
    #{{ $uid }} .pb-btn:focus-visible { outline: 3px solid currentColor; outline-offset: 3px; }

    #{{ $uid }} .pb-media { perspective: 1000px; }
    #{{ $uid }} .pb-tilt {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4 / 3;
        border-radius: 18px;
        box-shadow: 0 24px 48px -20px rgba(0,0,0,.5);
        transition: transform .3s ease;
    }
    #{{ $uid }} .pb-tilt img { display: block; width: 100%; height: 100%; object-fit: cover; }
    #{{ $uid }} .pb-tilt::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0;
        transition: opacity .3s ease;
        background: radial-gradient(300px circle at var(--gx, 50%) var(--gy, 0%), rgba(255,255,255,.32), transparent 60%);
    }
    #{{ $uid }} .pb-media:hover .pb-tilt::after { opacity: 1; }

    @keyframes pbFlow { to { background-position: 250% 50%; } }
    @keyframes pbFloat { 50% { transform: translateY(-8px); } }
    @keyframes pbWave { to { transform: translateX(-50%); } }

    @media (prefers-reduced-motion: no-preference) {
        #{{ $uid }}[data-animate="1"] .pb-waves div:nth-child(1) { animation: pbWave 24s linear infinite; }
        #{{ $uid }}[data-animate="1"] .pb-waves div:nth-child(2) { animation: pbWave 16s linear infinite reverse; }
        #{{ $uid }}[data-animate="1"] .pb-waves div:nth-child(3) { animation: pbWave 10s linear infinite; animation-delay: -4s; }
        #{{ $uid }} .pb-hl .pb-wi { animation: pbFlow 6s linear infinite; }
        #{{ $uid }} .pb-media { animation: pbFloat 6s ease-in-out infinite; }
        #{{ $uid }} .pb-num span { transition: transform .5s cubic-bezier(.2,.8,.2,1), opacity .5s ease; }
        #{{ $uid }}.pb-js[data-animate="1"] .pb-wi { transform: translateY(115%) rotate(5deg); transition: transform 1s cubic-bezier(.2,.9,.2,1) var(--d, 0ms); }
        #{{ $uid }}.pb-js[data-animate="1"].is-in .pb-wi { transform: none; }
        #{{ $uid }}.pb-js[data-animate="1"] .pb-fade { opacity: 0; transform: translateY(16px); transition: opacity .7s ease .5s, transform .8s ease .5s; }
        #{{ $uid }}.pb-js[data-animate="1"].is-in .pb-fade { opacity: 1; transform: none; }
        #{{ $uid }}.pb-js[data-animate="1"] .pb-tilt img { transform: scale(1.3); transition: transform 1.8s cubic-bezier(.2,.8,.2,1) .2s; }
        #{{ $uid }}.pb-js[data-animate="1"].is-in .pb-tilt img { transform: none; }
    }
</style>

<div id="{{ $uid }}" data-bg="{{ $bg }}" data-animate="{{ $animate ? '1' : '0' }}">
    <div class="pb-wrap">
        @if($shapes)
            <div class="pb-shapes" aria-hidden="true"><i></i><i></i></div>
            <div class="pb-waves" aria-hidden="true">
                @for($w = 0; $w < 3; $w++)
                    <div>
                        @for($j = 0; $j < 2; $j++)
                            <svg viewBox="0 0 1200 100" preserveAspectRatio="none"><path d="M0 50Q150 0 300 50T600 50T900 50T1200 50V100H0Z"/></svg>
                        @endfor
                    </div>
                @endfor
            </div>
        @endif

        @if($layout === 'ribbon')
            <div class="pb-ribbon">
                <div>
                    @if($badge !== '') <span class="pb-badge">{{ $badge }}</span> @endif
                    @if($title !== '')
                        <p class="pb-title" data-title>
                            <span>{!! $titleHtml !!}</span>
                            @if($code !== '') {!! $couponBtn('pb-rcoupon') !!} @endif
                        </p>
                    @endif
                </div>
                @if($label !== '') <a href="{{ $href }}" class="pb-btn pb-fade">{{ $label }}</a> @endif
            </div>
        @else
            <div class="{{ $isSplit ? 'pb-split' : 'pb-centered' }}">
                <div>
                    @if($badge !== '') <span class="pb-badge">{{ $badge }}</span> @endif
                    @if($title !== '') <h2 class="pb-title" data-title>{!! $titleHtml !!}</h2> @endif
                    @if($desc !== '') <p class="pb-desc pb-fade">{{ $desc }}</p> @endif

                    @if($endTs > 0)
                        <div class="pb-row pb-fade">
                            <div class="pb-cd" data-end="{{ $endTs }}">
                                @foreach(['d' => 'Days', 'h' => 'Hours', 'm' => 'Mins', 's' => 'Secs'] as $k => $l)
                                    <div><span class="pb-num" data-{{ $k }}>00</span><small>{{ __($l) }}</small></div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($code !== '')
                        <div class="pb-row pb-fade">
                            {!! $couponBtn('pb-coupon') !!}
                            @if($hint !== '') <span class="pb-hint">{{ $hint }}</span> @endif
                        </div>
                    @endif

                    @if($label !== '')
                        <div class="pb-row pb-fade" style="margin:0"><a href="{{ $href }}" class="pb-btn">{{ $label }}</a></div>
                    @endif
                </div>

                @if($isSplit && $image !== '' && $image !== '#')
                    <div class="pb-media" data-media>
                        <div class="pb-tilt" data-tilt><img src="{{ $image }}" alt="{{ $title }}" loading="lazy"></div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var live   = root.dataset.animate === '1' && !reduce;
    var fine   = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    var colors = @json($palette);
    root.classList.add('pb-js');

    function split(node, ctr) {
        if (node.nodeType === 3) {
            var frag = document.createDocumentFragment();
            node.textContent.split(/(\s+)/).forEach(function (p) {
                if (!p) return;
                if (/^\s+$/.test(p)) { frag.appendChild(document.createTextNode(' ')); return; }
                var o = document.createElement('span'), i = document.createElement('span');
                o.className = 'pb-w';
                i.className = 'pb-wi';
                i.style.setProperty('--d', (200 + ctr.n++ * 70) + 'ms');
                i.textContent = p;
                o.appendChild(i);
                frag.appendChild(o);
            });
            node.parentNode.replaceChild(frag, node);
        } else if (node.nodeType === 1) {
            [].slice.call(node.childNodes).forEach(function (c) { split(c, ctr); });
        }
    }
    [].slice.call(root.querySelectorAll('[data-title]')).forEach(function (el) { split(el, { n: 0 }); });

    var cd = root.querySelector('[data-end]');
    if (cd) {
        var end = parseInt(cd.getAttribute('data-end'), 10);
        var roll = function (el, val) {
            if (el.getAttribute('data-v') === val) return;
            var first = !el.hasAttribute('data-v');
            el.setAttribute('data-v', val);
            if (!live) { el.textContent = val; return; }
            var nu  = document.createElement('span');
            var old = el.querySelector('.is-cur');
            nu.textContent = val;
            if (first) el.textContent = '';
            nu.className = first ? 'is-cur' : 'is-start';
            el.appendChild(nu);
            if (first) return;
            requestAnimationFrame(function () {
                requestAnimationFrame(function () {
                    nu.className = 'is-cur';
                    if (old) old.className = 'is-out';
                });
            });
            setTimeout(function () { if (old && old.parentNode) old.parentNode.removeChild(old); }, 600);
        };
        var pad = function (n) { return n < 10 ? '0' + n : '' + n; };
        var tick = function () {
            var s = Math.floor(Math.max(0, end - Date.now()) / 1000);
            roll(cd.querySelector('[data-d]'), pad(Math.floor(s / 86400)));
            roll(cd.querySelector('[data-h]'), pad(Math.floor(s % 86400 / 3600)));
            roll(cd.querySelector('[data-m]'), pad(Math.floor(s % 3600 / 60)));
            roll(cd.querySelector('[data-s]'), pad(s % 60));
        };
        tick();
        setInterval(tick, 1000);
    }

    function confetti(x, y) {
        if (reduce) return;
        var cv = document.createElement('canvas'), w = innerWidth, h = innerHeight;
        cv.width = w;
        cv.height = h;
        cv.style.cssText = 'position:fixed;left:0;top:0;width:100%;height:100%;pointer-events:none;z-index:99999';
        document.body.appendChild(cv);
        var c = cv.getContext('2d'), bits = [], f = 0;
        for (var i = 0; i < 90; i++) {
            bits.push({ x: x, y: y, vx: (Math.random() - .5) * 13, vy: -(Math.random() * 10 + 4), r: Math.random() * 6, vr: (Math.random() - .5) * .45, col: colors[i % colors.length] });
        }
        (function frame() {
            c.clearRect(0, 0, w, h);
            bits.forEach(function (b) {
                b.vy += .34; b.x += b.vx; b.y += b.vy; b.r += b.vr;
                c.save();
                c.globalAlpha = Math.max(0, 1 - Math.max(0, f - 55) / 55);
                c.translate(b.x, b.y);
                c.rotate(b.r);
                c.fillStyle = b.col;
                c.fillRect(-4, -2.5, 8, 5);
                c.restore();
            });
            if (++f < 115) requestAnimationFrame(frame); else cv.remove();
        })();
    }

    [].slice.call(root.querySelectorAll('[data-coupon]')).forEach(function (btn) {
        btn.addEventListener('click', function () {
            var code = btn.getAttribute('data-coupon');
            var done = function () {
                var r = btn.getBoundingClientRect(), prev = btn.textContent;
                confetti(r.left + r.width / 2, r.top + r.height / 2);
                btn.textContent = @js(__('Copied!'));
                setTimeout(function () { btn.textContent = prev; }, 1600);
            };
            if (navigator.clipboard) {
                navigator.clipboard.writeText(code).then(done);
            } else {
                var ta = document.createElement('textarea');
                ta.value = code;
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                ta.remove();
            }
        });
    });

    var media = root.querySelector('[data-media]'), tilt = root.querySelector('[data-tilt]');
    if (live && fine && media) {
        media.addEventListener('pointermove', function (e) {
            var r = media.getBoundingClientRect(), x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
            tilt.style.transform = 'rotateY(' + (x - .5) * 14 + 'deg) rotateX(' + (.5 - y) * 14 + 'deg)';
            tilt.style.setProperty('--gx', x * 100 + '%');
            tilt.style.setProperty('--gy', y * 100 + '%');
        });
        media.addEventListener('pointerleave', function () { tilt.style.transform = ''; });
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (e) {
            if (e[0].isIntersecting) { root.classList.add('is-in'); io.disconnect(); }
        }, { threshold: .15 });
        io.observe(root);
    } else {
        root.classList.add('is-in');
    }
})();
</script>
