<?php

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Support\Collection;

class EquipmentService
{
    public function getAllEquipment(array $queryParams): Collection
    {
        $query = Equipment::query();

        if (!empty($queryParams['type'])) {
            $query->where('type', $queryParams['type']);
        }

        if (!empty($queryParams['status'])) {
            $query->where('status', $queryParams['status']);
        }

        return $query->get();
    }

    public function createEquipment(array $data): Equipment
    {
        return Equipment::create($data);
    }

    public function updateEquipment(int $id, array $data): Equipment
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);

        return $equipment;
    }

    public function deleteEquipment(int $id): void
    {
        Equipment::findOrFail($id)->delete();
    }
}
