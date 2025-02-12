<?php

namespace Database\Seeders;

use App\Models\WorkHour;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WorkHourSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $dates = [];

            for ($j = 1; $j <= 5; $j++) {
                do {
                    $date = Carbon::now()->subDays(rand(1, 30))->toDateString();
                } while (in_array($date, $dates));

                $dates[] = $date;

                $start = Carbon::parse($date)->setHour(rand(8, 10))->setMinute(0);
                $end = (clone $start)->addHours(rand(7, 8))->addMinutes(rand(0, 59));
                $totalHours = round($start->diffInMinutes($end) / 60, 2);

                WorkHour::create([
                    'user_id' => $i + 7,
                    'date' => $date,
                    'start_time' => $start,
                    'end_time' => $end,
                    'total_hours' => $totalHours,
                ]);
            }
        }
    }
}
