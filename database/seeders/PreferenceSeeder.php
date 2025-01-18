<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('preferences')->insert([
            ['name' => 'theme', 'description' => 'User interface theme preference.'],
            ['name' => 'email_subscription', 'description' => 'Allows receiving job offer notifications.'],
        ]);

    }
}
