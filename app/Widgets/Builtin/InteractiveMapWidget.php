<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class InteractiveMapWidget extends BaseWidget
{
    public function id(): string
    {
        return 'interactive-map';
    }

    public function name(): string
    {
        return __('Interactive Map');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
    }

    public function category(): string
    {
        return 'advanced';
    }

    public function description(): string
    {
        return __('An OpenStreetMap-based interactive map with custom markers and popups.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'address',
                'type' => 'text',
                'label' => __('Location Address'),
                'default' => 'Baku, Azerbaijan',
                'tab' => 'content',
                'help' => __('Enter a city or address to center the map.'),
            ],
            [
                'name' => 'latitude',
                'type' => 'text',
                'label' => __('Latitude'),
                'default' => '40.4093',
                'tab' => 'content',
            ],
            [
                'name' => 'longitude',
                'type' => 'text',
                'label' => __('Longitude'),
                'default' => '49.8671',
                'tab' => 'content',
            ],
            [
                'name' => 'zoom',
                'type' => 'range',
                'label' => __('Zoom Level'),
                'default' => 13,
                'min' => 1,
                'max' => 19,
                'tab' => 'style',
            ],
            [
                'name' => 'map_style',
                'type' => 'select',
                'label' => __('Map Style'),
                'default' => 'light',
                'tab' => 'style',
                'options' => [
                    'light' => __('Light (Minimal)'),
                    'dark' => __('Dark Mode'),
                    'streets' => __('Standard Streets'),
                ],
            ],
            [
                'name' => 'marker_icon',
                'type' => 'icon',
                'label' => __('Marker Icon'),
                'default' => 'ph:map-pin',
                'tab' => 'style',
            ],
            [
                'name' => 'marker_color',
                'type' => 'color',
                'label' => __('Marker Color'),
                'default' => '#8b5cf6',
                'tab' => 'style',
            ],
            [
                'name' => 'popup_title',
                'type' => 'text',
                'label' => __('Popup Title'),
                'default' => __('Our Location'),
                'tab' => 'content',
            ],
            [
                'name' => 'popup_text',
                'type' => 'textarea',
                'label' => __('Popup Text'),
                'default' => __('Visit us at our main office. We are open Monday to Friday, 9am - 6pm.'),
                'tab' => 'content',
            ],
            [
                'name' => 'height',
                'type' => 'select',
                'label' => __('Height'),
                'default' => 'h-[500px]',
                'tab' => 'style',
                'options' => [
                    'h-[300px]' => __('Small (300px)'),
                    'h-[500px]' => __('Medium (500px)'),
                    'h-[700px]' => __('Large (700px)'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'map_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.interactive-map', compact('settings', 'uid'))->render();
    }
}
