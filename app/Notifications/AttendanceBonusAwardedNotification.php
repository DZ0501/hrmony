<?php

namespace App\Notifications;

use App\Enums\SettingKey;
use App\Services\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceBonusAwardedNotification extends Notification
{
    use Queueable;

    protected $bonus;
    protected $month;
    protected $year;

    public function __construct(float $bonus, int $month, int $year)
    {
        $this->bonus = $bonus;
        $this->month = $month;
        $this->year = $year;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = app(SettingService::class)->get(SettingKey::COMPANY_NAME);


        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - Attendance Bonus Awarded!')
            ->line("Congratulations! You have been awarded a bonus of {$this->bonus}PLN for your attendance in {$this->month}/{$this->year}.")
            ->line('Thank you for your dedication and hard work!')
            ->salutation('Best Regards, ' . $companyName);
    }
}
