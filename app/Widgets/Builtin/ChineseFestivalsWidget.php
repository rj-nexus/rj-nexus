<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;
use com\nlp\lunar\Lunar;
use com\nlp\lunar\Solar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * 中国节日 — Çin bayramları, Ay təqvimi, Yi/Ji və 12 Shi Chen.
 * Xarici API yoxdur. Tələb: composer require 6tail/lunar-php
 */
class ChineseFestivalsWidget extends BaseWidget
{
    private const CACHE_HOURS = 6;

    /** [lunar ay, lunar gün, açar, çincə, pinyin] */
    private const LUNAR_FESTIVALS = [
        [1, 1, 'spring', '春节', 'Chūnjié'],
        [1, 15, 'lantern', '元宵节', 'Yuánxiāojié'],
        [2, 2, 'longtaitou', '龙抬头', 'Lóngtáitóu'],
        [5, 5, 'dragon', '端午节', 'Duānwǔjié'],
        [7, 7, 'qixi', '七夕', 'Qīxī'],
        [7, 15, 'ghost', '中元节', 'Zhōngyuánjié'],
        [8, 15, 'midautumn', '中秋节', 'Zhōngqiūjié'],
        [9, 9, 'chongyang', '重阳节', 'Chóngyángjié'],
        [12, 8, 'laba', '腊八节', 'Làbājié'],
        [12, 23, 'xiaonian', '小年', 'Xiǎonián'],
    ];

    public function id(): string
    {
        return 'chinese-festivals';
    }

    public function name(): string
    {
        return '中国节日';
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v3M8 5h8a4 4 0 014 4v4a4 4 0 01-4 4H8a4 4 0 01-4-4V9a4 4 0 014-4zM12 17v3M10 22h4"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Upcoming Chinese festivals with countdown, today\'s lunar date, auspicious activities (Yi/Ji) and the 12 Shi Chen hours. Calculated offline, no API.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => '中国节日', 'tab' => 'content'],
            ['name' => 'timezone', 'type' => 'text', 'label' => __('Timezone'), 'default' => 'Asia/Baku', 'tab' => 'content', 'placeholder' => 'Asia/Baku', 'help' => __('IANA timezone, e.g. Asia/Baku, Asia/Shanghai, Europe/London.')],
            [
                'name' => 'count',
                'type' => 'select',
                'label' => __('Number of Festivals'),
                'default' => '5',
                'tab' => 'content',
                'options' => ['3' => '3', '4' => '4', '5' => '5', '6' => '6', '8' => '8', '10' => '10'],
            ],
            [
                'name' => 'time_format',
                'type' => 'select',
                'label' => __('Time Format'),
                'default' => '24',
                'tab' => 'content',
                'options' => ['24' => __('24-hour'), '12' => __('12-hour (AM/PM)')],
            ],
            ['name' => 'show_countdown', 'type' => 'toggle', 'label' => __('Show Countdown'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_today', 'type' => 'toggle', 'label' => __('Show Today\'s Lunar Date'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_yiji', 'type' => 'toggle', 'label' => __('Show Yi / Ji (Auspicious / Avoid)'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_shichen', 'type' => 'toggle', 'label' => __('Show Shi Chen Hour'), 'default' => true, 'tab' => 'content'],
            ['name' => 'show_pinyin', 'type' => 'toggle', 'label' => __('Show Pinyin'), 'default' => true, 'tab' => 'content'],

            ['name' => 'animate', 'type' => 'toggle', 'label' => __('Animations'), 'default' => true, 'tab' => 'style'],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'red',
                'tab' => 'style',
                'options' => ['red' => __('Red & Gold'), 'dark' => __('Dark')],
            ],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#facc15', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        if (!class_exists(Lunar::class)) {
            return view('rjbuilder.widgets.builtin.chinese-festivals', [
                'o' => ['style' => 'red', 'accent' => '#facc15', 'animate' => false, 'title' => '', 'countdown' => false],
                'uid' => 'cf_' . substr(md5(uniqid('', true)), 0, 8),
                'payload' => null,
                'error' => __('Calendar library is not installed.'),
            ])->render();
        }

        $tz = trim((string) ($settings['timezone'] ?? 'Asia/Baku'));
        if (!in_array($tz, timezone_identifiers_list(), true)) {
            $tz = 'Asia/Baku';
        }

        $count = (int) $this->pick($settings['count'] ?? '5', ['3', '4', '5', '6', '8', '10'], '5');

        $opts = [
            'title' => $this->text($settings['title'] ?? '', 80),
            'style' => $this->pick($settings['style'] ?? 'red', ['red', 'dark'], 'red'),
            'accent' => $this->hex($settings['accent_color'] ?? null, '#facc15'),
            'animate' => $this->flag($settings['animate'] ?? null, true),
            'countdown' => $this->flag($settings['show_countdown'] ?? null, true),
        ];

        $uid = 'cf_' . substr(md5(uniqid('', true)), 0, 8);

        $now = Carbon::now($tz);
        $cacheKey = 'rj_cnfest:' . md5(json_encode([$tz, $now->format('Y-m-d'), $count]));

        $data = Cache::remember($cacheKey, now()->addHours(self::CACHE_HOURS), function () use ($now, $tz, $count) {
            try {
                return $this->compute($now, $tz, $count);
            } catch (\Throwable $e) {
                report($e);

                return null;
            }
        });

