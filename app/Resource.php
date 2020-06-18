<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    /**
     * The staff that belongs to (i.e. manages) the resource.
     *
     */
    public function staff()
    {
        return $this->belongsToMany('App\Staff');
    }
}
