@php
    $subtitle   = $settings['subtitle'] ?? '';
    $title      = $settings['title'] ?? '';
    $showFilter = $settings['show_filter'] ?? true;
    $showSort   = $settings['show_sort'] ?? true;
    $layout     = $settings['layout'] ?? 'masonry';
    $columns    = (int) ($settings['columns'] ?? 3);
    $gap        = $settings['gap'] ?? 'md';

    $items = [];
    if (!empty($settings['items']) && is_array($settings['items'])) {
        foreach ($settings['items'] as $i => $row) {
            if (!is_array($row) || empty($row['image'])) continue;
            $cat = trim((string) ($row['category'] ?? ''));
            $items[] = [
                'id'       => $i,
                'image'    => $row['image'],
                'title'    => $row['title'] ?? '',
                'category' => $cat !== '' ? $cat : __('Uncategorized'),
            ];
        }
    }

    $categories = [];
    foreach ($items as $it) {
        if ($it['category'] !== '' && !in_array($it['category'], $categories, true)) {
            $categories[] = $it['category'];
        }
    }
    sort($categories);

    $gapMap = ['sm' => '10px', 'md' => '16px', 'lg' => '24px'];
    $gapPx  = $gapMap[$gap] ?? '16px';
@endphp

@once
<style>
    @keyframes rjGaPop {
        from { opacity: 0; transform: scale(.94); }
        to   { opacity: 1; transform: none; }
    }
</style>
@endonce

