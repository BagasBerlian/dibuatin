<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    });

// Harus dikonfigurasi SEBELUM ->create() agar Laravel boot dengan path yang benar
if (isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
    $app->useBootstrapPath('/tmp/bootstrap');
}

return $app->create();
