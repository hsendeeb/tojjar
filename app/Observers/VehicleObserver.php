<?php

namespace App\Observers;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class VehicleObserver
{
    /**
     * Handle the Vehicle "created" event.
     */
    public function created(Vehicle $vehicle)
    {
              

        self::flushVehicleCache();
    }

    public function updated(Vehicle $vehicle)
    {
        self::flushVehicleCache();
    }

    public function deleted(Vehicle $vehicle)
    {
        self::flushVehicleCache();
    }

    private static function flushVehicleCache()
    {
        $perPage = 20;

    // Get one page to access paginator
    $samplePage = Vehicle::join('ads', 'ads.vehicle_id', 'vehicles.id')
        ->where('ads.boosted', true)
        ->select('vehicles.*')
        ->paginate($perPage);

    $maxPage = $samplePage->lastPage();

    for ($i = 1; $i <= $maxPage; $i++) {
        Cache::forget("vehicles_page_{$i}");
    }
 
        
    }

}
