@php
    $icon = $settings['icon'] ?? '';
    $title = $settings['title'] ?? '';
    $description = $settings['description'] ?? '';
    $linkUrl = $settings['link_url'] ?? '';
    $layout = $settings['layout'] ?? 'top';
    $align = $settings['align'] ?? 'center';
    $iconStyle = $settings['icon_style'] ?? 'circle';
    $iconColor = $settings['icon_color'] ?? '#8b5cf6';
    $iconBg = $settings['icon_bg'] ?? '#8b5cf615';
    $hoverAnimation = $settings['hover_animation'] ?? 'rotate';
    $boxStyle = $settings['box_style'] ?? 'card';
    $radius = $settings['border_radius'] ?? 'rounded-2xl';

    $flexDir = 'flex-col';
    $alignItems = 'items-center';
    $textAlign = 'text-center';

    if ($layout === 'left') {
        $flexDir = 'flex-col sm:flex-row';
        $alignItems = 'items-center sm:items-start';
        $textAlign = 'text-center sm:text-left';
    } elseif ($layout === 'right') {
        $flexDir = 'flex-col sm:flex-row-reverse';
        $alignItems = 'items-center sm:items-start';
        $textAlign = 'text-center sm:text-right';
    } else {
        if ($align === 'left') { $alignItems = 'items-start'; $textAlign = 'text-left'; }
        elseif ($align === 'right') { $alignItems = 'items-end'; $textAlign = 'text-right'; }
    }

    $shapeClass = match($iconStyle) {
        'circle' => 'rounded-full',
        'square' => 'rounded-xl',
        default => 'rounded-none',
    };

    $wrapperClass = $boxStyle === 'card'
        ? "bg-white border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-indigo-500/30 {$radius} p-6 sm:p-8 transition-all duration-300 group"
        : "group w-full";

    $tag = !empty($linkUrl) ? 'a' : 'div';
    $href = !empty($linkUrl) ? "href=\"{$linkUrl}\"" : '';
@endphp

<style>
    @keyframes rj-icon-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    @keyframes rj-icon-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    @keyframes rj-icon-pulse {
        0% { box-shadow: 0 0 0 0 {{ $iconColor }}60; }
        70% { box-shadow: 0 0 0 12px {{ $iconColor }}00; }
        100% { box-shadow: 0 0 0 0 {{ $iconColor }}00; }
    }

    #{{ $uid }} .rj-icon-box {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #{{ $uid }}:hover .rj-icon-box.rj-anim-rotate {
        transform: rotate(15deg) scale(1.1);
        background-color: {{ $iconColor }};
        color: #ffffff !important;
    }
    #{{ $uid }}:hover .rj-icon-box.rj-anim-bounce {
        animation: rj-icon-bounce 0.8s ease infinite alternate;
        background-color: {{ $iconColor }};
        color: #ffffff !important;
    }
    #{{ $uid }}:hover .rj-icon-box.rj-anim-float {
        animation: rj-icon-float 1.5s ease-in-out infinite;
        background-color: {{ $iconColor }};
        color: #ffffff !important;
    }
    #{{ $uid }}:hover .rj-icon-box.rj-anim-pulse {
        animation: rj-icon-pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        background-color: {{ $iconColor }};
        color: #ffffff !important;
    }

    #{{ $uid }} .rj-icon-box svg {
        transition: transform 0.4s ease;
    }
    #{{ $uid }}:hover .rj-icon-box svg {
        transform: scale(1.1);
    }
</style>

<{{ $tag }} {{ $href }} id="{{ $uid }}" class="block w-full {{ $wrapperClass }}">
    <div class="flex {{ $flexDir }} {{ $alignItems }} gap-5 w-full">

        @if($icon)
            <div class="rj-icon-box rj-anim-{{ $hoverAnimation }} flex-shrink-0 flex items-center justify-center w-16 h-16 {{ $shapeClass }}" style="color: {{ $iconColor }}; background-color: {{ $iconBg }};">
                {!! rj_icon($icon, 'w-8 h-8') !!}
            </div>
        @endif

        <div class="flex-1 w-full {{ $textAlign }}">
            @if($title)
                <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-slate-500 leading-relaxed">{{ $description }}</p>
            @endif
        </div>

    </div>
</{{ $tag }}>
