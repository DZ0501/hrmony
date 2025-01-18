<?php

namespace App\Jobs;

use App\Models\JobApplication;
use App\Notifications\JobApplicationStatusNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendJobApplicationStatusNotificationJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public JobApplication $jobApplication;
    public string $status;

    public function __construct(JobApplication $jobApplication, string $status)
    {
        $this->jobApplication = $jobApplication;
        $this->status = $status;
    }

    public function handle()
    {
        $this->jobApplication->user->notify(
            new JobApplicationStatusNotification($this->jobApplication, $this->status)
        );
    }
}
