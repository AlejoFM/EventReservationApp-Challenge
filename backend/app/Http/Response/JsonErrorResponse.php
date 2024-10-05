<?php

namespace App\Http\Response;

class JsonErrorResponse
{
    protected $message;
    protected $code;

    public function __construct(string $message, int $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function send()
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->message,
            'code' => $this->code,
        ], $this->code);
    }
}
