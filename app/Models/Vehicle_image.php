<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle_image extends Model
{
    protected $fillable=[
        "vehicle_id",
        "image_url",
    ];
    public function vehicle(){
       return $this->belongsTo(Vehicle::class);
    }
}
