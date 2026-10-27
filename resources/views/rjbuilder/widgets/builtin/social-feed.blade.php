@php
    $layout       = in_array($settings['layout'] ?? 'grid', ['grid', 'masonry', 'carousel'], true) ? $settings['layout'] : 'grid';
    $cols         = max(2, min(4, (int) ($settings['columns'] ?? 3)));
    $gap          = ['sm' => '10px', 'md' => '18px', 'lg' => '28px'][$settings['gap'] ?? 'md'] ?? '18px';
    $radius       = ['none' => '0px', 'md' => '10px', 'lg' => '18px', 'xl' => '28px'][$settings['radius'] ?? 'lg'] ?? '18px';
    $ratio        = str_replace('/', ' / ', $settings['aspect'] ?? '1/1');
    $accent       = preg_match('/^#[0-9a-f]{3,8}$/i', (string) ($settings['accent'] ?? '')) ? $settings['accent'] : '#8b5cf6';
    $padY         = max(0, min(160, (int) ($settings['padding_y'] ?? 60)));
    $showPlatform = $settings['show_platform'] ?? true;
    $showCaption  = $settings['show_caption'] ?? true;
    $showDate     = $settings['show_date'] ?? true;
    $title        = $settings['title'] ?? '';
    $subtitle     = $settings['subtitle'] ?? '';

    $base = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/social-media';

    $platforms = [
        'twitter'   => ['name' => 'Twitter / X', 'color' => '#000000', 'fb' => 'X', 'svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>'],
        'instagram' => ['name' => 'Instagram', 'color' => '#E4405F', 'fb' => 'IG', 'svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>'],
        'piokio'    => ['name' => 'Piokio', 'color' => '#FF6B35', 'fb' => 'P', 'img' => $base . '/piokio/piokio_logo.svg'],
        'dehliz'    => ['name' => 'Dehliz', 'color' => '#0f172a', 'fb' => 'D', 'img' => $base . '/dehliz/dehliz_icon.svg'],
        'reax'      => ['name' => 'Reax', 'color' => '#dc2626', 'fb' => 'R', 'img' => $base . '/reax/icon.svg'],
        'web'       => ['name' => 'Web', 'color' => '#475569', 'fb' => 'W', 'svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3.3 3 14.7 0 18M12 3c-3 3.3-3 14.7 0 18"/></svg>'],
    ];

    $badge = function (string $key) use ($platforms) {
        $p     = $platforms[$key] ?? $platforms['web'];
        $inner = $p['svg'] ?? '<img src="' . e($p['img']) . '" alt="" loading="lazy" onerror="this.parentNode.classList.add(\'is-fb\')">';
        return '<span class="sf-badge" style="--c:' . $p['color'] . '">' . $inner . '<i>' . $p['fb'] . '</i></span>';
    };

    $used = collect($items)->pluck('platform')->unique()->values()->all();
@endphp

