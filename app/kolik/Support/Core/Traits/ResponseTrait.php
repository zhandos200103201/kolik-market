<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    final public function response(string $message, mixed $data = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    final public function jsonApiErrorResponse(array $errors, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'errors' => $errors,
        ], $code);
    }

    final public function defaultErrorResponse(string $message, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
