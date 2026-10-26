<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class ImageBoxWidget extends BaseWidget
{
    public function id(): string
    {
        return 'image-box';
    }

    public function name(): string
    {
        return __('Image Box');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A card with an image on top, followed by a title and a short description.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'image',
                'type' => 'media',
                'label' => __('Image'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title'),
                'default' => __('Card Title'),
                'tab' => 'content',
            ],
            [
                'name' => 'description',
                'type' => 'textarea',
                'label' => __('Description'),
                'default' => __('This is a short description for the image box. You can change it in the widget settings.'),
                'tab' => 'content',
            ],
            [
                'name' => 'link_url',
                'type' => 'text',
                'label' => __('Link URL (Optional)'),
                'default' => '',
                'tab' => 'content',
                'help' => __('Make the entire card clickable by adding a link here.'),
            ],
            [
                'name' => 'link_target',
                'type' => 'select',
                'label' => __('Link Target'),
                'default' => '_self',
                'tab' => 'content',
                'options' => [
                    '_self' => __('Same Window'),
                    '_blank' => __('New Window'),
                ],
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Style'),
                'default' => 'card',
                'tab' => 'style',
                'options' => [
                    'card' => __('Card (Shadow & Border)'),
                    'minimal' => __('Minimal (No Background)'),
                    'overlay' => __('Image Overlay (Text over Image)'),
                ],
            ],
            [
                'name' => 'image_ratio',
                'type' => 'select',
                'label' => __('Image Aspect Ratio'),
                'default' => 'aspect-[4/3]',
                'tab' => 'style',
                'options' => [
                    'aspect-[4/3]' => __('Landscape (4:3)'),
                    'aspect-video' => __('Video (16:9)'),
                    'aspect-square' => __('Square (1:1)'),
                    'aspect-[3/4]' => __('Portrait (3:4)'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                ],
            ],
            [
                'name' => 'hover_effect',
                'type' => 'toggle',
                'label' => __('Zoom Image on Hover'),
                'default' => true,
                'tab' => 'style',
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
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'imgbox_' . substr(md5(uniqid()), 0, 6);
        return view('rjbuilder.widgets.builtin.image-box', compact('settings', 'uid'))->render();
    }
}
