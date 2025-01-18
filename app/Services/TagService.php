<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function getAllTags(): Collection
    {
        return Tag::all();
    }

    public function getTagById(int $id): Tag
    {
        return Tag::findOrFail($id);
    }

    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }

    public function updateTag(int $id, array $data): Tag
    {
        $tag = $this->getTagById($id);
        $tag->update($data);

        return $tag;
    }

    public function deleteTag(int $id): void
    {
        $tag = $this->getTagById($id);
        $tag->delete();
    }
}
