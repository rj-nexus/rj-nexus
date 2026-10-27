<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class GoogleReviewsWidget extends BaseWidget
{
    public function id(): string
    {
        return 'google-reviews';
    }

    public function name(): string
    {
        return __('Google Reviews');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>';
    }

    public function category(): string
    {
        return 'content';
    }

    public function description(): string
    {
        return __('Display real Google reviews — either fetched live via Places API or entered manually.');
    }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('What our customers say'),
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
                'name'    => 'mode',
                'type'    => 'select',
                'label'   => __('Data Source'),
                'default' => 'manual',
                'tab'     => 'content',
                'options' => [
                    'manual' => __('Manual (repeater)'),
                    'api'    => __('Google Places API (live)'),
                ],
                'help'    => __('Manual mode works offline with any number of reviews. API mode fetches live reviews (max 5 per request, requires a Places API key).'),
            ],
            [
                'name'           => 'place_id',
                'type'           => 'text',
                'label'          => __('Google Place ID'),
                'default'        => '',
                'tab'            => 'content',
                'help'           => __('Find your Place ID at developers.google.com/maps/documentation/places/web-service/place-id'),
                'help_link'      => 'https://developers.google.com/maps/documentation/places/web-service/place-id',
                'help_link_text' => __('Find Place ID →'),
            ],
            [
                'name'           => 'api_key',
                'type'           => 'text',
                'label'          => __('Google Places API Key'),
                'default'        => '',
                'tab'            => 'content',
                'help'           => __('Create a Places API key in Google Cloud Console. Free tier covers typical usage; billing required.'),
                'help_link'      => 'https://console.cloud.google.com/google/maps-apis/credentials',
                'help_link_text' => __('Get API Key →'),
            ],
            [
                'name'    => 'google_maps_url',
                'type'    => 'text',
                'label'   => __('Google Maps Business URL'),
                'default' => '',
                'tab'     => 'content',
                'help'    => __('Link to your Google Maps business page — shown as "View all reviews" button.'),
            ],
            [
                'name'    => 'overall_rating',
                'type'    => 'text',
                'label'   => __('Overall Rating (manual)'),
                'default' => '5.0',
                'tab'     => 'content',
                'help'    => __('Used in manual mode. For API mode, rating is fetched automatically.'),
            ],
            [
                'name'    => 'review_count',
                'type'    => 'text',
                'label'   => __('Total Review Count (manual)'),
                'default' => '',
                'tab'     => 'content',
            ],
            [
                'name'    => 'layout',
                'type'    => 'select',
                'label'   => __('Layout'),
                'default' => 'grid',
                'tab'     => 'style',
                'options' => [
                    'grid'    => __('Grid'),
                    'carousel'=> __('Carousel'),
                ],
            ],
            [
                'name'    => 'columns',
                'type'    => 'select',
                'label'   => __('Columns'),
                'default' => '3',
                'tab'     => 'style',
                'options' => [
                    '2' => __('2 Columns'),
                    '3' => __('3 Columns'),
                    '4' => __('4 Columns'),
                ],
            ],
            [
                'name'    => 'card_style',
                'type'    => 'select',
                'label'   => __('Card Style'),
                'default' => 'card',
                'tab'     => 'style',
                'options' => [
                    'card'     => __('Card (shadow)'),
                    'bordered' => __('Bordered'),
                    'minimal'  => __('Minimal (no bg)'),
                    'glass'    => __('Glass'),
                ],
            ],
            [
                'name'    => 'star_color',
                'type'    => 'color',
                'label'   => __('Star Color'),
                'default' => '#fbbf24',
                'tab'     => 'style',
            ],
            [
                'name'    => 'accent',
                'type'    => 'color',
                'label'   => __('Accent Color'),
                'default' => '#4285F4',
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_avatar',
                'type'    => 'toggle',
                'label'   => __('Show Reviewer Avatar'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_date',
                'type'    => 'toggle',
                'label'   => __('Show Review Date'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_google_badge',
                'type'    => 'toggle',
                'label'   => __('Show Google Attribution Badge'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'show_summary',
                'type'    => 'toggle',
                'label'   => __('Show Rating Summary (top)'),
                'default' => true,
                'tab'     => 'style',
            ],
            [
                'name'    => 'radius',
                'type'    => 'select',
                'label'   => __('Card Radius'),
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
            [
                'name'   => 'reviews',
                'type'   => 'repeater',
                'label'  => __('Manual Reviews'),
                'tab'    => 'content',
                'fields' => [
                    ['name' => 'author',   'type' => 'text',     'label' => __('Reviewer Name')],
                    ['name' => 'avatar',   'type' => 'media',    'label' => __('Avatar (optional)')],
                    ['name' => 'rating',   'type' => 'select',   'label' => __('Rating'), 'options' => [
                        '5' => '5 ★', '4' => '4 ★', '3' => '3 ★', '2' => '2 ★', '1' => '1 ★',
                    ]],
                    ['name' => 'text',     'type' => 'textarea', 'label' => __('Review Text')],
                    ['name' => 'date',     'type' => 'text',     'label' => __('Date (e.g. "2 weeks ago")')],
                    ['name' => 'link',     'type' => 'text',     'label' => __('Review URL (optional)')],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        $uid = 'gr_' . substr(md5(uniqid('', true)), 0, 8);

        return view('rjbuilder.widgets.builtin.google-reviews', compact('settings', 'uid'))->render();
    }
}
