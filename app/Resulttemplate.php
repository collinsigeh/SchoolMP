<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resulttemplate extends Model
{
    /**
     * Get the School that own the resulttemplate.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    
    /**
     * Get all arms using the resulttemplate.
     *
     */
    public function arms()
    {
        return $this->hasMany('App\Arm');
    }
    
    /**
     * Get the results using the resulttemplate.
     */
    public function results()
    {
        return $this->hasmany('App\Result');
    }

    /**
     * Get the user that created the resulttemplate.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
