<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itempayment extends Model
{
    /**
     * Get the enrolment that has itempayment.
     *
     */
    public function enrolment()
    {
        return $this->belongsTo('App\Enrolment');
    }

    /**
     * Get the item that has itempayment.
     *
     */
    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    /**
     * Get the term that has itempayment.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the school that has itempayment.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the user who entered/confirmed the itempayment.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
