<?php

namespace App\Events;

use App\Models\JobApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobApplicationStatusUpdated
{
    use Dispatchable, SerializesModels;

    public JobApplication $jobApplication;
    public string $status;

    public function __construct(JobApplication $jobApplication, string $status)
    {
        $this->jobApplication = $jobApplication;
        $this->status = $status;
    }
}
