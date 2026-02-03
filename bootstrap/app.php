<?php

use App\Http\Middleware\TrackVisitMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\TokenMismatchException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Define route middleware aliases
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'trackable' => TrackVisitMiddleware::class,
            'check.subscription' => \App\Http\Middleware\CheckSubscription::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // معالجة خطأ 419 (انتهاء الجلسة)
        $exceptions->renderable(function (TokenMismatchException $e, $request) {
            // إذا كان طلب Livewire أو AJAX → رد JSON
            if ($request->expectsJson() || $request->header('X-Livewire')) {
                return response()->json([
                    'message' => 'انتهت صلاحية الجلسة. جاري إعادة التوجيه...',
                    'redirect' => route('login')
                ], 419);
            }

            // للطلبات العادية → اعرض صفحة 419 مخصصة
            return response()->view('frontend.errors.419', [], 419);
        });
    })->create();
