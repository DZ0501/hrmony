<?php

namespace App\Notifications;

use App\Models\Request;
use App\Services\SettingService;
use App\Enums\SettingKey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusUpdatedNotification extends Notification
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
            ->subject($companyName . ' - Request Status Updated')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('Your request (' . ucfirst($this->request->type) . ') has been updated to: **' . ucfirst($this->request->status) . '**.')
            ->action('View Request', $requestLink)
            ->salutation('Best Regards, ' . $companyName);
    }
}
