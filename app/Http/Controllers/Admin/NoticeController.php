<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Event;

class NoticeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $notices = Notice::where('school_id', $schoolId)->latest()->get();
        $events = Event::where('school_id', $schoolId)->latest()->get();

        return view('admin.notices.index', compact('notices', 'events'));
    }
}
