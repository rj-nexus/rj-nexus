@php
    $url = $settings['url'] ?? '';
    $color = str_replace('#', '', $settings['color'] ?? '#ff5500');
    $visual = $settings['visual'] ?? true;
    $autoplay = $settings['autoplay'] ?? false;
    $hideRelated = $settings['hide_related'] ?? false;
    $showComments = $settings['show_comments'] ?? true;
    $showUser = $settings['show_user'] ?? true;
    $height = $settings['height'] ?? '166';

    $embedUrl = '';
    if (!empty($url)) {
        $params = http_build_query([
            'url' => $url,
            'color' => '#' . $color,
            'auto_play' => $autoplay ? 'true' : 'false',
            'hide_related' => $hideRelated ? 'true' : 'false',
            'show_comments' => $showComments ? 'true' : 'false',
            'show_user' => $showUser ? 'true' : 'false',
            'visual' => $visual ? 'true' : 'false',
        ]);
        $embedUrl = 'https://w.soundcloud.com/player/?' . $params;
    }
@endphp

<div id="{{ $uid }}" class="w-full max-w-4xl mx-auto my-6">
    @if($embedUrl)
        <div class="relative w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" style="height: {{ $height }}px;">
            <iframe
                width="100%"
                height="100%"
                scrolling="no"
                frameborder="no"
                allow="autoplay"
                src="{{ $embedUrl }}">
            </iframe>
        </div>
    @else
        <div class="p-8 text-center bg-slate-50 border border-slate-200 border-dashed rounded-2xl text-slate-500">
            {{ __('Please enter a valid SoundCloud URL to display the player.') }}
        </div>
    @endif
</div>