        if (!is_array($data)) {
            return view('rjbuilder.widgets.builtin.chinese-festivals', [
                'o' => $opts,
                'uid' => $uid,
                'payload' => null,
                'error' => __('Calendar data is temporarily unavailable.'),
            ])->render();
        }

        $payload = $data + [
            'tz' => $tz,
            'count' => $count,
            'fmt' => $this->pick($settings['time_format'] ?? '24', ['24', '12'], '24'),
            'today' => $this->flag($settings['show_today'] ?? null, true),
            'yiji' => $this->flag($settings['show_yiji'] ?? null, true),
            'shichen' => $this->flag($settings['show_shichen'] ?? null, true),
            'pinyin' => $this->flag($settings['show_pinyin'] ?? null, true),
            'labels' => [
                'today' => __('Today'),
                'days' => __('days'),
                'until' => __('Until'),
                'yi' => __('Auspicious'),
                'ji' => __('Avoid'),
                'term' => __('Next solar term'),
                'hour' => __('Current hour'),
                'now' => __('Today!'),
            ],
        ];

        return view('rjbuilder.widgets.builtin.chinese-festivals', [
            'o' => $opts,
            'uid' => $uid,
            'payload' => $payload,
            'error' => null,
        ])->render();
    }

    private function compute(Carbon $now, string $tz, int $count): array
    {
        $today = $now->copy()->startOfDay();
        $lunarNow = Lunar::fromDate(new \DateTime($now->format('Y-m-d H:i:s')));

        // Bu və növbəti lunar il (+ əvvəlki, il dəyişən aylar üçün)
        $baseYear = $lunarNow->getYear();
        $found = [];

        foreach ([$baseYear - 1, $baseYear, $baseYear + 1, $baseYear + 2] as $ly) {
            foreach (self::LUNAR_FESTIVALS as [$m, $d, $key, $zh, $py]) {
                $this->push($found, $key, $zh, $py, Lunar::fromYmd($ly, $m, $d)->getSolar());
            }

            // Çuxi (lunar ilin son günü) = növbəti Yeni ilin 1-dən 1 gün əvvəl
            $ny = Lunar::fromYmd($ly + 1, 1, 1)->getSolar();
            $eve = Solar::fromJulianDay($ny->getJulianDay() - 1);
            $this->push($found, 'eve', '除夕', 'Chúxī', $eve);

            // Qingming və Dongzhi — günəş terminləri
            $table = Lunar::fromYmd($ly, 6, 1)->getJieQiTable();
            foreach ([['清明', 'qingming', '清明节', 'Qīngmíngjié'], ['冬至', 'dongzhi', '冬至', 'Dōngzhì']] as [$jq, $key, $zh, $py]) {
                if (isset($table[$jq])) {
                    $this->push($found, $key, $zh, $py, $table[$jq]);
                }
            }
        }

        $todayKey = $today->format('Y-m-d');
        $found = array_values(array_filter($found, fn ($f) => $f['date'] >= $todayKey));
        usort($found, fn ($a, $b) => strcmp($a['date'], $b['date']));

        $seen = [];
        $items = [];
        foreach ($found as $f) {
            $uniq = $f['key'] . $f['date'];
            if (isset($seen[$uniq])) {
                continue;
            }
            $seen[$uniq] = true;
            $f['ts'] = Carbon::createFromFormat('Y-m-d', $f['date'], $tz)->startOfDay()->getTimestamp() * 1000;
            $f['name'] = $this->enName($f['key']);
            $items[] = $f;
            if (count($items) >= $count) {
                break;
            }
        }

        $next = $lunarNow->getNextJieQi();
        $term = $next ? [
            'zh' => $next->getName(),
            'date' => $next->getSolar()->toYmd(),
        ] : null;

        $yi = array_slice($lunarNow->getDayYi(), 0, 8);
        $ji = array_slice($lunarNow->getDayJi(), 0, 8);

        return [
            'items' => $items,
            'today_info' => [
                'key' => $todayKey,
                'lunar' => $lunarNow->getMonthInChinese() . '月' . $lunarNow->getDayInChinese(),
                'ganzhi' => $lunarNow->getYearInGanZhi() . '年',
                'zodiac' => $lunarNow->getYearShengXiao(),
                'yi' => $yi,
                'ji' => $ji,
                'term' => $term,
            ],
        ];
    }

    private function push(array &$list, string $key, string $zh, string $py, Solar $s): void
    {
        $list[] = ['key' => $key, 'zh' => $zh, 'py' => $py, 'date' => $s->toYmd()];
    }

    private function enName(string $key): string
    {
        return match ($key) {
            'spring' => __('Spring Festival'),
            'lantern' => __('Lantern Festival'),
            'longtaitou' => __('Dragon Head Raising'),
            'qingming' => __('Qingming (Tomb-Sweeping)'),
            'dragon' => __('Dragon Boat Festival'),
            'qixi' => __('Qixi Festival'),
            'ghost' => __('Hungry Ghost Festival'),
            'midautumn' => __('Mid-Autumn Festival'),
            'chongyang' => __('Double Ninth Festival'),
            'dongzhi' => __('Winter Solstice'),
            'laba' => __('Laba Festival'),
            'xiaonian' => __('Little New Year'),
            'eve' => __('Chinese New Year\'s Eve'),
            default => $key,
        };
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
