<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Booking;
use App\Models\Seat;
use App\Models\TripStation;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seat_id' => Seat::factory(),
            'source_trip_station_id' => TripStation::factory(),
            'destination_trip_station_id' => TripStation::factory(),
        ];
    }
}
