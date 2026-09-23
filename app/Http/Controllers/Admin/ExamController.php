<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\MarkEntry;
use App\Models\Student;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\ExamSubject;

class ExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $examsQuery = Exam::with(['examSubjects.subject', 'examSubjects.schoolClass', 'school'])->latest();
        if ($user->role_name !== 'super_admin') {
            $examsQuery->where('school_id', $schoolId);
        }
        $exams = $examsQuery->get();

        if ($user->role_name === 'teacher') {
            $teacherObj = $user->teacher ?? \App\Models\Teacher::where('user_id', $user->id)->first();
            $teacherId = $teacherObj?->id;
            $teacherIds = $teacherId ? [$teacherId] : [];

            if (!empty($teacherIds)) {
                $ttSubjectIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('subject_id')->toArray();
                $csSubjectIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('subject_id')->toArray();
                $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
                $csClassIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
                $secClassIds = Section::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();

                $allAssignedSubjectIds = array_unique(array_merge($ttSubjectIds, $csSubjectIds));
                $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));
            } else {
                $allAssignedSubjectIds = [];
                $allAssignedClassIds = [];
            }

            if (empty($allAssignedClassIds) && empty($allAssignedSubjectIds)) {
                $classes = collect();
                $subjects = collect();
                $students = collect();
            } else {
                $classes = SchoolClass::where('school_id', $schoolId)->whereIn('id', $allAssignedClassIds)->get();
                $subjects = Subject::where('school_id', $schoolId)->whereIn('id', $allAssignedSubjectIds)->get();
                $students = Student::where('school_id', $schoolId)->whereIn('class_id', $allAssignedClassIds)->get();
            }
        } else {
            $classes = $user->role_name === 'super_admin' ? SchoolClass::all() : SchoolClass::where('school_id', $schoolId)->get();
            $subjects = $user->role_name === 'super_admin' ? Subject::all() : Subject::where('school_id', $schoolId)->get();
            $students = $user->role_name === 'super_admin' ? Student::all() : Student::where('school_id', $schoolId)->get();
        }

        return view('admin.exams.index', compact('exams', 'classes', 'subjects', 'students'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $acadYear = AcademicYear::where('school_id', $schoolId)->first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_published' => 'nullable|boolean',
        ]);

        Exam::create([
            'school_id' => $schoolId,
            'academic_year_id' => $acadYear->id ?? 1,
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_published' => $request->has('is_published') ? (bool)$request->is_published : false,
            'status' => 'active',
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'Exam schedule created successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $exam = Exam::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_published' => 'nullable|boolean',
        ]);

        $exam->update([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_published' => $request->has('is_published') ? (bool)$request->is_published : false,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $exam = Exam::where('school_id', $schoolId)->findOrFail($id);
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Exam schedule deleted successfully.');
    }

    public function storeMarks(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'student_id' => 'required|exists:students,id',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'max_marks' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        if ($user->role_name === 'teacher') {
            $teacherIds = array_filter([$user->id, $user->teacher?->id]);
            $ttSubjectIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('subject_id')->toArray();
            $csSubjectIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('subject_id')->toArray();
            $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $csClassIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $secClassIds = Section::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();

            $allAssignedSubjectIds = array_unique(array_merge($ttSubjectIds, $csSubjectIds));
            $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));

            if (!in_array($validated['class_id'], $allAssignedClassIds) && !in_array($validated['subject_id'], $allAssignedSubjectIds)) {
                return redirect()->route('admin.exams.index')->with('error', 'Access Restricted: You are not authorized to enter marks for unassigned classes or subjects.');
            }
        }

        $examSubject = ExamSubject::firstOrCreate(
            [
                'exam_id' => $validated['exam_id'],
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
            ],
            [
                'max_marks' => $validated['max_marks'],
                'pass_marks' => 35.00,
            ]
        );

        $grade = $validated['marks_obtained'] >= 80 ? 'A+' : ($validated['marks_obtained'] >= 60 ? 'A' : ($validated['marks_obtained'] >= 35 ? 'B' : 'F'));
        $resultStatus = $validated['marks_obtained'] >= 35 ? 'pass' : 'fail';

        MarkEntry::updateOrCreate(
            [
                'exam_subject_id' => $examSubject->id,
                'student_id' => $validated['student_id'],
            ],
            [
                'marks_obtained' => $validated['marks_obtained'],
                'grade' => $grade,
                'result_status' => $resultStatus,
            ]
        );

        return redirect()->route('admin.exams.index')->with('success', 'Student marks entered successfully!');
    }

    public function destroyMarks($id)
    {
        $mark = MarkEntry::findOrFail($id);
        $mark->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Marks entry deleted successfully.');
    }
}
