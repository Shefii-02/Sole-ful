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
        //
        $middleware->alias([
            'check.account.admin' => \App\Http\Middleware\CheckAccountAdmin::class,
            'check.account.user' => \App\Http\Middleware\CheckAccountUser::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'confirm',
        ]);
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        

    })->create();
