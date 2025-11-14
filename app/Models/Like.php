<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
   const UPDATED_AT=null;
   const CREATED_AT=null;
 protected $fillable=['user_id','ad_id','liked_at'];

 public function user() {
    return $this->belongsTo(User::class);
 }
 public function ad() {
    return $this->belongsTo(Ad::class);
 }
}
