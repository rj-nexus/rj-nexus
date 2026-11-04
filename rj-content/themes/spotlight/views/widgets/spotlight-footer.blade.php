@php
    $uid = 'ft_' . substr(md5(uniqid('', true)), 0, 8);

    $logoImage = $settings['logo_image'] ?? '';
    $logoText = $settings['logo_text'] ?? 'RJ Nexus';
    $tagline = $settings['tagline'] ?? '';

    $columns = $settings['columns'] ?? [];
    if (!is_array($columns)) $columns = [];

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
                        @if($logoImage)
                            <img src="{{ $logoImage }}" alt="{{ $logoText }}">
                        @else
                            <svg class="rj-ft-logo-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M15 9L9 15M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <span>{{ $logoText }}</span>
                        @endif
                    </a>
                </div>

                {{-- Sağ tərəf: Linklər --}}
                <div class="rj-ft-col-links">
                    @foreach($columns as $col)
                        @php
                            $lines = preg_split('/\r\n|\r|\n/', (string) ($col['links'] ?? ''));
                            $lines = array_filter(array_map('trim', $lines));
                        @endphp
                        <div class="rj-ft-link-group">
                            <h4 class="rj-ft-title">{{ $col['title'] ?? '' }}</h4>
                            <ul class="rj-ft-list">
                                @foreach($lines as $line)
                                    @php
                                        $parts = array_pad(array_map('trim', explode('|', $line, 2)), 2, '#');
                                        $label = str_replace(['Qore', 'qore'], 'RJ Nexus', $parts[0]);
                                        $url = $parts[1] ?: '#';
                                    @endphp
                                    <li>
                                        <a href="{{ $url }}" class="rj-ft-link" @if(str_starts_with($url, 'http')) target="_blank" rel="noopener noreferrer" @endif>
                                            {{ $label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
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
            background: var(--rj-bg);
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
