<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\HandlesRelationships;

class PositionService
{
    use HandlesRelationships;
    public function getAllPositions(): Collection
    {
        return Position::all();
    }

    public function getPositionById(int $id, array $queryParams = []): Position
    {
        $query = Position::query();

        $this->applyRelationships($query, $queryParams);

        return $query->findOrFail($id);
    }

    public function createPosition(array $data): Position
    {
        return Position::create($data);
    }

    public function updatePosition(int $id, array $data): Position
    {
        $position = $this->getPositionById($id);
        $position->update($data);

        return $position;
    }

    public function deletePosition(int $id): void
    {
        $position = $this->getPositionById($id);
        $position->delete();
    }

    public function syncResponsibilities(Position $position, array $responsibilityIds): void
    {
        $position->responsibilities()->sync($responsibilityIds);
    }

    public function syncRequirements(Position $position, array $requirementIds): void
    {
        $position->requirements()->sync($requirementIds);
    }

}
