<?php

namespace App\Exceptions;

use App\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof HttpException){
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];
            return $this->errorResponse($message, $code);
        }
        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            $message = 'No '. $model . ' found with this id';
            return $this->errorResponse($message, Response::HTTP_NOT_FOUND);
        }
        if(env('APP_DEBUG', false)){
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        /* return parent::render($request, $exception); */
    }
}
