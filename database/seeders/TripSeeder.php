<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
use App\Services\TripService;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    const STATION_SAMPLE = 5;
    private TripService $tripService;

    public function __construct()
    {
        $this->tripService = new TripService();
    }


    public function run()
    {
        $buses = Bus::all();
        $stations = Station::all();

        foreach ($buses as $bus) {
            $this->tripService->createOne([
                'bus_id' => $bus->id,
                'path' => $stations->random($this::STATION_SAMPLE)->pluck('id')->toArray()
            ]);
        }
    }
}