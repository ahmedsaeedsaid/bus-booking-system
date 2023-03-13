<?php

namespace Tests\Unit;

use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use App\Services\TripService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;


class TripTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test create trip.
     *
     * @return void
     */
    public function test_create_one()
    {
        // Arrange
        $this->seed();
        $tripCount = Trip::count();
        $stationCount = 5;
        $seatCount = 12;

        $bus = Bus::first();
        $stations = Station::all();
        $tripData = [
            'bus_id' => $bus->id,
            'path' => $stations->random($stationCount)->pluck('id')->toArray()
        ];

        // Act
        $tripService = new TripService();
        $trip = $tripService->createOne($tripData);

        // Assert.
        $this->assertEquals($bus->id, $trip->bus->id);
        $this->assertDatabaseCount('trips', $tripCount + 1);

        $expectedStationCount = ($stationCount * $tripCount) + $stationCount;
        $this->assertDatabaseCount('trip_stations', $expectedStationCount);

        $expectedSeatCount = ($seatCount * $tripCount) + $seatCount;
        $this->assertDatabaseCount('trip_seats', $expectedSeatCount);

        $this->assertDatabaseHas('trips', [
            'id' => $trip->id,
            'bus_id' => $trip->bus->id,
            'path'  => json_encode($tripData['path'])
        ]);

    }

    /**
     * test get available trips.
     *
     * @return void
     */
    public function test_get_many()
    {
        // Arrange
        $this->seed();
        $trip = Trip::first();

        // Act
        $tripService = new TripService();
        $trips = $tripService->getMany($trip->path[0], $trip->path[4]);

        // Assert.
        $this->assertGreaterThanOrEqual(1, count($trips));
    }
}
