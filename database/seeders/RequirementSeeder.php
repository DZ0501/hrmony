<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use App\Models\Requirement;



class RequirementSeeder extends Seeder
{
    public function run()
    {
        $requirements = [
            ['name' => 'Proficiency in PHP and Laravel'],
            ['name' => 'Experience with JavaScript frameworks'],
            ['name' => 'Experience in digital marketing'],
            ['name' => 'Knowledge of Google Analytics and SEO'],
            ['name' => 'Proficiency in Adobe Creative Suite'],
            ['name' => 'Strong portfolio of graphic design work'],
            ['name' => 'Familiarity with RESTful APIs'],
            ['name' => 'Ability to lead a team effectively'],
            ['name' => 'Excellent written and verbal communication'],
            ['name' => 'Strong analytical skills'],
            ['name' => 'Understanding of Agile methodologies'],
            ['name' => 'Experience with database systems'],
            ['name' => 'Knowledge of UX/UI principles'],
            ['name' => 'Creative problem-solving skills'],
            ['name' => 'Proficiency in HTML/CSS'],
            ['name' => 'Ability to manage multiple projects'],
            ['name' => 'Knowledge of campaign tracking tools'],
            ['name' => 'Familiarity with version control systems'],
            ['name' => 'Ability to collaborate across teams'],
            ['name' => 'Excellent attention to detail'],
        ];

        foreach ($requirements as $requirement) {
            Requirement::create($requirement);
        }

        $developer = Position::where('name', 'Software Developer')->first();
        $marketing = Position::where('name', 'Marketing Specialist')->first();
        $designer = Position::where('name', 'Graphic Designer')->first();

        $developer->requirements()->sync([1, 2, 7, 11, 12]);
        $marketing->requirements()->sync([3, 4, 10, 13, 16]);
        $designer->requirements()->sync([5, 6, 14, 15, 20]);
    }
}
