<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the School that owns the order.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    
    /**
     * Get the person who made the order.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get the subscription provided for the order.
     *
     */
    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }

    /**
     * Get the Product that owns the order.
     *
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Get the Package that owns the order.
     *
     */
    public function package()
    {
        return $this->belongsTo('App\Package');
    }
    
    /**
     * Get the payments for the order.
     *
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
