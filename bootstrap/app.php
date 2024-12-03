<?php

use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\UpdateUserStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Thêm Middleware
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            // 'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
            'check.admin.role' => CheckAdminRole::class,
        ]);
        // $middleware->append([
        //     'update.user.status' => UpdateUserStatus::class,
        // ]);
        // protected function schedule(Schedule $schedule)
        // {
        //     $schedule->call(function () {
        //         app(\App\Services\ChatService::class)->processPendingMessages();
        //     })->everyMinute();
        // }

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
