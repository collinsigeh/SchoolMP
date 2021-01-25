<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usertype', 'status', 'pic', 'role', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The schools that belongs to (i.e. being managed by) the user.
     *
     */
    public function schools()
    {
        return $this->belongsToMany('App\School');
    }
    
    /**
     * Get the directorships for the user.
     *
     */
    public function director()
    {
        return $this->hasOne('App\Director');
    }
    
    /**
     * Get the staff accounts for the user.
     *
     */
    public function staff()
    {
        return $this->hasOne('App\Staff');
    }
    
    /**
     * Get the subjets created by the user.
     *
     */
    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }
    
    /**
     * Get the subjets created by the user.
     *
     */
    public function schoolclasses()
    {
        return $this->hasMany('App\Schoolclass');
    }
    
    /**
     * Get the enrolments for the user.
     *
     */
    public function enrolments()
    {
        return $this->hasMany('App\Enrolment');
    }
    
    /**
     * Get the subjects taught by the user.
     *
     */
    public function classsubjects()
    {
        return $this->hasMany('App\Classsubject');
    }
    
    /**
     * Get the class arms (termly) administered by the user.
     *
     */
    public function arms()
    {
        return $this->hasMany('App\Arm');
    }
    
    /**
     * Get the assistant class teacher role (termly) administered by the user.
     *
     */
    public function classteachers()
    {
        return $this->hasMany('App\Classteachers');
    }

    
    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->hasOne('App\Student');
    }

    
    /**
     * Get the result template created by the user.
     */
    public function resulttemplate()
    {
        return $this->hasmany('App\Resulttemplate');
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
     * Get the itempayments for the User.
     */
    public function itempayments()
    {
        return $this->hasmany('App\Itempayment');
    }
    
    /**
     * Get the lessons created by the User.
     *
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
    
    /**
     * Get the cbts created by the User.
     */
    public function cbts()
    {
        return $this->hasmany('App\Cbt');
    }
    
    /**
     * Get the questions created by the User.
     */
    public function questions()
    {
        return $this->hasmany('App\Question');
    }
}
