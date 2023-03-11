<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\TripStation;

class TripService
{
    public function getMany(int $source_id, int $destination_id)
    {
        return TripStation::where('station_id', $source_id)
            ->whereJsonContains('path_to_destination', $destination_id)
            ->get();
    }

    public function createOne(array $trip_data)
    {
        $trip = Trip::create($trip_data)->fresh();

        $this->createTripStations($trip, $trip_data['path']);

        $this->createTripSeats($trip);

        return $trip;
    }

    private function createTripStations(Trip $trip, array $path): void
    {
        $previous_id = null;
        $path_to_destination = $path;

        foreach ($path as $station) {
            array_shift($path_to_destination);

            $trip_station = $trip->stations()->create([
                'station_id' => $station,
                'previous_id' => $previous_id,
                'path_to_destination' => $path_to_destination,
            ])->fresh();

            $previous_id = $trip_station->id;
        }
    }

    private function createTripSeats(Trip $trip): void
    {
        foreach ($trip->bus->seats as $seat) {
            $trip->seats()->create([
                'seat_id' => $seat->id,
                'station_ids' => [],
            ]);
        }
    }

}