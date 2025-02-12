<?php

namespace App\Listeners;

use App\Events\AttendanceBonusesCalculated;
use App\Jobs\SendAttendanceBonusNotificationsJob;

class NotifyAttendanceBonusesListener
{
    public function handle(AttendanceBonusesCalculated $event): void
    {
        foreach ($event->bonuses as $bonus) {
            SendAttendanceBonusNotificationsJob::dispatch($bonus);
        }
    }
}
