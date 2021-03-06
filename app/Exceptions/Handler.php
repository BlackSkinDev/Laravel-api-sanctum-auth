<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request,Throwable $e)
    {
        if($e instanceof  ModelNotFoundException || $e instanceof NotFoundHttpException){
            return response()->json(['message'=>'Resource not found'],Response::HTTP_NOT_FOUND);
        }

        if($e instanceof  AuthenticationException ){
            return response()->json(['message'=>'Unauthenticated'],Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof UnauthorizedHttpException) {
            return response()->json(['message'=>'Oops! Invalid Auth Credentials'],Response::HTTP_UNAUTHORIZED);
        }


       return response()->json(['message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);


    }


}
