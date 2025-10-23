<?php

namespace App\Jobs;

use App\Models\Vehicle;
use App\Models\Vehicle_image;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteVehicleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $vehicleId;

    /**
     * Create a new job instance.
     */
    public function __construct($vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         
        $vehicle = Vehicle::find($this->vehicleId);;
        if ($vehicle && !$vehicle->available) {

            $vehicle->delete();
          
        }
    }
}
