@php
    $image        = $settings['image'] ?? '';
    $url          = $settings['url'] ?? '/';
    $alt          = $settings['alt'] ?? rj_get_option('site_name', 'Logo');
    $width        = (int) ($settings['width'] ?? 140);
    $align        = $settings['align'] ?? 'left';
    $hoverOpacity = $settings['hover_opacity'] ?? true;

    // Əgər istifadəçi şəkil seçməyibsə, saytın default loqosunu yoxla
    $logoMask = function_exists('rj_logo_mask_url') ? rj_logo_mask_url() : '';
    $siteName = rj_get_option('site_name', 'RJ CMS');

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
    #{{ $uid }} .rj-logo-text {
        font-size: 24px;
        font-weight: 800;
        color: currentColor;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
</style>

<div id="{{ $uid }}">
    <a href="{{ $url }}" class="rj-logo-link">
        @if($image)
            <img src="{{ $image }}" alt="{{ $alt }}" class="rj-logo-img" loading="lazy">
        @elseif($logoMask)
            <div style="width: {{ $width }}px; height: 40px; background-color: currentColor; -webkit-mask-image: url('{{ $logoMask }}'); mask-image: url('{{ $logoMask }}'); -webkit-mask-size: contain; mask-size: contain; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-position: left center; mask-position: left center;"></div>
        @else
            <span class="rj-logo-text">{{ $siteName }}</span>
        @endif
    </a>
</div>
