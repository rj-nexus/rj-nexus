@php
    $uid = 'tabs_' . substr(md5(uniqid('', true)), 0, 8);

    $resolve = function ($url, $media) {
        if (!empty($url)) return $url;
        if (empty($media)) return '';
        if (\Illuminate\Support\Str::startsWith($media, ['http://', 'https://'])) return $media;
        if (\Illuminate\Support\Str::startsWith($media, ['media/', '/media/'])) return asset(ltrim($media, '/'));
        return \Illuminate\Support\Facades\Storage::url($media);
    };

    $tabs = $settings['tabs'] ?? [];
    if (!is_array($tabs)) $tabs = [];

    // Maksimum 9 tab limiti
    $tabs = array_slice($tabs, 0, 9);

    // Əgər heç bir tab yoxdursa, standart göstər
    if (empty($tabs)) {
        $tabs = [
            ['tab_title' => 'Tab 1', 'content_title' => 'Title 1', 'content_text' => 'Text 1', 'content_image' => ''],
            ['tab_title' => 'Tab 2', 'content_title' => 'Title 2', 'content_text' => 'Text 2', 'content_image' => ''],
            ['tab_title' => 'Tab 3', 'content_title' => 'Title 3', 'content_text' => 'Text 3', 'content_image' => ''],
        ];
    }
@endphp

<section class="rj-tabs-section" id="{{ $uid }}">
    <div class="rj-tabs-lines-top"></div>

    <div class="rj-tabs-inner">
        {{-- Naviqasiya (Tablar) --}}
        <div class="rj-tabs-nav" role="tablist">
            @foreach($tabs as $index => $tab)
                <button class="rj-tabs-btn {{ $index === 0 ? 'is-active' : '' }}"
                        role="tab"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        data-target="{{ $uid }}_panel_{{ $index }}">
                    <span class="rj-tabs-btn-text">{{ $tab['tab_title'] ?? '' }}</span>
                    <span class="rj-tabs-btn-glow"></span>
                </button>
            @endforeach
        </div>

        {{-- Məzmun Panelləri --}}
        <div class="rj-tabs-content">
            @foreach($tabs as $index => $tab)
                @php
                    $img = $resolve($tab['content_image'] ?? '', '');
                @endphp

                <div class="rj-tabs-panel {{ $index === 0 ? 'is-active' : '' }}"
                     id="{{ $uid }}_panel_{{ $index }}"
                     role="tabpanel">

                    <div class="rj-tabs-panel-text">
                        <h3 class="rj-tabs-title">{{ $tab['content_title'] ?? '' }}</h3>
                        <p class="rj-tabs-desc">{{ $tab['content_text'] ?? '' }}</p>
                    </div>

                    @if($img)
                        <div class="rj-tabs-panel-media">
                            <img src="{{ $img }}" alt="{{ $tab['content_title'] ?? '' }}" loading="lazy">
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="rj-tabs-lines-bottom"></div>

    <style>
        #{{ $uid }}.rj-tabs-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 80px 24px 100px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* Glass Xətlər */
        #{{ $uid }} .rj-tabs-lines-top,
        #{{ $uid }} .rj-tabs-lines-bottom {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: var(--rj-container);
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1) 15%, rgba(255,255,255,0.1) 85%, transparent);
        }
        #{{ $uid }} .rj-tabs-lines-top { top: 0; }
        #{{ $uid }} .rj-tabs-lines-bottom { bottom: 0; }

        #{{ $uid }} .rj-tabs-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Naviqasiya */
        #{{ $uid }} .rj-tabs-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 48px;
            background: rgba(255, 255, 255, 0.02);
            padding: 6px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #{{ $uid }} .rj-tabs-btn {
            position: relative;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            color: var(--rj-muted);
            background: transparent;
            border: 1px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            overflow: hidden;
        }

        #{{ $uid }} .rj-tabs-btn:hover {
            color: var(--rj-text);
            background: rgba(255, 255, 255, 0.05);
        }

        #{{ $uid }} .rj-tabs-btn.is-active {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Aktiv tabın altındakı parlaq xətt */
        #{{ $uid }} .rj-tabs-btn-glow {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--rj-primary);
            box-shadow: 0 0 12px var(--rj-primary);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        #{{ $uid }} .rj-tabs-btn.is-active .rj-tabs-btn-glow {
            width: 40%;
        }

        /* Məzmun Sahəsi */
        #{{ $uid }} .rj-tabs-content {
            position: relative;
            width: 100%;
            display: grid;
        }

        #{{ $uid }} .rj-tabs-panel {
            grid-area: 1 / 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        #{{ $uid }} .rj-tabs-panel.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            z-index: 2;
        }

        /* Mətn */
        #{{ $uid }} .rj-tabs-panel-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-right: 20px;
        }

        #{{ $uid }} .rj-tabs-title {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: #fff;
            margin: 0 0 20px;
        }

        #{{ $uid }} .rj-tabs-desc {
            font-size: 16px;
            line-height: 1.7;
            color: var(--rj-muted);
            margin: 0;
        }

        /* Şəkil */
        #{{ $uid }} .rj-tabs-panel-media {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.5);
            background: var(--rj-surface);
            aspect-ratio: 16 / 10;
        }

        #{{ $uid }} .rj-tabs-panel-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        #{{ $uid }} .rj-tabs-panel.is-active .rj-tabs-panel-media img {
            transform: scale(1.02);
        }

        /* Şəkilsiz hal üçün */
        #{{ $uid }} .rj-tabs-panel:not(:has(.rj-tabs-panel-media)) {
            grid-template-columns: 1fr;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        #{{ $uid }} .rj-tabs-panel:not(:has(.rj-tabs-panel-media)) .rj-tabs-panel-text {
            padding-right: 0;
            align-items: center;
        }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-tabs-panel {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 32px;
            }
            #{{ $uid }} .rj-tabs-panel-text {
                padding-right: 0;
                align-items: center;
            }
            #{{ $uid }} .rj-tabs-panel-media {
                max-width: 600px;
                margin: 0 auto;
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-tabs-section { padding: 60px 20px; }
            #{{ $uid }} .rj-tabs-nav {
                flex-direction: column;
                width: 100%;
            }
            #{{ $uid }} .rj-tabs-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <script>
    (function() {
        var root = document.getElementById(@js($uid));
        if (!root) return;

        var buttons = root.querySelectorAll('.rj-tabs-btn');
        var panels = root.querySelectorAll('.rj-tabs-panel');

        buttons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');

                // Bütün düymələrdən active-i sil
                buttons.forEach(function(b) {
                    b.classList.remove('is-active');
                    b.setAttribute('aria-selected', 'false');
                });

                // Bütün panellərdən active-i sil
                panels.forEach(function(p) {
                    p.classList.remove('is-active');
                });

                // Kliklənənə active ver
                this.classList.add('is-active');
                this.setAttribute('aria-selected', 'true');

                var targetPanel = document.getElementById(targetId);
                if (targetPanel) {
                    targetPanel.classList.add('is-active');
                }
            });
        });
    })();
    </script>
</section>
