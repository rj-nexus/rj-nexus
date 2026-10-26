<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class VideoWidget extends BaseWidget
{
    private const ASPECTS = [
        'aspect-video' => ['16 / 9', 1.7778],
        'aspect-square' => ['1 / 1', 1.0],
        'aspect-[9/16]' => ['9 / 16', 0.5625],
        'aspect-[4/3]' => ['4 / 3', 1.3333],
    ];

    private const RADII = [
        'rounded-none' => '0px',
        'rounded-xl' => '12px',
        'rounded-2xl' => '22px',
        'rounded-3xl' => '34px',
        'rounded-full' => '999px',
    ];

    private const WIDTHS = [
        'small' => 640,
        'medium' => 900,
        'large' => 1200,
        'full' => 0,
    ];

    private const MAX_HEIGHTS = [
        '60' => 60,
        '70' => 70,
        '80' => 80,
        'none' => 0,
    ];

    public function id(): string
    {
        return 'video';
    }

    public function name(): string
    {
        return __('Video Player');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('Embed videos from YouTube, Vimeo, Dailymotion, or self-hosted files with custom playback behaviors.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'source',
                'type' => 'select',
                'label' => __('Video Source'),
                'default' => 'youtube',
                'tab' => 'content',
                'options' => [
                    'youtube' => __('YouTube'),
                    'vimeo' => __('Vimeo'),
                    'dailymotion' => __('Dailymotion'),
                    'self_hosted' => __('Self-Hosted (MP4)'),
                ],
            ],
            [
                'name' => 'video_url',
                'type' => 'text',
                'label' => __('Video URL'),
                'default' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'tab' => 'content',
                'help' => __('Paste the URL for YouTube, Vimeo, or Dailymotion.'),
            ],
            [
                'name' => 'video_file',
                'type' => 'media',
                'label' => __('Self-Hosted Video File (MP4)'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Upload an MP4 file. Used only if Source is Self-Hosted.'),
            ],
            [
                'name' => 'poster_image',
                'type' => 'media',
                'label' => __('Poster Image (Thumbnail)'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Shown before the video plays. Overrides the automatic YouTube thumbnail.'),
            ],
            [
                'name' => 'caption',
                'type' => 'text',
                'label' => __('Caption on Poster'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'behavior',
                'type' => 'select',
                'label' => __('Playback Behavior'),
                'default' => 'static',
                'tab' => 'style',
                'options' => [
                    'static' => __('Static Poster (Click to Play)'),
                    'hover' => __('Hover to Play (muted, tap on touch devices)'),
                    'autoplay' => __('Autoplay (Muted on load)'),
                ],
            ],
            [
                'name' => 'width',
                'type' => 'select',
                'label' => __('Width'),
                'default' => 'medium',
                'tab' => 'style',
                'options' => [
                    'small' => __('Small (640px)'),
                    'medium' => __('Medium (900px)'),
                    'large' => __('Large (1200px)'),
                    'full' => __('Full Width'),
                ],
            ],
            [
                'name' => 'max_height',
                'type' => 'select',
                'label' => __('Max Height (% of screen)'),
                'default' => '70',
                'tab' => 'style',
                'options' => [
                    '60' => __('60%'),
                    '70' => __('70%'),
                    '80' => __('80%'),
                    'none' => __('No limit'),
                ],
            ],
            [
                'name' => 'aspect_ratio',
                'type' => 'select',
                'label' => __('Aspect Ratio'),
                'default' => 'aspect-video',
                'tab' => 'style',
                'options' => [
                    'aspect-video' => __('16:9 (Standard)'),
                    'aspect-square' => __('1:1 (Square)'),
                    'aspect-[9/16]' => __('9:16 (Vertical / Reels)'),
                    'aspect-[4/3]' => __('4:3 (Classic)'),
                ],
            ],
            [
                'name' => 'border_radius',
                'type' => 'select',
                'label' => __('Border Radius'),
                'default' => 'rounded-2xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-xl' => __('Small'),
                    'rounded-2xl' => __('Medium'),
                    'rounded-3xl' => __('Large'),
                    'rounded-full' => __('Full (Pill)'),
                ],
            ],
            ['name' => 'play_btn_bg', 'type' => 'color', 'label' => __('Play Button Background'), 'default' => '#8b5cf6', 'tab' => 'style'],
            ['name' => 'play_btn_color', 'type' => 'color', 'label' => __('Play Button Icon Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'loop', 'type' => 'toggle', 'label' => __('Loop Video'), 'default' => false, 'tab' => 'style'],
            ['name' => 'mute', 'type' => 'toggle', 'label' => __('Mute Audio (always on for Hover and Autoplay)'), 'default' => false, 'tab' => 'style'],
            ['name' => 'show_controls', 'type' => 'toggle', 'label' => __('Show Player Controls'), 'default' => true, 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $source = $this->pick($settings['source'] ?? 'youtube', ['youtube', 'vimeo', 'dailymotion', 'self_hosted'], 'youtube');
        $behavior = $this->pick($settings['behavior'] ?? 'static', ['static', 'hover', 'autoplay'], 'static');
        $url = trim((string) ($settings['video_url'] ?? ''));
        $file = $this->mediaUrl((string) ($settings['video_file'] ?? ''));
        $poster = $this->mediaUrl((string) ($settings['poster_image'] ?? ''));

        $loop = $this->toBool($settings['loop'] ?? null, false);
        $controls = $this->toBool($settings['show_controls'] ?? null, true);
        $mute = $this->toBool($settings['mute'] ?? null, false) || $behavior !== 'static';

        $kind = $source === 'self_hosted' ? 'file' : 'iframe';
        $src = '';
        $posterFallback = '';

        if ($kind === 'file') {
            if ($file === '') {
                return $this->error(__('Please upload a video file.'));
            }
            $src = $file;
        } else {
            $id = $this->videoId($source, $url);
            if ($id === '') {
                return $this->error(__('Invalid video URL. Please check the link.'));
            }
            $src = $this->embedUrl($source, $id, $mute, $loop, $controls);

            if ($source === 'youtube' && $poster === '') {
                $poster = 'https://img.youtube.com/vi/' . $id . '/maxresdefault.jpg';
                $posterFallback = 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
            }
        }

        [$aspect, $ratio] = self::ASPECTS[$settings['aspect_ratio'] ?? 'aspect-video'] ?? self::ASPECTS['aspect-video'];
        $vertical = ($settings['aspect_ratio'] ?? '') === 'aspect-[9/16]';

        $widthPx = self::WIDTHS[$this->pick($settings['width'] ?? 'medium', array_keys(self::WIDTHS), 'medium')];
        if ($vertical) {
            $widthPx = $widthPx === 0 ? 380 : min($widthPx, 380);
        }

        $maxVh = self::MAX_HEIGHTS[$this->pick($settings['max_height'] ?? '70', array_keys(self::MAX_HEIGHTS), '70')];

        $maxWidth = $widthPx > 0 ? $widthPx . 'px' : '100%';
        if ($maxVh > 0) {
            $maxWidth = 'min(' . $maxWidth . ', calc(' . $maxVh . 'vh * ' . $ratio . '))';
            $maxWidthSv = 'min(' . ($widthPx > 0 ? $widthPx . 'px' : '100%') . ', calc(' . $maxVh . 'svh * ' . $ratio . '))';
        } else {
            $maxWidthSv = $maxWidth;
        }

        $o = [
            'kind' => $kind,
            'src' => $src,
            'poster' => $poster,
            'poster_fallback' => $posterFallback,
            'behavior' => $behavior,
            'caption' => trim((string) ($settings['caption'] ?? '')),
            'aspect' => $aspect,
            'max_width' => $maxWidth,
            'max_width_sv' => $maxWidthSv,
            'radius' => self::RADII[$settings['border_radius'] ?? 'rounded-2xl'] ?? '22px',
            'play_bg' => $this->hex($settings['play_btn_bg'] ?? null, '#8b5cf6'),
            'play_color' => $this->hex($settings['play_btn_color'] ?? null, '#ffffff'),
            'loop' => $loop,
            'mute' => $mute,
            'controls' => $controls,
        ];

        $uid = 'video_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.video', compact('o', 'uid'))->render();
    }

    private function videoId(string $source, string $url): string
    {
        if ($url === '') {
            return '';
        }

        if ($source === 'youtube') {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts|live)\/|.*[?&]v=)|youtu\.be\/)([A-Za-z0-9_-]{11})/i', $url, $m);

            return $m[1] ?? '';
        }

        if ($source === 'vimeo') {
            preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/i', $url, $m);

            return $m[1] ?? '';
        }

        preg_match('/(?:dailymotion\.com\/video\/|dai\.ly\/)([a-z0-9]+)/i', $url, $m);

        return $m[1] ?? '';
    }

    private function embedUrl(string $source, string $id, bool $mute, bool $loop, bool $controls): string
    {
        $m = $mute ? 1 : 0;
        $l = $loop ? 1 : 0;
        $c = $controls ? 1 : 0;

        if ($source === 'youtube') {
            $q = 'autoplay=1&mute=' . $m . '&controls=' . $c . '&rel=0&playsinline=1&modestbranding=1';
            if ($loop) {
                $q .= '&loop=1&playlist=' . $id;
            }

            return 'https://www.youtube-nocookie.com/embed/' . $id . '?' . $q;
        }

        if ($source === 'vimeo') {
            return 'https://player.vimeo.com/video/' . $id . '?autoplay=1&muted=' . $m . '&loop=' . $l . '&controls=' . $c . '&dnt=1';
        }

        return 'https://www.dailymotion.com/embed/video/' . $id . '?autoplay=1&mute=' . $m . '&controls=' . ($controls ? 'true' : 'false');
    }

    private function error(string $message): string
    {
        return '<div style="margin:16px auto;max-width:40rem;padding:28px;border:1px dashed #fca5a5;border-radius:16px;background:#fef2f2;color:#dc2626;text-align:center;font-size:.95rem;">' . e($message) . '</div>';
    }

    private function mediaUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^https?:/i', $url) ? $url : '';
        }

        return $url;
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function toBool(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    private function hex(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }
}
