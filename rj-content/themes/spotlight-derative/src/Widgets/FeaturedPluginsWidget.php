<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;
use App\Services\GitHubRegistry;

class FeaturedPluginsWidget extends BaseWidget
{
    public function id(): string { return 'featured-plugins'; }
    public function name(): string { return __('Featured Plugins'); }
    public function icon(): string { return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>'; }
    public function category(): string { return 'showcase'; }
    public function description(): string { return __('Displays featured plugins from the RJ Nexus registry.'); }
    public function contexts(): array { return ['page']; }

    public function schema(): array
    {
        return [
            ['name' => 'title', 'type' => 'text', 'label' => __('Section Title'), 'default' => __('Featured Plugins'), 'tab' => 'content'],
            ['name' => 'limit', 'type' => 'number', 'label' => __('Limit'), 'default' => 3, 'tab' => 'style']
        ];
    }

    public function render(array $settings): string
    {
        $allPlugins = app(GitHubRegistry::class)->enrichPlugins();
        $featured = array_values(array_filter($allPlugins, fn($p) => $p['featured'] ?? false));
        $plugins = array_slice(empty($featured) ? $allPlugins : $featured, 0, (int)($settings['limit'] ?? 3));
        
        return view('spotlight::widgets.featured-plugins', compact('settings', 'plugins'))->render();
    }
}