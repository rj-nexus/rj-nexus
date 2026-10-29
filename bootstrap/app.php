<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            \Illuminate\Support\Facades\Route::middleware('web')
                ->group(base_path('routes/auth.php'));

            \Illuminate\Support\Facades\Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            \Illuminate\Support\Facades\Route::middleware('web')
                ->group(base_path('routes/frontend.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\CheckMaintenanceMode::class,
            \App\Http\Middleware\InjectRtlDirection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, $request) {
            if (config('app.debug') && !$request->expectsJson()) {
                $isHttpException = $e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
                $statusCode = $isHttpException ? $e->getStatusCode() : 500;

                // Yalnız və yalnız 500 xətası və ya HTTP olmayan daxili xətalar üçün RJ Debug ekranı
                if (!$isHttpException || $statusCode === 500) {
                    return response()->view('errors.rj-debug', [
                        'exception' => $e,
                        'statusCode' => $statusCode,
                    ], $statusCode);
                }
            }
        });
    })->create();
