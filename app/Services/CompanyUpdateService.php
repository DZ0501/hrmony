<?php

namespace App\Services;

use App\Events\CompanyUpdatePublished;
use App\Models\CompanyUpdate;
use App\Traits\HandlesRelationships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class CompanyUpdateService
{
    use HandlesRelationships;
    public function getAllUpdates(array $queryParams = []): Collection
    {
        $query = CompanyUpdate::query();

        $this->applyRelationships($query, $queryParams);

        $query->when(
            isset($queryParams['published']),
            fn($q) => $q->where('published', filter_var($queryParams['published'], FILTER_VALIDATE_BOOLEAN))
        );

        return $query->get();
    }


    public function getUpdateById(int $id): CompanyUpdate
    {
        return CompanyUpdate::with('tags')->findOrFail($id);
    }

    public function createUpdate(array $data): CompanyUpdate
    {
        $data['created_by'] = Auth::id();

        return CompanyUpdate::create($data);
    }

    public function updateUpdate(int $id, array $data): CompanyUpdate
    {
        $update = CompanyUpdate::findOrFail($id);

        $update->update($data);

        return $update;
    }

    public function deleteUpdate(int $id): void
    {
        CompanyUpdate::findOrFail($id)->delete();
    }

    public function attachTags(int $id, array $tagIds): CompanyUpdate
    {
        $update = $this->getUpdateById($id);
        $update->tags()->syncWithoutDetaching($tagIds);

        return $update->load('tags');
    }

    public function detachTags(int $id, array $tagIds): CompanyUpdate
    {
        $update = $this->getUpdateById($id);
        $update->tags()->detach($tagIds);

        return $update->load('tags');
    }


    public function publishUpdate(int $id): CompanyUpdate
    {
        $update = CompanyUpdate::findOrFail($id);

        if ($update->published) {
            return $update;
        }

        $update->update(['published' => true]);

        CompanyUpdatePublished::dispatch($update);

        return $update;
    }

}
