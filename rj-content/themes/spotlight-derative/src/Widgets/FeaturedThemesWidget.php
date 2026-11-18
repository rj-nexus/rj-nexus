<?php

namespace Spotlight\Widgets;

use App\Widgets\BaseWidget;
use App\Services\GitHubRegistry;

class FeaturedThemesWidget extends BaseWidget
{
    public function id(): string { return 'featured-themes'; }
    public function name(): string { return __('Featured Themes'); }
    public function icon(): string { return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>'; }
    public function category(): string { return 'showcase'; }
    public function description(): string { return __('Displays featured themes from the RJ Nexus registry.'); }
    public function contexts(): array { return ['page']; }

    public function schema(): array
    {
        return [
            [
                'name'    => 'title',
                'type'    => 'text',
                'label'   => __('Section Title'),
                'default' => __('Featured Themes'),
                'tab'     => 'content',
            ]
        ];
    }

    public function render(array $settings): string
    {
        $registry = app(GitHubRegistry::class);
        $allThemes = $registry->enrichThemes();
        
        $featured = array_values(array_filter($allThemes, fn($t) => $t['featured'] ?? false));
        if (empty($featured)) {
            $themes = array_slice($allThemes, 0, 3);
        } else {
            $themes = array_slice($featured, 0, 3);
        }

        return view('spotlight::widgets.featured-themes', compact('settings', 'themes'))->render();
    }
}