<style>
    #{{ $uid }} {
        --accent: {{ $accent }};
        --cols: {{ $cols }};
        --gap: {{ $gap }};
        --radius: {{ $radius }};
        --ratio: {{ $ratio }};
        padding: {{ $padY }}px 16px;

        .sf-inner { max-width: 1240px; margin: 0 auto; }

        .sf-head { text-align: center; margin-bottom: 32px; }
        .sf-sub { margin: 0 0 8px; font-size: 12px; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: var(--accent); }
        .sf-title { margin: 0; font-size: clamp(26px, 4vw, 38px); font-weight: 800; letter-spacing: -.02em; color: #0f172a; }

        .sf-tabs { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 28px; }
        .sf-tab { display: inline-flex; align-items: center; gap: 8px; padding: 7px 16px 7px 8px; border: 1px solid #e2e8f0; border-radius: 999px; background: #fff; color: #475569; font: 600 13px/1 inherit; cursor: pointer; transition: .2s; }
        .sf-tab:first-child { padding-left: 16px; }
        .sf-tab:hover { border-color: var(--accent); color: #0f172a; }
        .sf-tab.is-active { background: #0f172a; border-color: #0f172a; color: #fff; }

        .sf-badge { position: relative; flex: none; display: grid; place-items: center; width: 24px; height: 24px; border-radius: 8px; background: #fff; color: var(--c); box-shadow: 0 0 0 1px rgba(15, 23, 42, .1); overflow: hidden;
            svg, img { width: 14px; height: 14px; object-fit: contain; }
            i { display: none; position: absolute; inset: 0; place-items: center; background: var(--c); color: #fff; font: 800 10px/1 sans-serif; font-style: normal; }
            &.is-fb i { display: grid; }
            &.is-fb img { display: none; }
        }

        .sf-list { display: grid; grid-template-columns: repeat(var(--cols), minmax(0, 1fr)); gap: var(--gap); }
        .sf-list[data-layout="masonry"] { display: block; column-count: var(--cols); column-gap: var(--gap); }
        .sf-list[data-layout="carousel"] { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; padding: 4px 0 12px;
            &::-webkit-scrollbar { display: none; }
            .sf-card { flex: 0 0 calc((100% - var(--gap) * (var(--cols) - 1)) / var(--cols)); scroll-snap-align: start; }
        }

        .sf-card { position: relative; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #e8edf3; border-radius: var(--radius); background: #fff; color: inherit; text-decoration: none; transition: transform .35s cubic-bezier(.2, .8, .2, 1), box-shadow .35s ease;
            &:hover { transform: translateY(-5px); box-shadow: 0 24px 48px -20px rgba(15, 23, 42, .35); }
            &.is-hidden { display: none; }
        }
        .sf-list[data-layout="masonry"] .sf-card { break-inside: avoid; margin-bottom: var(--gap); }

        .sf-media { position: relative; overflow: hidden; aspect-ratio: var(--ratio); background: #f1f5f9;
            img { display: block; width: 100%; height: 100%; object-fit: cover; transition: transform .8s cubic-bezier(.2, .8, .2, 1); }
            &.is-text { display: flex; align-items: center; padding: 24px; background: linear-gradient(135deg, var(--accent), color-mix(in srgb, var(--accent) 50%, #0f172a)); color: #fff;
                p { margin: 0; font-size: 16px; font-weight: 600; line-height: 1.5; white-space: pre-line; display: -webkit-box; -webkit-line-clamp: 8; -webkit-box-orient: vertical; overflow: hidden; }
            }
        }
        .sf-card:hover .sf-media img { transform: scale(1.07); }
        .sf-list[data-layout="masonry"] .sf-media { aspect-ratio: auto; min-height: 140px;
            img { height: auto; }
        }

        .sf-go { position: absolute; top: 12px; right: 12px; display: grid; place-items: center; width: 34px; height: 34px; border-radius: 50%; background: rgba(255, 255, 255, .92); color: #0f172a; box-shadow: 0 4px 12px rgba(15, 23, 42, .2); opacity: 0; transform: translateY(-6px); transition: .3s;
            svg { width: 16px; height: 16px; }
        }
        .sf-card:hover .sf-go { opacity: 1; transform: none; }

        .sf-body { display: flex; flex-direction: column; gap: 10px; padding: 14px 16px 16px; }
        .sf-meta { display: flex; align-items: center; gap: 8px; font-size: 12.5px; font-weight: 700; color: #0f172a; }
        .sf-date { margin-left: auto; font-weight: 500; color: #94a3b8; }
        .sf-caption { margin: 0; font-size: 13.5px; line-height: 1.55; color: #475569; white-space: pre-line; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .sf-nav { display: flex; justify-content: center; gap: 10px; margin-top: 18px;
            button { display: grid; place-items: center; width: 42px; height: 42px; border: 1px solid #e2e8f0; border-radius: 50%; background: #fff; color: #0f172a; font-size: 20px; cursor: pointer; transition: .2s;
                &:hover { background: var(--accent); border-color: var(--accent); color: #fff; }
            }
        }

        .sf-empty { max-width: 480px; margin: 0 auto; padding: 40px 24px; border: 1px dashed #cbd5e1; border-radius: 16px; background: #f8fafc; color: #64748b; text-align: center; font-size: 14px; }

        @media (max-width: 960px) { --cols: {{ $cols > 2 ? 2 : 1 }}; }
        @media (max-width: 560px) { --cols: 1; .sf-list[data-layout="carousel"] .sf-card { flex-basis: 82%; } }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    }
</style>

<div id="{{ $uid }}">
    <div class="sf-inner">
        @if($title || $subtitle)
            <header class="sf-head">
                @if($subtitle)<p class="sf-sub">{{ $subtitle }}</p>@endif
                @if($title)<h2 class="sf-title">{{ $title }}</h2>@endif
            </header>
        @endif

        @if(!empty($items))
            @if(($settings['show_tabs'] ?? true) && count($used) > 1)
                <div class="sf-tabs">
                    <button type="button" class="sf-tab is-active" data-filter="">{{ __('All') }}</button>
                    @foreach($used as $key)
                        <button type="button" class="sf-tab" data-filter="{{ $key }}">
                            {!! $badge($key) !!}<span>{{ $platforms[$key]['name'] ?? 'Web' }}</span>
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="sf-list" data-layout="{{ $layout }}">
                @foreach($items as $it)
                    @php
                        $tag    = $it['url'] ? 'a' : 'div';
                        $hasImg = $it['image'] !== '';
                        $key    = isset($platforms[$it['platform']]) ? $it['platform'] : 'web';
                    @endphp
                    <{{ $tag }} class="sf-card" data-platform="{{ $key }}" @if($it['url']) href="{{ $it['url'] }}" target="_blank" rel="noopener noreferrer" @endif>
                        <div class="sf-media {{ $hasImg ? '' : 'is-text' }}">
                            @if($hasImg)
                                <img src="{{ $it['image'] }}" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.remove()">
                            @else
                                <p>{{ $it['caption'] }}</p>
                            @endif
                            @if($it['url'])
                                <span class="sf-go"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
                            @endif
                        </div>
                        @if($showPlatform || $showDate || ($showCaption && $hasImg && $it['caption'] !== ''))
                            <div class="sf-body">
                                @if($showPlatform || ($showDate && $it['date'] !== ''))
                                    <div class="sf-meta">
                                        @if($showPlatform){!! $badge($key) !!}<span>{{ $platforms[$key]['name'] }}</span>@endif
                                        @if($showDate && $it['date'] !== '')<span class="sf-date">{{ $it['date'] }}</span>@endif
                                    </div>
                                @endif
                                @if($showCaption && $hasImg && $it['caption'] !== '')
                                    <p class="sf-caption">{{ $it['caption'] }}</p>
                                @endif
                            </div>
                        @endif
                    </{{ $tag }}>
                @endforeach
            </div>

            @if($layout === 'carousel')
                <div class="sf-nav">
                    <button type="button" data-dir="-1" aria-label="{{ __('Previous') }}">&#8249;</button>
                    <button type="button" data-dir="1" aria-label="{{ __('Next') }}">&#8250;</button>
                </div>
            @endif
        @else
            <div class="sf-empty">
                {{ __('Please add at least one social post.') }}
                @if(!empty($rssError))<br><small>{{ $rssError }}</small>@endif
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    var root = document.getElementById(@js($uid));
    if (!root) return;

    var tabs  = root.querySelectorAll('.sf-tab');
    var cards = root.querySelectorAll('.sf-card');
    var list  = root.querySelector('.sf-list');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.toggle('is-active', t === tab); });
            var filter = tab.getAttribute('data-filter');
            cards.forEach(function (c) {
                c.classList.toggle('is-hidden', !!filter && c.getAttribute('data-platform') !== filter);
            });
        });
    });

    root.querySelectorAll('.sf-nav button').forEach(function (btn) {
        btn.addEventListener('click', function () {
            list.scrollBy({ left: btn.getAttribute('data-dir') * list.clientWidth * 0.9, behavior: 'smooth' });
        });
    });
})();
</script>
