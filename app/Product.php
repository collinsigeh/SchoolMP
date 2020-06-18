<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the packages for the product.
     *
     */
    public function packages()
    {
        return $this->hasMany('App\Package');
    }

    /**
     * Get the orders for the product.
     *
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
