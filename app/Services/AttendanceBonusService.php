<?php

namespace App\Services;

use App\Events\AttendanceBonusesCalculated;
use App\Models\AttendanceBonus;
use App\Models\User;

class AttendanceBonusService
{
    public function calculateAndNotify(int $month, int $year, int $requiredWorkHours): void
    {
        $users = User::whereHas('workHours', function ($query) use ($month, $year) {
            $query->whereYear('start_time', $year)
                ->whereMonth('start_time', $month);
        })->get();

        $bonuses = collect();

        foreach ($users as $user) {
            $totalHours = $user->workHours()
                ->whereYear('start_time', $year)
                ->whereMonth('start_time', $month)
                ->sum('total_hours');

            if ($totalHours >= $requiredWorkHours) {
                $bonusAmount = 100; // Fixed bonus amount
                $bonus = AttendanceBonus::updateOrCreate(
                    ['user_id' => $user->id, 'year' => $year, 'month' => $month],
                    ['bonus_amount' => $bonusAmount]
                );
                $bonuses->push($bonus);
            }
        }

        AttendanceBonusesCalculated::dispatch($bonuses);
    }
}
