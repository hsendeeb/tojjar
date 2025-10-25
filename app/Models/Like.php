<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
 protected $fillable=['user_id','vehicle_id'];

 public function user() {
    return $this->belongsTo(User::class);
 }
 public function ad() {
    return $this->belongsTo(Ad::class);
 }
}
