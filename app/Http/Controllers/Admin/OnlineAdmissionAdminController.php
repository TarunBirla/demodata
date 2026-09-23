<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnlineAdmission;
use App\Models\Enquiry;

class OnlineAdmissionAdminController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $admissions = OnlineAdmission::where('school_id', $schoolId)->latest()->get();
        $enquiries = Enquiry::where('school_id', $schoolId)->latest()->get();

        return view('admin.admissions.index', compact('admissions', 'enquiries'));
    }
}
