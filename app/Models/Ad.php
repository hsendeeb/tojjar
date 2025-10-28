<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'views',
        'boosted'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
    public function likes() {
    return $this->hasMany(Like::class);
}
public function isLikedBy(User $user): bool
{
    return $this->likes()->where('user_id', $user->id)->exists();
}

    
}
