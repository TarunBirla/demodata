<?php

namespace App\Policies;

use App\Models\User;

class StaffPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }

    public function manage(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'hr_manager']);
    }
}
