<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentprocessors extends Model
{
    /**
     * The setting that own the payment processor.
     *
     */
    public function setting()
    {
        return $this->belongsTo('App\Setting');
    }
}
