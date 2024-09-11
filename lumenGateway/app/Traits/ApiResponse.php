<?php

namespace Traits;

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
}

