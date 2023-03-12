<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\TripStation;
use Illuminate\Support\Facades\DB;

class TripService
{
    private SeatService $seatService;
    public function __construct()
    {
        $this->seatService = new SeatService();
    }

    /**
     * @param int $source_id
     * @param int $destination_id
     * @return array.
     *
     * get trips pass through from source station to destination station
     */
    public function getMany(int $source_id, int $destination_id): array
    {
        $trips = [];
        $trip_stations = TripStation::where('station_id', $source_id)
            ->whereJsonContains('path_to_destination', $destination_id)
            ->get();

        foreach ($trip_stations as $trip_station) {
            $seats = $this->seatService->getAvailable(
                $trip_station->trip,
                $source_id,
                $destination_id
            );
            if (!empty($seats))
            {
                $trip = $trip_station->trip;
                $trip['seats'] = $seats;
                $trips[] = $trip;
            }
        }

        return $trips;
    }


    public function createOne(array $trip_data): Trip
    {
        return DB::transaction(function($trip_data) use ($trip_data)
        {
            $trip = Trip::create($trip_data)->fresh();

            $this->createTripStations($trip, $trip_data['path']);

            $this->createTripSeats($trip);

            return $trip;
        });

    }

    private function createTripStations(Trip $trip, array $path): void
    {
        while ($station = array_shift($path))
        {
            $trip->tripStations()->create([
                'station_id' => $station,
                'path_to_destination' => $path,
            ]);
        }
    }

    private function createTripSeats(Trip $trip): void
    {
        foreach ($trip->bus->seats as $seat) {
            $trip->tripSeats()->create([
                'seat_id' => $seat->id,
                'station_ids' => [],
            ]);
        }
    }

}