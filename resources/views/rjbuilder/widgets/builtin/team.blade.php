@php
    $total = count($members);
    $hasMore = $total > $opts['initial'];
@endphp

<style>
    #{{ $uid }} { --ac: {{ $opts['accent'] }}; --t: #0f172a; --m: #64748b; --bd: #e2e8f0; --ph: #f1f5f9; width: 100%; padding: 56px 16px; }
    #{{ $uid }}[data-style="dark"] { --t: #fff; --m: #94a3b8; --bd: #334155; --ph: #1e293b; }
    #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { box-sizing: border-box; }
    #{{ $uid }} .rjtm-wrap { max-width: 1200px; margin: 0 auto; }

    /* ---------- Header ---------- */
    #{{ $uid }} .rjtm-head { margin-bottom: 44px; text-align: center; }
    #{{ $uid }} .rjtm-title { margin: 0; padding: 0; font-size: clamp(1.9rem, 4.2vw, 2.8rem); font-weight: 800; line-height: 1.12; letter-spacing: -.03em; color: var(--t); }
    #{{ $uid }} .rjtm-title::after { content: ""; display: block; width: 56px; height: 4px; margin: 18px auto 0; border-radius: 4px; background: var(--ac); }
    #{{ $uid }} .rjtm-sub { margin: 16px auto 0; max-width: 36rem; color: var(--m); line-height: 1.7; font-size: 1.05rem; }

    /* ---------- Grid ---------- */
    #{{ $uid }} .rjtm-grid { display: grid; gap: 40px 32px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    #{{ $uid }}[data-cols="2"] .rjtm-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    #{{ $uid }}[data-cols="4"] .rjtm-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    @media (max-width: 1023px) { #{{ $uid }}[data-cols="3"] .rjtm-grid, #{{ $uid }}[data-cols="4"] .rjtm-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 639px) { #{{ $uid }} { padding: 36px 12px; } #{{ $uid }}[data-cols] .rjtm-grid { grid-template-columns: minmax(0, 1fr); gap: 32px; } }

    /* ---------- Card ---------- */
    #{{ $uid }} .rjtm-card { position: relative; display: flex; flex-direction: column; transition: transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjtm-card[hidden] { display: none; }
    #{{ $uid }} .rjtm-card:hover { transform: translateY(-8px); }

    #{{ $uid }} .rjtm-photo { position: relative; width: 100%; aspect-ratio: 4 / 5; overflow: hidden; border-radius: 24px; border: 2px solid var(--bd); background: var(--ph); transition: border-color .4s ease, box-shadow .4s ease; }
    #{{ $uid }} .rjtm-card:hover .rjtm-photo { border-color: var(--ac); box-shadow: 0 26px 46px -24px var(--ac); }
    #{{ $uid }} .rjtm-photo img { position: absolute; inset: 0; display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; object-position: center; transition: transform .7s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjtm-card:hover .rjtm-photo img { transform: scale(1.08); }
    #{{ $uid }} .rjtm-avatar { position: absolute; inset: 0; display: grid; place-items: center; font-size: clamp(3rem, 8vw, 4.5rem); font-weight: 800; letter-spacing: -.03em; color: var(--ac); background: radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--ac) 22%, transparent), transparent 65%), var(--ph); }

    /* ---------- Social overlay ---------- */
    #{{ $uid }} .rjtm-ov { position: absolute; inset: 0; display: flex; align-items: flex-end; justify-content: center; padding: 22px 14px; background: linear-gradient(to top, rgba(2,6,23,.72), transparent 55%); opacity: 0; transition: opacity .4s ease; }
    #{{ $uid }} .rjtm-card:hover .rjtm-ov, #{{ $uid }} .rjtm-card:focus-within .rjtm-ov { opacity: 1; }
    #{{ $uid }} .rjtm-soc { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin: 0; padding: 0; list-style: none; }
    #{{ $uid }} .rjtm-soc li { margin: 0; padding: 0; list-style: none; opacity: 0; transform: translateY(14px) scale(.85); transition: opacity .35s ease, transform .5s cubic-bezier(.34,1.56,.64,1); transition-delay: calc(var(--k, 0) * 45ms); }
    #{{ $uid }} .rjtm-card:hover .rjtm-soc li, #{{ $uid }} .rjtm-card:focus-within .rjtm-soc li { opacity: 1; transform: none; }

    #{{ $uid }} .rjtm-soc a { --bc: var(--ac); position: relative; display: grid; place-items: center; width: 42px; height: 42px; border-radius: 50%; color: #fff !important; text-decoration: none !important; background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.35); -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); transition: background-color .3s ease, color .3s ease, border-color .3s ease, transform .3s ease, box-shadow .3s ease; }
    #{{ $uid }}[data-brand="1"] .rjtm-soc a { --bc: var(--c, var(--ac)); }
    #{{ $uid }} .rjtm-soc a:hover, #{{ $uid }} .rjtm-soc a:focus-visible { background: var(--bc); border-color: var(--bc); transform: translateY(-4px) scale(1.1); box-shadow: 0 12px 22px -8px var(--bc); outline: none; }
    #{{ $uid }} .rjtm-soc a svg { display: block; width: 19px; height: 19px; max-width: none; }
    /* very light/dark brand colors: keep the glyph readable on hover */
    #{{ $uid }} .rjtm-soc a[data-key="snapchat"]:hover { color: #111 !important; }

    /* tooltip */
    #{{ $uid }} .rjtm-soc a::after { content: attr(data-label); position: absolute; bottom: calc(100% + 10px); left: 50%; padding: 5px 10px; border-radius: 8px; background: #0f172a; color: #fff; font-size: .7rem; font-weight: 600; line-height: 1; white-space: nowrap; pointer-events: none; opacity: 0; transform: translate(-50%, 6px); transition: opacity .25s ease, transform .25s ease; }
    #{{ $uid }} .rjtm-soc a:hover::after, #{{ $uid }} .rjtm-soc a:focus-visible::after { opacity: 1; transform: translate(-50%, 0); }

    /* touch devices have no hover: always show the icons */
    @media (hover: none) {
        #{{ $uid }} .rjtm-ov { opacity: 1; }
        #{{ $uid }} .rjtm-soc li { opacity: 1; transform: none; }
        #{{ $uid }} .rjtm-soc a::after { display: none; }
        #{{ $uid }} .rjtm-card:hover { transform: none; }
    }

    /* ---------- Info ---------- */
    #{{ $uid }} .rjtm-info { position: relative; margin-top: 26px; padding: 0 8px; text-align: center; }
    #{{ $uid }} .rjtm-info::before { content: ""; position: absolute; top: -14px; left: 50%; width: 48px; height: 4px; margin-left: -24px; border-radius: 4px; background: var(--ac); transform: scaleX(0); transition: transform .5s cubic-bezier(.2,.8,.2,1); }
    #{{ $uid }} .rjtm-card:hover .rjtm-info::before { transform: scaleX(1); }
    #{{ $uid }} .rjtm-name { margin: 0; padding: 0; font-size: 1.25rem; font-weight: 800; letter-spacing: -.01em; line-height: 1.3; color: var(--t); }
    #{{ $uid }} .rjtm-pos { margin: 6px 0 0; font-size: .92rem; font-weight: 500; color: var(--m); }

    #{{ $uid }} .rjtm-btn { display: inline-flex; align-items: center; gap: 8px; margin-top: 18px; padding: 10px 24px; border: 1px solid var(--bd); border-radius: 999px; color: var(--t) !important; font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; line-height: 1; text-decoration: none !important; transition: background-color .3s ease, color .3s ease, border-color .3s ease, transform .3s ease; }
    #{{ $uid }} .rjtm-btn svg { width: 14px; height: 14px; transition: transform .3s ease; }
    #{{ $uid }} .rjtm-btn:hover, #{{ $uid }} .rjtm-btn:focus-visible { background: var(--ac); border-color: var(--ac); color: #fff !important; transform: translateY(-2px); }
    #{{ $uid }} .rjtm-btn:hover svg { transform: translateX(4px); }

    /* ---------- Show more ---------- */
    #{{ $uid }} .rjtm-more-wrap { margin-top: 48px; text-align: center; }
    #{{ $uid }} .rjtm-more { all: unset; box-sizing: border-box; display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; border-radius: 999px; background: var(--t); color: var(--ph); font-size: .85rem; font-weight: 700; cursor: pointer; box-shadow: 0 14px 30px -14px rgba(0,0,0,.5); transition: transform .3s ease, background-color .3s ease, color .3s ease; }
    #{{ $uid }}[data-style="dark"] .rjtm-more { background: #fff; color: #0f172a; }
    #{{ $uid }} .rjtm-more:hover { background: var(--ac); color: #fff; transform: translateY(-3px); }
    #{{ $uid }} .rjtm-more:focus-visible { outline: 2px solid var(--ac); outline-offset: 3px; }
    #{{ $uid }} .rjtm-more svg { width: 16px; height: 16px; transition: transform .4s ease; }
    #{{ $uid }} .rjtm-more[aria-expanded="true"] svg { transform: rotate(180deg); }

    /* ---------- Animations ---------- */
    #{{ $uid }}.rjtm-ready:not(.rjtm-in) .rjtm-card { opacity: 0; }
    #{{ $uid }}.rjtm-in .rjtm-card { animation: rjtm-rise .9s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--i, 0) * 90ms); }
    #{{ $uid }} .rjtm-card.rjtm-pop { animation: rjtm-rise .8s cubic-bezier(.2,.8,.2,1) backwards; animation-delay: calc(var(--p, 0) * 80ms); }
    @keyframes rjtm-rise { from { opacity: 0; transform: translateY(32px) scale(.96); } }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *, #{{ $uid }} *::before, #{{ $uid }} *::after { animation: none !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        #{{ $uid }}.rjtm-ready:not(.rjtm-in) .rjtm-card { opacity: 1; }
    }
