<style>
    #{{ $uid }} { --acc: {{ $o['accent'] }}; --t: #0f172a; --m: #64748b; --bd: #e2e8f0; --bg: #fff; --ln: #e2e8f0; width: 100%; padding: 32px 16px; box-sizing: border-box; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }}[data-style="dark"] { --t: #e5e7eb; --m: #94a3b8; --bd: rgba(255,255,255,.1); --bg: #1e293b; --ln: rgba(255,255,255,.15); background: #0f172a; border-radius: 20px; }

    #{{ $uid }} .rjtl-wrap { position: relative; max-width: 900px; margin: 0 auto; }

    /* Xətt və progress */
    #{{ $uid }} .rjtl-line { position: absolute; top: 0; bottom: 0; left: 50%; width: 3px; transform: translateX(-50%); background: var(--ln); border-radius: 3px; }
    #{{ $uid }} .rjtl-fill { position: absolute; top: 0; left: 0; right: 0; height: 0; background: var(--acc); border-radius: 3px; }

    /* Mərhələ */
    #{{ $uid }} .rjtl-item { position: relative; display: grid; grid-template-columns: 1fr 40px 1fr; align-items: start; margin-bottom: 28px; }
    #{{ $uid }} .rjtl-item:last-child { margin-bottom: 0; }

    #{{ $uid }} .rjtl-dot { grid-column: 2; grid-row: 1; justify-self: center; z-index: 1; display: flex; align-items: center; justify-content: center; width: {{ $o['marker'] === 'number' ? '34px' : '20px' }}; height: {{ $o['marker'] === 'number' ? '34px' : '20px' }}; margin-top: {{ $o['marker'] === 'number' ? '10px' : '17px' }}; border-radius: 50%; background: var(--bg); border: 3px solid var(--ln); color: var(--m); font-size: .75rem; font-weight: 700; line-height: 1; transition: background .3s, border-color .3s, color .3s, box-shadow .3s; }
    #{{ $uid }} .rjtl-item.is-active .rjtl-dot { background: var(--acc); border-color: var(--acc); color: #fff; box-shadow: 0 0 0 5px color-mix(in srgb, var(--acc) 20%, transparent); }

    #{{ $uid }} .rjtl-card { grid-row: 1; min-width: 0; padding: 16px 18px; border-radius: 14px; background: var(--bg); border: 1px solid var(--bd); box-shadow: 0 4px 24px -10px rgba(15,23,42,.15); }
    #{{ $uid }}[data-style="minimal"] .rjtl-card { background: transparent; border: 0; box-shadow: none; padding: 8px 4px; }
    #{{ $uid }} .rjtl-item.is-l .rjtl-card { grid-column: 1; margin-right: 16px; text-align: right; }
    #{{ $uid }} .rjtl-item.is-r .rjtl-card { grid-column: 3; margin-left: 16px; }

    #{{ $uid }} .rjtl-date { display: inline-block; margin-bottom: 8px; padding: 3px 10px; border-radius: 999px; font-size: .75rem; font-weight: 700; letter-spacing: .03em; color: var(--acc); background: color-mix(in srgb, var(--acc) 12%, transparent); }
    #{{ $uid }} .rjtl-title { margin: 0; font-size: 1.05rem; font-weight: 700; line-height: 1.35; color: var(--t); }
    #{{ $uid }} .rjtl-text { margin: 6px 0 0; font-size: .92rem; line-height: 1.6; color: var(--m); }

    /* Bir tərəfli düzülüş (və mobil) */
    #{{ $uid }}[data-layout="left"] .rjtl-line { left: 20px; }
    #{{ $uid }}[data-layout="left"] .rjtl-item { grid-template-columns: 40px 1fr; }
    #{{ $uid }}[data-layout="left"] .rjtl-dot { grid-column: 1; }
    #{{ $uid }}[data-layout="left"] .rjtl-item .rjtl-card { grid-column: 2; margin: 0 0 0 12px; text-align: left; }

    @media (max-width: 700px) {
        #{{ $uid }} { padding: 20px 8px; }
        #{{ $uid }} .rjtl-line { left: 20px; }
        #{{ $uid }} .rjtl-item { grid-template-columns: 40px 1fr; }
        #{{ $uid }} .rjtl-dot { grid-column: 1; }
        #{{ $uid }} .rjtl-item .rjtl-card { grid-column: 2; margin: 0 0 0 12px; text-align: left; }
    }

    /* Giriş animasiyası: yalnız JS işləyəndə gizlədilir */
    #{{ $uid }}.js-on .rjtl-item { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
    #{{ $uid }}.js-on .rjtl-item.is-in { opacity: 1; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }}.js-on .rjtl-item { opacity: 1; transform: none; transition: none; }
        #{{ $uid }} .rjtl-dot { transition: none; }
    }
</style>

<section id="{{ $uid }}" data-layout="{{ $o['layout'] }}" data-style="{{ $o['style'] }}" data-animate="{{ $o['animate'] ? '1' : '0' }}">
    <div class="rjtl-wrap">
        <div class="rjtl-line" aria-hidden="true"><span class="rjtl-fill"></span></div>

        @foreach ($items as $i => $item)
            <article class="rjtl-item {{ $loop->odd ? 'is-l' : 'is-r' }}">
                <span class="rjtl-dot" aria-hidden="true">{{ $o['marker'] === 'number' ? $loop->iteration : '' }}</span>
                <div class="rjtl-card">
                    @if ($item['date'] !== '')
                        <span class="rjtl-date">{{ $item['date'] }}</span>
                    @endif
                    @if ($item['title'] !== '')
                        <h4 class="rjtl-title">{{ $item['title'] }}</h4>
                    @endif
                    @if ($item['text'] !== '')
                        <p class="rjtl-text">{{ $item['text'] }}</p>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var wrap = root.querySelector('.rjtl-wrap');
    var fill = root.querySelector('.rjtl-fill');
    var items = Array.prototype.slice.call(root.querySelectorAll('.rjtl-item'));
    var animate = root.dataset.animate === '1'
        && !(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

    // Giriş animasiyası
    if (animate && 'IntersectionObserver' in window) {
        root.classList.add('js-on');
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    en.target.classList.add('is-in');
                    io.unobserve(en.target);
                }
            });
        }, { threshold: 0.15 });
        items.forEach(function (it) { io.observe(it); });
    }

    // Scroll progress: xətt dolur, keçilən nöqtələr rənglənir
    var ticking = false;

    function update() {
        ticking = false;
        var r = wrap.getBoundingClientRect();
        var mid = window.innerHeight * 0.55;
        var h = Math.max(0, Math.min(r.height, mid - r.top));
        fill.style.height = h + 'px';

        items.forEach(function (it) {
            var d = it.querySelector('.rjtl-dot').getBoundingClientRect();
            it.classList.toggle('is-active', d.top + d.height / 2 < mid);
        });
    }

    function onScroll() {
        if (!ticking) {
            ticking = true;
            window.requestAnimationFrame(update);
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    update();
})();
</script>