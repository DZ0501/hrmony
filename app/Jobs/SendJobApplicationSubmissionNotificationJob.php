<?php

namespace App\Jobs;

use App\Models\JobApplication;
use App\Notifications\JobApplicationSubmittedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendJobApplicationSubmissionNotificationJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public JobApplication $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function handle()
    {
        // Send notification to the candidate
        $this->jobApplication->user->notify(
            new JobApplicationSubmittedNotification($this->jobApplication)
        );
    }
}
