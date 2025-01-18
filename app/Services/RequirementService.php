<?php

namespace App\Services;

use App\Models\Requirement;
use Illuminate\Database\Eloquent\Collection;

class RequirementService
{
    public function getAllRequirements(array $queryParams): Collection
    {
        $query = Requirement::query();

        if (isset($queryParams['include_tags']) && $queryParams['include_tags'] === 'true') {
            $query->with('tags');
        }

        return $query->get();
    }

    public function getAllRequirementsWithTags(): Collection
    {
        return Requirement::with('tags')->get();
    }

    public function getRequirementById(int $id): Requirement
    {
        return Requirement::with('tags')->findOrFail($id);
    }


    public function createRequirement(array $data): Requirement
    {
        return Requirement::create($data);
    }

    public function updateRequirement(int $id, array $data): Requirement
    {
        $requirement = $this->getRequirementById($id);
        $requirement->update($data);

        return $requirement;
    }

    public function deleteRequirement(int $id): void
    {
        $requirement = $this->getRequirementById($id);
        $requirement->delete();
    }
    public function attachTags(int $id, array $tagIds): Requirement
    {
        $requirement = $this->getRequirementById($id);
        $requirement->tags()->syncWithoutDetaching($tagIds);

        return $requirement->load('tags');
    }

    public function detachTags(int $id, array $tagIds): Requirement
    {
        $requirement = $this->getRequirementById($id);
        $requirement->tags()->detach($tagIds);

        return $requirement->load('tags');
    }
}
