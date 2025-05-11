<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
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
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('analytics:fetch-visitors')->dailyAt('01:00');
        $schedule->command('analytics:fetch-top-devices')->dailyAt('01:00');
        $schedule->command('analytics:fetch-top-referrers')->dailyAt('01:00');
        $schedule->command('analytics:fetch-top-landing-pages')->dailyAt('01:00');
        // $schedule->command('api:delivery-refresh-api-token')->everyMinute();
        // $schedule->command('api:delivery-partner-order-push')->everyMinute();
        // $schedule->command('api:delivery-order-track')->everyMinute();
        
        $schedule->command('queue:work --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Throwable $exception) {
            // if (!env('APP_DEBUG')) {
                $content['message'] = $exception->getMessage();
                $content['file'] = $exception->getFile();
                $content['line'] = $exception->getLine();
                $content['trace'] = $exception->getTrace();

                $content['url'] = request()->url();
                $content['body'] = request()->all();
                $content['ip'] = request()->ip();
                \App\Emails::sendError($content);
            // }
        });
    })->create();
