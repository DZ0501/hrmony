<?php

namespace App\Events;

use App\Models\Evaluation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EvaluationAssigned
{
    use Dispatchable, SerializesModels;

    public Evaluation $evaluation;

    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }
}
