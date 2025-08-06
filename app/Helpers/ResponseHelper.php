<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ],  (int)$code);
    }

    public static function error($message, $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null
        ],  (int)$code);
    }


}
