<?php

namespace App\Notifications;

use App\Enums\SettingKey;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $companyName = setting(SettingKey::COMPANY_NAME);
        $jobApplication = $this->comment->jobApplication;
        $commentAuthor = $this->comment->user->firstname;

        return (new MailMessage)
            ->from(config('mail.from.address'), $companyName)
            ->subject($companyName . ' - New Comment on Job Application')
            ->line("{$commentAuthor} added a new comment to the job application for the {$jobApplication->jobOffer->position->name} position.")
            ->line("Comment: {$this->comment->content}")
            ->action('View Job Application', url("/job-applications/{$jobApplication->id}"))
            ->line('Please review and respond if necessary.')
            ->salutation('Best Regards, ' . $companyName);
    }
}
