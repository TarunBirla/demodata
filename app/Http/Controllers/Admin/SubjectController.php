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
        $subjects = Subject::where('school_id', $schoolId)->latest()->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'type' => 'required|string|in:theory,practical,elective',
        ]);

        Subject::create([
            'school_id' => $schoolId,
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'type' => $validated['type'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject added successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $subject = Subject::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'type' => 'required|string|in:theory,practical,elective',
            'status' => 'required|string',
        ]);

        $subject->update(array_merge($validated, ['code' => strtoupper($validated['code'])]));

        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $subject = Subject::where('school_id', $schoolId)->findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
