<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AlertWidget extends BaseWidget
{
    public function id(): string
    {
        return 'alert';
    }

    public function name(): string
    {
        return __('Alert / Notification');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Display a message to your users with customizable colors and icons.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'type',
                'type' => 'select',
                'label' => __('Default Type'),
                'default' => 'info',
                'tab' => 'style',
                'options' => [
                    'info' => __('Info (Blue)'),
                    'success' => __('Success (Green)'),
                    'warning' => __('Warning (Yellow)'),
                    'error' => __('Error (Red)'),
                ],
            ],
            [
                'name' => 'custom_color',
                'type' => 'color',
                'label' => __('Custom Color (Optional)'),
                'default' => '',
                'tab' => 'style',
                'help' => __('Override the default color of the alert.'),
            ],
            [
                'name' => 'style',
                'type' => 'select',
                'label' => __('Design Style'),
                'default' => 'soft',
                'tab' => 'style',
                'options' => [
                    'soft' => __('Soft (Light Background)'),
                    'outline' => __('Outline (Border Only)'),
                    'filled' => __('Filled (Solid Color)'),
                ],
            ],
            [
                'name' => 'icon',
                'type' => 'icon',
                'label' => __('Icon'),
                'default' => 'ph:info',
                'tab' => 'content',
            ],
            [
                'name' => 'show_icon',
                'type' => 'toggle',
                'label' => __('Show Icon'),
                'default' => true,
                'tab' => 'content',
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Title (Optional)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'content',
                'type' => 'textarea',
                'label' => __('Message'),
                'default' => __('This is a sample notification message. You can customize it in the widget settings.'),
                'tab' => 'content',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'alert_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.alert', compact('settings', 'uid'))->render();
    }
}
