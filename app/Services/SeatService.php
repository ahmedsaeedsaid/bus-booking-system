<?php

namespace App\Services;

use App\Models\Seat;
use App\Models\Trip;
use App\Models\TripSeat;
use App\Models\TripStation;

class SeatService
{

    public function getAvailable(Trip $trip, int $source_id, int $destination_id): array
    {
        $available_seats = [];
        $path = $this->getPathFromSourceToDestination($trip, $source_id, $destination_id);

        foreach ($trip->tripSeats() as $trip_seat)
        {
            if(empty(array_intersect($trip_seat->station_ids, $path)))
            {
                $available_seats[] = $trip->tripSeats()->seat;
            }
        }

        return $available_seats;
    }

    public function book(Trip $trip, int $source_id, int $destination_id, int $seat_id): bool
    {
        $trip_seat = TripSeat::where("trip_id", $trip->id)
            ->where("seat_id", $seat_id)
            ->first();

        $path = $this->getPathFromSourceToDestination($trip, $source_id, $destination_id);

        $is_available = empty(array_intersect($trip_seat->seat->station_ids, $path));

        if ($is_available) {
            $trip_seat->station_ids->merge($path);

            $trip_seat->save();
        }

        return $is_available;
    }

    private function getPathFromSourceToDestination(Trip $trip, int $source_id, int $destination_id): array
    {
        $source_key = array_search($source_id, $trip->path);
        $destination_key = array_search($destination_id, $trip->path);

        return array_slice($trip->path, $source_key, ($destination_key - $source_key));
    }

}