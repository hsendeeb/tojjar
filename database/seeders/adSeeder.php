<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\Vehicle;

class adSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Vehicle::all()->each(function($vehicle) {
        Ad::factory()->create(
            ['vehicle_id'=>$vehicle->id]
        );

       });
    }
}
