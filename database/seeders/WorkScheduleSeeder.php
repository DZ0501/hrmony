<?php

namespace Database\Seeders;

use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;

class WorkScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $workSchedules = [
            ['name' => 'Full-time'],
            ['name' => 'Part-time'],
            ['name' => 'Flexible'],
        ];

        foreach ($workSchedules as $workSchedule) {
            WorkSchedule::create($workSchedule);
        }
    }
}
