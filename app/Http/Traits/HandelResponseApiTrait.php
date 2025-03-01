<?php

namespace App\Http\Traits;

trait HandelResponseApiTrait
{

    public function responseSuccess($data, $message = 'success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function responseFailed($message = 'error', $code = 400)
    {
        return response()->json([
            'status' => 'failed',
            'code' => $code,
            'message' => $message
        ], $code);
    }
}
