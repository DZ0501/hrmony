<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentUsage;
use Carbon\Carbon;

class EquipmentUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = Carbon::now();

        EquipmentUsage::create([
            'equipment_id' => 1,
            'user_id' => 5,
            'assigned_at' => $now->subDays(10),
            'returned_at' => $now->subDays(3),
            'status' => 'completed',
        ]);

        EquipmentUsage::create([
            'equipment_id' => 2,
            'user_id' => 6,
            'assigned_at' => $now->subDays(5),
            'returned_at' => null,
            'status' => 'active',
        ]);

        EquipmentUsage::create([
            'equipment_id' => 3,
            'user_id' => 7,
            'assigned_at' => $now->subDays(2),
            'returned_at' => null,
            'status' => 'active',
        ]);
    }
}
