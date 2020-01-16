<?php

namespace App\Exceptions;

use Exception, Auth;

class InvalidDataException extends Exception
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

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
            "type" => "https://trivago.seif.rocks/probs/invalid-data", 
            "title" => "Invalid data", 
            "detail" => "Data sent in the request body breaks validation rules.",
            "invalid-params" => $this->errors,
        ], 422);
    }
}