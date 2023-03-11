<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripIndexRequest;
use App\Http\Requests\TripStoreRequest;
use App\Services\TripService;
use JetBrains\PhpStorm\NoReturn;

class TripController extends Controller
{
    private TripService $tripService;
    public function __construct()
    {
        $this->tripService = new TripService();
    }

    public function store(TripStoreRequest $request): void
    {
        $trip_data = $request->validated();
        $this->tripService->createOne($trip_data);
    }

    public function index(TripIndexRequest $request)
    {
        $trips = $this->tripService->getMany($request->source_id, $request->destination_id);

        return $trips;
    }


}