<?php

namespace App\Listeners;

use App\Events\RequestStatusUpdated;
use App\Jobs\SendRequestStatusNotificationJob;

class SendRequestStatusNotificationListener
{
    public function __construct() {}

    public function handle(RequestStatusUpdated $event)
    {
        dispatch(new SendRequestStatusNotificationJob($event->request));
    }
}
