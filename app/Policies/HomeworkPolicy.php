<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Homework;

class HomeworkPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher', 'student', 'parent']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin', 'teacher']);
    }

    public function update(User $user, Homework $homework): bool
    {
        if (in_array($user->role_name, ['super_admin', 'school_admin'])) {
            return true;
        }

        if ($user->role_name === 'teacher') {
            $teacherObj = $user->teacher ?? \App\Models\Teacher::where('user_id', $user->id)->first();
            $teacherIds = array_filter([$user->id, $teacherObj?->id]);
            return in_array($homework->teacher_id, $teacherIds);
        }

        return false;
    }

    public function delete(User $user, Homework $homework): bool
    {
        return $this->update($user, $homework);
    }
}
