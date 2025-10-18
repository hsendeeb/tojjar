<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Company;


class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $response = Http::get('https://carapi.app/api/makes    ');
     
        $json = json_decode(str_replace('var carModels = ', '', $response->body()), true);
        $makes = $json['data'] ?? [];

        foreach ($makes as $make) {
            Company::UpdateOrCreate(
                [
                    'id' => $make['id'],
                    'company_name' => $make['name'],
                ],
               
            );
        }

    }
}
