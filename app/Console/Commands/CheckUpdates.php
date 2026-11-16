<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckForUpdates
{
    public function handle(Request $request, Closure $next): Response
    {
        // Yalnız admin panelində və ya frontend-də işləməsini istəyiriksə, şərt əlavə edə bilərik.
        // Amma ən sadə halda hər sorğuda yoxlayırıq.
        
        // Son yoxlama vaxtını keşdən oxuyuruq (əgər yoxdursa, 0 qəbul edirik)
        $lastChecked = Cache::get('rj_update_check_time', 0);
        
        // Əgər son yoxlamadan 12 saat (43200 saniyə) keçibsə...
        if (time() - $lastChecked > 43200) { 
            // Dərhal yoxlama vaxtını yeniləyirik ki, eyni anda bir neçə sorğu gəlsə, 
            // hamısı GitHub-a sorğu göndərməsin.
            Cache::put('rj_update_check_time', time(), now()->addDay());

            // Arxa planda (səhifəni gözlətmədən) yoxlama əmrini işə salırıq.
            // Bu, istifadəçinin səhifə yükləmə sürətinə təsir etməyəcək.
            dispatch(function () {
                \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
            })->afterResponse();
        }

        return $next($request);
    }
}