<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

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

        $middleware->trustHosts(at: function () {
            $hosts = [
                '^(.+\.)?localhost$',
                '^127\.0\.0\.1$',
            ];

            $url = (string) config('app.url', '');

            if ($url !== ''
                && !str_contains($url, 'localhost')
                && !str_contains($url, '127.0.0.1')
            ) {
                $host = parse_url($url, PHP_URL_HOST);

                if ($host) {
                    $hosts[] = '^(.+\.)?' . preg_quote($host, '/') . '$';
                }
            }

            return $hosts;
        });

        $middleware->web(prepend: [
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\ForceHttps::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\CheckMaintenanceMode::class,
            \App\Http\Middleware\InjectRtlDirection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->respond(function (Response $response) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('X-XSS-Protection', '0');
            $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
            return $response;
        });

        $exceptions->render(function (\Throwable $e, $request) {

            if ($e instanceof AuthenticationException) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                }
                return redirect()->guest(route('login'));
            }

            if (config('app.debug') && !$request->expectsJson()) {
                $isHttpException = $e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
                $statusCode = $isHttpException ? $e->getStatusCode() : 500;

                if (!$isHttpException || $statusCode === 500) {
                    return response()->view('errors.rj-debug', [
                        'exception' => $e,
                        'statusCode' => $statusCode,
                    ], $statusCode);
                }
            }
        });
    })->create();
