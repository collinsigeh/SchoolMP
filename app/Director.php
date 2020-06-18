<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    /**
     * Get the School that owns the director.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the User that owns the directorship.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
