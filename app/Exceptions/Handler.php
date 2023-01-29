<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
            // dd("Modelo");
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $name_ruta = $request->getPathInfo();
            $name_ruta = explode("/", $name_ruta);

            if ($name_ruta[1] == "admin") {
                return redirect()->route("admin.index");
            }
        }

        if ($e instanceof HttpException) {
            return redirect()->route("notfound");
        }

        if ($e instanceof \Laravel\Socialite\Two\InvalidStateException) {
            return redirect()->route("login");
        }

        if ($e instanceof NotFoundHttpException) {
            //dd("acceso denegado");
        }

        if ($e instanceof TokenMismatchException) {
            $name_ruta = $request->getPathInfo();
            $name_ruta = explode("/", $name_ruta);

            if ($name_ruta[1] == "admin") {
                return redirect()->route('admin.login');
            }else if($name_ruta[1] == "req"){
                return redirect()->route('login_req_view');
            }else{
                return redirect()->route('login');
            }
        }

        return parent::render($request, $e);
    }

}
