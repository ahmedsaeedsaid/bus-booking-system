<?php

namespace Unit;

use App\Exceptions\SeatUnAvailableException;
use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use App\Services\SeatService;
use App\Services\TripService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;


class SeatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test get available seats.
     *
     * @return void
     */
    public function test_get_available()
    {
        // Arrange
        $this->seed();
        $trip = Trip::first();

        // Act
        $seatService = new SeatService();
        $seats = $seatService->getAvailable($trip, $trip->path[0], $trip->path[4]);

        // Assert.
        $this->assertGreaterThanOrEqual(12, count($seats));
    }

    /**
     * test get available seats in mid.
     *
     * @return void
     */
    public function test_get_available_in_mid_trip()
    {
        // Arrange
        $this->seed();
        $trip = Trip::first();

        // Act
        $seatService = new SeatService();
        $seats = $seatService->getAvailable($trip, $trip->path[2], $trip->path[3]);

        // Assert.
        $this->assertCount(12, $seats);
    }

    /**
     * test get available seats in full trip.
     *
     * @return void
     */
    public function test_get_available_in_full_trip()
    {
        // Arrange
        $this->seed();
        $trip = Trip::first();

        foreach ($trip->tripSeats as $tripSeat) {
            $tripSeat->station_ids = $trip->path;
            $tripSeat->save();
        }

        // Act
        $seatService = new SeatService();
        $seats = $seatService->getAvailable($trip, $trip->path[2], $trip->path[3]);

        // Assert.
        $this->assertCount(0, $seats);
    }

    /**
     * test reserve seat on trip.
     *
     * @return void
     */
    public function test_reserve_seat()
    {
        // Arrange
        $this->seed();
        $trip = Trip::first();
        $seat = $trip->tripSeats()->first()->seat;

        // Act
        $seatService = new SeatService();
        $seatService->reserve($trip, $trip->path[2], $trip->path[3], $seat->id);

        // Assert.
        $this->assertDatabaseHas('trip_seats', [
            'trip_id' => $trip->id,
            'seat_id' => $seat->id,
            'station_ids'  => json_encode([$trip->path[2], $trip->path[3]])
        ]);
    }

    /**
     * test reserve not exists seat on trip.
     *
     * @return void
     */
    public function test_reserve_not_exists_seat()
    {
        // Assert
        $this->expectException(ModelNotFoundException::class);

        // Arrange
        $this->seed();
        $trip = Trip::first();

        // Act
        $seatService = new SeatService();
        $seatService->reserve($trip, $trip->path[2], $trip->path[3], 0);

    }

    /**
     * test reserve unavailable seat on trip.
     *
     * @return void
     */
    public function test_reserve_unavailable_seat()
    {
        $this->expectException(SeatUnAvailableException::class);

        // Arrange
        $this->seed();
        $trip = Trip::first();
        $tripSeat = $trip->tripSeats()->first();

        $tripSeat->station_ids = $trip->path;
        $tripSeat->save();

        // Act
        $seatService = new SeatService();
        $seatService->reserve($trip, $trip->path[2], $trip->path[3], $tripSeat->seat->id);
    }


}
