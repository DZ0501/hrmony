<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserRegistered;
use App\Jobs\AssignAdminRoleJob;

class AssignFirstUserAsAdminListener
{
    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        if (User::count() === 1) {
            AssignAdminRoleJob::dispatch($event->user);
        }
    }
}
