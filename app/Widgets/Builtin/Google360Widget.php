<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class Google360Widget extends BaseWidget
{
    public function id(): string
    {
        return 'google-360';
    }

    public function name(): string
    {
        return __('Google 360 Tour');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M3 12h2m14 0h2M5.6 5.6l1.4 1.4m10 10l1.4 1.4m0-12.8l-1.4 1.4m-10 10l-1.4 1.4"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('Embed a Google 360-degree virtual tour or Google Maps Street View using an iframe.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Section Title (Optional)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'subtitle',
                'type' => 'text',
                'label' => __('Section Subtitle (Optional)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'iframe_code',
                'type' => 'textarea',
                'label' => __('Google Maps / 360 Iframe Code'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => '<iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>',
                'help' => __('Paste the full iframe code from Google Maps or Google Street View here. The system will extract the source link automatically.'),
            ],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'aspect-video',
                'tab' => 'style',
                'options' => [
                    'aspect-video' => __('Standard (16:9)'),
                    'aspect-square' => __('Square (1:1)'),
                    'aspect-[4/3]' => __('Classic (4:3)'),
                    'h-[400px]' => __('Fixed (400px)'),
                    'h-[600px]' => __('Fixed (600px)'),
                ],
            ],
            [
                'name' => 'border_radius',
                'type' => 'select',
                'label' => __('Border Radius'),
                'default' => 'rounded-3xl',
                'tab' => 'style',
                'options' => [
                    'rounded-none' => __('None'),
                    'rounded-xl' => __('Medium'),
                    'rounded-3xl' => __('Large'),
                    'rounded-full' => __('Full Round (Pill)'),
                ],
            ],
            [
                'name' => 'box_shadow',
                'type' => 'select',
                'label' => __('Shadow'),
                'default' => 'shadow-xl',
                'tab' => 'style',
                'options' => [
                    'shadow-none' => __('None'),
                    'shadow-md' => __('Small'),
                    'shadow-xl' => __('Medium'),
                    'shadow-2xl' => __('Large'),
                ],
            ],
            [
                'name' => 'hover_effect',
                'type' => 'toggle',
                'label' => __('Add Hover Scale Effect'),
                'default' => true,
                'tab' => 'style',
            ],
            [
                'name' => 'overlay_color',
                'type' => 'color',
                'label' => __('Border Color (Optional)'),
                'default' => '',
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $iframeCode = $settings['iframe_code'] ?? '';
        $iframeUrl = '';

        if (!empty($iframeCode)) {
            if (preg_match('/src="([^"]+)"/', $iframeCode, $matches)) {
                $iframeUrl = $matches[1];
            } elseif (filter_var($iframeCode, FILTER_VALIDATE_URL)) {
                $iframeUrl = $iframeCode;
            }
        }

        if (empty($iframeUrl)) {
            return '';
        }

        $uid = 'g360_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.google-360', compact('settings', 'iframeUrl', 'uid'))->render();
    }
}
