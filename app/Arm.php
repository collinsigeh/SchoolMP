<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arm extends Model
{
    /**
     * Get the Class that owns the arm.
     *
     */
    public function schoolclass()
    {
        return $this->belongsTo('App\Schoolclass');
    }

    /**
     * Get the Term that owns the arm.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }
    
    /**
     * Get the enrolments for the arm.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }
    
    /**
     * Get the class subjects for the arm.
     *
     */
    public function classsubjects()
    {
        return $this->hasMany('App\Classsubject');
    }
    
    /**
     * Get the user who is the main class administrator for the arm.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the resulttemplate for the arm.
     *
     */
    public function resulttemplate()
    {
        return $this->belongsTo('App\Resulttemplate');
    }
    
    /**
     * The items that belongs to this class arm.
     *
     */
    public function items()
    {
        return $this->belongsToMany('App\Item');
    }
    
    /**
     * The lessons that belongs to this arm.
     *
     */
    public function lessons()
    {
        return $this->belongsToMany('App\Lesson');
    }
}
