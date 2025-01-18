<?php

namespace App\Notifications;

use App\Enums\SettingKey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\JobOffer;

class NewJobOfferNotification extends Notification
{
    use Queueable;

    protected $jobOffer;

    public function __construct(JobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $jobOffer = $this->jobOffer->load('position');
        $companyName = setting(SettingKey::COMPANY_NAME);
        $jobOfferLink = url('/job-offers/' . $this->jobOffer->id);

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - New Job Offer: ' . $this->jobOffer->position->name)
            ->greeting('Hello ' . $notifiable->firstname . '!')
            ->line('A new job offer has been posted for the position of ' . $this->jobOffer->position->name . '.')
            ->line('Location: ' . $this->jobOffer->job_location)
            ->line('Salary: ' . $this->jobOffer->offered_salary_min . ' - ' . $this->jobOffer->offered_salary_max)
            ->line('Description: ' . $jobOffer->position->description)
            ->action('Check Details', $jobOfferLink)
            ->salutation('Best Regards, ' . $companyName);
    }
}
