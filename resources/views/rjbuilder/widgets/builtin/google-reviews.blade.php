@php
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Cache;

    $title         = $settings['title'] ?? '';
    $subtitle      = $settings['subtitle'] ?? '';
    $mode          = $settings['mode'] ?? 'manual';
    $placeId       = trim($settings['place_id'] ?? '');
    $apiKey        = trim($settings['api_key'] ?? '');
    $mapsUrl       = trim($settings['google_maps_url'] ?? '');
    $overallRating = $settings['overall_rating'] ?? '5.0';
    $reviewCount   = $settings['review_count'] ?? '';
    $layout        = $settings['layout'] ?? 'grid';
    $columns       = (int) ($settings['columns'] ?? 3);
    $cardStyle     = $settings['card_style'] ?? 'card';
    $starColor     = $settings['star_color'] ?? '#fbbf24';
    $accent        = $settings['accent'] ?? '#4285F4';
    $showAvatar    = $settings['show_avatar'] ?? true;
    $showDate      = $settings['show_date'] ?? true;
    $showBadge     = $settings['show_google_badge'] ?? true;
    $showSummary   = $settings['show_summary'] ?? true;
    $radius        = $settings['radius'] ?? 'lg';
    $paddingY      = (int) ($settings['padding_y'] ?? 60);

    $radiusMap = ['none' => '0px', 'md' => '10px', 'lg' => '16px', 'xl' => '24px'];
    $radiusCss = $radiusMap[$radius] ?? '16px';

    $reviews = [];
    $fetchedRating = null;
    $fetchedTotal = null;

    if ($mode === 'api' && $placeId !== '' && $apiKey !== '') {
        $cacheKey = 'rj_gr_' . md5($placeId . '|' . app()->getLocale());
        $apiData = Cache::remember($cacheKey, now()->addHours(6), function () use ($placeId, $apiKey) {
            try {
                $lang = app()->getLocale() ?: 'en';
                $res = Http::timeout(6)->get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'fields'   => 'name,rating,user_ratings_total,reviews',
                    'language' => $lang,
                    'key'      => $apiKey,
                ]);
                if ($res->ok()) {
                    $body = $res->json();
                    if (($body['status'] ?? '') === 'OK' && isset($body['result'])) {
                        return $body['result'];
                    }
                }
            } catch (\Throwable $e) {}
            return null;
        });

        if (is_array($apiData)) {
            $fetchedRating = $apiData['rating'] ?? null;
            $fetchedTotal  = $apiData['user_ratings_total'] ?? null;
            foreach (($apiData['reviews'] ?? []) as $rv) {
                $reviews[] = [
                    'author' => $rv['author_name'] ?? '',
                    'avatar' => $rv['profile_photo_url'] ?? '',
                    'rating' => (int) ($rv['rating'] ?? 5),
                    'text'   => $rv['text'] ?? '',
                    'date'   => $rv['relative_time_description'] ?? '',
                    'link'   => $rv['author_url'] ?? '',
                ];
            }
        }
    }

    if (empty($reviews) && !empty($settings['reviews']) && is_array($settings['reviews'])) {
        foreach ($settings['reviews'] as $row) {
            if (!is_array($row)) continue;
            if (empty($row['author']) && empty($row['text'])) continue;
            $reviews[] = [
                'author' => $row['author'] ?? '',
                'avatar' => $row['avatar'] ?? '',
                'rating' => max(1, min(5, (int) ($row['rating'] ?? 5))),
                'text'   => $row['text'] ?? '',
                'date'   => $row['date'] ?? '',
                'link'   => $row['link'] ?? '',
            ];
        }
    }

    $displayRating = $fetchedRating !== null ? (float) $fetchedRating : (float) $overallRating;
    $displayTotal  = $fetchedTotal !== null ? (int) $fetchedTotal : $reviewCount;

    $initials = function (string $name): string {
        $name = trim($name);
        if ($name === '') return '?';
        $parts = preg_split('/\s+/u', $name) ?: [];
        if (count($parts) === 1) {
            return mb_strtoupper(mb_substr($parts[0], 0, 1));
        }
        return mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[count($parts) - 1], 0, 1));
    };

    $renderStars = function (float $value, string $color): string {
        $out = '';
        for ($i = 1; $i <= 5; $i++) {
            $fill = 0;
            if ($value >= $i) $fill = 100;
            elseif ($value > $i - 1) $fill = ($value - ($i - 1)) * 100;
            $id = 'sg' . uniqid() . $i;

            $out .= '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true">'
                . '<defs><linearGradient id="' . $id . '">'
                . '<stop offset="' . $fill . '%" stop-color="' . e($color) . '"/>'
                . '<stop offset="' . $fill . '%" stop-color="#e5e7eb"/>'
                . '</linearGradient></defs>'
                . '<path fill="url(#' . $id . ')" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>'
                . '</svg>';
        }
        return $out;
    };