</style>

<section id="{{ $uid }}"
         data-style="{{ $opts['style'] }}"
         data-cols="{{ $opts['cols'] }}"
         data-brand="{{ $opts['brand'] ? '1' : '0' }}"
         data-initial="{{ $opts['initial'] }}">
    <div class="rjtm-wrap">

        @if ($opts['title'] !== '' || $opts['subtitle'] !== '')
            <div class="rjtm-head">
                @if ($opts['title'] !== '')
                    <h2 class="rjtm-title">{{ $opts['title'] }}</h2>
                @endif
                @if ($opts['subtitle'] !== '')
                    <p class="rjtm-sub">{{ $opts['subtitle'] }}</p>
                @endif
            </div>
        @endif

        <div class="rjtm-grid">
            @foreach ($members as $member)
                @php
                    $extra = $loop->index >= $opts['initial'];
                    $initials = mb_strtoupper(collect(preg_split('/\s+/u', trim($member['name'])))->filter()->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
                @endphp

                <article class="rjtm-card" style="--i: {{ min($loop->index, 11) }};" data-extra="{{ $extra ? '1' : '0' }}" @if ($extra) hidden @endif>
                    <div class="rjtm-photo">
                        @if (!empty($member['image']))
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" loading="lazy" decoding="async">
                        @else
                            <div class="rjtm-avatar" aria-hidden="true">{{ $initials }}</div>
                        @endif

                        @if (!empty($member['socials']))
                            <div class="rjtm-ov">
                                <ul class="rjtm-soc">
                                    @foreach ($member['socials'] as $s)
                                        <li style="--k: {{ $loop->index }};">
                                            <a href="{{ $s['url'] }}"
                                               data-key="{{ $s['key'] }}"
                                               data-label="{{ $s['label'] }}"
                                               aria-label="{{ $member['name'] }} - {{ $s['label'] }}"
                                               style="--c: {{ $s['color'] }};"
                                               @if ($s['external']) target="_blank" rel="noopener noreferrer" @endif>
                                                {!! $s['svg'] !!}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="rjtm-info">
                        <h3 class="rjtm-name">{{ $member['name'] }}</h3>
                        @if (!empty($member['position']))
                            <p class="rjtm-pos">{{ $member['position'] }}</p>
                        @endif

                        @if (!empty($member['btn_text']) && !empty($member['btn_url']) && $member['btn_url'] !== '#')
                            <a href="{{ $member['btn_url'] }}" class="rjtm-btn">
                                <span>{{ $member['btn_text'] }}</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6l6 6-6 6"/></svg>
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        @if ($hasMore)
            <div class="rjtm-more-wrap">
                <button type="button" class="rjtm-more" aria-expanded="false" data-more="{{ $opts['more'] }}" data-less="{{ $opts['less'] }}">
                    <span>{{ $opts['more'] }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
        @endif
    </div>
</section>

<script>
(function () {
    var root = document.getElementById('{{ $uid }}');
    if (!root || root.dataset.ready) { return; }
    root.dataset.ready = '1';

    var btn = root.querySelector('.rjtm-more');
    var extras = [].slice.call(root.querySelectorAll('.rjtm-card[data-extra="1"]'));

    if (btn && extras.length) {
        var label = btn.querySelector('span');

        btn.addEventListener('click', function () {
            var open = btn.getAttribute('aria-expanded') !== 'true';

            extras.forEach(function (card, k) {
                card.classList.remove('rjtm-pop');
                if (open) {
                    card.hidden = false;
                    card.style.setProperty('--p', k);
                    void card.offsetWidth;
                    card.classList.add('rjtm-pop');
                } else {
                    card.hidden = true;
                }
            });

            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            label.textContent = open ? btn.dataset.less : btn.dataset.more;

            if (!open) {
                root.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'start' });
            }
        });
    }

    // Reveal on scroll
    root.classList.add('rjtm-ready');
    function show() { root.classList.add('rjtm-in'); }
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
