<?php

namespace App\Widgets\Support;

use Illuminate\Support\Carbon;

/**
 * Hindu lunisolar festival dates (amanta, Lahiri ayanamsa) hesablayır. API tələb etmir.
 * Tithi gün çıxanda/günorta/gün batanda/gecə yarısı Günəş-Ay bucağından tapılır.
 * Nəticə yerli məbəd təqvimlərindən bəzən ±1 gün fərqlənə bilər.
 */
class PanchangCalculator
{
    private const LUNATION = 29.530588861;

    /** [açar, amanta ay (0=Chaitra ... 11=Phalguna), tithi (1-15 shukla, 16-30 krishna), vaxt, qayda] */
    private const FEASTS = [
        ['vasant_panchami', 10, 5, 'sunrise', ''],
        ['maha_shivaratri', 10, 29, 'midnight', ''],
        ['ugadi', 0, 1, 'sunrise', ''],
        ['ram_navami', 0, 9, 'midday', ''],
        ['hanuman_jayanti', 0, 15, 'sunrise', ''],
        ['akshaya_tritiya', 1, 3, 'midday', ''],
        ['guru_purnima', 3, 15, 'sunrise', ''],
        ['raksha_bandhan', 4, 15, 'sunrise', ''],
        ['janmashtami', 4, 23, 'midnight', 'daymax'],
        ['ganesh_chaturthi', 5, 4, 'midday', ''],
        ['navaratri', 6, 1, 'sunrise', ''],
        ['dussehra', 6, 10, 'afternoon', ''],
        ['diwali', 6, 30, 'sunset', ''],
        ['kartika_purnima', 7, 15, 'sunset', ''],
    ];

    /** @var array<string, array{0: float, 1: float}> */
    private array $sunCache = [];

    public function __construct(
        private float $lat,
        private float $lng,
        private string $tz
    ) {
    }

    /**
     * Verilmiş il üçün bayramlar: [['key' => ..., 'date' => 'Y-m-d'], ...]
     */
    public function festivals(int $year): array
    {
        $res = [];

        foreach ($this->lunations($year) as [$a, $b, $name, $adhika]) {
            if ($adhika) {
                continue; // adhika (əlavə) ayda bayram keçirilmir
            }

            $d0 = $this->addDays($this->localDate($a), -1);
            $days = [];

            for ($i = 0; $i < 33; $i++) {
                $d = $this->addDays($d0, $i);
                [$rise, $set] = $this->sunTimes($d);
                [$riseNext] = $this->sunTimes($this->addDays($d, 1));
                $days[] = [$d, $rise, $set, $riseNext];
            }

            foreach (self::FEASTS as [$key, $month, $t, $time, $flag]) {
                if ($month !== $name) {
                    continue;
                }

                $found = null;
                $prev = null;

                foreach ($days as [$d, $rise, $set, $riseNext]) {
                    $inst = $this->observe($time, $rise, $set, $riseNext);

                    if ($inst < $a) {
                        $prev = [$d, 0];
                        continue;
                    }

                    if ($inst >= $b) {
                        $prev = null;
                        continue;
                    }

                    $tt = $this->tithi($inst);

                    if ($tt === $t) {
                        $found = $d;
                        break;
                    }

                    // Tithi (kshaya) iki gün çıxışı arasında bitibsə, əvvəlki gün götürülür
                    if ($prev !== null && $prev[1] < $t && $tt > $t) {
                        $found = $prev[0];
                        break;
                    }

                    $prev = [$d, $tt];
                }

                if ($flag === 'daymax') {
                    // Tithi gündüz ən çox hansı günə düşürsə, o gün
                    $st = $this->findElong(($t - 1) * 12.0, $a + ($t - 1) * ($b - $a) / 30.0);
                    $en = $this->findElong($t * 12.0, $st + 0.5);
                    $best = -1.0;

                    foreach ($days as [$d, $rise, $set, $riseNext]) {
                        $overlap = max(0.0, min($en, $set) - max($st, $rise));

                        if ($overlap > $best) {
                            $best = $overlap;
                            $found = $d;
                        }
                    }
                }

                if ($found !== null) {
                    $res[] = ['key' => $key, 'date' => $found];
                }
            }

            if ($name === 11) {
                $this->holika($a, $res);
            }
        }

        $res[] = ['key' => 'makar_sankranti', 'date' => $this->makarSankranti($year)];

        $out = [];
        foreach ($res as $r) {
            $out[$r['key'] . '|' . $r['date']] = $r;
        }

        $out = array_values($out);
        usort($out, fn ($x, $y) => strcmp($x['date'], $y['date']));

        return $out;
    }