@endphp

<style>
    #{{ $uid }} {
        --gr-accent: {{ $accent }};
        --gr-star: {{ $starColor }};
        width: 100%;
        padding: {{ $paddingY }}px 16px;
    }
    #{{ $uid }} .rj-gr-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    #{{ $uid }} .rj-gr-head {
        text-align: center;
        margin-bottom: 28px;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $uid }} .rj-gr-sub {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--gr-accent);
        margin: 0 0 8px;
    }
    #{{ $uid }} .rj-gr-title {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        margin: 0;
    }
    @media (min-width: 768px) {
        #{{ $uid }} .rj-gr-title { font-size: 38px; }
    }

    /* ---------- SUMMARY ---------- */
    #{{ $uid }} .rj-gr-summary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px 32px;
        padding: 22px 26px;
        border-radius: {{ $radiusCss }};
        background: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 12px 32px -18px rgba(15,23,42,.18);
        margin: 0 auto 32px;
        max-width: 640px;
    }
    #{{ $uid }} .rj-gr-rating-num {
        font-size: 42px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        letter-spacing: -.02em;
    }
    #{{ $uid }} .rj-gr-rating-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    #{{ $uid }} .rj-gr-stars {
        display: inline-flex;
        gap: 2px;
        align-items: center;
    }
    #{{ $uid }} .rj-gr-total {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }
    #{{ $uid }} .rj-gr-g-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 10px;
        background: var(--gr-accent);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: opacity .2s ease, transform .15s ease;
    }
    #{{ $uid }} .rj-gr-g-link:hover { opacity: .92; }
    #{{ $uid }} .rj-gr-g-link:active { transform: scale(.98); }
    #{{ $uid }} .rj-gr-g-link svg { width: 14px; height: 14px; }

    /* ---------- GRID / CAROUSEL ---------- */
    #{{ $uid }} .rj-gr-grid {
        display: grid;
        gap: 18px;
        grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-gr-grid { grid-template-columns: repeat({{ $columns > 2 ? 2 : 1 }}, minmax(0, 1fr)); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-gr-grid { grid-template-columns: 1fr; }
    }

    #{{ $uid }} .rj-gr-carousel {
        display: flex;
        gap: 18px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 10px;
        -webkit-overflow-scrolling: touch;
    }
    #{{ $uid }} .rj-gr-carousel .rj-gr-card {
        flex: 0 0 auto;
        width: calc((100% - 18px * ({{ $columns }} - 1)) / {{ $columns }});
        scroll-snap-align: start;
    }
    @media (max-width: 960px) {
        #{{ $uid }} .rj-gr-carousel .rj-gr-card { width: calc((100% - 18px) / 2); }
    }
    @media (max-width: 560px) {
        #{{ $uid }} .rj-gr-carousel .rj-gr-card { width: 85%; }
    }

    /* ---------- CARD ---------- */
    #{{ $uid }} .rj-gr-card {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 22px 20px;
        border-radius: {{ $radiusCss }};
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    #{{ $uid }} .rj-gr-card:hover {
        transform: translateY(-3px);
    }

    #{{ $uid }}[data-card="card"] .rj-gr-card {
        background: #fff;
        border: 1px solid #eef2f7;
        box-shadow: 0 14px 32px -20px rgba(15,23,42,.22);
    }
    #{{ $uid }}[data-card="card"] .rj-gr-card:hover {
        box-shadow: 0 22px 40px -20px rgba(15,23,42,.28);
    }
    #{{ $uid }}[data-card="bordered"] .rj-gr-card {
        background: #fff;
        border: 1.5px solid #e5e7eb;
    }
    #{{ $uid }}[data-card="bordered"] .rj-gr-card:hover {
        border-color: var(--gr-accent);
    }
    #{{ $uid }}[data-card="minimal"] .rj-gr-card {
        background: transparent;
        border: 0;
        padding: 8px 4px;
    }
    #{{ $uid }}[data-card="glass"] .rj-gr-card {
        background: rgba(255,255,255,.55);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.7);
        box-shadow: 0 12px 32px -20px rgba(15,23,42,.2);
    }

    #{{ $uid }} .rj-gr-card-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    #{{ $uid }} .rj-gr-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--gr-accent), #34a853);
        color: #fff;
        font-size: 15px;
        font-weight: 800;
    }
    #{{ $uid }} .rj-gr-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    #{{ $uid }} .rj-gr-author {
        flex: 1;
        min-width: 0;
    }
    #{{ $uid }} .rj-gr-name {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 2px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    #{{ $uid }} .rj-gr-date {
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 500;
    }

    #{{ $uid }} .rj-gr-stars-row {
        display: inline-flex;
        gap: 2px;
        align-items: center;
        margin-bottom: 10px;
    }

    #{{ $uid }} .rj-gr-text {
        font-size: 13.5px;
        line-height: 1.65;
        color: #334155;
        margin: 0 0 16px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #{{ $uid }} .rj-gr-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 6px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        font-size: 10.5px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: .02em;
        text-decoration: none;
        align-self: flex-start;
        transition: background .2s ease, border-color .2s ease;
    }
    #{{ $uid }} .rj-gr-badge:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1e40af;
    }
    #{{ $uid }} .rj-gr-badge svg {
        width: 12px;
        height: 12px;
    }

    #{{ $uid }} .rj-gr-empty {
        max-width: 480px;
        margin: 0 auto;
        padding: 40px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        font-size: 14px;
    }

    #{{ $uid }} .rj-gr-api-note {
        max-width: 640px;
        margin: 0 auto 20px;
        padding: 10px 14px;
        font-size: 11.5px;
        color: #b45309;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 8px;
        text-align: center;
    }

    @media (prefers-reduced-motion: reduce) {
        #{{ $uid }} *,
        #{{ $uid }} *::before,
        #{{ $uid }} *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div id="{{ $uid }}" data-card="{{ $cardStyle }}">
    <div class="rj-gr-inner">
        @if($title || $subtitle)
            <header class="rj-gr-head">
                @if($subtitle)
                    <p class="rj-gr-sub">{{ $subtitle }}</p>
                @endif
                @if($title)
                    <h2 class="rj-gr-title">{{ $title }}</h2>
                @endif
            </header>
        @endif

        @if($mode === 'api' && empty($reviews) && $placeId !== '')
            <div class="rj-gr-api-note">
                {{ __('Google reviews could not be fetched. Showing manual reviews instead, or check your API key / Place ID.') }}
            </div>
        @endif

        @if($showSummary && $displayRating > 0)
            <div class="rj-gr-summary">
                <div style="display:flex; align-items:center; gap:14px;">
                    <span class="rj-gr-rating-num">{{ number_format($displayRating, 1) }}</span>
                    <div class="rj-gr-rating-meta">
                        <span class="rj-gr-stars">{!! $renderStars($displayRating, $starColor) !!}</span>
                        @if($displayTotal)
                            <span class="rj-gr-total">{{ __('Based on :n reviews', ['n' => $displayTotal]) }}</span>
                        @endif
                    </div>
                </div>

                @if($mapsUrl !== '')
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="rj-gr-g-link">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        <span>{{ __('View all on Google') }}</span>
                    </a>
                @endif
            </div>
        @endif

        @if(!empty($reviews))
            @if($layout === 'carousel')
                <div class="rj-gr-carousel">
                    @foreach($reviews as $rv)
                        @include('rjbuilder.widgets.builtin.partials.google-review-card', ['rv' => $rv, 'showAvatar' => $showAvatar, 'showDate' => $showDate, 'showBadge' => $showBadge, 'starColor' => $starColor, 'renderStars' => $renderStars, 'initials' => $initials])
                    @endforeach
                </div>
            @else
                <div class="rj-gr-grid">
                    @foreach($reviews as $rv)
                        @include('rjbuilder.widgets.builtin.partials.google-review-card', ['rv' => $rv, 'showAvatar' => $showAvatar, 'showDate' => $showDate, 'showBadge' => $showBadge, 'starColor' => $starColor, 'renderStars' => $renderStars, 'initials' => $initials])
                    @endforeach
                </div>
            @endif
        @else
            <div class="rj-gr-empty">{{ __('No reviews yet. Add reviews manually or configure Google Places API.') }}</div>
        @endif
    </div>
</div>
