<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define roles
        $roles = [
            'candidate' => [
                'view job offers',
                'submit application',
                'view application status',
            ],
            'employee' => [
                'view job offers',
                'view personal details',
                'submit request',
                'view request status',
                'view monthly work hours',
                'check attendance bonus',
            ],
            'chief_of_department' => [
                'view assigned job applications',
                'provide application feedback',
                'approve or reject candidates',
                'view department employee details',
                'approve or reject department requests',
            ],
            'hr_employee' => [
                'view all job applications',
                'modify job applications',
                'assign reviewers',
                'add job offers',
                'edit job offers',
                'provide candidate feedback',
                'mark application stages as completed',
                'view all employee details',
            ],
            'administrator' => [
                'manage roles and permissions',
                'view all job offers',
                'manage all job offers',
                'manage users',
            ],
        ];

        // Create roles and assign permissions
        foreach ($roles as $role => $permissions) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);

            foreach ($permissions as $permission) {
                $permissionInstance = Permission::where('name', $permission)->first();
                $roleInstance->givePermissionTo($permissionInstance);
            }
        }
    }
}
