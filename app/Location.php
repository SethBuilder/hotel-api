<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city', 'state', 'country', 'zip_code'
    ];

    public function items() {
        return $this->hasMany('App\Item');
    }
}
