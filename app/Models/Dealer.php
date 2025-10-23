<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable=['name','user_id','paid'];  

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}

