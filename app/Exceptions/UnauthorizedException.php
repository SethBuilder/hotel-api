<?php

namespace App\Exceptions;

use Exception, Auth;

class UnauthorizedException extends Exception
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
            "type" => "https://trivago.seif.rocks/probs/unauthorized", 
            "title" => "You are not authorized",
            "detail" => "Your user account does not have permission to perform this operation.",
            "User Type" => "auth()->user()->id",
        ], 403);
    }
}