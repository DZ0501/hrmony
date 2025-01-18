<?php

namespace Database\Seeders;

use App\Enums\SettingKey;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => SettingKey::COMPANY_NAME->value],
            [
                'value' => 'HRMony',
                'description' => 'The name of the company as displayed in the app and emails.'
            ]
        );
    }
}
