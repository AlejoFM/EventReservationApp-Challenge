<?php

namespace App\Http\Response;

class JsonSuccesfulBodyResponse
{
    protected $message;
    protected $code;

    public function __construct($message, int $code = 200)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function send()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->message,
            'code' => $this->code,
        ], $this->code);
    }
}
