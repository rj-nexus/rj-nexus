<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ShabbatTimesWidget extends BaseWidget
{
    private const HEBCAL = 'https://www.hebcal.com/hebcal';
    private const ALADHAN = 'https://api.aladhan.com/v1/';
    private const GEO_CACHE_DAYS = 30;
    private const TIMES_CACHE_HOURS = 12;

    public function id(): string
    {
        return 'shabbat-times';
    }

    public function name(): string
    {
        return __('Shabbat Times');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2c1.3 1.7 1.5 3.2 0 4.4C10.5 5.200 10.700 3.700 12 2zM9.500 9h5v10h-5zM7 21h10M12 19v2"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Upcoming Shabbat dates with candle lighting and Havdalah times for any city, with an animated candle scene.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Shabbat Times'), 'tab' => 'content'],
            ['name' => 'city', 'type' => 'text', 'label' => __('City'), 'default' => 'Baku', 'tab' => 'content', 'placeholder' => 'Baku', 'help' => __('Write in English, e.g. London, Istanbul, Dubai.')],
            ['name' => 'country', 'type' => 'text', 'label' => __('Country'), 'default' => 'Azerbaijan', 'tab' => 'content', 'placeholder' => 'Azerbaijan', 'help' => __('Write in English. Required when no coordinates are set.')],
            ['name' => 'latitude', 'type' => 'text', 'label' => __('Latitude (optional)'), 'default' => '', 'tab' => 'content', 'placeholder' => '40.4093', 'help' => __('If latitude and longitude are both set, they are used instead of the city.')],
            ['name' => 'longitude', 'type' => 'text', 'label' => __('Longitude (optional)'), 'default' => '', 'tab' => 'content', 'placeholder' => '49.8671'],
            [
                'name' => 'count',
                'type' => 'select',
                'label' => __('Number of Shabbats'),
                'default' => '4',
                'tab' => 'content',
                'options' => ['2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '8' => '8'],
            ],
            [
                'name' => 'candle',
                'type' => 'select',
                'label' => __('Candle Lighting'),
                'default' => '18',
                'tab' => 'content',
                'options' => [
                    '15' => '15 ' . __('min before sunset'),
                    '18' => '18 ' . __('min before sunset'),
                    '20' => '20 ' . __('min before sunset'),
                    '30' => '30 ' . __('min before sunset'),
                    '40' => '40 ' . __('min before sunset'),
                ],
                'help' => __('Standard is 18 minutes. Jerusalem uses 40.'),
            ],
            [
                'name' => 'havdalah',
                'type' => 'select',
                'label' => __('Havdalah'),
                'default' => '50',
                'tab' => 'content',
                'options' => [
                    '42' => '42 ' . __('min after sunset'),
                    '50' => '50 ' . __('min after sunset'),
                    '60' => '60 ' . __('min after sunset'),
                    '72' => '72 ' . __('min after sunset'),
                ],
            ],
            [
                'name' => 'time_format',
                'type' => 'select',
                'label' => __('Time Format'),
                'default' => '24',
                'tab' => 'content',
                'options' => ['24' => __('24-hour'), '12' => __('12-hour (AM/PM)')],
            ],
            ['name' => 'show_parasha', 'type' => 'toggle', 'label' => __('Show Weekly Torah Portion'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_hebrew', 'type' => 'toggle', 'label' => __('Show Hebrew Date'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_countdown', 'type' => 'toggle', 'label' => __('Show Countdown'), 'default' => true, 'tab' => 'content'],

            ['name' => 'show_scene', 'type' => 'toggle', 'label' => __('Show Candle Scene'), 'default' => true, 'tab' => 'style'],
            [
                'name' => 'scene_side',
                'type' => 'select',
                'label' => __('Scene Position'),
                'default' => 'left',
                'tab' => 'style',
                'options' => ['left' => __('Left'), 'right' => __('Right')],
            ],
            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animations'), 'default' => true, 'tab' => 'style'],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'glass',
                'tab' => 'style',
                'options' => ['glass' => __('Glass'), 'glass-dark' => __('Glass (Dark)')],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#f59e0b', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $city = $this->text($settings['city'] ?? '', 80);
        $country = $this->text($settings['country'] ?? '', 80);
        $lat = $this->coord($settings['latitude'] ?? null, 90);
        $lng = $this->coord($settings['longitude'] ?? null, 180);
        $useCoords = $lat !== null && $lng !== null;

        if (!$useCoords && ($city === '' || $country === '')) {
            return '';
        }

        $count = (int) $this->pick($settings['count'] ?? '4', ['2', '3', '4', '5', '6', '8'], '4');
        $candle = (int) $this->pick($settings['candle'] ?? '18', ['15', '18', '20', '30', '40'], '18');
        $havdalah = (int) $this->pick($settings['havdalah'] ?? '50', ['42', '50', '60', '72'], '50');

        $place = $city !== ''
            ? $city . ($country !== '' ? ', ' . $country : '')
            : round((float) $lat, 2) . ', ' . round((float) $lng, 2);

        $opts = [
            'title' => $this->text($settings['title'] ?? '', 80),
            'place' => $place,
            'scene' => $this->flag($settings['show_scene'] ?? null, true),
            'side' => $this->pick($settings['scene_side'] ?? 'left', ['left', 'right'], 'left'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark'], 'glass'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#f59e0b'),
            'countdown' => $this->flag($settings['show_countdown'] ?? null, true),
        ];

        $uid = 'sb_' . substr(md5(uniqid('', true)), 0, 8);

        $loc = $this->resolveLocation($city, $country, $lat, $lng);
        $data = $loc ? $this->loadShabbats($loc, $count, $candle, $havdalah) : null;

        if ($data === null) {
            return view('rjbuilder.widgets.builtin.shabbat-times', [
                'o' => $opts,
                'uid' => $uid,
                'payload' => null,
                'labels' => [],
                'error' => __('Shabbat times are temporarily unavailable.'),
            ])->render();
        }

        $labels = [
            'candles' => __('Candle lighting'),
            'havdalah' => __('Havdalah'),
            'in_candles' => __('Candle lighting in'),
            'in_end' => __('Shabbat ends in'),
        ];

        $payload = [
            'tz' => $data['tz'],
            'items' => $data['items'],
            'count' => $count,
            'labels' => $labels,
            'fmt' => $this->pick($settings['time_format'] ?? '24', ['24', '12'], '24'),
            'parasha' => $this->flag($settings['show_parasha'] ?? null, true),
            'hebrew' => $this->flag($settings['show_hebrew'] ?? null, true),
        ];

        return view('rjbuilder.widgets.builtin.shabbat-times', [
            'o' => $opts,
            'uid' => $uid,
            'payload' => $payload,
            'labels' => $labels,
            'error' => null,
        ])->render();
    }

    /**
     * Şəhər və ya koordinatdan enlik, uzunluq və saat qurşağını tapır (Aladhan meta), 30 gün keşlənir.
     */
    private function resolveLocation(string $city, string $country, ?float $lat, ?float $lng): ?array
    {
        $cacheKey = 'rj_shabbat_geo:' . md5(json_encode([$city, $country, $lat, $lng]));
        $cached = Cache::get($cacheKey);

        if (is_array($cached)) {
            return $cached;
        }

        try {
            if ($lat !== null && $lng !== null) {
                $res = Http::timeout(10)->acceptJson()->get(
                    self::ALADHAN . 'timings/' . Carbon::now('UTC')->format('d-m-Y'),
                    ['latitude' => $lat, 'longitude' => $lng]
                );
            } else {
                $res = Http::timeout(10)->acceptJson()->get(
                    self::ALADHAN . 'timingsByCity',
                    ['city' => $city, 'country' => $country]
                );
            }

            if (!$res->ok()) {
                return null;
            }

            $meta = $res->json('data.meta');
            $tz = is_array($meta) ? ($meta['timezone'] ?? null) : null;
            $la = $lat ?? ($meta['latitude'] ?? null);
            $ln = $lng ?? ($meta['longitude'] ?? null);

            if (!is_string($tz) || !in_array($tz, timezone_identifiers_list(), true) || !is_numeric($la) || !is_numeric($ln)) {
                return null;
            }

            $out = ['lat' => round((float) $la, 5), 'lng' => round((float) $ln, 5), 'tz' => $tz];
            Cache::put($cacheKey, $out, now()->addDays(self::GEO_CACHE_DAYS));

            return $out;
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    /**
     * Növbəti şənbələr üçün şam yandırma, havdala və parşa məlumatını qaytarır.
     * Vaxtlar UTC millisaniyədir (Hebcal ofsetli vaxt verir, DST problemi olmur).
     */
    private function loadShabbats(array $loc, int $count, int $candle, int $havdalah): ?array
    {
        try {
            $today = Carbon::now($loc['tz'])->startOfDay();
        } catch (\Throwable $e) {
            return null;
        }

        $limit = $count + 1; // bu gün şənbədirsə və havdala keçibsə, JS onu gizlədir

        $params = [
            'v' => 1,
            'cfg' => 'json',
            'maj' => 'off',
            'min' => 'off',
            'mod' => 'off',
            'nx' => 'off',
            'mf' => 'off',
            'ss' => 'off',
            'c' => 'on',
            's' => 'on',
            'M' => 'on',
            'geo' => 'pos',
            'latitude' => $loc['lat'],
            'longitude' => $loc['lng'],
            'tzid' => $loc['tz'],
            'b' => $candle,
            'm' => $havdalah,
            'start' => $today->copy()->subDay()->format('Y-m-d'),
            'end' => $today->copy()->addDays($limit * 7 + 1)->format('Y-m-d'),
        ];

        $cacheKey = 'rj_shabbat:' . md5(json_encode($params));
        $events = Cache::get($cacheKey);

        if (!is_array($events)) {
            try {
                $res = Http::timeout(10)->acceptJson()->get(self::HEBCAL, $params);

                if (!$res->ok()) {
                    return null;
                }

                $items = $res->json('items');

                if (!is_array($items) || empty($items)) {
                    return null;
                }

                $events = ['candles' => [], 'havdalah' => [], 'parasha' => []];

                foreach ($items as $it) {
                    $cat = (string) ($it['category'] ?? '');
                    $date = (string) ($it['date'] ?? '');
                    $day = substr($date, 0, 10);

                    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $day)) {
                        continue;
                    }

                    if (($cat === 'candles' || $cat === 'havdalah') && str_contains($date, 'T')) {
                        $key = $cat === 'candles' ? 'candles' : 'havdalah';
                        $events[$key][$day] = Carbon::parse($date)->getTimestamp() * 1000;
                    } elseif ($cat === 'parashat') {
                        $events['parasha'][$day] = trim((string) preg_replace('/^Parashat\s+/i', '', (string) ($it['title'] ?? '')));
                    }
                }

                if (empty($events['candles']) && empty($events['havdalah'])) {
                    return null;
                }

                Cache::put($cacheKey, $events, now()->addHours(self::TIMES_CACHE_HOURS));
            } catch (\Throwable $e) {
                report($e);

                return null;
            }
        }

        $list = [];

        for ($i = 0; $i <= $limit * 7 + 1 && count($list) < $limit; $i++) {
            $d = $today->copy()->addDays($i);

            if ($d->dayOfWeek !== Carbon::SATURDAY) {
                continue;
            }

            $sat = $d->format('Y-m-d');
            $fri = $d->copy()->subDay()->format('Y-m-d');
            $c = $events['candles'][$fri] ?? null;
            $h = $events['havdalah'][$sat] ?? null;

            if ($c === null && $h === null) {
                continue;
            }

            $list[] = [
                'date' => $sat,
                'candle' => $c,
                'havdalah' => $h,
                'parasha' => $events['parasha'][$sat] ?? '',
            ];
        }

        if (empty($list)) {
            return null;
        }

        return ['tz' => $loc['tz'], 'items' => $list];
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
    }

    private function coord(mixed $value, float $max): ?float
    {
        $v = trim((string) $value);

        if ($v === '' || !is_numeric($v)) {
            return null;
        }

        $f = (float) $v;

        return abs($f) <= $max ? round($f, 5) : null;
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function flag(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}
