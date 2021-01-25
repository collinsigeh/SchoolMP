<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionattempt extends Model
{

    /**
     * Get the school that has the questionattempt.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the term that has the questionattempt.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the cbt that has the questionattempt.
     *
     */
    public function cbt()
    {
        return $this->belongsTo('App\Cbt');
    }

    /**
     * Get the enrolment that has the questionattempt.
     *
     */
    public function enrolment()
    {
        return $this->belongsTo('App\Enrolment');
    }

    /**
     * Get the attempt that has the questionattempt.
     *
     */
    public function attempt()
    {
        return $this->belongsTo('App\Attempt');
    }

    /**
     * Get the question that has the questionattempt.
     *
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
