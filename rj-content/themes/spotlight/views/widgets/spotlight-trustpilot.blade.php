@php
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Cache;

    $uid = 'tp_' . substr(md5(uniqid('', true)), 0, 8);

    $apiKey = trim($settings['api_key'] ?? '');
    $buid = trim($settings['business_unit_id'] ?? '');
    $showReviews = filter_var($settings['show_reviews'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $align = $settings['align'] ?? 'center';

    $data = null;

    if ($apiKey && $buid) {
<<<<<<< HEAD
        $data = Cache::remember("tp_rating_{$buid}", 3600, function () use ($apiKey, $buid) {
            try {
                $res = Http::timeout(10)->withHeaders([
=======
        // API məlumatını 1 saat (3600 saniyə) keşləyirik
        $data = Cache::remember("tp_rating_{$buid}", 3600, function () use ($apiKey, $buid) {
            try {
                $res = Http::withHeaders([
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
                    'apikey' => $apiKey,
                ])->get("https://api.trustpilot.com/v1/business-units/{$buid}");

                if ($res->successful()) {
                    return $res->json();
                }
                return null;
            } catch (\Throwable $e) {
                return null;
            }
        });
    }

<<<<<<< HEAD
=======
    // API-dən gələn məlumatlar
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
    $score = $data['score'] ?? 0;
    $stars = $data['stars'] ?? 0;
    $reviews = $data['numberOfReviews']['total'] ?? 0;
@endphp

@if($data)
    <div class="rj-tp-widget" id="{{ $uid }}" style="text-align: {{ $align }};">
        <div class="rj-tp-inner">
            <div class="rj-tp-stars" aria-label="{{ $score }} out of 5 stars">
                @for($i = 1; $i <= 5; $i++)
                    <div class="rj-tp-star {{ $i <= $stars ? 'is-filled' : 'is-empty' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                @endfor
            </div>
            <div class="rj-tp-text">
                <span class="rj-tp-score">{{ number_format($score, 1) }}</span>
                <span class="rj-tp-label">{{ __('Trustpilot Rating') }}</span>
                @if($showReviews && $reviews > 0)
                    <span class="rj-tp-reviews">({{ number_format($reviews) }} {{ __('reviews') }})</span>
                @endif
            </div>
        </div>
    </div>

    <style>
        #{{ $uid }}.rj-tp-widget {
            display: inline-block;
            padding: 16px 24px;
            background: var(--rj-surface);
            border: 1px solid var(--rj-border);
            border-radius: var(--rj-radius-lg);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        #{{ $uid }} .rj-tp-inner {
            display: flex;
            flex-direction: column;
            align-items: {{ $align === 'left' ? 'flex-start' : ($align === 'right' ? 'flex-end' : 'center') }};
            gap: 8px;
        }
        #{{ $uid }} .rj-tp-stars {
            display: flex;
            gap: 4px;
        }
        #{{ $uid }} .rj-tp-star {
            width: 24px;
            height: 24px;
        }
        #{{ $uid }} .rj-tp-star svg {
            width: 100%;
            height: 100%;
        }
        #{{ $uid }} .rj-tp-star.is-filled {
<<<<<<< HEAD
            color: #00b67a;
        }
        #{{ $uid }} .rj-tp-star.is-empty {
            color: #dcdce6;
=======
            color: #00b67a; /* Trustpilot Yaşıl Rəngi */
        }
        #{{ $uid }} .rj-tp-star.is-empty {
            color: #dcdce6; /* Boş ulduz rəngi */
>>>>>>> 88a78bbec7968caaa32e93f7ae4c4baa0f863c9d
        }
        #{{ $uid }} .rj-tp-text {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            font-size: 14px;
            color: var(--rj-text);
        }
        #{{ $uid }} .rj-tp-score {
            font-weight: 700;
            font-size: 16px;
        }
        #{{ $uid }} .rj-tp-label {
            color: var(--rj-muted);
        }
        #{{ $uid }} .rj-tp-reviews {
            color: var(--rj-muted);
            font-size: 13px;
        }
    </style>
@else
    @if(auth()->check() && auth()->user()->isAdmin())
        <div style="padding: 20px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 12px; color: #fca5a5; font-size: 14px; text-align: center;">
            <strong>Trustpilot Error:</strong> {{ __('Missing API Key, Business Unit ID, or API request failed.') }}
        </div>
    @endif
@endif
