<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $teachers = Teacher::where('school_id', $schoolId)->latest()->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
        ]);

        $empId = 'EMP-' . rand(1000, 9999);

        Teacher::create(array_merge($validated, [
            'school_id' => $schoolId,
            'employee_id' => $empId,
            'status' => 'active',
        ]));

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile added successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $teacher = Teacher::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $teacher = Teacher::where('school_id', $schoolId)->findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile deleted successfully.');
    }
}
