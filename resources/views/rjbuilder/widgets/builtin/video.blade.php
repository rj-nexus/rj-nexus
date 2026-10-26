<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class VideoHeroWidget extends BaseWidget
{
    private const HEIGHTS = [
        'h-[60vh]' => 'height:60vh;height:60svh;min-height:420px;',
        'h-[70vh]' => 'height:70vh;height:70svh;min-height:460px;max-height:820px;',
        'h-[80vh]' => 'height:80vh;height:80svh;min-height:480px;',
        'h-screen' => 'height:100vh;height:100svh;min-height:520px;',
    ];

    private const TITLE_SIZES = [
        'sm' => 'clamp(1.75rem,4vw,3.25rem)',
        'md' => 'clamp(2rem,5.5vw,4.5rem)',
        'lg' => 'clamp(2.5rem,7.5vw,6.25rem)',
    ];

    private const BTN_RADIUS = [
        'sm' => '4px',
        'md' => '12px',
        'pill' => '999px',
    ];

    public function id(): string
    {
        return 'video-hero';
    }

    public function name(): string
    {
        return __('Video Hero');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A full-screen video background hero supporting local videos, YouTube and Vimeo, with animated text, two buttons and playback controls.');
    }

    private function yesNo(): array
    {
        return ['1' => __('Yes'), '0' => __('No')];
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Section Height'),
                'default' => 'h-[70vh]',
                'tab' => 'content',
                'options' => [
                    'h-[60vh]' => __('Medium (60vh)'),
                    'h-[70vh]' => __('Standard (70vh)'),
                    'h-[80vh]' => __('Large (80vh)'),
                    'h-screen' => __('Full Screen'),
                ],
            ],
            [
                'name' => 'video_source',
                'type' => 'select',
                'label' => __('Video Source'),
                'default' => 'local',
                'tab' => 'content',
                'options' => [
                    'local' => __('Local / Media Library'),
                    'youtube' => __('YouTube'),
                    'vimeo' => __('Vimeo'),
                    'external' => __('External URL (MP4 / WebM)'),
                ],
            ],
            [
                'name' => 'video_file',
                'type' => 'media',
                'label' => __('Local Video (MP4)'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Used only if Source is set to Local.'),
            ],
            [
                'name' => 'video_url',
                'type' => 'text',
                'label' => __('External Video URL'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
                'help' => __('Used for YouTube, Vimeo, or External video URL.'),
            ],
            [
                'name' => 'fallback_image',
                'type' => 'media',
                'label' => __('Fallback Image'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Shown while the video loads, if it fails, or when reduced motion is on.'),
            ],
            ['name' => 'eyebrow', 'type' => 'text', 'label' => __('Small Label'), 'default' => '', 'tab' => 'content'],
            ['name' => 'title', 'type' => 'text', 'label' => __('Title'), 'default' => __('Experience the *Future*'), 'tab' => 'content', 'help' => __('Wrap a word in *asterisks* to highlight it.')],
            ['name' => 'subtitle', 'type' => 'textarea', 'label' => __('Subtitle'), 'default' => __('Watch our latest collection in motion.'), 'tab' => 'content'],
            ['name' => 'btn_text', 'type' => 'text', 'label' => __('Button Text'), 'default' => __('Discover Now'), 'tab' => 'content'],
            ['name' => 'btn_url', 'type' => 'text', 'label' => __('Button URL'), 'default' => '/shop', 'tab' => 'content'],
            ['name' => 'btn2_text', 'type' => 'text', 'label' => __('Second Button Text'), 'default' => '', 'tab' => 'content'],
            ['name' => 'btn2_url', 'type' => 'text', 'label' => __('Second Button URL'), 'default' => '', 'tab' => 'content'],

            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Text Position (horizontal)'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
            [
                'name' => 'valign',
                'type' => 'select',
                'label' => __('Text Position (vertical)'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'top' => __('Top'),
                    'center' => __('Center'),
                    'bottom' => __('Bottom'),
                ],
            ],
            [
                'name' => 'content_style',
                'type' => 'select',
                'label' => __('Content Style'),
                'default' => 'plain',
                'tab' => 'style',
                'options' => [
                    'plain' => __('Plain text'),
                    'glass' => __('Glass card'),
                ],
            ],
            [
                'name' => 'title_size',
                'type' => 'select',
                'label' => __('Title Size'),
                'default' => 'md',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'text_animation',
                'type' => 'select',
                'label' => __('Text Animation'),
                'default' => 'rise',
                'tab' => 'style',
                'options' => [
                    'rise' => __('Rise'),
                    'fade' => __('Fade'),
                    'zoom' => __('Zoom'),
                    'blur' => __('Blur in'),
                ],
            ],
            ['name' => 'show_controls', 'type' => 'select', 'label' => __('Show Video Controls'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'show_hint', 'type' => 'select', 'label' => __('Show "Scroll" Hint'), 'default' => '1', 'tab' => 'style', 'options' => $this->yesNo()],
            ['name' => 'btn_new_tab', 'type' => 'select', 'label' => __('Open Buttons in New Tab'), 'default' => '0', 'tab' => 'style', 'options' => $this->yesNo()],
            [
                'name' => 'btn_radius',
                'type' => 'select',
                'label' => __('Button Shape'),
                'default' => 'pill',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Square'),
                    'md' => __('Rounded'),
                    'pill' => __('Pill'),
                ],
            ],
            [
                'name' => 'overlay_style',
                'type' => 'select',
                'label' => __('Overlay Style'),
                'default' => 'side',
                'tab' => 'style',
                'options' => [
                    'solid' => __('Solid'),
                    'gradient' => __('Gradient (bottom to top)'),
                    'side' => __('Follows text position'),
                ],
            ],
            ['name' => 'overlay_color', 'type' => 'color', 'label' => __('Overlay Color'), 'default' => '#000000', 'tab' => 'style'],
            ['name' => 'overlay_opacity', 'type' => 'range', 'label' => __('Overlay Opacity (%)'), 'default' => 40, 'min' => 0, 'max' => 100, 'tab' => 'style'],
            ['name' => 'accent_color', 'type' => 'color', 'label' => __('Accent Color'), 'default' => '#f59e0b', 'tab' => 'style'],
            ['name' => 'title_color', 'type' => 'color', 'label' => __('Title Color'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'subtitle_color', 'type' => 'color', 'label' => __('Subtitle Color'), 'default' => '#f3f4f6', 'tab' => 'style'],
            ['name' => 'btn_bg', 'type' => 'color', 'label' => __('Button Background'), 'default' => '#ffffff', 'tab' => 'style'],
            ['name' => 'btn_text_color', 'type' => 'color', 'label' => __('Button Text Color'), 'default' => '#111827', 'tab' => 'style'],
            ['name' => 'btn_hover_bg', 'type' => 'color', 'label' => __('Button Hover Background'), 'default' => '#f59e0b', 'tab' => 'style'],
            ['name' => 'btn_hover_text_color', 'type' => 'color', 'label' => __('Button Hover Text Color'), 'default' => '#111827', 'tab' => 'style'],
        ];
    }

    public function render(array $settings): string
    {
        $video = $this->resolveVideo($settings);

        $title = trim((string) ($settings['title'] ?? ''));
        $titleSize = $this->pick($settings['title_size'] ?? 'md', array_keys(self::TITLE_SIZES), 'md');
        $btnRadius = $this->pick($settings['btn_radius'] ?? 'pill', array_keys(self::BTN_RADIUS), 'pill');
        $textAnim = $this->pick($settings['text_animation'] ?? 'rise', ['rise', 'fade', 'zoom', 'blur'], 'rise');
        $overlayOpacity = $this->int($settings['overlay_opacity'] ?? 40, 0, 100) / 100;
        $heightKey = (string) ($settings['height'] ?? 'h-[70vh]');

        $content = [
            'eyebrow' => trim((string) ($settings['eyebrow'] ?? '')),
            'title' => str_replace('*', '', $title),
            'title_html' => $title === '' ? '' : $this->accent($title),
            'subtitle' => trim((string) ($settings['subtitle'] ?? '')),
            'btn_text' => trim((string) ($settings['btn_text'] ?? '')),
            'btn_url' => $this->safeUrl((string) ($settings['btn_url'] ?? '')),
            'btn2_text' => trim((string) ($settings['btn2_text'] ?? '')),
            'btn2_url' => $this->safeUrl((string) ($settings['btn2_url'] ?? '')),
        ];

        $opts = [
            'height_css' => self::HEIGHTS[$heightKey] ?? self::HEIGHTS['h-[70vh]'],
            'align' => $this->pick($settings['align'] ?? 'center', ['left', 'center', 'right'], 'center'),
            'valign' => $this->pick($settings['valign'] ?? 'center', ['top', 'center', 'bottom'], 'center'),
            'content_style' => $this->pick($settings['content_style'] ?? 'plain', ['plain', 'glass'], 'plain'),
            'title_font' => self::TITLE_SIZES[$titleSize],
            'text_anim' => 'rjvh-' . $textAnim,
            'show_controls' => $this->flag($settings['show_controls'] ?? null, true),
            'show_hint' => $this->flag($settings['show_hint'] ?? null, true),
            'btn_new_tab' => $this->flag($settings['btn_new_tab'] ?? null, false),
            'btn_radius' => self::BTN_RADIUS[$btnRadius],
            'overlay_style' => $this->pick($settings['overlay_style'] ?? 'side', ['solid', 'gradient', 'side'], 'side'),
            'overlay_color' => $this->color($settings['overlay_color'] ?? null, '#000000'),
            'overlay_opacity' => round($overlayOpacity, 2),
            'overlay_opacity_g' => round(min(1, $overlayOpacity * 1.7), 2),
            'accent' => $this->color($settings['accent_color'] ?? null, '#f59e0b'),
            'title_color' => $this->color($settings['title_color'] ?? null, '#ffffff'),
            'subtitle_color' => $this->color($settings['subtitle_color'] ?? null, '#f3f4f6'),
            'btn_bg' => $this->color($settings['btn_bg'] ?? null, '#ffffff'),
            'btn_text' => $this->color($settings['btn_text_color'] ?? null, '#111827'),
            'btn_hover_bg' => $this->color($settings['btn_hover_bg'] ?? null, '#f59e0b'),
            'btn_hover_text' => $this->color($settings['btn_hover_text_color'] ?? null, '#111827'),
            'fallback' => $this->safeMediaUrl((string) ($settings['fallback_image'] ?? '')),
        ];

        $uid = 'rjvh_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.video-hero', [
            'o' => $opts,
            'c' => $content,
            'v' => $video,
            'uid' => $uid,
        ])->render();
    }

    private function resolveVideo(array $settings): array
    {
        $none = ['kind' => 'none', 'url' => '', 'mime' => ''];

        $source = $this->pick($settings['video_source'] ?? 'local', ['local', 'youtube', 'vimeo', 'external'], 'local');
        $file = trim((string) ($settings['video_file'] ?? ''));
        $url = trim((string) ($settings['video_url'] ?? ''));

        if ($source === 'local' || $source === 'external') {
            $src = $this->safeMediaUrl($source === 'local' ? $file : $url);

            if ($src === '') {
                return $none;
            }

            return ['kind' => 'file', 'url' => $src, 'mime' => $this->mime($src)];
        }

        if ($url === '') {
            return $none;
        }

        if ($source === 'youtube') {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $m);
            $id = $m[1] ?? '';

            if (!preg_match('/^[A-Za-z0-9_-]{11}$/', $id)) {
                return $none;
            }

            $origin = rawurlencode(request()->getSchemeAndHttpHost());

            return [
                'kind' => 'youtube',
                'url' => 'https://www.youtube-nocookie.com/embed/' . $id
                    . '?autoplay=1&mute=1&loop=1&playlist=' . $id
                    . '&controls=0&rel=0&playsinline=1&modestbranding=1&disablekb=1&iv_load_policy=3&enablejsapi=1&origin=' . $origin,
                'mime' => '',
            ];
        }

        preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/i', $url, $m);
        $id = $m[1] ?? '';

        if ($id === '') {
            return $none;
        }

        return [
            'kind' => 'vimeo',
            'url' => 'https://player.vimeo.com/video/' . $id . '?background=1&autoplay=1&loop=1&muted=1&autopause=0&dnt=1&byline=0&title=0&portrait=0',
            'mime' => '',
        ];
    }

    private function mime(string $url): string
    {
        $path = (string) parse_url($url, PHP_URL_PATH);

        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'mp4', 'm4v' => 'video/mp4',
            'webm' => 'video/webm',
            'ogv', 'ogg' => 'video/ogg',
            'mov' => 'video/quicktime',
            default => '',
        };
    }

    private function accent(string $text): string
    {
        $escaped = e($text);

        return preg_replace('/\*(.+?)\*/u', '<span class="rjvh-accent">$1</span>', $escaped) ?? $escaped;
    }

    private function int(mixed $value, int $min, int $max): int
    {
        return max($min, min($max, (int) $value));
    }

    private function color(mixed $value, string $default): string
    {
        $value = trim((string) $value);

        return preg_match('/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value) ? $value : $default;
    }

    private function pick(mixed $value, array $allowed, string $default): string
    {
        $value = (string) $value;

        return in_array($value, $allowed, true) ? $value : $default;
    }

    private function flag(mixed $value, bool $default): bool
    {
        if ($value === null || $value === '') {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^[a-z][a-z0-9+.\-]*:/i', $url)) {
            return preg_match('/^(https?|mailto|tel):/i', $url) ? $url : '';
        }

        return $url;
    }

    private function safeMediaUrl(string $url): string
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
}
