@php
    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';
    $products = $settings['products'] ?? [];
    $uid = 'pl_' . substr(md5(uniqid('', true)), 0, 8);

    $isExternal = function ($url) {
        return is_string($url) && preg_match('#^https?://#i', $url) && !str_contains($url, request()->getHost());
    };
@endphp

<section class="rj-pl-section" id="{{ $uid }}">
    <div class="rj-pl-inner">

        @if($title || $subtitle)
            <div class="rj-pl-header" data-reveal>
                @if($title)
                    <h2 class="rj-pl-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-pl-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        @if(!empty($products))
            <div class="rj-pl-grid">
                @foreach($products as $i => $item)
                    @php
                        $hasLink = !empty($item['btn_text']) && !empty($item['btn_url']);
                        $external = $hasLink && $isExternal($item['btn_url']);
                    @endphp
                    <article class="rj-pl-card {{ $hasLink ? 'has-link' : '' }}" data-card data-reveal style="--i: {{ $i }};">
                        <div class="rj-pl-image-wrap">
                            @if(!empty($item['image']))
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] ?? '' }}" loading="lazy">
                            @else
                                <div class="rj-pl-placeholder">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                </div>
                            @endif

                            @if(!empty($item['price']))
                                <div class="rj-pl-price-badge">{{ $item['price'] }}</div>
                            @endif
                        </div>

                        <div class="rj-pl-content">
                            @if(!empty($item['title']))
                                <h3 class="rj-pl-item-title">{{ $item['title'] }}</h3>
                            @endif
                            @if(!empty($item['desc']))
                                <p class="rj-pl-desc">{{ $item['desc'] }}</p>
                            @endif

                            @if($hasLink)
                                <a href="{{ $item['btn_url'] }}" class="rj-pl-btn" @if($external) target="_blank" rel="noopener noreferrer" @endif>
                                    <span>{{ $item['btn_text'] }}</span>
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rj-pl-empty" data-reveal>
                <svg fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>{{ __('No products yet') }}</span>
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-pl-section {
            --pl-accent: var(--rj-primary, #3b82f6);
            position: relative;
            padding: 100px 24px;
            background: transparent;
            z-index: 1;
        }

        #{{ $uid }} .rj-pl-inner {
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        #{{ $uid }} [data-reveal] {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
            transition-delay: calc(var(--i, 0) * 90ms);
        }
        #{{ $uid }} [data-reveal].is-visible {
            opacity: 1;
            transform: none;
        }

        #{{ $uid }} .rj-pl-header {
            text-align: center;
            margin: 0 auto 64px;
            max-width: 700px;
        }

        #{{ $uid }} .rj-pl-title {
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 500;
            color: #fff;
            margin: 0 0 16px;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        #{{ $uid }} .rj-pl-subtitle {
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }

        #{{ $uid }} .rj-pl-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
        }

        #{{ $uid }} .rj-pl-card {
            --mx: 50%;
            --my: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            border-radius: 24px;
            overflow: hidden;
            isolation: isolate;
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.015));
            border: 1px solid rgba(255, 255, 255, 0.08);
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
            transition: opacity 0.7s cubic-bezier(0.2, 0.8, 0.2, 1), transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1), border-color 0.3s, box-shadow 0.3s;
        }

        #{{ $uid }} .rj-pl-card::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.35s ease;
            background: radial-gradient(360px circle at var(--mx) var(--my), color-mix(in srgb, var(--pl-accent) 22%, transparent), transparent 65%);
        }

        #{{ $uid }} .rj-pl-card::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 3;
            pointer-events: none;
            border-radius: inherit;
            padding: 1px;
            opacity: 0;
            transition: opacity 0.35s ease;
            background: radial-gradient(260px circle at var(--mx) var(--my), color-mix(in srgb, var(--pl-accent) 90%, #fff), transparent 65%);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
        }

        #{{ $uid }} .rj-pl-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 50px -26px color-mix(in srgb, var(--pl-accent) 55%, transparent);
        }
        #{{ $uid }} .rj-pl-card:hover::before,
        #{{ $uid }} .rj-pl-card:hover::after { opacity: 1; }

        #{{ $uid }} .rj-pl-image-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            aspect-ratio: 4 / 3;
            background: rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        #{{ $uid }} .rj-pl-image-wrap::after {
            content: "";
            position: absolute;
            inset: auto 0 0 0;
            height: 55%;
            pointer-events: none;
            background: linear-gradient(180deg, transparent, rgba(8, 10, 16, 0.75));
        }

        #{{ $uid }} .rj-pl-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        #{{ $uid }} .rj-pl-card:hover .rj-pl-image-wrap img { transform: scale(1.07); }

        #{{ $uid }} .rj-pl-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.14);
        }
        #{{ $uid }} .rj-pl-placeholder svg { width: 48px; height: 48px; }

        #{{ $uid }} .rj-pl-price-badge {
            position: absolute;
            left: 16px;
            bottom: 16px;
            z-index: 2;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            -webkit-backdrop-filter: blur(12px) saturate(160%);
            backdrop-filter: blur(12px) saturate(160%);
            transition: background 0.3s, border-color 0.3s;
        }
        #{{ $uid }} .rj-pl-card:hover .rj-pl-price-badge {
            background: color-mix(in srgb, var(--pl-accent) 55%, rgba(255, 255, 255, 0.1));
            border-color: color-mix(in srgb, var(--pl-accent) 70%, #fff);
        }

        #{{ $uid }} .rj-pl-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 26px 26px 24px;
        }

        #{{ $uid }} .rj-pl-item-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 10px;
            line-height: 1.3;
            letter-spacing: -0.02em;
        }

        #{{ $uid }} .rj-pl-desc {
            font-size: 14px;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.55);
            margin: 0 0 24px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #{{ $uid }} .rj-pl-btn {
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-top: auto;
            padding: 13px 18px;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: background 0.25s, border-color 0.25s, box-shadow 0.25s;
        }

        #{{ $uid }} .rj-pl-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 4;
        }

        #{{ $uid }} .rj-pl-btn svg {
            width: 18px;
            height: 18px;
            flex: none;
            transition: transform 0.25s ease;
        }

        #{{ $uid }} .rj-pl-card.has-link:hover .rj-pl-btn {
            background: var(--pl-accent);
            border-color: var(--pl-accent);
            box-shadow: 0 8px 22px -8px color-mix(in srgb, var(--pl-accent) 80%, transparent);
        }
        #{{ $uid }} .rj-pl-card.has-link:hover .rj-pl-btn svg { transform: translateX(4px); }
        #{{ $uid }} .rj-pl-btn:focus-visible { outline: 2px solid rgba(255, 255, 255, 0.7); outline-offset: 3px; }

        #{{ $uid }} .rj-pl-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            padding: 64px 24px;
            border-radius: 24px;
            border: 1px dashed rgba(255, 255, 255, 0.14);
            color: rgba(255, 255, 255, 0.4);
            font-size: 15px;
        }
        #{{ $uid }} .rj-pl-empty svg { width: 40px; height: 40px; }

        @media (max-width: 768px) {
            #{{ $uid }}.rj-pl-section { padding: 64px 20px; }
            #{{ $uid }} .rj-pl-header { margin-bottom: 40px; }
            #{{ $uid }} .rj-pl-grid { gap: 20px; }
            #{{ $uid }} .rj-pl-content { padding: 22px 20px 20px; }
        }

        @media (hover: none) {
            #{{ $uid }} .rj-pl-card:hover { transform: none; }
        }
    </style>

    <script>
    (function () {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var items = root.querySelectorAll('[data-reveal]');
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            items.forEach(function (el) { io.observe(el); });
        } else {
            items.forEach(function (el) { el.classList.add('is-visible'); });
        }

        root.querySelectorAll('[data-card]').forEach(function (card) {
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                card.style.setProperty('--my', (e.clientY - r.top) + 'px');
            });
        });
    })();
    </script>
</section>