<?php

namespace App\Http\Response;

class JsonSuccesfulResponse
{
    protected $message;
    protected $code;

    public function __construct(string $message, int $code = 200)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function send()
    {
        return response()->json([
            'status' => 'success',
            'message' => $this->message,
            'code' => $this->code,
        ], $this->code);
    }
}
