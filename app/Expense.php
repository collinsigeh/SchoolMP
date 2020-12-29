<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * Get the term that has expense.
     *
     */
    public function term()
    {
        return $this->belongsTo('App\Term');
    }

    /**
     * Get the school that has expense.
     *
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    /**
     * Get the user who entered the expense.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
