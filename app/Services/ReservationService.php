<?php

namespace App\Services;

use App\Exceptions\SeatUnAvailableException;
use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    private SeatService $seatService;
    public function __construct()
    {
        $this->seatService = new SeatService();
    }

    /**
     * @param Trip $trip
     * @param int $source_id
     * @param int $destination_id
     * @param int $seat_id
     * @return void
     *
     * create reservation.
     */

    public function createOne(Trip $trip, int $source_id, int $destination_id, int $seat_id): void
    {
        DB::transaction(function() use ($trip, $source_id, $destination_id, $seat_id)
        {
            $this->seatService->reserve(
                $trip,
                $source_id,
                $destination_id,
                $seat_id
            );

            Reservation::create([
                'trip_id' => $trip->id,
                'user_id' => auth()->id(),
                'source_station_id' => $source_id,
                'destination_station_id' => $destination_id,
                'seat_id' => $seat_id
            ]);
        });
        
    }

}