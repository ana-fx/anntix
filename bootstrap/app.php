<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix('reseller')
                ->name('reseller.')
                ->group(base_path('routes/reseller.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SiteAccessMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'midtrans/notification',
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'reseller' => \App\Http\Middleware\IsReseller::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('admin/*')) {
                return response()->view('errors.404-admin', [], 404);
            }
        });
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() === 403) {
                if ($request->is('admin/*') || $request->is('dashboard')) {
                    return response()->view('errors.403-admin', [], 403);
                }
            }
        });
    })->create();
