<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{    
    /**
     * The class arms that belongs to the item.
     *
     */
    public function arms()
    {
        return $this->belongsToMany('App\Arm');
    }
}
