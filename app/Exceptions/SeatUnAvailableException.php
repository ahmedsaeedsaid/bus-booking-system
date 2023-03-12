<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SeatUnAvailableException extends Exception
{
    public function __construct(int $trip_id, int $seat_id, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('seat: %s not available for trip: %s', $seat_id, $trip_id);

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
