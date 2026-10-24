<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class VideoHeroWidget extends BaseWidget
{
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
        return __('A full-screen video background hero section supporting local videos, YouTube, and Vimeo.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Section Height'),
                'default' => 'h-screen',
                'tab' => 'content',
                'options' => [
                    'h-[60vh]' => __('Medium (60vh)'),
                    'h-[80vh]' => __('Large (80vh)'),
                    'h-screen' => __('Full Screen'),
                ]
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
                    'external' => __('External URL (MP4)'),
                ]
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
                'help' => __('Used for YouTube, Vimeo, or External MP4 URL.'),
            ],
            [
                'name' => 'fallback_image',
                'type' => 'media',
                'label' => __('Fallback Image'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Shown if the video fails to load or on slow connections.'),
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => __('Experience the Future'),
                'tab' => 'content',
            ],
            [
                'name' => 'subtitle',
                'type' => 'text',
                'label' => __('Subtitle'),
                'default' => __('Watch our latest collection in motion.'),
                'tab' => 'content',
            ],
            [
                'name' => 'btn_text',
                'type' => 'text',
                'label' => __('Button Text'),
                'default' => __('Discover Now'),
                'tab' => 'content',
            ],
            [
                'name' => 'btn_url',
                'type' => 'text',
                'label' => __('Button URL'),
                'default' => '/shop',
                'tab' => 'content',
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Text Alignment'),
                'default' => 'center',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ]
            ],
            [
                'name' => 'overlay_color',
                'type' => 'color',
                'label' => __('Overlay Color'),
                'default' => '#000000',
                'tab' => 'style',
            ],
            [
                'name' => 'overlay_opacity',
                'type' => 'range',
                'label' => __('Overlay Opacity (%)'),
                'default' => 40,
                'min' => 0,
                'max' => 100,
                'tab' => 'style',
            ],
            [
                'name' => 'title_color',
                'type' => 'color',
                'label' => __('Title Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'subtitle_color',
                'type' => 'color',
                'label' => __('Subtitle Color'),
                'default' => '#f3f4f6',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_bg',
                'type' => 'color',
                'label' => __('Button Background'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_text_color',
                'type' => 'color',
                'label' => __('Button Text Color'),
                'default' => '#111827',
                'tab' => 'style',
            ],
            [
                'name' => 'btn_hover_bg',
                'type' => 'color',
                'label' => __('Button Hover Background'),
                'default' => '#f3f4f6',
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $source = $settings['video_source'] ?? 'local';
        $videoFile = $settings['video_file'] ?? '';
        $videoUrl = $settings['video_url'] ?? '';

        $finalVideoUrl = '';
        $isIframe = false;

        if ($source === 'local' && !empty($videoFile)) {
            $finalVideoUrl = $videoFile;
        } elseif ($source === 'external' && !empty($videoUrl)) {
            $finalVideoUrl = $videoUrl;
        } elseif (in_array($source, ['youtube', 'vimeo']) && !empty($videoUrl)) {
            $isIframe = true;
            if ($source === 'youtube') {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $videoUrl, $matches);
                $videoId = $matches[1] ?? '';
                if ($videoId) {
                    $finalVideoUrl = 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&loop=1&playlist=' . $videoId . '&controls=0&showinfo=0&rel=0&playsinline=1';
                }
            } elseif ($source === 'vimeo') {
                preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/i', $videoUrl, $matches);
                $videoId = $matches[1] ?? '';
                if ($videoId) {
                    $finalVideoUrl = 'https://player.vimeo.com/video/' . $videoId . '?background=1&autoplay=1&loop=1&muted=1';
                }
            }
        }

        return view('rjbuilder.widgets.builtin.video-hero', compact('settings', 'finalVideoUrl', 'isIframe'))->render();
    }
}
