<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestRoutesCommand extends Command
{
    protected $signature = 'rj:test-routes';
    protected $description = 'Bütün GET route-larını yoxlayır və xəta verənləri göstərir';

    public function handle()
    {
        $routes = Route::getRoutes();
        $errorCount = 0;
        $successCount = 0;

        $this->info("Yoxlama başlayır... (Bu bir neçə saniyə çəkə bilər)");
        $this->newLine();

        // Admin kimi daxil oluruq ki, admin səhifələri də yoxlanılsın (User ID: 1)
        Auth::loginUsingId(1);

        foreach ($routes as $route) {
            // Yalnız GET metodlu route-ları yoxlayırıq
            if (!in_array('GET', $route->methods())) {
                continue;
            }

            $uri = $route->uri();

            // Parametrli route-ları (məsələn: {post}, {id}) keçirik, çünki onlar üçün ID lazımdır
            if (str_contains($uri, '{')) {
                continue;
            }

            try {
                // Sorğunu simulyasiya edirik
                $request = Request::create('/' . ltrim($uri, '/'), 'GET');
                $response = app()->handle($request);
                $status = $response->getStatusCode();

                // Əgər 500 və ya yuxarı xəta varsa
                if ($status >= 500) {
                    $this->error("XƏTA [{$status}] - /{$uri}");
                    $errorCount++;
                } else {
                    // Uğurlu səhifələr (200, 302, 404)
                    $successCount++;
                }
            } catch (\Throwable $e) {
                $this->error("XƏTA (Exception) - /{$uri}");
                $this->line("Səbəb: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->newLine();
        $this->info("Yoxlama bitdi!");
        $this->line("Uğurlu səhifələr: " . $successCount);

        if ($errorCount > 0) {
            $this->error("Xətalı səhifələr: " . $errorCount);
        } else {
            $this->info("Bütün səhifələr mükəmməl işləyir! Heç bir 500 xətası yoxdur.");
        }
    }
}
