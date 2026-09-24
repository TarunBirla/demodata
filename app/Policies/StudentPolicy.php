<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_name, [
            'super_admin', 'school_admin', 'teacher', 'student',
            'parent', 'accountant', 'librarian', 'transport_manager', 'hr_manager'
        ]);
    }

    public function view(User $user, Student $student): bool
    {
        if (in_array($user->role_name, ['super_admin', 'school_admin', 'accountant', 'librarian', 'transport_manager', 'hr_manager'])) {
            return true;
        }

        if ($user->role_name === 'student') {
            return $student->user_id === $user->id;
        }

        if ($user->role_name === 'parent') {
            $parentProfile = $user->parentProfile;
            $parentStudentIds = $parentProfile ? $parentProfile->students()->pluck('students.id')->toArray() : [];
            return in_array($student->id, $parentStudentIds);
        }

        if ($user->role_name === 'teacher') {
            $teacherObj = $user->teacher ?? \App\Models\Teacher::where('user_id', $user->id)->first();
            $teacherId = $teacherObj?->id;
            $teacherIds = $teacherId ? [$teacherId] : [];

            if (empty($teacherIds)) {
                return false;
            }

            $assignedSecIds = Section::whereIn('teacher_id', $teacherIds)->pluck('id')->toArray();
            $ttSecIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('section_id')->toArray();
            $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $csClassIds = DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $secClassIds = Section::whereIn('id', array_merge($assignedSecIds, $ttSecIds))->pluck('class_id')->toArray();

            $allAssignedSecIds = array_unique(array_merge($assignedSecIds, $ttSecIds));
            $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));

            return in_array($student->class_id, $allAssignedClassIds) || in_array($student->section_id, $allAssignedSecIds);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }

    public function update(User $user, Student $student): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }

    public function delete(User $user, Student $student): bool
    {
        return in_array($user->role_name, ['super_admin', 'school_admin']);
    }
}
