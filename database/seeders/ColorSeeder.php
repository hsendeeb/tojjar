<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $response= Http::get("https://csscolorsapi.com/api/colors");
       $json=json_decode($response,true);
       $colors=$json['colors'];
       foreach($colors as $color){
        Color::updateOrCreate([
            "color"=>$color['name']
          ]);
       }
       


        
    }
}
