@php
    $image        = $settings['image'] ?? '';
    $url          = $settings['url'] ?? '/';
    $alt          = $settings['alt'] ?? rj_get_option('site_name', 'Logo');
    $width        = (int) ($settings['width'] ?? 140);
    $align        = $settings['align'] ?? 'left';
    $hoverOpacity = $settings['hover_opacity'] ?? true;

    $justify = 'flex-start';
    if ($align === 'center') $justify = 'center';
    elseif ($align === 'right') $justify = 'flex-end';
@endphp

<style>
    #{{ $uid }} {
        display: flex;
        justify-content: {{ $justify }};
        width: 100%;
    }
    #{{ $uid }} .rj-logo-link {
        display: inline-block;
        line-height: 0;
        transition: opacity .2s ease;
        text-decoration: none;
    }
    @if($hoverOpacity)
    #{{ $uid }} .rj-logo-link:hover {
        opacity: 0.7;
    }
    @endif
    #{{ $uid }} .rj-logo-img {
        width: {{ $width }}px;
        max-width: 100%;
        height: auto;
        max-height: 80px;
        display: block;
        object-fit: contain;
    }
</style>

<div id="{{ $uid }}">
    <a href="{{ $url }}" class="rj-logo-link">
        @if($image)
            <img src="{{ $image }}" alt="{{ $alt }}" class="rj-logo-img" loading="lazy">
        @else
            <div style="width: {{ $width }}px; height: 40px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #94a3b8; font-weight: bold;">{{ __('LOGO') }}</div>
        @endif
    </a>
</div>
