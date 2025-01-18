<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

class ApiSuccessResponse implements Responsable
{
    protected mixed $data;
    protected array $message;
    protected int $status;
    protected array $headers;

    public function __construct(
        mixed $data = null,
        array $message = [],
        int $status = Response::HTTP_OK,
        array $headers = []
    ) {
        $this->data = $data;
        $this->message = $message ?: ['Operation successful'];
        $this->status = $status;
        $this->headers = $headers;
    }

    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->data,
                'message' => $this->message,
            ],
            $this->status,
            $this->headers
        );
    }
}
