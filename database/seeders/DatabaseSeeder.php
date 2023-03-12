<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Bus::factory()->count(5)->create();
        Station::factory()->count(28)->create();

        $this->call(TripSeeder::class);
    }
}
