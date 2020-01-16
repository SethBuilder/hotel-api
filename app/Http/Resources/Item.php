<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\Hotelier as HotelierResource;
class Item extends JsonResource
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
            'name'          =>  $this->name,
            'rating'        =>  $this->rating,
            'category'      =>  $this->category,
            'reputation'    =>  $this->reputation,
            'image'         =>  $this->image,
            'price'         =>  $this->price,
            'availability'  =>  $this->availability,
            'reputation_badge'  =>  $this->reputation_badge,

            'location'                 =>  new LocationResource($this->location),
            'hotelier'                 =>  new HotelierResource($this->hotelier),
            
        ];
    }
}
