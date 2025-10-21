<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\TrackUserActivity::class,
        ]);
        
        $middleware->alias([
            'cache.pages' => \App\Http\Middleware\CacheMiddleware::class,
            'optimize' => \App\Http\Middleware\ImageOptimizationMiddleware::class,
            'security.headers' => \App\Http\Middleware\SecurityHeadersMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'no-cache-auth' => \App\Http\Middleware\NoCacheForAuthenticated::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeadersMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
