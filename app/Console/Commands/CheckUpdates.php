<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Option;

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
                
                $updateData = [
                    'has_update' => version_compare($latestVersion, $currentVersion, '>'),
                    'version' => $latestVersion,
                    'name' => $latest['name'] ?? '',
                    'published_at' => $latest['published_at'] ?? null,
                    'body' => $latest['body'] ?? '',
                    'url' => $latest['html_url'] ?? '',
                ];

                Cache::put('rj_latest_release', $updateData, now()->addDays(1));
                Option::set('last_update_check', now()->toDateTimeString(), 'updates');
                Option::set('latest_release_data', json_encode($updateData), 'updates');

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
        } catch (\Throwable $e) {
            $this->error('Tema/Plagin yoxlama xətası: ' . $e->getMessage());
        }

        $this->info('Bütün yoxlamalar tamamlandı.');
    }
}