    /**
     * Holika Dahan: Purnima-nın ilk yarısı (Bhadra/Vishti) gecə yarısından əvvəl bitən axşam.
     * Holi (Rangwali) ertəsi gündür.
     */
    private function holika(float $a, array &$res): void
    {
        $ps = $this->findElong(168.0, $a + 14.5);
        $ve = $this->findElong(174.0, $ps + 0.5);
        $dd = $this->localDate($ps);

        for ($k = 0; $k < 3; $k++) {
            $d = $this->addDays($dd, $k);
            [, $set] = $this->sunTimes($d);
            [$riseNext] = $this->sunTimes($this->addDays($d, 1));
            $mid = $set + ($riseNext - $set) / 2;

            if ($ps < $mid && $ve < $mid) {
                $res[] = ['key' => 'holika_dahan', 'date' => $d];
                $res[] = ['key' => 'holi', 'date' => $this->addDays($d, 1)];

                return;
            }
        }
    }

    /** Günəş sidereal 270° (Makara) keçən gün; gün batandan sonra olarsa, ertəsi gün */
    private function makarSankranti(int $year): string
    {
        $start = Carbon::create($year, 1, 14, 0, 0, 0, $this->tz);
        $j = $this->jdFromUnix((float) $start->getTimestamp());

        for ($i = 0; $i < 12; $i++) {
            $j -= self::wrap($this->sidSun($j) - 270.0);
        }

        $dd = $this->localDate($j);
        [, $set] = $this->sunTimes($dd);

        return $j >= $set ? $this->addDays($dd, 1) : $dd;
    }

    /**
     * Yeni Ay-dan yeni Aya qədər olan ayları qaytarır: [başlanğıc JD, son JD, amanta ay indeksi, adhika?]
     */
    private function lunations(int $year): array
    {
        $ref = Carbon::create($year - 1, 12, 1, 0, 0, 0, 'UTC')->getTimestamp();
        $epoch = Carbon::create(2000, 1, 6, 0, 0, 0, 'UTC')->getTimestamp();
        $days = ($ref - $epoch) / 86400;
        $base = 2451550.09766 + self::LUNATION * round($days / self::LUNATION);

        $moons = [];
        for ($k = 0; $k < 18; $k++) {
            $moons[] = $this->newMoonNear($base + $k * self::LUNATION);
        }

        $out = [];
        for ($i = 0; $i < count($moons) - 1; $i++) {
            $s = (int) floor($this->sidSun($moons[$i]) / 30);
            $e = (int) floor($this->sidSun($moons[$i + 1]) / 30);
            $out[] = [$moons[$i], $moons[$i + 1], ($s + 1) % 12, $s === $e];
        }

        return $out;
    }

    private function observe(string $time, float $rise, float $set, float $riseNext): float
    {
        return match ($time) {
            'sunrise' => $rise,
            'midday' => ($rise + $set) / 2,
            'afternoon' => $rise + ($set - $rise) * 0.7,
            'sunset' => $set,
            default => $set + ($riseNext - $set) / 2, // midnight
        };
    }

    /** Yerli təqvim günü üçün [gün çıxması JD, gün batması JD] */
    private function sunTimes(string $date): array
    {
        if (isset($this->sunCache[$date])) {
            return $this->sunCache[$date];
        }

        $noon = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' 12:00:00', $this->tz);
        $jd = $this->jdFromUnix((float) $noon->getTimestamp());

        $n = round($jd - 2451545.0 - 0.0008 + $this->lng / 360.0);
        $js = $n - $this->lng / 360.0;
        $m = self::norm(357.5291 + 0.98560028 * $js);
        $c = 1.9148 * self::sinD($m) + 0.02 * self::sinD(2 * $m) + 0.0003 * self::sinD(3 * $m);
        $lam = self::norm($m + $c + 180.0 + 102.9372);
        $jt = 2451545.0 + $js + 0.0053 * self::sinD($m) - 0.0069 * self::sinD(2 * $lam);
        $sd = self::sinD($lam) * self::sinD(23.4397);
        $dec = asin($sd);
        $cw = (self::sinD(-0.833) - self::sinD($this->lat) * $sd) / (cos(deg2rad($this->lat)) * cos($dec));
        $cw = max(-1.0, min(1.0, $cw));
        $w = rad2deg(acos($cw));

