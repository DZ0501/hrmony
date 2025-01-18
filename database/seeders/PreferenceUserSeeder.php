<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Preference;

class PreferenceUserSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $preferences = Preference::all();

        foreach ($users as $user) {
            foreach ($preferences as $preference) {
                $user->preferences()->attach($preference->id, [
                    'value' => $this->getPreferenceValue($preference->name),
                ]);
            }
        }
    }

    private function getPreferenceValue(string $preferenceName): string
    {
        return match ($preferenceName) {
            'theme' => 'light',
            'email_subscription' => 'no',
            default => '',
        };
    }
}
