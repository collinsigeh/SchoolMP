<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /**
     * Get the Term that owns the calendar.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }
}
