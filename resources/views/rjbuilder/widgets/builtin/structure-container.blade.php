@php
    $dirRaw = $settings['flex_direction'] ?? 'row';
    $dir = in_array($dirRaw, ['row', 'column', 'row-reverse', 'column-reverse'], true) ? $dirRaw : 'row';

    $jcRaw = $settings['justify_content'] ?? 'space-between';
    $jc = in_array($jcRaw, ['flex-start', 'center', 'flex-end', 'space-between', 'space-around'], true) ? $jcRaw : 'space-between';

    $aiRaw = $settings['align_items'] ?? 'center';
    $ai = in_array($aiRaw, ['flex-start', 'center', 'flex-end', 'stretch'], true) ? $aiRaw : 'center';

    $mid = (($settings['middle_position'] ?? 'center') === 'right') ? 'right' : 'center';

    $cols = max(2, min(5, (int) ($settings['columns'] ?? 3)));

    $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '24px', 'lg' => '36px', 'xl' => '48px'];
    $gap = $gapMap[$settings['gap'] ?? 'md'] ?? '24px';

    $bg = preg_replace('/[^#\w(),.%\s-]/', '', (string) ($settings['bg_color'] ?? ''));

    $pad = is_array($settings['padding_dim'] ?? null) ? $settings['padding_dim'] : [];
    $unitRaw = $pad['unit'] ?? 'px';
    $unit = in_array($unitRaw, ['px', '%', 'em', 'rem', 'vh', 'vw'], true) ? $unitRaw : 'px';
    $side = function ($k) use ($pad, $unit) {
        return (isset($pad[$k]) && $pad[$k] !== '' && is_numeric($pad[$k])) ? ($pad[$k] + 0) . $unit : '';
    };
    $pt = $side('top');
    $pr = $side('right');
    $pb = $side('bottom');
    $pl = $side('left');
    $hasPad = $pt !== '' || $pr !== '' || $pb !== '' || $pl !== '';

    $bp = function_exists('rj_breakpoints') ? (array) rj_breakpoints() : [];
    $bpTablet = (int) ($bp['tablet']['max'] ?? 860);

    $widths = null;
    $rawW = trim((string) ($settings['column_widths'] ?? ''));
    if ($rawW !== '') {
        $nums = [];
        foreach (explode(',', $rawW) as $part) {
            $n = (float) trim($part);
            if ($n > 0) {
                $nums[] = $n;
            }
        }
        if (count($nums) > 0) {
            if (count($nums) < $cols) {
                $used = array_sum($nums);
                $missing = $cols - count($nums);
                $rest = max(100 - $used, 1) / $missing;
                for ($k = 0; $k < $missing; $k++) {
                    $nums[] = $rest;
                }
            }
            $widths = $nums;
        }
    }

    $pushes = ($dir === 'row') && $widths === null;

    $num = function ($v) {
        return ($v === null || $v === '' || !is_numeric($v)) ? null : (int) $v;
    };

    $rank = function (array $items, string $key, bool $skipHidden) {
        $list = [];
        foreach ($items as $i => $it) {
            if ($skipHidden && $it['hideM']) {
                continue;
            }
            $list[] = [$i, $it[$key]];
        }
        usort($list, function ($a, $b) {
            return ($a[1] <=> $b[1]) ?: ($a[0] <=> $b[0]);
        });
        $ranks = [];
        foreach ($list as $pos => $row) {
            $ranks[$row[0]] = $pos;
        }
        return $ranks;
    };

    $margins = function (int $r, int $m, bool $small) use ($mid, $pushes) {
        $ml = '0';
        $mr = '0';
        if ($pushes && $m >= 2 && $r === 1) {
            $ml = 'auto';
            if (!$small && $m >= 3 && $mid === 'center') {
                $mr = 'auto';
            }
        }
        return [$ml, $mr];
    };

    $items = [];
    for ($i = 0; $i < $cols; $i++) {
        $child = $children[$i] ?? null;
        if (!$child) {
            continue;
        }
        $cs = (is_array($child) && is_array($child['settings'] ?? null)) ? $child['settings'] : [];

        $oD = $num($cs['_order_desktop'] ?? null) ?? $num($cs['order'] ?? null) ?? 0;
        $oT = $num($cs['_order_tablet'] ?? null) ?? $oD;
        $oMraw = $num($cs['_order_mobile'] ?? null);

        $items[$i] = [
            'child' => $child,
            'oD' => $oD,
            'oM' => $oMraw ?? $oT,
            'hideM' => ($cols === 5 && $oMraw === null),
        ];
    }

    $rD = $rank($items, 'oD', false);
    $rM = $rank($items, 'oM', true);

    $countD = count($items);
    $countM = count($rM);

    $style = "display:flex; flex-wrap:nowrap; flex-direction:{$dir}; justify-content:{$jc}; align-items:{$ai}; gap:{$gap}; box-sizing:border-box; width:100%;";
    if (!$hasPad) {
        $style .= ' padding:16px 24px;';
    }
    if ($pt !== '') $style .= " padding-top:{$pt};";
    if ($pr !== '') $style .= " padding-right:{$pr};";
    if ($pb !== '') $style .= " padding-bottom:{$pb};";
    if ($pl !== '') $style .= " padding-left:{$pl};";
    if ($bg !== '') $style .= " background-color:{$bg};";

    $cls = 'rjsc-' . bin2hex(random_bytes(4));
    $sel = '.' . $cls . '>.rj-slot';
    $css = $sel . '{order:var(--ord-d);margin-left:var(--ml-d);margin-right:var(--mr-d)}'
        . '@container rj (max-width:' . $bpTablet . 'px){'
        . $sel . '{order:var(--ord-m);margin-left:var(--ml-m);margin-right:var(--mr-m);display:var(--dsp-m,block)}}';
@endphp

<style>{!! $css !!}</style>
<div class="rj-structure-container {{ $cls }}" style="{!! $style !!}">
    @foreach($items as $i => $it)
        @php
            [$mlD, $mrD] = $margins($rD[$i], $countD, false);

            if ($it['hideM']) {
                $ordM = $countD;
                $mlM = '0';
                $mrM = '0';
                $dspM = 'none';
            } else {
                $ordM = $rM[$i];
                [$mlM, $mrM] = $margins($rM[$i], $countM, true);
                $dspM = 'block';
            }

            $flex = ($widths !== null && isset($widths[$i])) ? 'flex:' . $widths[$i] . ' 1 0;' : 'flex:0 1 auto;';

            $vars = '--ord-d:' . $rD[$i] . ';--ord-m:' . $ordM . ';'
                . '--ml-d:' . $mlD . ';--mr-d:' . $mrD . ';'
                . '--ml-m:' . $mlM . ';--mr-m:' . $mrM . ';'
                . '--dsp-m:' . $dspM . ';';
        @endphp
        <div class="rj-slot rj-slot-i-{{ $i }}" style="{!! $flex !!} min-width:0; {!! $vars !!}">
            {!! rj_render_block($it['child']) !!}
        </div>
    @endforeach
</div>
