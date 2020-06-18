<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    /**
     * Get the School that owns the term.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the Subscription used to create the term.
     *
     */
    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }
    
    /**
     * Get the arms for the term.
     *
     */
    public function arms()
    {
        return $this->hasMany('App\Arm');
    }

    /**
     * Get the enrolments for the term.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }
    
    /**
     * Get the results for the term.
     */
    public function results()
    {
        return $this->hasmany('App\Result');
    }
}
