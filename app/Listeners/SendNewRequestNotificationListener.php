<?php

namespace App\Listeners;

use App\Events\NewRequestSubmitted;
use App\Jobs\SendNewRequestNotificationJob;

class SendNewRequestNotificationListener
{
    public function __construct() {}

    public function handle(NewRequestSubmitted $event)
    {
        dispatch(new SendNewRequestNotificationJob($event->request));
    }
}
