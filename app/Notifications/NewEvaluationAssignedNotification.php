<?php

namespace App\Notifications;

use App\Models\Evaluation;
use App\Services\SettingService;
use App\Enums\SettingKey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEvaluationAssignedNotification extends Notification
{
    use Queueable;

    protected Evaluation $evaluation;

    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = app(SettingService::class)->get(SettingKey::COMPANY_NAME);
        $evaluationLink = url('/evaluations/' . $this->evaluation->id);

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - New Evaluation Assigned')
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('A new evaluation has been assigned to you for Quarter ' . $this->evaluation->quarter . ', ' . $this->evaluation->year . '.')
            ->line('Evaluation Type: ' . ucfirst($this->evaluation->type))
            ->action('Start Evaluation', $evaluationLink)
            ->salutation('Best Regards, ' . $companyName);
    }
}
