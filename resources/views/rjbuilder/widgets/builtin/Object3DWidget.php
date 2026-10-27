<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class Object3DWidget extends BaseWidget
{
    public function id(): string
    {
        return 'object-3d';
    }

    public function name(): string
    {
        return __('3D Object');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l9 5v10l-9 5-9-5V7l9-5zM12 12l9-5M12 12l-9-5M12 12v10"/></svg>';
    }

    public function category(): string
    {
        return 'media';
    }

    public function description(): string
    {
        return __('An interactive 3D model viewer with drag-rotate, auto-rotate and optional background.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Section Subtitle'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'model_url',
                'type'    => 'text',
                'label'   => __('3D Model URL (.glb / .gltf)'),
                'default' => 'https://modelviewer.dev/shared-assets/models/Astronaut.glb',
                'tab'     => 'content',
                'help'    => __('Direct link to a .glb or .gltf file.'),
            ],
            [
                'name'    => 'usdz_url',
                'type'    => 'text',
                'label'   => __('USDZ URL (for iOS AR)'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Optional. Enables "View in AR" on iOS devices.'),
            ],
            [
                'name'    => 'poster',
                'type'    => 'media',
                'label'   => __('Poster Image'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Shown while the model loads.'),
            ],
            [
                'name'    => 'camera_orbit',
                'type'    => 'text',
                'label'   => __('Camera Orbit (theta phi radius)'),
                'default' => '0deg 75deg 105%',
                'tab'     => 'style',
                'help'    => __('Example: 0deg 75deg 105%'),
            ],
            [
                'name'    => 'auto_rotate',
                'type'    => 'toggle',
                'label'   => __('Auto Rotate'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'enable_zoom',
                'type'    => 'toggle',
                'label'   => __('Enable Zoom'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'enable_pan',
                'type'    => 'toggle',
                'label'   => __('Enable Pan'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'background',
                'type'    => 'select',
                'label'   => __('Background Style'),
                'default' => 'gradient',
                'tab'     => 'style',
                'options' => [
                    'transparent' => __('Transparent'),
                    'light'       => __('Light'),
                    'dark'        => __('Dark'),
                    'gradient'    => __('Gradient'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Gradient End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'height',
                'type'    => 'range',
                'label'   => __('Viewer Height (px)'),
                'default' => 480,
                'min'     => 240,
                'max'     => 900,
                'step'    => 20,
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Corner Radius'),
                'default' => 'lg',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'xl'   => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'padding_y',
                'type'    => 'range',
                'label'   => __('Vertical Padding'),
                'default' => 60,
                'min'     => 0,
                'max'     => 160,
                'step'    => 4,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'o3_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.object-3d', compact('settings', 'uid'))->render();
    }
}
