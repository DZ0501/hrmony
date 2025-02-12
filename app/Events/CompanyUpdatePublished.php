<?php

namespace App\Events;

use App\Models\CompanyUpdate;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CompanyUpdatePublished
{
    use Dispatchable, SerializesModels;

    public CompanyUpdate $update;

    public function __construct(CompanyUpdate $update)
    {
        $this->update = $update;
    }
}
