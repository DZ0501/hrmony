<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Enums\SettingKey;

class PasswordResetNotification extends Notification
{
    use Queueable;
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = setting(SettingKey::COMPANY_NAME);
        $url = url(config('app.url') . "/password/reset/{$this->token}");

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - Reset Your Password')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.')
            ->salutation('Best Regards, ' . $companyName);
    }
}
