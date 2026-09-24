<?php

namespace App\Policies;

use App\Models\User;

class NoticePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher', 'hr_manager', 'librarian', 'transport_manager']);
    }

    public function update(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }

    public function delete(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }
}
