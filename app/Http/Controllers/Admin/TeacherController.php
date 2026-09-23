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
            'password' => 'nullable|string|min:6',
        ]);

        $user = \App\Models\User::create([
            'school_id' => $schoolId,
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($request->password ?: 'password123'),
            'role_name' => 'teacher',
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);

        $empId = 'EMP-' . rand(1000, 9999);

        Teacher::create([
            'school_id' => $schoolId,
            'user_id' => $user->id,
            'employee_id' => $empId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'designation' => $validated['designation'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile and portal User login created successfully! Password: ' . ($request->password ?: 'password123'));
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
