<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Section;

class ClassController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $classes = SchoolClass::with('sections')->where('school_id', $schoolId)->get();
        return view('admin.classes.index', compact('classes'));
    }
}
