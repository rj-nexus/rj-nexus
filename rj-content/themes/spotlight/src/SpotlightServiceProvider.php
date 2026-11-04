<?php

namespace Spotlight;

use Illuminate\Support\ServiceProvider;
use Spotlight\Widgets\SpotlightHeroWidget;

class SpotlightServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->registerWidgets();
    }

    protected function registerWidgets(): void
    {
        if (function_exists('rj_add_filter')) {
            rj_add_filter('builder.widgets', function ($existing) {
                $widgets = [
                    new SpotlightHeroWidget(),
                ];
                return array_merge($existing, $widgets);
            });
        }
    }
}
