<?php

namespace App\Notifications;

use App\Models\CompanyUpdate;
use App\Services\SettingService;
use App\Enums\SettingKey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyUpdatePublishedNotification extends Notification
{
    use Queueable;

    protected CompanyUpdate $update;

    public function __construct(CompanyUpdate $update)
    {
        $this->update = $update;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = app(SettingService::class)->get(SettingKey::COMPANY_NAME);
        $updateLink = url('/company-updates/' . $this->update->id);

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - New Company Update Published')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('A new company update has been published: "' . $this->update->title . '".')
            ->line('Published by: ' . $this->update->creator->firstname . ' ' . $this->update->creator->surname)
            ->action('Read the Update', $updateLink)
            ->salutation('Best Regards, ' . $companyName);
    }
}
