<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightTrustpilotWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-trustpilot';
    }

    public function name(): string
    {
        return __('Spotlight Trustpilot');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('Display your real Trustpilot rating and review count using the official API.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'api_key',
                'type' => 'text',
                'label' => __('Trustpilot API Key'),
                'default' => '',
                'help' => __('Get this from your Trustpilot Business account.'),
            ],
            [
                'name' => 'business_unit_id',
                'type' => 'text',
                'label' => __('Business Unit ID'),
                'default' => '',
                'help' => __('The 24-character hexadecimal ID of your Trustpilot profile.'),
            ],
            [
                'name' => 'show_reviews',
                'type' => 'toggle',
                'label' => __('Show Review Count'),
                'default' => true,
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'center',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-trustpilot', compact('settings'))->render();
    }
}
