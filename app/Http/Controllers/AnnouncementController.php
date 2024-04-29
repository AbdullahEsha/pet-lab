<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // get all announcements
    public function getAllAnnouncements()
    {
        $announcements = Announcement::all();
        $announcementsCount = $announcements->count();
        
        return response()->json([
            'message' => 'Announcements retrieved successfully',
            'count' => $announcementsCount,
            'announcements' => $announcements
        ]);
    }

    // get announcement by id
    public function getAnnouncementById($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'message' => 'Announcement not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Announcement retrieved successfully',
            'announcement' => $announcement
        ]);
    }

    // create announcement
    public function createAnnouncement(Request $request)
    {
        $announcement = Announcement::create($request->all());

        return response()->json([
            'message' => 'Announcement created successfully',
            'announcement' => $announcement
        ]);
    }

    // update announcement
    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'message' => 'Announcement not found'
            ], 404);
        }

        // only update the fields that are present in the request body and ignore the rest
        $announcement->fill($request->all());
        $announcement->save();

        return response()->json([
            'message' => 'Announcement updated successfully',
            'announcement' => $announcement
        ]);
    }

    // delete announcement
    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'message' => 'Announcement not found'
            ], 404);
        }

        $announcement->delete();

        return response()->json([
            'message' => 'Announcement deleted successfully'
        ]);
    }
}
