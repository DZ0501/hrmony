<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\EquipmentType;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get the IDs of predefined equipment types
        $electronicsType = EquipmentType::where('name', 'Electronics')->firstOrFail()->id;
        $vehicleType = EquipmentType::where('name', 'Vehicle')->firstOrFail()->id;

        $equipmentData = [
            [
                'name' => 'Laptop HP EliteBook 850',
                'serial_number' => 'ABC123456',
                'equipment_type_id' => $electronicsType,
                'purchase_date' => '2022-01-15',
                'warranty_until' => '2025-01-15',
                'status' => 'available',
            ],
            [
                'name' => 'Dell Monitor 27-inch',
                'serial_number' => 'DEF654321',
                'equipment_type_id' => $electronicsType,
                'purchase_date' => '2023-03-01',
                'warranty_until' => '2026-03-01',
                'status' => 'assigned',
            ],
            [
                'name' => 'Company Car - Toyota Corolla',
                'serial_number' => 'XYZ987654',
                'equipment_type_id' => $vehicleType,
                'purchase_date' => '2020-05-10',
                'warranty_until' => '2025-05-10',
                'status' => 'under_maintenance',
            ],
        ];

        foreach ($equipmentData as $equipment) {
            Equipment::create($equipment);
        }
    }
}
