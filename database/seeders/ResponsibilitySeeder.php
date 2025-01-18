<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Responsibility;


class ResponsibilitySeeder extends Seeder
{
    public function run()
    {
        $responsibilities = [
            ['name' => 'Develop and maintain web applications'],
            ['name' => 'Optimize application performance'],
            ['name' => 'Plan and execute marketing campaigns'],
            ['name' => 'Analyze marketing performance metrics'],
            ['name' => 'Design promotional materials (flyers, posters, etc.)'],
            ['name' => 'Create digital assets for online campaigns'],
            ['name' => 'Maintain code quality and standards'],
            ['name' => 'Troubleshoot application issues'],
            ['name' => 'Collaborate with product teams'],
            ['name' => 'Manage social media platforms'],
            ['name' => 'Write technical documentation'],
            ['name' => 'Perform user research'],
            ['name' => 'Conduct A/B testing for campaigns'],
            ['name' => 'Create wireframes for UI designs'],
            ['name' => 'Design brand logos and assets'],
            ['name' => 'Monitor campaign ROI'],
            ['name' => 'Prepare reports on project progress'],
            ['name' => 'Assist in user onboarding processes'],
            ['name' => 'Provide support for technical queries'],
            ['name' => 'Review deliverables for quality assurance'],
        ];

        foreach ($responsibilities as $responsibility) {
            Responsibility::create($responsibility);
        }

        $developer = Position::where('name', 'Software Developer')->first();
        $marketing = Position::where('name', 'Marketing Specialist')->first();
        $designer = Position::where('name', 'Graphic Designer')->first();

        $developer->responsibilities()->sync([1, 2, 7, 8, 11]);
        $marketing->responsibilities()->sync([3, 4, 10, 13, 16]);
        $designer->responsibilities()->sync([5, 6, 14, 15, 17]);
    }
}
