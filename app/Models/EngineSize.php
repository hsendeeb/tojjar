<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineSize extends Model
{
    protected $fillable=['size'];
    protected $table='enginesize';
     public function vehicle() {
        return $this->hasMany(Vehicle::class);
    }
}
