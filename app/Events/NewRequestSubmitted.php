<?php

namespace App\Events;

use App\Models\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRequestSubmitted
{
    use Dispatchable, SerializesModels;

    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
