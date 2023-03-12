<?php

namespace Database\Factories;

use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Reservation;
use App\Models\Seat;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

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
            'user_id' => User::factory(),
            'source_station_id' => Station::factory(),
            'destination_station_id' => Station::factory(),
        ];
    }
}
