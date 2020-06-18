<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schoolclass extends Model
{
    /**
     * Get the User that created the schoolclass.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get the School that own the schoolclass.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    
    /**
     * Get the arms for the Schoolclass.
     *
     */
    public function arms()
    {
        return $this->hasMany('App\Arm');
    }
    
    /**
     * Get the enrolments for the class.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }
}
