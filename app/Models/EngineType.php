<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineType extends Model
{
    protected $fillable=['type'];
    protected $table="enginetype";
    public function vehicle() {
        return $this->hasMany(Vehicle::class);
    }
}
