<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            RolesSeeder::class,
            WorkModeSeeder::class,
            WorkScheduleSeeder::class,
            EquipmentTypeSeeder::class,
            PreferenceSeeder::class,
        ]);
    }
}
