<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // TokenMismatchException 例外発生時
            if($e instanceof \Illuminate\Session\TokenMismatchException) {
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "]");
                // 強制的にログアウト
                Auth::logout();
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // TokenMismatchException 例外発生時
        if($exception instanceof \Illuminate\Session\TokenMismatchException) {
            // ログアウトリクエスト時は、強制的にログアウト
            if($request->is('logout')) {
                Log::debug("[" . __FILE__ . " " . __FUNCTION__ . ":" . __LINE__ . "]");
                Auth::logout();
            }
        }

        return parent::render($request, $exception);
    }
}