        return $this->sunCache[$date] = [$jt - $w / 360.0, $jt + $w / 360.0];
    }

    private function sunLong(float $jd): float
    {
        $t = ($jd - 2451545.0) / 36525.0;
        $l0 = 280.46646 + 36000.76983 * $t + 0.0003032 * $t * $t;
        $m = 357.52911 + 35999.05029 * $t - 0.0001537 * $t * $t;
        $c = (1.914602 - 0.004817 * $t - 0.000014 * $t * $t) * self::sinD($m)
            + (0.019993 - 0.000101 * $t) * self::sinD(2 * $m)
            + 0.000289 * self::sinD(3 * $m);
        $om = 125.04 - 1934.136 * $t;

        return self::norm($l0 + $c - 0.00569 - 0.00478 * self::sinD($om));
    }

    private function moonLong(float $jd): float
    {
        $t = ($jd - 2451545.0) / 36525.0;
        $lp = 218.3164477 + 481267.88123421 * $t;
        $d = 297.8501921 + 445267.1114034 * $t;
        $m = 357.5291092 + 35999.0502909 * $t;
        $mp = 134.9633964 + 477198.8675055 * $t;
        $f = 93.2720950 + 483202.0175233 * $t;
        $s = fn (float $x) => self::sinD($x);

        $terms = 6.288774 * $s($mp) + 1.274027 * $s(2 * $d - $mp) + 0.658314 * $s(2 * $d)
            + 0.213618 * $s(2 * $mp) - 0.185116 * $s($m) - 0.114332 * $s(2 * $f)
            + 0.058793 * $s(2 * $d - 2 * $mp) + 0.057066 * $s(2 * $d - $m - $mp)
            + 0.053322 * $s(2 * $d + $mp) + 0.045758 * $s(2 * $d - $m) - 0.040923 * $s($m - $mp)
            - 0.034720 * $s($d) - 0.030383 * $s($m + $mp) + 0.015327 * $s(2 * $d - 2 * $f)
            - 0.012528 * $s($mp + 2 * $f) + 0.010980 * $s($mp - 2 * $f) + 0.010675 * $s(4 * $d - $mp)
            + 0.010034 * $s(3 * $mp) + 0.008548 * $s(4 * $d - 2 * $mp) - 0.007888 * $s(2 * $d + $m - $mp)
            - 0.006766 * $s(2 * $d + $m) - 0.005163 * $s($mp - $d) + 0.004987 * $s($d + $m)
            + 0.004036 * $s(2 * $d - $m + $mp) + 0.003994 * $s(2 * $mp + 2 * $d)
            + 0.003861 * $s(4 * $d) + 0.003665 * $s(2 * $d - 3 * $mp);

        return self::norm($lp + $terms);
    }

    /** Lahiri ayanamsa */
    private function ayanamsa(float $jd): float
    {
        $t = ($jd - 2451545.0) / 36525.0;

        return 23.85306 + 1.396971 * $t + 0.000309 * $t * $t;
    }

    private function sidSun(float $jd): float
    {
        return self::norm($this->sunLong($jd) - $this->ayanamsa($jd));
    }

    private function elong(float $jd): float
    {
        return self::norm($this->moonLong($jd) - $this->sunLong($jd));
    }

    private function tithi(float $jd): int
    {
        return (int) floor($this->elong($jd) / 12) + 1;
    }

    private function newMoonNear(float $jd): float
    {
        for ($i = 0; $i < 8; $i++) {
            $e = $this->elong($jd);
            if ($e > 180) {
                $e -= 360;
            }
            $jd -= $e / 12.19;
        }

        return $jd;
    }

    private function findElong(float $target, float $near): float
    {
        $jd = $near;

        for ($i = 0; $i < 10; $i++) {
            $jd -= self::wrap($this->elong($jd) - $target) / 12.19;
        }

        return $jd;
    }

    private function localDate(float $jd): string
    {
        return Carbon::createFromTimestamp((int) floor($this->unixFromJd($jd)), $this->tz)->format('Y-m-d');
    }

    private function addDays(string $date, int $n): string
    {
        return Carbon::parse($date, 'UTC')->addDays($n)->format('Y-m-d');
    }

    private function jdFromUnix(float $ts): float
    {
        return $ts / 86400.0 + 2440587.5;
    }

    private function unixFromJd(float $jd): float
    {
        return ($jd - 2440587.5) * 86400.0;
    }

    private static function norm(float $x): float
    {
        return $x - 360.0 * floor($x / 360.0);
    }

    /** -180..180 aralığına gətirir */
    private static function wrap(float $x): float
    {
        return self::norm($x + 180.0) - 180.0;
    }

    private static function sinD(float $deg): float
    {
        return sin(deg2rad($deg));
    }
}