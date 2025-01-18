<?php

namespace App\Notifications;

use App\Enums\SettingKey;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicationSubmittedNotification extends Notification
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
            ->subject($companyName . ' - Application Submitted Successfully')
            ->line("Thank you for applying for the {$jobOffer->position->name} position.")
            ->line("Your application has been received and is now under review.")
            ->line("We will keep you updated on the next steps.")
            ->line("Job Location: {$jobOffer->job_location}")
            ->line("Salary Range: \${$jobOffer->offered_salary_min} - \${$jobOffer->offered_salary_max}")
            ->line('Thank you for your interest in our company!')
            ->salutation('Best Regards, ' . $companyName);
    }
}
