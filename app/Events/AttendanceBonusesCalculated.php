<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AttendanceBonusesCalculated
{
    use Dispatchable, SerializesModels;

    public Collection $bonuses;

    public function __construct(Collection $bonuses)
    {
        $this->bonuses = $bonuses;
    }
}
