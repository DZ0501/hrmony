<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkHour;
use Illuminate\Support\Carbon;

class WorkHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Generate work hours for 3 employees
        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $start = Carbon::now()->subDays(rand(1, 30))->setHour(rand(8, 10))->setMinutes(0);

                $end = (clone $start)->addHours(rand(7, 8))->addMinutes(rand(0, 59));

                $totalHours = round($start->diffInMinutes($end) / 60, 2);
                WorkHour::create([
                    'employee_id' => $i + 7, // Employee IDs start from 8
                    'start' => $start,
                    'end' => $end,
                    'total_hours' => $totalHours,
                ]);
            }
        }
    }
}
