<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class LoginWidget extends BaseWidget
{
    public function id(): string
    {
        return 'login';
    }

    public function name(): string
    {
        return __('Login');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>';
    }

    public function category(): string
    {
        return 'forms';
    }

    public function description(): string
    {
        return __('A login form that turns into a user card when logged in.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Card Title'),
                'default' => __('Welcome back'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'subtitle',
                'type'    => 'text',
                'label'   => __('Card Subtitle'),
                'default' => __('Sign in to your account to continue'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'logged_title',
                'type'    => 'text',
                'label'   => __('Logged-in Heading'),
                'default' => __('Welcome'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_remember',
                'type'    => 'toggle',
                'label'   => __('Show "Remember me"'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_forgot',
                'type'    => 'toggle',
                'label'   => __('Show "Forgot password" link'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_register',
                'type'    => 'toggle',
                'label'   => __('Show "Create account" link'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'show_admin_btn',
                'type'    => 'toggle',
                'label'   => __('Show "Go to Admin" for admins'),
                'default' => true,
                'tab'     => 'content',
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#8b5cf6',
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
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
                'label'   => __('Card Shadow'),
                'default' => true,
                'tab'     => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'login_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.login', compact('settings', 'uid'))->render();
    }
}
