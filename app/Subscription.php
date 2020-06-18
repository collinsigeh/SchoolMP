<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * Get the terms for the subscription.
     *
     */
    public function terms()
    {
        return $this->hasMany('App\Term');
    }

    /**
     * Get the enrolments for the subscription.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }

    /**
     * Get the School that owns the subscription.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the orders for the subscription.
     *
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
