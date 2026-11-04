@php
    $uid = 'tabs_' . substr(md5(uniqid('', true)), 0, 8);

    $tabs = $settings['tabs'] ?? [];
    if (!is_array($tabs)) $tabs = [];
    $tabs = array_slice($tabs, 0, 9);

    if (empty($tabs)) {
        $tabs = [
            ['tab_title' => 'Tab 1', 'content_title' => 'Title 1', 'content_text' => 'Text 1'],
            ['tab_title' => 'Tab 2', 'content_title' => 'Title 2', 'content_text' => 'Text 2'],
            ['tab_title' => 'Tab 3', 'content_title' => 'Title 3', 'content_text' => 'Text 3'],
        ];
    }
@endphp

<section class="rj-tabs-section" id="{{ $uid }}">
    <div class="rj-tabs-lines-top"></div>

    <div class="rj-tabs-inner">
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

        <div class="rj-tabs-content">
            @foreach($tabs as $index => $tab)
                <div class="rj-tabs-panel {{ $index === 0 ? 'is-active' : '' }}"
                     id="{{ $uid }}_panel_{{ $index }}"
                     role="tabpanel">

                    <h2 class="rj-tabs-title">{{ $tab['content_title'] ?? '' }}</h2>
                    <p class="rj-tabs-desc">{{ $tab['content_text'] ?? '' }}</p>

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
            padding: 100px 24px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

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
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #{{ $uid }} .rj-tabs-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 56px;
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
            width: 60%;
        }

        #{{ $uid }} .rj-tabs-content {
            position: relative;
            width: 100%;
            display: grid;
            text-align: center;
        }

        #{{ $uid }} .rj-tabs-panel {
            grid-area: 1 / 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
            width: 100%;
        }

        #{{ $uid }} .rj-tabs-panel.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            z-index: 2;
        }

        #{{ $uid }} .rj-tabs-title {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -0.03em;
            margin: 0 0 24px;
            background: linear-gradient(180deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            max-width: 900px;
        }

        #{{ $uid }} .rj-tabs-desc {
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0;
            max-width: 680px;
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
            #{{ $uid }} .rj-tabs-btn-glow {
                bottom: 2px;
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

                buttons.forEach(function(b) {
                    b.classList.remove('is-active');
                    b.setAttribute('aria-selected', 'false');
                });

                panels.forEach(function(p) {
                    p.classList.remove('is-active');
                });

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
