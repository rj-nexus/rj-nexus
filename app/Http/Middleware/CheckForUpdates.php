<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckForUpdates
{
    public function handle(Request $request, Closure $next): Response
    {
        // Yalnız Admin və ya Frontend fərq etməz, hər sorğuda yoxlayırıq
        $lastChecked = Cache::get('rj_update_check_time', 0);
        
        // 900 saniyə = 15 dəqiqə. (İstəsən 3600 = 1 saat edə bilərsən)
        if (time() - $lastChecked > 900) { 
            
            // Vaxtı dərhal yeniləyirik ki, eyni anda gələn sorğular spam etməsin
            Cache::put('rj_update_check_time', time(), now()->addDay());

            // Arxa planda yoxlama əmrini işə salırıq
            dispatch(function () {
                \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
            })->afterResponse();
        }

        return $next($request);
    }
}