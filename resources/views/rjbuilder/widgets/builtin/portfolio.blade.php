@php
    $subtitle    = $settings['subtitle'] ?? '';
    $title       = $settings['title'] ?? '';
    $showFilter  = $settings['show_filter'] ?? true;
    $columns     = (int) ($settings['columns'] ?? 3);
    $gap         = $settings['gap'] ?? 'md';
    $aspect      = $settings['aspect'] ?? '4/3';

    $items = [];
    if (!empty($settings['items']) && is_array($settings['items'])) {
        foreach ($settings['items'] as $row) {
            if (!is_array($row) || empty($row['image'])) continue;
            $items[] = [
                'image'    => $row['image'],
                'title'    => $row['title'] ?? '',
                'category' => trim($row['category'] ?? ''),
                'link'     => $row['link'] ?? '',
            ];
        }
    }

    $categories = [];
    foreach ($items as $it) {
        if ($it['category'] !== '' && !in_array($it['category'], $categories, true)) {
            $categories[] = $it['category'];
        }
    }

    $gapMap    = ['sm' => '10px', 'md' => '18px', 'lg' => '28px'];
    $gapPx     = $gapMap[$gap] ?? '18px';
    $aspectCss = str_replace('/', ' / ', $aspect);
@endphp

@once
<style>
    @keyframes rjPfRise {
        from { opacity: 0; transform: translateY(24px) scale(.98); }
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
    #{{ $uid }} .rj-pf-head {
        text-align: center;
        margin-bottom: 36px;
        max-width: 720px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-pf-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #6366f1;
        margin: 0 0 10px;
    }
    #{{ $uid }} .rj-pf-title {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.02em;
        color: #0f172a;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-pf-title { font-size: 42px; }
    }

    #{{ $uid }} .rj-pf-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        margin: 0 0 32px;
    }
    #{{ $uid }} .rj-pf-btn {
        padding: 8px 18px;
        border-radius: 999px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .25s ease, color .25s ease, border-color .25s ease, transform .2s ease;
    }
    #{{ $uid }} .rj-pf-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    #{{ $uid }} .rj-pf-btn.is-active {
        background: #0f172a;
        border-color: #0f172a;
        color: #fff;
    }

    #{{ $uid }} .rj-pf-grid {
        display: grid;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
        gap: {{ $gapPx }};
        max-width: 1280px;
        margin: 0 auto;
    }
    @media (max-width: 900px) {
        #{{ $uid }} .rj-pf-grid { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-pf-grid { grid-template-columns: 1fr; }
    }

    #{{ $uid }} .rj-pf-card {
        position: relative;
        aspect-ratio: {{ $aspectCss }};
        border-radius: 16px;
        overflow: hidden;
        background: #e2e8f0;
        cursor: pointer;
        animation: rjPfRise .7s cubic-bezier(.2,.8,.2,1) var(--d, 0s) backwards;
        transition: transform .5s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease;
    }
    #{{ $uid }} .rj-pf-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 48px -20px rgba(15,23,42,.45);
    }
    #{{ $uid }} .rj-pf-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .9s cubic-bezier(.2,.8,.2,1), filter .4s ease;
    }
    #{{ $uid }} .rj-pf-card:hover img {
        transform: scale(1.08);
        filter: brightness(.85);
    }
    #{{ $uid }} .rj-pf-veil {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 18px;
        background: linear-gradient(180deg, transparent 40%, rgba(2,6,23,.85) 100%);
        opacity: 0;
        transform: translateY(8px);
        transition: opacity .35s ease, transform .35s ease;
        pointer-events: none;
    }
    #{{ $uid }} .rj-pf-card:hover .rj-pf-veil,
    #{{ $uid }} .rj-pf-card:focus-visible .rj-pf-veil {
        opacity: 1;
        transform: none;
    }
    #{{ $uid }} .rj-pf-cat {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #a5b4fc;
        margin: 0 0 4px;
    }
    #{{ $uid }} .rj-pf-name {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        line-height: 1.3;
    }
    #{{ $uid }} .rj-pf-plus {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,.3);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: scale(.6) rotate(-90deg);
        opacity: 0;
        transition: opacity .3s ease, transform .35s cubic-bezier(.34,1.56,.64,1);
    }
    #{{ $uid }} .rj-pf-card:hover .rj-pf-plus {
        opacity: 1;
        transform: none;
    }

    #{{ $uid }} .rj-pf-card.is-hidden {
        display: none;
    }

    #{{ $uid }} .rj-pf-empty {
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

    #{{ $uid }} .rj-pf-lb {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 32px;
        background: rgba(2,6,23,.94);
        backdrop-filter: blur(8px);
    }
    #{{ $uid }} .rj-pf-lb.is-open { display: flex; }
    #{{ $uid }} .rj-pf-lb-img {
        max-width: 100%;
        max-height: 88vh;
        object-fit: contain;
        border-radius: 18px;
        box-shadow: 0 40px 80px -20px rgba(0,0,0,.7);
    }
    #{{ $uid }} .rj-pf-lb-btn {
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
    #{{ $uid }} .rj-pf-lb-btn:hover {
        background: rgba(255,255,255,.28);
        transform: scale(1.08);
    }
    #{{ $uid }} .rj-pf-lb-close { top: 20px; right: 20px; }
    #{{ $uid }} .rj-pf-lb-prev  { left: 20px; top: 50%; margin-top: -24px; }
    #{{ $uid }} .rj-pf-lb-next  { right: 20px; top: 50%; margin-top: -24px; }
    #{{ $uid }} .rj-pf-lb-count {
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

