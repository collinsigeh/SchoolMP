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
     * Get the subject that has lesson.
     *
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject');
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
     * The arms that belongs to the lesson.
     *
     */
    public function arms()
    {
        return $this->belongsToMany('App\Arm');
    }
}
