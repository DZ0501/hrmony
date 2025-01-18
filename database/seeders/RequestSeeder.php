<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Request;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            Request::create([
                'employee_id' => $i + 7,
                'request_type' => ['leave', 'equipment', 'personal_info_update'][rand(0, 2)],
                'stage' => 'submitted',
                'details' => "Employee$i submitted a request.",
            ]);
        }
    }
}
