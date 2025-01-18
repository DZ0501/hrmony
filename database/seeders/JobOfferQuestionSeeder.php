<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobOfferQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $jobOffer1 = JobOffer::find(1);
        $jobOffer1->question()->attach([
            1 => ['order' => 1],
            2 => ['order' => 2],
            3 => ['order' => 3],
        ]);

        $jobOffer2 = JobOffer::find(2);
        $jobOffer2->question()->attach([
            4 => ['order' => 1],
            5 => ['order' => 2],
        ]);
    }
}
