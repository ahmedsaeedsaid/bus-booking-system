<?php

namespace Unit;

use App\Exceptions\SeatUnAvailableException;
use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use App\Services\ReservationService;
use App\Services\SeatService;
use App\Services\TripService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery\MockInterface;
use Tests\TestCase;


class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test create one Reservation.
     *
     * @return void
     */
    public function test_create_one()
    {
        // Arrange
        $this->seed();
        $user = User::first();
        $trip = Trip::first();
        $seat = $trip->tripSeats()->first()->seat;
        Auth::setUser($user);

        // Act
        $reservationService = new ReservationService();
        $reservationService->createOne($trip, $trip->path[0], $trip->path[4], $seat->id);

        // Assert.
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'seat_id' => $seat->id,
        ]);

    }
}
