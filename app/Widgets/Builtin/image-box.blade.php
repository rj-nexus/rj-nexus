@php
    $image = $settings['image'] ?? '';
    $title = $settings['title'] ?? '';
    $description = $settings['description'] ?? '';
    $linkUrl = $settings['link_url'] ?? '';
    $linkTarget = $settings['link_target'] ?? '_self';
    $style = $settings['style'] ?? 'card';
    $ratio = $settings['image_ratio'] ?? 'aspect-[4/3]';
    $align = $settings['align'] ?? 'left';
    $hover = $settings['hover_effect'] ?? true;
    $radius = $settings['border_radius'] ?? 'rounded-2xl';

    $alignClass = $align === 'center' ? 'text-center' : 'text-left';

    $wrapperClass = '';
    $imgWrapperClass = "relative w-full overflow-hidden {$ratio} {$radius}";
    $contentClass = '';

    if ($style === 'card') {
        $wrapperClass = "bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow duration-300 {$radius} overflow-hidden group";
        $imgWrapperClass = "relative w-full overflow-hidden {$ratio}";
        $contentClass = 'p-6';
    } elseif ($style === 'overlay') {
        $wrapperClass = "relative w-full {$ratio} {$radius} overflow-hidden group flex items-end";
        $imgWrapperClass = "absolute inset-0 w-full h-full";
        $contentClass = 'relative z-10 w-full p-6 bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white';
    } else {
        $wrapperClass = "group";
        $contentClass = 'mt-4';
    }

    $tag = !empty($linkUrl) ? 'a' : 'div';
    $href = !empty($linkUrl) ? "href=\"{$linkUrl}\" target=\"{$linkTarget}\"" : '';
@endphp

<{{ $tag }} {{ $href }} class="block w-full {{ $wrapperClass }}">
    <div class="{{ $imgWrapperClass }} bg-slate-100">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover {{ $hover ? 'transition-transform duration-700 ease-out group-hover:scale-110' : '' }}">
        @else
            <div class="w-full h-full flex items-center justify-center text-slate-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif
    </div>

    @if($style === 'overlay')
        <div class="{{ $contentClass }} {{ $alignClass }}">
            @if($title)
                <h3 class="text-xl font-bold mb-2 text-white">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-gray-200 leading-relaxed">{{ $description }}</p>
            @endif
        </div>
    @else
        <div class="{{ $contentClass }} {{ $alignClass }}">
            @if($title)
                <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="text-sm text-slate-500 leading-relaxed">{{ $description }}</p>
            @endif
        </div>
    @endif
</{{ $tag }}>
