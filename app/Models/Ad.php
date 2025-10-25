<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'likes',
        'views',
        'boosted'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
    
}
