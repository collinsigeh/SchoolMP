<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classteacher extends Model
{
    /**
     * Get the Class arm that owns the class teacher.
     *
     */
    public function arm()
    {
        return $this->belongsTo('App\Arm');
    }
    
    /**
     * Get the user who administers this class teacher role (termly).
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
