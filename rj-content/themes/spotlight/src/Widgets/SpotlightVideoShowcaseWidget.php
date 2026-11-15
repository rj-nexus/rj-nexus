<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightVideoShowcaseWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-video-showcase';
    }

    public function name(): string
    {
        return __('Spotlight Video Showcase');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('Display a video inside a sleek browser mockup with a lightbox play button.');
    }

    public function contexts(): array
    {
        return ['page', 'block'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('See it in action'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'textarea',
                'label'   => __('Subtitle'),
                'default' => __('Watch how our platform can transform your workflow in just a few minutes.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'video_url',
                'type'    => 'text',
                'label'   => __('Video URL (YouTube, Vimeo, or MP4)'),
                'default' => 'https://www.youtube.com/watch?v=BU4UXY2D3FU&t=23s',
                'tab'     => 'content',
            ],
            [
                'name'    => 'cover_image',
                'type'    => 'image',
                'label'   => __('Cover Image (Optional)'),
                'default' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1200&h=675',
                'tab'     => 'content',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'vs_' . substr(md5(uniqid('', true)), 0, 8);

        return view('spotlight::widgets.video-showcase', compact('settings', 'uid'))->render();
    }
}