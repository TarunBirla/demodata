<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\AcademicYear;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        if ($user->role_name === 'teacher') {
            $teacherObj = $user->teacher ?? \App\Models\Teacher::where('user_id', $user->id)->first();
            $teacherId = $teacherObj?->id;
            $teacherIds = $teacherId ? [$teacherId] : [];

            if (!empty($teacherIds)) {
                $assignedSecIds = Section::whereIn('teacher_id', $teacherIds)->pluck('id')->toArray();
                $ttSecIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('section_id')->toArray();
                $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
                $csClassIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
                $secClassIds = Section::whereIn('id', array_merge($assignedSecIds, $ttSecIds))->pluck('class_id')->toArray();

                $allAssignedSecIds = array_unique(array_merge($assignedSecIds, $ttSecIds));
                $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));
            } else {
                $allAssignedSecIds = [];
                $allAssignedClassIds = [];
            }

            if (!empty($allAssignedClassIds)) {
                $classes = SchoolClass::where('school_id', $schoolId)->whereIn('id', $allAssignedClassIds)->get();
            } else {
                $classes = collect();
            }
        } else {
            $classes = $user->role_name === 'super_admin' ? SchoolClass::all() : SchoolClass::where('school_id', $schoolId)->get();
        }

        $classId = $request->class_id ?? ($classes->first()->id ?? null);

        if ($user->role_name === 'teacher' && isset($allAssignedSecIds)) {
            $sections = $classId ? Section::where('class_id', $classId)->whereIn('id', $allAssignedSecIds)->get() : collect();
        } else {
            $sections = $classId ? Section::where('class_id', $classId)->get() : collect();
        }

        $sectionId = $request->section_id ?? ($sections->first()->id ?? null);
        $date = $request->date ?? date('Y-m-d');

        $students = collect();
        $existingAttendance = [];

        if ($user->role_name === 'student') {
            $student = $user->student;
            if ($student) {
                $students = collect([$student]);
                $existingAttendance = StudentAttendance::where('school_id', $schoolId)
                    ->where('student_id', $student->id)
                    ->pluck('status', 'date')
                    ->toArray();
            }
        } elseif ($user->role_name === 'parent') {
            $parentProfile = $user->parentProfile;
            $studentIds = $parentProfile ? $parentProfile->students()->pluck('students.id')->toArray() : [];
            $linkedStudentParentId = Student::where('parent_id', $user->id)->pluck('id')->toArray();
            $allStudentIds = array_unique(array_merge($studentIds, $linkedStudentParentId));

            if (!empty($allStudentIds)) {
                $students = Student::whereIn('id', $allStudentIds)->get();
                $existingAttendance = StudentAttendance::where('school_id', $schoolId)
                    ->whereIn('student_id', $allStudentIds)
                    ->pluck('status', 'date')
                    ->toArray();
            }
        } elseif ($classId && $sectionId) {
            $students = Student::where('school_id', $schoolId)->where('class_id', $classId)->where('section_id', $sectionId)->get();
            $existingAttendance = StudentAttendance::where('school_id', $schoolId)
                ->where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->where('date', $date)
                ->pluck('status', 'student_id')
                ->toArray();
        }

        return view('admin.attendance.index', compact('classes', 'sections', 'students', 'classId', 'sectionId', 'date', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $academicYear = AcademicYear::where('school_id', $schoolId)->where('is_current', true)->first();

        $validated = $request->validate([
            'class_id' => 'required',
            'section_id' => 'required',
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        $user = auth()->user();
        if ($user->role_name === 'teacher') {
            $teacherIds = array_filter([$user->id, $user->teacher?->id]);
            $assignedSecIds = Section::whereIn('teacher_id', $teacherIds)->pluck('id')->toArray();
            $ttSecIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('section_id')->toArray();
            $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $csClassIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $secClassIds = Section::whereIn('id', array_merge($assignedSecIds, $ttSecIds))->pluck('class_id')->toArray();

            $allAssignedSecIds = array_unique(array_merge($assignedSecIds, $ttSecIds));
            $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));

            if (!in_array($validated['class_id'], $allAssignedClassIds) && !in_array($validated['section_id'], $allAssignedSecIds)) {
                return back()->with('error', 'Access Restricted: You are not authorized to mark attendance for unassigned classes.');
            }
        }

        foreach ($validated['attendance'] as $studentId => $status) {
            StudentAttendance::updateOrCreate(
                [
                    'school_id' => $schoolId,
                    'student_id' => $studentId,
                    'date' => $validated['date'],
                ],
                [
                    'academic_year_id' => $academicYear->id ?? 1,
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'status' => $status,
                ]
            );
        }

        return back()->with('success', 'Attendance recorded successfully for ' . $validated['date']);
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $attendance = StudentAttendance::where('school_id', $schoolId)->findOrFail($id);
        $attendance->delete();

        return back()->with('success', 'Attendance record deleted successfully.');
    }
}
