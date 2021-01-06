<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{    

    /**
     * Get the school that has lesson.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the term that has lesson.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * The classsubjects that belongs to the lesson.
     *
     */
    public function classsubjects()
    {
        return $this->belongsToMany('App\Classsubject');
    }
}
