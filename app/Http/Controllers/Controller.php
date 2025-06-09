<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseSuccess($message, $code=200) {
        $result = [
            'message' => $message
        ];
        if(is_array($message)) $result = $message;
        return response()->json($result, $code);
    }

    public function responseError($message, $code=400) {
        $result = [
            'message' => $message
        ];
        if(is_array($message)) $result = $message;
        return response()->json($result, $code);
    }
}
