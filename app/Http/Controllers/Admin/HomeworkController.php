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
        $schoolId = auth()->user()->school_id ?? 1;
        $homeworkList = Homework::with(['schoolClass', 'section', 'subject', 'teacher'])->where('school_id', $schoolId)->latest()->get();
        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $teachers = Teacher::where('school_id', $schoolId)->get();

        return view('admin.homework.index', compact('homeworkList', 'classes', 'sections', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
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
