<?php

namespace App\Exceptions;

use Exception, Auth;

class UnauthenticatedException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            "type" => "https://trivago.seif.rocks/probs/unauthenticated", 
            "title" => "Login failed", 
            "detail" => "Wrong username and password or authentication token is expired or invalid.",
        ], 401);
    }
}