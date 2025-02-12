<?php

namespace App\Jobs;

use App\Models\Request;
use App\Notifications\RequestStatusUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRequestStatusNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        if ($this->request->user) {
            $this->request->user->notify(new RequestStatusUpdatedNotification($this->request));
        }
    }
}
