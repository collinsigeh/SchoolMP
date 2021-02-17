<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newstaffdata extends Model
{
    /**
     * Get the staff that has details.
     *
     */
    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }
}
