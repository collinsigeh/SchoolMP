<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Get the order that owns the payment.
     *
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    
    /**
     * Get the user that confirmed the payment.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
