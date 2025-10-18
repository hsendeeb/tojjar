<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    protected $fillable=["body_type"];

    public function vehicle(){
        return $this->hasMany(Vehicle::class);
    }
}
