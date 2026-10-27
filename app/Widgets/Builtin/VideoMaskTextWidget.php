<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class VideoMaskTextWidget extends BaseWidget
{
    public function id(): string
    {
        return 'video-mask-text';
    }

    public function name(): string
    {
        return __('Video Mask Text');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('Giant typography with a looping video visible through the text. Hover for color fill.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'text',
                'type'    => 'text',
                'label'   => __('Masked Text'),
                'default' => __('CREATIVE'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Subtitle (below)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'video_url',
                'type'    => 'text',
                'label'   => __('Video URL (mp4 / webm)'),
                'default' => 'https://cdn.pixabay.com/video/2023/03/31/156932-814104173_large.mp4',
                'tab'     => 'content',
                'help'    => __('Direct link to a video file. Use a short, muted, looping video for best results.'),
            ],
            [
                'name'    => 'poster',
                'type'    => 'media',
                'label'   => __('Poster Image (fallback)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Shown while the video loads.'),
            ],
            [
                'name'    => 'font_size',
                'type'    => 'range',
                'label'   => __('Text Size (vw)'),
                'default' => 18,
                'min'     => 6,
                'max'     => 30,
                'step'    => 1,
                'tab'     => 'style',
            ],
            [
                'name'    => 'font_weight',
                'type'    => 'select',
                'label'   => __('Font Weight'),
                'default' => '900',
                'tab'     => 'style',
                'options' => ['700' => '700', '800' => '800', '900' => '900'],
            ],
            [
                'name'    => 'letter_spacing',
                'type'    => 'range',
                'label'   => __('Letter Spacing (em × 100)'),
                'default' => -2,
                'min'     => -10,
                'max'     => 40,
                'step'    => 1,
                'tab'     => 'style',
            ],
            [
                'name'    => 'align',
                'type'    => 'select',
                'label'   => __('Alignment'),
                'default' => 'center',
                'tab'     => 'style',
                'options' => [
                    'left'   => __('Left'),
                    'center' => __('Center'),
                    'right'  => __('Right'),
                ],
            ],
            [
                'name'    => 'fallback_color',
                'type'    => 'color',
                'label'   => __('Fallback Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
                'help'    => __('Shown if the video cannot load.'),
            ],
            [
                'name'    => 'subtitle_color',
                'type'    => 'color',
                'label'   => __('Subtitle Color'),
                'default' => '#64748b',
                'tab'     => 'style',
            ],
            [
                'name'    => 'hover_accent',
                'type'    => 'toggle',
                'label'   => __('Color Fill on Hover'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'hover_color',
                'type'    => 'color',
                'label'   => __('Hover Fill Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'overlay',
                'type'    => 'toggle',
                'label'   => __('Subtle Video Overlay'),
                'default' => false,
                'tab'     => 'style',
            ],
            [
                'name'    => 'overlay_color',
                'type'    => 'color',
                'label'   => __('Overlay Tint'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 60,
                'min'     => 0,
                'max'     => 200,
                'step'    => 4,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'vmt_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.video-mask-text', compact('settings', 'uid'))->render();
    }
}
