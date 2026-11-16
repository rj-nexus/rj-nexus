<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Option;
use App\Models\Notification; // Bildiriş modeli

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

                // ƏGƏR YENİ VERSİYA VARSA, BİLDİRİŞ YARADIRIQ
                if ($hasUpdate) {
                    $this->createNotification($latestVersion);
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
        } catch (\Throwable $e) {
            $this->error('Tema/Plagin yoxlama xətası: ' . $e->getMessage());
        }

        $this->info('Bütün yoxlamalar tamamlandı.');
    }

    protected function createNotification($version)
    {
        try {
            // Eyni versiya üçün əvvəl bildiriş yaradılıbsa, təkrar yaratmırıq
            $exists = Notification::where('title', 'like', "%{$version}%")->exists();
            
            if (!$exists) {
                Notification::create([
                    'title' => __('New System Update Available'),
                    'message' => __('RJ Nexus v:version is ready. Click to view details.', ['version' => $version]),
                    'action_url' => route('admin.updates.index'),
                    'is_read' => false,
                    'color' => '#ec4899', // Çəhrayı rəng (yeniləmə üçün)
                ]);
                
                $this->info('Bildiriş yaradıldı: Yeni versiya v' . $version);
            }
        } catch (\Throwable $e) {
            // Əgər Notification modelinin sütun adları fərqlidirsə, xəta verməsin
            $this->error('Bildiriş yaradılarkən xəta: ' . $e->getMessage());
        }
    }
}