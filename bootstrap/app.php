<?php

use App\Http\Middleware\EnsureHasApiReadPermission;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'has_api' => EnsureHasApiReadPermission::class,
        ]);
        $middleware->web(LocaleMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if (!config('app.debug')) {
            // Reportable exceptions
            $exceptions->reportable(function (Throwable $e) {
                Log::error('Unexpected Exception', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
            });

            // Renderable exceptions
            $exceptions->renderable(function (Throwable $e) {
                $statusCode = $e instanceof HttpException ? $e->getStatusCode() : 500;
                if (!in_array($statusCode, [401, 403, 404])) {
                    return response()->view('errors.500', [], 500);
                }
            });
        }
    })->create();
