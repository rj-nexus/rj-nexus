<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Option;
use App\Models\Notification;
use App\Models\User;
use App\Models\Theme;
use App\Models\Plugin;
use Illuminate\Support\Facades\Log;

class CheckUpdates extends Command
{
    protected $signature = 'rj:check-updates';
    protected $description = 'Avtomatik olaraq Core, Tema və Plagin yeniləmələrini yoxlayır';

    public function handle()
    {
        $this->info('Sistem yeniləmələri yoxlanılır...');

        // 1. Core CMS Yoxlaması
        try {
            $response = Http::timeout(10)->get('https://api.github.com/repos/rj-nexus/rj-nexus/releases/latest');

            if ($response->successful()) {
                $latest = $response->json();
                $latestVersion = ltrim($latest['tag_name'] ?? '', 'v');
                $currentVersion = config('app.version', '1.0.0');
                
                $hasUpdate = version_compare($latestVersion, $currentVersion, '>');

                $updateData = [
                    'has_update' => $hasUpdate,
                    'version' => $latestVersion,
                    'name' => $latest['name'] ?? '',
                    'published_at' => $latest['published_at'] ?? null,
                    'body' => $latest['body'] ?? '',
                    'url' => $latest['html_url'] ?? '',
                ];

                Cache::put('rj_latest_release', $updateData, now()->addDays(1));
                Option::set('last_update_check', now()->toDateTimeString(), 'updates');
                Option::set('latest_release_data', json_encode($updateData), 'updates');

                if ($hasUpdate) {
                    $this->notifyAdmins(
                        __('New System Update Available'),
                        __('RJ Nexus v:version is ready. Click to view details.', ['version' => $latestVersion]),
                        route('admin.updates.index'),
                        __('View Update'),
                        ['type' => 'core', 'version' => $latestVersion]
                    );
                }
                $this->info('Core versiya: ' . $latestVersion);
            }
        } catch (\Throwable $e) {
            $this->error('Core yoxlama xətası: ' . $e->getMessage());
        }

        // 2. Tema və Plagin Yoxlaması
        try {
            $themeManager = app(\App\Services\ThemeManager::class);
            if (method_exists($themeManager, 'checkForUpdates')) {
                $themeManager->checkForUpdates();
                $this->info('Temalar yoxlanıldı.');
            }

            $pluginManager = app(\App\Services\PluginManager::class);
            if (method_exists($pluginManager, 'checkForUpdates')) {
                $pluginManager->checkForUpdates();
                $this->info('Plaginlər yoxlanıldı.');
            }
            
            $this->checkThemeNotifications();
            $this->checkPluginNotifications();
            
        } catch (\Throwable $e) {
            $this->error('Tema/Plagin yoxlama xətası: ' . $e->getMessage());
        }

        $this->info('Bütün yoxlamalar tamamlandı.');
    }

    protected function notifyAdmins($title, $message, $url, $label, $meta = [])
    {
        try {
            $admins = User::whereIn('role', ['admin', 'super-admin'])->get();
            $defaultLocale = app()->getLocale();

            foreach ($admins as $admin) {
                $adminLocale = $admin->locale ?? $defaultLocale;
                app()->setLocale($adminLocale);

                // DUBLİKATLARIN QARŞISINI ALMAQ ÜÇÜN MÖHKƏM YOXLAMA
                $exists = Notification::where('user_id', $admin->id)
                    ->where('action_url', $url)
                    ->get()
                    ->contains(function ($n) use ($meta) {
                        return ($n->meta['version'] ?? '') === ($meta['version'] ?? '') && 
                               ($n->meta['type'] ?? '') === ($meta['type'] ?? '');
                    });

                if (!$exists) {
                    Notification::send($admin, [
                        'type' => 'system',
                        'title' => $title,
                        'message' => $message,
                        'icon' => 'download',
                        'color' => $meta['type'] === 'plugin' ? '#f59e0b' : ($meta['type'] === 'theme' ? '#8b5cf6' : '#ec4899'),
                        'action_url' => $url,
                        'action_label' => $label,
                        'meta' => $meta,
                    ]);
                }
            }
            app()->setLocale($defaultLocale);
        } catch (\Throwable $e) {
            Log::error('Bildiriş xətası: ' . $e->getMessage());
        }
    }

    protected function checkThemeNotifications()
    {
        foreach (Theme::all() as $theme) {
            $meta = $theme->metadata();
            $latest = $meta['latest_version'] ?? null;
            
            if ($latest && version_compare($latest, $theme->version, '>')) {
                $this->notifyAdmins(
                    __('Theme Update Available: :name', ['name' => $theme->name]),
                    __('New version v:version is available for this theme.', ['version' => $latest]),
                    route('admin.themes.index'),
                    __('View Themes'),
                    ['type' => 'theme', 'slug' => $theme->slug, 'version' => $latest]
                );
            }
        }
    }

    protected function checkPluginNotifications()
    {
        foreach (Plugin::all() as $plugin) {
            $meta = $plugin->metadata();
            $latest = $meta['latest_version'] ?? null;
            
            if ($latest && version_compare($latest, $plugin->version, '>')) {
                $this->notifyAdmins(
                    __('Plugin Update Available: :name', ['name' => $plugin->name]),
                    __('New version v:version is available for this plugin.', ['version' => $latest]),
                    route('admin.plugins.index'),
                    __('View Plugins'),
                    ['type' => 'plugin', 'slug' => $plugin->slug, 'version' => $latest]
                );
            }
        }
    }
}