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
        $teachers = Teacher::where('school_id', $schoolId)->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }
}
