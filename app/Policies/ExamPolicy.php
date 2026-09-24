<?php

namespace App\Policies;

use App\Models\User;

class ExamPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher', 'student', 'parent']);
    }

    public function manageExam(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }

    public function enterMarks(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher']);
    }
}
