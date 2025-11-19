<?php

namespace Database\Seeders;

use App\Models\Vehicle_image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;


class imageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageFiles= Storage::disk('public')->files('vehicle_images');;
        Vehicle::all()->each(function($vehicle) use($imageFiles) {
         
                $selected=collect($imageFiles)->random();
            
            
                Vehicle_image::create([
                    'vehicle_id'=>$vehicle->id,
                    'image_url'=>$selected
                ]);
            

        });
    }
}
