<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class AnimatedHeroWidget extends BaseWidget
{
    public function id(): string
    {
        return 'animated-hero';
    }

    public function name(): string
    {
        return __('Animated Scroll Hero');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>';
    }

    public function category(): string
    {
        return 'layout';
    }

    public function description(): string
    {
        return __('A premium, sticky scroll-driven hero section with up to 5 images and a final CTA slide.');
    }

    public function schema(): array
    {
        return [
            ['name' => 'image_1', 'type' => 'media', 'label' => __('Image 1 (Required)'), 'default' => '', 'tab' => 'content'],
            ['name' => 'image_2', 'type' => 'media', 'label' => __('Image 2'), 'default' => '', 'tab' => 'content'],
            ['name' => 'image_3', 'type' => 'media', 'label' => __('Image 3'), 'default' => '', 'tab' => 'content'],
            ['name' => 'image_4', 'type' => 'media', 'label' => __('Image 4'), 'default' => '', 'tab' => 'content'],
            ['name' => 'image_5', 'type' => 'media', 'label' => __('Image 5'), 'default' => '', 'tab' => 'content'],

            ['name' => 'final_bg_image', 'type' => 'media', 'label' => __('Final Slide Background (Optional)'), 'default' => '', 'tab' => 'content', 'help' => __('If left empty, the last image will be used with a blur effect.')],
            ['name' => 'final_title', 'type' => 'text', 'label' => __('Final Slide Title'), 'default' => __('Discover Our Latest Collection'), 'tab' => 'content'],
            ['name' => 'final_subtitle', 'type' => 'text', 'label' => __('Final Slide Subtitle'), 'default' => __('Elevate your style with our premium selection.'), 'tab' => 'content'],
            ['name' => 'final_btn_text', 'type' => 'text', 'label' => __('Final Slide Button Text'), 'default' => __('Explore Now'), 'tab' => 'content'],
            ['name' => 'final_btn_url', 'type' => 'text', 'label' => __('Final Slide Button URL'), 'default' => '/shop', 'tab' => 'content'],
        ];
    }

    public function render(array $settings): string
    {
        $images = [];
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($settings['image_' . $i])) {
                $images[] = $settings['image_' . $i];
            }
        }

        if (empty($images)) {
            return '<div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">' . __('Please select at least Image 1 to display the animated hero.') . '</div>';
        }

        $uid = 'hero_' . substr(md5(uniqid()), 0, 6);

        return view('rjbuilder.widgets.builtin.animated-hero', compact('settings', 'images', 'uid'))->render();
    }
}
