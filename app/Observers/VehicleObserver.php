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
        Cache::forget("vehicles");
        Cache::forget("vehicles.profile");  
    }

}
