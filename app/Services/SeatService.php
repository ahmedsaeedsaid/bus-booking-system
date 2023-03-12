<?php

namespace App\Services;

use App\Exceptions\SeatUnAvailableException;
use App\Exceptions\InvalidTripStationsException;
use App\Models\Trip;
use App\Models\TripSeat;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SeatService
{

    /**
     * @param Trip $trip
     * @param int $source_id
     * @param int $destination_id
     * @return array seats.
     *
     * get available seats for a trip.
     * @throws InvalidTripStationsException
     */
    public function getAvailable(Trip $trip, int $source_id, int $destination_id): array
    {
        $available_seats = [];
        try {

            $source_destination_path = $this->getPathBetweenTwoStations($trip, $source_id, $destination_id);

            foreach ($trip->tripSeats as $trip_seat)
            {
                if(empty(array_intersect($trip_seat->station_ids, $source_destination_path)))
                {
                    $available_seats[] = $trip_seat->seat;
                }
            }

        } catch (InvalidTripStationsException $e){
            return $available_seats;
        }

        return $available_seats;
    }

    /**
     * @param Trip $trip
     * @param int $source_id
     * @param int $destination_id
     * @param int $seat_id
     * @return void.
     *
     * reserve seat for a trip for stations between source to destination.
     * @throws SeatUnAvailableException
     * @throws InvalidTripStationsException
     * @throws ModelNotFoundException
     */
    public function reserve(Trip $trip, int $source_id, int $destination_id, int $seat_id): void
    {
        $trip_seat = $trip->tripSeats()->where("seat_id", $seat_id)->firstOrFail();

        $source_destination_path = $this->getPathBetweenTwoStations($trip, $source_id, $destination_id);

        if(!empty(array_intersect($trip_seat->station_ids, $source_destination_path)))
            throw new SeatUnAvailableException($trip->id, $seat_id);

        $trip_seat->station_ids = array_merge($trip_seat->station_ids, $source_destination_path);

        $trip_seat->save();
    }

    /**
     * @param Trip $trip
     * @param int $source_id
     * @param int $destination_id
     * @return array .
     *
     * get stations from source to destination.
     * @throws InvalidTripStationsException
     */
    private function getPathBetweenTwoStations(Trip $trip, int $source_id, int $destination_id): array
    {
        $source_key = array_search($source_id, $trip->path);
        $destination_key = array_search($destination_id, $trip->path);

        if (!$source_key || !$destination_key)
            throw new InvalidTripStationsException($source_id, $destination_id);

        return array_slice($trip->path, $source_key, ($destination_key - $source_key) + 1);
    }

}