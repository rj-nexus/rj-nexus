<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;

class SpotlightProductListWidget extends BaseWidget
{
    public function id(): string
    {
        return 'spotlight-product-list';
    }

    public function name(): string
    {
        return __('Spotlight Product List');
    }

    public function icon(): string
    {
        return '<svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>';
    }

    public function category(): string
    {
        return 'spotlight';
    }

    public function description(): string
    {
        return __('A grid of product cards with images, titles, prices, and action buttons.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'title',
                'type' => 'text',
                'label' => __('Section Title'),
                'default' => 'Featured Products',
            ],
            [
                'name' => 'subtitle',
                'type' => 'textarea',
                'label' => __('Section Subtitle'),
                'default' => 'Explore our latest collection of premium digital products.',
            ],
            [
                'name' => 'products',
                'type' => 'repeater',
                'label' => __('Products (Max 4)'),
                'max_items' => 4,
                'default' => [
                    [
                        'image' => '',
                        'title' => 'Product Name',
                        'price' => '$49.00',
                        'desc' => 'Short description of the product goes here.',
                        'btn_text' => 'Buy Now',
                        'btn_url' => '#',
                    ],
                    [
                        'image' => '',
                        'title' => 'Premium Theme',
                        'price' => '$79.00',
                        'desc' => 'A beautiful dark theme for your next project.',
                        'btn_text' => 'Buy Now',
                        'btn_url' => '#',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'image',
                        'type' => 'media',
                        'label' => __('Product Image'),
                    ],
                    [
                        'name' => 'title',
                        'type' => 'text',
                        'label' => __('Product Title'),
                        'default' => 'Product Name',
                    ],
                    [
                        'name' => 'price',
                        'type' => 'text',
                        'label' => __('Price'),
                        'default' => '$0.00',
                    ],
                    [
                        'name' => 'desc',
                        'type' => 'textarea',
                        'label' => __('Description'),
                        'default' => 'Product description.',
                    ],
                    [
                        'name' => 'btn_text',
                        'type' => 'text',
                        'label' => __('Button Text'),
                        'default' => 'Add to Cart',
                    ],
                    [
                        'name' => 'btn_url',
                        'type' => 'text',
                        'label' => __('Button URL'),
                        'default' => '#',
                    ],
                ],
            ],
        ];
    }

    public function render(array $settings): string
    {
        return view('theme::widgets.spotlight-product-list', compact('settings'))->render();
    }
}