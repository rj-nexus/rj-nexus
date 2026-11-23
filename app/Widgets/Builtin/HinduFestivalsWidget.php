<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use App\Widgets\Support\PanchangCalculator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class HinduFestivalsWidget extends BaseWidget
{
    private const CACHE_HOURS = 6;

    public function id(): string
    {
        return 'hindu-festivals';
    }

    public function name(): string
    {
        return __('Hindu Festivals');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3 4 5 6.500 5 10a5 5 0 01-10 0c0-3.500 2-6 5-10z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Upcoming Hindu festivals (Sanatana Dharma / Vaidika Dharma) with a countdown and an animated temple scene.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Hindu Festivals'), 'tab' => 'content'],
            [
                'name' => 'dharma_name',
                'type' => 'select',
                'label' => __('Tradition Name'),
                'default' => 'sanatana',
                'tab' => 'content',
                'options' => $this->dharmaNames(),
                'help' => __('Both names refer to the same tradition. The chosen name is shown under the title.'),
            ],
            [
                'name' => 'place',
                'type' => 'select',
                'label' => __('Calendar Location'),
                'default' => 'new_delhi',
                'tab' => 'content',
                'options' => array_map(fn ($p) => $p['label'], $this->places()),
                'help' => __('Festival days depend on sunrise and sunset at this place. Also sets the time zone.'),
            ],
            [
                'name' => 'count',
                'type' => 'select',
                'label' => __('Number of Festivals'),
                'default' => '5',
                'tab' => 'content',
                'options' => ['3' => '3', '4' => '4', '5' => '5', '6' => '6', '8' => '8', '10' => '10'],
            ],
            ['name' => 'only_major', 'type' => 'toggle', 'label' => __('Major Festivals Only'), 'default' => false, 'tab' => 'content'],
            ['name' => 'show_countdown', 'type' => 'toggle', 'label' => __('Show Countdown'), 'default' => true, 'tab' => 'content'],

            ['name' => 'show_scene', 'type' => 'toggle', 'label' => __('Show Temple Scene'), 'default' => true, 'tab' => 'style'],
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
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#f97316', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $dharma = $this->pick($settings['dharma_name'] ?? 'sanatana', array_keys($this->dharmaNames()), 'sanatana');
        $placeKey = $this->pick($settings['place'] ?? 'new_delhi', array_keys($this->places()), 'new_delhi');
        $place = $this->places()[$placeKey];
        $count = (int) $this->pick($settings['count'] ?? '5', ['3', '4', '5', '6', '8', '10'], '5');
        $onlyMajor = $this->flag($settings['only_major'] ?? null, false);

        $opts = [
            'title' => $this->text($settings['title'] ?? '', 80),
            'dharma_label' => $this->dharmaNames()[$dharma],
            'place_name' => $place['label'],
            'scene' => $this->flag($settings['show_scene'] ?? null, true),
            'side' => $this->pick($settings['scene_side'] ?? 'left', ['left', 'right'], 'left'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark'], 'glass'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#f97316'),
            'countdown' => $this->flag($settings['show_countdown'] ?? null, true),
        ];

        $uid = 'hd_' . substr(md5(uniqid('', true)), 0, 8);
        $tz = $place['tz'];

        try {
            $today = Carbon::now($tz)->startOfDay();
        } catch (\Throwable $e) {
            return $this->errorView($opts, $uid);
        }

        $items = $this->upcoming($place, $placeKey, $today, $onlyMajor);

        if (empty($items)) {
            return $this->errorView($opts, $uid);
        }

        $payload = [
            'tz' => $tz,
            'count' => $count,
            'items' => $items,
            'labels' => [
                'today' => __('Today'),
                'tomorrow' => __('Tomorrow'),
                'in_days' => __('in :n days'),
                'day' => __('day'),
                'days' => __('days'),
                'next' => __('Next: :name'),
                'now' => __('Today: :name'),
            ],
        ];

        return view('rjbuilder.widgets.builtin.hindu-festivals', [
            'o' => $opts,
            'uid' => $uid,
            'payload' => $payload,
            'error' => null,
            'note' => __('Calculated for :place. Local temple calendars may differ by a day.', ['place' => $place['label']]),
        ])->render();
    }

    private function errorView(array $opts, string $uid): string
    {
        return view('rjbuilder.widgets.builtin.hindu-festivals', [
            'o' => $opts,
            'uid' => $uid,
            'payload' => null,
            'error' => __('Festivals are temporarily unavailable.'),
            'note' => '',
        ])->render();
    }

    private function dharmaNames(): array
    {
        return [
            'sanatana' => 'Sanātana Dharma (सनातन धर्म)',
            'vaidika' => 'Vaidika Dharma (वैदिक धर्म)',
            'hindu' => 'Hindu (हिन्दू)',
        ];
    }

    private function places(): array
    {
        return [
            'new_delhi' => ['label' => 'New Delhi, India', 'lat' => 28.6139, 'lng' => 77.2090, 'tz' => 'Asia/Kolkata'],
            'varanasi' => ['label' => 'Varanasi, India', 'lat' => 25.3176, 'lng' => 82.9739, 'tz' => 'Asia/Kolkata'],
            'mumbai' => ['label' => 'Mumbai, India', 'lat' => 19.0760, 'lng' => 72.8777, 'tz' => 'Asia/Kolkata'],
            'kolkata' => ['label' => 'Kolkata, India', 'lat' => 22.5726, 'lng' => 88.3639, 'tz' => 'Asia/Kolkata'],
            'chennai' => ['label' => 'Chennai, India', 'lat' => 13.0827, 'lng' => 80.2707, 'tz' => 'Asia/Kolkata'],
            'baku' => ['label' => 'Baku, Azerbaijan', 'lat' => 40.4093, 'lng' => 49.8671, 'tz' => 'Asia/Baku'],
            'dubai' => ['label' => 'Dubai, UAE', 'lat' => 25.2048, 'lng' => 55.2708, 'tz' => 'Asia/Dubai'],
            'london' => ['label' => 'London, UK', 'lat' => 51.5074, 'lng' => -0.1278, 'tz' => 'Europe/London'],
            'new_york' => ['label' => 'New York, USA', 'lat' => 40.7128, 'lng' => -74.0060, 'tz' => 'America/New_York'],
            'singapore' => ['label' => 'Singapore', 'lat' => 1.3521, 'lng' => 103.8198, 'tz' => 'Asia/Singapore'],
        ];
    }

    /** [açar => [ad, əsas bayramdır?]] */
    private function festivalNames(): array
    {
        return [
            'makar_sankranti' => [__('Makar Sankranti / Pongal'), true],
            'vasant_panchami' => [__('Vasant Panchami'), false],
            'maha_shivaratri' => [__('Maha Shivaratri'), true],
            'holika_dahan' => [__('Holika Dahan'), false],
            'holi' => [__('Holi'), true],
            'ugadi' => [__('Ugadi / Gudi Padwa'), false],
            'ram_navami' => [__('Ram Navami'), true],
            'hanuman_jayanti' => [__('Hanuman Jayanti'), false],
            'akshaya_tritiya' => [__('Akshaya Tritiya'), false],
            'guru_purnima' => [__('Guru Purnima'), false],
            'raksha_bandhan' => [__('Raksha Bandhan'), false],
            'janmashtami' => [__('Krishna Janmashtami'), true],
            'ganesh_chaturthi' => [__('Ganesh Chaturthi'), true],
            'navaratri' => [__('Navaratri begins'), true],
            'dussehra' => [__('Dussehra (Vijayadashami)'), true],
            'diwali' => [__('Diwali'), true],
            'kartika_purnima' => [__('Kartika Purnima'), false],
        ];
    }

    /**
     * Keçən 120 gün və gələn 420 günün bayramları (JS keçmişi halqa hesabı üçün istifadə edir).
     */
    private function upcoming(array $place, string $placeKey, Carbon $today, bool $onlyMajor): array
    {
        $cacheKey = 'rj_hindu:' . md5($placeKey . '|' . $today->format('Y-m-d'));
        $raw = Cache::get($cacheKey);

        if (!is_array($raw)) {
            try {
                $calc = new PanchangCalculator($place['lat'], $place['lng'], $place['tz']);
                $raw = [];

                foreach ([$today->year - 1, $today->year, $today->year + 1] as $year) {
                    foreach ($calc->festivals($year) as $f) {
                        $raw[$f['key'] . '|' . $f['date']] = $f;
                    }
                }

                $raw = array_values($raw);
                Cache::put($cacheKey, $raw, now()->addHours(self::CACHE_HOURS));
            } catch (\Throwable $e) {
                report($e);

                return [];
            }
        }

        $from = $today->copy()->subDays(120)->format('Y-m-d');
        $to = $today->copy()->addDays(420)->format('Y-m-d');
        $names = $this->festivalNames();
        $list = [];

        foreach ($raw as $f) {
            if (!isset($names[$f['key']]) || $f['date'] < $from || $f['date'] > $to) {
                continue;
            }

            [$label, $major] = $names[$f['key']];

            if ($onlyMajor && !$major) {
                continue;
            }

            $list[] = ['key' => $f['key'], 'name' => $label, 'date' => $f['date'], 'major' => $major];
        }

        usort($list, fn ($a, $b) => strcmp($a['date'], $b['date']));

        return $list;
    }

    private function text(mixed $value, int $max): string
    {
        return mb_substr(trim(strip_tags((string) $value)), 0, $max);
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
