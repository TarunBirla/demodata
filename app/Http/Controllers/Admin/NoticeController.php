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

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'audience' => 'required|string',
            'publish_date' => 'required|date',
        ]);

        Notice::create(array_merge($validated, [
            'school_id' => $schoolId,
            'status' => 'active',
        ]));

        return redirect()->route('admin.notices.index')->with('success', 'Notice published successfully!');
    }

    public function update(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $notice = Notice::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'audience' => 'required|string',
            'publish_date' => 'required|date',
        ]);

        $notice->update($validated);

        return redirect()->route('admin.notices.index')->with('success', 'Notice updated successfully!');
    }

    public function destroy($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $notice = Notice::where('school_id', $schoolId)->findOrFail($id);
        $notice->delete();

        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted successfully.');
    }

    public function storeEvent(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        Event::create(array_merge($validated, [
            'school_id' => $schoolId,
            'status' => 'active',
        ]));

        return redirect()->route('admin.notices.index')->with('success', 'School Event scheduled successfully!');
    }

    public function updateEvent(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $event = Event::where('school_id', $schoolId)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
        ]);

        $event->update($validated);

        return redirect()->route('admin.notices.index')->with('success', 'School Event updated successfully!');
    }

    public function destroyEvent($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $event = Event::where('school_id', $schoolId)->findOrFail($id);
        $event->delete();

        return redirect()->route('admin.notices.index')->with('success', 'School Event deleted successfully.');
    }
}
