@php
    $color = fn ($v, $d) => preg_match('/^#[0-9a-f]{3,8}$/i', (string) $v) ? $v : $d;
    $url   = fn ($v) => preg_match('#^(https?://|/)#i', (string) $v) ? (string) $v : '';

    $title        = $settings['title'] ?? '';
    $subtitle     = $settings['subtitle'] ?? '';
    $layout       = in_array($settings['layout'] ?? 'grid', ['grid', 'masonry', 'carousel'], true) ? $settings['layout'] : 'grid';
    $cardStyle    = in_array($settings['card_style'] ?? 'card', ['card', 'bordered', 'minimal', 'glass'], true) ? $settings['card_style'] : 'card';
    $cols         = max(2, min(4, (int) ($settings['columns'] ?? 3)));
    $accent       = $color($settings['accent'] ?? '', '#1a73e8');
    $star         = $color($settings['star_color'] ?? '', '#fbbc04');
    $radiusCss    = ['none' => '0px', 'md' => '10px', 'lg' => '18px', 'xl' => '28px'][$settings['radius'] ?? 'lg'] ?? '18px';
    $padY         = max(0, min(160, (int) ($settings['padding_y'] ?? 60)));
    $showAvatar   = $settings['show_avatar'] ?? true;
    $showDate     = $settings['show_date'] ?? true;
    $showBadge    = $settings['show_google_badge'] ?? true;
    $showSummary  = $settings['show_summary'] ?? true;
    $mapsUrl      = $url($settings['google_maps_url'] ?? '');
    $palette      = ['#1a73e8', '#d93025', '#e37400', '#188038'];

    $reviews = $api['reviews'] ?? [];

    if (empty($reviews) && !empty($settings['reviews']) && is_array($settings['reviews'])) {
        foreach ($settings['reviews'] as $row) {
            if (!is_array($row) || (empty($row['author']) && empty($row['text']))) continue;
            $reviews[] = [
                'author' => (string) ($row['author'] ?? ''),
                'avatar' => (string) ($row['avatar'] ?? ''),
                'rating' => (int) ($row['rating'] ?? 5),
                'text'   => (string) ($row['text'] ?? ''),
                'date'   => (string) ($row['date'] ?? ''),
                'link'   => (string) ($row['link'] ?? ''),
            ];
        }
    }

    $rating = ($api['rating'] ?? null) !== null ? (float) $api['rating'] : (float) ($settings['overall_rating'] ?? 5);
    $total  = ($api['total'] ?? null) !== null ? (int) $api['total'] : ($settings['review_count'] ?? '');

    $initials = function (string $name): string {
        $parts = preg_split('/\s+/u', trim($name), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        if (!$parts) return '?';
        $first = mb_substr($parts[0], 0, 1);
        $last  = count($parts) > 1 ? mb_substr($parts[count($parts) - 1], 0, 1) : '';

        return mb_strtoupper($first . $last);
    };
@endphp

<style>
    #{{ $uid }} {
        --accent: {{ $accent }};
        --star: {{ $star }};
        --cols: {{ $cols }};
        --gap: 20px;
        --radius: {{ $radiusCss }};
        --s: 16px;
        --ink: #0f172a;
        --muted: #64748b;
        --line: #e2e8f0;
        --mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 1.8l3.1 6.5 7.1 1-5.2 5 1.3 7.1L12 17.9l-6.3 3.5L7 14.3 1.8 9.3l7.1-1z'/%3E%3C/svg%3E");
        padding: {{ $padY }}px 16px;

        .gr-inner { max-width: 1200px; margin: 0 auto; }

        .gr-head { max-width: 640px; margin: 0 auto 32px; text-align: center; }
        .gr-sub { margin: 0 0 8px; font-size: 12px; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: var(--accent); }
        .gr-title { margin: 0; font-size: clamp(26px, 4vw, 38px); font-weight: 800; letter-spacing: -.02em; color: var(--ink); }

        .gr-stars { display: block; flex: none; width: calc(var(--s) * 5); height: var(--s); background: linear-gradient(90deg, var(--star) calc(var(--v) * 20%), #e2e8f0 0); -webkit-mask: var(--mask) 0 0 / var(--s) var(--s) repeat-x; mask: var(--mask) 0 0 / var(--s) var(--s) repeat-x; }

        .gr-sum { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 18px 28px; max-width: 700px; margin: 0 auto 36px; padding: 20px 26px; border: 1px solid var(--line); border-radius: var(--radius); background: #fff; box-shadow: 0 18px 40px -26px rgba(15, 23, 42, .3); }
        .gr-logo { display: grid; place-items: center; width: 52px; height: 52px; border-radius: 50%; background: #fff; box-shadow: 0 0 0 1px var(--line), 0 8px 20px -8px rgba(15, 23, 42, .25);
            svg { width: 26px; height: 26px; }
        }
        .gr-score { display: flex; align-items: center; gap: 14px;
            b { font-size: 46px; font-weight: 900; line-height: 1; letter-spacing: -.03em; color: var(--ink); }
            div { display: flex; flex-direction: column; gap: 6px; }
            small { font-size: 12px; font-weight: 600; color: var(--muted); }
            .gr-stars { --s: 20px; }
        }
        .gr-btn { display: inline-flex; align-items: center; gap: 10px; padding: 10px 18px 10px 12px; border: 1px solid var(--line); border-radius: 999px; background: #fff; color: var(--ink); font-size: 13px; font-weight: 700; text-decoration: none; box-shadow: 0 2px 6px rgba(15, 23, 42, .08); transition: .25s;
            svg { width: 20px; height: 20px; }
            &:hover { border-color: var(--accent); transform: translateY(-1px); box-shadow: 0 12px 24px -12px color-mix(in srgb, var(--accent) 70%, transparent); }
        }

        .gr-list { display: grid; grid-template-columns: repeat(var(--cols), minmax(0, 1fr)); gap: var(--gap);
            &[data-layout="masonry"] { display: block; column-count: var(--cols); column-gap: var(--gap);
                .gr-card { break-inside: avoid; margin-bottom: var(--gap); }
            }
            &[data-layout="carousel"] { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none; padding: 6px 2px 14px;
                &::-webkit-scrollbar { display: none; }
                .gr-card { flex: 0 0 calc((100% - var(--gap) * (var(--cols) - 1)) / var(--cols)); scroll-snap-align: start; }
            }
        }

        .gr-card { position: relative; display: flex; flex-direction: column; gap: 12px; padding: 22px 22px 18px; overflow: hidden; border: 1px solid var(--line); border-radius: var(--radius); background: #fff; transition: transform .3s cubic-bezier(.2, .8, .2, 1), box-shadow .3s, border-color .3s;
            &::after { content: "\201D"; position: absolute; right: 18px; bottom: -28px; font: 900 130px/1 Georgia, serif; color: var(--accent); opacity: .07; pointer-events: none; }
            &:hover { transform: translateY(-4px); }
        }

        &[data-card="card"] .gr-card { border-color: #eef2f7; box-shadow: 0 16px 36px -22px rgba(15, 23, 42, .3);
            &:hover { box-shadow: 0 30px 50px -24px rgba(15, 23, 42, .38); }
        }
        &[data-card="bordered"] .gr-card { padding-top: 26px; border: 1.5px solid #cfd8e6;
            &::before { content: ""; position: absolute; inset: 0 0 auto; height: 4px; background: linear-gradient(90deg, #4285f4 0 25%, #ea4335 0 50%, #fbbc04 0 75%, #34a853 0); }
            &:hover { border-color: var(--accent); box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent) 14%, transparent); }
        }
        &[data-card="minimal"] .gr-card { padding: 20px 4px 8px; border-width: 1px 0 0; border-radius: 0; background: transparent;
            &::after { display: none; }
            &:hover { transform: none; }
        }
        &[data-card="glass"] { background: radial-gradient(520px 280px at 8% 0, color-mix(in srgb, var(--accent) 24%, transparent), transparent), radial-gradient(480px 280px at 92% 100%, rgba(52, 168, 83, .2), transparent), radial-gradient(360px 220px at 60% 20%, rgba(251, 188, 4, .16), transparent);
            .gr-card { border-color: rgba(255, 255, 255, .85); background: rgba(255, 255, 255, .62); -webkit-backdrop-filter: blur(14px); backdrop-filter: blur(14px); box-shadow: 0 18px 40px -24px rgba(15, 23, 42, .3); }
        }

        .gr-corner { position: absolute; top: 14px; right: 14px; z-index: 1; display: grid; place-items: center; width: 34px; height: 34px; border-radius: 50%; background: #fff; box-shadow: 0 0 0 1px var(--line), 0 6px 14px -6px rgba(15, 23, 42, .3); transition: transform .3s;
            svg { width: 18px; height: 18px; }
        }
        .gr-card:hover .gr-corner { transform: scale(1.12) rotate(-8deg); }

        .gr-who { display: flex; align-items: center; gap: 12px; min-width: 0; padding-right: 44px;
            div { min-width: 0; }
            h3 { margin: 0 0 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 14.5px; font-weight: 700; color: var(--ink); }
            span:not(.gr-avatar) { font-size: 12px; color: #94a3b8; }
        }
        .gr-avatar { position: relative; flex: none; display: grid; place-items: center; width: 44px; height: 44px; overflow: hidden; border-radius: 50%; background: var(--av); color: #fff; font-size: 15px; font-weight: 800; box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px var(--av);
            b { font-weight: inherit; }
            img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        }

        .gr-text { position: relative; z-index: 1; flex: 1; margin: 0; font-size: 14px; line-height: 1.7; color: #334155; white-space: pre-line; display: -webkit-box; -webkit-line-clamp: 7; -webkit-box-orient: vertical; overflow: hidden; }
        .gr-more { position: relative; z-index: 1; align-self: flex-start; font-size: 12px; font-weight: 700; color: var(--accent); text-decoration: none;
            &::after { content: "\2197"; display: inline-block; margin-left: 4px; transition: transform .2s; }
            &:hover::after { transform: translate(2px, -2px); }
        }

        .gr-nav { display: flex; justify-content: center; gap: 10px; margin-top: 20px;
            button { display: grid; place-items: center; width: 44px; height: 44px; padding: 0; border: 1px solid var(--line); border-radius: 50%; background: #fff; color: var(--ink); font-size: 22px; line-height: 1; cursor: pointer; transition: .2s;
                &:hover { border-color: var(--accent); background: var(--accent); color: #fff; }
            }
        }

        .gr-note { max-width: 640px; margin: 0 auto 24px; padding: 10px 14px; border: 1px solid #fde68a; border-radius: 10px; background: #fffbeb; color: #b45309; font-size: 12px; text-align: center; }
        .gr-empty { max-width: 480px; margin: 0 auto; padding: 40px 24px; border: 1px dashed #cbd5e1; border-radius: 16px; background: #f8fafc; color: var(--muted); font-size: 14px; text-align: center; }

        @media (max-width: 960px) { --cols: {{ $cols > 2 ? 2 : 1 }}; }
        @media (max-width: 560px) { --cols: 1; .gr-list[data-layout="carousel"] .gr-card { flex-basis: 84%; } }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    }
</style>

<div id="{{ $uid }}" data-card="{{ $cardStyle }}">
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <symbol id="{{ $uid }}-g" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </symbol>
    </svg>

    <div class="gr-inner">
        @if($title || $subtitle)
            <header class="gr-head">
                @if($subtitle)<p class="gr-sub">{{ $subtitle }}</p>@endif
                @if($title)<h2 class="gr-title">{{ $title }}</h2>@endif
            </header>
        @endif

        @if(!empty($api['error']))
            <div class="gr-note">
                {{ __('Google reviews could not be fetched.') }}<br><small>{{ $api['error'] }}</small>
            </div>
        @endif

        @if($showSummary && $rating > 0)
            <div class="gr-sum">
                <span class="gr-logo"><svg><use href="#{{ $uid }}-g"/></svg></span>
                <div class="gr-score">
                    <b>{{ number_format($rating, 1) }}</b>
                    <div>
                        <span class="gr-stars" style="--v: {{ number_format($rating, 2, '.', '') }}"></span>
                        @if($total)<small>{{ __('Based on :n reviews', ['n' => $total]) }}</small>@endif
                    </div>
                </div>
                @if($mapsUrl !== '')
                    <a class="gr-btn" href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer">
                        <svg><use href="#{{ $uid }}-g"/></svg>
                        <span>{{ __('View all on Google') }}</span>
                    </a>
                @endif
            </div>
        @endif

        @if(!empty($reviews))
            <div class="gr-list" data-layout="{{ $layout }}">
                @foreach($reviews as $rv)
                    @php
                        $stars  = max(1, min(5, (int) $rv['rating']));
                        $link   = $url($rv['link']);
                        $avatar = $url($rv['avatar']);
                    @endphp
                    <article class="gr-card" style="--av: {{ $palette[crc32($rv['author']) % 4] }}">
                        @if($showBadge)
                            <span class="gr-corner"><svg><use href="#{{ $uid }}-g"/></svg></span>
                        @endif

                        <header class="gr-who">
                            @if($showAvatar)
                                <span class="gr-avatar">
                                    <b>{{ $initials($rv['author']) }}</b>
                                    @if($avatar !== '')<img src="{{ $avatar }}" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.remove()">@endif
                                </span>
                            @endif
                            <div>
                                <h3>{{ $rv['author'] }}</h3>
                                @if($showDate && $rv['date'] !== '')<span>{{ $rv['date'] }}</span>@endif
                            </div>
                        </header>

                        <span class="gr-stars" style="--v: {{ $stars }}"></span>

                        @if($rv['text'] !== '')<p class="gr-text">{{ $rv['text'] }}</p>@endif

                        @if($showBadge && $link !== '')
                            <a class="gr-more" href="{{ $link }}" target="_blank" rel="noopener noreferrer">{{ __('Posted on Google') }}</a>
                        @endif
                    </article>
                @endforeach
            </div>

            @if($layout === 'carousel')
                <div class="gr-nav">
                    <button type="button" data-dir="-1" aria-label="{{ __('Previous') }}">&#8249;</button>
                    <button type="button" data-dir="1" aria-label="{{ __('Next') }}">&#8250;</button>
                </div>
                <script>
                (function () {
                    var root = document.getElementById(@js($uid));
                    var list = root && root.querySelector('.gr-list');
                    if (!list) return;
                    root.querySelectorAll('.gr-nav button').forEach(function (b) {
                        b.addEventListener('click', function () {
                            list.scrollBy({ left: b.dataset.dir * list.clientWidth * 0.9, behavior: 'smooth' });
                        });
                    });
                })();
                </script>
            @endif
        @else
            <div class="gr-empty">{{ __('No reviews yet. Add reviews manually or configure Google Places API.') }}</div>
        @endif
    </div>
</div>
