@php
    $type = $settings['type'] ?? 'divider';
    $spacerHeight = $settings['spacer_height'] ?? '50px';
    $style = $settings['style'] ?? 'solid';
    $color = $settings['color'] ?? '#e2e8f0';
    $grad1 = $settings['gradient_color_1'] ?? '#8b5cf6';
    $grad2 = $settings['gradient_color_2'] ?? '#ec4899';
    $thickness = (int)($settings['thickness'] ?? 1);
    $width = $settings['width'] ?? '100%';
    $align = $settings['align'] ?? 'center';
    $centerIcon = $settings['center_icon'] ?? '';
    $centerText = $settings['center_text'] ?? '';
    $mt = (int)($settings['margin_top'] ?? 24);
    $mb = (int)($settings['margin_bottom'] ?? 24);

    $alignClass = match($align) {
        'left' => 'justify-start',
        'right' => 'justify-end',
        default => 'justify-center',
    };

    $widthClass = match($width) {
        '75%' => 'w-3/4',
        '50%' => 'w-1/2',
        '25%' => 'w-1/4',
        default => 'w-full',
    };

    $lineStyle = '';
    if ($style === 'solid') {
        $lineStyle = "height: {$thickness}px; background-color: {$color};";
    } elseif ($style === 'gradient') {
        $lineStyle = "height: {$thickness}px; background: linear-gradient(90deg, {$grad1}, {$grad2});";
    } elseif ($style === 'dashed') {
        $lineStyle = "border-top: {$thickness}px dashed {$color};";
    } elseif ($style === 'dotted') {
        $lineStyle = "border-top: {$thickness}px dotted {$color};";
    }
@endphp

<div id="{{ $uid }}" class="w-full flex {{ $alignClass }} px-4" style="margin-top: {{ $mt }}px; margin-bottom: {{ $mb }}px;">

    @if($type === 'spacer')
        <div class="{{ $widthClass }}" style="height: {{ $spacerHeight }};"></div>
    @else
        <div class="{{ $widthClass }}">
            @if($style === 'icon' || $style === 'text')
                <div class="flex items-center w-full gap-4">
                    <div class="flex-grow" style="border-top: {{ $thickness }}px solid {{ $color }}; opacity: 0.5;"></div>

                    <div class="flex-shrink-0 flex items-center justify-center" style="color: {{ $color }};">
                        @if($style === 'icon' && $centerIcon)
                            {!! rj_icon($centerIcon, 'w-6 h-6') !!}
                        @elseif($style === 'text' && $centerText)
                            <span class="text-sm font-bold uppercase tracking-widest bg-white px-2">{{ $centerText }}</span>
                        @endif
                    </div>

                    <div class="flex-grow" style="border-top: {{ $thickness }}px solid {{ $color }}; opacity: 0.5;"></div>
                </div>
            @else
                <div class="w-full" style="{{ $lineStyle }}"></div>
            @endif
        </div>
    @endif

</div>
