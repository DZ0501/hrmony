<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiErrorResponse implements Responsable
{
    protected Throwable|null $exception;
    protected array $message;
    protected int $status;
    protected array $headers;

    public function __construct(
        Throwable $exception = null,
        array $message = [],
        int $status = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = []
    ) {
        $this->exception = $exception;
        $this->message = $message ?: ['An error occurred'];
        $this->status = $status;
        $this->headers = $headers;
    }

    public function toResponse($request)
    {
        $response = [
            'message' => $this->message,
        ];

        if ($this->exception && config('app.debug')) {
            $response['debug'] = [
                'message' => $this->exception->getMessage(),
                'file' => $this->exception->getFile(),
                'line' => $this->exception->getLine(),
            ];
        }

        return response()->json($response, $this->status, $this->headers);
    }
}
