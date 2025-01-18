<?php

namespace App\Listeners;

use App\Events\PasswordResetRequested;
use App\Jobs\SendPasswordResetNotification;

class SendPasswordResetLinkListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordResetRequested $event)
    {
        // Dispatch the job to send the notification
        SendPasswordResetNotification::dispatch($event->email, $event->token);
    }
}
