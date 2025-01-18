<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    public function getAllQuestions(array $queryParams): Collection
    {
        $query = Question::query();

        if (isset($queryParams['include_tags']) && $queryParams['include_tags'] === 'true') {
            $query->with('tags');
        }

        return $query->get();
    }

    public function getQuestionById(int $id): Question
    {
        return Question::findOrFail($id);
    }

    public function createQuestion(array $data): Question
    {
        return Question::create($data);
    }

    public function updateQuestion(int $id, array $data): Question
    {
        $question = $this->getQuestionById($id);
        $question->update($data);

        return $question;
    }

    public function deleteQuestion(int $id): void
    {
        $question = $this->getQuestionById($id);
        $question->delete();
    }

    public function attachTags(int $id, array $tagIds): Question
    {
        $question = $this->getQuestionById($id);
        $question->tags()->syncWithoutDetaching($tagIds);

        return $question->load('tags');
    }

    public function detachTags(int $id, array $tagIds): Question
    {
        $question = $this->getQuestionById($id);
        $question->tags()->detach($tagIds);

        return $question->load('tags');
    }

}
