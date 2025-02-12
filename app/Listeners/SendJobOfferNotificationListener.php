<?php

namespace App\Listeners;

use App\Events\JobOfferPublished;
use App\Jobs\SendJobOfferNotificationJob;

class SendJobOfferNotificationListener
{
    public function handle(JobOfferPublished $event): void
    {
        SendJobOfferNotificationJob::dispatch($event->jobOffer);
    }
}