<div id="{{ $uid }}" x-data="rjPortfolio_{{ $uid }}()" x-init="init()">
    @if($title || $subtitle)
        <header class="rj-pf-head">
            @if($subtitle)
                <p class="rj-pf-sub">{{ $subtitle }}</p>
            @endif
            @if($title)
                <h2 class="rj-pf-title">{{ $title }}</h2>
            @endif
        </header>
    @endif

    @if(!empty($items))
        @if($showFilter && count($categories) > 0)
            <div class="rj-pf-filters">
                <button type="button" class="rj-pf-btn" :class="{ 'is-active': active === '' }" @click="active = ''">
                    {{ __('All') }}
                </button>
                @foreach($categories as $cat)
                    <button type="button" class="rj-pf-btn"
                            :class="{ 'is-active': active === @js($cat) }"
                            @click="active = @js($cat)">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="rj-pf-grid">
            @foreach($items as $i => $it)
                <article class="rj-pf-card"
                         style="--d: {{ number_format($i * 0.06, 2, '.', '') }}s;"
                         :class="{ 'is-hidden': active !== '' && active !== @js($it['category']) }"
                         data-src="{{ $it['image'] }}"
                         data-index="{{ $i }}"
                         tabindex="0"
                         role="button"
                         @click="openLb({{ $i }})"
                         @keydown.enter.prevent="openLb({{ $i }})"
                         aria-label="{{ $it['title'] ?: __('Open image') }}">
                    <img src="{{ $it['image'] }}" alt="{{ $it['title'] }}" loading="lazy">
                    <div class="rj-pf-plus">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    @if($it['title'] || $it['category'])
                        <div class="rj-pf-veil">
                            @if($it['category'])
                                <p class="rj-pf-cat">{{ $it['category'] }}</p>
                            @endif
                            @if($it['title'])
                                <h3 class="rj-pf-name">{{ $it['title'] }}</h3>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @else
        <div class="rj-pf-empty">{{ __('Please add at least one portfolio item.') }}</div>
    @endif

    <div class="rj-pf-lb" @click.self="closeLb()">
        <button type="button" class="rj-pf-lb-btn rj-pf-lb-close" @click="closeLb()" aria-label="{{ __('Close') }}">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button type="button" class="rj-pf-lb-btn rj-pf-lb-prev" @click.stop="prevLb()" aria-label="{{ __('Previous') }}">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
        </button>
        <img class="rj-pf-lb-img" src="" alt="">
        <button type="button" class="rj-pf-lb-btn rj-pf-lb-next" @click.stop="nextLb()" aria-label="{{ __('Next') }}">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
        </button>
        <span class="rj-pf-lb-count"></span>
    </div>
</div>

<script>
window['rjPortfolio_{{ $uid }}'] = function () {
    return {
        active: '',
        current: 0,
        sources: [],
        init() {
            var root = document.getElementById(@js($uid));
            if (!root) return;
            this.sources = Array.prototype.slice.call(root.querySelectorAll('.rj-pf-card')).map(function (el) {
                return el.getAttribute('data-src');
            });
        },
        lb() { return document.getElementById(@js($uid)).querySelector('.rj-pf-lb'); },
        img() { return document.getElementById(@js($uid)).querySelector('.rj-pf-lb-img'); },
        count() { return document.getElementById(@js($uid)).querySelector('.rj-pf-lb-count'); },
        openLb(i) {
            if (!this.sources.length) return;
            this.current = (i + this.sources.length) % this.sources.length;
            var img = this.img(), lb = this.lb(), c = this.count();
            img.src = this.sources[this.current];
            if (c) c.textContent = (this.current + 1) + ' / ' + this.sources.length;
            lb.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            this._boundKey = this._onKey.bind(this);
            document.addEventListener('keydown', this._boundKey);
        },
        closeLb() {
            var lb = this.lb();
            lb.classList.remove('is-open');
            document.body.style.overflow = '';
            if (this._boundKey) document.removeEventListener('keydown', this._boundKey);
        },
        prevLb() { if (this.sources.length) this.openLb(this.current - 1); },
        nextLb() { if (this.sources.length) this.openLb(this.current + 1); },
        _onKey(e) {
            if (e.key === 'Escape') this.closeLb();
            if (e.key === 'ArrowLeft') this.prevLb();
            if (e.key === 'ArrowRight') this.nextLb();
        }
    };
};
</script>
