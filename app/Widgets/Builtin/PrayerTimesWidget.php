<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PrayerTimesWidget extends BaseWidget
{
    private const API = 'https://api.aladhan.com/v1/';
    private const CACHE_DAYS = 7;
    private const ORDER = ['fajr', 'sunrise', 'dhuhr', 'asr', 'maghrib', 'isha'];

    public function id(): string
    {
        return 'prayer-times';
    }

    public function name(): string
    {
        return __('Prayer Times');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 21V11a7 7 0 0114 0v10M3 21h18M12 4V2m-3 19v-5a3 3 0 016 0v5"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Prayer times for any city in the world with an animated mosque scene.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Prayer Times'), 'tab' => 'content'],
            ['name' => 'city', 'type' => 'text', 'label' => __('City'), 'default' => 'Baku', 'tab' => 'content', 'placeholder' => 'Baku', 'help' => __('Write in English, e.g. London, Istanbul, Dubai.')],
            ['name' => 'country', 'type' => 'text', 'label' => __('Country'), 'default' => 'Azerbaijan', 'tab' => 'content', 'placeholder' => 'Azerbaijan', 'help' => __('Write in English. Required when no coordinates are set.')],
            ['name' => 'latitude', 'type' => 'text', 'label' => __('Latitude (optional)'), 'default' => '', 'tab' => 'content', 'placeholder' => '40.4093', 'help' => __('If latitude and longitude are both set, they are used instead of the city.')],
            ['name' => 'longitude', 'type' => 'text', 'label' => __('Longitude (optional)'), 'default' => '', 'tab' => 'content', 'placeholder' => '49.8671'],
            [
                'name' => 'method',
                'type' => 'select',
                'label' => __('Calculation Method'),
                'default' => 'auto',
                'tab' => 'content',
                'options' => $this->methods(),
                'help' => __('Compare with your local official timetable and choose the matching method.'),
            ],
            [
                'name' => 'school',
                'type' => 'select',
                'label' => __('Asr Calculation'),
                'default' => '0',
                'tab' => 'content',
                'options' => [
                    '0' => __('Standard (Shafi, Maliki, Hanbali)'),
                    '1' => __('Hanafi'),
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
            ['name' => 'show_sunrise', 'type' => 'toggle', 'label' => __('Show Sunrise'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_hijri', 'type' => 'toggle', 'label' => __('Show Hijri Date'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_countdown', 'type' => 'toggle', 'label' => __('Show Countdown'), 'default' => true, 'tab' => 'content'],

            ['name' => 'show_scene', 'type' => 'toggle', 'label' => __('Show Mosque Scene'), 'default' => true, 'tab' => 'style'],
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
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#10b981', 'tab' => 'style'],
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

        $method = $this->pick($settings['method'] ?? 'auto', array_map('strval', array_keys($this->methods())), 'auto');
        $school = $this->pick($settings['school'] ?? '0', ['0', '1'], '0');

        $query = $useCoords
            ? ['latitude' => $lat, 'longitude' => $lng]
            : ['city' => $city, 'country' => $country];

        if ($method !== 'auto') {
            $query['method'] = (int) $method;
        }
        $query['school'] = (int) $school;

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
            'accent' => $this->hex($settings['accent_color'] ?? null, '#10b981'),
            'countdown' => $this->flag($settings['show_countdown'] ?? null, true),
        ];

        $showSunrise = $this->flag($settings['show_sunrise'] ?? null, true);
        $order = array_values(array_filter(
            self::ORDER,
            fn ($k) => $k !== 'sunrise' || $showSunrise
        ));

        $data = $this->loadDays($query);
        $uid = 'pt_' . substr(md5(uniqid('', true)), 0, 8);

        if ($data === null) {
            return view('rjbuilder.widgets.builtin.prayer-times', [
                'o' => $opts,
                'uid' => $uid,
                'payload' => null,
                'labels' => [],
                'order' => $order,
                'error' => __('Prayer times are temporarily unavailable.'),
            ])->render();
        }

        $labels = [
            'fajr' => __('Fajr'),
            'sunrise' => __('Sunrise'),
            'dhuhr' => __('Dhuhr'),
            'asr' => __('Asr'),
            'maghrib' => __('Maghrib'),
            'isha' => __('Isha'),
            'next' => __('Next: :prayer'),
        ];

        $payload = [
            'tz' => $data['tz'],
            'today' => $data['today'],
            'days' => $data['days'],
            'order' => $order,
            'labels' => $labels,
            'fmt' => $this->pick($settings['time_format'] ?? '24', ['24', '12'], '24'),
            'hijri' => $this->flag($settings['show_hijri'] ?? null, true),
        ];

        return view('rjbuilder.widgets.builtin.prayer-times', [
            'o' => $opts,
            'uid' => $uid,
            'payload' => $payload,
            'labels' => $labels,
            'order' => $order,
            'error' => null,
        ])->render();
    }

    /**
     * Dünən, bu gün və sabahdan sonrakı 2 günün vaxtlarını qaytarır (şəhərin saat qurşağı ilə).
     */
    private function loadDays(array $query): ?array
    {
        $utc = Carbon::now('UTC');
        $first = $this->fetchMonth($query, (int) $utc->year, (int) $utc->month);

        if ($first === null) {
            return null;
        }

        $tz = $first['tz'];
        if (!in_array($tz, timezone_identifiers_list(), true)) {
            $tz = 'UTC';
        }

        try {
            $today = Carbon::now($tz)->startOfDay();
        } catch (\Throwable $e) {
            $tz = 'UTC';
            $today = Carbon::now('UTC')->startOfDay();
        }

        $months = [$utc->format('Y-n') => $first];
        $days = [];

        for ($i = -1; $i <= 2; $i++) {
            $d = $today->copy()->addDays($i);
            $mk = $d->format('Y-n');

            if (!array_key_exists($mk, $months)) {
                $months[$mk] = $this->fetchMonth($query, (int) $d->year, (int) $d->month);
            }

            $key = $d->format('Y-m-d');
            if (isset($months[$mk]['days'][$key])) {
                $days[$key] = $months[$mk]['days'][$key];
            }
        }

        $todayKey = $today->format('Y-m-d');

        if (!isset($days[$todayKey])) {
            return null;
        }

        return ['tz' => $tz, 'today' => $todayKey, 'days' => $days];
    }

    /**
     * Aylıq cədvəli çəkir və 7 gün keşləyir. Uğursuz cavablar keşlənmir.
     */
    private function fetchMonth(array $query, int $year, int $month): ?array
    {
        $cacheKey = 'rj_prayer:' . md5(json_encode([$query, $year, $month]));
        $cached = Cache::get($cacheKey);

        if (is_array($cached)) {
            return $cached;
        }

        try {
            $endpoint = isset($query['latitude']) ? 'calendar' : 'calendarByCity';

            $res = Http::timeout(10)
                ->acceptJson()
                ->get(self::API . $endpoint . '/' . $year . '/' . $month, $query);

            if (!$res->ok()) {
                return null;
            }

            $json = $res->json();

            if (($json['code'] ?? 0) !== 200 || empty($json['data']) || !is_array($json['data'])) {
                return null;
            }

            $days = [];
            $tz = null;

            foreach ($json['data'] as $row) {
                $g = $row['date']['gregorian']['date'] ?? '';

                if (!preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', (string) $g, $m)) {
                    continue;
                }

                $timings = $row['timings'] ?? [];
                $entry = [];

                foreach (['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'] as $name) {
                    if (!isset($timings[$name]) || !preg_match('/(\d{1,2}):(\d{2})/', (string) $timings[$name], $t)) {
                        continue 2;
                    }

                    $entry[strtolower($name)] = sprintf('%02d:%02d', $t[1], $t[2]);
                }

                $h = $row['date']['hijri'] ?? [];
                $entry['hijri'] = trim(($h['day'] ?? '') . ' ' . ($h['month']['en'] ?? '') . ' ' . ($h['year'] ?? ''));

                $days["{$m[3]}-{$m[2]}-{$m[1]}"] = $entry;
                $tz = $tz ?? ($row['meta']['timezone'] ?? null);
            }

            if (empty($days) || !$tz) {
                return null;
            }

            $result = ['tz' => (string) $tz, 'days' => $days];
            Cache::put($cacheKey, $result, now()->addDays(self::CACHE_DAYS));

            return $result;
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    private function methods(): array
    {
        return [
            'auto' => __('Auto (by location)'),
            '3' => 'Muslim World League',
            '2' => 'ISNA (North America)',
            '5' => 'Egyptian General Authority',
            '4' => 'Umm al-Qura (Makkah)',
            '1' => 'Univ. of Islamic Sciences, Karachi',
            '13' => 'Diyanet (Turkey)',
            '0' => 'Shia Ithna-Ashari (Jafari)',
            '7' => 'Tehran (Geophysics)',
            '8' => 'Gulf Region',
            '9' => 'Kuwait',
            '10' => 'Qatar',
            '16' => 'Dubai',
            '11' => 'Singapore',
            '17' => 'Malaysia (JAKIM)',
            '20' => 'Indonesia (Kemenag)',
            '12' => 'France (UOIF)',
            '14' => 'Russia (Spiritual Administration)',
            '15' => 'Moonsighting Committee',
            '18' => 'Tunisia',
            '19' => 'Algeria',
            '21' => 'Morocco',
            '22' => 'Portugal',
            '23' => 'Jordan',
        ];
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