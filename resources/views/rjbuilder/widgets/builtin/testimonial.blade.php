@php
    $image = $settings['image'] ?? '';
    $name = $settings['name'] ?? '';
    $position = $settings['position'] ?? '';
    $text = $settings['text'] ?? '';
    $rating = (int)($settings['rating'] ?? 5);
    $style = $settings['style'] ?? 'modern';
    $starColor = $settings['star_color'] ?? '#f59e0b';
    $quoteColor = $settings['quote_color'] ?? '#8b5cf6';
    $imageStyle = $settings['image_style'] ?? 'circle';

    $imgClass = $imageStyle === 'circle' ? 'rounded-full' : 'rounded-2xl';

    $wrapperClass = '';
    if ($style === 'modern') {
        $wrapperClass = 'bg-white border border-slate-200 shadow-xl shadow-slate-200/50 rounded-3xl';
    } elseif ($style === 'glass') {
        $wrapperClass = 'bg-white/40 backdrop-blur-xl border border-white/40 shadow-2xl rounded-3xl';
    } else {
        $wrapperClass = 'bg-transparent';
    }
@endphp

<style>
    #{{ $uid }} {
        transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    #{{ $uid }}:hover {
        transform: translateY(-4px);
    }
</style>

<div id="{{ $uid }}" class="w-full max-w-3xl mx-auto p-8 sm:p-10 {{ $wrapperClass }}">
    <div class="flex flex-col md:flex-row gap-8 md:gap-10 items-center md:items-start">

        <div class="flex flex-col items-center flex-shrink-0 w-40 text-center">
            @if($image)
                <img src="{{ $image }}" alt="{{ $name }}" class="w-24 h-24 sm:w-28 sm:h-28 object-cover {{ $imgClass }} shadow-lg border-4 border-white mb-4">
            @else
                <div class="w-24 h-24 sm:w-28 sm:h-28 {{ $imgClass }} bg-slate-100 flex items-center justify-center mb-4 border-4 border-white shadow-lg">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            @endif

            @if($name)
                <h4 class="text-lg font-extrabold text-slate-900 leading-tight">{{ $name }}</h4>
            @endif
            @if($position)
                <p class="text-xs font-bold text-indigo-500 uppercase tracking-wide mt-1">{{ $position }}</p>
            @endif
        </div>

        <div class="flex-1 flex flex-col justify-between h-full text-center md:text-left relative">
            <div class="absolute top-0 left-1/2 md:left-0 -translate-x-1/2 md:translate-x-0 -mt-6 opacity-10" style="color: {{ $quoteColor }};">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>

            <div class="relative z-10 pt-4 md:pt-0">
                @if($text)
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-medium italic mb-6">"{{ $text }}"</p>
                @endif
            </div>

            <div class="flex items-center justify-center md:justify-start gap-1 mt-auto">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= $rating ? 'opacity-100' : 'opacity-20' }}" fill="{{ $i <= $rating ? $starColor : '#cbd5e1' }}" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
        </div>

    </div>
</div>
