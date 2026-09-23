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
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $query = Student::with(['schoolClass', 'section', 'academicYear'])->where('school_id', $schoolId);

        if ($user->role_name === 'teacher') {
            $teacherIds = array_filter([$user->id, $user->teacher?->id]);
            $assignedSecIds = Section::whereIn('teacher_id', $teacherIds)->pluck('id')->toArray();
            $ttSecIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('section_id')->toArray();
            $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $csClassIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $secClassIds = Section::whereIn('id', array_merge($assignedSecIds, $ttSecIds))->pluck('class_id')->toArray();

            $allAssignedSecIds = array_unique(array_merge($assignedSecIds, $ttSecIds));
            $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));

            $query->where(function($q) use ($allAssignedClassIds, $allAssignedSecIds) {
                $q->whereIn('class_id', $allAssignedClassIds)
                  ->orWhereIn('section_id', $allAssignedSecIds);
            });

            $classes = SchoolClass::where('school_id', $schoolId)->whereIn('id', $allAssignedClassIds)->get();
            $sections = Section::where('school_id', $schoolId)->whereIn('id', $allAssignedSecIds)->get();
        } elseif ($user->role_name === 'student') {
            $query->where('user_id', $user->id);
            $classes = SchoolClass::where('school_id', $schoolId)->get();
            $sections = Section::where('school_id', $schoolId)->get();
        } elseif ($user->role_name === 'parent') {
            $parentProfile = $user->parentProfile;
            $studentIds = $parentProfile ? $parentProfile->students()->pluck('students.id')->toArray() : [];
            $linkedStudentParentId = Student::where('parent_id', $user->id)->pluck('id')->toArray();
            $allStudentIds = array_unique(array_merge($studentIds, $linkedStudentParentId));

            if (!empty($allStudentIds)) {
                $query->whereIn('id', $allStudentIds);
            } else {
                $query->whereRaw('1 = 0');
            }
            $classes = SchoolClass::where('school_id', $schoolId)->get();
            $sections = Section::where('school_id', $schoolId)->get();
        } else {
            $classes = SchoolClass::where('school_id', $schoolId)->get();
            $sections = Section::where('school_id', $schoolId)->get();
        }

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
            'password' => 'nullable|string|min:6',
        ]);

        $userId = null;
        if (!empty($validated['email'])) {
            $user = \App\Models\User::create([
                'school_id' => $schoolId,
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($request->password ?: 'password123'),
                'role_name' => 'student',
                'phone' => $validated['phone'] ?? null,
                'status' => 'active',
            ]);
            $userId = $user->id;
        }

        $admissionNo = 'GVIS-' . date('Y') . '-' . rand(1000, 9999);

        Student::create(array_merge($validated, [
            'school_id' => $schoolId,
            'user_id' => $userId,
            'admission_number' => $admissionNo,
            'status' => 'active',
        ]));

        return redirect()->route('admin.students.index')->with('success', 'Student profile added successfully! Admission No: ' . $admissionNo . ($userId ? ' | Portal Login Password: ' . ($request->password ?: 'password123') : ''));
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
        $user = auth()->user();
        
        $query = Student::with(['schoolClass', 'section', 'academicYear', 'parents', 'attendances', 'fees.feeStructure', 'markEntries.examSubject.subject']);
        
        if ($user->role_name !== 'super_admin') {
            $query->where('school_id', $user->school_id);
        }

        $student = $query->findOrFail($id);

        if ($user->role_name === 'student' && $student->user_id !== $user->id) {
            return redirect()->route('admin.dashboard')->with('error', 'Access Restricted: You can only view your own student profile.');
        }

        if ($user->role_name === 'parent') {
            $parentProfile = $user->parentProfile;
            $parentStudentIds = $parentProfile ? $parentProfile->students()->pluck('students.id')->toArray() : [];
            if (!in_array($student->id, $parentStudentIds) && $student->parent_id !== $user->id) {
                return redirect()->route('admin.dashboard')->with('error', 'Access Restricted: You can only view profiles of your linked children.');
            }
        }

        return view('admin.students.show', compact('student'));
    }
}
