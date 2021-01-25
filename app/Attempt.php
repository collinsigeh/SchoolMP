<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{

    /**
     * Get the school that has the attempt.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the subject that has the attempt.
     *
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    /**
     * Get the term that has the attempt.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the cbt that has the attempt.
     *
     */
    public function cbt()
    {
        return $this->belongsTo('App\Cbt');
    }

    /**
     * Get the enrolment that has the attempt.
     *
     */
    public function enrolment()
    {
        return $this->belongsTo('App\Enrolment');
    }
    
    /**
     * Get the questionattempts for the attempt.
     */
    public function questionattempts()
    {
        return $this->hasmany('App\Questionattempt');
    }
}
