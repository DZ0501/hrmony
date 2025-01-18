<?php

namespace App\Listeners;

use App\Events\JobApplicationStatusUpdated;
use App\Jobs\SendJobApplicationStatusNotificationJob;

class SendJobApplicationStatusNotificationListener
{
    public function handle(JobApplicationStatusUpdated $event)
    {
        SendJobApplicationStatusNotificationJob::dispatch($event->jobApplication, $event->status);
    }
}
