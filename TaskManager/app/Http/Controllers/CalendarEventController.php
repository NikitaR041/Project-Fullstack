<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;

class CalendarEventController extends Controller
{
    public function index()
    {
        return CalendarEvent::with(['task', 'project'])
            ->where('user_id', Auth::id())->orderBy('event_date')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'nullable|exists:tasks,id',
            'project_id' => 'nullable|exists:projects,id',
            'event_date' => 'required|date'
        ]);

        $validated['user_id'] = Auth::id();
        $event = CalendarEvent::create($validated);

        return response()->json($event->load(['task', 'project']), 201);
    }

    public function show(CalendarEvent $calendarEvent)
    {
        return $calendarEvent->load(['task', 'project']);
    }

    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        $validated = $request->validate([
            'task_id' => 'nullable|exists:tasks,id',
            'project_id' => 'nullable|exists:projects,id',
            'event_date' => 'sometimes|date'
        ]);

        $calendarEvent->update($validated);
        return response()->json($calendarEvent->load(['task', 'project']));
    }

    public function destroy(CalendarEvent $calendarEvent)
    {
        $calendarEvent->delete();
        return response()->noContent();
    }
}
