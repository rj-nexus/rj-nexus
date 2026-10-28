@php
    $dir = $settings['flex_direction'] ?? 'row';
    $jc = $settings['justify_content'] ?? 'space-between';
    $ai = $settings['align_items'] ?? 'center';
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
    $autoPad = !$hasPad ? 'padding: 16px 24px;' : '';

    $dirStyle = $dir !== 'row' ? "flex-direction:{$dir};" : '';

    // flex-wrap: nowrap məcburi edirik ki, mobildə aşağı düşməsin
    $style = "display:flex; flex-wrap:nowrap; {$dirStyle} align-items:{$ai}; gap:{$gap}; box-sizing:border-box; width:100%; {$autoPad}";

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

            // SƏNİN MƏNTİQİN:
            $pushCss = '';
            if ($jc === 'space-between') {
                if ($i === 0) {
                    // 1-ci element (Loqo) həmişə sola dartır
                    $pushCss = 'margin-right: auto;';
                } elseif ($i === 1) {
                    // 2-ci element (Menyu)
                    if ($cols === 3) {
                        $pushCss = 'margin-left: auto; margin-right: auto;'; // 3 element varsa tam mərkəz
                    } else {
                        $pushCss = 'margin-left: auto;'; // 4 və 5 element varsa sağa sıxışdırır
                    }
                }
            }
        @endphp
        <div class="rj-slot rj-slot-i-{!! $i !!}" style="flex: 1 1 0%; min-width: 0; {!! $orderStyle !!} {!! $pushCss !!}">
            @if($child)
                {!! rj_render_block($child) !!}
            @endif
        </div>
    @endfor
</div>
