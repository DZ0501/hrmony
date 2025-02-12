<?php

namespace App\Jobs;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignAdminRoleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        $adminRole = Role::where('name', 'administrator')->first();

        if ($adminRole) {
            $this->user->syncRoles([$adminRole]);
        }
    }
}

