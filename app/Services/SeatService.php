<?php

namespace App\Services;

use App\Exceptions\SeatUnAvailableException;
use App\Models\Trip;
use App\Models\TripSeat;

class SeatService
{

    public function getAvailable(Trip $trip, int $source_id, int $destination_id): array
    {
        $available_seats = [];
        $path = $this->getPathFromSourceToDestination($trip, $source_id, $destination_id);

        foreach ($trip->tripSeats as $trip_seat)
        {
            if(empty(array_intersect($trip_seat->station_ids, $path)))
            {
                $available_seats[] = $trip_seat->seat;
            }
        }

        return $available_seats;
    }

    /**
     * @throws SeatUnAvailableException
     */
    public function book(Trip $trip, int $source_id, int $destination_id, int $seat_id): void
    {
        $trip_seat = $trip->tripSeats()->where("seat_id", $seat_id)->firstOrFail();

        $path = $this->getPathFromSourceToDestination($trip, $source_id, $destination_id);

        if(!empty(array_intersect($trip_seat->station_ids, $path)))
            throw new SeatUnAvailableException($trip->id, $seat_id);

        $trip_seat->station_ids = array_merge($trip_seat->station_ids, $path);

        $trip_seat->save();
    }

    private function getPathFromSourceToDestination(Trip $trip, int $source_id, int $destination_id): array
    {
        $source_key = array_search($source_id, $trip->path);
        $destination_key = array_search($destination_id, $trip->path);

        return array_slice($trip->path, $source_key, ($destination_key - $source_key) + 1);
    }

}