<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EngineSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sizes = [
            '0.6L', '0.8L', '1.0L', '1.2L', '1.4L',
            '1.6L', '1.8L', '2.0L', '2.2L', '2.4L',
            '2.5L', '2.7L', '3.0L', '3.5L', '4.0L',
            '4.6L', '5.0L', '5.7L', '6.2L', '6.4L',
            '6.7L', '7.0L', '8.0L', '8.4L'
        ];

        foreach ($sizes as $size) {
            DB::table('engineSize')->insert([
                'size' => $size,
            
            ]);
        }
    }

}
