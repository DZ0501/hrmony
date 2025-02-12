<?php

namespace Database\Seeders;

use App\Models\Request;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $validTypes = ['leave', 'remote_work', 'personal_data_change', 'equipment_request'];

        for ($i = 1; $i <= 3; $i++) {
            Request::create([
                'user_id' => $i + 7,
                'type' => $validTypes[array_rand($validTypes)], // Ensure a valid type
                'status' => 'pending',
                'details' => json_encode([
                    'reason' => "Request details for Employee $i",
                    'requested_at' => now()->toDateTimeString(),
                ]),
            ]);
        }
    }
}
