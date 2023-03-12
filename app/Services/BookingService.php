<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Trip;

class BookingService
{
    private SeatService $seatService;
    public function __construct()
    {
        $this->seatService = new SeatService();
    }

    public function book(Trip $trip, int $source_id, int $destination_id, int $seat_id): void
    {
        $this->seatService->book(
            $trip,
            $source_id,
            $destination_id,
            $seat_id
        );

        Booking::create([
            'trip_id' => $trip->id,
            'source_station_id' => $source_id,
            'destination_station_id' => $destination_id,
            'seat_id' => $seat_id
        ]);
    }

}