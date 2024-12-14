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
        $middleware->alias([
            'userMiddleware' => \App\Http\Middleware\UserMiddleware::class,
            'adminMiddleware' => \App\Http\Middleware\AdminMiddleware::class,
            'landlordMiddleware' => \App\Http\Middleware\LandLordMiddleware::class,
            'verify.user' => \App\Http\Middleware\VerifyUserMiddleware::class,
            'checkTrial' => \App\Http\Middleware\CheckTrialStatus::class,
            'PDF' => Barryvdh\DomPDF\Facade::class,

            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
