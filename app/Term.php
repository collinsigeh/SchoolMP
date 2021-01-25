<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    /**
     * Get the School that owns the term.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the Subscription used to create the term.
     *
     */
    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }
    
    /**
     * Get the arms for the term.
     *
     */
    public function arms()
    {
        return $this->hasMany('App\Arm');
    }

    /**
     * Get the enrolments for the term.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }
    
    /**
     * Get the results for the term.
     */
    public function results()
    {
        return $this->hasmany('App\Result');
    }
    
    /**
     * Get the calendar activities for the term.
     */
    public function calendars()
    {
        return $this->hasmany('App\Calendar');
    }
    
    /**
     * Get the items for the term.
     *
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }
    
    /**
     * Get the itempayments for the Term.
     */
    public function itempayments()
    {
        return $this->hasmany('App\Itempayment');
    }
    
    /**
     * Get the lessos for the term.
     *
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
    
    /**
     * Get the cbts for the term.
     */
    public function cbts()
    {
        return $this->hasmany('App\Cbt');
    }
    
    /**
     * Get the questions for the term.
     */
    public function questions()
    {
        return $this->hasmany('App\Question');
    }
    
    /**
     * Get the attempts for the term.
     */
    public function attempts()
    {
        return $this->hasmany('App\Attempt');
    }
    
    /**
     * Get the questionattempts for the term.
     */
    public function questionattempts()
    {
        return $this->hasmany('App\Questionattempt');
    }
}
