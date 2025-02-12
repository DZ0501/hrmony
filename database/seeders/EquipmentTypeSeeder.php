<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentType;

class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $equipmentTypes = [
            ['name' => 'Electronics', 'description' => 'Electronic devices such as laptops, monitors, and phones.'],
            ['name' => 'Vehicle', 'description' => 'Company vehicles like cars, trucks, or motorbikes.'],
            ['name' => 'Furniture', 'description' => 'Office furniture such as desks, chairs, and cabinets.'],
        ];

        foreach ($equipmentTypes as $type) {
            EquipmentType::create($type);
        }
    }
}
