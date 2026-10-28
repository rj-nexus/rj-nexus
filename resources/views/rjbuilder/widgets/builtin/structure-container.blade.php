@php
    $dir = $settings['flex_direction'] ?? 'row';
    $jc = $settings['justify_content'] ?? 'space-between';
    $ai = $settings['align_items'] ?? 'center';

    $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '24px', 'lg' => '36px', 'xl' => '48px'];
    $gap = $gapMap[$settings['gap'] ?? 'md'] ?? '24px';

    $bg = $settings['bg_color'] ?? '';
    $width = $settings['width'] ?? 'full';
    $keepTablet = !empty($settings['keep_tablet']);
    $keepMobile = !empty($settings['keep_mobile']);

    $pad = $settings['padding_dim'] ?? [];
    $unit = $pad['unit'] ?? 'px';
    $pt = ($pad['top'] ?? '') !== '' ? $pad['top'] . $unit : '0';
    $pr = ($pad['right'] ?? '') !== '' ? $pad['right'] . $unit : '0';
    $pb = ($pad['bottom'] ?? '') !== '' ? $pad['bottom'] . $unit : '0';
    $pl = ($pad['left'] ?? '') !== '' ? $pad['left'] . $unit : '0';

    $outerStyle = "width:100%;";
    if ($width === 'boxed') {
        $outerStyle .= "max-width:1100px; margin:0 auto;";
    }

    $style = "display:flex; flex-direction:{$dir}; justify-content:{$jc}; align-items:{$ai}; gap:{$gap}; padding:{$pt} {$pr} {$pb} {$pl}; box-sizing:border-box;";

    if ($bg !== '') {
        $style .= " background-color:{$bg};";
    }

    $gridClass = 'rj-cg';
    if ($keepTablet) $gridClass .= ' rj-keep-tablet';
    if ($keepMobile) $gridClass .= ' rj-keep-mobile';

    $widths = [];
    if (!empty($settings['column_widths'])) {
        $parts = array_map('trim', explode(',', $settings['column_widths']));
        foreach ($parts as $p) {
            if (is_numeric($p) && (float)$p > 0) {
                $widths[] = (float)$p;
            }
        }
    }
@endphp

<div style="{!! $outerStyle !!}">
    <div class="{!! $gridClass !!}" style="{!! $style !!}">
        @foreach($children as $index => $child)
            @php
                $flex = '1 1 0';
                if (isset($widths[$index])) {
                    $flex = "{$widths[$index]} 1 0";
                }
            @endphp
            <div class="rj-slot" style="flex: {!! $flex !!}; min-width: 0; position: relative;">
                {!! rj_render_block($child) !!}
            </div>
        @endforeach
    </div>
</div>
