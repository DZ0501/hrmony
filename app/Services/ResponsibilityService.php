<?php

namespace App\Services;

use App\Models\Responsibility;
use Illuminate\Database\Eloquent\Collection;

class ResponsibilityService
{
    public function getAllResponsibilities(array $queryParams): Collection
    {
        $query = Responsibility::query();

        if (isset($queryParams['include_tags']) && $queryParams['include_tags'] === 'true') {
            $query->with('tags');
        }

        return $query->get();
    }


    public function getResponsibilityById(int $id): Responsibility
    {
        return Responsibility::findOrFail($id);
    }

    public function createResponsibility(array $data): Responsibility
    {
        return Responsibility::create($data);
    }

    public function updateResponsibility(int $id, array $data): Responsibility
    {
        $responsibility = $this->getResponsibilityById($id);
        $responsibility->update($data);

        return $responsibility;
    }

    public function deleteResponsibility(int $id): void
    {
        $responsibility = $this->getResponsibilityById($id);
        $responsibility->delete();
    }
    public function attachTags(int $id, array $tagIds): Responsibility
    {
        $responsibility = $this->getResponsibilityById($id);
        $responsibility->tags()->syncWithoutDetaching($tagIds);

        return $responsibility->load('tags');
    }

    public function detachTags(int $id, array $tagIds): Responsibility
    {
        $responsibility = $this->getResponsibilityById($id);
        $responsibility->tags()->detach($tagIds);

        return $responsibility->load('tags');
    }

}
