<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
     protected $fillable = [
        'user_id', 'plan', 'amount', 'payment_method',
        'invoice_image', 'status', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
