<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InvalidEmailOrPasswordException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            "error" => true,
            "message" => "Email & Password does not match with our users"
        ],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
