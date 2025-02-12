<?php

namespace App\Jobs;

use App\Models\AttendanceBonus;
use App\Notifications\AttendanceBonusAwardedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAttendanceBonusNotificationsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Dispatchable;

    protected AttendanceBonus $bonus;

    public function __construct(AttendanceBonus $bonus)
    {
        $this->bonus = $bonus;
    }

    public function handle()
    {
        $this->bonus->user->notify(new AttendanceBonusAwardedNotification(
            $this->bonus->bonus_amount,
            $this->bonus->month,
            $this->bonus->year
        ));
    }
}
