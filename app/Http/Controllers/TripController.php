<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripIndexRequest;
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


}