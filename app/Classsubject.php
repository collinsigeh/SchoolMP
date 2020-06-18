<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classsubject extends Model
{
    /**
     * Get the Class arm that owns the class subject.
     *
     */
    public function arm()
    {
        return $this->belongsTo('App\Arm');
    }
    
    /**
     * Get the user who teaches the class subject.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the Subject that owns this classsubject.
     *
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
    
    /**
     * Get the results using the classsubject.
     */
    public function results()
    {
        return $this->hasmany('App\Result');
    }
}
