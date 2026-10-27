<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class FlipBoxWidget extends BaseWidget
{
    public function id(): string
    {
        return 'flip-box';
    }

    public function name(): string
    {
        return __('Flip Box');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M8 10l-2 2 2 2M16 10l2 2-2 2"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('A card that reveals a hidden face on hover with flip, slide, fade, zoom or push effects.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'effect',
                'type'    => 'select',
                'label'   => __('Hover Effect'),
                'default' => 'flip-h',
                'tab'     => 'content',
                'options' => [
                    'flip-h'      => __('3D Flip Horizontal'),
                    'flip-v'      => __('3D Flip Vertical'),
                    'flip-diag'   => __('3D Flip Diagonal'),
                    'slide-up'    => __('Slide Up'),
                    'slide-down'  => __('Slide Down'),
                    'slide-left'  => __('Slide Left'),
                    'slide-right' => __('Slide Right'),
                    'fade'        => __('Fade'),
                    'zoom-in'     => __('Zoom In'),
                    'zoom-out'    => __('Zoom Out'),
                    'rotate'      => __('Rotate'),
                    'push-up'     => __('Push Up'),
                    'push-left'   => __('Push Left'),
                ],
                'help'    => __('How the back face appears on hover.'),
            ],
            [
                'name'    => 'height',
                'type'    => 'range',
                'label'   => __('Box Height'),
                'default' => 320,
                'min'     => 200,
                'max'     => 500,
                'step'    => 10,
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Corner Radius'),
                'default' => 'xl',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'md'   => __('Medium'),
                    'xl'   => __('Large'),
                    '2xl'  => __('Extra Large'),
                ],
            ],
            [
                'name'    => 'shadow',
                'type'    => 'toggle',
                'label'   => __('Shadow'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'front_bg',
                'type'    => 'color',
                'label'   => __('Front Background'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'front_color',
                'type'    => 'color',
                'label'   => __('Front Text Color'),
                'default' => '#0f172a',
                'tab'     => 'style',
            ],
            [
                'name'    => 'back_bg',
                'type'    => 'color',
                'label'   => __('Back Background'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'back_color',
                'type'    => 'color',
                'label'   => __('Back Text Color'),
                'default' => '#ffffff',
                'tab'     => 'style',
            ],
            [
                'name'    => 'front_icon',
                'type'    => 'icon',
                'label'   => __('Front Icon'),
                'default' => 'ph:rocket-launch-duotone',
                'tab'     => 'content',
            ],
            [
                'name'    => 'front_title',
                'type'    => 'text',
                'label'   => __('Front Title'),
                'default' => __('Our Mission'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'front_text',
                'type'    => 'textarea',
                'label'   => __('Front Text'),
                'default' => __('Hover to learn more about what drives us.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'back_title',
                'type'    => 'text',
                'label'   => __('Back Title'),
                'default' => __('We Build Fast'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'back_text',
                'type'    => 'textarea',
                'label'   => __('Back Text'),
                'default' => __('Crafting modern, high-performance websites that convert.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_label',
                'type'    => 'text',
                'label'   => __('Button Label'),
                'default' => __('Learn More'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_url',
                'type'    => 'text',
                'label'   => __('Button URL'),
                'default' => '#',
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_style',
                'type'    => 'select',
                'label'   => __('Button Style'),
                'default' => 'solid',
                'tab'     => 'style',
                'options' => [
                    'solid'   => __('Solid White'),
                    'outline' => __('Outline White'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'fb_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.flip-box', compact('settings', 'uid'))->render();
    }
}
