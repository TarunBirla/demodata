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

    public function updateStatus(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $admission = OnlineAdmission::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $admission->update(['status' => $validated['status']]);

        return redirect()->route('admin.admissions.index')->with('success', 'Admission application status updated to: ' . strtoupper($validated['status']));
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $admission = OnlineAdmission::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:50',
            'grade_applying' => 'required|string|max:50',
            'status' => 'required|string',
        ]);

        $admission->update($validated);

        return redirect()->route('admin.admissions.index')->with('success', 'Admission application updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $admission = OnlineAdmission::where('school_id', $schoolId)->findOrFail($id);
        $admission->delete();

        return redirect()->route('admin.admissions.index')->with('success', 'Admission application deleted successfully.');
    }

    public function destroyEnquiry($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $enquiry = Enquiry::where('school_id', $schoolId)->findOrFail($id);
        $enquiry->delete();

        return redirect()->route('admin.admissions.index')->with('success', 'Public enquiry entry deleted successfully.');
    }
}
