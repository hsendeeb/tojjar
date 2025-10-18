<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\CarModel;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $response = Http::get('https://carapi.app/api/models/v2?page=8');
     
        $json = json_decode(str_replace('var carModels = ', '', $response->body()), true);
        $makes = $json['data'] ?? [];

        foreach ($makes as $make) {
            CarModel::UpdateOrCreate(
                [
                    'model_name' => $make['name'],
                    'company_id' => $make['make_id'],
                ],
               
            );
        }

    }
}
