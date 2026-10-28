@php
    $dir = $settings['flex_direction'] ?? 'row';
    $jc = $settings['justify_content'] ?? 'space-between';
    $ai = $settings['align_items'] ?? 'center';

    $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '24px', 'lg' => '36px', 'xl' => '48px'];
    $gap = $gapMap[$settings['gap'] ?? 'md'] ?? '24px';

    $bg = $settings['bg_color'] ?? '';

    $pad = $settings['padding_dim'] ?? [];
    $unit = $pad['unit'] ?? 'px';
    $pt = ($pad['top'] ?? '') !== '' ? $pad['top'] . $unit : '0';
    $pr = ($pad['right'] ?? '') !== '' ? $pad['right'] . $unit : '0';
    $pb = ($pad['bottom'] ?? '') !== '' ? $pad['bottom'] . $unit : '0';
    $pl = ($pad['left'] ?? '') !== '' ? $pad['left'] . $unit : '0';

    $style = "display:flex; flex-direction:{$dir}; justify-content:{$jc}; align-items:{$ai}; gap:{$gap}; padding:{$pt} {$pr} {$pb} {$pl}; width:100%; box-sizing:border-box;";

    if ($bg !== '') {
        $style .= " background-color:{$bg};";
    }
@endphp

<div class="rj-structure-container" style="{!! $style !!}">
    @if(!empty($children))
        {!! rj_render_blocks($children) !!}
    @endif
</div>
