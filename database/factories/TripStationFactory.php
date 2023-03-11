<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripStation;

class TripStationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TripStation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trip_id' => Trip::factory(),
            'station_id' => Station::factory(),
            'previous_id' => TripStation::factory(),
            'path_to_destination' => '{}',
        ];
    }
}
