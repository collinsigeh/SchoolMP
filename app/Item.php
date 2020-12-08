<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{    

    /**
     * Get the term that has item.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * The class arms that belongs to the item.
     *
     */
    public function arms()
    {
        return $this->belongsToMany('App\Arm');
    }
    
    /**
     * Get the itempayments for the Item.
     */
    public function itempayments()
    {
        return $this->hasmany('App\Itempayment');
    }
}
