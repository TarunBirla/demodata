<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homework;

class HomeworkController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $homeworkList = Homework::with(['schoolClass', 'section', 'subject', 'teacher'])->where('school_id', $schoolId)->latest()->get();

        return view('admin.homework.index', compact('homeworkList'));
    }
}
