<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rating', 'category', 'image', 'reputation', 'location_id', 'price', 'availability', 'hotelier_id'
    ];

    public function location() {
        return $this->belongsTo('App\Location');
    }

    public function hotelier() {
        return $this->belongsTo('App\Hotelier');
    }

    /**
     * Get reputation badge.
     * @return string
     */
    public function getReputationBadgeAttribute()
    {
        $reputation = $this->reputation;
        if($reputation < 500) {
            $badge = 'red';
        } else if($reputation < 799) {
            $badge = 'yellow';
        } else {
            $badge = 'green';
        }

        return $badge;
    }
}
