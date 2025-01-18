<?php

namespace App\Jobs;

use App\Models\JobApplication;
use App\Models\User;
use App\Notifications\NewJobApplicationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyHrOfNewJobApplicationJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public JobApplication $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function handle()
    {
        // Notify all HR employees
        $hrEmployees = User::whereHas('roles', function ($query) {
            $query->where('name', 'hr_employee');
        })->get();

        foreach ($hrEmployees as $hrEmployee) {
            $hrEmployee->notify(new NewJobApplicationNotification($this->jobApplication));
        }
    }
}
