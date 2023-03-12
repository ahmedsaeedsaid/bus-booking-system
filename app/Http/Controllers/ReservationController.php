<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\TripIndexRequest;
use App\Models\Trip;
use App\Services\ReservationService;
use App\Services\TripService;
use App\Http\Resources\TripResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    private ReservationService $reservationService;
    public function __construct()
    {
        $this->reservationService = new ReservationService();
    }

    public function store(Trip $trip, ReservationStoreRequest $request): Response
    {
        $this->reservationService->createOne(
            $trip,
            $request->source_id,
            $request->destination_id,
            $request->seat_id
        );

        return response()->json("seat booked successfully", Response::HTTP_OK);
    }

}