<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = [
            ['name' => 'Software Developer', 'description' => 'Develop and maintain software.'],
            ['name' => 'Marketing Specialist', 'description' => 'Plan and execute marketing campaigns.'],
            ['name' => 'Graphic Designer', 'description' => 'Create designs for various projects.'],
            ['name' => 'Project Manager', 'description' => 'Oversee project planning and execution.'],
            ['name' => 'Data Analyst', 'description' => 'Analyze data to support business decisions.'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
