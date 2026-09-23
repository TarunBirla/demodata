<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\MarkEntry;
use App\Models\Student;

class ExamController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $exams = Exam::with('examSubjects.subject')->where('school_id', $schoolId)->get();
        return view('admin.exams.index', compact('exams'));
    }
}
