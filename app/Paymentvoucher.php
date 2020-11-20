<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentvoucher extends Model
{
    /**
     * Get the Product package that owns the payment voucher.
     *
     */
    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
