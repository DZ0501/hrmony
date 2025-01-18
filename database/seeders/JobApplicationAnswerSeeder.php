<?php

namespace Database\Seeders;

use App\Models\JobApplicationAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobApplicationAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            JobApplicationAnswer::create([
                'job_application_id' => 1,
                'question_id' => $i,
                'user_id' => 5,
                'answer' => "Sample answer for Question $i",
            ]);
        }


        for ($i = 6; $i <= 10; $i++) {
            JobApplicationAnswer::create([
                'job_application_id' => 2,
                'question_id' => $i,
                'user_id' => 6,
                'answer' => "Sample answer for Question $i",
            ]);
        }

        for ($i = 11; $i <= 15; $i++) {
            JobApplicationAnswer::create([
                'job_application_id' => 3,
                'question_id' => $i,
                'user_id' => 7,
                'answer' => "Sample answer for Question $i",
            ]);
        }
    }
}
