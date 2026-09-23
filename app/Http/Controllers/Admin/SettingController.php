<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\SchoolSetting;
use App\Models\Role;
use App\Models\Permission;

class SettingController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $school = School::with('settings')->find($schoolId);
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('group');
        $users = \App\Models\User::where('school_id', $schoolId)->orWhereNull('school_id')->latest()->get();

        return view('admin.settings.index', compact('school', 'roles', 'permissions', 'users'));
    }

    public function updateSettings(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $school = School::find($schoolId);

        if ($school) {
            $school->update([
                'name' => $request->school_name ?? $school->name,
                'phone' => $request->school_phone ?? $school->phone,
                'email' => $request->school_email ?? $school->email,
            ]);
        }

        $settings = $request->only(['currency_symbol', 'receipt_prefix']);
        foreach ($settings as $key => $val) {
            if ($val !== null) {
                SchoolSetting::updateOrCreate(
                    ['school_id' => $schoolId, 'key' => $key],
                    ['value' => $val, 'group' => 'general']
                );
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'School profile & system settings saved successfully!');
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'description' => 'nullable|string',
        ]);

        Role::create($validated);

        return redirect()->route('admin.settings.index')->with('success', 'New User Role created successfully!');
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role->update($validated);

        return redirect()->route('admin.settings.index')->with('success', 'User Role updated successfully!');
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        if (in_array($role->slug, ['super_admin', 'school_admin'])) {
            return redirect()->route('admin.settings.index')->with('error', 'System default roles cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.settings.index')->with('success', 'User Role deleted successfully.');
    }

    public function storeUserAccount(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role_name' => 'required|string',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
        ]);

        \App\Models\User::create([
            'school_id' => $schoolId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_name' => $validated['role_name'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'User account for ' . ucfirst(str_replace('_', ' ', $validated['role_name'])) . ' created successfully! They can now log in with email: ' . $validated['email']);
    }
}
