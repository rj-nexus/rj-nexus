<?php

namespace Spotlight\Services;

use App\Models\Post;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpotlightStarterContent
{
    public static function run(): void
    {
        if (Post::where('slug', 'about')->exists() || Post::where('slug', 'contact')->exists()) {
            return; 
        }

        $pages = [
            ['title' => 'Home', 'slug' => 'home', 'template' => 'landing'],
            ['title' => 'About Us', 'slug' => 'about', 'template' => 'full-width'],
            ['title' => 'Contact', 'slug' => 'contact', 'template' => 'contact'],
            ['title' => 'Pricing', 'slug' => 'pricing', 'template' => 'full-width'],
            ['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'template' => 'full-width'],
        ];

        $createdPages = [];

        foreach ($pages as $p) {
            $page = Post::firstOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'type' => 'page',
                    'status' => 'published',
                    'content' => '<p>This is the ' . $p['title'] . ' page. Edit this content in the admin panel.</p>',
                    'published_at' => now(),
                    'user_id' => 1,
                ]
            );
            $createdPages[$p['slug']] = $page;
        }

        $headerMenu = Menu::firstOrCreate(['name' => 'Header Menu']);
        
        $headerItems = [
            ['label' => 'Home', 'url' => '/', 'type' => 'custom'],
            ['label' => 'About', 'url' => '/about', 'type' => 'custom'],
            ['label' => 'Pricing', 'url' => '/pricing', 'type' => 'custom'],
            ['label' => 'Contact', 'url' => '/contact', 'type' => 'custom'],
        ];

        foreach ($headerItems as $index => $item) {
            MenuItem::firstOrCreate(
                ['menu_id' => $headerMenu->id, 'label' => $item['label']],
                ['url' => $item['url'], 'type' => $item['type'], 'order' => $index]
            );
        }

        $footerMenu = Menu::firstOrCreate(['name' => 'Footer Menu']);
        
        $footerItems = [
            ['label' => 'Privacy Policy', 'url' => '/privacy-policy', 'type' => 'custom'],
            ['label' => 'Contact', 'url' => '/contact', 'type' => 'custom'],
        ];

        foreach ($footerItems as $index => $item) {
            MenuItem::firstOrCreate(
                ['menu_id' => $footerMenu->id, 'label' => $item['label']],
                ['url' => $item['url'], 'type' => $item['type'], 'order' => $index]
            );
        }

        $locations = rj_get_option('menu_locations', []);
        $locations['header'] = $headerMenu->id;
        $locations['footer'] = $footerMenu->id;
        rj_set_option('menu_locations', $locations);

        $readingSettings = rj_get_option('reading_settings', []);
        $readingSettings['homepage_type'] = 'page';
        $readingSettings['homepage_page_id'] = $createdPages['home']->id ?? null;
        rj_set_option('reading_settings', $readingSettings);

        $themeMods = rj_theme_mods_all();
        $themeMods['header']['logo_text'] = 'Spotlight';
        $themeMods['footer']['footer_text'] = '© 2026 RJ Nexus. All rights reserved.';
        rj_set_option('theme_mods_spotlight', $themeMods);
    }
}