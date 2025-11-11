<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\BodyType;
use App\Models\Condition;
use App\Models\Color;
use App\Models\Gearbox;
use App\Models\FuelType;
use App\Models\EngineType;
use App\Models\EngineSize;
use Illuminate\Support\Facades\Cache;

class CacheDropdowns extends Command
{
    protected $signature = 'cache:dropdowns';

    protected $description = 'Cache all dropdown data for 24 hours to reduce database queries';

    public function handle()
    {
        $this->info('Caching dropdown data...');

        try {
            Cache::remember('dropdowns:companies', 60 * 24, fn() => Company::select('id', 'company_name')->get());
            $this->info('✓ Companies cached');

            Cache::remember('dropdowns:car_models', 60 * 24, fn() => CarModel::select('id', 'model_name', 'company_id')->get());
            $this->info('✓ Car models cached');

            Cache::remember('dropdowns:categories', 60 * 24, fn() => Category::select('id', 'category')->get());
            $this->info('✓ Categories cached');

            Cache::remember('dropdowns:body_types', 60 * 24, fn() => BodyType::select('id', 'body_type')->get());
            $this->info('✓ Body types cached');

            Cache::remember('dropdowns:conditions', 60 * 24, fn() => Condition::select('id', 'condition')->get());
            $this->info('✓ Conditions cached');

            Cache::remember('dropdowns:colors', 60 * 24, fn() => Color::select('id', 'color')->get());
            $this->info('✓ Colors cached');

            Cache::remember('dropdowns:gearboxes', 60 * 24, fn() => Gearbox::select('id', 'gearbox_type')->get());
            $this->info('✓ Gearboxes cached');

            Cache::remember('dropdowns:fuel_types', 60 * 24, fn() => FuelType::select('id', 'fuel_type')->get());
            $this->info('✓ Fuel types cached');

            Cache::remember('dropdowns:engine_types', 60 * 24, fn() => EngineType::select('id', 'type')->get());
            $this->info('✓ Engine types cached');

            Cache::remember('dropdowns:engine_sizes', 60 * 24, fn() => EngineSize::select('id', 'size')->get());
            $this->info('✓ Engine sizes cached');

            $this->info('🎉 All dropdown data cached successfully for 24 hours!');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error caching dropdowns: ' . $e->getMessage());
            return 1;
        }
    }
}
