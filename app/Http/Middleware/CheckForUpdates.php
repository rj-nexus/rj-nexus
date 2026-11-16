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
        // TEST REJİMİ: Hər səhifə yüklənməsində (refresh) yoxlayır
        // Vaxt məhdudiyyətini və keş yoxlamasını müvəqqəti söndürdük
        
        // Arxa planda yoxlama əmrini işə salırıq
        dispatch(function () {
            \Illuminate\Support\Facades\Artisan::call('rj:check-updates');
        })->afterResponse();

        return $next($request);
    }
}