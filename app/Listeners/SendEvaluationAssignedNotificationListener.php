<?php

namespace App\Listeners;

use App\Events\EvaluationAssigned;
use App\Jobs\SendEvaluationNotificationJob;

class SendEvaluationAssignedNotificationListener
{
    public function __construct() {}

    public function handle(EvaluationAssigned $event)
    {
        dispatch(new SendEvaluationNotificationJob($event->evaluation));
    }
}
