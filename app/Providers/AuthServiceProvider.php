<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Student::class => \App\Policies\StudentPolicy::class,
        \App\Models\Teacher::class => \App\Policies\TeacherPolicy::class,
        \App\Models\StudentAttendance::class => \App\Policies\AttendancePolicy::class,
        \App\Models\StudentFee::class => \App\Policies\FeePolicy::class,
        \App\Models\Exam::class => \App\Policies\ExamPolicy::class,
        \App\Models\Homework::class => \App\Policies\HomeworkPolicy::class,
        \App\Models\Notice::class => \App\Policies\NoticePolicy::class,
        \App\Models\Book::class => \App\Policies\BookPolicy::class,
        \App\Models\Vehicle::class => \App\Policies\TransportPolicy::class,
        \App\Models\Staff::class => \App\Policies\StaffPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
