<?php

namespace App\Jobs;

use App\Models\CompanyUpdate;
use App\Models\User;
use App\Notifications\CompanyUpdatePublishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCompanyUpdateNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected CompanyUpdate $update;

    public function __construct(CompanyUpdate $update)
    {
        $this->update = $update;
    }

    public function handle()
    {
        $users = User::where('role', 'employee')->get();

        foreach ($users as $user) {
            $user->notify(new CompanyUpdatePublishedNotification($this->update));
        }
    }
}
