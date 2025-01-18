<?php

namespace App\Listeners;

use App\Events\JobOfferPublished;
use App\Jobs\SendJobOfferNotification;

class SendJobOfferNotificationListener
{
    public function handle(JobOfferPublished $event): void
    {
        SendJobOfferNotification::dispatch($event->jobOffer);
    }
}
