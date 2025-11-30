<?php

namespace App\Exceptions;

use App\Mail\ExceptionMail;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e): void
    {
        try {
            if (! $this->shouldntReport($e)) {
                $title = $e->getMessage() . ' (' . \URL::full() . ')';
                $message = $title . "\n\n" . $e;
                if (\App::environment() === 'production') {
                    \Mail::to('admin@pgbilliard.com')->send(new ExceptionMail($title, nl2br($message)));
                }
            }
            parent::report($e);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception|Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Exception|Throwable $e): \Symfony\Component\HttpFoundation\Response
    {
        return parent::render($request, $e);
    }
}
