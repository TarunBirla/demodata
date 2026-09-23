<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $subjects = Subject::where('school_id', $schoolId)->get();
        return view('admin.subjects.index', compact('subjects'));
    }
}
