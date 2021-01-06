<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * The users that belongs to (i.e. managing) the school.
     *
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
    /**
     * Get the directors for the school.
     *
     */
    public function directors()
    {
        return $this->hasMany('App\Director');
    }
    
    /**
     * Get all staff for the school.
     *
     */
    public function staff()
    {
        return $this->hasMany('App\Staff');
    }
    
    /**
     * Get all students for the school.
     *
     */
    public function students()
    {
        return $this->hasMany('App\Student');
    }
    
    /**
     * Get the session terms for the school.
     *
     */
    public function terms()
    {
        return $this->hasMany('App\Term');
    }
    
    /**
     * Get the session terms for the school.
     *
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    
    /**
     * Get the classes for the school.
     *
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }
    
    /**
     * Get the subscriptions for the school.
     *
     */
    public function schoolclasses()
    {
        return $this->hasMany('App\Schoolclass');
    }
    
    /**
     * Get the enrolments for the school.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }
    
    /**
     * Get all subjects for the school.
     *
     */
    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }
    
    /**
     * Get all resulttemplates for the school.
     *
     */
    public function resulttemplates()
    {
        return $this->hasMany('App\Resulttemplate');
    }
    
    /**
     * Get the results for the school.
     */
    public function results()
    {
        return $this->hasmany('App\Result');
    }
    
    /**
     * Get the itempayments for the School.
     */
    public function itempayments()
    {
        return $this->hasmany('App\Itempayment');
    }
    
    /**
     * Get the lessons for the school.
     *
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
}
