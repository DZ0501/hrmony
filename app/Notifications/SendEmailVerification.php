<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\Enums\SettingKey;

class SendEmailVerification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = setting(SettingKey::COMPANY_NAME);

        // Generate the email verification link
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - Verify Your Email Address')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('Please verify your email address by clicking the button below:')
            ->action('Verify Email', $verificationUrl)
            ->line('If you did not create this account, no further action is required.')
            ->salutation('Best Regards, ' . $companyName);
    }

    /**
     * Generate the email verification URL.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
