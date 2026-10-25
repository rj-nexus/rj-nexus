@php
    $type = $settings['type'] ?? 'info';
    $style = $settings['style'] ?? 'soft';
    $customColor = $settings['custom_color'] ?? '';
    $showIcon = $settings['show_icon'] ?? true;
    $iconName = $settings['icon'] ?? 'ph:info';
    $title = $settings['title'] ?? '';
    $content = $settings['content'] ?? '';

    $baseColor = $customColor;
    if (empty($baseColor)) {
        $baseColor = match($type) {
            'success' => '#10b981',
            'warning' => '#f59e0b',
            'error' => '#ef4444',
            default => '#3b82f6',
        };
    }

    // HEX to RGB for opacity manipulation
    list($r, $g, $b) = sscanf($baseColor, "#%02x%02x%02x");
    $rgb = "$r, $g, $b";

    $containerStyle = '';
    $iconStyle = '';
    $titleStyle = '';
    $textStyle = '';

    if ($style === 'filled') {
        $containerStyle = "background-color: {$baseColor}; color: #ffffff; border-color: transparent;";
        $iconStyle = "color: #ffffff;";
        $titleStyle = "color: #ffffff;";
        $textStyle = "color: rgba(255,255,255,0.85);";
    } elseif ($style === 'outline') {
        $containerStyle = "background-color: transparent; border-color: {$baseColor};";
        $iconStyle = "color: {$baseColor};";
        $titleStyle = "color: {$baseColor};";
        $textStyle = "color: {$baseColor}; opacity: 0.8;";
    } else {
        $containerStyle = "background-color: rgba({$rgb}, 0.1); border-color: rgba({$rgb}, 0.2);";
        $iconStyle = "color: {$baseColor};";
        $titleStyle = "color: {$baseColor};";
        $textStyle = "color: {$baseColor}; opacity: 0.9;";
    }
@endphp

<style>
    @keyframes alertFadeIn-{{ $uid }} {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #{{ $uid }} {
        animation: alertFadeIn-{{ $uid }} 0.5s ease-out forwards;
    }
</style>

<div id="{{ $uid }}" class="w-full max-w-4xl mx-auto my-6">
    <div class="flex items-start gap-4 p-5 rounded-2xl border shadow-sm" style="{{ $containerStyle }}">

        @if($showIcon && !empty($iconName))
            <div class="flex-shrink-0 mt-0.5" style="{{ $iconStyle }}">
                {!! rj_icon($iconName, 'w-6 h-6') !!}
            </div>
        @endif

        <div class="flex-1 min-w-0">
            @if(!empty($title))
                <h4 class="text-base font-bold mb-1" style="{{ $titleStyle }}">{{ $title }}</h4>
            @endif

            @if(!empty($content))
                <div class="text-sm leading-relaxed" style="{{ $textStyle }}">
                    {!! nl2br(e($content)) !!}
                </div>
            @endif
        </div>

        <button type="button" onclick="this.parentElement.style.display='none'" class="flex-shrink-0 ml-auto opacity-50 hover:opacity-100 transition-opacity" style="{{ $iconStyle }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
