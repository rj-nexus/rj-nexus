<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use Illuminate\Support\Carbon;

class ChristianHolidaysWidget extends BaseWidget
{
    /** 1900–2099 arasında Julian və Qriqorian təqvimləri arasındakı fərq */
    private const JULIAN_SHIFT = 13;

    public function id(): string
    {
        return 'christian-holidays';
    }

    public function name(): string
    {
        return __('Christian Holidays');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M7 8h10M5 21h14"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Upcoming Christian holidays (Western or Orthodox calendar) with a countdown and an animated church scene.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Christian Holidays'), 'tab' => 'content'],
            [
                'name' => 'tradition',
                'type' => 'select',
                'label' => __('Calendar'),
                'default' => 'western',
                'tab' => 'content',
                'options' => $this->traditions(),
                'help' => __('Orthodox Easter differs from Western Easter. Julian means Christmas on 7 January.'),
            ],
            ['name' => 'timezone', 'type' => 'text', 'label' => __('Time Zone'), 'default' => 'Asia/Baku', 'tab' => 'content', 'placeholder' => 'Asia/Baku', 'help' => __('IANA name, e.g. Europe/London, Asia/Baku. Invalid values fall back to UTC.')],
            [
                'name' => 'count',
                'type' => 'select',
                'label' => __('Number of Holidays'),
                'default' => '5',
                'tab' => 'content',
                'options' => ['3' => '3', '4' => '4', '5' => '5', '6' => '6', '8' => '8', '10' => '10'],
            ],
            ['name' => 'only_major', 'type' => 'toggle', 'label' => __('Major Feasts Only'), 'default' => false, 'tab' => 'content'],
            ['name' => 'show_countdown', 'type' => 'toggle', 'label' => __('Show Countdown'), 'default' => true, 'tab' => 'content'],

            ['name' => 'show_scene', 'type' => 'toggle', 'label' => __('Show Church Scene'), 'default' => true, 'tab' => 'style'],
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
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#8b5cf6', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $tradition = $this->pick($settings['tradition'] ?? 'western', array_keys($this->traditions()), 'western');
        $count = (int) $this->pick($settings['count'] ?? '5', ['3', '4', '5', '6', '8', '10'], '5');
        $onlyMajor = $this->flag($settings['only_major'] ?? null, false);

        $tz = $this->text($settings['timezone'] ?? '', 60);
        if ($tz === '' || !in_array($tz, timezone_identifiers_list(), true)) {
            $tz = in_array('Asia/Baku', timezone_identifiers_list(), true) ? 'Asia/Baku' : 'UTC';
        }

        $opts = [
            'title' => $this->text($settings['title'] ?? '', 80),
            'tradition_label' => $this->traditions()[$tradition],
            'orthodox' => $tradition !== 'western',
            'scene' => $this->flag($settings['show_scene'] ?? null, true),
            'side' => $this->pick($settings['scene_side'] ?? 'left', ['left', 'right'], 'left'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'style' => $this->pick($settings['style'] ?? 'glass', ['glass', 'glass-dark'], 'glass'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#8b5cf6'),
            'countdown' => $this->flag($settings['show_countdown'] ?? null, true),
        ];

        $uid = 'cx_' . substr(md5(uniqid('', true)), 0, 8);

        try {
            $today = Carbon::now($tz)->startOfDay();
        } catch (\Throwable $e) {
            $tz = 'UTC';
            $today = Carbon::now('UTC')->startOfDay();
        }

        $items = $this->upcoming($tradition, $today, $onlyMajor);

        if (empty($items)) {
            return view('rjbuilder.widgets.builtin.christian-holidays', [
                'o' => $opts,
                'uid' => $uid,
                'payload' => null,
                'error' => __('Holidays are temporarily unavailable.'),
            ])->render();
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

        return view('rjbuilder.widgets.builtin.christian-holidays', [
            'o' => $opts,
            'uid' => $uid,
            'payload' => $payload,
            'error' => null,
        ])->render();
    }

    private function traditions(): array
    {
        return [
            'western' => __('Western (Catholic & Protestant)'),
            'orthodox_revised' => __('Orthodox (Revised Julian)'),
            'orthodox_julian' => __('Orthodox (Julian)'),
        ];
    }

    /**
     * Keçən 120 gün və gələn 420 günün bayramlarını qaytarır (JS keçmişi həlqə hesabı üçün istifadə edir).
     */
    private function upcoming(string $tradition, Carbon $today, bool $onlyMajor): array
    {
        $from = $today->copy()->subDays(120);
        $to = $today->copy()->addDays(420);
        $list = [];

        foreach ([$today->year - 1, $today->year, $today->year + 1] as $year) {
            foreach ($this->feasts($tradition, $year) as [$key, $name, $date, $major]) {
                $day = $date->format('Y-m-d');

                if ($day < $from->format('Y-m-d') || $day > $to->format('Y-m-d')) {
                    continue;
                }

                if ($onlyMajor && !$major) {
                    continue;
                }

                $list[] = ['key' => $key, 'name' => $name, 'date' => $day, 'major' => $major];
            }
        }

        usort($list, fn ($a, $b) => strcmp($a['date'], $b['date']));

        return $list;
    }

    /**
     * Bir il üçün bayramlar: [açar, ad, tarix, əsas bayramdır?]
     */
    private function feasts(string $tradition, int $y): array
    {
        $orthodox = $tradition !== 'western';
        $shift = $tradition === 'orthodox_julian' ? self::JULIAN_SHIFT : 0;

        // Sabit tarixli bayramlar (Qriqorian), Julian üçün +13 gün
        $fix = fn (int $m, int $d) => Carbon::create($y, $m, $d, 0, 0, 0, 'UTC')->addDays($shift);

        if (!$orthodox) {
            $e = $this->westernEaster($y);
            $adventSunday = Carbon::create($y, 12, 25, 0, 0, 0, 'UTC')->previous(Carbon::SUNDAY)->subDays(21);

            return [
                ['epiphany', __('Epiphany'), $fix(1, 6), true],
                ['ash_wednesday', __('Ash Wednesday'), $e->copy()->subDays(46), false],
                ['annunciation', __('Annunciation'), $fix(3, 25), false],
                ['palm_sunday', __('Palm Sunday'), $e->copy()->subDays(7), false],
                ['maundy_thursday', __('Maundy Thursday'), $e->copy()->subDays(3), false],
                ['good_friday', __('Good Friday'), $e->copy()->subDays(2), true],
                ['easter', __('Easter'), $e->copy(), true],
                ['ascension', __('Ascension'), $e->copy()->addDays(39), true],
                ['pentecost', __('Pentecost'), $e->copy()->addDays(49), true],
                ['assumption', __('Assumption of Mary'), $fix(8, 15), false],
                ['all_saints', __('All Saints\' Day'), $fix(11, 1), false],
                ['advent', __('First Sunday of Advent'), $adventSunday, false],
                ['christmas_eve', __('Christmas Eve'), $fix(12, 24), false],
                ['christmas', __('Christmas'), $fix(12, 25), true],
            ];
        }

        $p = $this->orthodoxEaster($y);

        return [
            ['christmas', __('Nativity of Christ (Christmas)'), $fix(12, 25), true],
            ['theophany', __('Theophany (Epiphany)'), $fix(1, 6), true],
            ['meeting', __('Meeting of the Lord'), $fix(2, 2), false],
            ['clean_monday', __('Clean Monday (Great Lent begins)'), $p->copy()->subDays(48), false],
            ['annunciation', __('Annunciation'), $fix(3, 25), false],
            ['palm_sunday', __('Palm Sunday'), $p->copy()->subDays(7), false],
            ['good_friday', __('Good Friday'), $p->copy()->subDays(2), true],
            ['pascha', __('Easter (Pascha)'), $p->copy(), true],
            ['ascension', __('Ascension'), $p->copy()->addDays(39), true],
            ['pentecost', __('Pentecost'), $p->copy()->addDays(49), true],
            ['transfiguration', __('Transfiguration'), $fix(8, 6), false],
            ['dormition', __('Dormition of the Theotokos'), $fix(8, 15), false],
            ['nativity_theotokos', __('Nativity of the Theotokos'), $fix(9, 8), false],
            ['holy_cross', __('Exaltation of the Cross'), $fix(9, 14), false],
        ];
    }

    /** Qərb Pasxası (Anonim Qriqorian alqoritmi) */
    private function westernEaster(int $y): Carbon
    {
        $a = $y % 19;
        $b = intdiv($y, 100);
        $c = $y % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($y, $month, $day, 0, 0, 0, 'UTC');
    }

    /** Pravoslav Pasxası (Julian alqoritmi, +13 gün ilə Qriqorian təqvimə çevrilir) */
    private function orthodoxEaster(int $y): Carbon
    {
        $a = $y % 4;
        $b = $y % 7;
        $c = $y % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = intdiv($d + $e + 114, 31);
        $day = (($d + $e + 114) % 31) + 1;

        return Carbon::create($y, $month, $day, 0, 0, 0, 'UTC')->addDays(self::JULIAN_SHIFT);
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
