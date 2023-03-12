<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UnValidTripStationsException extends Exception
{

    public function __construct(int $source_id, int $destination_id, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf(
            'The trip does not pass through station: %s and station: %s',
            $source_id,
            $destination_id
        );

        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            "error" => true,
            "message" => $this->getMessage()
        ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
