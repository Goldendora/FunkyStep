<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Importamos los middlewares personalizados
use App\Http\Middleware\VerificarBaneo;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * 🔐 Alias de middlewares personalizados
         * Aquí registramos los nombres que luego usamos en las rutas.
         * Ejemplo: Route::middleware(['auth', 'baneo', 'admin'])
         */
        $middleware->alias([
            'baneo' => VerificarBaneo::class,
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
