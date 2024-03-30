<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success( $data, $message = "okay", $statusCode = 200)
    {
        return response()->json(
            [
                'data' => $data,
                'message' => $message,
                'success' => true
            ],
            $statusCode
        );
    }
    public function error($message, $statusCode = 400)
    {
        return response()->json(
            [
                'message' => $message,
                'success' => false
            ],
            $statusCode
        );
    }
}
