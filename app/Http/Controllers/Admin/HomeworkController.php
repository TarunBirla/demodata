<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homework;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\AcademicYear;

class HomeworkController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $query = Homework::with(['schoolClass', 'section', 'subject', 'teacher', 'school']);
        if ($user->role_name !== 'super_admin') {
            $query->where('school_id', $schoolId);
        }

        if ($user->role_name === 'teacher') {
            $teacherIds = array_filter([$user->id, $user->teacher?->id]);
            $query->whereIn('teacher_id', $teacherIds);
        } elseif ($user->role_name === 'student') {
            $student = $user->student;
            if ($student && $student->class_id && $student->section_id) {
                $query->where('class_id', $student->class_id)
                      ->where('section_id', $student->section_id);
            } else {
                $query->whereRaw('1 = 0');
            }
        } elseif ($user->role_name === 'parent') {
            $parentProfile = $user->parentProfile;
            $studentIds = $parentProfile ? $parentProfile->students()->pluck('students.id')->toArray() : [];
            $linkedStudentParentId = \App\Models\Student::where('parent_id', $user->id)->pluck('id')->toArray();
            $allStudentIds = array_unique(array_merge($studentIds, $linkedStudentParentId));
            $students = \App\Models\Student::whereIn('id', $allStudentIds)->get(['class_id', 'section_id']);

            if ($students->isNotEmpty()) {
                $query->where(function($q) use ($students) {
                    foreach ($students as $st) {
                        $q->orWhere(function($subQ) use ($st) {
                            $subQ->where('class_id', $st->class_id)->where('section_id', $st->section_id);
                        });
                    }
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $homeworkList = $query->latest()->get();
        $classes = $user->role_name === 'super_admin' ? SchoolClass::all() : SchoolClass::where('school_id', $schoolId)->get();
        $sections = $user->role_name === 'super_admin' ? Section::all() : Section::where('school_id', $schoolId)->get();
        $subjects = $user->role_name === 'super_admin' ? Subject::all() : Subject::where('school_id', $schoolId)->get();
        $teachers = $user->role_name === 'super_admin' ? Teacher::all() : Teacher::where('school_id', $schoolId)->get();

        return view('admin.homework.index', compact('homeworkList', 'classes', 'sections', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;
        $acadYear = AcademicYear::where('school_id', $schoolId)->first();

        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:assigned_date',
        ]);

        if (empty($validated['teacher_id'])) {
            $validated['teacher_id'] = $user->id;
        }

        Homework::create(array_merge($validated, [
            'school_id' => $schoolId,
            'academic_year_id' => $acadYear->id ?? 1,
            'status' => 'active',
        ]));

        return redirect()->route('admin.homework.index')->with('success', 'Homework assignment created successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $homework = Homework::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:assigned_date',
        ]);

        $homework->update($validated);

        return redirect()->route('admin.homework.index')->with('success', 'Homework assignment updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $homework = Homework::where('school_id', $schoolId)->findOrFail($id);
        $homework->delete();

        return redirect()->route('admin.homework.index')->with('success', 'Homework assignment deleted successfully.');
    }
}
