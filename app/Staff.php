<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    /**
     * Get the School that owns the staff.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    
    /**
     * Get the User that owns the staff account.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the newstaffdata details that belong to this staff account.
     *
     */
    public function staff()
    {
        return $this->hasOne('App\Newstaffdata');
    }
}
