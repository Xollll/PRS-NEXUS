<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureAdminSession;
use App\Http\Middleware\EnsureMemberSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Render terminates HTTPS at its reverse proxy and forwards the
        // original scheme in X-Forwarded-Proto. Trust the connecting proxy so
        // Laravel generates HTTPS URLs in production while local HTTP remains
        // unchanged.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin.session' => EnsureAdminSession::class,
            'member.session' => EnsureMemberSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
