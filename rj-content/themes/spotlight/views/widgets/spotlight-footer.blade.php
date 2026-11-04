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

    {{-- Struktur xətləri (Dizayndakı kimi) --}}
    <div class="rj-ft-lines" aria-hidden="true">
        <div class="rj-ft-line-v rj-v-left"></div>
        <div class="rj-ft-line-v rj-v-center"></div>
        <div class="rj-ft-line-v rj-v-right"></div>
        <div class="rj-ft-line-h rj-h-top"></div>
        <div class="rj-ft-line-h rj-h-middle"></div>
        <div class="rj-ft-line-h rj-h-bottom"></div>
    </div>

    <div class="rj-ft-inner">

        <div class="rj-ft-main">
            {{-- Sol tərəf: Loqo --}}
            <div class="rj-ft-brand">
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
                @if($tagline)
                    <p class="rj-ft-tagline">{{ $tagline }}</p>
                @endif
            </div>

            {{-- Sağ tərəf: Linklər --}}
            <div class="rj-ft-links-wrap">
                @foreach($columns as $col)
                    @php
                        $lines = preg_split('/\r\n|\r|\n/', (string) ($col['links'] ?? ''));
                        $lines = array_filter(array_map('trim', $lines));
                    @endphp
                    <div class="rj-ft-col">
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

        {{-- Alt hissə: Copyright və Back to top --}}
        @if($showCopyright || $showBackToTop)
            <div class="rj-ft-bottom">
                @if($showCopyright)
                    <div class="rj-ft-copy">{{ str_replace(['Qore', 'qore'], 'RJ Nexus', $copyrightText) }}</div>
                @endif

                @if($showBackToTop)
                    <a href="#" class="rj-ft-top" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;">
                        BACK TO TOP <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </a>
                @endif
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-ft-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 100px 24px 40px;
            overflow: hidden;
        }

        /* Dizayn Xətləri */
        #{{ $uid }} .rj-ft-lines {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            max-width: var(--rj-container);
            margin: 0 auto;
        }

        #{{ $uid }} .rj-ft-line-v {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 1px;
            background: rgba(255, 255, 255, 0.06);
        }
        #{{ $uid }} .rj-v-left { left: 24px; }
        #{{ $uid }} .rj-v-center { left: 40%; display: none; } /* Tablet/mobil üçün gizlədilir */
        #{{ $uid }} .rj-v-right { right: 24px; }

        #{{ $uid }} .rj-ft-line-h {
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
        }
        #{{ $uid }} .rj-h-top { top: 80px; }
        #{{ $uid }} .rj-h-middle { bottom: 80px; }
        #{{ $uid }} .rj-h-bottom { bottom: 0; }

        /* Inner Container */
        #{{ $uid }} .rj-ft-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            padding: 40px 24px;
            display: flex;
            flex-direction: column;
            gap: 100px;
        }

        /* Main: Brand + Links */
        #{{ $uid }} .rj-ft-main {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 60px;
            align-items: start;
        }

        /* Brand */
        #{{ $uid }} .rj-ft-brand {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
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
        }
        #{{ $uid }} .rj-ft-logo-icon {
            width: 32px;
            height: 32px;
            color: var(--rj-primary);
        }
        #{{ $uid }} .rj-ft-logo img {
            max-height: 40px;
            width: auto;
        }
        #{{ $uid }} .rj-ft-tagline {
            font-size: 14px;
            line-height: 1.6;
            color: var(--rj-muted);
            max-width: 300px;
            margin: 0;
        }

        /* Links Grid */
        #{{ $uid }} .rj-ft-links-wrap {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }
        #{{ $uid }} .rj-ft-title {
            font-size: 11px;
            font-weight: 700;
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
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.2s ease, transform 0.2s ease;
            display: inline-block;
        }
        #{{ $uid }} .rj-ft-link:hover {
            color: #fff;
            transform: translateX(4px);
        }

        /* Bottom Bar */
        #{{ $uid }} .rj-ft-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            flex-wrap: wrap;
        }
        #{{ $uid }} .rj-ft-copy {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
        }
        #{{ $uid }} .rj-ft-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: color 0.2s;
        }
        #{{ $uid }} .rj-ft-top:hover {
            color: #fff;
        }
        #{{ $uid }} .rj-ft-top svg {
            width: 12px;
            height: 12px;
            transition: transform 0.2s;
        }
        #{{ $uid }} .rj-ft-top:hover svg {
            transform: translateY(-3px);
        }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-ft-main {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            #{{ $uid }} .rj-v-center { display: block; left: 50%; }
            #{{ $uid }} .rj-ft-links-wrap {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-ft-section { padding: 60px 16px 20px; }
            #{{ $uid }} .rj-ft-inner { padding: 20px 8px; gap: 60px; }
            #{{ $uid }} .rj-ft-links-wrap {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            #{{ $uid }} .rj-h-top { top: 40px; }
            #{{ $uid }} .rj-h-middle { bottom: 60px; }
            #{{ $uid }} .rj-ft-bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }
    </style>
</section>
