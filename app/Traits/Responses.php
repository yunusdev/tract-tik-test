<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait Responses
 * @package App\Traits
 */
trait Responses
{

    /**
     * @param string $message
     * @param int $code
     * @param object|array|null $data
     * @return JsonResponse
     */
    protected function returnSuccess(string $message, int $code = Response::HTTP_OK, object|array $data = null) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param string|null $message
     * @param int|string $code
     * @param array|null $data
     * @return JsonResponse
     */
    protected function returnError(
        string $message = null,
        int|string $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $data = null
    ): JsonResponse {
        if (!is_numeric($code) || $code == "0") $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        return response()->json([
            'success' => false,
            'message' => $message ?? 'An error occurred',
            'data' => $data
        ], $code);
    }
}
