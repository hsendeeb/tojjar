<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable=['user_id','role'];

 protected $hidden = [
        'password',
        'remember_token',
    ];
     protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
