@php
    $dir = $settings['flex_direction'] ?? 'row';
    $jc = $settings['justify_content'] ?? 'space-between';
    $ai = $settings['align_items'] ?? 'center';
    $wrap = $settings['flex_wrap'] ?? 'nowrap';
    $cols = max(2, min(5, (int)($settings['columns'] ?? 3)));

    $gapMap = ['none' => '0', 'sm' => '12px', 'md' => '24px', 'lg' => '36px', 'xl' => '48px'];
    $gap = $gapMap[$settings['gap'] ?? 'md'] ?? '24px';

    $bg = $settings['bg_color'] ?? '';

    $pad = $settings['padding_dim'] ?? [];
    $unit = $pad['unit'] ?? 'px';
    $pt = ($pad['top'] ?? '') !== '' ? $pad['top'] . $unit : '';
    $pr = ($pad['right'] ?? '') !== '' ? $pad['right'] . $unit : '';
    $pb = ($pad['bottom'] ?? '') !== '' ? $pad['bottom'] . $unit : '';
    $pl = ($pad['left'] ?? '') !== '' ? $pad['left'] . $unit : '';

    $hasPad = $pt !== '' || $pr !== '' || $pb !== '' || $pl !== '';
    $autoPad = !$hasPad ? 'padding-left:16px; padding-right:16px;' : '';

    $dirStyle = $dir !== 'row' ? "flex-direction:{$dir};" : '';

    $style = "display:flex; flex-wrap:{$wrap}; {$dirStyle} justify-content:{$jc}; align-items:{$ai}; gap:{$gap}; box-sizing:border-box; width:100%; {$autoPad}";

    if ($pt !== '') $style .= " padding-top:{$pt};";
    if ($pr !== '') $style .= " padding-right:{$pr};";
    if ($pb !== '') $style .= " padding-bottom:{$pb};";
    if ($pl !== '') $style .= " padding-left:{$pl};";

    if ($bg !== '') {
        $style .= " background-color:{$bg};";
    }
@endphp

<div class="rj-structure-container" style="{!! $style !!}">
    @for($i = 0; $i < $cols; $i++)
        @php
            $child = $children[$i] ?? null;
            $orderStyle = '';
            if ($child && isset($child['settings'])) {
                $oD = $child['settings']['_order_desktop'] ?? $child['settings']['order'] ?? 0;
                $oT = $child['settings']['_order_tablet'] ?? $oD;
                $oM = $child['settings']['_order_mobile'] ?? $oT;
                $orderStyle = "--ord-d:{$oD}; --ord-t:{$oT}; --ord-m:{$oM};";
            }

            $pushRight = ($jc === 'space-between' && $i === 1) ? 'margin-left: auto;' : '';
        @endphp
        <div class="rj-slot" style="flex: 0 1 auto; min-width: 0; {!! $orderStyle !!} {!! $pushRight !!}">
            @if($child)
                {!! rj_render_block($child) !!}
            @endif
        </div>
    @endfor
</div>
