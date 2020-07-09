<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The default payment processor for this app
     *
     */
    public function paymentprocessors()
    {
        return $this->hasOne('App\Paymentprocessors');
    }
}
