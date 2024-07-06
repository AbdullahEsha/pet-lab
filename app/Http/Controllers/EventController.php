<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class EventController extends Controller
{
    // Get all events
    public function getAllEvents()
    {
        $events = Event::all();
        $eventsCount = $events->count();

        // decode birdData json field
        foreach ($events as $event) {
            $event->birdData = json_decode($event->birdData);
        }

        // If perams count=true then return only count of events
        if (request()->count) {
            return response()->json([
                'message' => 'Events count retrieved successfully',
                'eventsCount' => $eventsCount
            ]);
        }

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

        // decode birdData json field
        $event->birdData = json_decode($event->birdData);

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
        $createEvent = $request->all();
        // If image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/event'), $imageName);
            $createEvent['image'] = 'images/event/' . $imageName;
        }

        // birdData is json field
        $createEvent['birdData'] = json_encode($createEvent['birdData']);

        $event = Event::create($createEvent);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event,
        ]);
    }

    // Update event
    public function updateEvent(Request $request, $id)
    {
        $updateEvent = $request->all();
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }

        // If image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/event'), $imageName);
            $updateEvent['image'] = 'images/event/' . $imageName;
        }

        // birdData is json field
        if(isset($updateEvent['birdData'])) {
            $updateEvent['birdData'] = json_encode($updateEvent['birdData']);
        }

        $event->fill($updateEvent);
        $event->save();

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event,
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
