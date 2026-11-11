<?php

namespace App\Providers;

use App\Hooks\HookRegistry;
use App\Services\PluginManager;
use App\Services\ThemeManager;
use App\Services\IconService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

use App\Observers\ActivityLogObserver;
use App\Models\Post;
use App\Models\Media;
use App\Models\User;
use App\Models\Template;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use App\Models\ActivityLog;

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
        config(['app.base_locale' => config('app.locale', 'en')]);

        $hasOptionsTable = false;
        $hasPluginsTable = false;

        try {
            $hasOptionsTable = Schema::hasTable('rj_options');
            $hasPluginsTable = Schema::hasTable('rj_plugins');
        } catch (\Throwable $e) {
            // Baza hələ qoşulmayıbsa və ya boşdursa xətanı dayandırır
        }

        if ($hasOptionsTable) {
            $dbUrl = rj_get_option('site_url');

            if (is_string($dbUrl)
                && $dbUrl !== ''
                && filter_var($dbUrl, FILTER_VALIDATE_URL)
                && !str_contains($dbUrl, 'localhost')
                && !str_contains($dbUrl, '127.0.0.1')
            ) {
                Config::set('app.url', rtrim($dbUrl, '/'));
            }
        }

        $appUrl = (string) config('app.url', '');

        if ($appUrl !== ''
            && !str_contains($appUrl, 'localhost')
            && !str_contains($appUrl, '127.0.0.1')
            && filter_var($appUrl, FILTER_VALIDATE_URL)
        ) {
            URL::forceRootUrl($appUrl);

            if (str_starts_with($appUrl, 'https://')) {
                URL::forceScheme('https');
            }
        }

        if (!file_exists(storage_path('installed.lock'))) {
            return;
        }

        $themeManager = $this->app->make(ThemeManager::class);
        $themeManager->registerViews();

        if (method_exists($themeManager, 'registerProviders')) {
            $themeManager->registerProviders();
        }

        if ($hasPluginsTable) {
            $this->app->make(PluginManager::class)->boot();
        }

        Post::observe(ActivityLogObserver::class);
        Media::observe(ActivityLogObserver::class);
        User::observe(ActivityLogObserver::class);
        Template::observe(ActivityLogObserver::class);
        Category::observe(ActivityLogObserver::class);
        Tag::observe(ActivityLogObserver::class);
        Menu::observe(ActivityLogObserver::class);
        Role::observe(ActivityLogObserver::class);

        Event::listen(Login::class, function ($event) {
            ActivityLog::record([
                'log_name' => 'auth',
                'description' => __('User logged in: :name', ['name' => $event->user->name]),
                'subject_type' => get_class($event->user),
                'subject_id' => $event->user->id,
                'event' => 'login',
            ]);
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                ActivityLog::record([
                    'log_name' => 'auth',
                    'description' => __('User logged out: :name', ['name' => $event->user->name]),
                    'subject_type' => get_class($event->user),
                    'subject_id' => $event->user->id,
                    'event' => 'logout',
                ]);
            }
        });

        Event::listen(Failed::class, function ($event) {
            ActivityLog::record([
                'log_name' => 'auth',
                'description' => __('Failed login attempt for: :email', ['email' => $event->credentials['email'] ?? 'Unknown']),
                'event' => 'login_failed',
            ]);
        });

        if ($hasOptionsTable) {
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

            $forceHttps = rj_get_option('force_https') === '1';
            $isHttps = str_starts_with((string) config('app.url', ''), 'https://');

            if ($forceHttps || $isHttps) {
                Config::set('session.secure', true);
            }
        }
    }
}
