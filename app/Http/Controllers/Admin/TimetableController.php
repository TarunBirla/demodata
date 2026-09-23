<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\SchoolClass;
use App\Models\Section;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\AcademicYear;

class TimetableController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $sections = Section::where('school_id', $schoolId)->get();
        $subjects = Subject::where('school_id', $schoolId)->get();
        $teachers = Teacher::where('school_id', $schoolId)->get();

        $query = Timetable::with(['schoolClass', 'section', 'subject', 'teacher'])->where('school_id', $schoolId);

        if ($user->role_name === 'teacher') {
            $teacherIds = array_filter([$user->id, $user->teacher?->id]);
            $query->whereIn('teacher_id', $teacherIds);
        }

        $timetables = $query->get();

        return view('admin.timetable.index', compact('classes', 'sections', 'subjects', 'teachers', 'timetables'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $acadYear = AcademicYear::where('school_id', $schoolId)->first();

        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required',
            'day' => 'required|string',
            'period_number' => 'required|integer|min:1|max:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'room_number' => 'nullable|string|max:50',
        ]);

        Timetable::create(array_merge($validated, [
            'school_id' => $schoolId,
            'academic_year_id' => $acadYear->id ?? 1,
        ]));

        return redirect()->route('admin.timetable.index')->with('success', 'Timetable slot created successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $slot = Timetable::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required',
            'day' => 'required|string',
            'period_number' => 'required|integer|min:1|max:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'room_number' => 'nullable|string|max:50',
        ]);

        $slot->update($validated);

        return redirect()->route('admin.timetable.index')->with('success', 'Timetable slot updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $slot = Timetable::where('school_id', $schoolId)->findOrFail($id);
        $slot->delete();

        return redirect()->route('admin.timetable.index')->with('success', 'Timetable slot removed successfully.');
    }
}
