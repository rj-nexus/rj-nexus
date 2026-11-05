@php
    $uid = 'team_' . substr(md5(uniqid('', true)), 0, 8);

    $title = $settings['title'] ?? '';
    $subtitle = $settings['subtitle'] ?? '';

    $members = $settings['members'] ?? [];
    if (!is_array($members)) $members = [];
    $members = array_slice(array_values($members), 0, 9);

    // GitHub Raw linkinə çevirmək üçün funksiya
    $toRaw = function($url) {
        if (str_contains($url, 'github.com') && str_contains($url, '/blob/')) {
            return str_replace(['github.com/', '/blob/'], ['raw.githubusercontent.com/', '/'], $url);
        }
        return $url;
    };

    // Demo şəkillərin bazası (Sənin githubuna uyğun)
    $demoBase = 'https://raw.githubusercontent.com/rj-nexus/spotlight/main/assets/demo_image/';
@endphp

<section class="rj-team-section" id="{{ $uid }}">
    <div class="rj-team-inner">

        @if($title || $subtitle)
            <div class="rj-team-header">
                @if($title)
                    <h2 class="rj-team-title">{{ $title }}</h2>
                @endif
                @if($subtitle)
                    <p class="rj-team-sub">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        @if(!empty($members))
            <div class="rj-team-grid">
                @foreach($members as $index => $member)
                    @php
                        // Əgər istifadəçi şəkil yükləməyibsə, team1.webp - team6.webp arasından seçirik
                        $imgUrl = trim($member['image'] ?? '');

                        if ($imgUrl === '') {
                            $demoIndex = ($index % 6) + 1; // 1-dən 6-ya kimi dövr edir
                            $imgUrl = $demoBase . 'team' . $demoIndex . '.webp';
                        } else {
                            $imgUrl = $toRaw($imgUrl);
                        }
                    @endphp

                    <div class="rj-team-card" style="--i: {{ $index }};">
                        <div class="rj-team-image-wrap">
                            <img src="{{ $imgUrl }}" alt="{{ $member['name'] ?? '' }}" loading="lazy">
                            <div class="rj-team-overlay"></div>
                        </div>
                        <div class="rj-team-info">
                            <h3 class="rj-team-name">{{ $member['name'] ?? '' }}</h3>
                            <p class="rj-team-role">{{ $member['role'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <style>
        #{{ $uid }}.rj-team-section {
            position: relative;
            width: 100%;
            background: transparent;
            padding: 100px 24px;
        }

        #{{ $uid }} .rj-team-inner {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
        }

        #{{ $uid }} .rj-team-header {
            text-align: center;
            margin-bottom: 56px;
        }
        #{{ $uid }} .rj-team-title {
            font-size: clamp(32px, 4vw, 48px);
            font-weight: 600;
            letter-spacing: -0.03em;
            color: #fff;
            margin: 0 0 16px;
        }
        #{{ $uid }} .rj-team-sub {
            font-size: 16px;
            line-height: 1.6;
            color: var(--rj-muted);
            margin: 0 auto;
            max-width: 600px;
        }

        /* Grid Sistemi */
        #{{ $uid }} .rj-team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        /* Kart Dizaynı */
        #{{ $uid }} .rj-team-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: var(--rj-surface);
            border: 1px solid rgba(255, 255, 255, 0.08);
            aspect-ratio: 3 / 4;
            cursor: pointer;
            transition: border-color 0.3s ease, transform 0.3s ease;
        }

        #{{ $uid }} .rj-team-card:hover {
            border-color: rgba(59, 130, 246, 0.4);
            transform: translateY(-4px);
        }

        #{{ $uid }} .rj-team-image-wrap {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        #{{ $uid }} .rj-team-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        #{{ $uid }} .rj-team-card:hover .rj-team-image-wrap img {
            transform: scale(1.05);
        }

        /* Qradient Örtük (Text oxunaqlı olsun deyə) */
        #{{ $uid }} .rj-team-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(10, 10, 15, 0.95) 0%,
                rgba(10, 10, 15, 0.6) 30%,
                transparent 60%
            );
            pointer-events: none;
        }

        /* Ad və Vəzifə */
        #{{ $uid }} .rj-team-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 24px;
            z-index: 2;
            text-align: left;
        }

        #{{ $uid }} .rj-team-name {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0 0 4px;
            letter-spacing: -0.01em;
        }

        #{{ $uid }} .rj-team-role {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }

        /* Mobil Uyğunluq */
        @media (max-width: 968px) {
            #{{ $uid }} .rj-team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 640px) {
            #{{ $uid }}.rj-team-section { padding: 60px 20px; }
            #{{ $uid }} .rj-team-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }
            #{{ $uid }} .rj-team-header { margin-bottom: 32px; }
        }
    </style>
</section>
