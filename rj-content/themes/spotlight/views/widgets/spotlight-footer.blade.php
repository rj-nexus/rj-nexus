@php
    $uid = 'ft_' . substr(md5(uniqid('', true)), 0, 8);

    $logoImage = trim((string) ($settings['logo_image'] ?? ''));
    $logoText = trim((string) ($settings['logo_text'] ?? 'RJ Nexus'));
    $tagline = $settings['tagline'] ?? '';

    $menu1Id = $settings['menu_1_id'] ?? '';
    $menu2Id = $settings['menu_2_id'] ?? '';
    $menu3Id = $settings['menu_3_id'] ?? '';

    $allMenus = function_exists('rj_menu_tree') ? rj_menu_tree() : [];

    $menu1 = !empty($menu1Id) && isset($allMenus[$menu1Id]) ? $allMenus[$menu1Id] : null;
    $menu2 = !empty($menu2Id) && isset($allMenus[$menu2Id]) ? $allMenus[$menu2Id] : null;
    $menu3 = !empty($menu3Id) && isset($allMenus[$menu3Id]) ? $allMenus[$menu3Id] : null;

    $showCopyright = filter_var($settings['show_copyright'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $copyrightText = $settings['copyright_text'] ?? '© ' . date('Y') . ' RJ NEXUS. ALL RIGHTS RESERVED.';
    $showBackToTop = filter_var($settings['show_back_to_top'] ?? true, FILTER_VALIDATE_BOOLEAN);
@endphp

<footer class="rj-ft-section" id="{{ $uid }}">

    <div class="rj-ft-inner">

        {{-- Arxadakı mükəmməl grid xətləri --}}
        <div class="rj-ft-grid-lines" aria-hidden="true">
            <span class="rj-g-line rj-g-v-left"></span>
            <span class="rj-g-line rj-g-v-center"></span>
            <span class="rj-g-line rj-g-v-right"></span>
            <span class="rj-g-line rj-g-h-top"></span>
            <span class="rj-g-line rj-g-h-mid"></span>
            <span class="rj-g-line rj-g-h-bot"></span>

            <span class="rj-g-cross rj-g-c-tl">+</span>
            <span class="rj-g-cross rj-g-c-tr">+</span>
            <span class="rj-g-cross rj-g-c-bl">+</span>
            <span class="rj-g-cross rj-g-c-br">+</span>
        </div>

        <div class="rj-ft-content">

            <div class="rj-ft-row">
                {{-- Sol tərəf: Loqo --}}
                <div class="rj-ft-col-brand">
                    <a href="{{ url('/') }}" class="rj-ft-logo">
                        @if($logoImage !== '')
                            <img src="{{ $logoImage }}" alt="{{ $logoText }}">
                        @elseif($logoText !== '')
                            <span>{{ $logoText }}</span>
                        @else
                            <svg class="rj-ft-logo-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>RJ Nexus</span>
                        @endif
                    </a>
                    @if($tagline)
                        <p class="rj-ft-tagline">{{ $tagline }}</p>
                    @endif
                </div>

                {{-- Sağ tərəf: Dinamik Menyular --}}
                <div class="rj-ft-col-links">

                    {{-- 1-ci Sütun --}}
                    <div class="rj-ft-link-group">
                        <h4 class="rj-ft-title">{{ $menu1 ? $menu1['name'] : 'PRODUCT' }}</h4>
                        <ul class="rj-ft-list">
                            @if($menu1 && !empty($menu1['items']))
                                @foreach($menu1['items'] as $item)
                                    <li><a href="{{ $item['url'] }}" class="rj-ft-link" target="{{ $item['target'] ?? '_self' }}">{{ $item['label'] }}</a></li>
                                @endforeach
                            @else
                                <li><a href="#" class="rj-ft-link">Features</a></li>
                                <li><a href="#" class="rj-ft-link">Benefits</a></li>
                                <li><a href="#" class="rj-ft-link">Pricing</a></li>
                            @endif
                        </ul>
                    </div>

                    {{-- 2-ci Sütun --}}
                    <div class="rj-ft-link-group">
                        <h4 class="rj-ft-title">{{ $menu2 ? $menu2['name'] : 'LEGALS' }}</h4>
                        <ul class="rj-ft-list">
                            @if($menu2 && !empty($menu2['items']))
                                @foreach($menu2['items'] as $item)
                                    <li><a href="{{ $item['url'] }}" class="rj-ft-link" target="{{ $item['target'] ?? '_self' }}">{{ $item['label'] }}</a></li>
                                @endforeach
                            @else
                                <li><a href="#" class="rj-ft-link">Privacy Policy</a></li>
                                <li><a href="#" class="rj-ft-link">Terms & Conditions</a></li>
                            @endif
                        </ul>
                    </div>

                    {{-- 3-cü Sütun --}}
                    <div class="rj-ft-link-group">
                        <h4 class="rj-ft-title">{{ $menu3 ? $menu3['name'] : 'SOCIAL' }}</h4>
                        <ul class="rj-ft-list">
                            @if($menu3 && !empty($menu3['items']))
                                @foreach($menu3['items'] as $item)
                                    <li><a href="{{ $item['url'] }}" class="rj-ft-link" target="{{ $item['target'] ?? '_self' }}">{{ $item['label'] }}</a></li>
                                @endforeach
                            @else
                                <li><a href="#" class="rj-ft-link">Twitter (X)</a></li>
                                <li><a href="#" class="rj-ft-link">Github</a></li>
                                <li><a href="#" class="rj-ft-link">LinkedIn</a></li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>

            {{-- Alt hissə --}}
            @if($showCopyright || $showBackToTop)
                <div class="rj-ft-bottom-row">
                    <div class="rj-ft-copy">
                        {{ str_replace(['Qore', 'qore'], 'RJ Nexus', $copyrightText) }}
                    </div>

                    @if($showBackToTop)
                        <a href="#" class="rj-ft-top" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;">
                            BACK TO TOP
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <style>
        #{{ $uid }}.rj-ft-section {
            position: relative;
            width: 100%;
            background: var(--rj-bg); /* Arxa fon saytın əsas rəngi ilə eynidir */
            padding: 80px 0 40px;
            overflow: hidden;
            z-index: 1;
        }

        #{{ $uid }} .rj-ft-inner {
            position: relative;
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 0 24px;
        }

        /* === Mükəmməl Grid Xətləri === */
        #{{ $uid }} .rj-ft-grid-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        #{{ $uid }} .rj-g-line {
            position: absolute;
            background: rgba(255, 255, 255, 0.08);
        }

        /* Şaquli xətlər */
        #{{ $uid }} .rj-g-v-left { top: 0; bottom: 0; left: 0; width: 1px; }
        #{{ $uid }} .rj-g-v-center { top: 0; bottom: 0; left: 33.333%; width: 1px; }
        #{{ $uid }} .rj-g-v-right { top: 0; bottom: 0; right: 0; width: 1px; }

        /* Üfüqi xətlər */
        #{{ $uid }} .rj-g-h-top { top: 60px; left: 0; right: 0; height: 1px; }
        #{{ $uid }} .rj-g-h-mid { top: 50%; left: 0; right: 0; height: 1px; }
        #{{ $uid }} .rj-g-h-bot { bottom: 60px; left: 0; right: 0; height: 1px; }

        /* Kəsişmə nöqtələrindəki + işarələri */
        #{{ $uid }} .rj-g-cross {
            position: absolute;
            color: rgba(255, 255, 255, 0.3);
            font-family: monospace;
            font-size: 14px;
            line-height: 1;
            transform: translate(-50%, -50%);
        }
        #{{ $uid }} .rj-g-c-tl { top: 60px; left: 0; }
        #{{ $uid }} .rj-g-c-tr { top: 60px; right: 0; transform: translate(50%, -50%); }
        #{{ $uid }} .rj-g-c-bl { bottom: 60px; left: 0; }
        #{{ $uid }} .rj-g-c-br { bottom: 60px; right: 0; transform: translate(50%, 50%); }

        /* === Məzmun === */
        #{{ $uid }} .rj-ft-content {
            position: relative;
            z-index: 1;
            padding-top: 120px;
            padding-bottom: 40px;
        }

        #{{ $uid }} .rj-ft-row {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 60px;
        }

        /* Loqo */
        #{{ $uid }} .rj-ft-col-brand {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        #{{ $uid }} .rj-ft-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            letter-spacing: -0.02em;
            padding: 12px 0;
            position: relative;
            z-index: 2;
        }
        #{{ $uid }} .rj-ft-logo-icon {
            width: 32px;
            height: 32px;
            color: #fff;
        }
        #{{ $uid }} .rj-ft-logo img {
            max-height: 40px;
            width: auto;
        }
        #{{ $uid }} .rj-ft-tagline {
            font-size: 14px;
            line-height: 1.6;
            color: var(--rj-muted);
            max-width: 280px;
            margin: 10px 0 0;
        }

        /* Linklər */
        #{{ $uid }} .rj-ft-col-links {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }
        #{{ $uid }} .rj-ft-title {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            margin: 0 0 24px;
        }
        #{{ $uid }} .rj-ft-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        #{{ $uid }} .rj-ft-link {
            font-size: 15px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s ease;
            display: inline-block;
        }
        #{{ $uid }} .rj-ft-link:hover {
            color: #fff;
        }

        /* Alt hissə (Copyright) */
        #{{ $uid }} .rj-ft-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-top: 80px;
            padding-top: 32px;
            border-top: 1px solid transparent;
        }
        #{{ $uid }} .rj-ft-copy {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
        }
        #{{ $uid }} .rj-ft-top {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: color 0.2s;
            text-transform: uppercase;
        }
        #{{ $uid }} .rj-ft-top:hover {
            color: #fff;
        }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-ft-row {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            #{{ $uid }} .rj-ft-col-links {
                grid-template-columns: repeat(2, 1fr);
            }
            #{{ $uid }} .rj-g-v-center { display: none; }
            #{{ $uid }} .rj-ft-content { padding-top: 80px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-ft-section { padding: 60px 0 20px; }
            #{{ $uid }} .rj-ft-inner { padding: 0 20px; }
            #{{ $uid }} .rj-ft-col-links {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            #{{ $uid }} .rj-ft-content { padding-top: 60px; }
            #{{ $uid }} .rj-ft-bottom-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            #{{ $uid }} .rj-g-h-top { top: 40px; }
            #{{ $uid }} .rj-g-h-bot { bottom: 40px; }
            #{{ $uid }} .rj-g-c-tl, #{{ $uid }} .rj-g-c-tr { top: 40px; }
            #{{ $uid }} .rj-g-c-bl, #{{ $uid }} .rj-g-c-br { bottom: 40px; }
        }
    </style>
</section>
