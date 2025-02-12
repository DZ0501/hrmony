<?php

namespace App\Services;

use App\Models\EquipmentType;

class EquipmentTypeService
{
    public function getAll()
    {
        return EquipmentType::all();
    }

    public function create(array $data): EquipmentType
    {
        return EquipmentType::create($data);
    }

    public function update(int $id, array $data): EquipmentType
    {
        $type = EquipmentType::findOrFail($id);
        $type->update($data);

        return $type;
    }

    public function delete(int $id): bool
    {
        $type = EquipmentType::findOrFail($id);

        return $type->delete();
    }
}
