<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): JsonResponse|Response
    {

        if ($request->expectsJson()) {
            $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;

            $response = [
                'message' => $e->getMessage(),
                'status_code' => $status,
            ];

            // In debug mode, include the stack trace
            if (config('app.debug')) {
                $response['exception'] = get_class($e);
                $response['trace'] = $e->getTrace();
            }

            return response()->json($response, $status);
        }

        return parent::render($request, $e);
    }
}
