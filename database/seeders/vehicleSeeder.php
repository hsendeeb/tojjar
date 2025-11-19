<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class vehicleSeeder extends Seeder
{
   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::factory()->count(100)->create();
    }
}
