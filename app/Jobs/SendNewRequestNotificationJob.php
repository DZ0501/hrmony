<?php

namespace App\Jobs;

use App\Models\Request;
use App\Models\User;
use App\Notifications\NewRequestSubmittedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewRequestNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $hrEmployees = User::where('role', 'hr_employee')->get(); // Adjust the query if needed

        foreach ($hrEmployees as $hr) {
            $hr->notify(new NewRequestSubmittedNotification($this->request));
        }
    }
}
