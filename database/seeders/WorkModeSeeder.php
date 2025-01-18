<?php

namespace Database\Seeders;

use App\Models\WorkMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $workModes = [
            ['name' => 'On-site'],
            ['name' => 'Remote'],
            ['name' => 'Hybrid'],
        ];

        foreach ($workModes as $workMode) {
            WorkMode::create($workMode);
        }
    }
}
