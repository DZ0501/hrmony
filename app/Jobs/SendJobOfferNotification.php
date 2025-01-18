<?php

namespace App\Jobs;

use App\Models\JobOffer;
use App\Models\User;
use App\Notifications\NewJobOfferNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendJobOfferNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 10;
    public JobOffer $jobOffer;

    public function __construct(JobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer;
    }

    public function handle()
    {
        $users = User::whereHas('userPreferences', function ($query) {
            $query->where('key', 'email_subscription')
                ->where('value', 'yes');
        })->whereNotNull('email_verified')->get();

        foreach ($users as $user) {
            $user->notify(new NewJobOfferNotification($this->jobOffer));
        }
    }
}
