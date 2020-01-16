<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Get the customer's user details.
     */
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }
}
