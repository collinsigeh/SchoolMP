<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Get the enrolments for the student.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }

    /**
     * Get the user that owns the student.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
