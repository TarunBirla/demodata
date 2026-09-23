<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\AcademicYear;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $query = Student::with(['schoolClass', 'section', 'academicYear'])->where('school_id', $schoolId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->paginate(15);
        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();

        return view('admin.students.index', compact('students', 'classes', 'sections'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
        $academicYears = AcademicYear::where('school_id', $schoolId)->get();

        return view('admin.students.create', compact('classes', 'sections', 'academicYears'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $admissionNo = 'GVIS-' . date('Y') . '-' . rand(1000, 9999);

        Student::create(array_merge($validated, [
            'school_id' => $schoolId,
            'admission_number' => $admissionNo,
            'status' => 'active',
        ]));

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully with Admission No: ' . $admissionNo);
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $student = Student::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'required|string',
        ]);

        $student->update($validated);

        return redirect()->route('admin.students.index')->with('success', 'Student profile updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $student = Student::where('school_id', $schoolId)->findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student record deleted successfully.');
    }

    public function show($id)
    {
        $student = Student::with(['schoolClass', 'section', 'academicYear', 'parents', 'attendances', 'fees.feeStructure', 'markEntries.examSubject.subject'])->findOrFail($id);
        return view('admin.students.show', compact('student'));
    }
}
