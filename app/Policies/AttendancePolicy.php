<?php

namespace App\Policies;

use App\Models\User;

class AttendancePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher', 'student', 'parent']);
    }

    public function mark(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher']);
    }

    public function delete(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }
}
