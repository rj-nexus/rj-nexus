<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class GalaxyCookieWidget extends BaseWidget
{
    public function id(): string
    {
        return 'galaxy-cookie';
    }

    public function name(): string
    {
        return __('Galaxy Cookie Notice');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm-4.5-9a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm9 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm-4.5 4.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/></svg>';
    }

    public function category(): string
    {
        return 'system';
    }

    public function description(): string
    {
        return __('A modern, dark galaxy-themed cookie consent banner.');
    }

    public function contexts(): array
    {
        return ['page', 'header', 'footer'];
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Title'),
                'default' => __('We value your privacy'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'message',
                'type'    => 'textarea',
                'label'   => __('Message'),
                'default' => __('We use cookies to enhance your browsing experience and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'accept_text',
                'type'    => 'text',
                'label'   => __('Accept Button Text'),
                'default' => __('Accept All'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'decline_text',
                'type'    => 'text',
                'label'   => __('Decline Button Text'),
                'default' => __('Decline'),
                'tab'     => 'content',
            ],
            [
                'name'    => 'position',
                'type'    => 'select',
                'label'   => __('Position'),
                'default' => 'bottom-right',
                'tab'     => 'style',
                'options' => [
                    'bottom-right'  => __('Bottom Right'),
                    'bottom-left'   => __('Bottom Left'),
                    'bottom-center' => __('Bottom Center'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'gc_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.galaxy-cookie', compact('settings', 'uid'))->render();
    }
}