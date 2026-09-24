<?php

namespace App\Policies;

use App\Models\User;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }

    public function view(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }

    public function update(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }

    public function delete(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }
}
