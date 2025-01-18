<?php

namespace App\Services;

use App\Events\JobOfferPublished;
use App\Models\JobOffer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class JobOfferService
{
    public function createJobOffer(array $data): JobOffer
    {
        return DB::transaction(function () use ($data) {
            $jobOffer = JobOffer::create([
                'position_id' => $data['position_id'],
                'offered_salary_min' => $data['offered_salary_min'],
                'offered_salary_max' => $data['offered_salary_max'],
                'job_location' => $data['job_location'],
                'published' => $data['published'],
                'created_by' => $data['created_by'],
            ]);

            $jobOffer->employmentTypes()->sync($data['employment_type_ids']);
            $jobOffer->workModes()->sync($data['work_mode_ids']);
            $jobOffer->workSchedules()->sync($data['work_schedule_ids']);

            return $jobOffer;
        });
    }


    public function publishJobOffer(JobOffer $jobOffer): void
    {
        $jobOffer->update(['published' => true]);

        JobOfferPublished::dispatch($jobOffer);
    }

    public function updateJobOffer(int $id, array $data): JobOffer
    {
        return DB::transaction(function () use ($id, $data) {
            $jobOffer = JobOffer::findOrFail($id);

            if ($jobOffer->published) {
                throw ValidationException::withMessages([
                    'published' => ['Published job offers cannot be updated.'],
                ]);
            }

            $jobOffer->update([
                'position_id' => $data['position_id'] ?? $jobOffer->position_id,
                'offered_salary_min' => $data['offered_salary_min'] ?? $jobOffer->offered_salary_min,
                'offered_salary_max' => $data['offered_salary_max'] ?? $jobOffer->offered_salary_max,
                'job_location' => $data['job_location'] ?? $jobOffer->job_location,
                'published' => $data['published'] ?? $jobOffer->published,
            ]);

            if (isset($data['employment_type_ids'])) {
                $jobOffer->employmentTypes()->sync($data['employment_type_ids']);
            }

            if (isset($data['work_mode_ids'])) {
                $jobOffer->workModes()->sync($data['work_mode_ids']);
            }

            if (isset($data['work_schedule_ids'])) {
                $jobOffer->workSchedules()->sync($data['work_schedule_ids']);
            }

            $wasNotPublished = !$jobOffer->published && ($data['published'] ?? false);

            if ($wasNotPublished) {
                JobOfferPublished::dispatch($jobOffer);
            }

            return $jobOffer;
        });
    }
    public function deleteJobOffer(int $id): void
    {
        $jobOffer = JobOffer::findOrFail($id);
        $jobOffer->delete();
    }

    public function getJobOffer(int $id): JobOffer
    {
        $query = JobOffer::query();

        $query->with(['position.responsibilities', 'position.requirements', 'employmentTypes']);

        if (auth()->user()->hasRole(['candidate', 'hr_employee', 'administrator'])) {
            $query->with('questions');
        }

        return $query->findOrFail($id);
    }

    public function getAllJobOffers(): Collection
    {
        return JobOffer::with(['position', 'employmentTypes', 'workSchedules', 'workModes'])
            ->where('published', true)
            ->get();
    }
}
