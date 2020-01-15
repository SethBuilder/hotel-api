<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotelier extends Model
{
    /**
     * Get the hotelier's user details.
     */
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }
}
