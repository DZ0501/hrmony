<?php

namespace App\Notifications;

use App\Models\Request;
use App\Services\SettingService;
use App\Enums\SettingKey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRequestSubmittedNotification extends Notification
{
    use Queueable;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = app(SettingService::class)->get(SettingKey::COMPANY_NAME);
        $requestLink = url('/requests/' . $this->request->id);

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - New Employee Request Submitted')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('A new request has been submitted by ' . $this->request->user->firstname . ' ' . $this->request->user->surname . '.')
            ->line('Request Type: **' . ucfirst($this->request->type) . '**')
            ->action('Review Request', $requestLink)
            ->salutation('Best Regards, ' . $companyName);
    }
}