<style>
    #{{ $uid }} {
        position: relative;
        width: 100%;
        padding: 56px 16px;
    }

    #{{ $uid }} .rj-ga-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
        max-width: 1280px;
        margin: 0 auto 28px;
    }
    #{{ $uid }} .rj-ga-hleft { flex: 1; min-width: 220px; }
    #{{ $uid }} .rj-ga-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #14b8a6;
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-ga-title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-ga-title { font-size: 42px; }
    }
    #{{ $uid }} .rj-ga-sort {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475569;
    }
    #{{ $uid }} .rj-ga-sort select {
        padding: 9px 32px 9px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='none' stroke='%23475569' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    #{{ $uid }} .rj-ga-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        max-width: 1280px;
        margin: 0 auto 28px;
    }
    #{{ $uid }} .rj-ga-chip {
        padding: 7px 16px;
        border-radius: 999px;
        background: transparent;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .02em;
        cursor: pointer;
        transition: background .25s ease, color .25s ease, border-color .25s ease;
    }
    #{{ $uid }} .rj-ga-chip:hover {
        border-color: #0f172a;
        color: #0f172a;
    }
    #{{ $uid }} .rj-ga-chip.is-active {
        background: #14b8a6;
        border-color: #14b8a6;
        color: #fff;
    }

    #{{ $uid }} .rj-ga-grid {
        max-width: 1280px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-ga-grid[data-layout="masonry"] {
        column-count: {{ $columns }};
        column-gap: {{ $gapPx }};
    }
    #{{ $uid }} .rj-ga-grid[data-layout="grid"] {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: {{ $gapPx }};
    }
    @media (max-width: 900px) {
        #{{ $uid }} .rj-ga-grid[data-layout="masonry"] { column-count: {{ $columns > 2 ? 2 : 1 }}; }
        #{{ $uid }} .rj-ga-grid[data-layout="grid"] { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-ga-grid[data-layout="masonry"] { column-count: 1; }
        #{{ $uid }} .rj-ga-grid[data-layout="grid"] { grid-template-columns: 1fr; }
    }

    #{{ $uid }} .rj-ga-item {
        position: relative;
        break-inside: avoid;
        page-break-inside: avoid;
        margin-bottom: {{ $gapPx }};
        border-radius: 14px;
        overflow: hidden;
        background: #e2e8f0;
        cursor: pointer;
        animation: rjGaPop .55s cubic-bezier(.2,.8,.2,1) var(--d, 0s) backwards;
        transition: transform .4s ease, box-shadow .4s ease;
        display: block;
    }
    #{{ $uid }} .rj-ga-grid[data-layout="grid"] .rj-ga-item {
        margin-bottom: 0;
        aspect-ratio: 1 / 1;
    }
    #{{ $uid }} .rj-ga-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px -18px rgba(15,23,42,.4);
    }
    #{{ $uid }} .rj-ga-item img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform .8s cubic-bezier(.2,.8,.2,1), filter .4s ease;
    }
    #{{ $uid }} .rj-ga-grid[data-layout="grid"] .rj-ga-item img {
        height: 100%;
        object-fit: cover;
    }
    #{{ $uid }} .rj-ga-item:hover img {
        transform: scale(1.06);
        filter: brightness(.9);
    }
    #{{ $uid }} .rj-ga-meta {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 14px;
        background: linear-gradient(180deg, transparent 55%, rgba(2,6,23,.85));
        opacity: 0;
        transition: opacity .3s ease;
    }
    #{{ $uid }} .rj-ga-item:hover .rj-ga-meta,
    #{{ $uid }} .rj-ga-item:focus-visible .rj-ga-meta { opacity: 1; }
    #{{ $uid }} .rj-ga-cat {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #5eead4;
        margin: 0 0 2px;
    }
    #{{ $uid }} .rj-ga-name {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        margin: 0;
        line-height: 1.3;
    }

    #{{ $uid }} .rj-ga-item.is-hidden { display: none; }

    #{{ $uid }} .rj-ga-empty {
        max-width: 560px;
        margin: 0 auto;
        padding: 48px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        font-size: 14px;
    }

    #{{ $uid }} .rj-ga-lb {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 32px;
        background: rgba(2,6,23,.95);
        backdrop-filter: blur(10px);
    }
    #{{ $uid }} .rj-ga-lb.is-open { display: flex; }
    #{{ $uid }} .rj-ga-lb-img {
        max-width: 100%;
        max-height: 88vh;
        object-fit: contain;
        border-radius: 14px;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.8);
    }
    #{{ $uid }} .rj-ga-lb-btn {
        position: absolute;
        width: 48px;
        height: 48px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        cursor: pointer;
        transition: transform .25s ease, background .25s ease;
    }
    #{{ $uid }} .rj-ga-lb-btn:hover {
        background: rgba(255,255,255,.28);
        transform: scale(1.08);
    }
    #{{ $uid }} .rj-ga-lb-close { top: 20px; right: 20px; }
    #{{ $uid }} .rj-ga-lb-prev  { left: 20px; top: 50%; margin-top: -24px; }
    #{{ $uid }} .rj-ga-lb-next  { right: 20px; top: 50%; margin-top: -24px; }
    #{{ $uid }} .rj-ga-lb-count {
        position: absolute;
        bottom: 22px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .12em;
        color: rgba(255,255,255,.7);
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}" x-data="rjGalAdv_{{ $uid }}()" x-init="init()">
    @if($title || $subtitle || $showSort)
        <header class="rj-ga-head">
            <div class="rj-ga-hleft">
                @if($subtitle)
                    <p class="rj-ga-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-ga-title">{{ $title }}</h2>
                @endif
            </div>
            @if($showSort)
                <label class="rj-ga-sort">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12M10 18h4"/></svg>
                    <select x-model="sort">
                        <option value="default">{{ __('Default') }}</option>
                        <option value="title-asc">{{ __('Title A → Z') }}</option>
                        <option value="title-desc">{{ __('Title Z → A') }}</option>
                    </select>
                </label>
            @endif
        </header>
    @endif

    @if(!empty($items))
        @if($showFilter && count($categories) > 0)
            <div class="rj-ga-filters">
                <button type="button" class="rj-ga-chip" :class="{ 'is-active': active === '' }" @click="active = ''">
                    {{ __('All') }}
                </button>
                @foreach($categories as $cat)
                    <button type="button" class="rj-ga-chip"
                            :class="{ 'is-active': active === @js($cat) }"
                            @click="active = @js($cat)">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="rj-ga-grid" data-layout="{{ $layout }}" x-ref="grid">
            @foreach($items as $i => $it)
                <article class="rj-ga-item"
                         style="--d: {{ number_format($i * 0.05, 2, '.', '') }}s;"
                         :class="{ 'is-hidden': active !== '' && active !== @js($it['category']) }"
                         data-src="{{ $it['image'] }}"
                         data-index="{{ $i }}"
                         data-title="{{ $it['title'] }}"
                         data-category="{{ $it['category'] }}"
                         tabindex="0"
                         role="button"
                         @click="openLb($el)"
                         @keydown.enter.prevent="openLb($el)"
                         aria-label="{{ $it['title'] ?: __('Open image') }}">
                    <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}" loading="lazy">
                    @if($it['title'] || $it['category'])
                        <div class="rj-ga-meta">
                            @if($it['category'])
                                <p class="rj-ga-cat">{{ $it['category'] }}</p>
                            @endif
                            @if($it['title'])
                                <h3 class="rj-ga-name">{{ $it['title'] }}</h3>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @else
        <div class="rj-ga-empty">{{ __('Please add at least one gallery item.') }}</div>
    @endif

    <div class="rj-ga-lb" @click.self="closeLb()">
        <button type="button" class="rj-ga-lb-btn rj-ga-lb-close" @click="closeLb()" aria-label="{{ __('Close') }}">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button type="button" class="rj-ga-lb-btn rj-ga-lb-prev" @click.stop="prevLb()" aria-label="{{ __('Previous') }}">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
        </button>
        <img class="rj-ga-lb-img" src="" alt="">
        <button type="button" class="rj-ga-lb-btn rj-ga-lb-next" @click.stop="nextLb()" aria-label="{{ __('Next') }}">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
        </button>
        <span class="rj-ga-lb-count"></span>
    </div>
