<?php

use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, $request) {
            $response = [
              'error' => '',
              'code' => 500,
            ];
            if ($e instanceof ClientException) {
                $message = json_decode($e->getResponse()->getBody()->getContents());
                return response()->json($message)->header('Content-Type', 'application/json');
            }
            if ($e instanceof ModelNotFoundException) {
                $model = strtolower(class_basename($e->getModel()));
                $response['code'] = Response::HTTP_NOT_FOUND;
                $response['error'] = "Does not exist any instance of {$model} with the given id";
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }
            if ($e instanceof AuthorizationException) {
                $response['code'] = Response::HTTP_FORBIDDEN;
                $response['error'] = $e->getMessage();
                return response()->json($response, Response::HTTP_FORBIDDEN);
            }

            if ($e instanceof AuthenticationException) {
                $response['code'] = Response::HTTP_UNAUTHORIZED;
                $response['error'] = $e->getMessage();
                return response()->json($response, Response::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof HttpException) {
                $code = $e->getStatusCode();
                $message = Response::$statusTexts[$code];
                return response()->json($message)->header('Content-Type', 'application/json');
            }
            return response()->json(['error'=>'Internal Server Error','code'=> Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
