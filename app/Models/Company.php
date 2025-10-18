<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable=['id','company_name'];
    public function vehicle(){
        return $this->hasMany(Vehicle::class);
    }
}