</div>

<script>
window['rjGalAdv_{{ $uid }}'] = function () {
    return {
        active: '',
        sort: 'default',
        current: 0,
        sources: [],
        items: [],
        init() {
            var root = document.getElementById(@js($uid));
            if (!root) return;
            var self = this;
            this.items = Array.prototype.slice.call(root.querySelectorAll('.rj-ga-item')).map(function (el, i) {
                return {
                    el: el,
                    title: el.getAttribute('data-title') || '',
                    category: el.getAttribute('data-category') || '',
                    src: el.getAttribute('data-src') || '',
                    order: i
                };
            });
            this.items.forEach(function (it, i) { it.el.setAttribute('data-ref', i); });
            this.$watch('sort', function () { self.reorder(); });
        },
        reorder() {
            var grid = document.getElementById(@js($uid)).querySelector('.rj-ga-grid');
            if (!grid) return;
            var arr = this.items.slice();
            if (this.sort === 'title-asc') {
                arr.sort(function (a, b) { return (a.title || '').localeCompare(b.title || ''); });
            } else if (this.sort === 'title-desc') {
                arr.sort(function (a, b) { return (b.title || '').localeCompare(a.title || ''); });
            } else {
                arr.sort(function (a, b) { return a.order - b.order; });
            }
            arr.forEach(function (it) { grid.appendChild(it.el); });
        },
        openLb(el) {
            var root = document.getElementById(@js($uid));
            if (!root) return;

            var visibleItems = Array.prototype.slice.call(root.querySelectorAll('.rj-ga-item')).filter(function(item) {
                return !item.classList.contains('is-hidden');
            });

            var pos = visibleItems.indexOf(el);
            if (pos === -1) pos = 0;

            this.sources = visibleItems.map(function(item) {
                return item.getAttribute('data-src');
            });

            this.current = pos;

            var img = this.imgEl(), lb = this.lbEl(), c = this.countEl();
            img.src = this.sources[this.current];
            if (c) c.textContent = (this.current + 1) + ' / ' + this.sources.length;

            lb.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            this._boundKey = this._onKey.bind(this);
            document.addEventListener('keydown', this._boundKey);
        },
        closeLb() {
            this.lbEl().classList.remove('is-open');
            document.body.style.overflow = '';
            if (this._boundKey) document.removeEventListener('keydown', this._boundKey);
        },
        prevLb() { if (this.sources.length) this._show((this.current - 1 + this.sources.length) % this.sources.length); },
        nextLb() { if (this.sources.length) this._show((this.current + 1) % this.sources.length); },
        _show(i) {
            this.current = i;
            var img = this.imgEl(), c = this.countEl();
            img.src = this.sources[this.current];
            if (c) c.textContent = (this.current + 1) + ' / ' + this.sources.length;
        },
        _onKey(e) {
            if (e.key === 'Escape') this.closeLb();
            if (e.key === 'ArrowLeft') this.prevLb();
            if (e.key === 'ArrowRight') this.nextLb();
        },
        lbEl() { return document.getElementById(@js($uid)).querySelector('.rj-ga-lb'); },
        imgEl() { return document.getElementById(@js($uid)).querySelector('.rj-ga-lb-img'); },
        countEl() { return document.getElementById(@js($uid)).querySelector('.rj-ga-lb-count'); }
    };
};
</script>
