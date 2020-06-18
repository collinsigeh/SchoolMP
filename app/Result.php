<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /**
     * Get the resulttemplate for the result.
     *
     */
    public function resulttemplate()
    {
        return $this->belongsTo('App\Resulttemplate');
    }

    /**
     * Get the classsubject for the result.
     *
     */
    public function classsubject()
    {
        return $this->belongsTo('App\Classsubject');
    }

    /**
     * Get the enrolment for the result.
     *
     */
    public function enrolment()
    {
        return $this->belongsTo('App\Enrolment');
    }

    /**
     * Get the term for the result.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the school for the result.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
}
