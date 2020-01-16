<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class Location extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'city'          =>  $this->city,
            'state'         =>  $this->state,
            'country'       =>  $this->country,
            'zip_code'      =>  $this->zip_code,
        ];
    }
}
