<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ad extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'views',
        'boosted',
        'boosted_at'
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
    // Check if likes are already eager-loaded to prevent N+1
    if ($this->relationLoaded('likes')) {
        return $this->likes->where('user_id', $user->id)->isNotEmpty();
    }
    // Fallback to database query if not eager-loaded
    return $this->likes()->where('user_id', $user->id)->exists();
}

public function isCurrentUserLike(): bool
{
    // For use after with('likes') eager loading
    return Auth::check() && $this->likes->where('user_id', Auth::id())->isNotEmpty();
}

    
}
