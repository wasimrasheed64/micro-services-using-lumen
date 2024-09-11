<?php

namespace  App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successDataResponse($data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['data' => $data], $statusCode);
    }

    /**
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successMessageResponse($message, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['message' => $message], $statusCode);
    }

    /**
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function errorResponse($message, int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $statusCode], $statusCode);
    }

    /**
     * Build valid response
     * @param array|string $data
     * @param int $code
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function validResponse(array|string $data, int $code = Response::HTTP_OK): \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    public function errorMessage($message, $code)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }


}



