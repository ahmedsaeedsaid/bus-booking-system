<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\TripSeat;

class TripSeatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TripSeat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trip_id' => Trip::factory(),
            'seat_id' => Seat::factory(),
            'station_ids' => '{}',
        ];
    }
}
