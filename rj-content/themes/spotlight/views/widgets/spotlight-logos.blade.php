@php
    $uid = 'logos_' . substr(md5(uniqid('', true)), 0, 8);
    $title = $settings['title_text'] ?? '';

    $logos = [];
    if (!empty($settings['logos'])) {
        $lines = preg_split('/\r\n|\r|\n/', $settings['logos']);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '') {
                // GitHub blob linkini jsDelivr CDN linkinə çeviririk (MIME problemini həll edir)
                if (str_contains($line, 'github.com') && str_contains($line, '/blob/')) {
                    $line = str_replace(
                        ['github.com/', '/blob/'],
                        ['cdn.jsdelivr.net/gh/', '/'],
                        $line
                    );
                }
                // Əgər raw linkdirsə
                elseif (str_contains($line, 'raw.githubusercontent.com')) {
                    $line = str_replace(
                        'raw.githubusercontent.com/',
                        'cdn.jsdelivr.net/gh/',
                        $line
                    );
                }
                $logos[] = $line;
            }
        }
    }
@endphp

<section class="rj-logos-section" id="{{ $uid }}">
    <div class="rj-logos-lines-top"></div>

    <div class="rj-logos-inner">
        @if($title)
            <div class="rj-logos-badge">
                <span class="rj-logos-badge-text">{{ $title }}</span>
            </div>
        @endif

        @if(!empty($logos))
            <div class="rj-logos-grid">
                @foreach($logos as $index => $logo)
                    <div class="rj-logo-item" style="--i: {{ $index }};">
                        <img src="{{ $logo }}"
                             alt="Trusted Partner"
                             loading="lazy"
                             referrerpolicy="no-referrer"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <span class="rj-logo-fallback" style="display:none;">LOGO {{ $index + 1 }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="rj-logos-lines-bottom"></div>

    <style>
        #{{ $uid }}.rj-logos-section {
            position: relative;
            width: 100%;
            background: var(--rj-bg);
            padding: 60px 24px 80px;
            overflow: hidden;
            border-bottom: 1px solid var(--rj-border);
        }

        #{{ $uid }}::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 100%;
            background: radial-gradient(ellipse at center, rgba(255,255,255,0.03) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        #{{ $uid }} .rj-logos-inner {
            position: relative;
            z-index: 1;
            max-width: var(--rj-container);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 48px;
        }

        #{{ $uid }} .rj-logos-lines-top,
        #{{ $uid }} .rj-logos-lines-bottom {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: var(--rj-container);
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15) 15%, rgba(255,255,255,0.15) 85%, transparent);
        }
        #{{ $uid }} .rj-logos-lines-top { top: 0; }
        #{{ $uid }} .rj-logos-lines-bottom { bottom: 0; }

        #{{ $uid }} .rj-logos-badge {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
        }
        #{{ $uid }} .rj-logos-badge-text {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.85); /* Təmiz Ağ */
        }

        #{{ $uid }} .rj-logos-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 60px 80px;
            width: 100%;
        }

        #{{ $uid }} .rj-logo-item {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 100px;
            min-height: 30px;
            opacity: 0;
            animation: rjLogoFadeIn 0.8s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }

        #{{ $uid }} .rj-logo-item img {
            height: 28px;
            max-width: 140px;
            width: auto;
            object-fit: contain;
            /* Loqoların təbii ağ rəngini saxlayırıq, sadəcə şəffaflıq veririk */
            opacity: 0.5;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Hover edəndə parlaq ağ olsun */
        #{{ $uid }} .rj-logo-item:hover img {
            opacity: 1;
            transform: scale(1.05);
        }

        /* Şəkil yüklənməzsə görünəcək ehtiyat mətn */
        #{{ $uid }} .rj-logo-fallback {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.05);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            border-radius: 6px;
            padding: 8px 16px;
            white-space: nowrap;
        }

        @media (max-width: 968px) {
            #{{ $uid }} .rj-logos-grid { gap: 40px 50px; }
            #{{ $uid }} .rj-logo-item img { height: 24px; max-width: 110px; }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-logos-section { padding: 40px 20px 60px; }
            #{{ $uid }} .rj-logos-inner { gap: 32px; }
            #{{ $uid }} .rj-logos-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 32px 20px;
                justify-items: center;
            }
            #{{ $uid }} .rj-logo-item img { height: 20px; max-width: 90px; }
        }

        @keyframes rjLogoFadeIn {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</section>
