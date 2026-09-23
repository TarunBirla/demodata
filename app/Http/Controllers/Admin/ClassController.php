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
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        if ($user->role_name === 'teacher') {
            $teacherIds = array_filter([$user->id, $user->teacher?->id]);
            $assignedSecIds = Section::whereIn('teacher_id', $teacherIds)->pluck('id')->toArray();
            $ttSecIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('section_id')->toArray();
            $ttClassIds = \App\Models\Timetable::whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $csClassIds = \Illuminate\Support\Facades\DB::table('class_subject')->whereIn('teacher_id', $teacherIds)->pluck('class_id')->toArray();
            $secClassIds = Section::whereIn('id', array_merge($assignedSecIds, $ttSecIds))->pluck('class_id')->toArray();

            $allAssignedSecIds = array_unique(array_merge($assignedSecIds, $ttSecIds));
            $allAssignedClassIds = array_unique(array_merge($ttClassIds, $csClassIds, $secClassIds));

            $classes = SchoolClass::with(['sections' => function($q) use ($allAssignedSecIds) {
                if (!empty($allAssignedSecIds)) {
                    $q->whereIn('id', $allAssignedSecIds);
                }
            }])
            ->where('school_id', $schoolId)
            ->whereIn('id', $allAssignedClassIds)
            ->orderBy('display_order')
            ->get();
        } else {
            $classes = SchoolClass::with('sections')->where('school_id', $schoolId)->orderBy('display_order')->get();
        }

        return view('admin.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
        ]);

        SchoolClass::create([
            'school_id' => $schoolId,
            'name' => $validated['name'],
            'display_order' => $validated['display_order'] ?? 0,
            'status' => 'active',
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'New Academic Class added successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $class = SchoolClass::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
            'status' => 'required|string',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $class = SchoolClass::where('school_id', $schoolId)->findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }

    public function storeSection(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Section::create([
            'school_id' => $schoolId,
            'class_id' => $validated['class_id'],
            'name' => $validated['name'],
            'capacity' => $validated['capacity'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'New Section added to class successfully!');
    }

    public function updateSection(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $section = Section::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $section->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Section details updated successfully!');
    }

    public function destroySection($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $section = Section::where('school_id', $schoolId)->findOrFail($id);
        $section->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Section deleted successfully.');
    }
}
