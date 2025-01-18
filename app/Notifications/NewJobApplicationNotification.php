<?php

namespace App\Notifications;

use App\Enums\SettingKey;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplicationNotification extends Notification
{
    use Queueable;

    public JobApplication $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = setting(SettingKey::COMPANY_NAME);
        $jobOffer = $this->jobApplication->jobOffer;

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - New Job Application Received')
            ->line("A new application has been submitted for the {$jobOffer->position->name} position.")
            ->line("Candidate: {$this->jobApplication->user->firstname} ({$this->jobApplication->user->email})")
            ->line("Job Location: {$jobOffer->job_location}")
            ->line("Salary Range: \${$jobOffer->offered_salary_min} - \${$jobOffer->offered_salary_max}")
            ->line('Please review the application in the system.')
            ->action('View Application', url("/job-applications/{$this->jobApplication->id}"))
            ->salutation('Best Regards, ' . $companyName);
    }
}
