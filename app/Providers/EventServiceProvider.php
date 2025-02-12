<?php

namespace App\Providers;


use App\Events\AttendanceBonusesCalculated;
use App\Events\CompanyUpdatePublished;
use App\Events\EvaluationAssigned;
use App\Events\JobApplicationStatusUpdated;
use App\Events\JobApplicationSubmitted;
use App\Events\NewCommentAdded;
use App\Events\NewRequestSubmitted;
use App\Events\RequestStatusUpdated;
use App\Listeners\AssignFirstUserAsAdminListener;
use App\Listeners\NotifyAttendanceBonusesListener;
use App\Listeners\NotifyTeamOfNewCommentListener;
use App\Listeners\SendCompanyUpdateNotificationListener;
use App\Listeners\SendEvaluationAssignedNotificationListener;
use App\Listeners\SendJobApplicationStatusNotificationListener;
use App\Listeners\SendJobApplicationSubmissionNotificationListener;
use App\Listeners\SendNewRequestNotificationListener;
use App\Listeners\SendPasswordResetLinkListener;
use App\Listeners\SendRequestStatusNotificationListener;
use App\Listeners\SendWelcomeEmailListener;
use App\Listeners\SendJobOfferNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserRegistered;
use App\Events\JobOfferPublished;
use App\Events\PasswordResetRequested;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserRegistered::class => [
            SendWelcomeEmailListener::class,
            AssignFirstUserAsAdminListener::class,
        ],

        PasswordResetRequested::class => [
            SendPasswordResetLinkListener::class,
        ],

        JobOfferPublished::class => [
            SendJobOfferNotificationListener::class,
        ],

        JobApplicationSubmitted::class => [
            SendJobApplicationSubmissionNotificationListener::class,
        ],

        JobApplicationStatusUpdated::class => [
            SendJobApplicationStatusNotificationListener::class,
        ],

        NewCommentAdded::class => [
            NotifyTeamOfNewCommentListener::class,
        ],

        AttendanceBonusesCalculated::class => [
            NotifyAttendanceBonusesListener::class,
        ],

        EvaluationAssigned::class => [
            SendEvaluationAssignedNotificationListener::class,
        ],

        CompanyUpdatePublished::class => [
            SendCompanyUpdateNotificationListener::class,
        ],

        RequestStatusUpdated::class => [
            SendRequestStatusNotificationListener::class,
        ],

        NewRequestSubmitted::class => [
            SendNewRequestNotificationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
