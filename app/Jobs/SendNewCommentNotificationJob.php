<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewCommentNotificationJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function handle()
    {
        $jobApplication = $this->comment->jobApplication;

        // Notify all team members except the comment author
        $teamMembers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['hr_employee', 'department_head']);
        })->where('id', '!=', $this->comment->user_id)->get();

        foreach ($teamMembers as $teamMember) {
            $teamMember->notify(new NewCommentNotification($this->comment));
        }
    }
}
