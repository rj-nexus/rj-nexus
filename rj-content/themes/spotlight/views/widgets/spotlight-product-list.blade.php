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
                    <article class="rj-pl-card" data-reveal style="--i: {{ $i }};">
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
                                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rj-pl-empty" data-reveal>
                <span>{{ __('No products yet') }}</span>
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-pl-section {
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
            transform: translateY(16px);
            transition: opacity 0.6s ease, transform 0.6s ease;
            transition-delay: calc(var(--i, 0) * 70ms);
        }
        #{{ $uid }} [data-reveal].is-visible {
            opacity: 1;
            transform: none;
        }

        #{{ $uid }} .rj-pl-header {
            text-align: center;
            margin: 0 auto 56px;
            max-width: 640px;
        }

        #{{ $uid }} .rj-pl-title {
            font-size: clamp(30px, 4vw, 44px);
            font-weight: 500;
            color: #fff;
            margin: 0 0 14px;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        #{{ $uid }} .rj-pl-subtitle {
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.55);
            margin: 0;
        }

        #{{ $uid }} .rj-pl-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 20px;
        }

        #{{ $uid }} .rj-pl-card {
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 10px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.09);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
            backdrop-filter: blur(18px) saturate(140%);
            transition: opacity 0.6s ease, transform 0.6s ease, background 0.3s ease, border-color 0.3s ease;
        }

        #{{ $uid }} .rj-pl-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.2);
        }

        #{{ $uid }} .rj-pl-image-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 11;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            overflow: hidden;
        }

        #{{ $uid }} .rj-pl-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }
        #{{ $uid }} .rj-pl-card:hover .rj-pl-image-wrap img { transform: scale(1.04); }

        #{{ $uid }} .rj-pl-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.16);
        }
        #{{ $uid }} .rj-pl-placeholder svg { width: 40px; height: 40px; }

        #{{ $uid }} .rj-pl-price-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            color: #fff;
            background: rgba(10, 12, 18, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.18);
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
        }

        #{{ $uid }} .rj-pl-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 18px 10px 8px;
        }

        #{{ $uid }} .rj-pl-item-title {
            font-size: 17px;
            font-weight: 500;
            color: #fff;
            margin: 0 0 8px;
            line-height: 1.3;
            letter-spacing: -0.01em;
        }

        #{{ $uid }} .rj-pl-desc {
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.5);
            margin: 0 0 18px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #{{ $uid }} .rj-pl-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
            padding: 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        #{{ $uid }} .rj-pl-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;
            border-radius: inherit;
        }
        #{{ $uid }} .rj-pl-btn svg {
            width: 16px;
            height: 16px;
            flex: none;
            transition: transform 0.25s ease;
        }
        #{{ $uid }} .rj-pl-card:hover .rj-pl-btn { color: #fff; }
        #{{ $uid }} .rj-pl-card:hover .rj-pl-btn svg { transform: translateX(4px); }
        #{{ $uid }} .rj-pl-btn:focus-visible { outline: 2px solid rgba(255, 255, 255, 0.6); outline-offset: 4px; }

        #{{ $uid }} .rj-pl-empty {
            padding: 56px 24px;
            text-align: center;
            border-radius: 20px;
            border: 1px dashed rgba(255, 255, 255, 0.14);
            color: rgba(255, 255, 255, 0.4);
            font-size: 14px;
        }

        @media (max-width: 768px) {
            #{{ $uid }}.rj-pl-section { padding: 64px 20px; }
            #{{ $uid }} .rj-pl-header { margin-bottom: 36px; }
            #{{ $uid }} .rj-pl-grid { gap: 16px; }
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
    })();
    </script>
</section>