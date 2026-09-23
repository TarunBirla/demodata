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
        $schoolId = auth()->user()->school_id ?? 1;
        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $classId = $request->class_id ?? ($classes->first()->id ?? null);
        $sections = $classId ? Section::where('class_id', $classId)->get() : collect();
        $sectionId = $request->section_id ?? ($sections->first()->id ?? null);
        $date = $request->date ?? date('Y-m-d');

        $students = collect();
        $existingAttendance = [];

        if ($classId && $sectionId) {
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
