<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            JobApplication::create([
                'user_id' => $i + 4,
                'reviewer_id' => rand(2, 3),
                'job_offer_id' => rand(1, 2),
                'stage' => 'hr_review',
                'decision' => 'pending',
            ]);
        }
    }
}
