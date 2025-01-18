<?php

namespace App\Notifications;

use App\Enums\SettingKey;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicationStatusNotification extends Notification
{
    use Queueable;

    public JobApplication $jobApplication;
    public string $status;

    public function __construct(JobApplication $jobApplication, string $status)
    {
        $this->jobApplication = $jobApplication;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $jobOffer = $this->jobApplication->jobOffer;
        $stage = $this->jobApplication->stage;
        $companyName = setting(SettingKey::COMPANY_NAME);

        if ($this->status === 'passed') {
            $statusMessage = "Congratulations! Your application for the {$jobOffer->position->name} position has been accepted.";
            if ($stage === 'department_head_review') {
                $statusMessage .= " Please wait for a phone call to schedule your interview.";
            }
        } elseif ($this->status === 'rejected') {
            $statusMessage = "We regret to inform you that your application for the {$jobOffer->position->name} position has been rejected.";
        } else {
            $statusMessage = "Your application for the {$jobOffer->position->name} position has been updated to status: {$this->status}.";
        }
        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - Application Status Update')
            ->line($statusMessage)
            ->line('Thank you for your interest in our company.')
            ->salutation('Best Regards, ' . $companyName);
    }
}
