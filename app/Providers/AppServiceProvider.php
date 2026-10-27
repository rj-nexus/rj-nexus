<?php

namespace App\Providers;

use App\Hooks\HookRegistry;
use App\Services\PluginManager;
use App\Services\ThemeManager;
use App\Services\IconService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ThemeManager::class, fn($app) => new ThemeManager());
        $this->app->singleton(PluginManager::class, fn($app) => new PluginManager());
        $this->app->singleton(IconService::class);
        $this->app->singleton(HookRegistry::class);

        require_once app_path('Helpers/plugins.php');

        if (file_exists(app_path('Helpers/icons.php'))) {
            require_once app_path('Helpers/icons.php');
        }
    }

    public function boot(): void
    {
        $themeManager = $this->app->make(ThemeManager::class);
        $themeManager->registerViews();

        if (method_exists($themeManager, 'registerProviders')) {
            $themeManager->registerProviders();
        }

        $this->app->make(PluginManager::class)->boot();

        if (Schema::hasTable('rj_options')) {
            $mailHost = rj_get_option('smtp_host');

            if ($mailHost) {
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.host', $mailHost);
                Config::set('mail.mailers.smtp.port', rj_get_option('smtp_port', 587));
                Config::set('mail.mailers.smtp.username', rj_get_option('smtp_username'));
                Config::set('mail.mailers.smtp.password', rj_get_option('smtp_password'));
                Config::set('mail.mailers.smtp.encryption', rj_get_option('smtp_encryption', 'tls'));

                Config::set('mail.from.address', rj_get_option('smtp_from_address', 'hello@example.com'));
                Config::set('mail.from.name', rj_get_option('smtp_from_name', config('app.name')));
            }
        }
    }
}
