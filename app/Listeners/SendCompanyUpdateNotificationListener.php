<?php

namespace App\Listeners;

use App\Events\CompanyUpdatePublished;
use App\Jobs\SendCompanyUpdateNotificationJob;

class SendCompanyUpdateNotificationListener
{
    public function __construct() {}

    public function handle(CompanyUpdatePublished $event)
    {
        dispatch(new SendCompanyUpdateNotificationJob($event->update));
    }
}
