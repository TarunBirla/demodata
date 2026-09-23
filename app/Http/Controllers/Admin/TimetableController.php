<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\SchoolClass;
use App\Models\Section;

class TimetableController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $timetables = Timetable::with(['schoolClass', 'section', 'subject', 'teacher'])->where('school_id', $schoolId)->get();

        return view('admin.timetable.index', compact('classes', 'timetables'));
    }
}
