<?php

namespace App\Services;

use App\Events\JobApplicationStatusUpdated;
use App\Events\JobApplicationSubmitted;
use App\Events\NewCommentAdded;
use App\Models\JobApplication;
use App\Models\JobApplicationAnswer;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JobApplicationService
{
    public function checkIfAlreadyApplied(int $userId, int $jobOfferId): void
    {
        $existingApplication = JobApplication::where('user_id', $userId)
            ->where('job_offer_id', $jobOfferId)
            ->exists();

        if ($existingApplication) {
            throw new \Exception('You have already applied for this job offer.');
        }
    }

    public function createApplication(User $user, array $validatedData): JobApplication
    {
        $jobApplication = JobApplication::create([
            'user_id' => $user->id,
            'job_offer_id' => $validatedData['job_offer_id'], // Update if job_offer_id is used
            'stage' => 'hr_review',
            'decision' => 'pending',
        ]);

        event(new JobApplicationSubmitted($jobApplication));

        return $jobApplication;
    }


    public function saveAnswers(JobApplication $jobApplication, array $answers): void
    {
        foreach ($answers as $answer) {
            JobApplicationAnswer::create([
                'job_application_id' => $jobApplication->id,
                'question_id' => $answer['question_id'],
                'user_id' => $jobApplication->user_id,
                'answer' => $answer['answer'],
            ]);
        }
    }

    public function getApplicationsByUser(int $userId)
    {
        return JobApplication::with(['jobOffer', 'answers'])
            ->where('user_id', $userId)
            ->get();
    }

    public function addComment(int $jobApplicationId, int $userId, string $content): Comment
    {
        $comment = Comment::create([
            'job_application_id' => $jobApplicationId,
            'user_id' => $userId,
            'content' => $content,
        ]);

        event(new NewCommentAdded($comment));

        return $comment;
    }

    public function getComments(int $jobApplicationId)
    {
        return Comment::where('job_application_id', $jobApplicationId)
            ->with('user:id,firstname,surname')
            ->get();
    }

    public function updateStageOrDecision(int $jobApplicationId, array $data): JobApplication
    {
        $jobApplication = JobApplication::findOrFail($jobApplicationId);

        if (isset($data['stage'])) {
            $jobApplication->stage = $data['stage'];
        }

        if (isset($data['decision'])) {
            $jobApplication->decision = $data['decision'];

            if (in_array($data['decision'], ['passed', 'rejected'])) {
                event(new JobApplicationStatusUpdated($jobApplication, $data['decision']));
            }
        }

        $jobApplication->save();

        return $jobApplication;
    }

    public function updateReviewer(int $jobApplicationId, int $reviewerId): JobApplication
    {
        $jobApplication = JobApplication::findOrFail($jobApplicationId);

        $reviewer = User::findOrFail($reviewerId);

        if ($jobApplication->stage === 'hr_review') {
            if (!$reviewer->roles()->where('name', 'hr_employee')->exists()) {
                throw new \Exception('Reviewer must have the HR Employee role.');
            }
        } elseif ($jobApplication->stage === 'department_head_review') {
            if (!$reviewer->roles()->where('name', 'chief_of_department')->exists()) {
                throw new \Exception('Reviewer must have the Head of Department role.');
            }
        } else {
            throw new \Exception('Invalid stage for assigning a reviewer.');
        }

        $jobApplication->reviewer_id = $reviewerId;
        $jobApplication->save();

        return $jobApplication;
    }

    public function getApplicationById(int $id)
    {
        return JobApplication::with(['jobOffer', 'answers.question', 'comments.user'])
            ->findOrFail($id);
    }

    public function getAllJobApplicationsForExport()
    {
        return JobApplication::with([
            'user:id,firstname,email',
            'answers.question:id,name',
            'comments.user:id,name',
            'jobOffer:id,position_id,offered_salary_min,offered_salary_max,job_location',
            'jobOffer.position:id,name',
        ])->get()->map(function ($jobApplication) {
            return [
                'candidate' => [
                    'id' => $jobApplication->user->id,
                    'name' => $jobApplication->user->firstname,
                    'email' => $jobApplication->user->email,
                ],
                'job_offer' => [
                    'id' => $jobApplication->jobOffer->id,
                    'position' => $jobApplication->jobOffer->position->name,
                    'salary_range' => "$" . $jobApplication->jobOffer->offered_salary_min . " - $" . $jobApplication->jobOffer->offered_salary_max,
                    'location' => $jobApplication->jobOffer->job_location,
                ],
                'answers' => $jobApplication->answers->map(function ($answer) {
                    return [
                        'question' => $answer->question->name,
                        'answer' => $answer->answer,
                    ];
                }),
                'comments' => $jobApplication->comments->map(function ($comment) {
                    return [
                        'content' => $comment->content,
                        'reviewer' => $comment->user->name ?? null,
                    ];
                }),
                'status' => [
                    'stage' => $jobApplication->stage,
                    'decision' => $jobApplication->decision,
                ],
            ];
        });
    }


}
