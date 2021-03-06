<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * Get the School that owns the subject.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the User that created the subject.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * The enrolments that belongs to the subject.
     *
     */
    public function enrolments()
    {
        return $this->belongsToMany('App\Enrolment');
    }
    
    /**
     * Get the classsubjects for this subject.
     *
     */
    public function classsubjects()
    {
        return $this->hasMany('App\Classsubjects');
    }
    
    /**
     * Get the lessons for the subject.
     *
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
    
    /**
     * Get the cbts for the subject.
     *
     */
    public function cbts()
    {
        return $this->hasMany('App\Cbt');
    }
    
    /**
     * Get the questions for the subject.
     */
    public function questions()
    {
        return $this->hasmany('App\Question');
    }
    
    /**
     * Get the attempts for the subject.
     */
    public function attempts()
    {
        return $this->hasmany('App\Attempt');
    }
}
