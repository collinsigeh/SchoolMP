<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Get the School that owns the student.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

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
