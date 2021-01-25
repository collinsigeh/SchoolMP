<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cbt extends Model
{

    /**
     * Get the user that created the cbt.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the school that has the cbt.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the subject that has the cbt.
     *
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    /**
     * Get the term that has the cbt.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * The arms that belongs to the cbt.
     *
     */
    public function arms()
    {
        return $this->belongsToMany('App\Arm');
    }
    
    /**
     * Get the questions for the cbt.
     *
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
    
    /**
     * Get the attempts for the cbt.
     *
     */
    public function attempts()
    {
        return $this->hasMany('App\Attempt');
    }
    
    /**
     * Get the questionattempts for the cbt.
     */
    public function questionattempts()
    {
        return $this->hasmany('App\Questionattempt');
    }
}
