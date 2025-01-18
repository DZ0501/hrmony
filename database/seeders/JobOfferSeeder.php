<?php

namespace Database\Seeders;

use App\Models\EmploymentType;
use App\Models\JobOffer;
use App\Models\Position;
use App\Models\WorkMode;
use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    public function run()
    {
        $developer = Position::where('name', 'Software Developer')->first();
        $marketing = Position::where('name', 'Marketing Specialist')->first();

        $employmentContract = EmploymentType::where('name', 'Employment Contract')->first();
        $b2b = EmploymentType::where('name', 'B2B')->first();
        $contractOfMandate = EmploymentType::where('name', 'Contract of Mandate')->first();
        $internship = EmploymentType::where('name', 'Internship')->first();

        $fullTime = WorkSchedule::where('name', 'Full-time')->first();
        $onSite = WorkMode::where('name', 'On-site')->first();


        $offer1 = JobOffer::create([
            'position_id' => $developer->id,
            'offered_salary_min' => 4000,
            'offered_salary_max' => 6000,
            'job_location' => 'Krakow, Poland',
            'published' => true,
            'created_by' => 1,
        ]);

        $offer1->employmentTypes()->attach([$employmentContract->id, $b2b->id]);
        $offer1->workSchedules()->attach($fullTime->id);
        $offer1->workModes()->attach($onSite->id);

        $offer2 = JobOffer::create([
            'position_id' => $marketing->id,
            'offered_salary_min' => 2000,
            'offered_salary_max' => 3000,
            'job_location' => 'Wadowice, Poland',
            'published' => true,
            'created_by' => 1,
        ]);

        $offer2->employmentTypes()->attach([$contractOfMandate->id, $internship->id]);
        $offer2->workSchedules()->attach($fullTime->id);
        $offer2->workModes()->attach($onSite->id);
    }
}
