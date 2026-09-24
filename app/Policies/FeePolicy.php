<?php

namespace App\Policies;

use App\Models\User;

class FeePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'accountant', 'student', 'parent']);
    }

    public function collect(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'accountant']);
    }

    public function manageStructure(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'accountant']);
    }

    public function deletePayment(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }
}
