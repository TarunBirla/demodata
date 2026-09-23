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

        return view('admin.settings.index', compact('school', 'roles', 'permissions'));
    }
}
