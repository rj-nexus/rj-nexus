<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightFooterWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-footer';
    }

    public function name(): string
    {
        return __('Spotlight Footer');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A structural, grid-based footer with brand identity, link columns, and a bottom bar.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'logo_image',
                'type' => 'media',
                'label' => __('Logo Image'),
                'default' => '',
            ],
            [
                'name' => 'logo_text',
                'type' => 'text',
                'label' => __('Logo Text'),
                'default' => 'RJ Nexus',
            ],
            [
                'name' => 'tagline',
                'type' => 'textarea',
                'label' => __('Tagline (Optional)'),
                'default' => 'Building the next generation of digital experiences.',
            ],
            [
                'name' => 'columns',
                'type' => 'repeater',
                'label' => __('Link Columns'),
                'max_items' => 4,
                'default' => [
                    [
                        'title' => 'PRODUCT',
                        'links' => "Features | /\nBenefits | /\nHow to use | /\nPricing | /"
                    ],
                    [
                        'title' => 'LEGALS',
                        'links' => "Privacy Policy | /\nTerms & Conditions | /"
                    ],
                    [
                        'title' => 'SOCIAL',
                        'links' => "Twitter (X) | https://x.com\nGithub | https://github.com\nLinkedIn | https://linkedin.com"
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'title',
                        'type' => 'text',
                        'label' => __('Column Title'),
                        'default' => 'Column',
                    ],
                    [
                        'name' => 'links',
                        'type' => 'textarea',
                        'label' => __('Links (Label | URL, one per line)'),
                        'default' => "Link 1 | /\nLink 2 | /",
                    ],
                ],
            ],
            [
                'name' => 'show_copyright',
                'type' => 'toggle',
                'label' => __('Show Copyright Bar'),
                'default' => true,
            ],
            [
                'name' => 'copyright_text',
                'type' => 'text',
                'label' => __('Copyright Text'),
                'default' => '© ' . date('Y') . ' RJ NEXUS. ALL RIGHTS RESERVED.',
            ],
            [
                'name' => 'show_back_to_top',
                'type' => 'toggle',
                'label' => __('Show Back to Top Link'),
                'default' => true,
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-footer', compact('settings'))->render();
    }
}
