<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Location;

class LocationController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Make new location.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $locationDetails = $this->validate($request, [
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'zip_code' => 'required|integer|digits:5',
        ]);

        $location = Location::create($locationDetails);
        return response()->json([$location], 200);
    }

}