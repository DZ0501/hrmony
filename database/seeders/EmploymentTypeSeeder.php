<?php

namespace Database\Seeders;

use App\Models\EmploymentType;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
    {
        $types = ['Employment Contract', 'Contract of Mandate', 'B2B', 'Internship'];

        foreach ($types as $type) {
            EmploymentType::create(['name' => $type]);
        }
    }
}
