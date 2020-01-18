<?php

namespace App\Http\Controllers;
use Validator, Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\ItemCollection;
use App\Exceptions\UnauthenticatedException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\InvalidDataException;
class ItemController extends Controller
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
     * Get all items for the logged in hotelier.
     *
     * @return Response
     */
    public function index()
    {
        $items = Item::where('hotelier_id', Auth::user()->userable_id)->get();
        return new ItemCollection($items);
    }

    /**
     * Make new item.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => ['required','min:10', 'regex:/(?!.*(free|offer|book|website)).*$/i'],
            'rating' => 'required|integer|min:0|max:5',
            'category' => 'required|string|in:hotel,alternative,hostel,lodge,resort,guest-house',
            'location_id' => 'required|integer',
            'image' => 'required|url',
            'reputation' => 'required|integer|min:0|max:1000',
            'price'  => 'required|integer',
            'availability'  => 'required|integer',
        ]);

        if($validateData->fails()) {
            throw new InvalidDataException($validateData->errors());
        }

        $validateData = $validateData->valid();
        $validateData['hotelier_id'] = Auth::user()->userable_id;
        $item = Item::create($validateData);
        return new ItemResource($item);
    }



    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $item = $this->getItem($request->id);
        
        return new ItemResource($item);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $item = $this->getItem($request->id);

        $validateData = Validator::make($request->all(), [
            'name' => ['regex:/(?!.*(free|offer|book|website)).*$/i'],
            'rating' => 'integer|min:0|max:5',
            'category' => 'string|in:hotel,alternative,hostel,lodge,resort,guest-house',
            'location_id' => 'integer',
            'image' => 'url',
            'reputation' => 'integer|min:0|max:1000',
            'price'  => 'integer',
            'availability'  => 'integer',
        ]);
        if($validateData->fails()) {
            throw new InvalidDataException($validateData->errors());
        }
        $item->fill($validateData->valid())->save();
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = $this->getItem($request->id);

        $item->delete();

        return response('deleted successfully', 200);
    }

    private function getItem($id) {
        $item = Item::where('id', $id)->first();

        if (Gate::denies('access-item', $item)) {
            throw new UnauthorizedException();
        }
        return $item;
    }

}