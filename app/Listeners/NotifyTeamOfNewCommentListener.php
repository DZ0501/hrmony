<?php

namespace App\Listeners;

use App\Jobs\SendNewCommentNotificationJob;

class NotifyTeamOfNewCommentListener
{
    public function handle(object $event): void
    {
        SendNewCommentNotificationJob::dispatch($event->comment);
    }
}
