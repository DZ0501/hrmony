<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentUsage;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class EquipmentUsageService
{
    public function getUsage(int $equipmentId): Collection
    {
        return EquipmentUsage::where('equipment_id', $equipmentId)
            ->with('user:id,firstname,surname')
            ->get();
    }

    public function assignEquipment(int $equipmentId, int $userId): EquipmentUsage
    {
        $equipment = Equipment::findOrFail($equipmentId);

        if ($equipment->status !== 'available') {
            throw new \Exception('Equipment is not available for assignment.');
        }

        $equipment->update(['status' => 'assigned']);

        return EquipmentUsage::create([
            'equipment_id' => $equipmentId,
            'user_id' => $userId,
            'assigned_at' => Carbon::now(),
            'status' => 'active',
        ]);
    }

    public function returnEquipment(int $equipmentId): EquipmentUsage
    {
        $usage = EquipmentUsage::where('equipment_id', $equipmentId)
            ->where('status', 'active')
            ->firstOrFail();

        $usage->update([
            'returned_at' => Carbon::now(),
            'status' => 'completed',
        ]);

        Equipment::findOrFail($equipmentId)->update(['status' => 'available']);

        return $usage;
    }
}
