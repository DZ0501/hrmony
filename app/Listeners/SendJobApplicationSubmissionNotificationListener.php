<?php

namespace App\Listeners;

use App\Events\JobApplicationSubmitted;
use App\Jobs\SendJobApplicationSubmissionNotificationJob;
use App\Jobs\NotifyHrOfNewJobApplicationJob;

class SendJobApplicationSubmissionNotificationListener
{
    public function handle(JobApplicationSubmitted $event)
    {
        SendJobApplicationSubmissionNotificationJob::dispatch($event->jobApplication);
        NotifyHrOfNewJobApplicationJob::dispatch($event->jobApplication);
    }
}
