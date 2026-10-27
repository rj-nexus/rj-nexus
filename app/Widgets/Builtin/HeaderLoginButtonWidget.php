<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class HeaderLoginButtonWidget extends BaseWidget
{
    public function id(): string
    {
        return 'header-login';
    }

    public function name(): string
    {
        return __('Header Login Button');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>';
    }

    public function category(): string
    {
        return 'header';
    }

    public function description(): string
    {
        return __('A compact header login button that turns into a user dropdown when logged in.');
    }

    public function contexts(): array
    {
        return ['header'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'login_label',
                'type'    => 'text',
                'label'   => __('Login Button Label'),
                'default' => __('Login'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'register_label',
                'type'    => 'text',
                'label'   => __('Register Button Label'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Leave empty to hide the register button.'),
            ],
            [
                'name'    => 'register_url',
                'type'    => 'text',
                'label'   => __('Register URL'),
                'default' => '/register',
                'tab'     => 'content',
            ],
            [
                'name'    => 'login_mode',
                'type'    => 'select',
                'label'   => __('Login Action'),
                'default' => 'modal',
                'tab'     => 'content',
                'options' => [
                    'modal'   => __('Inline Modal'),
                    'redirect'=> __('Redirect to Login Page'),
                ],
            ],
            [
                'name'    => 'show_avatar',
                'type'    => 'toggle',
                'label'   => __('Show Avatar when Logged In'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_name',
                'type'    => 'toggle',
                'label'   => __('Show User Name'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_admin_link',
                'type'    => 'toggle',
                'label'   => __('Show "Admin Panel" in Dropdown'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_account_link',
                'type'    => 'toggle',
                'label'   => __('Show "My Account" in Dropdown'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_settings_link',
                'type'    => 'toggle',
                'label'   => __('Show "Settings" in Dropdown'),
                'default' => false,
                'tab'     => 'content',
            ],
            [
                'name'    => 'btn_style',
                'type'    => 'select',
                'label'   => __('Button Style'),
                'default' => 'gradient',
                'tab'     => 'style',
                'options' => [
                    'gradient' => __('Gradient'),
                    'solid'    => __('Solid Accent'),
                    'outline'  => __('Outline'),
                    'ghost'    => __('Ghost (text only)'),
                    'dark'     => __('Dark'),
                ],
            ],
            [
                'name'    => 'size',
                'type'    => 'select',
                'label'   => __('Size'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Start'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent2',
                'type'    => 'color',
                'label'   => __('Accent End'),
                'default' => '#ec4899',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Radius'),
                'default' => 'md',
                'tab'     => 'style',
                'options' => [
                    'none' => __('None'),
                    'sm'   => __('Small'),
                    'md'   => __('Medium'),
                    'lg'   => __('Large'),
                    'full' => __('Full (pill)'),
                ],
            ],
            [
                'name'    => 'show_icon',
                'type'    => 'toggle',
                'label'   => __('Show User Icon'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_divider',
                'type'    => 'toggle',
                'label'   => __('Show Divider between Login and Register'),
                'default' => false,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'hlb_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.header-login-button', compact('settings', 'uid'))->render();
    }
}
