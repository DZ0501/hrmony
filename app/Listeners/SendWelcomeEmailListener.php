<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmail;

class SendWelcomeEmailListener
{
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;

        SendWelcomeEmail::dispatch($user);
    }
}
