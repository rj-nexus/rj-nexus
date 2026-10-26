<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class VideoWidget extends BaseWidget
{
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
                ]
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
                'help' => __('Shown before the video plays. Overrides automatic YouTube/Vimeo thumbnails.'),
            ],
            [
                'name' => 'behavior',
                'type' => 'select',
                'label' => __('Playback Behavior'),
                'default' => 'static',
                'tab' => 'style',
                'options' => [
                    'static' => __('Static Poster (Click to Play)'),
                    'hover' => __('Hover to Play (Autoplay on mouseover)'),
                    'autoplay' => __('Autoplay (Muted on load)'),
                ]
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
                ]
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
                ]
            ],
            [
                'name' => 'play_btn_bg',
                'type' => 'color',
                'label' => __('Play Button Background'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'play_btn_color',
                'type' => 'color',
                'label' => __('Play Button Icon Color'),
                'default' => '#ffffff',
                'tab' => 'style',
            ],
            [
                'name' => 'loop',
                'type' => 'toggle',
                'label' => __('Loop Video'),
                'default' => false,
                'tab' => 'style',
            ],
            [
                'name' => 'mute',
                'type' => 'toggle',
                'label' => __('Mute Audio (Forced)'),
                'default' => false,
                'tab' => 'style',
            ],
            [
                'name' => 'show_controls',
                'type' => 'toggle',
                'label' => __('Show Player Controls'),
                'default' => true,
                'tab' => 'style',
            ]
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'video_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.video', compact('settings', 'uid'))->render();
    }
}
