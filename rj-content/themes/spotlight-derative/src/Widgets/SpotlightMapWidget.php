<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightMapWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-map';
    }

    public function name(): string
    {
        return __('Spotlight Map (OpenStreetMap)');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A fully customizable dark-mode map with custom markers using OpenStreetMap and Leaflet.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Section Title (Optional)'),
                'default' => '',
            ],
            [
                'name' => 'address',
                'type' => 'text',
                'label' => __('Address Text'),
                'default' => 'Baku, Azerbaijan',
            ],
            [
                'name' => 'lat',
                'type' => 'text',
                'label' => __('Latitude (e.g. 40.4093)'),
                'default' => '40.4093',
            ],
            [
                'name' => 'lng',
                'type' => 'text',
                'label' => __('Longitude (e.g. 49.8671)'),
                'default' => '49.8671',
            ],
            [
                'name' => 'zoom',
                'type' => 'number',
                'label' => __('Zoom Level (1-20)'),
                'default' => 14,
                'min' => 1,
                'max' => 20,
            ],
            [
                'name' => 'height',
                'type' => 'number',
                'label' => __('Map Height (px)'),
                'default' => 450,
            ],
            [
                'name' => 'marker_icon',
                'type' => 'icon',
                'label' => __('Marker Icon'),
                'default' => 'ph:map-pin-fill',
            ],
            [
                'name' => 'marker_color',
                'type' => 'color',
                'label' => __('Marker Color'),
                'default' => '#3b82f6',
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-map', compact('settings'))->render();
    }
}
