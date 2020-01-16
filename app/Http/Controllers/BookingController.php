<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Item;
use App\Http\Resources\Item as ItemResource;
use App\Exceptions\InvalidDataException;
class BookingController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Both Hoteliers and customers can book (assumption)
        $this->middleware('auth');
    }

    /**
     * Make new location.
     *
     * @return Response
     */
    public function book(Request $request)
    {
        $item = Item::where('id', $request->id)->first();
        if($item) {
            if($item->availability == 0) {
                throw new InvalidDataException(['availability'  =>  'sold out']);
            }
            $item->availability = $item->availability - 1;
            $item->save();
            return new ItemResource($item);
        }

    }

}