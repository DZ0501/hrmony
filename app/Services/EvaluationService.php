<?php

namespace App\Services;

use App\Events\EvaluationAssigned;
use App\Models\Evaluation;
use App\Models\EvaluationAnswer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class EvaluationService
{
    public function ensureUserHasDetails(?User $user): void
    {
        if (!$user || !$user->userDetails) {
            throw new Exception('User details not found.');
        }
    }

    public function isManager(int $userId): bool
    {
        return User::whereHas('userDetails', function ($query) use ($userId) {
            $query->where('manager_id', $userId);
        })->exists();
    }

    private function ensureUserCanAnswerEvaluation(Evaluation $evaluation, int $userId): void
    {
        if (!in_array($userId, [$evaluation->user_id, $evaluation->evaluator_id])) {
            throw new Exception('You are not authorized to answer this evaluation.');
        }
    }

    public function bulkCreateEvaluations(int $quarter, int $year): Collection
    {
        return DB::transaction(function () use ($quarter, $year) {
            $evaluations = collect();

            // Self Evaluations
            User::all()->each(function ($user) use ($quarter, $year, &$evaluations) {
                $evaluation = Evaluation::create([
                    'user_id' => $user->id,
                    'evaluator_id' => $user->id,
                    'quarter' => $quarter,
                    'year' => $year,
                    'type' => 'self',
                    'finalized' => false,
                ]);
                event(new EvaluationAssigned($evaluation));
                $evaluations->push($evaluation);
            });

            // Manager Evaluations
            User::whereHas('userDetails', function ($query) {
                $query->whereNotNull('manager_id');
            })->get()->each(function ($user) use ($quarter, $year, &$evaluations) {
                $evaluation = Evaluation::create([
                    'user_id' => $user->id,
                    'evaluator_id' => $user->userDetails->manager_id,
                    'quarter' => $quarter,
                    'year' => $year,
                    'type' => 'manager',
                    'finalized' => false,
                ]);
                event(new EvaluationAssigned($evaluation));
                $evaluations->push($evaluation);
            });

            return $evaluations;
        });
    }

    public function getEvaluationsForUser(int $userId, bool $isManager, array $filters): Collection
    {
        return Evaluation::where(function ($query) use ($userId, $isManager) {
            $isManager
                ? $query->where('evaluator_id', $userId)->where('type', 'manager')
                : $query->where('user_id', $userId)->where('type', 'self');
        })
            ->when(isset($filters['finalized']), function ($query) use ($filters) {
                $query->where('finalized', filter_var($filters['finalized'], FILTER_VALIDATE_BOOLEAN));
            })
            ->get();
    }

    public function getEvaluationDetails(int $evaluationId, int $userId, bool $isManager): Evaluation
    {
        return Evaluation::with('answers')->where(function ($query) use ($userId, $isManager) {
            $isManager
                ? $query->where('evaluator_id', $userId)
                : $query->where('user_id', $userId);
        })->findOrFail($evaluationId);
    }

    public function answerEvaluation(int $evaluationId, array $data): Collection
    {
        return DB::transaction(function () use ($evaluationId, $data) {
            $evaluation = Evaluation::findOrFail($evaluationId);
            $userId = auth()->id();

            $this->ensureUserCanAnswerEvaluation($evaluation, $userId);

            $requiredQuestions = Question::where('type', 'evaluation')->pluck('id')->toArray();
            $providedQuestions = collect($data['answers'])->pluck('question_id')->toArray();

            if (array_diff($requiredQuestions, $providedQuestions)) {
                throw new Exception('All evaluation questions must be answered.');
            }

            $answers = collect();
            foreach ($data['answers'] as $answer) {
                $answers->push(EvaluationAnswer::updateOrCreate(
                    [
                        'evaluation_id' => $evaluationId,
                        'question_id' => $answer['question_id'],
                        'user_id' => $userId,
                    ],
                    [
                        'rating' => $answer['rating'],
                        'comment' => $answer['comment'] ?? null,
                    ]
                ));
            }

            $evaluation->update(['finalized' => true]);

            return $answers;
        });
    }

    public function compareEvaluations(int $userId): array
    {
        $selfEvaluation = Evaluation::with('answers.question')
            ->where('user_id', $userId)
            ->where('type', 'self')
            ->where('finalized', true)
            ->first();

        $managerEvaluation = Evaluation::with('answers.question')
            ->where('user_id', $userId)
            ->where('type', 'manager')
            ->where('finalized', true)
            ->first();

        if (!$selfEvaluation || !$managerEvaluation) {
            throw new Exception('Both self and manager evaluations must be finalized for comparison.');
        }

        $comparison = $selfEvaluation->answers->map(function ($answer) use ($managerEvaluation) {
            $managerAnswer = $managerEvaluation->answers->firstWhere('question_id', $answer->question_id);

            return [
                'question' => $answer->question->name,
                'self_rating' => $answer->rating,
                'self_comment' => $answer->comment,
                'manager_rating' => $managerAnswer->rating ?? null,
                'manager_comment' => $managerAnswer->comment ?? null,
            ];
        })->values();

        return [
            'user_id' => $userId,
            'self_evaluation' => $selfEvaluation,
            'manager_evaluation' => $managerEvaluation,
            'comparison' => $comparison,
        ];
    }
}
