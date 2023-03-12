<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\TripIndexRequest;
use App\Http\Requests\TripStoreRequest;
use App\Models\Trip;
use App\Services\TripService;
use App\Http\Resources\TripResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TripController extends Controller
{
    private TripService $tripService;
    public function __construct()
    {
        $this->tripService = new TripService();
    }

    public function index(TripIndexRequest $request): JsonResponse
    {
        $trips = $this->tripService->getMany($request->source_id, $request->destination_id);

        return response()->json(TripResource::collection($trips), Response::HTTP_OK);
    }

    public function store(TripStoreRequest $request): JsonResponse
    {
        $trip_data = $request->validated();

        $trip = $this->tripService->createOne($trip_data);

        return response()->json(TripResource::collection($trip), Response::HTTP_CREATED);
    }

}