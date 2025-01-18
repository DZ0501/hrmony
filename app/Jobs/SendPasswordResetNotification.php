<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPasswordResetNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected string $token;

    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function handle()
    {
        $user = User::where('email', $this->email)->first();

        if ($user) {
            $user->notify(new PasswordResetNotification($this->token));
        }
    }
}
