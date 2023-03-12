<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookintStoreRequest;
use App\Http\Requests\TripIndexRequest;
use App\Models\Trip;
use App\Services\BookingService;
use App\Services\TripService;
use App\Http\Resources\TripResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    private BookingService $bookingService;
    public function __construct()
    {
        $this->bookingService = new BookingService();
    }

    public function store(Trip $trip, BookintStoreRequest $request): Response
    {
        $this->bookingService->book(
            $trip,
            $request->source_id,
            $request->destination_id,
            $request->seat_id
        );

        return response()->json("seat booked successfully", Response::HTTP_OK);
    }

}