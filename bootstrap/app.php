<?php

use App\Mail\ExceptionMail;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\CheckIfAdmin::class,
            \App\Http\Middleware\PoolCycle::class,
            \App\Http\Middleware\TeamOfLoggedInUserMiddleware::class,
            //\App\Http\Middleware\DetectAndroid::class,
        ]);

        $middleware->api(append: [
            \App\Http\Middleware\PoolCycleApi::class,
        ]);
        $middleware->alias([
            'detect.android' => \App\Http\Middleware\DetectAndroid::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (\Exception $e) {
            try {
                $title = $e->getMessage() . ' (' . \URL::full() . ')';
                $message = $title . "\n\n" . $e;
                if (\App::environment() === 'production') {
                    \Mail::to('admin@pgbilliard.com')->send(new ExceptionMail($title, nl2br($message)));
                }
            } catch (Exception $e) {
                \Log::error($e->getMessage());
            }
        });
    })->create();
