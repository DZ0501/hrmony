<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            TagSeeder::class,
            RolesSeeder::class,
            UserSeeder::class,
            UserDetailSeeder::class,
            PreferenceSeeder::class,
            PreferenceUserSeeder::class,
            QuestionSeeder::class,
            PositionSeeder::class,
            EmploymentTypeSeeder::class,
            WorkModeSeeder::class,
            WorkScheduleSeeder::class,
            JobOfferSeeder::class,
            JobOfferQuestionSeeder::class,
            JobApplicationSeeder::class,
            JobApplicationAnswerSeeder::class,
            RequestSeeder::class,
            WorkHourSeeder::class,
            CompanyUpdateSeeder::class,
            RequirementSeeder::class,
            ResponsibilitySeeder::class,
        ]);

    }
}
