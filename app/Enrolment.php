<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    /**
     * Get the Subscription used to create the enrolment.
     *
     */
    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }

    /**
     * Get the School that own the enrolment.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the Term used to create the enrolment.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the User that own the enrolment.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the Student that own the enrolment.
     *
     */
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    /**
     * Get the Schoolclass that own the enrolment.
     *
     */
    public function schoolclass()
    {
        return $this->belongsTo('App\Schoolclass');
    }

    /**
     * Get the arm that own the enrolment.
     *
     */
    public function arm()
    {
        return $this->belongsTo('App\Arm');
    }
    
    /**
     * The subjects that belongs to the enrolment (enrolled student for the term).
     *
     */
    public function subjects()
    {
        return $this->belongsToMany('App\Subject');
    }
    
    /**
     * Get the results for the enrolment.
     */
    public function results()
    {
        return $this->hasmany('App\Result');
    }
    
    /**
     * Get the itempayments for the enrolment.
     */
    public function itempayments()
    {
        return $this->hasmany('App\Itempayment');
    }
}
