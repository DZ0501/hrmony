<?php

namespace App\Services;

use App\Models\WorkHour;
use Carbon\Carbon;

class WorkHoursService
{
    public function startWork(int $userId): WorkHour
    {
        $date = Carbon::today()->toDateString();

        return WorkHour::updateOrCreate(
            ['user_id' => $userId, 'date' => $date],
            ['start_time' => Carbon::now()]
        );
    }

    public function endWork(int $userId): WorkHour
    {
        $date = Carbon::today()->toDateString();

        $workHour = WorkHour::where('user_id', $userId)
            ->whereDate('date', $date)
            ->firstOrFail();

        if ($workHour->end_time) {
            throw new \Exception('Workday has already been ended.');
        }

        $workHour->end_time = Carbon::now();
        $workHour->total_hours = round(
            $workHour->start_time->diffInMinutes(Carbon::now()) / 60,
            2
        );
        $workHour->save();

        return $workHour;
    }

    public function getWorkHoursHistory(array $filters = [])
    {
        $query = WorkHour::query();

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('date', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->paginate(10);
    }
}
