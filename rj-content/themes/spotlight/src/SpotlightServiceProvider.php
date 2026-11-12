<?php

namespace Spotlight;

use Illuminate\Support\ServiceProvider;
use Spotlight\Services\SpotlightStarterContent;
use Spotlight\Widgets\SpotlightHeroWidget;
use Spotlight\Widgets\SpotlightHeaderWidget;
use Spotlight\Widgets\SpotlightLogosWidget;
use Spotlight\Widgets\SpotlightDividerWidget;
use Spotlight\Widgets\SpotlightShowcaseWidget;
use Spotlight\Widgets\SpotlightTabsWidget;
use Spotlight\Widgets\SpotlightFeaturesWidget;
use Spotlight\Widgets\SpotlightStepsWidget;
use Spotlight\Widgets\SpotlightPricingWidget;
use Spotlight\Widgets\SpotlightTestimonialsWidget;
use Spotlight\Widgets\SpotlightFaqWidget;
use Spotlight\Widgets\SpotlightNewsletterWidget;
use Spotlight\Widgets\SpotlightFooterWidget;
use Spotlight\Widgets\SpotlightTeamWidget;
use Spotlight\Widgets\SpotlightActionGridWidget;
use Spotlight\Widgets\SpotlightTrustpilotWidget;
use Spotlight\Widgets\SpotlightFeaturesGridWidget;
use Spotlight\Widgets\SpotlightMapWidget;
use Spotlight\Widgets\SpotlightContactWidget;
use Spotlight\Widgets\SpotlightProductListWidget;

class SpotlightServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->registerWidgets();
        $this->maybeSetupStarterContent();
    }

    protected function registerWidgets(): void
    {
        if (function_exists('rj_add_filter')) {
            rj_add_filter('builder.widgets', function ($existing) {
                $widgets = [
                    new SpotlightHeroWidget(),
                    new SpotlightHeaderWidget(),
                    new SpotlightLogosWidget(),
                    new SpotlightDividerWidget(),
                    new SpotlightShowcaseWidget(),
                    new SpotlightTabsWidget(),
                    new SpotlightFeaturesWidget(),
                    new SpotlightStepsWidget(),
                    new SpotlightPricingWidget(),
                    new SpotlightTestimonialsWidget(),
                    new SpotlightFaqWidget(),
                    new SpotlightNewsletterWidget(),
                    new SpotlightFooterWidget(),
                    new SpotlightTeamWidget(),
                    new SpotlightActionGridWidget(),
                    new SpotlightTrustpilotWidget(),
                    new SpotlightFeaturesGridWidget(),
                    new SpotlightMapWidget(),
                    new SpotlightContactWidget(),
                    new SpotlightProductListWidget(),
                ];
                return array_merge($existing, $widgets);
            });
        }
    }

    protected function maybeSetupStarterContent(): void
    {
        if (!function_exists('rj_get_option') || !function_exists('rj_set_option')) {
            return;
        }

        try {
            $activeTheme = rj_get_option('active_theme', '');

            if ($activeTheme === 'spotlight' && !rj_get_option('spotlight_starter_content_imported')) {
                SpotlightStarterContent::run();
                rj_set_option('spotlight_starter_content_imported', true);
            }
        } catch (\Throwable $e) {
            if (function_exists('logger')) {
                logger()->error('Spotlight Starter Content Error: ' . $e->getMessage());
            }
        }
    }
}