<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * Validation hataları için özel JSON çıktısı
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Doğrulama hatası.',
            'data' => null,
            'meta' => null,
            'errors' => $exception->errors(),
        ], 422);
    }

    /**
     * Diğer hataların yönetimi
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kaynak bulunamadı.',
                'data' => null,
                'meta' => null,
                'errors' => [],
            ], 404);
        }

        return response()->json([
            'status' => 'error',
            'message' => $exception->getMessage() ?: 'Sunucu hatası.',
            'data' => null,
            'meta' => null,
            'errors' => [],
        ], method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
    }
}