<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Option;
use App\Models\Plugin;
use App\Models\Theme;
use App\Models\User;
use App\Services\GitHubService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckUpdates extends Command
{
    protected $signature = 'rj:check-updates';
    protected $description = 'Check for core, theme and plugin updates';

    public function handle()
    {
        $this->info('Checking system updates...');

        try {
            $repo = rj_get_option('update_repo', 'rj-nexus/rj-nexus');
            $parts = explode('/', $repo);

            if (count($parts) !== 2) {
                throw new \RuntimeException('Invalid update_repo format: ' . $repo);
            }

            $github = app(GitHubService::class);
            $releases = $github->getReleases($parts[0], $parts[1]);
            $release = $this->pickLatestRelease($releases);

            if (!$release) {
                $this->warn('No stable release found.');
            } else {
                $latestVersion = ltrim($release['tag_name'] ?? '', 'v');
                $currentVersion = ltrim((string) config('app.version', '1.0.0'), 'v');
                $hasUpdate = version_compare($latestVersion, $currentVersion, '>');

                $releaseData = [
                    'version' => $latestVersion,
                    'name' => $release['name'] ?? $release['tag_name'],
                    'body' => $release['body'] ?? '',
                    'url' => $release['html_url'] ?? '',
                    'download_url' => $this->pickDownloadUrl($release),
                    'published_at' => $release['published_at'] ?? null,
                    'prerelease' => false,
                    'has_update' => $hasUpdate,
                ];

                Option::set('last_release', json_encode($releaseData), 'updates');
                Option::set('last_checked', now()->toDateTimeString(), 'updates');

                if ($hasUpdate) {
                    $this->notifyAdmins(
                        __('New System Update Available'),
                        __('RJ Nexus v:version is ready. Click to view details.', ['version' => $latestVersion]),
                        route('admin.updates.index'),
                        __('View Update'),
                        ['type' => 'core', 'version' => $latestVersion]
                    );
                }

                $this->info('Core: v' . $latestVersion . ($hasUpdate ? ' (update available)' : ' (up to date)'));
            }
        } catch (\Throwable $e) {
            $this->error('Core check failed: ' . $e->getMessage());
            Log::warning('rj:check-updates core failure: ' . $e->getMessage());
        }

        try {
            $themeManager = app(\App\Services\ThemeManager::class);
            if (method_exists($themeManager, 'checkForUpdates')) {
                $themeManager->checkForUpdates();
                $this->info('Themes checked.');
            }

            $pluginManager = app(\App\Services\PluginManager::class);
            if (method_exists($pluginManager, 'checkForUpdates')) {
                $pluginManager->checkForUpdates();
                $this->info('Plugins checked.');
            }

            $this->checkThemeNotifications();
            $this->checkPluginNotifications();
        } catch (\Throwable $e) {
            $this->error('Theme/plugin check failed: ' . $e->getMessage());
            Log::warning('rj:check-updates theme/plugin failure: ' . $e->getMessage());
        }

        $this->info('All checks complete.');
    }

    protected function pickLatestRelease(array $releases): ?array
    {
        $best = null;

        foreach ($releases as $release) {
            if (!is_array($release) || !empty($release['draft']) || empty($release['tag_name'])) {
                continue;
            }

            if (!empty($release['prerelease'])) {
                continue;
            }

            if ($best === null || version_compare(ltrim($release['tag_name'], 'v'), ltrim($best['tag_name'], 'v'), '>')) {
                $best = $release;
            }
        }

        return $best;
    }

    protected function pickDownloadUrl(array $release): ?string
    {
        $assets = $release['assets'] ?? [];

        if (is_array($assets)) {
            foreach ($assets as $asset) {
                if (!is_array($asset)) continue;
                $url = (string) ($asset['browser_download_url'] ?? '');
                $name = (string) ($asset['name'] ?? '');
                if ($url !== '' && str_ends_with(strtolower($name), '.zip')) {
                    return $url;
                }
            }
        }

        return $release['zipball_url'] ?? null;
    }

    protected function notifyAdmins($title, $message, $url, $label, $meta = [])
    {
        try {
            $admins = User::whereIn('role', ['admin', 'super-admin'])->get();
            $defaultLocale = app()->getLocale();

            foreach ($admins as $admin) {
                $adminLocale = $admin->locale ?? $defaultLocale;
                app()->setLocale($adminLocale);

                $exists = Notification::where('user_id', $admin->id)
                    ->where('action_url', $url)
                    ->get()
                    ->contains(function ($n) use ($meta) {
                        return ($n->meta['version'] ?? '') === ($meta['version'] ?? '')
                            && ($n->meta['type'] ?? '') === ($meta['type'] ?? '');
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
            Log::error('Notification failed: ' . $e->getMessage());
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