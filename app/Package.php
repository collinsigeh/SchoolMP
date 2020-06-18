<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * Get the Product that owns the package.
     *
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
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
