<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $staffList = Staff::with('user')->where('school_id', $schoolId)->latest()->get();

        return view('admin.staff.index', compact('staffList'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        $user = \App\Models\User::create([
            'school_id' => $schoolId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role_name' => 'hr_manager',
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);

        $empId = 'EMP-HR-' . rand(1000, 9999);

        Staff::create(array_merge($validated, [
            'school_id' => $schoolId,
            'user_id' => $user->id,
            'employee_id' => $empId,
            'joining_date' => date('Y-m-d'),
            'status' => 'active',
        ]));

        return back()->with('success', 'Staff member profile created successfully!');
    }
}
