<?php

namespace App\Widgets;

class WidgetDemoData
{
    public static function get(string $widgetId): array
    {
        $placeholder = 'https://raw.githubusercontent.com/mr-ruhid/rare-logos-vault/main/logo/social-media/piokio/piokio_logo.svg';

        $data = [
            'portfolio' => [
                'items' => [
                    ['image' => $placeholder, 'title' => 'Brand Identity', 'category' => 'Branding', 'link' => '#'],
                    ['image' => $placeholder, 'title' => 'Mobile App', 'category' => 'Web', 'link' => '#'],
                    ['image' => $placeholder, 'title' => 'Landing Page', 'category' => 'Print', 'link' => '#'],
                ]
            ],
            'gallery-advanced' => [
                'items' => [
                    ['image' => $placeholder, 'title' => 'Mountain View', 'category' => 'Nature'],
                    ['image' => $placeholder, 'title' => 'City Lights', 'category' => 'Urban'],
                    ['image' => $placeholder, 'title' => 'Ocean Breeze', 'category' => 'Nature'],
                ]
            ],
            'price-list' => [
                'items' => [
                    ['title' => 'Grilled Salmon', 'desc' => 'With lemon butter sauce', 'price' => '$24.00', 'icon' => 'ph:fish-duotone', 'image' => $placeholder],
                    ['title' => 'Caesar Salad', 'desc' => 'Romaine, parmesan, croutons', 'price' => '$12.00', 'icon' => 'ph:leaf-duotone', 'image' => $placeholder],
                    ['title' => 'Beef Steak', 'desc' => '8oz prime cut with veggies', 'price' => '$32.00', 'icon' => 'ph:fork-knife-duotone', 'image' => $placeholder],
                ]
            ],
            'price-table' => [
                'plans' => [
                    ['name' => 'Basic', 'price' => '$19', 'period' => '/month', 'features' => "10 GB Storage\n1 Domain\nBasic Support", 'cta_label' => 'Get Started', 'featured' => '0'],
                    ['name' => 'Pro', 'price' => '$49', 'period' => '/month', 'features' => "100 GB Storage\n10 Domains\nPriority Support", 'cta_label' => 'Go Pro', 'featured' => '1'],
                    ['name' => 'Business', 'price' => '$99', 'period' => '/month', 'features' => "Unlimited Storage\nUnlimited Domains\n24/7 Support", 'cta_label' => 'Contact Us', 'featured' => '0'],
                ]
            ],
            'logo-grid' => [
                'logos' => [
                    ['image' => $placeholder, 'name' => 'Partner 1', 'url' => '#'],
                    ['image' => $placeholder, 'name' => 'Partner 2', 'url' => '#'],
                    ['image' => $placeholder, 'name' => 'Partner 3', 'url' => '#'],
                    ['image' => $placeholder, 'name' => 'Partner 4', 'url' => '#'],
                ]
            ],
            'wheel-of-fortune' => [
                'segments' => [
                    ['label' => '10% OFF', 'color' => '#ef4444', 'weight' => '1', 'description' => '10% discount code'],
                    ['label' => 'FREE SHIP', 'color' => '#f59e0b', 'weight' => '1', 'description' => 'Free shipping'],
                    ['label' => 'TRY AGAIN', 'color' => '#10b981', 'weight' => '1', 'description' => 'Better luck next time'],
                    ['label' => '20% OFF', 'color' => '#3b82f6', 'weight' => '1', 'description' => '20% discount code'],
                    ['label' => 'GIFT', 'color' => '#8b5cf6', 'weight' => '1', 'description' => 'Free gift'],
                    ['label' => '50% OFF', 'color' => '#ec4899', 'weight' => '1', 'description' => 'Mega discount!'],
                ]
            ],
            'step-flow' => [
                'steps' => [
                    ['title' => 'Research', 'desc' => 'We analyze your needs and target audience.', 'icon' => 'ph:magnifying-glass-duotone', 'image' => $placeholder],
                    ['title' => 'Design', 'desc' => 'Crafting beautiful and functional UI/UX.', 'icon' => 'ph:pen-nib-duotone', 'image' => $placeholder],
                    ['title' => 'Launch', 'desc' => 'Deploying your project to the world.', 'icon' => 'ph:rocket-launch-duotone', 'image' => $placeholder],
                ]
            ],
            'contact-info' => [
                'cards' => [
                    ['type' => 'address', 'title' => 'Visit Us', 'value' => '123 Main Street, Baku', 'desc' => 'Mon-Fri from 8am to 5pm', 'link' => ''],
                    ['type' => 'phone', 'title' => 'Call Us', 'value' => '+994 50 123 45 67', 'desc' => 'We are here to help', 'link' => ''],
                    ['type' => 'email', 'title' => 'Email Us', 'value' => 'hello@domain.com', 'desc' => 'We reply within 24h', 'link' => ''],
                ]
            ],
            'business-hours' => [
                'schedule' => [
                    ['day' => 'mon', 'open' => '09:00', 'close' => '18:00', 'closed' => '0', 'note' => ''],
                    ['day' => 'tue', 'open' => '09:00', 'close' => '18:00', 'closed' => '0', 'note' => ''],
                    ['day' => 'wed', 'open' => '09:00', 'close' => '18:00', 'closed' => '0', 'note' => ''],
                    ['day' => 'thu', 'open' => '09:00', 'close' => '18:00', 'closed' => '0', 'note' => ''],
                    ['day' => 'fri', 'open' => '09:00', 'close' => '18:00', 'closed' => '0', 'note' => ''],
                    ['day' => 'sat', 'open' => '10:00', 'close' => '14:00', 'closed' => '0', 'note' => ''],
                    ['day' => 'sun', 'open' => '', 'close' => '', 'closed' => '1', 'note' => ''],
                ]
            ],
            'google-reviews' => [
                'reviews' => [
                    ['author' => 'John Doe', 'avatar' => $placeholder, 'rating' => '5', 'text' => 'Absolutely amazing service! Highly recommended.', 'date' => '2 weeks ago', 'link' => ''],
                    ['author' => 'Jane Smith', 'avatar' => $placeholder, 'rating' => '5', 'text' => 'The team went above and beyond. 10/10 experience.', 'date' => '1 month ago', 'link' => ''],
                    ['author' => 'Alex Johnson', 'avatar' => $placeholder, 'rating' => '4', 'text' => 'Great quality, but shipping took a bit longer than expected.', 'date' => '2 months ago', 'link' => ''],
                ]
            ],
            'multi-chat' => [
                'channels' => [
                    ['platform' => 'whatsapp', 'value' => '+994501234567', 'label' => 'WhatsApp', 'icon' => '', 'color' => ''],
                    ['platform' => 'telegram', 'value' => 'username', 'label' => 'Telegram', 'icon' => '', 'color' => ''],
                    ['platform' => 'email', 'value' => 'hello@domain.com', 'label' => 'Email', 'icon' => '', 'color' => ''],
                ]
            ],
            'hotspot' => [
                'image' => $placeholder,
                'hotspots' => [
                    ['x' => '30', 'y' => '40', 'title' => 'Modern Sofa', 'desc' => 'Comfortable 3-seater sofa in premium fabric.', 'image' => $placeholder, 'link' => '#'],
                    ['x' => '70', 'y' => '60', 'title' => 'Floor Lamp', 'desc' => 'Minimalist design with warm lighting.', 'image' => $placeholder, 'link' => '#'],
                ]
            ],
        ];

        return $data[$widgetId] ?? [];
    }
}
