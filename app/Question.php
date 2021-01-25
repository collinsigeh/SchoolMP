<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * Get the user that created the question.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the school that has the question.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the subject that has the question.
     *
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    /**
     * Get the term that has the question.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the cbt that has the question.
     *
     */
    public function cbt()
    {
        return $this->belongsTo('App\Cbt');
    }
    
    /**
     * Get the questionattempts for the question.
     */
    public function questionattempts()
    {
        return $this->hasmany('App\Questionattempt');
    }
}
