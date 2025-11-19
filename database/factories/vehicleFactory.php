<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\vehicle>
 */
class vehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id'=>2,
            'model_id'=>19,
            'year'=>2020,
            'category_id'=>1,
            'price'=>20000,
            'mileage'=>2000,
            'body_id'=>10,
            'fuel_id'=>1,
            'color_id'=>1,
             'gearbox_id'=>2,
              'condition_id'=>1,
               'user_id'=>8,
                'location'=>'Ansar',
                 'description'=>'any',
                 'engineSize_id'=>1,
                  'engineType_id'=>1,


        ];
    }
}
