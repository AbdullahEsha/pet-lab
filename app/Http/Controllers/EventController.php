<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Attributes
// - id: int
// - title: string
// - description: string
// - image: string
// - expires at: date
// - fees: double

class EventController extends Controller
{
    // Get all events
    public function getAllEvents()
    {
        $events = Event::all();
        $eventsCount = $events->count();

        return response()->json([
            'message' => 'Events retrieved successfully',
            'eventsCount' => $eventsCount,
            'events' => $events
        ]);
    }

    // Get event by id
    public function getEventById($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Event retrieved successfully',
            'event' => $event
        ]);
    }

    // Create event
    public function createEvent(Request $request)
    {
        // If image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/event'), $imageName);
            $request->image = 'images/event/' . $imageName;
        }

        $event = Event::create($request->all());

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event
        ]);
    }

    // Update event
    public function updateEvent(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        // If image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/event'), $imageName);
            $request->image = 'images/event/' . $imageName;
        }

        $event->fill($request->all());
        $event->save();

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }

    // Delete event
    public function deleteEvent($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    }
}
