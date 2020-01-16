<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hotelier;
use App\Customer;
use App\Exceptions\UnauthenticatedException;
use App\Exceptions\InvalidDataException;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'type'     => 'required|in:hotelier,customer'
        ]);

        if($validateData->fails()) {
            throw new InvalidDataException($validateData->errors());
        }

        $hotelier = $request->type === "hotelier" ? Hotelier::create() : Customer::create();
        $user = new User;
        $user->email = $request->email;
        $password = $request->password;
        $user->password = app('hash')->make($password);

        $hotelier->user()->save($user);

        return response()->json(['user' => $user, 'message' => "$user->userable_type created"], 201);
        
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            throw new UnauthenticatedException();
        }

        return $this->respondWithToken($token);
    }

}