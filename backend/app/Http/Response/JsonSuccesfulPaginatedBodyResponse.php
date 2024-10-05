<?php

namespace App\Http\Response;

class JsonSuccesfulPaginatedBodyResponse
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
            'paginated_data' => $this->message,
            'code' => $this->code,
        ], $this->code);
    }
}
